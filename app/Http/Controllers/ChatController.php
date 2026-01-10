<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // Inbox
    public function inbox()
    {
        $currentId = Auth::id();

        $allChats = Chat::with(['sender', 'receiver', 'item'])
            ->where('chat_by_id', $currentId)
            ->orWhere('chat_for_id', $currentId)
            ->latest()
            ->get();

        $threads = $allChats->groupBy(function ($chat) use ($currentId) {
            return $chat->chat_by_id === $currentId
                ? $chat->chat_for_id
                : $chat->chat_by_id;
        });

        return view('auth.inboxpage', compact('threads', 'currentId'));
    }

    // Show chat page
    public function show(User $user, Item $item)
    {
        $current = Auth::user();

        if ($user->id === $current->id) {
            abort(403);
        }

        $messages = Chat::where('item_id', $item->id)
            ->where(function ($q) use ($current, $user) {
                $q->where([
                    ['chat_by_id', $current->id],
                    ['chat_for_id', $user->id],
                ])->orWhere([
                    ['chat_by_id', $user->id],
                    ['chat_for_id', $current->id],
                ]);
            })
            ->orderBy('created_at')
            ->get();

        return view('auth.chatpage', [
            'item'      => $item,
            'otherUser' => $user,
            'messages'  => $messages,
        ]);
    }

    // Send message
    public function send(Request $request, User $user, Item $item)
    {
        $current = Auth::user();

        if ($user->id === $current->id) {
            abort(403);
        }

        $request->validate([
            'chat_message' => 'required|string|max:255',
        ]);

        Chat::create([
            'item_id'      => $item->id,   // ✅ GUARANTEED
            'chat_by_id'   => $current->id,
            'chat_for_id'  => $user->id,
            'chat_message' => $request->chat_message,
        ]);

        return redirect()->route('chatpage', [
            'user' => $user->id,
            'item' => $item->id,
        ]);
    }
}
