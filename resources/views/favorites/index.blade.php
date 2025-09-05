@extends('layouts.mancycle')

@section('title', 'My Favorites - ManCycle')

@section('content')
<!-- Header -->
<section style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; padding: 3rem 0;">
    <div class="container">
        <h1 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 0.5rem;">My Favorites</h1>
        <p style="opacity: 0.9;">Items you've saved for later</p>
    </div>
</section>

<!-- Favorites Grid -->
<section style="padding: 2rem 0; background: #f8fafc; min-height: 60vh;">
    <div class="container">
        @if($favorites->count() > 0)
            <div class="listing-grid">
                @foreach($favorites as $favorite)
                <div class="listing-card">
                    <div class="listing-image">
                        <div class="listing-badge">Favorite</div>
                        <div style="background: linear-gradient(45deg, #ef4444, #dc2626); height: 100%; display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                            <i class="fas fa-heart"></i>
                        </div>
                    </div>
                    <div class="listing-content">
                        <h3 class="listing-title">{{ $favorite->listing->title }}</h3>
                        <div class="listing-price">${{ number_format($favorite->listing->price) }}</div>
                        <div class="listing-location">
                            <i class="fas fa-map-marker-alt"></i>
                            {{ $favorite->listing->location }}
                        </div>
                        <div style="margin-top: 1rem; display: flex; gap: 0.5rem;">
                            <button onclick="removeFavorite({{ $favorite->listing->id }})" class="btn" style="flex: 1; background: #ef4444; color: white; padding: 0.5rem;">
                                <i class="fas fa-heart-broken"></i>
                                Remove
                            </button>
                            <a href="{{ route('listings.show', $favorite->listing) }}" class="btn btn-primary" style="flex: 3; padding: 0.5rem; text-align: center;">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div style="margin-top: 3rem; display: flex; justify-content: center;">
                {{ $favorites->links() }}
            </div>
        @else
            <div style="text-align: center; padding: 4rem 0;">
                <i class="fas fa-heart" style="font-size: 4rem; color: #d1d5db; margin-bottom: 1rem;"></i>
                <h2 style="font-size: 1.5rem; color: #6b7280; margin-bottom: 0.5rem;">No favorites yet</h2>
                <p style="color: #9ca3af; margin-bottom: 2rem;">Start browsing and save items you like!</p>
                <a href="{{ route('listings.index') }}" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                    Browse Listings
                </a>
            </div>
        @endif
    </div>
</section>

@push('styles')
<style>
.listing-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
}

.listing-card {
    background: white;
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.listing-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
}

.listing-image {
    height: 200px;
    position: relative;
    overflow: hidden;
}

.listing-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: #f59e0b;
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 1rem;
    font-size: 0.875rem;
    font-weight: 600;
}

.listing-content {
    padding: 1.5rem;
}

.listing-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.listing-price {
    font-size: 1.5rem;
    font-weight: 700;
    color: #059669;
    margin-bottom: 0.5rem;
}

.listing-location {
    color: #6b7280;
    font-size: 0.875rem;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}
</style>
@endpush

@push('scripts')
<script>
async function removeFavorite(listingId) {
    try {
        const response = await fetch(`/favorites/${listingId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            }
        });

        const data = await response.json();
        
        if (data.success) {
            location.reload(); // Refresh the page to update the list
        } else {
            alert(data.message || 'Error removing from favorites');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error removing from favorites');
    }
}
</script>
@endpush
@endsection