@extends('layouts.mancycle')

@section('title', 'Login - ManCycle')

@section('content')
<section class="auth-section">
    <div class="auth-container">
        <div class="auth-card">
            <!-- Left Side - Welcome -->
            <div class="auth-left">
                <div class="auth-brand">
                    <i class="fas fa-motorcycle"></i>
                    <h2>ManCycle</h2>
                </div>
                <h1>Welcome Back!</h1>
                <p>Login to access your account and start buying or selling vehicles.</p>
                
                <div class="auth-features">
                    <div class="feature-item">
                        <i class="fas fa-shield-alt"></i>
                        <span>Secure Login</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-lock"></i>
                        <span>Protected Data</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-user-shield"></i>
                        <span>Privacy First</span>
                    </div>
                </div>
                
                <div class="auth-image">
                    <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=600&h=400&fit=crop" 
                         alt="ManCycle Login" 
                         style="width: 100%; border-radius: 1rem; opacity: 0.9;">
                </div>
            </div>
            
            <!-- Right Side - Form -->
            <div class="auth-right">
                <div class="auth-form-container">
                    <h2>Login to Your Account</h2>
                    <p class="auth-subtitle">Enter your credentials to continue</p>
                    
                    @if(session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    @if($errors->any())
                        <div class="alert alert-error">
                            @foreach($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('login') }}" class="auth-form">
                        @csrf
                        
                        <!-- Email -->
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <div class="input-group">
                                <i class="fas fa-envelope"></i>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       placeholder="Enter your email"
                                       required 
                                       autofocus>
                            </div>
                        </div>
                        
                        <!-- Password -->
                        <div class="form-group">
                            <label for="password">Password</label>
                            <div class="input-group">
                                <i class="fas fa-lock"></i>
                                <input type="password" 
                                       id="password" 
                                       name="password" 
                                       placeholder="Enter your password"
                                       required>
                                <button type="button" class="toggle-password" onclick="togglePassword()">
                                    <i class="fas fa-eye" id="toggleIcon"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Remember Me & Forgot Password -->
                        <div class="form-options">
                            <label class="checkbox-label">
                                <input type="checkbox" name="remember">
                                <span>Remember me</span>
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="forgot-link">
                                    Forgot Password?
                                </a>
                            @endif
                        </div>
                        
                        <!-- Submit Button -->
                        <button type="submit" class="btn-auth-submit">
                            <i class="fas fa-sign-in-alt"></i>
                            Sign In
                        </button>
                    </form>
                    
                    <!-- Quick Login Options -->
                    <div class="quick-login">
                        <p style="margin: 1.5rem 0 1rem; color: #6b7280; font-size: 0.875rem;">Quick Login for Testing:</p>
                        <div class="test-credentials">
                            <div class="credential-item">
                                <strong>Admin:</strong> admin@mancycle.com / password
                            </div>
                            <div class="credential-item">
                                <strong>Seller:</strong> dealer1@mancycle.com / password
                            </div>
                            <div class="credential-item">
                                <strong>Buyer:</strong> user1@mancycle.com / password
                            </div>
                        </div>
                    </div>
                    
                    <!-- Register Link -->
                    <div class="auth-footer">
                        <p>Don't have an account? 
                            <a href="{{ route('register') }}">Create Account</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
.auth-section {
    min-height: calc(100vh - 200px);
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 3rem 1rem;
}

.auth-container {
    max-width: 1200px;
    width: 100%;
    margin: 0 auto;
}

.auth-card {
    background: white;
    border-radius: 2rem;
    overflow: hidden;
    display: grid;
    grid-template-columns: 1fr 1fr;
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
}

.auth-left {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 3rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.auth-brand {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 2rem;
}

.auth-brand i {
    font-size: 3rem;
    color: #f59e0b;
}

.auth-brand h2 {
    font-size: 2rem;
    font-weight: 800;
}

.auth-left h1 {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.auth-left p {
    font-size: 1.125rem;
    opacity: 0.9;
    margin-bottom: 2rem;
}

.auth-features {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin-bottom: 2rem;
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.feature-item i {
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.auth-right {
    padding: 3rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.auth-form-container {
    width: 100%;
    max-width: 400px;
}

.auth-form-container h2 {
    font-size: 2rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 0.5rem;
}

.auth-subtitle {
    color: #6b7280;
    margin-bottom: 2rem;
}

.auth-form {
    margin-top: 2rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
}

.input-group {
    position: relative;
    display: flex;
    align-items: center;
}

.input-group i {
    position: absolute;
    left: 1rem;
    color: #9ca3af;
    font-size: 1rem;
}

.input-group input {
    width: 100%;
    padding: 0.875rem 1rem 0.875rem 3rem;
    border: 2px solid #e5e7eb;
    border-radius: 0.75rem;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.input-group input:focus {
    outline: none;
    border-color: #f59e0b;
    box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
}

.toggle-password {
    position: absolute;
    right: 1rem;
    background: none;
    border: none;
    color: #9ca3af;
    cursor: pointer;
    padding: 0.5rem;
}

.toggle-password:hover {
    color: #6b7280;
}

.form-options {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #6b7280;
    font-size: 0.875rem;
    cursor: pointer;
}

.checkbox-label input {
    width: 1rem;
    height: 1rem;
}

.forgot-link {
    color: #f59e0b;
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 500;
    transition: color 0.3s ease;
}

.forgot-link:hover {
    color: #d97706;
}

.btn-auth-submit {
    width: 100%;
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
    padding: 0.875rem;
    border: none;
    border-radius: 0.75rem;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
}

.btn-auth-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(245, 158, 11, 0.3);
}

.test-credentials {
    background: #f8fafc;
    padding: 1rem;
    border-radius: 0.5rem;
    font-size: 0.8rem;
}

.credential-item {
    margin-bottom: 0.5rem;
    color: #6b7280;
}

.credential-item:last-child {
    margin-bottom: 0;
}

.credential-item strong {
    color: #374151;
}

.auth-footer {
    text-align: center;
    margin-top: 2rem;
    color: #6b7280;
}

.auth-footer a {
    color: #f59e0b;
    font-weight: 600;
    text-decoration: none;
}

.auth-footer a:hover {
    color: #d97706;
}

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

@media (max-width: 768px) {
    .auth-card {
        grid-template-columns: 1fr;
    }
    
    .auth-left {
        display: none;
    }
    
    .auth-section {
        padding: 2rem 1rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    }
}
</script>
@endpush
@endsection
