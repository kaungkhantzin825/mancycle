<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ManCycle - Buy & Sell Cars, Motorcycles & More')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Custom Styles -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: #1f2937;
            background-color: #ffffff;
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 24px;
        }
        
        /* Header Styles */
        .header {
            background: #ffffff;
            color: #1f2937;
            padding: 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            border-bottom: 1px solid #e5e7eb;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .top-bar {
            background: #1f2937;
            color: white;
            padding: 8px 0;
            font-size: 0.875rem;
        }
        
        .top-bar-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .top-bar-left {
            display: flex;
            gap: 2rem;
        }
        
        .top-bar-right {
            display: flex;
            gap: 1rem;
            align-items: center;
        }
        
        .top-bar a {
            color: #d1d5db;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .top-bar a:hover {
            color: white;
        }
        
        .main-nav {
            padding: 1rem 0;
        }
        
        .nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            font-size: 2.2rem;
            font-weight: 800;
            text-decoration: none;
            color: #1f2937;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .logo i {
            font-size: 2.5rem;
            color: #f59e0b;
        }
        
        .logo-text {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .nav-links {
            display: flex;
            list-style: none;
            gap: 3rem;
            align-items: center;
        }
        
        .nav-links a {
            color: #4b5563;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            padding: 0.75rem 0;
            position: relative;
        }
        
        .nav-links a:hover {
            color: #f59e0b;
        }
        
        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            transition: width 0.3s ease;
        }
        
        .nav-links a:hover::after {
            width: 100%;
        }
        
        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-align: center;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            box-shadow: 0 4px 14px rgba(245, 158, 11, 0.25);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(245, 158, 11, 0.35);
        }
        
        .btn-outline {
            background: transparent;
            color: #4b5563;
            border: 2px solid #e5e7eb;
        }
        
        .btn-outline:hover {
            background: #f9fafb;
            border-color: #f59e0b;
            color: #f59e0b;
        }
        
        .btn-secondary {
            background: #f3f4f6;
            color: #4b5563;
            border: 1px solid #e5e7eb;
        }
        
        .btn-secondary:hover {
            background: #e5e7eb;
            color: #1f2937;
        }

        /* User Dropdown */
        .user-dropdown {
            position: relative;
        }

        .user-btn {
            background: #f3f4f6;
            border: 2px solid #e5e7eb;
            color: #374151;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .user-btn:hover {
            background: #e5e7eb;
            border-color: #f59e0b;
            color: #f59e0b;
        }
        
        .user-btn i {
            font-size: 1.1rem;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            min-width: 200px;
            z-index: 1000;
            margin-top: 0.5rem;
        }

        .dropdown-menu.show {
            display: block;
        }

        .dropdown-menu a,
        .dropdown-menu button {
            display: block;
            width: 100%;
            padding: 0.75rem 1rem;
            color: #374151;
            text-decoration: none;
            border: none;
            background: none;
            text-align: left;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .dropdown-menu a:hover,
        .dropdown-menu button:hover {
            background: #f3f4f6;
        }

        .dropdown-menu .logout-btn {
            color: #ef4444;
            border-top: 1px solid #f3f4f6;
        }

        /* Footer */
        .footer {
            background: #1f2937;
            color: white;
            padding: 3rem 0 1rem;
            margin-top: auto;
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }
        
        .footer-section h3 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        
        .footer-section ul {
            list-style: none;
        }
        
        .footer-section ul li {
            margin-bottom: 0.5rem;
        }
        
        .footer-section ul li a {
            color: #d1d5db;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer-section ul li a:hover {
            color: white;
        }
        
        .footer-bottom {
            border-top: 1px solid #374151;
            padding-top: 1rem;
            text-align: center;
            color: #9ca3af;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }
            
            .nav {
                flex-wrap: wrap;
                gap: 1rem;
            }
        }

        /* Alert Styles */
        .alert {
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }
        
        /* Listing Card Styles */
        .listing-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
            padding: 1rem 0;
        }
        
        .listing-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }
        
        .listing-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }
        
        .listing-image {
            position: relative;
            width: 100%;
            height: 220px;
            overflow: hidden;
            background: #f3f4f6;
        }
        
        .listing-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .listing-card:hover .listing-image img {
            transform: scale(1.05);
        }
        
        .listing-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            z-index: 10;
        }
        
        .listing-content {
            padding: 1.5rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        
        .listing-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.75rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .listing-price {
            font-size: 1.75rem;
            font-weight: 700;
            color: #059669;
            margin-bottom: 0.75rem;
        }
        
        .listing-location {
            color: #6b7280;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }
        
        .listing-location i {
            color: #f59e0b;
        }
        
        /* Section Styles */
        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            text-align: center;
            color: #1f2937;
            margin-bottom: 3rem;
            position: relative;
        }
        
        .section-title:after {
            content: '';
            display: block;
            width: 60px;
            height: 4px;
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            margin: 1rem auto 0;
            border-radius: 2px;
        }
        
        .categories {
            padding: 4rem 0;
            background: #f8fafc;
        }
        
        .category-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }
        
        .category-card {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .category-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }
        
        .category-card i {
            font-size: 3rem;
            color: #f59e0b;
            margin-bottom: 1rem;
        }
        
        .category-card h3 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.75rem;
        }
        
        .category-card p {
            color: #6b7280;
            margin-bottom: 1.5rem;
        }
        
        .featured {
            padding: 4rem 0;
            background: white;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Header -->
    <header class="header">
        <!-- Top Bar -->
        <div class="top-bar">
            <div class="container">
                <div class="top-bar-content">
                    <div class="top-bar-left">
                        <span><i class="fas fa-phone"></i> +1 (555) 123-4567</span>
                        <span><i class="fas fa-envelope"></i> support@mancycle.com</span>
                    </div>
                    <div class="top-bar-right">
                        <a href="{{ route('help') }}">Help</a>
                        <span>|</span>
                        <a href="{{ route('contact') }}">Contact</a>
                        @auth
                        <span>|</span>
                        <span>Welcome, {{ Auth::user()->name }}!</span>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Navigation -->
        <div class="main-nav">
            <div class="container">
                <nav class="nav">
                    <a href="{{ route('home') }}" class="logo">
                        <i class="fas fa-motorcycle"></i>
                        <span class="logo-text">ManCycle</span>
                    </a>
                
                <ul class="nav-links">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('listings.index') }}">Browse</a></li>
                    <li><a href="{{ route('categories.index') }}">Categories</a></li>
                    @auth
                        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ route('messages.index') }}">Messages</a></li>
                        <li><a href="{{ route('favorites.index') }}">Favorites</a></li>
                    @endauth
                </ul>
                
                <div style="display: flex; align-items: center; gap: 1rem;">
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-outline">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-primary">Sign Up</a>
                    @else
                        <a href="{{ route('listings.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i>
                            Sell Now
                        </a>
                        
                        <!-- User Dropdown -->
                        <div class="user-dropdown">
                            <button class="user-btn" onclick="toggleDropdown()">
                                <i class="fas fa-user-circle"></i>
                                {{ Auth::user()->name }}
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            
                            <div class="dropdown-menu" id="userDropdown">
                                <a href="{{ route('dashboard') }}">
                                    <i class="fas fa-tachometer-alt" style="width: 20px;"></i>
                                    Dashboard
                                </a>
                                <a href="{{ route('profile.edit') }}">
                                    <i class="fas fa-user" style="width: 20px;"></i>
                                    Profile
                                </a>
                                @if(Auth::user()->role === 'super_admin')
                                <a href="{{ route('admin.dashboard') }}">
                                    <i class="fas fa-cog" style="width: 20px;"></i>
                                    Admin Panel
                                </a>
                                @endif
                                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                                    @csrf
                                    <button type="submit" class="logout-btn">
                                        <i class="fas fa-sign-out-alt" style="width: 20px;"></i>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>
                </nav>
            </div>
        </div>
    </header>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="container" style="margin-top: 1rem;">
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="container" style="margin-top: 1rem;">
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main style="min-height: calc(100vh - 200px);">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>ManCycle</h3>
                    <p>Your trusted marketplace for cars, motorcycles, and second-hand products. Buy and sell with confidence.</p>
                </div>
                
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('listings.index') }}">Browse Listings</a></li>
                        <li><a href="{{ route('categories.index') }}">Categories</a></li>
                        <li><a href="{{ route('about') }}">About Us</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h3>Categories</h3>
                    <ul>
                        <li><a href="{{ route('categories.show', 'cars') }}">Cars</a></li>
                        <li><a href="{{ route('categories.show', 'motorcycles') }}">Motorcycles</a></li>
                        <li><a href="{{ route('categories.show', 'second-hand') }}">Second Hand</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h3>Support</h3>
                    <ul>
                        <li><a href="{{ route('help') }}">Help Center</a></li>
                        <li><a href="{{ route('contact') }}">Contact Us</a></li>
                        <li><a href="{{ route('privacy') }}">Privacy Policy</a></li>
                        <li><a href="{{ route('terms') }}">Terms of Service</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} ManCycle. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('show');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('userDropdown');
            const userBtn = document.querySelector('.user-btn');
            
            if (!userBtn.contains(event.target)) {
                dropdown.classList.remove('show');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>