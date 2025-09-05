<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Listing;
// use Inertia\Inertia; // Disabled to use Blade templates

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)
            ->whereNull('parent_id')
            ->withCount('listings')
            ->with(['children' => function($query) {
                $query->where('is_active', true);
            }])
            ->orderBy('sort_order')
            ->get();
        return view('categories.index', [
            'categories' => $categories,
        ]);
    }

    public function show(Category $category)
    {
        $listings = Listing::where('status', 'approved')
            ->where('category_id', $category->id)
            ->with(['user', 'category'])
            ->latest()
            ->paginate(12);

        $subcategories = $category->children()
            ->where('is_active', true)
            ->withCount('listings')
            ->get();

        return view('categories.show', [
            'category' => $category,
            'listings' => $listings,
            'subcategories' => $subcategories,
        ]);
    }
}