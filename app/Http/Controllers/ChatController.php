<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\Message;
use App\Models\Listing;

class ChatController extends Controller
{
    public function index()
    {
        $chats = Chat::where('buyer_id', auth()->id())
            ->orWhere('seller_id', auth()->id())
            ->with(['listing', 'buyer', 'seller', 'latestMessage'])
            ->orderBy('last_message_at', 'desc')
            ->get();

        return view('messages.index', compact('chats'));
    }

    public function show(Chat $chat)
    {
        // Check if user is part of this chat
        if ($chat->buyer_id !== auth()->id() && $chat->seller_id !== auth()->id()) {
            abort(403);
        }

        $messages = $chat->messages()
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark messages as read
        $chat->markAsReadBy(auth()->id());

        return view('messages.show', compact('chat', 'messages'));
    }

    public function store(Request $request, Chat $chat)
    {
        // Check if user is part of this chat
        if ($chat->buyer_id !== auth()->id() && $chat->seller_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $message = Message::create([
            'chat_id' => $chat->id,
            'sender_id' => auth()->id(),
            'message' => $request->message,
            'type' => 'text',
        ]);

        // Update chat last message time
        $chat->update([
            'last_message_at' => now(),
            'is_read_by_buyer' => $chat->buyer_id === auth()->id(),
            'is_read_by_seller' => $chat->seller_id === auth()->id(),
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message->load('sender')
            ]);
        }

        return back();
    }

    public function create(Request $request, Listing $listing)
    {
        // Check if user is not the owner of the listing
        if ($listing->user_id === auth()->id()) {
            return back()->with('error', 'You cannot message yourself!');
        }

        // Find or create chat
        $chat = Chat::firstOrCreate([
            'listing_id' => $listing->id,
            'buyer_id' => auth()->id(),
            'seller_id' => $listing->user_id,
        ]);

        return redirect()->route('messages.show', $chat);
    }
}