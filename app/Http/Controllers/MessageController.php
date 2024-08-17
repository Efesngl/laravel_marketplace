<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use App\Events\MessageReceived;

class MessageController extends Controller
{
    public function index($chatId)
    {
        $messages = ChatMessage::with('user')->where('chat_id', $chatId)->get();
        return response()->json($messages);
    }

    public function store(Request $request, $chatId)
    {
        $request->validate([
            'text' => 'required|string',
        ]);
        $message=ChatMessage::create([
            'chat_id' => $chatId,
            'user_id' => $request->user()->id,
            'message' => $request->text,
        ])->load("user");
        // Broadcast the message event
        broadcast(new MessageReceived($message,$chatId))->toOthers();
        return $message;
    }
}

