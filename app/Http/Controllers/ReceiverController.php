<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Receiver;
use Illuminate\Support\Facades\Mail;

class ReceiverController extends Controller
{
    public function index(Request $request)
    {
        $query = Receiver::query();

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('sender_name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('message', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('status')) {
            $query->where('is_read', $request->status === 'read' ? 1 : 0);
        }

        $receivers = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('home', compact('receivers'));
    }

    public function create()
    {
        return view('receiver.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sender_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'priority' => 'required|in:low,medium,high',
            'message' => 'required|string',
        ]);

        Receiver::create($validated);

        return redirect()->route('home')->with('success', 'Message created successfully.');
    }

    public function show($id)
    {
        $receiver = Receiver::findOrFail($id);
        return view('receiver.show', compact('receiver'));
    }

    public function edit($id)
    {
        $receiver = Receiver::findOrFail($id);
        return view('receiver.edit', compact('receiver'));
    }

    public function update(Request $request, $id)
    {
        $receiver = Receiver::findOrFail($id);

        $validated = $request->validate([
            'sender_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'priority' => 'required|in:low,medium,high',
            'message' => 'required|string',
        ]);

        $receiver->update($validated);

        return redirect()->route('home')->with('success', 'Message updated successfully.');
    }

    public function destroy($id)
    {
        $receiver = Receiver::findOrFail($id);
        $receiver->delete();

        return redirect()->route('home')->with('success', 'Message deleted successfully.');
    }

    public function markAsRead($id)
    {
        $receiver = Receiver::findOrFail($id);
        $receiver->update(['is_read' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Message marked as read successfully.'
        ]);
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:receivers,id'
        ]);

        Receiver::whereIn('id', $request->ids)->delete();

        return redirect()->route('home')->with('success', 'Selected messages deleted successfully.');
    }

    public function sendReply(Request $request, $id)
    {
        $receiver = Receiver::findOrFail($id);

        $request->validate([
            'reply_message' => 'required|string'
        ]);

        $replyMessage = $request->reply_message;

        Mail::raw($replyMessage, function ($message) use ($receiver) {
            $message->to($receiver->email)
                    ->subject('Reply to your inquiry');
        });

        return redirect()->back()->with('success', 'Reply sent successfully.');
    }

    public function getAnalyticsData()
    {
        $total = Receiver::count();
        $read = Receiver::where('is_read', 1)->count();
        $unread = Receiver::where('is_read', 0)->count();

        $high = Receiver::where('priority', 'high')->count();
        $medium = Receiver::where('priority', 'medium')->count();
        $low = Receiver::where('priority', 'low')->count();

        return response()->json([
            'status' => [
                'labels' => ['Read', 'Unread'],
                'data' => [$read, $unread]
            ],
            'priority' => [
                'labels' => ['High', 'Medium', 'Low'],
                'data' => [$high, $medium, $low]
            ]
        ]);
    }
}