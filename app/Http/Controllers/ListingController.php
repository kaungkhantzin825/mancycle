<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Listing;
use App\Models\Category;
use Inertia\Inertia;

class ListingController extends Controller
{
    public function index(Request $request)
    {
        $query = Listing::with(['category', 'user'])
            ->where('status', 'approved');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        // Price range filter
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Condition filter
        if ($request->filled('condition')) {
            $query->whereIn('condition', $request->condition);
        }

        // Location filter
        if ($request->filled('location')) {
            $query->where('location', 'like', "%{$request->location}%");
        }

        // Sorting
        switch ($request->get('sort', 'latest')) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'popular':
                $query->orderBy('views', 'desc');
                break;
            default:
                $query->latest();
        }

        $listings = $query->paginate(12);
        
        $categories = Category::where('is_active', true)
            ->whereNull('parent_id')
            ->get();
        
        return view('listings.index', [
            'listings' => $listings,
            'categories' => $categories
        ]);
    }

    public function show(Listing $listing)
    {
        $listing->load(['category', 'user', 'reviews.reviewer']);
        $listing->incrementViews();
        
        $relatedListings = Listing::where('category_id', $listing->category_id)
            ->where('id', '!=', $listing->id)
            ->where('status', 'approved')
            ->take(4)
            ->get();
            
        return view('listings.show', compact('listing', 'relatedListings'));
    }

    public function byCategory($categorySlug)
    {
        $category = Category::where('slug', $categorySlug)->firstOrFail();
        
        $listings = Listing::with(['category', 'user'])
            ->where('status', 'approved')
            ->where('category_id', $category->id)
            ->latest()
            ->paginate(12);
            
        return view('listings.category', compact('listings', 'category'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)
            ->whereNotNull('parent_id')
            ->with('parent')
            ->get();
            
        return view('listings.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'condition' => 'required|in:new,excellent,good,fair,poor',
            'category_id' => 'required|exists:categories,id',
            'brand' => 'nullable|string|max:100',
            'model' => 'nullable|string|max:100',
            'year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'fuel_type' => 'nullable|string|max:50',
            'mileage' => 'nullable|integer|min:0',
            'transmission' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:50',
            'location' => 'required|string|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'phone_privacy' => 'boolean',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'pending'; // Requires admin approval
        
        $listing = Listing::create($validated);
        
        return redirect()->route('listings.show', $listing)
            ->with('success', 'Listing created successfully! It will be reviewed by our team.');
    }

    public function edit(Listing $listing)
    {
        $this->authorize('update', $listing);
        
        $categories = Category::where('is_active', true)
            ->whereNotNull('parent_id')
            ->with('parent')
            ->get();
            
        return view('listings.edit', compact('listing', 'categories'));
    }

    public function update(Request $request, Listing $listing)
    {
        $this->authorize('update', $listing);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'condition' => 'required|in:new,excellent,good,fair,poor',
            'category_id' => 'required|exists:categories,id',
            'brand' => 'nullable|string|max:100',
            'model' => 'nullable|string|max:100',
            'year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'fuel_type' => 'nullable|string|max:50',
            'mileage' => 'nullable|integer|min:0',
            'transmission' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:50',
            'location' => 'required|string|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'phone_privacy' => 'boolean',
        ]);

        // If listing was approved and now edited, set back to pending
        if ($listing->status === 'approved') {
            $validated['status'] = 'pending';
        }
        
        $listing->update($validated);
        
        return redirect()->route('listings.show', $listing)
            ->with('success', 'Listing updated successfully!');
    }

    public function destroy(Listing $listing)
    {
        $this->authorize('delete', $listing);
        
        $listing->delete();
        
        return redirect()->route('dashboard')
            ->with('success', 'Listing deleted successfully!');
    }
}
