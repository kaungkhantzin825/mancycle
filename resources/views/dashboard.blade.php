@extends('layouts.mancycle')

@section('title', 'Dashboard - ManCycle')

@section('content')
<div class="dashboard-container">
    <div class="container" style="padding: 2rem 0;">
        <!-- Welcome Header -->
        <div class="welcome-section">
            <h1>Welcome back, {{ Auth::user()->name }}!</h1>
            <p>Manage your listings, messages, and account from your personal dashboard.</p>
        </div>

        <!-- Quick Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <i class="fas fa-list"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['total_listings'] ?? 0 }}</h3>
                    <p>Total Listings</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['active_listings'] ?? 0 }}</h3>
                    <p>Active Listings</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['pending_listings'] ?? 0 }}</h3>
                    <p>Pending Approval</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
                    <i class="fas fa-heart"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['favorites_count'] ?? 0 }}</h3>
                    <p>Favorites</p>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
            <h2>Quick Actions</h2>
            <div class="action-buttons">
                <a href="{{ route('listings.create') }}" class="action-btn">
                    <i class="fas fa-plus-circle"></i>
                    <span>Create New Listing</span>
                </a>
                <a href="{{ route('messages.index') }}" class="action-btn">
                    <i class="fas fa-envelope"></i>
                    <span>View Messages</span>
                </a>
                <a href="{{ route('favorites.index') }}" class="action-btn">
                    <i class="fas fa-heart"></i>
                    <span>My Favorites</span>
                </a>
                <a href="{{ route('profile.edit') }}" class="action-btn">
                    <i class="fas fa-user-edit"></i>
                    <span>Edit Profile</span>
                </a>
            </div>
        </div>

        <!-- Recent Listings -->
        <div class="dashboard-section">
            <div class="section-header">
                <h2>Your Recent Listings</h2>
                <a href="{{ route('listings.index') }}?user={{ Auth::id() }}" class="view-all-link">View All →</a>
            </div>
            
            @if(isset($recentListings) && count($recentListings) > 0)
            <div class="listings-table">
                <table>
                    <thead>
                        <tr>
                            <th>Image</th>
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
                            <td>
                                <div class="listing-thumb">
                                    @if($listing->images && json_decode($listing->images) && count(json_decode($listing->images)) > 0)
                                        <img src="{{ json_decode($listing->images)[0] }}" alt="{{ $listing->title }}">
                                    @else
                                        <div class="placeholder-image">
                                            <i class="fas fa-image"></i>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('listings.show', $listing) }}" class="listing-link">
                                    {{ Str::limit($listing->title, 30) }}
                                </a>
                            </td>
                            <td>{{ $listing->category->name ?? 'N/A' }}</td>
                            <td class="price">${{ number_format($listing->price) }}</td>
                            <td>
                                <span class="status-badge status-{{ $listing->status }}">
                                    {{ ucfirst($listing->status) }}
                                </span>
                            </td>
                            <td>{{ $listing->views ?? 0 }}</td>
                            <td>{{ $listing->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="action-dropdown">
                                    <button class="action-toggle">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div class="action-menu">
                                        <a href="{{ route('listings.show', $listing) }}">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        <a href="{{ route('listings.edit', $listing) }}">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form method="POST" action="{{ route('listings.destroy', $listing) }}" 
                                              onsubmit="return confirm('Are you sure you want to delete this listing?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="empty-state">
                <i class="fas fa-box-open"></i>
                <h3>No listings yet</h3>
                <p>Start selling by creating your first listing!</p>
                <a href="{{ route('listings.create') }}" class="btn btn-primary">Create Listing</a>
            </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
.dashboard-container {
    background: #f8fafc;
    min-height: calc(100vh - 200px);
}

.welcome-section {
    background: white;
    padding: 2rem;
    border-radius: 12px;
    margin-bottom: 2rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
}

.welcome-section h1 {
    font-size: 2rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 0.5rem;
}

.welcome-section p {
    color: #6b7280;
    font-size: 1.1rem;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1.5rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 12px rgba(0, 0, 0, 0.1);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
}

.stat-content h3 {
    font-size: 2rem;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
}

.stat-content p {
    color: #6b7280;
    margin: 0;
    font-size: 0.9rem;
}

.quick-actions {
    background: white;
    border-radius: 12px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
}

.quick-actions h2 {
    font-size: 1.5rem;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 1.5rem;
}

.action-buttons {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.action-btn {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem 1.5rem;
    background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
    border-radius: 8px;
    text-decoration: none;
    color: #374151;
    font-weight: 500;
    transition: all 0.3s ease;
}

.action-btn:hover {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
    transform: translateY(-2px);
}

.action-btn i {
    font-size: 1.25rem;
}

.dashboard-section {
    background: white;
    border-radius: 12px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.section-header h2 {
    font-size: 1.5rem;
    font-weight: 600;
    color: #1f2937;
}

.view-all-link {
    color: #f59e0b;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s ease;
}

.view-all-link:hover {
    color: #d97706;
}

.listings-table {
    overflow-x: auto;
}

.listings-table table {
    width: 100%;
    border-collapse: collapse;
}

.listings-table th {
    text-align: left;
    padding: 0.75rem;
    background: #f8fafc;
    color: #6b7280;
    font-weight: 600;
    font-size: 0.875rem;
    text-transform: uppercase;
    border-bottom: 2px solid #e5e7eb;
}

.listings-table td {
    padding: 1rem 0.75rem;
    border-bottom: 1px solid #f3f4f6;
}

.listing-thumb {
    width: 50px;
    height: 50px;
    overflow: hidden;
    border-radius: 8px;
}

.listing-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.placeholder-image {
    width: 50px;
    height: 50px;
    background: #f3f4f6;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #9ca3af;
}

.listing-link {
    color: #1f2937;
    text-decoration: none;
    font-weight: 500;
}

.listing-link:hover {
    color: #f59e0b;
}

.price {
    font-weight: 600;
    color: #059669;
}

.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
}

.status-approved {
    background: #d1fae5;
    color: #065f46;
}

.status-pending {
    background: #fed7aa;
    color: #92400e;
}

.status-rejected {
    background: #fee2e2;
    color: #991b1b;
}

.status-sold {
    background: #e0e7ff;
    color: #3730a3;
}

.action-dropdown {
    position: relative;
}

.action-toggle {
    background: none;
    border: none;
    color: #6b7280;
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 4px;
    transition: background 0.3s ease;
}

.action-toggle:hover {
    background: #f3f4f6;
}

.action-menu {
    display: none;
    position: absolute;
    right: 0;
    top: 100%;
    background: white;
    border-radius: 8px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    min-width: 150px;
    z-index: 10;
}

.action-dropdown:hover .action-menu {
    display: block;
}

.action-menu a,
.action-menu button {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1rem;
    color: #374151;
    text-decoration: none;
    border: none;
    background: none;
    width: 100%;
    text-align: left;
    cursor: pointer;
    transition: background 0.3s ease;
}

.action-menu a:hover,
.action-menu button:hover {
    background: #f3f4f6;
}

.empty-state {
    text-align: center;
    padding: 3rem;
}

.empty-state i {
    font-size: 4rem;
    color: #d1d5db;
    margin-bottom: 1rem;
}

.empty-state h3 {
    font-size: 1.5rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
}

.empty-state p {
    color: #6b7280;
    margin-bottom: 1.5rem;
}

@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .action-buttons {
        grid-template-columns: 1fr;
    }
    
    .listings-table {
        font-size: 0.875rem;
    }
}
</style>
@endpush

@endsection
