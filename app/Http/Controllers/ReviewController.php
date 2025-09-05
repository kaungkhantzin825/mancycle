<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Listing;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Listing $listing)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
            'rating' => 'nullable|integer|min:1|max:5'
        ]);

        // Check if user already reviewed this listing
        $existingReview = Review::where('listing_id', $listing->id)
            ->where('reviewer_id', auth()->id())
            ->first();

        if ($existingReview) {
            return back()->with('error', 'You have already reviewed this listing');
        }

        // Check if user is not reviewing their own listing
        if ($listing->user_id == auth()->id()) {
            return back()->with('error', 'You cannot review your own listing');
        }

        Review::create([
            'listing_id' => $listing->id,
            'reviewer_id' => auth()->id(),
            'reviewee_id' => $listing->user_id,
            'rating' => $request->rating ?: null, // Allow null rating for questions/comments without rating
            'comment' => $request->comment,
            'type' => 'listing',
            'is_approved' => true
        ]);

        return back()->with('success', 'Review posted successfully');
    }

    public function reply(Request $request, Listing $listing, Review $review)
    {
        // Check if the user owns this listing
        if ($listing->user_id != auth()->id()) {
            return back()->with('error', 'You can only reply to reviews on your own listings');
        }

        $request->validate([
            'reply' => 'required|string|max:500'
        ]);

        $review->update([
            'seller_reply' => $request->reply
        ]);

        return back()->with('success', 'Reply posted successfully');
    }

    public function destroy(Listing $listing, Review $review)
    {
        // Check if user owns the review or is admin
        if ($review->reviewer_id != auth()->id() && auth()->user()->role != 'super_admin') {
            return back()->with('error', 'You can only delete your own reviews');
        }

        $review->delete();

        return back()->with('success', 'Review deleted successfully');
    }
}
