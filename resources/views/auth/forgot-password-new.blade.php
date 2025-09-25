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
        }
        
        .container {
            width: 100%;
            max-width: 400px;
        }
        
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            padding: 2rem;
        }
        
        .logo-section {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        
        .logo {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            color: #1f2937;
        }
        
        .logo i {
            font-size: 1.5rem;
            color: #f59e0b;
        }
        
        .logo-text {
            font-size: 1.5rem;
            font-weight: 700;
            color: #f59e0b;
        }
        
        .page-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.5rem;
            text-align: center;
        }
        
        .page-subtitle {
            color: #6b7280;
            font-size: 0.875rem;
            line-height: 1.4;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        
        .form-group {
            margin-bottom: 1rem;
        }
        
        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.375rem;
        }
        
        .input-wrapper {
            position: relative;
        }
        
        .input-icon {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 0.875rem;
            pointer-events: none;
        }
        
        .form-input {
            width: 100%;
            padding: 0.5rem 0.75rem 0.5rem 2.25rem;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 0.875rem;
            color: #1f2937;
            background: white;
            transition: all 0.2s ease;
            height: 36px;
        }
        
        .form-input::placeholder {
            color: #9ca3af;
            font-size: 0.875rem;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #f59e0b;
            box-shadow: 0 0 0 2px rgba(245, 158, 11, 0.1);
        }
        
        .form-input:hover {
            border-color: #9ca3af;
        }
        
        .error-message {
            color: #ef4444;
            font-size: 0.75rem;
            margin-top: 0.25rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }
        
        .error-message i {
            font-size: 0.75rem;
        }
        
        .success-message {
            background: #d1fae5;
            color: #065f46;
            padding: 0.75rem;
            border-radius: 6px;
            margin-bottom: 1rem;
            font-size: 0.813rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .success-message i {
            font-size: 1rem;
            color: #10b981;
        }
        
        .btn {
            width: 100%;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 6px;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            height: 36px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
        }
        
        .btn-primary:active {
            transform: translateY(0);
        }
        
        .btn i {
            font-size: 0.875rem;
        }
        
        .divider {
            text-align: center;
            margin: 1.5rem 0;
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
            font-size: 0.75rem;
            position: relative;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        .links {
            text-align: center;
        }
        
        .link {
            color: #6b7280;
            text-decoration: none;
            font-size: 0.875rem;
            transition: color 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
        }
        
        .link:hover {
            color: #f59e0b;
        }
        
        .link i {
            font-size: 0.875rem;
        }
        
        /* Loading spinner */
        .spinner {
            display: none;
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 0.6s linear infinite;
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
                padding: 1.5rem;
            }
            
            .page-title {
                font-size: 1.125rem;
            }
        }
    </style>
</head>
<body>
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
                No worries! Just enter your email address and we'll send you a password reset link.
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
                    <div class="input-wrapper">
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
                <span>or</span>
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
