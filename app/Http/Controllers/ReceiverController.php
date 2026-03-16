<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Receiver;

class ReceiverController extends Controller
{
    public function index()
    {
        $receivers = Receiver::latest()->get();
        return view('receiver.index', compact('receivers'));
    }

    public function create()
    {
        return view('receiver.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'sender_name' => 'required',
            'message' => 'required',
        ]);

        Receiver::create([
            'sender_name' => $request->sender_name,
            'message' => $request->message,
        ]);

        return redirect('/')->with('success', 'Message received successfully!');
    }
}