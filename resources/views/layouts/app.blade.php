<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Egbe Arobayo')</title>
    <meta name="description" content="@yield('meta_description', 'Egbe Arobayo - Preserving Yoruba Culture and Tradition')">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Custom CSS -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    @yield('styles')
</head>
<body>
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
                    @if(isset($navigation))
                        @foreach($navigation as $nav)
                            <li class="nav-item dropdown">
                                <a class="nav-link @if($nav->children->isNotEmpty()) dropdown-toggle @endif"
                                   href="{{ $nav->url }}"
                                   @if($nav->children->isNotEmpty())
                                       data-bs-toggle="dropdown"
                                       role="button"
                                       aria-expanded="false"
                                   @endif
                                   target="{{ $nav->target }}">
                                    @if($nav->icon)
                                        <i class="{{ $nav->icon }}"></i>
                                    @endif
                                    {{ $nav->label }}
                                </a>
                                @if($nav->children->isNotEmpty())
                                    <ul class="dropdown-menu">
                                        @foreach($nav->children as $child)
                                            <li>
                                                <a class="dropdown-item" href="{{ $child->url }}" target="{{ $child->target }}">
                                                    @if($child->icon)
                                                        <i class="{{ $child->icon }}"></i>
                                                    @endif
                                                    {{ $child->label }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
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
                                    <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                                </a>
                            </li>
                        @endif
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-1"></i>{{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt me-1"></i>Admin Login
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
    <footer class="footer section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5 class="fw-bold">{{ $siteSettings['site_name'] ?? 'Egbe Arobayo' }}</h5>
                    <p>{{ $siteSettings['footer_description'] ?? 'Preserving and promoting Yoruba culture, traditions, and values for future generations.' }}</p>
                    <div class="social-links">
                        @if(isset($siteSettings['facebook_url']))
                            <a href="{{ $siteSettings['facebook_url'] }}" class="text-white me-3" target="_blank">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        @endif
                        @if(isset($siteSettings['twitter_url']))
                            <a href="{{ $siteSettings['twitter_url'] }}" class="text-white me-3" target="_blank">
                                <i class="fab fa-twitter"></i>
                            </a>
                        @endif
                        @if(isset($siteSettings['instagram_url']))
                            <a href="{{ $siteSettings['instagram_url'] }}" class="text-white me-3" target="_blank">
                                <i class="fab fa-instagram"></i>
                            </a>
                        @endif
                    </div>
                </div>

                <div class="col-lg-2 mb-4">
                    <h6 class="fw-bold">Quick Links</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}" class="text-white-50">Home</a></li>
                        <li><a href="{{ route('events.index') }}" class="text-white-50">Events</a></li>
                        <li><a href="{{ route('gallery.index') }}" class="text-white-50">Gallery</a></li>
                        <li><a href="{{ route('register') }}" class="text-white-50">Join Us</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 mb-4">
                    <h6 class="fw-bold">Contact Info</h6>
                    <ul class="list-unstyled">
                        @if(isset($siteSettings['phone']))
                            <li class="text-white-50">
                                <i class="fas fa-phone me-2"></i>
                                {{ $siteSettings['phone'] }}
                            </li>
                        @endif
                        @if(isset($siteSettings['email']))
                            <li class="text-white-50">
                                <i class="fas fa-envelope me-2"></i>
                                {{ $siteSettings['email'] }}
                            </li>
                        @endif
                        @if(isset($siteSettings['address']))
                            <li class="text-white-50">
                                <i class="fas fa-map-marker-alt me-2"></i>
                                {{ $siteSettings['address'] }}
                            </li>
                        @endif
                    </ul>
                </div>

                <div class="col-lg-3 mb-4">
                    <h6 class="fw-bold">Newsletter</h6>
                    <p class="text-white-50">Stay updated with our latest news and events.</p>
                    <div class="input-group">
                        <input type="email" class="form-control" placeholder="Your email">
                        <button class="btn btn-outline-light" type="button">Subscribe</button>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="text-white-50 mb-0">
                        &copy; {{ date('Y') }} {{ $siteSettings['site_name'] ?? 'Egbe Arobayo' }}. All rights reserved.
                    </p>
                </div>
                <div class="col-md-6 text-end">
                    <a href="#" class="text-white-50 me-3">Privacy Policy</a>
                    <a href="#" class="text-white-50">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
