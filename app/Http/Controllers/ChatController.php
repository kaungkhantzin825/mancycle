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
        $chats = Chat::where(function($q){
                $q->where('buyer_id', auth()->id())
                  ->orWhere('seller_id', auth()->id());
            })
            ->with(['listing', 'buyer', 'seller', 'latestMessage'])
            ->orderBy('last_message_at', 'desc')
            ->get();

        // Mark all chats as read for this user to clear header badges
        $userId = auth()->id();
        Chat::where('buyer_id', $userId)->where('is_read_by_buyer', false)->update(['is_read_by_buyer' => true]);
        Chat::where('seller_id', $userId)->where('is_read_by_seller', false)->update(['is_read_by_seller' => true]);

        if ($chats->count() > 0) {
            return redirect()->route('messages.show', $chats->first());
        }

        return view('messages.index', compact('chats'));
    }

    public function show(Chat $chat)
    {
        // Check if user is part of this chat
        if ($chat->buyer_id !== auth()->id() && $chat->seller_id !== auth()->id()) {
            abort(403);
        }

        // Sidebar chat list
        $chats = Chat::where(function($q){
                $q->where('buyer_id', auth()->id())
                  ->orWhere('seller_id', auth()->id());
            })
            ->with(['listing', 'buyer', 'seller', 'latestMessage'])
            ->orderBy('last_message_at', 'desc')
            ->get();

        $messages = $chat->messages()
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark this chat as read
        $chat->markAsReadBy(auth()->id());
        // Also clear unread flag on all chats for this user to close the badge immediately
        $userId = auth()->id();
        Chat::where('buyer_id', $userId)->where('is_read_by_buyer', false)->update(['is_read_by_buyer' => true]);
        Chat::where('seller_id', $userId)->where('is_read_by_seller', false)->update(['is_read_by_seller' => true]);

        return view('messages.show', compact('chat', 'messages', 'chats'));
    }

    public function store(Request $request, Chat $chat)
    {
        // Check if user is part of this chat
        if ($chat->buyer_id !== auth()->id() && $chat->seller_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'message' => 'nullable|string|max:1000',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,webp,gif,svg,mp3,wav,ogg,m4a,webm|max:12288',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,webp,gif,svg,mp3,wav,ogg,m4a,webm|max:12288' // up to 12MB per file
        ]);

        if (!$request->filled('message') && !$request->hasFile('attachments') && !$request->hasFile('attachment')) {
            return back()->with('error', 'Please type a message or attach a file.');
        }

        $attachmentsMeta = [];
        $attachmentCategories = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                if (!$file) continue;
                $path = $file->store('chat_attachments', 'public');
                $mime = $file->getMimeType();
                $cat = str_starts_with($mime, 'image/') ? 'image' : (str_starts_with($mime, 'audio/') ? 'audio' : 'file');
                $attachmentsMeta[] = [
                    'path' => $path,
                    'mime' => $mime,
                    'original' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'category' => $cat,
                ];
                $attachmentCategories[] = $cat;
            }
        } elseif ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $path = $file->store('chat_attachments', 'public');
            $mime = $file->getMimeType();
            $cat = str_starts_with($mime, 'image/') ? 'image' : (str_starts_with($mime, 'audio/') ? 'audio' : 'file');
            $attachmentsMeta[] = [
                'path' => $path,
                'mime' => $mime,
                'original' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'category' => $cat,
            ];
            $attachmentCategories[] = $cat;
        }

        // Determine DB-friendly type
        $resolvedType = 'text';
        if (!empty($attachmentsMeta)) {
            $unique = array_unique($attachmentCategories);
            if (count($unique) === 1) {
                $resolvedType = $unique[0]; // image or audio or file
            } else {
                $resolvedType = 'file';
            }
        }

        $message = Message::create([
            'chat_id' => $chat->id,
            'sender_id' => auth()->id(),
            'message' => $request->message ?? '',
            'attachments' => !empty($attachmentsMeta) ? $attachmentsMeta : null,
            'type' => $resolvedType,
        ]);

        // Update chat last message time and unread flags
        $senderId = auth()->id();
        $chat->update([
            'last_message_at' => now(),
            'is_read_by_buyer' => $chat->buyer_id === $senderId ? true : false,
            'is_read_by_seller' => $chat->seller_id === $senderId ? true : false,
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