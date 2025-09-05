@extends('layouts.admin')

@section('title', 'Conversation Details')

@section('content')
<!-- Page Header -->
<div style="margin-bottom: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="font-size: 1.875rem; font-weight: 700; color: #1f2937; margin-bottom: 0.5rem;">Conversation Details</h1>
            <p style="color: #6b7280;">Chat ID: #{{ $chat->id }}</p>
        </div>
        <a href="{{ route('admin.messages') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i>
            Back to Messages
        </a>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 2rem;">
    <!-- Conversation Info -->
    <div>
        <!-- Listing Details -->
        <div class="card" style="margin-bottom: 1.5rem;">
            <div class="card-header">
                <h3 class="card-title">Listing Details</h3>
            </div>
            <div class="card-body">
                @if($chat->listing)
                <div style="margin-bottom: 1rem;">
                    @if($chat->listing->image)
                    <img src="{{ asset('storage/' . $chat->listing->image) }}" 
                         alt="{{ $chat->listing->title }}"
                         style="width: 100%; height: 150px; object-fit: cover; border-radius: 0.5rem; margin-bottom: 1rem;">
                    @else
                    <div style="width: 100%; height: 150px; background: #e5e7eb; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                        <i class="fas fa-image" style="font-size: 2rem; color: #9ca3af;"></i>
                    </div>
                    @endif
                    
                    <h4 style="font-weight: 600; color: #1f2937; margin-bottom: 0.5rem;">{{ $chat->listing->title }}</h4>
                    <p style="font-size: 1.5rem; font-weight: 700; color: #059669; margin-bottom: 0.5rem;">
                        ${{ number_format($chat->listing->price) }}
                    </p>
                    <p style="color: #6b7280; font-size: 0.875rem;">
                        <i class="fas fa-map-marker-alt"></i> {{ $chat->listing->location ?? 'N/A' }}
                    </p>
                    <div style="margin-top: 1rem;">
                        <a href="{{ route('listings.show', $chat->listing) }}" target="_blank" class="btn btn-primary" style="width: 100%; justify-content: center;">
                            <i class="fas fa-external-link-alt"></i>
                            View Listing
                        </a>
                    </div>
                </div>
                @else
                <p style="color: #6b7280; text-align: center; padding: 2rem;">
                    <i class="fas fa-exclamation-triangle" style="display: block; font-size: 2rem; margin-bottom: 0.5rem;"></i>
                    Listing has been deleted
                </p>
                @endif
            </div>
        </div>
        
        <!-- Participants -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Participants</h3>
            </div>
            <div class="card-body">
                <!-- Buyer -->
                <div style="margin-bottom: 1.5rem;">
                    <h4 style="font-size: 0.875rem; font-weight: 600; color: #6b7280; margin-bottom: 0.5rem;">BUYER</h4>
                    @if($chat->buyer)
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600;">
                            {{ strtoupper(substr($chat->buyer->name, 0, 1)) }}
                        </div>
                        <div>
                            <div style="font-weight: 600; color: #1f2937;">{{ $chat->buyer->name }}</div>
                            <div style="color: #6b7280; font-size: 0.875rem;">{{ $chat->buyer->email }}</div>
                        </div>
                    </div>
                    @else
                    <span style="color: #9ca3af;">User deleted</span>
                    @endif
                </div>
                
                <!-- Seller -->
                <div>
                    <h4 style="font-size: 0.875rem; font-weight: 600; color: #6b7280; margin-bottom: 0.5rem;">SELLER</h4>
                    @if($chat->seller)
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600;">
                            {{ strtoupper(substr($chat->seller->name, 0, 1)) }}
                        </div>
                        <div>
                            <div style="font-weight: 600; color: #1f2937;">{{ $chat->seller->name }}</div>
                            <div style="color: #6b7280; font-size: 0.875rem;">{{ $chat->seller->email }}</div>
                        </div>
                    </div>
                    @else
                    <span style="color: #9ca3af;">User deleted</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Messages -->
    <div class="card">
        <div class="card-header">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h3 class="card-title">Messages ({{ $messages->count() }})</h3>
                <span style="color: #6b7280; font-size: 0.875rem;">
                    Started {{ $chat->created_at->diffForHumans() }}
                </span>
            </div>
        </div>
        <div class="card-body">
            <div style="max-height: 600px; overflow-y: auto; padding: 1rem; background: #f9fafb; border-radius: 0.5rem;">
                @forelse($messages as $message)
                <div style="margin-bottom: 1.5rem; {{ $message->sender_id == $chat->seller_id ? 'text-align: right;' : '' }}">
                    <div style="display: inline-block; max-width: 70%;">
                        <!-- Sender Info -->
                        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem; {{ $message->sender_id == $chat->seller_id ? 'justify-content: flex-end;' : '' }}">
                            @if($message->sender)
                            <span style="font-weight: 600; color: {{ $message->sender_id == $chat->seller_id ? '#059669' : '#3b82f6' }}; font-size: 0.875rem;">
                                {{ $message->sender->name }}
                                @if($message->sender_id == $chat->seller_id)
                                <span style="background: #d1fae5; color: #065f46; padding: 0.125rem 0.5rem; border-radius: 0.25rem; font-size: 0.75rem; margin-left: 0.5rem;">Seller</span>
                                @else
                                <span style="background: #dbeafe; color: #1e40af; padding: 0.125rem 0.5rem; border-radius: 0.25rem; font-size: 0.75rem; margin-left: 0.5rem;">Buyer</span>
                                @endif
                            </span>
                            @else
                            <span style="color: #9ca3af; font-size: 0.875rem;">Deleted User</span>
                            @endif
                        </div>
                        
                        <!-- Message Content -->
                        <div style="padding: 1rem; background: {{ $message->sender_id == $chat->seller_id ? 'linear-gradient(135deg, #10b981 0%, #059669 100%)' : 'white' }}; color: {{ $message->sender_id == $chat->seller_id ? 'white' : '#1f2937' }}; border-radius: 1rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                            <p style="margin: 0; word-wrap: break-word;">{{ $message->message }}</p>
                        </div>
                        
                        <!-- Timestamp -->
                        <div style="margin-top: 0.25rem; {{ $message->sender_id == $chat->seller_id ? 'text-align: right;' : '' }}">
                            <span style="color: #9ca3af; font-size: 0.75rem;">
                                {{ $message->created_at->format('M d, Y h:i A') }}
                                @if($message->is_read)
                                <i class="fas fa-check-double" style="margin-left: 0.25rem;"></i>
                                @endif
                            </span>
                        </div>
                        
                        <!-- Delete Button for Admin -->
                        <div style="margin-top: 0.5rem; {{ $message->sender_id == $chat->seller_id ? 'text-align: right;' : '' }}">
                            <form method="POST" action="{{ route('admin.messages.delete', $message) }}" 
                                  style="display: inline;"
                                  onsubmit="return confirm('Are you sure you want to delete this message?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: none; border: none; color: #ef4444; cursor: pointer; font-size: 0.75rem;">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <p style="text-align: center; color: #6b7280; padding: 2rem;">
                    No messages in this conversation
                </p>
                @endforelse
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.card {
    background: white;
    border-radius: 0.75rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.card-header {
    padding: 1rem 1.5rem;
    background: #f9fafb;
    border-bottom: 1px solid #e5e7eb;
}

.card-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0;
}

.card-body {
    padding: 1.5rem;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.625rem 1.25rem;
    border: none;
    border-radius: 0.5rem;
    font-weight: 500;
    font-size: 0.875rem;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
}

.btn-primary {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
}

.btn-secondary {
    background: white;
    color: #6b7280;
    border: 1px solid #e5e7eb;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* Custom scrollbar for messages */
.card-body > div::-webkit-scrollbar {
    width: 6px;
}

.card-body > div::-webkit-scrollbar-track {
    background: #f3f4f6;
    border-radius: 3px;
}

.card-body > div::-webkit-scrollbar-thumb {
    background: #9ca3af;
    border-radius: 3px;
}

.card-body > div::-webkit-scrollbar-thumb:hover {
    background: #6b7280;
}
</style>
@endpush
@endsection
