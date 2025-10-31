<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Egbe Arobayo Akinle Ijebu')</title>
    <meta name="description" content="@yield('meta_description', 'Egbe Arobayo - Preserving Yoruba Culture and Tradition')">
   <link rel="icon" type="image/x-icon" href="{{ asset('images/icon.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/icon.png') }}">
 <!-- WhatsApp specific meta tags -->
    <meta property="og:image:type" content="image/jpeg">
    <meta name="theme-color" content="#2596be">
  <meta property="og:image" content="@yield('og_image', asset('images/icon.png'))">

    <!-- Preload critical assets -->
    <link rel="preload" href="{{ asset('images/logo.png') }}" as="image">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Custom CSS -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <style>
        @keyframes breathe {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        .navbar-brand img {
            animation: breathe 3s ease-in-out infinite;
        }
    </style>
    <style>
        /* Preloader styles */
        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #fff; /* Full white background */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: opacity 0.5s ease;
        }

        #preloader .spinner {
            width: 80px;
            height: 80px;
            background-image: url('{{ asset("images/logo.png") }}');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            animation: preloader-spin 2s linear infinite;
        }

        @keyframes preloader-spin {
            from {
                transform: rotate(0deg) scale(1);
            }
            50% {
                transform: rotate(180deg) scale(1.1);
            }
            to {
                transform: rotate(360deg) scale(1);
            }
        }

        main {
            visibility: hidden;
            opacity: 0;
            transition: opacity 0.5s ease;
        }

        body.loaded main {
            visibility: visible;
            opacity: 1;
        }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Preloader -->
    <div id="preloader">
        <div class="spinner"></div>
    </div>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary-custom fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Egbe Arobayo Logo">
                {{ $siteSettings['site_name'] ?? 'Egbe Arobayo' }}
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

                        <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                    @if(isset($globalNavigations) && $globalNavigations->count() > 0)
                        @foreach($globalNavigations as $nav)
                            <li class="nav-item {{ $nav->children->count() > 0 ? 'dropdown' : '' }}">
                                @if($nav->children->count() > 0)
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                        @if($nav->icon)
                                            <i class="{{ $nav->icon }} me-1"></i>
                                        @endif
                                        {{ $nav->label }}
                                    </a>
                                    <ul class="dropdown-menu">
                                        @foreach($nav->children->where('is_active', true) as $child)
                                            <li>
                                                <a class="dropdown-item"
                                                   href="{{ $child->getNavigationUrl() }}"
                                                   target="{{ $child->target ?? '_self' }}">
                                                    @if($child->icon)
                                                        <i class="{{ $child->icon }} me-2"></i>
                                                    @endif
                                                    {{ $child->label }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <a class="nav-link"
                                       href="{{ $nav->getNavigationUrl() }}"
                                       target="{{ $nav->target ?? '_self' }}">
                                        @if($nav->icon)
                                            <i class="{{ $nav->icon }} me-1"></i>
                                        @endif
                                        {{ $nav->label }}
                                    </a>
                                @endif
                            </li>
                        @endforeach
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('events.index') }}">Events</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('gallery.index') }}">Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-light ms-2 px-3" href="{{ route('register') }}">Join Us</a>
                    </li>
                    @auth
                        @if(Auth::user()->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                    <i class="fas fa-tachometer-alt me-1"></i>
                                    Admin
                                </a>
                            </li>
                        @endif
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-1"></i>
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt me-1"></i>
                                Login
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @include('layouts.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
    <script>
        window.addEventListener('load', function() {
            const preloader = document.getElementById('preloader');
            if (preloader) {
                preloader.style.opacity = '0';
                setTimeout(() => {
                    preloader.style.display = 'none';
                    document.body.classList.add('loaded');
                }, 500); // Match CSS transition time
            }
        });
    </script>
</body>
</html>
