<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChatController extends Controller
{
    public function index()
    {
        $chats = auth()
            ->user()
            ->chats()
            ->with([
                "deal:title,id",
                'users:id,name,email,phone_number',
                "messages:created_at,message,id,user_id,chat_id"
            ])->get()->sortByDesc(function ($chat) {
                return $chat->messages->last()->created_at ?? $chat->created_at;
            })
            ->values();
        ;
        return Inertia::render("Chat/Index", [
            "chats" => $chats
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            "message" => ["required", "string"],
            'receiverID' => ["required", "exists:users,id"],
            "dealId" => ["required", "exists:deals,id"]
        ]);
        $chat = Chat::create([
            'name' => $request->user()->id . "_" . $request->receiverID,
            "deal_id" => $request->dealId
        ]);

        $chat->users()->attach([$request->user()->id, $request->receiverID]);
        $chat->messages()->create(["user_id" => $request->user()->id, "message" => $request->message]);
    }

    public function show(Request $request, string $chatID)
    {
        $chat = Chat::with("messages:id,message,chat_id,user_id,created_at", "messages.user:id,name,email,phone_number", "deal")->findOrFail($chatID);
        return Inertia::render("Chat/Chat", [
            "messages" => $chat->messages,
            "chat" => $chat->only(["deal", "id", "deal_id", "name", "users"])
        ]);
    }
}

