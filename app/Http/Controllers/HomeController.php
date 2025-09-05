<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Listing;
use App\Models\Category;
use App\Models\User;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured listings
        $featuredListings = Listing::where('status', 'approved')
            ->where('is_featured', true)
            ->with(['category', 'user'])
            ->latest()
            ->take(8)
            ->get();
            
        // Get recent listings
        $recentListings = Listing::where('status', 'approved')
            ->with(['category', 'user'])
            ->latest()
            ->take(12)
            ->get();
            
        // Get main categories
        $categories = Category::where('is_active', true)
            ->whereNull('parent_id')
            ->withCount('listings')
            ->orderBy('sort_order')
            ->get();
            
        // Get listing statistics
        $stats = [
            'total_listings' => Listing::where('status', 'approved')->count(),
            'total_motorcycles' => Listing::whereHas('category', function ($q) {
                $q->where('type', 'motorcycles');
            })->where('status', 'approved')->count(),
            'total_cars' => Listing::whereHas('category', function ($q) {
                $q->where('type', 'cars');
            })->where('status', 'approved')->count(),
            'total_scooters' => Listing::whereHas('category', function ($q) {
                $q->where('type', 'scooters');
            })->where('status', 'approved')->count(),
            'total_users' => User::count(),
        ];
        
        // Popular brands
        $popularBrands = Listing::where('status', 'approved')
            ->whereNotNull('brand')
            ->selectRaw('brand, COUNT(*) as count')
            ->groupBy('brand')
            ->orderByDesc('count')
            ->take(12)
            ->pluck('brand');
            
        return view('home', [
            'featuredListings' => $featuredListings,
            'recentListings' => $recentListings,
            'categories' => $categories,
            'stats' => $stats,
            'popularBrands' => $popularBrands,
        ]);
    }
}
