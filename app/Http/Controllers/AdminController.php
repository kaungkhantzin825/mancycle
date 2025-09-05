<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Listing;
use App\Models\Category;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Admin Dashboard with Statistics
     */
    public function dashboard()
    {
        // Get comprehensive statistics
        $stats = [
            'total_users' => User::count(),
            'pending_users' => User::where('status', 'pending')->count(),
            'total_listings' => Listing::count(),
            'pending_listings' => Listing::where('status', 'pending')->count(),
            'total_chats' => Chat::count(),
            'total_messages' => Message::count(),
            'total_categories' => Category::count(),
            'revenue_this_month' => $this->getMonthlyRevenue(),
        ];

        // Get recent pending users for quick approval
        $recentUsers = User::where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        // Get recent pending listings
        $recentListings = Listing::where('status', 'pending')
            ->with(['user', 'category'])
            ->latest()
            ->take(5)
            ->get();

        // Get chart data for dashboard
        $chartData = $this->getChartData();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentListings', 'chartData'));
    }

    /**
     * Get monthly revenue (if applicable)
     */
    private function getMonthlyRevenue()
    {
        // Implement based on your payment model
        // For now, returning a placeholder
        return 0;
    }

    /**
     * Get chart data for dashboard analytics
     */
    private function getChartData()
    {
        $lastSevenDays = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $lastSevenDays->push([
                'date' => $date->format('M d'),
                'users' => User::whereDate('created_at', $date)->count(),
                'listings' => Listing::whereDate('created_at', $date)->count(),
            ]);
        }
        return $lastSevenDays;
    }

    public function charts()
    {
        // return Inertia::render('Admin/ChartsPage');
        return view('admin.charts'); // Using Blade template instead
    }

    public function users()
    {
        $users = User::with(['listings'])
            ->latest()
            ->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function approveUser(User $user)
    {
        $user->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => auth()->id(),
        ]);

        return back()->with('success', 'User approved successfully!');
    }

    public function blockUser(User $user)
    {
        $user->update(['status' => 'blocked']);

        return back()->with('success', 'User blocked successfully!');
    }

    public function listings()
    {
        $listings = Listing::with(['user', 'category'])
            ->latest()
            ->paginate(20);

        return view('admin.listings.index', compact('listings'));
    }

    public function approveListing(Listing $listing)
    {
        $listing->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => auth()->id(),
        ]);

        return back()->with('success', 'Listing approved successfully!');
    }

    public function rejectListing(Request $request, Listing $listing)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);

        $listing->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        return back()->with('success', 'Listing rejected successfully!');
    }

    public function categories()
    {
        $categories = Category::with(['parent', 'children'])
            ->orderBy('sort_order')
            ->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
            'type' => 'required|in:cars,motorcycles,second_hand',
            'parent_id' => 'nullable|exists:categories,id',
            'icon' => 'nullable|string|max:100',
        ]);

        $validated['is_active'] = true;
        $validated['sort_order'] = Category::max('sort_order') + 1;

        Category::create($validated);

        return back()->with('success', 'Category created successfully!');
    }

    public function updateCategory(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug,' . $category->id,
            'description' => 'nullable|string',
            'type' => 'required|in:cars,motorcycles,second_hand',
            'parent_id' => 'nullable|exists:categories,id',
            'icon' => 'nullable|string|max:100',
            'is_active' => 'boolean',
        ]);

        $category->update($validated);

        return back()->with('success', 'Category updated successfully!');
    }

    public function destroyCategory(Category $category)
    {
        if ($category->children()->count() > 0) {
            return back()->with('error', 'Cannot delete category with subcategories!');
        }

        if ($category->listings()->count() > 0) {
            return back()->with('error', 'Cannot delete category with listings!');
        }

        $category->delete();

        return back()->with('success', 'Category deleted successfully!');
    }

    /**
     * Show user details and activity
     */
    public function showUser(User $user)
    {
        $userStats = [
            'total_listings' => $user->listings()->count(),
            'active_listings' => $user->listings()->where('status', 'approved')->count(),
            'total_messages' => Message::where('sender_id', $user->id)->count(),
            'total_chats' => Chat::where('buyer_id', $user->id)
                ->orWhere('seller_id', $user->id)
                ->count(),
        ];

        $recentListings = $user->listings()->latest()->take(5)->get();
        $recentActivity = $this->getUserActivity($user);

        return view('admin.users.show', compact('user', 'userStats', 'recentListings', 'recentActivity'));
    }

    /**
     * Edit user form
     */
    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update user details
     */
    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:user,dealer,admin',
            'status' => 'required|in:pending,approved,blocked',
            'commission_rate' => 'nullable|numeric|min:0|max:100',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully!');
    }

    /**
     * Delete user account
     */
    public function destroyUser(User $user)
    {
        // Soft delete or handle related data
        if ($user->listings()->count() > 0) {
            return back()->with('error', 'Cannot delete user with active listings!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully!');
    }

    /**
     * Reports and Analytics Page
     */
    public function reports(Request $request)
    {
        $period = $request->get('period', 'month');
        
        $stats = $this->getReportStats($period);
        $topCategories = $this->getTopCategories();
        $topUsers = $this->getTopUsers();
        $revenueData = $this->getRevenueData($period);

        return view('admin.reports.index', compact('stats', 'topCategories', 'topUsers', 'revenueData', 'period'));
    }

    /**
     * System Settings Page
     */
    public function settings()
    {
        $settings = [
            'site_name' => config('app.name'),
            'site_url' => config('app.url'),
            'contact_email' => config('mail.from.address'),
            'listings_per_page' => 20,
            'auto_approve_listings' => false,
            'auto_approve_users' => false,
            'commission_rate' => 5,
            'maintenance_mode' => app()->isDownForMaintenance(),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update System Settings
     */
    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'contact_email' => 'required|email',
            'listings_per_page' => 'required|integer|min:10|max:100',
            'auto_approve_listings' => 'boolean',
            'auto_approve_users' => 'boolean',
            'commission_rate' => 'required|numeric|min:0|max:100',
        ]);

        // Save settings to database or config file
        // Implementation depends on your setup

        return back()->with('success', 'Settings updated successfully!');
    }

    /**
     * Export data functions
     */
    public function exportUsers(Request $request)
    {
        $users = User::all();
        $filename = 'users_' . now()->format('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($users) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Name', 'Email', 'Phone', 'Role', 'Status', 'Created At']);
            
            foreach ($users as $user) {
                fputcsv($file, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->phone,
                    $user->role,
                    $user->status,
                    $user->created_at,
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export listings data
     */
    public function exportListings(Request $request)
    {
        $listings = Listing::with(['user', 'category'])->get();
        $filename = 'listings_' . now()->format('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($listings) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Title', 'Price', 'Category', 'User', 'Status', 'Views', 'Created At']);
            
            foreach ($listings as $listing) {
                fputcsv($file, [
                    $listing->id,
                    $listing->title,
                    $listing->price,
                    $listing->category->name ?? 'N/A',
                    $listing->user->name,
                    $listing->status,
                    $listing->views ?? 0,
                    $listing->created_at,
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Helper method to get user activity
     */
    private function getUserActivity(User $user)
    {
        // Get recent activity logs
        $activities = collect();
        
        // Add recent listings
        $user->listings()->latest()->take(5)->each(function($listing) use ($activities) {
            $activities->push([
                'type' => 'listing_created',
                'description' => 'Created listing: ' . $listing->title,
                'created_at' => $listing->created_at,
            ]);
        });

        // Add recent messages
        Message::where('sender_id', $user->id)
            ->latest()
            ->take(5)
            ->each(function($message) use ($activities) {
                $activities->push([
                    'type' => 'message_sent',
                    'description' => 'Sent a message',
                    'created_at' => $message->created_at,
                ]);
            });

        return $activities->sortByDesc('created_at')->take(10);
    }

    /**
     * Get report statistics for a given period
     */
    private function getReportStats($period)
    {
        $startDate = match($period) {
            'week' => now()->subWeek(),
            'month' => now()->subMonth(),
            'year' => now()->subYear(),
            default => now()->subMonth(),
        };

        return [
            'new_users' => User::where('created_at', '>=', $startDate)->count(),
            'new_listings' => Listing::where('created_at', '>=', $startDate)->count(),
            'total_messages' => Message::where('created_at', '>=', $startDate)->count(),
            'approved_listings' => Listing::where('created_at', '>=', $startDate)
                ->where('status', 'approved')->count(),
        ];
    }

    /**
     * Get top categories by listing count
     */
    private function getTopCategories()
    {
        return Category::withCount('listings')
            ->orderByDesc('listings_count')
            ->take(5)
            ->get();
    }

    /**
     * Get top users by listing count
     */
    private function getTopUsers()
    {
        return User::withCount('listings')
            ->orderByDesc('listings_count')
            ->take(5)
            ->get();
    }

    /**
     * Get revenue data for charts
     */
    private function getRevenueData($period)
    {
        // Implement based on your revenue model
        // This is a placeholder
        return collect();
    }

    /**
     * Messages Management
     */
    public function messages()
    {
        $chats = Chat::with(['buyer', 'seller', 'listing'])
            ->latest('updated_at')
            ->paginate(20);
            
        return view('admin.messages.index', compact('chats'));
    }

    /**
     * Show message details
     */
    public function showMessage(Chat $chat)
    {
        $messages = $chat->messages()->with('sender')->get();
        
        return view('admin.messages.show', compact('chat', 'messages'));
    }

    /**
     * Delete a message
     */
    public function deleteMessage(Message $message)
    {
        $message->delete();
        
        return back()->with('success', 'Message deleted successfully!');
    }

    /**
     * Unblock a user
     */
    public function unblockUser(User $user)
    {
        $user->update(['status' => 'approved']);
        
        return back()->with('success', 'User unblocked successfully!');
    }

    /**
     * Store a new user
     */
    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:user,dealer,admin',
            'status' => 'required|in:pending,approved,blocked',
        ]);
        
        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);
        
        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully!');
    }

    /**
     * Verify user email
     */
    public function verifyUser(User $user)
    {
        $user->update(['email_verified_at' => now()]);
        
        return back()->with('success', 'User email marked as verified!');
    }

    /**
     * Toggle category active status
     */
    public function toggleCategory(Category $category)
    {
        $category->update(['is_active' => !$category->is_active]);
        
        return back()->with('success', 'Category status updated!');
    }

    /**
     * Show listing details
     */
    public function showListing(Listing $listing)
    {
        $listing->load(['user', 'category']);
        
        return view('admin.listings.show', compact('listing'));
    }

    /**
     * Edit listing form
     */
    public function editListing(Listing $listing)
    {
        $categories = Category::all();
        
        return view('admin.listings.edit', compact('listing', 'categories'));
    }

    /**
     * Update listing
     */
    public function updateListing(Request $request, Listing $listing)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:pending,approved,rejected',
        ]);
        
        $listing->update($validated);
        
        return redirect()->route('admin.listings.index')
            ->with('success', 'Listing updated successfully!');
    }

    /**
     * Delete listing
     */
    public function destroyListing(Listing $listing)
    {
        $listing->delete();
        
        return redirect()->route('admin.listings.index')
            ->with('success', 'Listing deleted successfully!');
    }

    /**
     * Feature a listing
     */
    public function featureListing(Listing $listing)
    {
        $listing->update(['is_featured' => !$listing->is_featured]);
        
        return back()->with('success', 'Listing featured status updated!');
    }

    /**
     * Create category form
     */
    public function createCategory()
    {
        $categories = Category::whereNull('parent_id')->get();
        
        return view('admin.categories.create', compact('categories'));
    }

    /**
     * Edit category form
     */
    public function editCategory(Category $category)
    {
        $categories = Category::whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->get();
        
        return view('admin.categories.edit', compact('category', 'categories'));
    }

    /**
     * Backup management page
     */
    public function backups()
    {
        // Implement backup listing logic
        $backups = [];
        
        return view('admin.backups.index', compact('backups'));
    }

    /**
     * System logs page
     */
    public function logs()
    {
        // Implement log viewing logic
        $logs = [];
        
        return view('admin.logs.index', compact('logs'));
    }

    /**
     * Additional report methods
     */
    public function userReports(Request $request)
    {
        return redirect()->route('admin.reports');
    }

    public function listingReports(Request $request)
    {
        return redirect()->route('admin.reports');
    }

    public function revenueReports(Request $request)
    {
        return redirect()->route('admin.reports');
    }

    public function exportReports(Request $request)
    {
        // Implement report export
        return redirect()->route('admin.reports')->with('info', 'Report export feature coming soon');
    }
}
