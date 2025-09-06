<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Language Switching
Route::get('/language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

// Public Listing Routes (non-authenticated)
Route::get('/listings', [ListingController::class, 'index'])->name('listings.index');

// Category Routes
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');

// Static Pages
Route::view('/about', 'pages.about')->name('about');
Route::view('/contact', 'pages.contact')->name('contact');
Route::view('/help', 'pages.help')->name('help');
Route::view('/privacy', 'pages.privacy')->name('privacy');
Route::view('/terms', 'pages.terms')->name('terms');

// Dashboard Route (Updated)
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Authenticated User Routes
Route::middleware('auth')->group(function () {
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Listing Management Routes (authenticated users)
    Route::get('/listings/create', [ListingController::class, 'create'])->name('listings.create');
    Route::post('/listings', [ListingController::class, 'store'])->name('listings.store');
    Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->name('listings.edit');
    Route::patch('/listings/{listing}', [ListingController::class, 'update'])->name('listings.update');
    Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->name('listings.destroy');
    
    // Chat/Message Routes
    Route::get('/messages', [ChatController::class, 'index'])->name('messages.index');
    Route::get('/messages/{chat}', [ChatController::class, 'show'])->name('messages.show');
    Route::post('/messages/{chat}', [ChatController::class, 'store'])->name('messages.store');
    Route::post('/listings/{listing}/message', [ChatController::class, 'create'])->name('messages.create');
    
    // Favorites Routes
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/{listing}', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/favorites/{listing}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
    
    // Review Routes
    Route::post('/listings/{listing}/reviews', [ReviewController::class, 'store'])->name('listings.reviews.store');
    Route::post('/listings/{listing}/reviews/{review}/reply', [ReviewController::class, 'reply'])->name('listings.reviews.reply');
    Route::delete('/listings/{listing}/reviews/{review}', [ReviewController::class, 'destroy'])->name('listings.reviews.destroy');
});

// Public route for viewing listing details (must be after authenticated routes to avoid conflicts)
Route::get('/listings/{listing}', [ListingController::class, 'show'])->name('listings.show');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Users Management
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::get('/users/export', [AdminController::class, 'exportUsers'])->name('users.export');
    Route::get('/users/{user}', [AdminController::class, 'showUser'])->name('users.show');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::patch('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    Route::patch('/users/{user}/approve', [AdminController::class, 'approveUser'])->name('users.approve');
    Route::patch('/users/{user}/block', [AdminController::class, 'blockUser'])->name('users.block');
    Route::patch('/users/{user}/unblock', [AdminController::class, 'unblockUser'])->name('users.unblock');
    
    // Listings Management
    Route::get('/listings', [AdminController::class, 'listings'])->name('listings.index');
    Route::get('/listings/export', [AdminController::class, 'exportListings'])->name('listings.export');
    Route::get('/listings/{listing}', [AdminController::class, 'showListing'])->name('listings.show');
    Route::get('/listings/{listing}/edit', [AdminController::class, 'editListing'])->name('listings.edit');
    Route::patch('/listings/{listing}', [AdminController::class, 'updateListing'])->name('listings.update');
    Route::delete('/listings/{listing}', [AdminController::class, 'destroyListing'])->name('listings.destroy');
    Route::patch('/listings/{listing}/approve', [AdminController::class, 'approveListing'])->name('listings.approve');
    Route::patch('/listings/{listing}/reject', [AdminController::class, 'rejectListing'])->name('listings.reject');
    Route::patch('/listings/{listing}/feature', [AdminController::class, 'featureListing'])->name('listings.feature');
    
    // Categories Management
    Route::get('/categories', [AdminController::class, 'categories'])->name('categories.index');
    Route::get('/categories/create', [AdminController::class, 'createCategory'])->name('categories.create');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::get('/categories/{category}/edit', [AdminController::class, 'editCategory'])->name('categories.edit');
    Route::patch('/categories/{category}', [AdminController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/categories/{category}', [AdminController::class, 'destroyCategory'])->name('categories.destroy');
    Route::patch('/categories/{category}/toggle', [AdminController::class, 'toggleCategory'])->name('categories.toggle');
    
    // Messages Management
    Route::get('/messages', [AdminController::class, 'messages'])->name('messages');
    Route::get('/messages/{chat}', [AdminController::class, 'showMessage'])->name('messages.show');
    Route::delete('/messages/{message}', [AdminController::class, 'deleteMessage'])->name('messages.delete');
    
    // Reports & Analytics
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    Route::get('/reports/users', [AdminController::class, 'userReports'])->name('reports.users');
    Route::get('/reports/listings', [AdminController::class, 'listingReports'])->name('reports.listings');
    Route::get('/reports/revenue', [AdminController::class, 'revenueReports'])->name('reports.revenue');
    Route::get('/reports/export', [AdminController::class, 'exportReports'])->name('reports.export');
    
    // Settings
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
    Route::get('/settings/email', [AdminController::class, 'emailSettings'])->name('settings.email');
    Route::post('/settings/email', [AdminController::class, 'updateEmailSettings'])->name('settings.email.update');
    Route::get('/settings/payment', [AdminController::class, 'paymentSettings'])->name('settings.payment');
    Route::post('/settings/payment', [AdminController::class, 'updatePaymentSettings'])->name('settings.payment.update');
    
    // System Management
    Route::get('/backups', [AdminController::class, 'backups'])->name('backups');
    Route::post('/backups', [AdminController::class, 'createBackup'])->name('backups.create');
    Route::post('/backups/{backup}/restore', [AdminController::class, 'restoreBackup'])->name('backups.restore');
    Route::delete('/backups/{backup}', [AdminController::class, 'deleteBackup'])->name('backups.delete');
    
    Route::get('/logs', [AdminController::class, 'logs'])->name('logs');
    Route::get('/logs/{log}', [AdminController::class, 'showLog'])->name('logs.show');
    Route::post('/logs/clear', [AdminController::class, 'clearLogs'])->name('logs.clear');
    
    // Maintenance Mode
    Route::post('/maintenance/up', [AdminController::class, 'maintenanceUp'])->name('maintenance.up');
    Route::post('/maintenance/down', [AdminController::class, 'maintenanceDown'])->name('maintenance.down');
});

require __DIR__.'/auth.php';