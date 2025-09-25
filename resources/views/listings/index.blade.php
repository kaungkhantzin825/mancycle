@extends('layouts.mancycle')

@section('title', 'Browse Listings - ManCycle')

@section('content')
<!-- Search Header -->
<section style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 3rem 0;">
    <div class="container">
        <h1 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 2rem; text-align: center;">Browse Listings</h1>
        
        <!-- Advanced Search Bar -->
        <div style="max-width: 1200px; margin: 0 auto;">
            <form method="GET" action="{{ route('listings.index') }}" class="search-form" style="background: white; border-radius: 1rem; padding: 2rem; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);">
                <!-- First Row: Search, Category, Region, City -->
                <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div>
                        <label style="display: block; color: #374151; font-weight: 600; margin-bottom: 0.5rem; font-size: 0.875rem;">Search Keywords</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search for cars, motorcycles, parts..." 
                               style="width: 100%; padding: 0.875rem; border: 2px solid #e5e7eb; border-radius: 0.5rem; font-size: 1rem; transition: border-color 0.3s ease;"
                               onfocus="this.style.borderColor='#f59e0b'" onblur="this.style.borderColor='#e5e7eb'">
                    </div>
                    
                    <div>
                        <label style="display: block; color: #374151; font-weight: 600; margin-bottom: 0.5rem; font-size: 0.875rem;">Category</label>
                        <select name="category" style="width: 100%; padding: 0.875rem; border: 2px solid #e5e7eb; border-radius: 0.5rem; font-size: 1rem; cursor: pointer;">
                            <option value="">All Categories</option>
                            @php
                                $categories = App\Models\Category::where('is_active', true)->whereNull('parent_id')->get();
                            @endphp
                            @foreach($categories as $cat)
                                <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label style="display: block; color: #374151; font-weight: 600; margin-bottom: 0.5rem; font-size: 0.875rem;">Region/State</label>
                        <select name="region_id" id="filter_region_id" style="width: 100%; padding: 0.875rem; border: 2px solid #e5e7eb; border-radius: 0.5rem; font-size: 1rem; cursor: pointer;">
                            <option value="">All Regions</option>
                            @php
                                $regions = App\Models\Location::whereNull('parent_id')->where('is_active', true)->orderBy('name')->get();
                            @endphp
                            @foreach($regions as $reg)
                                <option value="{{ $reg->id }}" {{ request('region_id') == $reg->id ? 'selected' : '' }}>{{ $reg->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label style="display: block; color: #374151; font-weight: 600; margin-bottom: 0.5rem; font-size: 0.875rem;">City</label>
                        <select name="location_id" id="filter_location_id" style="width: 100%; padding: 0.875rem; border: 2px solid #e5e7eb; border-radius: 0.5rem; font-size: 1rem; cursor: pointer;" {{ request('region_id') ? '' : 'disabled' }}>
                            <option value="">{{ request('region_id') ? 'Loading...' : 'First select Region' }}</option>
                        </select>
                    </div>
                </div>
                
                <!-- Second Row: Price Range, Condition, Sort -->
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr 150px; gap: 1rem; align-items: end;">
                    <div>
                        <label style="display: block; color: #374151; font-weight: 600; margin-bottom: 0.5rem; font-size: 0.875rem;">Min Price</label>
                        <div style="position: relative;">
                            <span style="position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%); color: #6b7280;">MMK</span>
                            <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="0" min="0"
                                   style="width: 100%; padding: 0.875rem 0.875rem 0.875rem 3.25rem; border: 2px solid #e5e7eb; border-radius: 0.5rem; font-size: 1rem;">
                        </div>
                    </div>
                    
                    <div>
                        <label style="display: block; color: #374151; font-weight: 600; margin-bottom: 0.5rem; font-size: 0.875rem;">Max Price</label>
                        <div style="position: relative;">
                            <span style="position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%); color: #6b7280;">MMK</span>
                            <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Any" min="0"
                                   style="width: 100%; padding: 0.875rem 0.875rem 0.875rem 3.25rem; border: 2px solid #e5e7eb; border-radius: 0.5rem; font-size: 1rem;">
                        </div>
                    </div>
                    
                    <div>
                        <label style="display: block; color: #374151; font-weight: 600; margin-bottom: 0.5rem; font-size: 0.875rem;">Condition</label>
                        <select name="condition" style="width: 100%; padding: 0.875rem; border: 2px solid #e5e7eb; border-radius: 0.5rem; font-size: 1rem; cursor: pointer;">
                            <option value="">Any Condition</option>
                            <option value="new" {{ request('condition') == 'new' ? 'selected' : '' }}>New</option>
                            <option value="excellent" {{ request('condition') == 'excellent' ? 'selected' : '' }}>Excellent</option>
                            <option value="good" {{ request('condition') == 'good' ? 'selected' : '' }}>Good</option>
                            <option value="fair" {{ request('condition') == 'fair' ? 'selected' : '' }}>Fair</option>
                            <option value="poor" {{ request('condition') == 'poor' ? 'selected' : '' }}>Poor</option>
                        </select>
                    </div>
                    
                    <div>
                        <label style="display: block; color: #374151; font-weight: 600; margin-bottom: 0.5rem; font-size: 0.875rem;">Sort By</label>
                        <select name="sort" style="width: 100%; padding: 0.875rem; border: 2px solid #e5e7eb; border-radius: 0.5rem; font-size: 1rem; cursor: pointer;">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest First</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary" style="height: fit-content; padding: 0.875rem 2rem; font-weight: 600; display: flex; align-items: center; gap: 0.5rem; justify-content: center;">
                        <i class="fas fa-search"></i>
                        Search
                    </button>
                </div>
                
                <!-- Quick Filters -->
                <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #e5e7eb;">
                    <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
                        <span style="color: #6b7280; font-size: 0.875rem;">Quick Filters:</span>
                        <a href="{{ route('listings.index') }}?condition=new" class="quick-filter">🆕 New Only</a>
                        <a href="{{ route('listings.index') }}?max_price=10000" class="quick-filter">💰 Under MMK 10,000</a>
                        <a href="{{ route('listings.index') }}?category=cars" class="quick-filter">🚗 Cars Only</a>
                        <a href="{{ route('listings.index') }}?category=motorcycles" class="quick-filter">🏍️ Motorcycles Only</a>
                        <a href="{{ route('listings.index') }}" class="quick-filter" style="color: #ef4444;">❌ Clear All</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Listings Results -->
<section style="padding: 3rem 0; background: #f8fafc;">
    <div class="container">
        <!-- Results Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; background: white; padding: 1rem 1.5rem; border-radius: 0.75rem; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);">
            <div>
                <h2 style="font-size: 1.25rem; font-weight: 600; color: #1f2937; margin: 0;">Search Results</h2>
                <p style="color: #6b7280; margin: 0.25rem 0 0 0;">Found {{ $listings->total() }} listings matching your criteria</p>
            </div>
            <div style="display: flex; align-items: center; gap: 1rem;">
                <span style="color: #6b7280; font-size: 0.875rem;">View:</span>
                <button onclick="toggleView('grid')" id="gridBtn" class="view-btn active">
                    <i class="fas fa-th-large"></i> Grid
                </button>
                <button onclick="toggleView('list')" id="listBtn" class="view-btn">
                    <i class="fas fa-list"></i> List
                </button>
            </div>
        </div>
                
        <!-- Listings Grid -->
        <div id="listingsContainer" class="listing-grid">
                    @forelse($listings as $listing)
                    <div class="listing-card">
                        <div class="listing-image">
                            @if($listing->is_featured)
                                <div class="listing-badge">Featured</div>
                            @elseif($listing->created_at->diffInDays() < 7)
                                <div class="listing-badge">New</div>
                            @endif
                            
                            @if($listing->images && json_decode($listing->images) && count(json_decode($listing->images)) > 0)
                                <img src="{{ json_decode($listing->images)[0] }}" alt="{{ $listing->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <div style="background: linear-gradient(45deg, #667eea, #764ba2); height: 100%; display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                                    @if($listing->category->type === 'cars')
                                        <i class="fas fa-car"></i>
                                    @elseif($listing->category->type === 'motorcycles')
                                        <i class="fas fa-motorcycle"></i>
                                    @else
                                        <i class="fas fa-box"></i>
                                    @endif
                                </div>
                            @endif
                        </div>
                        <div class="listing-content">
                            <h3 class="listing-title">{{ $listing->title }}</h3>
                            <div class="listing-price">MMK {{ number_format($listing->price) }}</div>
                            <div class="listing-location">
                                <i class="fas fa-map-marker-alt"></i>
                                {{ $listing->location }}
                            </div>
                            <div style="margin-top: 1rem; display: flex; gap: 0.5rem;">
                                <button class="btn" style="flex: 1; background: #f3f4f6; color: #374151; padding: 0.5rem;">
                                    <i class="fas fa-heart"></i>
                                </button>
                                <a href="{{ route('listings.show', $listing) }}" class="btn btn-primary" style="flex: 3; padding: 0.5rem; text-align: center; text-decoration: none;">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div style="grid-column: 1 / -1; text-align: center; padding: 3rem;">
                        <p style="color: #6b7280; font-size: 1.125rem;">No listings found.</p>
                    </div>
                    @endforelse
        </div>
        
        <!-- Pagination -->
        <div style="margin-top: 3rem; display: flex; justify-content: center;">
            {{ $listings->withQueryString()->links() }}
        </div>
    </div>
</section>

@push('styles')
<style>
/* Quick Filter Styles */
.quick-filter {
    display: inline-block;
    padding: 0.5rem 1rem;
    background: #f3f4f6;
    color: #374151;
    text-decoration: none;
    border-radius: 20px;
    font-size: 0.875rem;
    transition: all 0.3s ease;
    border: 1px solid #e5e7eb;
}

.quick-filter:hover {
    background: #f59e0b;
    color: white;
    border-color: #f59e0b;
    transform: translateY(-2px);
    box-shadow: 0 4px 6px -1px rgba(245, 158, 11, 0.2);
}

/* View Toggle Buttons */
.view-btn {
    padding: 0.5rem;
    border: 1px solid #d1d5db;
    background: white;
    border-radius: 0.375rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.view-btn.active {
    background: #667eea;
    color: white;
    border-color: #667eea;
}

.view-btn:hover {
    background: #f3f4f6;
}

.view-btn.active:hover {
    background: #5a67d8;
}

.listing-grid.list-view .listing-card {
    display: flex;
    flex-direction: row;
}

.listing-grid.list-view .listing-image {
    width: 200px;
    flex-shrink: 0;
}

.listing-grid.list-view .listing-content {
    flex: 1;
}

@media (max-width: 768px) {
    .container > div {
        grid-template-columns: 1fr !important;
    }
    
    .search-form > div {
        grid-template-columns: 1fr !important;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const regionSelect = document.getElementById('filter_region_id');
    const citySelect = document.getElementById('filter_location_id');
    const initialRegionId = '{{ request('region_id') }}';
    const initialCityId = '{{ request('location_id') }}';

    function loadCities(regionId, preselectId = null) {
        if (!regionId) {
            citySelect.innerHTML = '<option value="">First select Region</option>';
            citySelect.disabled = true;
            return;
        }
        citySelect.disabled = true;
        citySelect.innerHTML = '<option value="">Loading...</option>';
        fetch(`/api/locations/descendants?region_id=${regionId}`)
            .then(r => {
                if (!r.ok) throw new Error('HTTP ' + r.status);
                return r.json();
            })
            .then(list => {
                citySelect.innerHTML = '<option value="">All Cities</option>';
                list.forEach(item => {
                    const opt = document.createElement('option');
                    opt.value = item.id;
                    opt.textContent = item.name;
                    citySelect.appendChild(opt);
                });
                citySelect.disabled = false;
                if (preselectId) {
                    citySelect.value = preselectId;
                }
            })
            .catch(err => {
                console.error('Failed to load cities:', err);
                citySelect.innerHTML = '<option value="">Error loading cities</option>';
            });
    }

    regionSelect.addEventListener('change', function () {
        loadCities(this.value);
    });

    // If page loaded with a region filter, populate cities and preselect
    if (initialRegionId) {
        loadCities(initialRegionId, initialCityId || null);
    }
});
</script>
@endpush

@push('scripts')
<script>
function toggleView(view) {
    const container = document.getElementById('listingsContainer');
    const gridBtn = document.getElementById('gridBtn');
    const listBtn = document.getElementById('listBtn');
    
    if (view === 'list') {
        container.classList.add('list-view');
        container.style.gridTemplateColumns = '1fr';
        listBtn.classList.add('active');
        gridBtn.classList.remove('active');
    } else {
        container.classList.remove('list-view');
        container.style.gridTemplateColumns = '';
        gridBtn.classList.add('active');
        listBtn.classList.remove('active');
    }
}

// Add responsive behavior
window.addEventListener('resize', function() {
    if (window.innerWidth < 768) {
        const container = document.getElementById('listingsContainer');
        container.classList.remove('list-view');
        document.getElementById('gridBtn').classList.add('active');
        document.getElementById('listBtn').classList.remove('active');
    }
});
</script>
@endpush

@endsection
