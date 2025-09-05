<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Listing;
use App\Models\Favorite;
// use Inertia\Inertia; // Disabled to use Blade templates

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $stats = [
            'total_listings' => $user->listings()->count(),
            'active_listings' => $user->listings()->where('status', 'approved')->count(),
            'pending_listings' => $user->listings()->where('status', 'pending')->count(),
            'favorites_count' => $user->favorites()->count(),
        ];
        
        $recentListings = $user->listings()
            ->with(['category'])
            ->latest()
            ->take(5)
            ->get();
            
        return view('dashboard', [
            'stats' => $stats,
            'recentListings' => $recentListings
        ]);
    }
}