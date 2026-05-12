<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Receiver;

class ReceiverController extends Controller
{
    public function index(Request $request)
    {
        $query = Receiver::latest();

        // SEARCH
        if ($request->search) {
            $query->where('sender_name', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('message', 'LIKE', '%' . $request->search . '%');
        }

        $receivers = $query->get();

        $totalMessages = Receiver::count();
        $todayMessages = Receiver::whereDate('created_at', today())->count();

        return view('receiver.index', compact(
            'receivers',
            'totalMessages',
            'todayMessages'
        ));
    }

    public function create()
    {
        return view('receiver.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'sender_name' => 'required|max:100',
            'message' => 'required|max:1000',
        ]);

        Receiver::create([
            'sender_name' => $request->sender_name,
            'message' => $request->message,
        ]);

        return redirect('/')
            ->with('success', 'Message received successfully!');
    }

    public function destroy($id)
    {
        Receiver::findOrFail($id)->delete();

        return redirect('/')
            ->with('success', 'Message deleted successfully!');
    }
}