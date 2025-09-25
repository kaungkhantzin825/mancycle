<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LocationController extends Controller
{
    /**
     * Display locations for admin management
     */
    public function index(Request $request)
    {
        $query = Location::with('parent');
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('name_mm', 'like', "%{$search}%");
            });
        }
        
        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        // Filter by parent
        if ($request->filled('parent_id')) {
            $query->where('parent_id', $request->parent_id);
        }
        
        $locations = $query->ordered()->paginate(20);
        
        // Get parent locations for dropdown
        $regions = Location::regions()->active()->ordered()->get();
        
        return view('admin.locations.index', compact('locations', 'regions'));
    }
    
    /**
     * Show form to create new location
     */
    public function create()
    {
        $regions = Location::regions()->active()->ordered()->get();
        $cities = Location::cities()->active()->ordered()->get();
        $towns = Location::towns()->active()->ordered()->get();
        
        return view('admin.locations.create', compact('regions', 'cities', 'towns'));
    }
    
    /**
     * Store new location
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_mm' => 'nullable|string|max:255',
            'type' => 'required|in:region,city,town,township',
            'parent_id' => 'nullable|exists:locations,id',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);
        
        // Auto-generate slug
        $validated['slug'] = Str::slug($validated['name']);
        
        // Ensure unique slug
        $count = Location::where('slug', 'like', $validated['slug'] . '%')->count();
        if ($count > 0) {
            $validated['slug'] = $validated['slug'] . '-' . ($count + 1);
        }
        
        // Set default values
        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        
        Location::create($validated);
        
        return redirect()->route('admin.locations.index')
            ->with('success', 'Location created successfully!');
    }
    
    /**
     * Show form to edit location
     */
    public function edit(Location $location)
    {
        $regions = Location::regions()->active()->ordered()->get();
        $cities = Location::cities()->active()->ordered()->get();
        $towns = Location::towns()->active()->ordered()->get();
        
        return view('admin.locations.edit', compact('location', 'regions', 'cities', 'towns'));
    }
    
    /**
     * Update location
     */
    public function update(Request $request, Location $location)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_mm' => 'nullable|string|max:255',
            'type' => 'required|in:region,city,town,township',
            'parent_id' => 'nullable|exists:locations,id',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);
        
        // Prevent setting itself as parent
        if ($validated['parent_id'] == $location->id) {
            return back()->withErrors(['parent_id' => 'Location cannot be its own parent']);
        }
        
        // Update slug if name changed
        if ($location->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']);
            
            // Ensure unique slug
            $count = Location::where('slug', 'like', $validated['slug'] . '%')
                ->where('id', '!=', $location->id)
                ->count();
            if ($count > 0) {
                $validated['slug'] = $validated['slug'] . '-' . ($count + 1);
            }
        }
        
        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        
        $location->update($validated);
        
        return redirect()->route('admin.locations.index')
            ->with('success', 'Location updated successfully!');
    }
    
    /**
     * Delete location
     */
    public function destroy(Location $location)
    {
        // Check if location has children
        if ($location->children()->count() > 0) {
            return back()->with('error', 'Cannot delete location with sub-locations!');
        }
        
        // Check if location has listings
        if ($location->listings()->count() > 0) {
            return back()->with('error', 'Cannot delete location with listings!');
        }
        
        // Check if location has users
        if ($location->users()->count() > 0) {
            return back()->with('error', 'Cannot delete location with users!');
        }
        
        $location->delete();
        
        return redirect()->route('admin.locations.index')
            ->with('success', 'Location deleted successfully!');
    }
    
    /**
     * Toggle location active status
     */
    public function toggleStatus(Location $location)
    {
        $location->update(['is_active' => !$location->is_active]);
        
        return back()->with('success', 'Location status updated!');
    }
    
    /**
     * Get locations for AJAX requests (for dropdowns)
     */
    public function getChildren(Request $request)
    {
        $request->validate([
            'parent_id' => 'required|exists:locations,id'
        ]);
        
        $children = Location::where('parent_id', $request->parent_id)
            ->active()
            ->ordered()
            ->get(['id', 'name', 'type']);
            
        // If no children found, check if we need to return the parent as a fallback
        if ($children->isEmpty()) {
            $parent = Location::find($request->parent_id);
            if ($parent && $parent->type === 'city') {
                // If it's a city with no townships, return the city itself
                return response()->json([
                    [
                        'id' => $parent->id,
                        'name' => $parent->name,
                        'type' => $parent->type
                    ]
                ]);
            }
            return response()->json([]);
        }
        
        return response()->json($children);
    }

    /**
     * Get all descendant locations one level down from cities under a region.
     * Example: Given Region (Yangon Region) -> find its child City (Yangon)
     * then return that city's children (Insein, Hlaing, ...).
     */
    public function getDescendants(Request $request)
    {
        $request->validate([
            'region_id' => 'required|exists:locations,id',
        ]);

        // Find direct children of the region (these should be cities)
        // Do NOT filter by active() here to avoid missing valid hierarchies
        $cityIds = Location::where('parent_id', $request->region_id)
            ->pluck('id');

        if ($cityIds->isEmpty()) {
            return response()->json([]);
        }

        // Find grandchildren (e.g., townships) under those cities
        $grandChildren = Location::whereIn('parent_id', $cityIds)
            ->active()
            ->ordered()
            ->get(['id', 'name', 'type']);

        return response()->json($grandChildren);
    }
    
    /**
     * Search locations for autocomplete
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        
        $locations = Location::where('name', 'like', "%{$query}%")
            ->orWhere('name_mm', 'like', "%{$query}%")
            ->active()
            ->with('parent')
            ->take(10)
            ->get()
            ->map(function ($location) {
                return [
                    'id' => $location->id,
                    'text' => $location->full_name,
                    'type' => $location->type,
                    'has_coordinates' => $location->hasCoordinates(),
                ];
            });
        
        return response()->json($locations);
    }
}
