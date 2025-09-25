<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Forgot Password - ManCycle</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }
        
        /* Animated background shapes */
        .bg-shape {
            position: absolute;
            opacity: 0.1;
        }
        
        .shape-1 {
            width: 300px;
            height: 300px;
            background: white;
            border-radius: 50%;
            top: -150px;
            left: -150px;
            animation: float 20s infinite ease-in-out;
        }
        
        .shape-2 {
            width: 200px;
            height: 200px;
            background: white;
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            bottom: -100px;
            right: -100px;
            animation: float 15s infinite ease-in-out reverse;
        }
        
        .shape-3 {
            width: 150px;
            height: 150px;
            background: white;
            clip-path: polygon(50% 0%, 0% 100%, 100% 100%);
            top: 50%;
            right: 10%;
            animation: rotate 25s infinite linear;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0) translateX(0); }
            25% { transform: translateY(-20px) translateX(10px); }
            50% { transform: translateY(10px) translateX(-10px); }
            75% { transform: translateY(-10px) translateX(20px); }
        }
        
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        .container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 440px;
        }
        
        .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 2rem;
            animation: slideUp 0.5s ease-out;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .logo-section {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        
        .logo {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1.75rem;
            font-weight: 800;
            color: #1f2937;
            text-decoration: none;
            margin-bottom: 0.5rem;
        }
        
        .logo i {
            font-size: 2rem;
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .logo-text {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .page-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }
        
        .page-subtitle {
            color: #6b7280;
            font-size: 0.875rem;
            line-height: 1.5;
            margin-bottom: 1.5rem;
        }
        
        .form-group {
            margin-bottom: 1.25rem;
        }
        
        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
        }
        
        .input-group {
            position: relative;
        }
        
        .input-icon {
            position: absolute;
            left: 0.875rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 1rem;
        }
        
        .form-input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.75rem;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 0.9rem;
            color: #1f2937;
            background: white;
            transition: all 0.3s ease;
            height: 44px;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #f59e0b;
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
            border-width: 1px;
        }
        
        .form-input:hover {
            border-color: #d1d5db;
        }
        
        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }
        
        .success-message {
            background: #d1fae5;
            color: #065f46;
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .success-message i {
            font-size: 1.25rem;
            color: #10b981;
        }
        
        .btn {
            width: 100%;
            padding: 0.75rem 1rem;
            border: none;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            height: 44px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            box-shadow: 0 4px 14px rgba(245, 158, 11, 0.4);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(245, 158, 11, 0.5);
        }
        
        .btn-primary:active {
            transform: translateY(0);
        }
        
        .divider {
            text-align: center;
            margin: 2rem 0;
            position: relative;
        }
        
        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e5e7eb;
        }
        
        .divider span {
            background: white;
            padding: 0 1rem;
            color: #9ca3af;
            font-size: 0.875rem;
            position: relative;
        }
        
        .links {
            text-align: center;
        }
        
        .link {
            color: #6b7280;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .link:hover {
            color: #f59e0b;
        }
        
        .link i {
            font-size: 1rem;
        }
        
        /* Loading spinner */
        .spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 0.8s linear infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        .btn-primary.loading .btn-text {
            display: none;
        }
        
        .btn-primary.loading .spinner {
            display: inline-block;
        }
        
        /* Responsive */
        @media (max-width: 640px) {
            .card {
                padding: 2rem;
            }
            
            .page-title {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Animated background shapes -->
    <div class="bg-shape shape-1"></div>
    <div class="bg-shape shape-2"></div>
    <div class="bg-shape shape-3"></div>
    
    <div class="container">
        <div class="card">
            <!-- Logo Section -->
            <div class="logo-section">
                <a href="{{ route('home') }}" class="logo">
                    <i class="fas fa-motorcycle"></i>
                    <span class="logo-text">ManCycle</span>
                </a>
            </div>
            
            <!-- Title -->
            <h1 class="page-title">Forgot Password?</h1>
            <p class="page-subtitle">
                No worries! Just enter your email address and we'll send you a password reset link that will allow you to choose a new one.
            </p>
            
            <!-- Success Message -->
            @if (session('status'))
                <div class="success-message">
                    <i class="fas fa-check-circle"></i>
                    {{ session('status') }}
                </div>
            @endif
            
            <!-- Form -->
            <form method="POST" action="{{ route('password.email') }}" id="resetForm">
                @csrf
                
                <!-- Email Field -->
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <div class="input-group">
                        <i class="fas fa-envelope input-icon"></i>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            class="form-input" 
                            placeholder="Enter your email address"
                            value="{{ old('email') }}" 
                            required 
                            autofocus
                        >
                    </div>
                    @error('email')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                
                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">
                    <span class="btn-text">
                        <i class="fas fa-paper-plane"></i>
                        Send Reset Link
                    </span>
                    <span class="spinner"></span>
                </button>
            </form>
            
            <!-- Divider -->
            <div class="divider">
                <span>OR</span>
            </div>
            
            <!-- Links -->
            <div class="links">
                <a href="{{ route('login') }}" class="link">
                    <i class="fas fa-arrow-left"></i>
                    Back to Login
                </a>
            </div>
        </div>
    </div>
    
    <script>
        // Add loading state to form submission
        document.getElementById('resetForm').addEventListener('submit', function(e) {
            const button = this.querySelector('.btn-primary');
            button.classList.add('loading');
            button.disabled = true;
        });
        
        // Auto-hide success message after 10 seconds
        const successMsg = document.querySelector('.success-message');
        if (successMsg) {
            setTimeout(() => {
                successMsg.style.transition = 'opacity 0.5s';
                successMsg.style.opacity = '0';
                setTimeout(() => successMsg.remove(), 500);
            }, 10000);
        }
    </script>
</body>
</html>
