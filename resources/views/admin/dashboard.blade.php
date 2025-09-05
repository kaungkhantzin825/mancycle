@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<!-- Page Header -->
<div style="margin-bottom: 2rem;">
    <h1 style="font-size: 1.875rem; font-weight: 700; color: #1f2937; margin-bottom: 0.5rem;">Dashboard Overview</h1>
    <p style="color: #6b7280;">Welcome back, {{ auth()->user()->name }}! Here's what's happening on your platform.</p>
</div>
<!-- Stats Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);">
            <i class="fas fa-users"></i>
        </div>
        <div>
            <div class="stat-number">{{ $stats['total_users'] }}</div>
            <div class="stat-label">Total Users</div>
            @if($stats['pending_users'] > 0)
            <div style="color: #f59e0b; font-size: 0.875rem; margin-top: 0.25rem;">
                {{ $stats['pending_users'] }} pending approval
            </div>
            @endif
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
            <i class="fas fa-list"></i>
        </div>
        <div>
            <div class="stat-number">{{ $stats['total_listings'] }}</div>
            <div class="stat-label">Total Listings</div>
            @if($stats['pending_listings'] > 0)
            <div style="color: #f59e0b; font-size: 0.875rem; margin-top: 0.25rem;">
                {{ $stats['pending_listings'] }} pending approval
            </div>
            @endif
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
            <i class="fas fa-comments"></i>
        </div>
        <div>
            <div class="stat-number">{{ $stats['total_chats'] }}</div>
            <div class="stat-label">Active Chats</div>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
            <i class="fas fa-envelope"></i>
        </div>
        <div>
            <div class="stat-number">{{ $stats['total_messages'] }}</div>
            <div class="stat-label">Total Messages</div>
        </div>
    </div>
</div>

        <!-- Quick Actions -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 3rem;">
            <a href="{{ route('admin.users.index') }}" class="btn btn-primary" style="justify-content: center; padding: 1rem;">
                <i class="fas fa-users"></i>
                Manage Users
            </a>
            <a href="{{ route('admin.listings.index') }}" class="btn btn-primary" style="justify-content: center; padding: 1rem;">
                <i class="fas fa-list"></i>
                Manage Listings
            </a>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-primary" style="justify-content: center; padding: 1rem;">
                <i class="fas fa-tags"></i>
                Manage Categories
            </a>
        </div>

        <!-- Recent Activity -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
            <!-- Pending Users -->
            <div class="dashboard-card">
                <div class="card-header">
                    <h3>Pending User Approvals</h3>
                    <a href="{{ route('admin.users.index') }}" class="btn-link">View All</a>
                </div>
                
                @if($recentUsers->count() > 0)
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    @foreach($recentUsers as $user)
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; background: #f9fafb; border-radius: 0.5rem;">
                        <div>
                            <div style="font-weight: 600; color: #1f2937;">{{ $user->name }}</div>
                            <div style="color: #6b7280; font-size: 0.875rem;">{{ $user->email }}</div>
                            <div style="color: #9ca3af; font-size: 0.75rem;">{{ $user->created_at->diffForHumans() }}</div>
                        </div>
                        <div style="display: flex; gap: 0.5rem;">
                            <form method="POST" action="{{ route('admin.users.approve', $user) }}" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn" style="background: #10b981; color: white; padding: 0.5rem 1rem; font-size: 0.875rem;">
                                    Approve
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.users.block', $user) }}" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn" style="background: #ef4444; color: white; padding: 0.5rem 1rem; font-size: 0.875rem;">
                                    Block
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p style="color: #6b7280; text-align: center; padding: 2rem;">No pending user approvals</p>
                @endif
            </div>

            <!-- Pending Listings -->
            <div class="dashboard-card">
                <div class="card-header">
                    <h3>Pending Listing Approvals</h3>
                    <a href="{{ route('admin.listings.index') }}" class="btn-link">View All</a>
                </div>
                
                @if($recentListings->count() > 0)
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    @foreach($recentListings as $listing)
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; background: #f9fafb; border-radius: 0.5rem;">
                        <div>
                            <div style="font-weight: 600; color: #1f2937;">{{ $listing->title }}</div>
                            <div style="color: #059669; font-weight: 600;">${{ number_format($listing->price) }}</div>
                            <div style="color: #6b7280; font-size: 0.875rem;">by {{ $listing->user->name }}</div>
                            <div style="color: #9ca3af; font-size: 0.75rem;">{{ $listing->created_at->diffForHumans() }}</div>
                        </div>
                        <div style="display: flex; gap: 0.5rem;">
                            <form method="POST" action="{{ route('admin.listings.approve', $listing) }}" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn" style="background: #10b981; color: white; padding: 0.5rem 1rem; font-size: 0.875rem;">
                                    Approve
                                </button>
                            </form>
                            <button onclick="showRejectModal({{ $listing->id }})" class="btn" style="background: #ef4444; color: white; padding: 0.5rem 1rem; font-size: 0.875rem;">
                                Reject
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p style="color: #6b7280; text-align: center; padding: 2rem;">No pending listing approvals</p>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Reject Modal -->
<div id="rejectModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 1rem; padding: 2rem; max-width: 500px; width: 90%;">
        <h3 style="margin-bottom: 1rem;">Reject Listing</h3>
        <form id="rejectForm" method="POST">
            @csrf
            @method('PATCH')
            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Rejection Reason:</label>
                <textarea name="rejection_reason" required style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; min-height: 100px;"></textarea>
            </div>
            <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                <button type="button" onclick="hideRejectModal()" class="btn btn-secondary">Cancel</button>
                <button type="submit" class="btn" style="background: #ef4444; color: white;">Reject Listing</button>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
.stat-card {
    background: white;
    border-radius: 1rem;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
}

.stat-number {
    font-size: 2rem;
    font-weight: 700;
    color: #1f2937;
}

.stat-label {
    color: #6b7280;
    font-size: 0.875rem;
}

.dashboard-card {
    background: white;
    border-radius: 1rem;
    padding: 1.5rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #e5e7eb;
}

.card-header h3 {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1f2937;
}

.btn-link {
    color: #667eea;
    text-decoration: none;
    font-weight: 500;
    font-size: 0.875rem;
}

.btn-link:hover {
    text-decoration: underline;
}
</style>
@endpush

@push('scripts')
<script>
function showRejectModal(listingId) {
    const modal = document.getElementById('rejectModal');
    const form = document.getElementById('rejectForm');
    form.action = `/admin/listings/${listingId}/reject`;
    modal.style.display = 'flex';
}

function hideRejectModal() {
    const modal = document.getElementById('rejectModal');
    modal.style.display = 'none';
}

// Close modal when clicking outside
document.getElementById('rejectModal').addEventListener('click', function(e) {
    if (e.target === this) {
        hideRejectModal();
    }
});
</script>
@endpush
@endsection