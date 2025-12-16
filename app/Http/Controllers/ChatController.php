<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // Inbox: list users you have chatted with
    public function inbox()
    {
        $currentId = Auth::id();

        $allChats = Chat::with(['sender', 'receiver', 'item'])
            ->where(function ($q) use ($currentId) {
                $q->where('chat_by_id', $currentId)
                  ->orWhere('chat_for_id', $currentId);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Group by "other user"
        $threads = $allChats->groupBy(function (Chat $chat) use ($currentId) {
            return $chat->chat_by_id == $currentId
                ? $chat->chat_for_id
                : $chat->chat_by_id;
        });

        return view('auth.inboxpage', [
            'threads'   => $threads,
            'currentId' => $currentId,
        ]);
    }

    // Open chat for a specific item & other user
    // Route: GET /chat/{user}?item=10
    public function show(Request $request, User $user)
    {
        $current = Auth::user();

        if ($user->id === $current->id) {
            abort(403, 'You cannot chat with yourself.');
        }

        $itemId = $request->query('item');
        if (!$itemId) {
            abort(404, 'Item ID is required.');
        }

        $item = Item::findOrFail($itemId);

        $messages = Chat::with(['sender', 'receiver'])
            ->where('item_id', $item->id)
            ->where(function ($q) use ($current, $user) {
                $q->where(function ($q2) use ($current, $user) {
                    $q2->where('chat_by_id', $current->id)
                       ->where('chat_for_id', $user->id);
                })->orWhere(function ($q2) use ($current, $user) {
                    $q2->where('chat_by_id', $user->id)
                       ->where('chat_for_id', $current->id);
                });
            })
            ->orderBy('created_at')
            ->get();

        return view('auth.chatpage', [
            'item'      => $item,
            'otherUser' => $user,
            'messages'  => $messages,
        ]);
    }

    // Send a new message
    // Route: POST /chat/{user}?item=10
    public function send(Request $request, User $user)
    {
        $current = Auth::user();

        if ($user->id === $current->id) {
            abort(403, 'You cannot chat with yourself.');
        }

        $itemId = $request->query('item');
        if (!$itemId) {
            abort(404, 'Item ID is required.');
        }

        $item = Item::findOrFail($itemId);

        $request->validate([
            'chat_message' => 'required|string|max:255',
        ]);

        Chat::create([
            'item_id'      => $item->id,
            'chat_by_id'   => $current->id,
            'chat_for_id'  => $user->id,
            'chat_message' => $request->chat_message,
        ]);

        // Stay on same chat
        return redirect()->route('chatpage', [
            'user' => $user->id,
            'item' => $item->id, // becomes ?item=...
        ]);
    }
}
