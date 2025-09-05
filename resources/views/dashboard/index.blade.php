@extends('layouts.mancycle')

@section('title', 'Dashboard - ManCycle')

@section('content')
<!-- Dashboard Header -->
<section style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 2rem 0;">
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 0.5rem;">Welcome back, John!</h1>
                <p style="opacity: 0.9;">Manage your listings and track your activity</p>
            </div>
            <a href="{{ route('listings.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Create New Listing
            </a>
        </div>
    </div>
</section>

<!-- Dashboard Content -->
<section style="padding: 2rem 0; background: #f8fafc;">
    <div class="container">
        <!-- Stats Cards -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 3rem;">
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <i class="fas fa-list"></i>
                </div>
                <div>
                    <div class="stat-number">24</div>
                    <div class="stat-label">Total Listings</div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                    <i class="fas fa-eye"></i>
                </div>
                <div>
                    <div class="stat-number">1,247</div>
                    <div class="stat-label">Total Views</div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                    <i class="fas fa-comments"></i>
                </div>
                <div>
                    <div class="stat-number">18</div>
                    <div class="stat-label">Active Chats</div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
                    <i class="fas fa-heart"></i>
                </div>
                <div>
                    <div class="stat-number">156</div>
                    <div class="stat-label">Favorites</div>
                </div>
            </div>
        </div>
        
        <!-- Main Dashboard Grid -->
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
            <!-- Recent Listings -->
            <div class="dashboard-card">
                <div class="card-header">
                    <h3>Recent Listings</h3>
                    <a href="{{ route('listings.index') }}" class="btn-link">View All</a>
                </div>
                
                <div class="listings-table">
                    <div class="table-header">
                        <div>Listing</div>
                        <div>Status</div>
                        <div>Views</div>
                        <div>Actions</div>
                    </div>
                    
                    @for($i = 1; $i <= 5; $i++)
                    <div class="table-row">
                        <div class="listing-info">
                            <div class="listing-thumb">
                                <i class="fas fa-{{ $i % 2 == 0 ? 'car' : 'motorcycle' }}"></i>
                            </div>
                            <div>
                                <div class="listing-name">{{ $i % 2 == 0 ? 'Honda Civic 2020' : 'Yamaha R15 V3' }}</div>
                                <div class="listing-price">${{ number_format(rand(5000, 25000)) }}</div>
                            </div>
                        </div>
                        <div>
                            <span class="status-badge {{ ['pending', 'approved', 'rejected'][rand(0, 2)] }}">
                                {{ ucfirst(['pending', 'approved', 'rejected'][rand(0, 2)]) }}
                            </span>
                        </div>
                        <div class="view-count">{{ rand(50, 500) }}</div>
                        <div class="actions">
                            <button class="action-btn edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="action-btn delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>
            
            <!-- Quick Actions & Recent Activity -->
            <div style="display: flex; flex-direction: column; gap: 2rem;">
                <!-- Quick Actions -->
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3>Quick Actions</h3>
                    </div>
                    
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        <a href="{{ route('listings.create') }}" class="quick-action">
                            <i class="fas fa-plus"></i>
                            <span>Create New Listing</span>
                        </a>
                        <a href="{{ route('messages.index') }}" class="quick-action">
                            <i class="fas fa-comments"></i>
                            <span>View Messages</span>
                        </a>
                        <a href="{{ route('favorites.index') }}" class="quick-action">
                            <i class="fas fa-heart"></i>
                            <span>My Favorites</span>
                        </a>
                        <a href="#" class="quick-action">
                            <i class="fas fa-cog"></i>
                            <span>Account Settings</span>
                        </a>
                    </div>
                </div>
                
                <!-- Recent Activity -->
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3>Recent Activity</h3>
                    </div>
                    
                    <div class="activity-list">
                        <div class="activity-item">
                            <div class="activity-icon approved">
                                <i class="fas fa-check"></i>
                            </div>
                            <div>
                                <div class="activity-text">Your listing "Honda Civic 2020" was approved</div>
                                <div class="activity-time">2 hours ago</div>
                            </div>
                        </div>
                        
                        <div class="activity-item">
                            <div class="activity-icon message">
                                <i class="fas fa-comment"></i>
                            </div>
                            <div>
                                <div class="activity-text">New message from Sarah about "Yamaha R15"</div>
                                <div class="activity-time">4 hours ago</div>
                            </div>
                        </div>
                        
                        <div class="activity-item">
                            <div class="activity-icon view">
                                <i class="fas fa-eye"></i>
                            </div>
                            <div>
                                <div class="activity-text">Your listing received 15 new views</div>
                                <div class="activity-time">1 day ago</div>
                            </div>
                        </div>
                        
                        <div class="activity-item">
                            <div class="activity-icon favorite">
                                <i class="fas fa-heart"></i>
                            </div>
                            <div>
                                <div class="activity-text">Someone added your listing to favorites</div>
                                <div class="activity-time">2 days ago</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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

.listings-table {
    display: flex;
    flex-direction: column;
}

.table-header {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1fr;
    gap: 1rem;
    padding: 0.75rem 0;
    font-weight: 600;
    color: #374151;
    border-bottom: 1px solid #e5e7eb;
    font-size: 0.875rem;
}

.table-row {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1fr;
    gap: 1rem;
    padding: 1rem 0;
    border-bottom: 1px solid #f3f4f6;
    align-items: center;
}

.listing-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.listing-thumb {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.listing-name {
    font-weight: 500;
    color: #1f2937;
    font-size: 0.875rem;
}

.listing-price {
    color: #059669;
    font-weight: 600;
    font-size: 0.875rem;
}

.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 1rem;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
}

.status-badge.pending {
    background: #fef3c7;
    color: #d97706;
}

.status-badge.approved {
    background: #d1fae5;
    color: #059669;
}

.status-badge.rejected {
    background: #fee2e2;
    color: #dc2626;
}

.view-count {
    font-weight: 500;
    color: #6b7280;
}

.actions {
    display: flex;
    gap: 0.5rem;
}

.action-btn {
    width: 32px;
    height: 32px;
    border: none;
    border-radius: 0.375rem;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

.action-btn.edit {
    background: #dbeafe;
    color: #2563eb;
}

.action-btn.edit:hover {
    background: #bfdbfe;
}

.action-btn.delete {
    background: #fee2e2;
    color: #dc2626;
}

.action-btn.delete:hover {
    background: #fecaca;
}

.quick-action {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem;
    border-radius: 0.5rem;
    text-decoration: none;
    color: #374151;
    transition: all 0.3s ease;
}

.quick-action:hover {
    background: #f3f4f6;
    color: #667eea;
}

.quick-action i {
    width: 20px;
    text-align: center;
}

.activity-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.activity-item {
    display: flex;
    gap: 0.75rem;
    align-items: flex-start;
}

.activity-icon {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.75rem;
    flex-shrink: 0;
}

.activity-icon.approved {
    background: #10b981;
}

.activity-icon.message {
    background: #3b82f6;
}

.activity-icon.view {
    background: #f59e0b;
}

.activity-icon.favorite {
    background: #ef4444;
}

.activity-text {
    font-size: 0.875rem;
    color: #374151;
    line-height: 1.4;
}

.activity-time {
    font-size: 0.75rem;
    color: #9ca3af;
    margin-top: 0.25rem;
}

@media (max-width: 768px) {
    .container > div:last-child {
        grid-template-columns: 1fr !important;
    }
    
    .table-header,
    .table-row {
        grid-template-columns: 1fr !important;
        gap: 0.5rem !important;
    }
    
    .table-header > div:not(:first-child),
    .table-row > div:not(:first-child) {
        display: none;
    }
}
</style>
@endpush
@endsection