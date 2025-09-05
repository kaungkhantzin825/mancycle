@extends('layouts.mancycle')

@section('title', 'Categories - ManCycle')

@section('content')
<!-- Categories Header -->
<section style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 3rem 0;">
    <div class="container">
        <h1 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 1rem; text-align: center;">Browse Categories</h1>
        <p style="font-size: 1.25rem; text-align: center; opacity: 0.9;">Find exactly what you're looking for</p>
    </div>
</section>

<!-- Categories Grid -->
<section style="padding: 4rem 0; background: #f8fafc;">
    <div class="container">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2rem;">
            @foreach($categories as $category)
            <div class="category-section">
                <div class="category-header">
                    <div class="category-icon">
                        <i class="{{ $category->icon ?? 'fas fa-tag' }}"></i>
                    </div>
                    <div>
                        <h2 class="category-title">{{ $category->name }}</h2>
                        <p class="category-description">{{ $category->description }}</p>
                    </div>
                </div>
                
                @if($category->children->count() > 0)
                <div class="subcategories">
                    @foreach($category->children as $subcategory)
                    <a href="{{ route('categories.show', $subcategory->slug) }}" class="subcategory-item">
                        <span>{{ $subcategory->name }}</span>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                    @endforeach
                </div>
                @endif
                
                <div class="category-footer">
                    <a href="{{ route('categories.show', $category->slug) }}" class="btn btn-primary">
                        Browse All {{ $category->name }}
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Popular Categories Stats -->
<section style="background: white; padding: 3rem 0;">
    <div class="container">
        <h2 style="text-align: center; font-size: 2rem; font-weight: 700; margin-bottom: 3rem; color: #1f2937;">Popular This Week</h2>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 2rem;">
            <div class="stat-item">
                <div class="stat-number">1,247</div>
                <div class="stat-label">Cars Listed</div>
                <div class="stat-icon">
                    <i class="fas fa-car"></i>
                </div>
            </div>
            
            <div class="stat-item">
                <div class="stat-number">856</div>
                <div class="stat-label">Motorcycles</div>
                <div class="stat-icon">
                    <i class="fas fa-motorcycle"></i>
                </div>
            </div>
            
            <div class="stat-item">
                <div class="stat-number">2,134</div>
                <div class="stat-label">Second Hand Items</div>
                <div class="stat-icon">
                    <i class="fas fa-box"></i>
                </div>
            </div>
            
            <div class="stat-item">
                <div class="stat-number">4,237</div>
                <div class="stat-label">Total Listings</div>
                <div class="stat-icon">
                    <i class="fas fa-list"></i>
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
.category-section {
    background: white;
    border-radius: 1rem;
    padding: 2rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.category-section:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
}

.category-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #e5e7eb;
}

.category-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.category-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 0.25rem;
}

.category-description {
    color: #6b7280;
    font-size: 0.875rem;
}

.subcategories {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    margin-bottom: 1.5rem;
}

.subcategory-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 1rem;
    background: #f8fafc;
    border-radius: 0.5rem;
    text-decoration: none;
    color: #374151;
    transition: all 0.3s ease;
    font-size: 0.875rem;
}

.subcategory-item:hover {
    background: #e5e7eb;
    color: #667eea;
    transform: translateX(5px);
}

.category-footer {
    text-align: center;
}

.stat-item {
    text-align: center;
    padding: 1.5rem;
    background: #f8fafc;
    border-radius: 1rem;
    position: relative;
    overflow: hidden;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 800;
    color: #1f2937;
    margin-bottom: 0.5rem;
}

.stat-label {
    color: #6b7280;
    font-weight: 500;
}

.stat-icon {
    position: absolute;
    top: 1rem;
    right: 1rem;
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    opacity: 0.8;
}

@media (max-width: 768px) {
    .category-section {
        padding: 1.5rem;
    }
    
    .category-header {
        flex-direction: column;
        text-align: center;
    }
    
    .stat-item {
        padding: 1rem;
    }
    
    .stat-number {
        font-size: 2rem;
    }
}
</style>
@endpush
@endsection