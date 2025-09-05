@extends('layouts.mancycle')

@section('title', 'Account Settings - ManCycle')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-8">
            <nav class="text-sm mb-4" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex">
                    <li class="flex items-center">
                        <a href="{{ route('dashboard') }}" class="text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-gray-700 dark:text-gray-300">Account Settings</span>
                    </li>
                </ol>
            </nav>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Account Settings</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Manage your profile information and security preferences</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar Navigation -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 sticky top-6">
                    <div class="flex flex-col items-center mb-6">
                        <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white text-3xl font-bold mb-3 shadow-lg">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ Auth::user()->name }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</p>
                    </div>

                    <nav class="space-y-1">
                        <button onclick="showSection('profile')" id="nav-profile" class="nav-item w-full text-left px-4 py-3 rounded-lg flex items-center space-x-3 text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span class="font-medium">Profile Information</span>
                        </button>
                        <button onclick="showSection('password')" id="nav-password" class="nav-item w-full text-left px-4 py-3 rounded-lg flex items-center space-x-3 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            <span class="font-medium">Security</span>
                        </button>
                        <button onclick="showSection('danger')" id="nav-danger" class="nav-item w-full text-left px-4 py-3 rounded-lg flex items-center space-x-3 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <span class="font-medium">Danger Zone</span>
                        </button>
                    </nav>

                    <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <div class="text-xs text-gray-500 dark:text-gray-400">
                            <p class="mb-2">Member since</p>
                            <p class="font-medium text-gray-700 dark:text-gray-300">{{ Auth::user()->created_at->format('F j, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="lg:col-span-3">
                <!-- Profile Information Section -->
                <div id="section-profile" class="section-content">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-6">
                            <h2 class="text-2xl font-bold text-white">Profile Information</h2>
                            <p class="text-blue-100 mt-1">Update your account's profile information and email address</p>
                        </div>
                        
                        <div class="p-6">
                            <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                                @csrf
                                @method('patch')

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Full Name
                                        </label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                </svg>
                                            </div>
                                            <input type="text" name="name" id="name" value="{{ old('name', Auth::user()->name) }}"
                                                class="pl-10 w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all"
                                                required autofocus>
                                        </div>
                                        @error('name')
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Email Address
                                        </label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                            <input type="email" name="email" id="email" value="{{ old('email', Auth::user()->email) }}"
                                                class="pl-10 w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all"
                                                required>
                                        </div>
                                        @error('email')
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                @if (Auth::user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! Auth::user()->hasVerifiedEmail())
                                    <div class="p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm text-yellow-700 dark:text-yellow-300">
                                                    Your email address is unverified.
                                                    <button form="send-verification" class="underline text-yellow-800 dark:text-yellow-200 hover:text-yellow-900 dark:hover:text-yellow-100">
                                                        Click here to re-send the verification email.
                                                    </button>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                                    <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-medium rounded-lg hover:from-blue-600 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transform transition-all hover:scale-105">
                                        Save Changes
                                    </button>
                                    
                                    @if (session('status') === 'profile-updated')
                                        <p class="text-sm text-green-600 dark:text-green-400 animate-pulse">
                                            ✓ Profile saved successfully
                                        </p>
                                    @endif
                                </div>
                            </form>

                            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Password Section -->
                <div id="section-password" class="section-content hidden">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-green-500 to-teal-600 p-6">
                            <h2 class="text-2xl font-bold text-white">Security Settings</h2>
                            <p class="text-green-100 mt-1">Ensure your account is using a strong password to stay secure</p>
                        </div>
                        
                        <div class="p-6">
                            <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                                @csrf
                                @method('put')

                                <div>
                                    <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Current Password
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                            </svg>
                                        </div>
                                        <input type="password" name="current_password" id="current_password"
                                            class="pl-10 w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all"
                                            autocomplete="current-password">
                                    </div>
                                    @error('current_password', 'updatePassword')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        New Password
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                            </svg>
                                        </div>
                                        <input type="password" name="password" id="password"
                                            class="pl-10 w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all"
                                            autocomplete="new-password">
                                    </div>
                                    <div class="mt-2">
                                        <div class="flex items-center space-x-1">
                                            <div class="flex-1 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                                <div id="password-strength" class="h-2 rounded-full transition-all duration-300"></div>
                                            </div>
                                            <span id="strength-text" class="text-xs text-gray-500 dark:text-gray-400 ml-2"></span>
                                        </div>
                                    </div>
                                    @error('password', 'updatePassword')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Confirm New Password
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                        <input type="password" name="password_confirmation" id="password_confirmation"
                                            class="pl-10 w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all"
                                            autocomplete="new-password">
                                    </div>
                                    @error('password_confirmation', 'updatePassword')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                                    <button type="submit" class="px-6 py-3 bg-gradient-to-r from-green-500 to-teal-600 text-white font-medium rounded-lg hover:from-green-600 hover:to-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transform transition-all hover:scale-105">
                                        Update Password
                                    </button>
                                    
                                    @if (session('status') === 'password-updated')
                                        <p class="text-sm text-green-600 dark:text-green-400 animate-pulse">
                                            ✓ Password updated successfully
                                        </p>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Danger Zone Section -->
                <div id="section-danger" class="section-content hidden">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border-2 border-red-200 dark:border-red-900">
                        <div class="bg-gradient-to-r from-red-500 to-pink-600 p-6">
                            <h2 class="text-2xl font-bold text-white">Danger Zone</h2>
                            <p class="text-red-100 mt-1">Irreversible and destructive actions</p>
                        </div>
                        
                        <div class="p-6">
                            <div class="bg-red-50 dark:bg-red-900/20 rounded-lg p-6 mb-6">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-lg font-medium text-red-800 dark:text-red-200">
                                            Delete Account
                                        </h3>
                                        <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                                            <p>Once your account is deleted, all of its resources and data will be permanently deleted. This action cannot be undone.</p>
                                            <ul class="list-disc list-inside mt-2 space-y-1">
                                                <li>All your listings will be removed</li>
                                                <li>Your messages and conversations will be deleted</li>
                                                <li>Your reviews and ratings will be removed</li>
                                                <li>This action is immediate and irreversible</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <form method="post" action="{{ route('profile.destroy') }}" onsubmit="return confirmDeletion(event)">
                                @csrf
                                @method('delete')

                                <div class="space-y-4">
                                    <div>
                                        <label for="password_delete" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Confirm your password to continue
                                        </label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                                </svg>
                                            </div>
                                            <input type="password" name="password" id="password_delete"
                                                class="pl-10 w-full px-4 py-3 border border-red-300 dark:border-red-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all"
                                                placeholder="Enter your password">
                                        </div>
                                        @error('password', 'userDeletion')
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="pt-6 border-t border-gray-200 dark:border-gray-700">
                                        <button type="submit" class="px-6 py-3 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transform transition-all hover:scale-105">
                                            <svg class="inline-block w-5 h-5 mr-2 -mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Delete Account Permanently
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Section navigation
    function showSection(section) {
        // Hide all sections
        document.querySelectorAll('.section-content').forEach(el => {
            el.classList.add('hidden');
        });
        
        // Remove active state from all nav items
        document.querySelectorAll('.nav-item').forEach(el => {
            el.classList.remove('text-blue-600', 'dark:text-blue-400', 'bg-blue-50', 'dark:bg-blue-900/20');
            el.classList.add('text-gray-700', 'dark:text-gray-300');
        });
        
        // Show selected section
        document.getElementById('section-' + section).classList.remove('hidden');
        
        // Add active state to selected nav item
        const navItem = document.getElementById('nav-' + section);
        navItem.classList.remove('text-gray-700', 'dark:text-gray-300');
        navItem.classList.add('text-blue-600', 'dark:text-blue-400', 'bg-blue-50', 'dark:bg-blue-900/20');
        
        // Store preference
        localStorage.setItem('profileSection', section);
    }
    
    // Password strength checker
    document.getElementById('password')?.addEventListener('input', function(e) {
        const password = e.target.value;
        const strengthBar = document.getElementById('password-strength');
        const strengthText = document.getElementById('strength-text');
        
        if (password.length === 0) {
            strengthBar.style.width = '0%';
            strengthBar.className = 'h-2 rounded-full transition-all duration-300';
            strengthText.textContent = '';
            return;
        }
        
        let strength = 0;
        
        // Length check
        if (password.length >= 8) strength++;
        if (password.length >= 12) strength++;
        
        // Complexity checks
        if (/[a-z]/.test(password)) strength++;
        if (/[A-Z]/.test(password)) strength++;
        if (/[0-9]/.test(password)) strength++;
        if (/[^a-zA-Z0-9]/.test(password)) strength++;
        
        const percentage = (strength / 6) * 100;
        strengthBar.style.width = percentage + '%';
        
        if (percentage <= 33) {
            strengthBar.className = 'h-2 rounded-full bg-red-500 transition-all duration-300';
            strengthText.textContent = 'Weak';
            strengthText.className = 'text-xs text-red-500 ml-2';
        } else if (percentage <= 66) {
            strengthBar.className = 'h-2 rounded-full bg-yellow-500 transition-all duration-300';
            strengthText.textContent = 'Medium';
            strengthText.className = 'text-xs text-yellow-500 ml-2';
        } else {
            strengthBar.className = 'h-2 rounded-full bg-green-500 transition-all duration-300';
            strengthText.textContent = 'Strong';
            strengthText.className = 'text-xs text-green-500 ml-2';
        }
    });
    
    // Delete account confirmation
    function confirmDeletion(event) {
        event.preventDefault();
        
        const message = "⚠️ WARNING: This will permanently delete your account!\n\n" +
                       "• All your data will be lost forever\n" +
                       "• This action cannot be undone\n" +
                       "• Your username will become available to others\n\n" +
                       "Type 'DELETE' to confirm:";
        
        const confirmation = prompt(message);
        
        if (confirmation === 'DELETE') {
            if (confirm('This is your final warning. Are you absolutely sure?')) {
                event.target.submit();
            }
        } else {
            alert('Account deletion cancelled.');
        }
        
        return false;
    }
    
    // Load saved section preference
    document.addEventListener('DOMContentLoaded', function() {
        const savedSection = localStorage.getItem('profileSection') || 'profile';
        showSection(savedSection);
    });
    
    // Auto-hide success messages
    setTimeout(function() {
        const messages = document.querySelectorAll('[class*="animate-pulse"]');
        messages.forEach(msg => {
            msg.style.transition = 'opacity 0.5s';
            msg.style.opacity = '0';
            setTimeout(() => msg.remove(), 500);
        });
    }, 3000);
</script>
@endsection
