@extends('layouts.mancycle')

@section('title', 'ManCycle - Buy & Sell Cars, Motorcycles & More')

@section('content')
<!-- Hero Section -->
<section class="hero-modern">
    <div class="hero-background">
        <div class="hero-overlay"></div>
        <div class="hero-pattern"></div>
    </div>
    
    <div class="container">
        <div class="hero-content">
            <div class="hero-text">
                <h1 class="hero-title">Find Your Perfect Vehicle</h1>
                <p class="hero-subtitle">Discover premium cars, motorcycles, and quality second-hand products from verified sellers across the country</p>
                
                <div class="hero-stats">
                    <div class="stat-item">
                        <span class="stat-number">10K+</span>
                        <span class="stat-label">Vehicles</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">5K+</span>
                        <span class="stat-label">Happy Customers</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">50+</span>
                        <span class="stat-label">Cities</span>
                    </div>
                </div>
            </div>
            
            <div class="hero-search">
                <div class="search-container">
                    <h3>What are you looking for?</h3>
                    
                    <div class="search-tabs">
                        <button class="search-tab active" data-tab="all">All Categories</button>
                        <button class="search-tab" data-tab="cars">Cars</button>
                        <button class="search-tab" data-tab="motorcycles">Motorcycles</button>
                        <button class="search-tab" data-tab="second_hand">Second Hand</button>
                    </div>
                    
                    <form class="advanced-search" method="GET" action="{{ route('listings.index') }}">
                        <div class="search-row">
                            <div class="search-field">
                                <label>Search</label>
                                <input type="text" name="search" placeholder="Enter keywords..." id="searchInput">
                            </div>
                            <div class="search-field">
                                <label>Location</label>
                                <input type="text" name="location" placeholder="Enter city or area">
                            </div>
                        </div>
                        
                        <div class="search-row">
                            <div class="search-field">
                                <label>Price Range</label>
                                <div class="price-inputs">
                                    <input type="number" name="min_price" placeholder="Min">
                                    <span>to</span>
                                    <input type="number" name="max_price" placeholder="Max">
                                </div>
                            </div>
                            <div class="search-field">
                                <label>Condition</label>
                                <select name="condition">
                                    <option value="">Any Condition</option>
                                    <option value="new">New</option>
                                    <option value="excellent">Excellent</option>
                                    <option value="good">Good</option>
                                    <option value="fair">Fair</option>
                                </select>
                            </div>
                        </div>
                        
                        <button type="submit" class="search-btn">
                            <i class="fas fa-search"></i>
                            Search Vehicles
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="categories">
    <div class="container">
        <h2 class="section-title">Browse by Category</h2>
        
        <div class="category-grid">
            <div class="category-card">
                <i class="fas fa-car"></i>
                <h3>Cars</h3>
                <p>Find your dream car from sedans to SUVs</p>
                <a href="{{ route('categories.show', 'cars') }}" class="btn btn-primary">Browse Cars</a>
            </div>
            
            <div class="category-card">
                <i class="fas fa-motorcycle"></i>
                <h3>Motorcycles</h3>
                <p>Explore bikes, scooters, and motorcycles</p>
                <a href="{{ route('categories.show', 'motorcycles') }}" class="btn btn-primary">Browse Bikes</a>
            </div>
            
            <div class="category-card">
                <i class="fas fa-box"></i>
                <h3>Parts & Accessories</h3>
                <p>Quality pre-owned items and auto parts at great prices</p>
                <a href="{{ route('categories.show', 'parts-accessories') }}" class="btn btn-primary">Browse Items</a>
            </div>
        </div>
    </div>
</section>

<!-- Featured Listings Section -->
<section class="featured">
    <div class="container">
        <h2 class="section-title">Featured Listings</h2>
        
        <div class="listing-grid">
            @forelse($featuredListings->take(6) as $listing)
            <a href="{{ route('listings.show', $listing) }}" class="listing-card" style="text-decoration: none; color: inherit;">
                <div class="listing-image">
                    @if($listing->is_featured)
                    <div class="listing-badge">Featured</div>
                    @elseif($listing->created_at->diffInDays() < 7)
                    <div class="listing-badge">New</div>
                    @endif
                    
                    @php
                        $images = $listing->images ? json_decode($listing->images, true) : [];
                        $firstImage = $images[0] ?? null;
                    @endphp
                    @if($firstImage)
                        <img src="{{ $firstImage }}" 
                             alt="{{ $listing->title }}" 
                             style="width: 100%; height: 100%; object-fit: cover;"
                             onerror="this.onerror=null; this.src='https://via.placeholder.com/800x600/6b7280/ffffff?text=No+Image';">
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
                    <div class="listing-price">${{ number_format($listing->price) }}</div>
                    <div class="listing-location">
                        <i class="fas fa-map-marker-alt"></i>
                        {{ $listing->location }}
                    </div>
                </div>
            </a>
            @empty
            <!-- Sample listing if no data -->
            <div class="listing-card">
                <div class="listing-image">
                    <div class="listing-badge">Featured</div>
                    <div style="background: linear-gradient(45deg, #667eea, #764ba2); height: 100%; display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                        <i class="fas fa-car"></i>
                    </div>
                </div>
                <div class="listing-content">
                    <h3 class="listing-title">No listings available</h3>
                    <div class="listing-price">$0</div>
                    <div class="listing-location">
                        <i class="fas fa-map-marker-alt"></i>
                        N/A
                    </div>
                </div>
            </div>
            @endforelse
        </div>
        
        <div style="text-align: center; margin-top: 3rem;">
            <a href="{{ route('listings.index') }}" class="btn btn-primary">View All Listings</a>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 4rem 0;">
    <div class="container">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 2rem; text-align: center;">
            <div>
                <div style="font-size: 3rem; font-weight: 800; margin-bottom: 0.5rem;">10K+</div>
                <div style="font-size: 1.25rem; opacity: 0.9;">Active Listings</div>
            </div>
            <div>
                <div style="font-size: 3rem; font-weight: 800; margin-bottom: 0.5rem;">5K+</div>
                <div style="font-size: 1.25rem; opacity: 0.9;">Happy Customers</div>
            </div>
            <div>
                <div style="font-size: 3rem; font-weight: 800; margin-bottom: 0.5rem;">50+</div>
                <div style="font-size: 1.25rem; opacity: 0.9;">Cities Covered</div>
            </div>
            <div>
                <div style="font-size: 3rem; font-weight: 800; margin-bottom: 0.5rem;">24/7</div>
                <div style="font-size: 1.25rem; opacity: 0.9;">Customer Support</div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section style="padding: 4rem 0; background: white;">
    <div class="container">
        <h2 class="section-title">How ManCycle Works</h2>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 3rem; margin-top: 3rem;">
            <div style="text-align: center;">
                <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; color: white; font-size: 2rem;">
                    <i class="fas fa-search"></i>
                </div>
                <h3 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1rem;">Browse & Search</h3>
                <p style="color: #6b7280;">Explore thousands of listings or use our advanced search to find exactly what you're looking for.</p>
            </div>
            
            <div style="text-align: center;">
                <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; color: white; font-size: 2rem;">
                    <i class="fas fa-comments"></i>
                </div>
                <h3 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1rem;">Connect & Chat</h3>
                <p style="color: #6b7280;">Message sellers directly through our secure chat system to ask questions and negotiate.</p>
            </div>
            
            <div style="text-align: center;">
                <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; color: white; font-size: 2rem;">
                    <i class="fas fa-handshake"></i>
                </div>
                <h3 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1rem;">Meet & Buy</h3>
                <p style="color: #6b7280;">Arrange a safe meeting, inspect the item, and complete your purchase with confidence.</p>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
.hero-modern {
    position: relative;
    min-height: 80vh;
    display: flex;
    align-items: center;
    overflow: hidden;
}

.hero-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.3);
}

.hero-pattern {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: 
        radial-gradient(circle at 25% 25%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 75% 75%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
    background-size: 100px 100px;
}

.hero-content {
    position: relative;
    z-index: 10;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 4rem;
    align-items: center;
}

.hero-text {
    color: white;
}

.hero-title {
    font-size: 3.5rem;
    font-weight: 800;
    line-height: 1.1;
    margin-bottom: 1.5rem;
    background: linear-gradient(135deg, #ffffff 0%, #f3f4f6 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.hero-subtitle {
    font-size: 1.25rem;
    line-height: 1.6;
    margin-bottom: 2rem;
    opacity: 0.9;
}

.hero-stats {
    display: flex;
    gap: 2rem;
}

.stat-item {
    text-align: center;
}

.stat-number {
    display: block;
    font-size: 2rem;
    font-weight: 800;
    color: #fbbf24;
}

.stat-label {
    font-size: 0.875rem;
    opacity: 0.8;
}

.hero-search {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
}

.search-container h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 1.5rem;
    text-align: center;
}

.search-tabs {
    display: flex;
    background: #f3f4f6;
    border-radius: 12px;
    padding: 4px;
    margin-bottom: 2rem;
}

.search-tab {
    flex: 1;
    padding: 0.75rem 1rem;
    border: none;
    background: transparent;
    border-radius: 8px;
    font-weight: 500;
    font-size: 0.875rem;
    color: #6b7280;
    cursor: pointer;
    transition: all 0.3s ease;
}

.search-tab.active {
    background: white;
    color: #f59e0b;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.advanced-search {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.search-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.search-field {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.search-field label {
    font-weight: 600;
    color: #374151;
    font-size: 0.875rem;
}

.search-field input,
.search-field select {
    padding: 0.875rem 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 0.95rem;
    transition: all 0.3s ease;
}

.search-field input:focus,
.search-field select:focus {
    outline: none;
    border-color: #f59e0b;
    box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
}

.price-inputs {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.price-inputs input {
    flex: 1;
}

.price-inputs span {
    color: #6b7280;
    font-weight: 500;
}

.search-btn {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
    border: none;
    padding: 1rem 2rem;
    border-radius: 12px;
    font-size: 1.1rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    margin-top: 1rem;
}

.search-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(245, 158, 11, 0.3);
}

@media (max-width: 768px) {
    .hero-content {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .hero-title {
        font-size: 2.5rem;
    }
    
    .search-row {
        grid-template-columns: 1fr;
    }
    
    .search-tabs {
        flex-wrap: wrap;
    }
    
    .search-tab {
        min-width: 120px;
    }
}
</style>
@endpush

@push('scripts')
<script>
// Search tab functionality
document.querySelectorAll('.search-tab').forEach(tab => {
    tab.addEventListener('click', function() {
        document.querySelectorAll('.search-tab').forEach(t => t.classList.remove('active'));
        this.classList.add('active');
        
        const category = this.dataset.tab;
        const form = document.querySelector('.advanced-search');
        
        // Add hidden input for category
        let categoryInput = form.querySelector('input[name="category"]');
        if (!categoryInput) {
            categoryInput = document.createElement('input');
            categoryInput.type = 'hidden';
            categoryInput.name = 'category';
            form.appendChild(categoryInput);
        }
        
        categoryInput.value = category === 'all' ? '' : category;
    });
});
</script>
@endpush
@endsection