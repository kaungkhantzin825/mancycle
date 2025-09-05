@extends('layouts.mancycle')

@section('title', 'Create Account - ManCycle')

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
                <h1>Join ManCycle Today!</h1>
                <p>Create your account and start your journey with the best vehicle marketplace.</p>
                
                <div class="auth-features">
                    <div class="feature-item">
                        <i class="fas fa-car"></i>
                        <span>Buy & Sell Vehicles</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-shield-alt"></i>
                        <span>Secure Transactions</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-users"></i>
                        <span>Trusted Community</span>
                    </div>
                </div>
                
                <div class="auth-image">
                    <img src="https://images.unsplash.com/photo-1552519507-da3b142c6e3d?w=600&h=400&fit=crop" 
                         alt="ManCycle Register" 
                         style="width: 100%; border-radius: 1rem; opacity: 0.9;">
                </div>
            </div>
            
            <!-- Right Side - Form -->
            <div class="auth-right">
                <div class="auth-form-container">
                    <h2>Create New Account</h2>
                    <p class="auth-subtitle">Fill in your details to get started</p>
                    
                    @if($errors->any())
                        <div class="alert alert-error">
                            @foreach($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('register') }}" class="auth-form">
                        @csrf
                        
                        <!-- Account Type -->
                        <div class="form-group">
                            <label>Account Type</label>
                            <div class="account-type-selector">
                                <label class="account-type-option">
                                    <input type="radio" name="role" value="buyer" checked>
                                    <div class="option-content">
                                        <i class="fas fa-shopping-cart"></i>
                                        <span>Buyer</span>
                                    </div>
                                </label>
                                <label class="account-type-option">
                                    <input type="radio" name="role" value="seller">
                                    <div class="option-content">
                                        <i class="fas fa-store"></i>
                                        <span>Seller</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Full Name -->
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <div class="input-group">
                                <i class="fas fa-user"></i>
                                <input type="text" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name') }}" 
                                       placeholder="Enter your full name"
                                       required 
                                       autofocus>
                            </div>
                        </div>
                        
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
                                       required>
                            </div>
                        </div>
                        
                        <!-- Phone (Optional) -->
                        <div class="form-group">
                            <label for="phone">Phone Number (Optional)</label>
                            <div class="input-group">
                                <i class="fas fa-phone"></i>
                                <input type="tel" 
                                       id="phone" 
                                       name="phone" 
                                       value="{{ old('phone') }}" 
                                       placeholder="Enter your phone number">
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
                                       placeholder="Create a strong password"
                                       required>
                                <button type="button" class="toggle-password" onclick="togglePassword('password', 'toggleIcon1')">
                                    <i class="fas fa-eye" id="toggleIcon1"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Confirm Password -->
                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <div class="input-group">
                                <i class="fas fa-lock"></i>
                                <input type="password" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       placeholder="Confirm your password"
                                       required>
                                <button type="button" class="toggle-password" onclick="togglePassword('password_confirmation', 'toggleIcon2')">
                                    <i class="fas fa-eye" id="toggleIcon2"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Terms & Conditions -->
                        <div class="form-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="terms" required>
                                <span>I agree to the <a href="{{ route('terms') }}" target="_blank">Terms & Conditions</a> and <a href="{{ route('privacy') }}" target="_blank">Privacy Policy</a></span>
                            </label>
                        </div>
                        
                        <!-- Submit Button -->
                        <button type="submit" class="btn-auth-submit">
                            <i class="fas fa-user-plus"></i>
                            Create Account
                        </button>
                    </form>
                    
                    <!-- Login Link -->
                    <div class="auth-footer">
                        <p>Already have an account? 
                            <a href="{{ route('login') }}">Sign In</a>
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
    padding: 2rem;
    display: flex;
    align-items: center;
    justify-content: center;
    max-height: 100vh;
    overflow-y: auto;
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
    margin-bottom: 1.5rem;
}

.auth-form {
    margin-top: 1.5rem;
}

.form-group {
    margin-bottom: 1.25rem;
}

.form-group label {
    display: block;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
}

.account-type-selector {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.account-type-option {
    cursor: pointer;
}

.account-type-option input {
    display: none;
}

.option-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 0.75rem;
    transition: all 0.3s ease;
}

.option-content i {
    font-size: 1.5rem;
    color: #6b7280;
    margin-bottom: 0.5rem;
}

.option-content span {
    color: #374151;
    font-weight: 500;
}

.account-type-option input:checked + .option-content {
    border-color: #f59e0b;
    background: #fef3c7;
}

.account-type-option input:checked + .option-content i {
    color: #f59e0b;
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
    padding: 0.75rem 1rem 0.75rem 3rem;
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

.checkbox-label {
    display: flex;
    align-items: flex-start;
    gap: 0.5rem;
    color: #6b7280;
    font-size: 0.875rem;
    cursor: pointer;
}

.checkbox-label input {
    width: 1rem;
    height: 1rem;
    margin-top: 0.125rem;
}

.checkbox-label a {
    color: #f59e0b;
    text-decoration: none;
}

.checkbox-label a:hover {
    text-decoration: underline;
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

.auth-footer {
    text-align: center;
    margin-top: 1.5rem;
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

.alert-error {
    background: #fee2e2;
    color: #991b1b;
    border: 1px solid #fecaca;
}

.alert-error p {
    margin: 0.25rem 0;
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
    
    .account-type-selector {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush

@push('scripts')
<script>
function togglePassword(fieldId, iconId) {
    const passwordInput = document.getElementById(fieldId);
    const toggleIcon = document.getElementById(iconId);
    
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
