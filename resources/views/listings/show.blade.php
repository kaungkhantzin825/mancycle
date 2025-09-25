@extends('layouts.mancycle')

@section('title', $listing->title . ' - ManCycle')

@section('content')
<!-- Listing Header -->
<section style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 2rem 0;">
    <div class="container">
        <nav style="margin-bottom: 1rem; opacity: 0.8;">
            <a href="{{ route('home') }}" style="color: white; text-decoration: none;">Home</a>
            <span style="margin: 0 0.5rem;">></span>
            <a href="{{ route('categories.show', $listing->category->slug) }}" style="color: white; text-decoration: none;">{{ $listing->category->name }}</a>
            <span style="margin: 0 0.5rem;">></span>
            <span>{{ $listing->title }}</span>
        </nav>
        
        <h1 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 0.5rem;">{{ $listing->title }}</h1>
        <div style="display: flex; align-items: center; gap: 2rem; opacity: 0.9;">
            <span><i class="fas fa-map-marker-alt"></i> {{ $listing->location }}</span>
            <span><i class="fas fa-eye"></i> {{ $listing->views }} views</span>
            <span><i class="fas fa-clock"></i> {{ $listing->created_at->diffForHumans() }}</span>
        </div>
    </div>
</section>

<!-- Listing Content -->
<section style="padding: 2rem 0; background: #f8fafc;">
    <div class="container">
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 3rem;">
            <!-- Main Content -->
            <div>
                <!-- Image Gallery -->
                <div class="image-gallery">
                    @php
                        $images = $listing->images ? json_decode($listing->images, true) : [];
                    @endphp
                    
                    @if(count($images) > 0)
                        <!-- Main Image Display -->
                        <div class="main-image" style="position: relative; background: #f3f4f6; border-radius: 1rem; overflow: hidden; height: 500px;">
                            <img id="mainImage" 
                                 src="{{ $images[0] }}" 
                                 alt="{{ $listing->title }}" 
                                 style="width: 100%; height: 100%; object-fit: contain;"
                                 onerror="this.onerror=null; this.src='https://via.placeholder.com/800x600/6b7280/ffffff?text=Image+Not+Available';">
                        </div>
                        
                        <!-- Thumbnail Gallery -->
                        @if(count($images) > 1)
                        <div class="thumbnail-gallery" style="display: flex; gap: 0.5rem; margin-top: 1rem; overflow-x: auto;">
                            @foreach($images as $index => $image)
                            <div class="thumbnail {{ $index === 0 ? 'active' : '' }}" 
                                 onclick="changeMainImage('{{ $image }}', this)"
                                 style="flex-shrink: 0; width: 100px; height: 100px; border: 2px solid {{ $index === 0 ? '#f59e0b' : '#e5e7eb' }}; border-radius: 0.5rem; overflow: hidden; cursor: pointer; transition: all 0.3s ease;">
                                <img src="{{ $image }}" 
                                     alt="{{ $listing->title }} - Image {{ $index + 1 }}" 
                                     style="width: 100%; height: 100%; object-fit: cover;"
                                     onerror="this.onerror=null; this.src='https://via.placeholder.com/100x100/6b7280/ffffff?text=Error';">
                            </div>
                            @endforeach
                        </div>
                        @endif
                    @else
                        <!-- Fallback when no images -->
                        <div class="main-image" style="background: linear-gradient(45deg, #667eea, #764ba2); height: 400px; border-radius: 1rem; display: flex; align-items: center; justify-content: center; color: white; font-size: 4rem;">
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
                
                <!-- Description -->
                <div class="listing-section">
                    <h2>Description</h2>
                    <p>{{ $listing->description }}</p>
                </div>
                
                <!-- Specifications -->
                @if($listing->brand || $listing->model || $listing->year)
                <div class="listing-section">
                    <h2>Specifications</h2>
                    <div class="specs-grid">
                        @if($listing->brand)
                        <div class="spec-item">
                            <span class="spec-label">Brand</span>
                            <span class="spec-value">{{ $listing->brand }}</span>
                        </div>
                        @endif
                        
                        @if($listing->model)
                        <div class="spec-item">
                            <span class="spec-label">Model</span>
                            <span class="spec-value">{{ $listing->model }}</span>
                        </div>
                        @endif
                        
                        @if($listing->year)
                        <div class="spec-item">
                            <span class="spec-label">Year</span>
                            <span class="spec-value">{{ $listing->year }}</span>
                        </div>
                        @endif
                        
                        @if($listing->condition)
                        <div class="spec-item">
                            <span class="spec-label">Condition</span>
                            <span class="spec-value">{{ ucfirst($listing->condition) }}</span>
                        </div>
                        @endif
                        
                        @if($listing->mileage)
                        <div class="spec-item">
                            <span class="spec-label">Mileage</span>
                            <span class="spec-value">{{ number_format($listing->mileage) }} miles</span>
                        </div>
                        @endif
                        
                        @if($listing->fuel_type)
                        <div class="spec-item">
                            <span class="spec-label">Fuel Type</span>
                            <span class="spec-value">{{ $listing->fuel_type }}</span>
                        </div>
                        @endif
                        
                        @if($listing->transmission)
                        <div class="spec-item">
                            <span class="spec-label">Transmission</span>
                            <span class="spec-value">{{ $listing->transmission }}</span>
                        </div>
                        @endif
                        
                        @if($listing->color)
                        <div class="spec-item">
                            <span class="spec-label">Color</span>
                            <span class="spec-value">{{ $listing->color }}</span>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
            
            <!-- Sidebar -->
            <div>
                <!-- Price & Actions -->
                <div class="sidebar-card">
                    <div class="price-section">
                        <div class="price">MMK {{ number_format($listing->price) }}</div>
                        @if($listing->is_featured)
                        <div class="featured-badge">
                            <i class="fas fa-star"></i>
                            Featured
                        </div>
                        @endif
                    </div>
                    
                    <div class="action-buttons">
                        @auth
                            @if(auth()->id() !== $listing->user_id)
                            <button onclick="toggleFavorite({{ $listing->id }})" class="btn btn-secondary" style="width: 100%; margin-bottom: 1rem;">
                                <i class="fas fa-heart"></i>
                                Add to Favorites
                            </button>
                            
                            <a href="{{ route('messages.create', $listing) }}" class="btn btn-primary" style="width: 100%; text-align: center;">
                                <i class="fas fa-comment"></i>
                                Message Seller
                            </a>
                            @else
                            <a href="{{ route('listings.edit', $listing) }}" class="btn btn-primary" style="width: 100%; text-align: center;">
                                <i class="fas fa-edit"></i>
                                Edit Listing
                            </a>
                            @endif
                        @else
                        <a href="{{ route('login') }}" class="btn btn-primary" style="width: 100%; text-align: center;">
                            <i class="fas fa-sign-in-alt"></i>
                            Login to Contact
                        </a>
                        @endauth
                    </div>
                </div>
                
                <!-- Seller Info -->
                <div class="sidebar-card">
                    <h3>Seller Information</h3>
                    <div class="seller-info">
                        <div class="seller-avatar">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($listing->user->name) }}&background=667eea&color=fff" alt="{{ $listing->user->name }}">
                        </div>
                        <div>
                            <div class="seller-name">{{ $listing->user->name }}</div>
                            @if($listing->user->is_verified)
                            <div class="verified-badge">
                                <i class="fas fa-check-circle"></i>
                                Verified Seller
                            </div>
                            @endif
                            <div class="seller-stats">
                                {{ $listing->user->listings()->where('status', 'approved')->count() }} listings
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Safety Tips -->
                <div class="sidebar-card">
                    <h3>Safety Tips</h3>
                    <ul class="safety-tips">
                        <li><i class="fas fa-shield-alt"></i> Meet in a public place</li>
                        <li><i class="fas fa-eye"></i> Inspect the item carefully</li>
                        <li><i class="fas fa-handshake"></i> Use secure payment methods</li>
                        <li><i class="fas fa-exclamation-triangle"></i> Report suspicious activity</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Reviews/Comments Section -->
        <div style="grid-column: 1 / -1; margin-top: 2rem;">
            <div class="comments-section">
                <h2>Customer Reviews & Questions</h2>
                
                @auth
                <div class="comment-form">
                    <h3>Ask a Question or Leave a Review</h3>
                    <form method="POST" action="{{ route('listings.reviews.store', $listing) }}">
                        @csrf
                        <div class="rating-input">
                            <label>Rating (optional - leave blank for questions):</label>
                            <div class="star-rating">
                                <input type="radio" name="rating" value="5" id="star5">
                                <label for="star5">★</label>
                                <input type="radio" name="rating" value="4" id="star4">
                                <label for="star4">★</label>
                                <input type="radio" name="rating" value="3" id="star3">
                                <label for="star3">★</label>
                                <input type="radio" name="rating" value="2" id="star2">
                                <label for="star2">★</label>
                                <input type="radio" name="rating" value="1" id="star1">
                                <label for="star1">★</label>
                            </div>
                        </div>
                        <textarea name="comment" rows="4" placeholder="Write your review or question here..." required></textarea>
                        <button type="submit" class="btn btn-primary">Post Comment</button>
                    </form>
                </div>
                @else
                <div class="login-prompt">
                    <p>Please <a href="{{ route('login') }}">login</a> to leave a review or ask a question.</p>
                </div>
                @endauth
                
                <!-- Display Reviews -->
                <div class="reviews-list">
                    @if($listing->reviews && $listing->reviews->count() > 0)
                        @foreach($listing->reviews as $review)
                        <div class="review-item">
                            <div class="review-header">
                                <div class="reviewer-info">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($review->reviewer->name) }}&background=667eea&color=fff" 
                                         alt="{{ $review->reviewer->name }}">
                                    <div>
                                        <h4>{{ $review->reviewer->name }}</h4>
                                        <span class="review-date">{{ $review->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                                @if($review->rating)
                                <div class="review-rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="star {{ $i <= $review->rating ? 'filled' : '' }}">★</span>
                                    @endfor
                                </div>
                                @endif
                            </div>
                            <div class="review-content">
                                <p>{{ $review->comment }}</p>
                            </div>
                            
                            @if($listing->user_id == auth()->id())
                            <div class="seller-reply">
                                <form method="POST" action="{{ route('listings.reviews.reply', [$listing, $review]) }}">
                                    @csrf
                                    <textarea name="reply" rows="2" placeholder="Reply to this review..." required></textarea>
                                    <button type="submit" class="btn btn-secondary">Reply</button>
                                </form>
                            </div>
                            @endif
                            
                            @if($review->seller_reply || $review->reply)
                            <div class="seller-response">
                                <h5>Seller Response:</h5>
                                <p>{{ $review->seller_reply ?? $review->reply }}</p>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    @else
                        <div class="no-reviews">
                            <p>No reviews yet. Be the first to review this listing!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
/* Image Gallery Styles */
.image-gallery {
    margin-bottom: 2rem;
}

.main-image {
    background: #f3f4f6;
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.main-image img {
    transition: transform 0.3s ease;
}

.main-image:hover img {
    transform: scale(1.02);
}

.thumbnail-gallery {
    padding: 0.5rem 0;
}

.thumbnail-gallery::-webkit-scrollbar {
    height: 6px;
}

.thumbnail-gallery::-webkit-scrollbar-track {
    background: #f3f4f6;
    border-radius: 3px;
}

.thumbnail-gallery::-webkit-scrollbar-thumb {
    background: #9ca3af;
    border-radius: 3px;
}

.thumbnail-gallery::-webkit-scrollbar-thumb:hover {
    background: #6b7280;
}

.thumbnail {
    transition: all 0.3s ease;
}

.thumbnail:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.thumbnail.active {
    border-color: #f59e0b !important;
}

.listing-section {
    background: white;
    border-radius: 1rem;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.listing-section h2 {
    font-size: 1.5rem;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 1rem;
}

.specs-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.spec-item {
    display: flex;
    justify-content: space-between;
    padding: 0.75rem;
    background: #f8fafc;
    border-radius: 0.5rem;
}

.spec-label {
    font-weight: 500;
    color: #6b7280;
}

.spec-value {
    font-weight: 600;
    color: #1f2937;
}

.sidebar-card {
    background: white;
    border-radius: 1rem;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.sidebar-card h3 {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 1rem;
}

.price-section {
    text-align: center;
    margin-bottom: 1.5rem;
}

.price {
    font-size: 2.5rem;
    font-weight: 800;
    color: #059669;
    margin-bottom: 0.5rem;
}

.featured-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    background: #f59e0b;
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 1rem;
    font-size: 0.875rem;
    font-weight: 600;
}

.seller-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.seller-avatar img {
    width: 60px;
    height: 60px;
    border-radius: 50%;
}

.seller-name {
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.25rem;
}

.verified-badge {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    color: #059669;
    font-size: 0.875rem;
    margin-bottom: 0.25rem;
}

.seller-stats {
    color: #6b7280;
    font-size: 0.875rem;
}

.safety-tips {
    list-style: none;
    padding: 0;
}

.safety-tips li {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 0;
    color: #6b7280;
    font-size: 0.875rem;
}

.safety-tips li i {
    color: #059669;
    width: 16px;
}

/* Comments Section Styles */
.comments-section {
    background: white;
    border-radius: 1rem;
    padding: 2rem;
    margin-top: 2rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.comments-section h2 {
    font-size: 1.75rem;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 1.5rem;
}

.comment-form {
    background: #f8fafc;
    padding: 1.5rem;
    border-radius: 0.75rem;
    margin-bottom: 2rem;
}

.comment-form h3 {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 1rem;
}

.comment-form textarea {
    width: 100%;
    padding: 0.75rem;
    border: 2px solid #e5e7eb;
    border-radius: 0.5rem;
    font-size: 1rem;
    resize: vertical;
    margin-bottom: 1rem;
}

.comment-form textarea:focus {
    outline: none;
    border-color: #f59e0b;
    box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
}

.rating-input {
    margin-bottom: 1rem;
}

.rating-input label {
    display: block;
    font-weight: 500;
    color: #374151;
    margin-bottom: 0.5rem;
}

.star-rating {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
    gap: 0.25rem;
}

.star-rating input {
    display: none;
}

.star-rating label {
    cursor: pointer;
    font-size: 1.5rem;
    color: #d1d5db;
    transition: color 0.2s ease;
}

.star-rating input:checked ~ label,
.star-rating label:hover,
.star-rating label:hover ~ label {
    color: #f59e0b;
}

.login-prompt {
    background: #f8fafc;
    padding: 1.5rem;
    border-radius: 0.75rem;
    text-align: center;
    margin-bottom: 2rem;
}

.login-prompt a {
    color: #f59e0b;
    font-weight: 600;
}

.reviews-list {
    margin-top: 2rem;
}

.review-item {
    border-bottom: 1px solid #e5e7eb;
    padding: 1.5rem 0;
}

.review-item:last-child {
    border-bottom: none;
}

.review-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
}

.reviewer-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.reviewer-info img {
    width: 48px;
    height: 48px;
    border-radius: 50%;
}

.reviewer-info h4 {
    font-weight: 600;
    color: #1f2937;
    margin: 0;
}

.review-date {
    color: #6b7280;
    font-size: 0.875rem;
}

.review-rating {
    display: flex;
    gap: 0.125rem;
}

.review-rating .star {
    color: #d1d5db;
    font-size: 1rem;
}

.review-rating .star.filled {
    color: #f59e0b;
}

.review-content {
    color: #374151;
    line-height: 1.6;
}

.seller-reply {
    margin-top: 1rem;
    padding-left: 3.5rem;
}

.seller-reply textarea {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #e5e7eb;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    resize: vertical;
    margin-bottom: 0.5rem;
}

.seller-response {
    background: #f8fafc;
    padding: 1rem;
    margin-top: 1rem;
    margin-left: 3.5rem;
    border-radius: 0.5rem;
    border-left: 3px solid #f59e0b;
}

.seller-response h5 {
    font-weight: 600;
    color: #f59e0b;
    margin: 0 0 0.5rem 0;
    font-size: 0.875rem;
}

.no-reviews {
    text-align: center;
    color: #6b7280;
    padding: 2rem;
    background: #f8fafc;
    border-radius: 0.75rem;
}

@media (max-width: 768px) {
    .container > div {
        grid-template-columns: 1fr !important;
    }
    
    .specs-grid {
        grid-template-columns: 1fr !important;
    }
}
</style>
@endpush

@push('scripts')
<script>
// Image gallery functionality
function changeMainImage(imageUrl, thumbnailElement) {
    // Update main image
    const mainImage = document.getElementById('mainImage');
    if (mainImage) {
        mainImage.src = imageUrl;
    }
    
    // Update active thumbnail
    document.querySelectorAll('.thumbnail').forEach(thumb => {
        thumb.style.borderColor = '#e5e7eb';
        thumb.classList.remove('active');
    });
    
    thumbnailElement.style.borderColor = '#f59e0b';
    thumbnailElement.classList.add('active');
}

// Add zoom functionality to main image
document.addEventListener('DOMContentLoaded', function() {
    const mainImage = document.getElementById('mainImage');
    if (mainImage) {
        mainImage.style.cursor = 'zoom-in';
        mainImage.addEventListener('click', function() {
            // Create modal for full-size image
            const modal = document.createElement('div');
            modal.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.9);
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 9999;
                cursor: zoom-out;
            `;
            
            const img = document.createElement('img');
            img.src = this.src;
            img.style.cssText = `
                max-width: 90%;
                max-height: 90%;
                object-fit: contain;
            `;
            
            modal.appendChild(img);
            document.body.appendChild(modal);
            
            modal.addEventListener('click', function() {
                document.body.removeChild(modal);
            });
        });
    }
});

function toggleFavorite(listingId) {
    const button = event.currentTarget;
    
    // Disable button while processing
    button.disabled = true;
    
    fetch(`/favorites/${listingId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            if (data.favorited) {
                button.innerHTML = '<i class="fas fa-heart"></i> Remove from Favorites';
                button.classList.add('favorited');
            } else {
                button.innerHTML = '<i class="fas fa-heart"></i> Add to Favorites';
                button.classList.remove('favorited');
            }
            
            // Show success message
            showNotification(data.message, 'success');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred. Please try again.', 'error');
    })
    .finally(() => {
        // Re-enable button
        button.disabled = false;
    });
}

function showNotification(message, type) {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;
    
    // Add styles
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1rem 1.5rem;
        background: ${type === 'success' ? '#10b981' : '#ef4444'};
        color: white;
        border-radius: 0.5rem;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        z-index: 1000;
        animation: slideIn 0.3s ease;
    `;
    
    document.body.appendChild(notification);
    
    // Remove after 3 seconds
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
    
    .btn-secondary.favorited {
        background: #ef4444 !important;
        color: white !important;
        border-color: #ef4444 !important;
    }
`;
document.head.appendChild(style);

// Handle star rating selection
document.addEventListener('DOMContentLoaded', function() {
    const starInputs = document.querySelectorAll('.star-rating input[type="radio"]');
    const starLabels = document.querySelectorAll('.star-rating label');
    
    // Add click handlers to star labels
    starLabels.forEach((label, index) => {
        label.addEventListener('click', function(e) {
            // The corresponding input value (5 - index because they're reversed)
            const ratingValue = 5 - Math.floor(index / 1);
            console.log('Selected rating:', ratingValue);
        });
    });
    
    // Make rating optional - add a "No Rating" option
    const ratingInput = document.querySelector('.rating-input');
    if (ratingInput) {
        const clearBtn = document.createElement('button');
        clearBtn.type = 'button';
        clearBtn.textContent = 'Clear Rating';
        clearBtn.className = 'btn btn-secondary';
        clearBtn.style.marginLeft = '1rem';
        clearBtn.style.padding = '0.25rem 0.75rem';
        clearBtn.style.fontSize = '0.875rem';
        clearBtn.onclick = function() {
            starInputs.forEach(input => input.checked = false);
        };
        
        const starRatingDiv = document.querySelector('.star-rating');
        if (starRatingDiv) {
            starRatingDiv.parentNode.appendChild(clearBtn);
        }
    }
});
</script>
@endpush
@endsection
