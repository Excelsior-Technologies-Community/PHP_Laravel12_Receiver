<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Receiver;

class ReceiverController extends Controller
{
    public function index(Request $request)
    {
        $query = Receiver::latest();

        // Search functionality
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('sender_name', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('message', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('email', 'LIKE', '%' . $request->search . '%');
            });
        }

        // Filter by priority
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // Filter by read status
        if ($request->filled('status')) {
            if ($request->status === 'read') {
                $query->where('is_read', true);
            } elseif ($request->status === 'unread') {
                $query->where('is_read', false);
            }
        }

        $receivers = $query->paginate(10);

        $totalMessages = Receiver::count();
        $todayMessages = Receiver::whereDate('created_at', today())->count();
        $unreadMessages = Receiver::where('is_read', false)->count();
        $highPriority = Receiver::where('priority', 'high')->count();

        return view('receiver.index', compact(
            'receivers',
            'totalMessages',
            'todayMessages',
            'unreadMessages',
            'highPriority'
        ));
    }

    public function create()
    {
        return view('receiver.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sender_name' => 'required|max:100',
            'email' => 'nullable|email|max:100',
            'phone' => 'nullable|max:20',
            'message' => 'required|max:1000',
            'priority' => 'in:low,medium,high',
        ]);

        Receiver::create($validated);

        return redirect('/')
            ->with('success', 'Message received successfully!');
    }

    public function show($id)
    {
        $receiver = Receiver::findOrFail($id);
        
        if (!$receiver->is_read) {
            $receiver->markAsRead();
        }

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
            'sender_name' => 'required|max:100',
            'email' => 'nullable|email|max:100',
            'phone' => 'nullable|max:20',
            'message' => 'required|max:1000',
            'priority' => 'in:low,medium,high',
        ]);

        $receiver->update($validated);

        return redirect('/')
            ->with('success', 'Message updated successfully!');
    }

    public function destroy($id)
    {
        Receiver::findOrFail($id)->delete();

        return redirect('/')
            ->with('success', 'Message deleted successfully!');
    }

    public function markAsRead($id)
    {
        $receiver = Receiver::findOrFail($id);
        $receiver->markAsRead();

        return redirect()->back()->with('success', 'Message marked as read!');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:receivers,id'
        ]);

        Receiver::whereIn('id', $request->ids)->delete();

        return redirect('/')->with('success', 'Messages deleted successfully!');
    }
}