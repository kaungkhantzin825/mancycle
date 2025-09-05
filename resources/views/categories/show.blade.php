@extends('layouts.mancycle')

@section('title', $category->name . ' - ManCycle')

@section('content')
<!-- Category Header -->
<section style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 3rem 0;">
    <div class="container">
        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
            <div style="width: 60px; height: 60px; background: rgba(255,255,255,0.2); border-radius: 1rem; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                <i class="{{ $category->icon ?? 'fas fa-tag' }}"></i>
            </div>
            <div>
                <h1 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 0.25rem;">{{ $category->name }}</h1>
                @if($category->parent)
                <p style="opacity: 0.8;">{{ $category->parent->name }} > {{ $category->name }}</p>
                @endif
            </div>
        </div>
        
        @if($category->description)
        <p style="font-size: 1.125rem; opacity: 0.9;">{{ $category->description }}</p>
        @endif
    </div>
</section>

<!-- Subcategories (if any) -->
@if($subcategories->count() > 0)
<section style="padding: 2rem 0; background: white;">
    <div class="container">
        <h2 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1.5rem; color: #1f2937;">Subcategories</h2>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
            @foreach($subcategories as $subcategory)
            <a href="{{ route('categories.show', $subcategory->slug) }}" class="subcategory-card">
                <i class="{{ $subcategory->icon ?? 'fas fa-tag' }}"></i>
                <span>{{ $subcategory->name }}</span>
                <i class="fas fa-arrow-right"></i>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Listings -->
<section style="padding: 2rem 0; background: #f8fafc;">
    <div class="container">
        <div style="display: flex; justify-content: between; align-items: center; margin-bottom: 2rem;">
            <h2 style="font-size: 1.5rem; font-weight: 600; color: #1f2937;">
                {{ $category->name }} Listings ({{ $listings->total() }})
            </h2>
            
            <!-- Sort Options -->
            <div style="display: flex; gap: 0.5rem;">
                <select onchange="window.location.href=this.value" style="padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                    <option value="{{ route('categories.show', $category->slug) }}">Latest</option>
                    <option value="{{ route('categories.show', $category->slug) }}?sort=price_low">Price: Low to High</option>
                    <option value="{{ route('categories.show', $category->slug) }}?sort=price_high">Price: High to Low</option>
                    <option value="{{ route('categories.show', $category->slug) }}?sort=popular">Most Popular</option>
                </select>
            </div>
        </div>
        
        @if($listings->count() > 0)
        <div class="listing-grid">
            @foreach($listings as $listing)
            <div class="listing-card">
                <div class="listing-image">
                    @if($listing->is_featured)
                    <div class="listing-badge">Featured</div>
                    @endif
                    <div style="background: linear-gradient(45deg, #667eea, #764ba2); height: 100%; display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                        @if($category->type === 'cars')
                        <i class="fas fa-car"></i>
                        @elseif($category->type === 'motorcycles')
                        <i class="fas fa-motorcycle"></i>
                        @else
                        <i class="fas fa-box"></i>
                        @endif
                    </div>
                </div>
                <div class="listing-content">
                    <h3 class="listing-title">{{ $listing->title }}</h3>
                    <div class="listing-price">${{ number_format($listing->price) }}</div>
                    <div class="listing-location">
                        <i class="fas fa-map-marker-alt"></i>
                        {{ $listing->location }}
                    </div>
                    <div style="margin-top: 1rem; display: flex; gap: 0.5rem;">
                        @auth
                        <button onclick="toggleFavorite({{ $listing->id }})" class="btn" style="flex: 1; background: #f3f4f6; color: #374151; padding: 0.5rem;">
                            <i class="fas fa-heart"></i>
                        </button>
                        @endauth
                        <a href="{{ route('listings.show', $listing) }}" class="btn btn-primary" style="flex: 3; padding: 0.5rem; text-align: center;">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div style="margin-top: 3rem; display: flex; justify-content: center;">
            {{ $listings->links() }}
        </div>
        @else
        <div style="text-align: center; padding: 4rem 0;">
            <i class="fas fa-search" style="font-size: 4rem; color: #d1d5db; margin-bottom: 1rem;"></i>
            <h3 style="font-size: 1.5rem; color: #6b7280; margin-bottom: 0.5rem;">No listings found</h3>
            <p style="color: #9ca3af; margin-bottom: 2rem;">Be the first to list an item in this category!</p>
            @auth
            <a href="{{ route('listings.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Create Listing
            </a>
            @else
            <a href="{{ route('register') }}" class="btn btn-primary">
                <i class="fas fa-user-plus"></i>
                Sign Up to Sell
            </a>
            @endauth
        </div>
        @endif
    </div>
</section>

@push('styles')
<style>
.subcategory-card {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem;
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    text-decoration: none;
    color: #374151;
    transition: all 0.3s ease;
}

.subcategory-card:hover {
    background: #f8fafc;
    border-color: #667eea;
    color: #667eea;
    transform: translateY(-2px);
}

.subcategory-card i:first-child {
    color: #667eea;
}

.subcategory-card i:last-child {
    margin-left: auto;
    font-size: 0.875rem;
}

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
    color: #1f2937;
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

@media (max-width: 768px) {
    .listing-grid {
        grid-template-columns: 1fr;
    }
    
    .subcategory-card {
        padding: 0.75rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
async function toggleFavorite(listingId) {
    try {
        const response = await fetch(`/favorites/${listingId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            }
        });

        const data = await response.json();
        
        if (data.success) {
            // Update button appearance
            const button = event.target.closest('button');
            if (data.favorited) {
                button.style.background = '#ef4444';
                button.style.color = 'white';
            } else {
                button.style.background = '#f3f4f6';
                button.style.color = '#374151';
            }
        }
    } catch (error) {
        console.error('Error:', error);
    }
}
</script>
@endpush
@endsection