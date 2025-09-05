<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Listing;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = auth()->user()
            ->favorites()
            ->with(['listing.category', 'listing.user'])
            ->latest()
            ->paginate(12);

        return view('favorites.index', compact('favorites'));
    }

    public function store(Listing $listing)
    {
        $favorite = Favorite::firstOrCreate([
            'user_id' => auth()->id(),
            'listing_id' => $listing->id,
        ]);

        if ($favorite->wasRecentlyCreated) {
            return response()->json([
                'success' => true,
                'message' => 'Added to favorites!',
                'favorited' => true
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Already in favorites!',
            'favorited' => true
        ]);
    }

    public function destroy(Listing $listing)
    {
        $deleted = Favorite::where([
            'user_id' => auth()->id(),
            'listing_id' => $listing->id,
        ])->delete();

        if ($deleted) {
            return response()->json([
                'success' => true,
                'message' => 'Removed from favorites!',
                'favorited' => false
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Not in favorites!',
            'favorited' => false
        ]);
    }
}