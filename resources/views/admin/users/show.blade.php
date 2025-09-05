@extends('layouts.admin')

@section('title', 'User Details')

@section('content')
<!-- Page Header -->
<div style="margin-bottom: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="font-size: 1.875rem; font-weight: 700; color: #1f2937; margin-bottom: 0.5rem;">User Profile</h1>
            <p style="color: #6b7280;">Detailed information and activity for {{ $user->name }}</p>
        </div>
        <div style="display: flex; gap: 1rem;">
            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i>
                Edit User
            </a>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Back to Users
            </a>
        </div>
    </div>
</div>

<!-- User Profile Section -->
<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 2rem; margin-bottom: 2rem;">
    <!-- User Card -->
    <div class="card">
        <div class="card-body" style="text-align: center; padding: 2rem;">
            <div style="width: 100px; height: 100px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 2.5rem; font-weight: 700; margin: 0 auto 1rem;">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <h2 style="font-size: 1.5rem; font-weight: 700; color: #1f2937; margin-bottom: 0.25rem;">{{ $user->name }}</h2>
            <p style="color: #6b7280; margin-bottom: 1rem;">{{ $user->email }}</p>
            
            <div style="display: flex; justify-content: center; gap: 0.5rem; margin-bottom: 1.5rem;">
                <span class="badge badge-{{ $user->role == 'admin' ? 'danger' : ($user->role == 'dealer' ? 'warning' : 'primary') }}">
                    {{ ucfirst($user->role) }}
                </span>
                @if($user->status == 'approved')
                <span class="badge badge-success">Approved</span>
                @elseif($user->status == 'pending')
                <span class="badge badge-warning">Pending</span>
                @else
                <span class="badge badge-danger">Blocked</span>
                @endif
            </div>
            
            <div style="text-align: left; padding: 1rem; background: #f9fafb; border-radius: 0.5rem;">
                <div style="display: flex; justify-content: space-between; padding: 0.5rem 0;">
                    <span style="color: #6b7280;">Phone:</span>
                    <span style="font-weight: 600;">{{ $user->phone ?? 'Not provided' }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 0.5rem 0;">
                    <span style="color: #6b7280;">Member Since:</span>
                    <span style="font-weight: 600;">{{ $user->created_at->format('M d, Y') }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 0.5rem 0;">
                    <span style="color: #6b7280;">Last Login:</span>
                    <span style="font-weight: 600;">{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- User Statistics -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Statistics Overview</h3>
        </div>
        <div class="card-body">
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem;">
                <div style="text-align: center; padding: 1.5rem; background: #f0f9ff; border-radius: 0.75rem;">
                    <div style="font-size: 2.5rem; font-weight: 700; color: #3b82f6;">{{ $userStats['total_listings'] }}</div>
                    <div style="color: #6b7280; margin-top: 0.5rem;">Total Listings</div>
                </div>
                <div style="text-align: center; padding: 1.5rem; background: #f0fdf4; border-radius: 0.75rem;">
                    <div style="font-size: 2.5rem; font-weight: 700; color: #10b981;">{{ $userStats['active_listings'] }}</div>
                    <div style="color: #6b7280; margin-top: 0.5rem;">Active Listings</div>
                </div>
                <div style="text-align: center; padding: 1.5rem; background: #fef3c7; border-radius: 0.75rem;">
                    <div style="font-size: 2.5rem; font-weight: 700; color: #f59e0b;">{{ $userStats['total_messages'] }}</div>
                    <div style="color: #6b7280; margin-top: 0.5rem;">Messages Sent</div>
                </div>
                <div style="text-align: center; padding: 1.5rem; background: #fce7f3; border-radius: 0.75rem;">
                    <div style="font-size: 2.5rem; font-weight: 700; color: #ec4899;">{{ $userStats['total_chats'] }}</div>
                    <div style="color: #6b7280; margin-top: 0.5rem;">Total Chats</div>
                </div>
                <div style="text-align: center; padding: 1.5rem; background: #f3e8ff; border-radius: 0.75rem;">
                    <div style="font-size: 2.5rem; font-weight: 700; color: #8b5cf6;">
                        @if($user->email_verified_at)
                        <i class="fas fa-check-circle"></i>
                        @else
                        <i class="fas fa-times-circle"></i>
                        @endif
                    </div>
                    <div style="color: #6b7280; margin-top: 0.5rem;">Email {{ $user->email_verified_at ? 'Verified' : 'Not Verified' }}</div>
                </div>
                <div style="text-align: center; padding: 1.5rem; background: #fee2e2; border-radius: 0.75rem;">
                    <div style="font-size: 2.5rem; font-weight: 700; color: #ef4444;">0</div>
                    <div style="color: #6b7280; margin-top: 0.5rem;">Violations</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabs Section -->
<div class="card">
    <div class="card-header">
        <div style="display: flex; gap: 2rem;">
            <button class="tab-btn active" onclick="showTab('listings')" data-tab="listings">
                <i class="fas fa-list"></i> Listings
            </button>
            <button class="tab-btn" onclick="showTab('activity')" data-tab="activity">
                <i class="fas fa-history"></i> Activity
            </button>
            <button class="tab-btn" onclick="showTab('messages')" data-tab="messages">
                <i class="fas fa-envelope"></i> Messages
            </button>
        </div>
    </div>
    <div class="card-body">
        <!-- Listings Tab -->
        <div id="listings-tab" class="tab-content active">
            <h4 style="margin-bottom: 1rem;">User Listings</h4>
            @if($recentListings->count() > 0)
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Views</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentListings as $listing)
                        <tr>
                            <td>{{ Str::limit($listing->title, 30) }}</td>
                            <td>{{ $listing->category->name ?? 'N/A' }}</td>
                            <td>${{ number_format($listing->price) }}</td>
                            <td>
                                @if($listing->status == 'approved')
                                <span class="badge badge-success">Approved</span>
                                @elseif($listing->status == 'pending')
                                <span class="badge badge-warning">Pending</span>
                                @else
                                <span class="badge badge-danger">Rejected</span>
                                @endif
                            </td>
                            <td>{{ $listing->views ?? 0 }}</td>
                            <td>{{ $listing->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('listings.show', $listing) }}" target="_blank" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p style="text-align: center; color: #6b7280; padding: 2rem;">No listings found for this user.</p>
            @endif
        </div>
        
        <!-- Activity Tab -->
        <div id="activity-tab" class="tab-content" style="display: none;">
            <h4 style="margin-bottom: 1rem;">Recent Activity</h4>
            @if($recentActivity->count() > 0)
            <div style="max-height: 400px; overflow-y: auto;">
                @foreach($recentActivity as $activity)
                <div style="display: flex; gap: 1rem; padding: 1rem; border-bottom: 1px solid #e5e7eb;">
                    <div style="width: 40px; height: 40px; background: #f3f4f6; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        @if($activity['type'] == 'listing_created')
                        <i class="fas fa-plus" style="color: #10b981;"></i>
                        @elseif($activity['type'] == 'message_sent')
                        <i class="fas fa-envelope" style="color: #3b82f6;"></i>
                        @else
                        <i class="fas fa-circle" style="color: #6b7280;"></i>
                        @endif
                    </div>
                    <div style="flex: 1;">
                        <div style="font-weight: 600; color: #1f2937;">{{ $activity['description'] }}</div>
                        <div style="color: #6b7280; font-size: 0.875rem;">{{ $activity['created_at']->diffForHumans() }}</div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <p style="text-align: center; color: #6b7280; padding: 2rem;">No recent activity found.</p>
            @endif
        </div>
        
        <!-- Messages Tab -->
        <div id="messages-tab" class="tab-content" style="display: none;">
            <h4 style="margin-bottom: 1rem;">Recent Messages</h4>
            <p style="text-align: center; color: #6b7280; padding: 2rem;">Message history will be displayed here.</p>
        </div>
    </div>
</div>

@push('styles')
<style>
.badge {
    display: inline-flex;
    align-items: center;
    padding: 0.25rem 0.75rem;
    border-radius: 1rem;
    font-size: 0.75rem;
    font-weight: 600;
}

.badge-primary {
    background: #dbeafe;
    color: #1e40af;
}

.badge-success {
    background: #d1fae5;
    color: #065f46;
}

.badge-warning {
    background: #fed7aa;
    color: #92400e;
}

.badge-danger {
    background: #fee2e2;
    color: #991b1b;
}

.tab-btn {
    background: none;
    border: none;
    padding: 0.75rem 1.5rem;
    color: #6b7280;
    font-weight: 600;
    cursor: pointer;
    border-bottom: 2px solid transparent;
    transition: all 0.2s ease;
}

.tab-btn:hover {
    color: #ef4444;
}

.tab-btn.active {
    color: #ef4444;
    border-bottom-color: #ef4444;
}

.tab-content {
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
}
</style>
@endpush

@push('scripts')
<script>
function showTab(tabName) {
    // Hide all tabs
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.style.display = 'none';
    });
    
    // Remove active class from all buttons
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    
    // Show selected tab
    document.getElementById(tabName + '-tab').style.display = 'block';
    
    // Add active class to clicked button
    document.querySelector(`[data-tab="${tabName}"]`).classList.add('active');
}
</script>
@endpush
@endsection
