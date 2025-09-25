<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Listing;
use App\Models\Category;
use App\Models\Location;
use Inertia\Inertia;

class ListingController extends Controller
{
    public function index(Request $request)
    {
        $query = Listing::with(['category', 'user', 'location'])
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

        // Location filter (old text-based)
        if ($request->filled('location')) {
            $query->where('location', 'like', "%{$request->location}%");
        }
        
        // Region filter: include all descendant location IDs of the region (cities/townships)
        if ($request->filled('region_id')) {
            $region = Location::find($request->region_id);
            if ($region) {
                $descendants = $region->descendants();
                $ids = $descendants->pluck('id')->toArray();
                // If also a specific city/location is chosen, the more specific filter below will narrow it further
                if (!empty($ids)) {
                    $query->whereIn('location_id', $ids);
                }
            }
        }
        
        // New location filter (by location_id)
        if ($request->filled('location_id')) {
            $locationIds = [$request->location_id];
            
            // Include all child locations
            $location = \App\Models\Location::find($request->location_id);
            if ($location) {
                $descendants = $location->descendants();
                $locationIds = array_merge($locationIds, $descendants->pluck('id')->toArray());
            }
            
            $query->whereIn('location_id', $locationIds);
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
        // Only non-buyers can create listings
        if (auth()->check() && auth()->user()->role === 'buyer') {
            return redirect()->route('dashboard')
                ->with('error', 'Buyers are not allowed to create listings.');
        }
        $categories = Category::where('is_active', true)
            ->whereNotNull('parent_id')
            ->with('parent')
            ->get();
            
        // Get parent locations (regions/states)
        $parentLocations = Location::whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
            
        return view('listings.create', compact('categories', 'parentLocations'));
    }

    public function store(Request $request)
    {
        // Only non-buyers can store listings
        if (auth()->check() && auth()->user()->role === 'buyer') {
            return redirect()->route('dashboard')
                ->with('error', 'Buyers are not allowed to create listings.');
        }
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
            'location_id' => 'required|exists:locations,id',
            'detailed_address' => 'nullable|string|max:500',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
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
            
        // Get parent locations (regions/states)
        $parentLocations = Location::whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
            
        // Get child locations if listing has location_id
        $childLocations = [];
        $parentLocationId = null;
        if ($listing->location_id) {
            $listing->load('location');
            if ($listing->location && $listing->location->parent_id) {
                $parentLocationId = $listing->location->parent_id;
                $childLocations = Location::where('parent_id', $parentLocationId)
                    ->where('is_active', true)
                    ->orderBy('name')
                    ->get();
            } elseif ($listing->location) {
                // The location is a parent location itself
                $parentLocationId = $listing->location->id;
            }
        }
            
        return view('listings.edit', compact('listing', 'categories', 'parentLocations', 'childLocations', 'parentLocationId'));
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
            'location_id' => 'required|exists:locations,id',
            'detailed_address' => 'nullable|string|max:500',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
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

    /**
     * Get child locations for cascading dropdowns
     */
    public function getLocationChildren(Request $request)
    {
        $parentId = $request->get('parent_id');
        
        $children = Location::where('parent_id', $parentId)
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'type']);
            
        return response()->json($children);
    }
}
