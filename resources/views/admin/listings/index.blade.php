@extends('layouts.admin')

@section('title', 'Listings Management')

@section('content')
<!-- Page Header -->
<div style="margin-bottom: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="font-size: 1.875rem; font-weight: 700; color: #1f2937; margin-bottom: 0.5rem;">Listings Management</h1>
            <p style="color: #6b7280;">Manage all vehicle listings on the platform</p>
        </div>
        <div style="display: flex; gap: 1rem;">
            <a href="{{ route('admin.listings.export') }}" class="btn btn-secondary">
                <i class="fas fa-download"></i>
                Export Listings
            </a>
            <a href="{{ route('listings.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Add New Listing
            </a>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
    <div class="stat-card" style="background: white; border-radius: 0.75rem; padding: 1.25rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; color: white;">
                <i class="fas fa-list"></i>
            </div>
            <div>
                <div style="font-size: 1.5rem; font-weight: 700; color: #1f2937;">{{ $listings->total() }}</div>
                <div style="color: #6b7280; font-size: 0.875rem;">Total Listings</div>
            </div>
        </div>
    </div>
    
    <div class="stat-card" style="background: white; border-radius: 0.75rem; padding: 1.25rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; color: white;">
                <i class="fas fa-check-circle"></i>
            </div>
            <div>
                <div style="font-size: 1.5rem; font-weight: 700; color: #1f2937;">{{ $listings->where('status', 'approved')->count() }}</div>
                <div style="color: #6b7280; font-size: 0.875rem;">Approved</div>
            </div>
        </div>
    </div>
    
    <div class="stat-card" style="background: white; border-radius: 0.75rem; padding: 1.25rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; color: white;">
                <i class="fas fa-clock"></i>
            </div>
            <div>
                <div style="font-size: 1.5rem; font-weight: 700; color: #1f2937;">{{ $listings->where('status', 'pending')->count() }}</div>
                <div style="color: #6b7280; font-size: 0.875rem;">Pending</div>
            </div>
        </div>
    </div>
    
    <div class="stat-card" style="background: white; border-radius: 0.75rem; padding: 1.25rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; color: white;">
                <i class="fas fa-ban"></i>
            </div>
            <div>
                <div style="font-size: 1.5rem; font-weight: 700; color: #1f2937;">{{ $listings->where('status', 'rejected')->count() }}</div>
                <div style="color: #6b7280; font-size: 0.875rem;">Rejected</div>
            </div>
        </div>
    </div>
</div>

<!-- Filters Section -->
<div class="card" style="margin-bottom: 2rem;">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.listings.index') }}" style="display: flex; gap: 1rem; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 200px;">
                <input type="text" name="search" placeholder="Search listings..." 
                       value="{{ request('search') }}"
                       style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
            </div>
            
            <select name="category" style="padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                <option value="">All Categories</option>
                @if(isset($categories))
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
                @endif
            </select>
            
            <select name="status" style="padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                <option value="">All Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
            
            <select name="sort" style="padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest First</option>
                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
            </select>
            
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i>
                Filter
            </button>
            <a href="{{ route('admin.listings.index') }}" class="btn btn-secondary">
                <i class="fas fa-redo"></i>
                Reset
            </a>
        </form>
    </div>
</div>

<!-- Listings Table -->
<div class="card">
    <div class="card-body" style="padding: 0;">
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Seller</th>
                        <th>Status</th>
                        <th>Views</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($listings as $listing)
                    <tr>
                        <td>#{{ $listing->id }}</td>
                        <td>
                            @if($listing->image)
                            <img src="{{ asset('storage/' . $listing->image) }}" alt="{{ $listing->title }}" 
                                 style="width: 60px; height: 40px; object-fit: cover; border-radius: 0.375rem;">
                            @else
                            <div style="width: 60px; height: 40px; background: #e5e7eb; border-radius: 0.375rem; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-image" style="color: #9ca3af;"></i>
                            </div>
                            @endif
                        </td>
                        <td>
                            <div>
                                <div style="font-weight: 600; color: #1f2937;">{{ Str::limit($listing->title, 30) }}</div>
                                <div style="color: #6b7280; font-size: 0.75rem;">{{ $listing->location ?? 'N/A' }}</div>
                            </div>
                        </td>
                        <td>
                            @if($listing->category)
                            <span style="padding: 0.25rem 0.5rem; background: #f3f4f6; border-radius: 0.25rem; font-size: 0.875rem;">
                                {{ $listing->category->name }}
                            </span>
                            @else
                            <span style="color: #9ca3af;">N/A</span>
                            @endif
                        </td>
                        <td style="font-weight: 600; color: #059669;">
                            ${{ number_format($listing->price) }}
                        </td>
                        <td>
                            @if($listing->user)
                            <div>
                                <div style="font-size: 0.875rem;">{{ $listing->user->name }}</div>
                                <div style="color: #6b7280; font-size: 0.75rem;">{{ $listing->user->email }}</div>
                            </div>
                            @else
                            <span style="color: #9ca3af;">N/A</span>
                            @endif
                        </td>
                        <td>
                            @if($listing->status == 'approved')
                            <span style="display: inline-flex; align-items: center; gap: 0.25rem; padding: 0.25rem 0.75rem; background: #d1fae5; color: #065f46; border-radius: 1rem; font-size: 0.75rem; font-weight: 600;">
                                <i class="fas fa-check-circle"></i> Approved
                            </span>
                            @elseif($listing->status == 'pending')
                            <span style="display: inline-flex; align-items: center; gap: 0.25rem; padding: 0.25rem 0.75rem; background: #fed7aa; color: #92400e; border-radius: 1rem; font-size: 0.75rem; font-weight: 600;">
                                <i class="fas fa-clock"></i> Pending
                            </span>
                            @else
                            <span style="display: inline-flex; align-items: center; gap: 0.25rem; padding: 0.25rem 0.75rem; background: #fee2e2; color: #991b1b; border-radius: 1rem; font-size: 0.75rem; font-weight: 600;">
                                <i class="fas fa-times-circle"></i> Rejected
                            </span>
                            @endif
                        </td>
                        <td>{{ $listing->views ?? 0 }}</td>
                        <td>{{ $listing->created_at->format('M d, Y') }}</td>
                        <td>
                            <div style="display: flex; gap: 0.25rem;">
                                <a href="{{ route('listings.show', $listing) }}" target="_blank" class="btn btn-sm" 
                                   style="padding: 0.25rem 0.5rem; font-size: 0.75rem; background: #3b82f6; color: white;" 
                                   title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                @if($listing->status == 'pending')
                                <form method="POST" action="{{ route('admin.listings.approve', $listing) }}" style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm" 
                                            style="padding: 0.25rem 0.5rem; font-size: 0.75rem; background: #10b981; color: white;"
                                            title="Approve">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                
                                <button onclick="showRejectModal({{ $listing->id }})" class="btn btn-sm" 
                                        style="padding: 0.25rem 0.5rem; font-size: 0.75rem; background: #ef4444; color: white;"
                                        title="Reject">
                                    <i class="fas fa-times"></i>
                                </button>
                                @endif
                                
                                <form method="POST" action="{{ route('admin.listings.destroy', $listing) }}" style="display: inline;"
                                      onsubmit="return confirm('Are you sure you want to delete this listing?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm" 
                                            style="padding: 0.25rem 0.5rem; font-size: 0.75rem; background: #dc2626; color: white;"
                                            title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" style="text-align: center; padding: 3rem; color: #6b7280;">
                            <i class="fas fa-car" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.3;"></i>
                            <p>No listings found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($listings->hasPages())
        <div style="padding: 1.5rem; border-top: 1px solid #e5e7eb;">
            {{ $listings->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 1rem; padding: 2rem; max-width: 500px; width: 90%;">
        <h3 style="margin-bottom: 1rem;">Reject Listing</h3>
        <form id="rejectForm" method="POST">
            @csrf
            @method('PATCH')
            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Rejection Reason:</label>
                <textarea name="rejection_reason" required 
                          style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; min-height: 100px;"
                          placeholder="Please provide a reason for rejection..."></textarea>
            </div>
            <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                <button type="button" onclick="hideRejectModal()" class="btn btn-secondary">Cancel</button>
                <button type="submit" class="btn" style="background: #ef4444; color: white;">Reject Listing</button>
            </div>
        </form>
    </div>
</div>

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
