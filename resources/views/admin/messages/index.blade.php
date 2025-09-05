@extends('layouts.admin')

@section('title', 'Messages Management')

@section('content')
<!-- Page Header -->
<div style="margin-bottom: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="font-size: 1.875rem; font-weight: 700; color: #1f2937; margin-bottom: 0.5rem;">Messages Management</h1>
            <p style="color: #6b7280;">Monitor and manage all platform conversations</p>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
    <div style="background: white; border-radius: 0.75rem; padding: 1.25rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; color: white;">
                <i class="fas fa-comments"></i>
            </div>
            <div>
                <div style="font-size: 1.5rem; font-weight: 700; color: #1f2937;">{{ $chats->total() }}</div>
                <div style="color: #6b7280; font-size: 0.875rem;">Total Conversations</div>
            </div>
        </div>
    </div>
    
    <div style="background: white; border-radius: 0.75rem; padding: 1.25rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; color: white;">
                <i class="fas fa-clock"></i>
            </div>
            <div>
                <div style="font-size: 1.5rem; font-weight: 700; color: #1f2937;">
                    {{ $chats->where('updated_at', '>=', now()->subDay())->count() }}
                </div>
                <div style="color: #6b7280; font-size: 0.875rem;">Active Today</div>
            </div>
        </div>
    </div>
    
    <div style="background: white; border-radius: 0.75rem; padding: 1.25rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; color: white;">
                <i class="fas fa-envelope"></i>
            </div>
            <div>
                <div style="font-size: 1.5rem; font-weight: 700; color: #1f2937;">
                    {{ \App\Models\Message::count() }}
                </div>
                <div style="color: #6b7280; font-size: 0.875rem;">Total Messages</div>
            </div>
        </div>
    </div>
    
    <div style="background: white; border-radius: 0.75rem; padding: 1.25rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; color: white;">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <div style="font-size: 1.5rem; font-weight: 700; color: #1f2937;">
                    {{ \App\Models\Message::distinct('sender_id')->count('sender_id') }}
                </div>
                <div style="color: #6b7280; font-size: 0.875rem;">Users Messaging</div>
            </div>
        </div>
    </div>
</div>

<!-- Messages Table -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">All Conversations</h3>
    </div>
    <div class="card-body" style="padding: 0;">
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Listing</th>
                        <th>Buyer</th>
                        <th>Seller</th>
                        <th>Messages</th>
                        <th>Last Activity</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($chats as $chat)
                    <tr>
                        <td>#{{ $chat->id }}</td>
                        <td>
                            @if($chat->listing)
                            <div>
                                <div style="font-weight: 600; color: #1f2937; font-size: 0.875rem;">
                                    {{ Str::limit($chat->listing->title, 25) }}
                                </div>
                                <div style="color: #6b7280; font-size: 0.75rem;">
                                    ${{ number_format($chat->listing->price) }}
                                </div>
                            </div>
                            @else
                            <span style="color: #9ca3af;">Listing Deleted</span>
                            @endif
                        </td>
                        <td>
                            @if($chat->buyer)
                            <div>
                                <div style="font-weight: 600; font-size: 0.875rem;">{{ $chat->buyer->name }}</div>
                                <div style="color: #6b7280; font-size: 0.75rem;">{{ $chat->buyer->email }}</div>
                            </div>
                            @else
                            <span style="color: #9ca3af;">User Deleted</span>
                            @endif
                        </td>
                        <td>
                            @if($chat->seller)
                            <div>
                                <div style="font-weight: 600; font-size: 0.875rem;">{{ $chat->seller->name }}</div>
                                <div style="color: #6b7280; font-size: 0.75rem;">{{ $chat->seller->email }}</div>
                            </div>
                            @else
                            <span style="color: #9ca3af;">User Deleted</span>
                            @endif
                        </td>
                        <td>
                            <span style="display: inline-flex; align-items: center; gap: 0.25rem; padding: 0.25rem 0.75rem; background: #dbeafe; color: #1e40af; border-radius: 1rem; font-size: 0.875rem; font-weight: 600;">
                                <i class="fas fa-envelope"></i> {{ $chat->messages()->count() }}
                            </span>
                        </td>
                        <td>
                            <span style="color: #6b7280; font-size: 0.875rem;">
                                {{ $chat->updated_at->diffForHumans() }}
                            </span>
                        </td>
                        <td>{{ $chat->created_at->format('M d, Y') }}</td>
                        <td>
                            <div style="display: flex; gap: 0.5rem;">
                                <a href="{{ route('admin.messages.show', $chat) }}" class="btn btn-sm" 
                                   style="padding: 0.25rem 0.5rem; font-size: 0.75rem; background: #3b82f6; color: white;" 
                                   title="View Messages">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.messages.delete', $chat) }}" 
                                      style="display: inline;"
                                      onsubmit="return confirm('Are you sure you want to delete this entire conversation?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm" 
                                            style="padding: 0.25rem 0.5rem; font-size: 0.75rem; background: #ef4444; color: white;"
                                            title="Delete Conversation">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 3rem; color: #6b7280;">
                            <i class="fas fa-comments" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.3;"></i>
                            <p>No conversations found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($chats->hasPages())
        <div style="padding: 1.5rem; border-top: 1px solid #e5e7eb;">
            {{ $chats->links() }}
        </div>
        @endif
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
    padding: 1.5rem;
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

.table-container {
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th {
    text-align: left;
    padding: 0.75rem 1rem;
    background: #f9fafb;
    border-bottom: 1px solid #e5e7eb;
    font-weight: 600;
    font-size: 0.875rem;
    color: #6b7280;
}

td {
    padding: 1rem;
    border-bottom: 1px solid #f3f4f6;
}

tr:hover {
    background: #f9fafb;
}

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
    border: none;
    border-radius: 0.25rem;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
}
</style>
@endpush
@endsection
