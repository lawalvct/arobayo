@extends('layouts.app')

@section('title', 'Admin Login - Egbe Arobayo')

@section('content')
<div class="container">
    <div class="row justify-content-center" style="margin-top: 100px;">
        <div class="col-md-5">
            <div class="card shadow-lg border-0">
                <div class="card-header text-center py-4 bg-gradient" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-blue) 100%);">
                    <div class="mb-3">
                        <img src="{{ asset('images/logo.png') }}" alt="Egbe Arobayo Logo" style="height: 60px;">
                    </div>
                    <h4 class="mb-0 text-white fw-bold">Admin Login</h4>
                    <p class="mb-0 text-white opacity-75">Access your dashboard</p>
                </div>

                <div class="card-body p-5">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            {{ $errors->first() }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold">
                                <i class="fas fa-envelope me-2 text-primary-custom"></i>Email Address
                            </label>
                            <input type="email"
                                   class="form-control form-control-lg @error('email') is-invalid @enderror"
                                   id="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   required
                                   autocomplete="email"
                                   placeholder="Enter your email address">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold">
                                <i class="fas fa-lock me-2 text-primary-custom"></i>Password
                            </label>
                            <div class="input-group">
                                <input type="password"
                                       class="form-control form-control-lg @error('password') is-invalid @enderror"
                                       id="password"
                                       name="password"
                                       required
                                       autocomplete="current-password"
                                       placeholder="Enter your password">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="fas fa-eye" id="eyeIcon"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input type="checkbox"
                                       class="form-check-input"
                                       id="remember"
                                       name="remember"
                                       {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    Remember me
                                </label>
                            </div>
                        </div>

                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-primary-custom btn-lg fw-bold" id="loginBtn">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                <span class="btn-text">Login to Dashboard</span>
                            </button>
                        </div>
                    </form>

                    <div class="text-center">
                        <a href="{{ route('home') }}" class="text-decoration-none">
                            <i class="fas fa-arrow-left me-2"></i>Back to Website
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Password toggle functionality
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');
    const loginForm = document.querySelector('form');
    const loginBtn = document.getElementById('loginBtn');
    const btnText = loginBtn.querySelector('.btn-text');

    // Password toggle
    if (togglePassword && password && eyeIcon) {
        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            if (type === 'text') {
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        });
    }

    // Form submission handling
    if (loginForm && loginBtn) {
        loginForm.addEventListener('submit', function(e) {
            // Add loading state
            loginBtn.classList.add('btn-loading');
            loginBtn.disabled = true;
            btnText.textContent = 'Logging in...';

            // Remove loading state after 10 seconds (fallback)
            setTimeout(function() {
                loginBtn.classList.remove('btn-loading');
                loginBtn.disabled = false;
                btnText.textContent = 'Login to Dashboard';
            }, 10000);
        });
    }

    // Auto-focus first empty field
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');

    if (emailInput && !emailInput.value) {
        emailInput.focus();
    } else if (passwordInput && !passwordInput.value) {
        passwordInput.focus();
    }

    // Enhanced form validation feedback
    const inputs = document.querySelectorAll('.form-control');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.value.trim() === '') {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }
        });

        input.addEventListener('input', function() {
            if (this.classList.contains('is-invalid') && this.value.trim() !== '') {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }
        });
    });
});
</script>

<style>
.bg-gradient {
    background: linear-gradient(135deg, #2596be 0%, #4b95c4 100%) !important;
}

.form-control-lg {
    border-radius: 8px;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.form-control-lg:focus {
    border-color: #2596be;
    box-shadow: 0 0 0 0.25rem rgba(37, 150, 190, 0.15);
}

.btn-primary-custom {
    background: linear-gradient(135deg, #2596be 0%, #4b95c4 100%) !important;
    border: 2px solid #2596be !important;
    color: white !important;
    border-radius: 8px;
    padding: 12px 0;
    font-weight: 600;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.btn-primary-custom::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
}

.btn-primary-custom:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(37, 150, 190, 0.3);
    background: linear-gradient(135deg, #1e7a9e 0%, #3d7ba3 100%) !important;
    border-color: #1e7a9e !important;
}

.btn-primary-custom:hover::before {
    left: 100%;
}

.btn-primary-custom:active {
    transform: translateY(0px);
    box-shadow: 0 4px 15px rgba(37, 150, 190, 0.4);
}

.text-primary-custom {
    color: #2596be !important;
}

.card {
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1) !important;
}

.card-header {
    border-bottom: none !important;
}

.alert {
    border-radius: 8px;
    border: none;
    margin-bottom: 1.5rem;
}

.alert-danger {
    background-color: rgba(175, 47, 46, 0.1);
    color: #af2f2e;
    border-left: 4px solid #af2f2e;
}

/* Loading state for button */
.btn-loading {
    pointer-events: none;
    opacity: 0.7;
}

.btn-loading::after {
    content: '';
    display: inline-block;
    width: 16px;
    height: 16px;
    margin-left: 8px;
    border: 2px solid currentColor;
    border-radius: 50%;
    border-top-color: transparent;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

/* Improved input styling */
.input-group .btn-outline-secondary {
    border-color: #e9ecef;
    color: #6c757d;
}

.input-group .btn-outline-secondary:hover {
    background-color: #f8f9fa;
    border-color: #e9ecef;
    color: #495057;
}

/* Enhanced focus states */
.form-control:focus,
.form-check-input:focus {
    border-color: #2596be;
    box-shadow: 0 0 0 0.25rem rgba(37, 150, 190, 0.15);
}
</style>
@endsection
