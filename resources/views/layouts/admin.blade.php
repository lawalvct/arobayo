<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Admin Dashboard - Egbe Arobayo')</title>
    <meta name="description" content="@yield('meta_description', 'Admin Dashboard - Egbe Arobayo Management System')">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Admin-specific CSS -->
    <style>
        /* Admin Layout Styles */
        :root {
            --primary-color: #2596be;
            --secondary-blue: #4b95c4;
            --accent-yellow: #f3d40a;
            --accent-red: #af2f2e;
            --light-cream: #fefefc;
            --admin-bg: #f8f9fa;
            --sidebar-width: 250px;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            margin: 0;
            padding: 0;
        }

        /* Admin Header */
        .admin-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-blue) 100%);
            color: white;
            height: 70px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .admin-header .container-fluid {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
        }

        .admin-logo {
            display: flex;
            align-items: center;
            color: white;
            text-decoration: none;
            font-size: 1.5rem;
            font-weight: 700;
        }

        .admin-logo img {
            height: 40px;
            margin-right: 15px;
            border-radius: 8px;
        }

        .admin-logo:hover {
            color: var(--accent-yellow);
        }

        .admin-nav {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .admin-nav-item {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .admin-nav-item:hover {
            color: white;
            background: rgba(255, 255, 255, 0.1);
        }

        .admin-user-menu {
            position: relative;
        }

        .admin-user-btn {
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.2);
            color: white;
            padding: 8px 15px;
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .admin-user-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.3);
        }

        /* Mobile Header */
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .mobile-menu-btn {
                display: block;
            }

            .admin-nav {
                display: none;
            }
        }

        /* Admin Sidebar */
        .admin-sidebar {
            background: linear-gradient(180deg, var(--primary-color) 0%, #1e7a9e 100%);
            width: var(--sidebar-width);
            height: calc(100vh - 70px);
            position: fixed;
            top: 70px;
            left: 0;
            overflow-y: auto;
            z-index: 999;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .admin-sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .admin-sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        .admin-sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
        }

        .admin-sidebar.collapsed {
            transform: translateX(-100%);
        }

        /* Sidebar Content */
        .sidebar-header {
            padding: 30px 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .admin-avatar {
            width: 60px;
            height: 60px;
            background: rgba(243, 212, 10, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            border: 3px solid rgba(243, 212, 10, 0.3);
        }

        .admin-name {
            color: white;
            font-size: 1.1rem;
            font-weight: 600;
            margin: 0;
        }

        .admin-role {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.875rem;
            margin: 5px 0 0 0;
        }

        /* Sidebar Navigation */
        .sidebar-nav {
            padding: 20px 0;
        }

        .nav-section {
            margin-bottom: 30px;
        }

        .nav-section-title {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 0 25px 10px;
            margin-bottom: 10px;
        }

        .sidebar-nav-item {
            display: block;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            padding: 12px 25px;
            margin: 2px 15px;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
            position: relative;
        }

        .sidebar-nav-item i {
            width: 20px;
            text-align: center;
            margin-right: 12px;
        }

        .sidebar-nav-item:hover {
            color: white;
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }

        .sidebar-nav-item.active {
            color: white;
            background: rgba(243, 212, 10, 0.2);
            border-left: 4px solid var(--accent-yellow);
            font-weight: 600;
        }

        .sidebar-nav-item.active::before {
            content: '';
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            width: 6px;
            height: 6px;
            background: var(--accent-yellow);
            border-radius: 50%;
        }

        /* Main Content Area */
        .admin-main {
            margin-left: var(--sidebar-width);
            margin-top: 70px;
            min-height: calc(100vh - 70px);
            padding: 0;
        }

        .admin-content {
            padding: 30px;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .admin-main {
                margin-left: 0;
            }

            .admin-sidebar {
                transform: translateX(-100%);
            }

            .admin-sidebar.show {
                transform: translateX(0);
            }

            .admin-content {
                padding: 20px;
            }
        }

        /* Additional Admin Styles */
        .admin-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border: none;
            overflow: hidden;
        }

        .admin-btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-blue));
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .admin-btn-primary:hover {
            background: linear-gradient(135deg, #1e7a9e, #3d7ba3);
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(37, 150, 190, 0.3);
            color: white;
        }

        /* Notification Badge */
        .notification-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: var(--accent-red);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>

    @yield('styles')
</head>
<body>
    <!-- Admin Header -->
    <header class="admin-header">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <button class="mobile-menu-btn me-3" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <a href="{{ route('admin.dashboard') }}" class="admin-logo">
                    <img src="{{ asset('images/logo.png') }}" alt="Egbe Arobayo Logo">
                    Admin Panel
                </a>
            </div>

            <nav class="admin-nav">
                <a href="{{ route('home') }}" class="admin-nav-item" target="_blank">
                    <i class="fas fa-external-link-alt me-2"></i>
                    View Site
                </a>

                <div class="admin-user-menu dropdown">
                    <button class="admin-user-btn dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle me-2"></i>
                        {{ Auth::user()->name }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-user me-2"></i>Profile
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-cog me-2"></i>Settings
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <!-- Admin Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-header">
            <div class="admin-avatar">
                <i class="fas fa-user-shield fa-2x text-white opacity-75"></i>
            </div>
            <h6 class="admin-name">{{ Auth::user()->name }}</h6>
            <p class="admin-role">Administrator</p>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section">
                <div class="nav-section-title">Main</div>
                <a href="{{ route('admin.dashboard') }}" class="sidebar-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    Dashboard
                </a>
            </div>

            <div class="nav-section">
                <div class="nav-section-title">Content Management</div>
                <a href="{{ route('admin.events.index') }}" class="sidebar-nav-item {{ request()->routeIs('admin.events.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar"></i>
                    Events
                    @if(isset($stats['pending_events']) && $stats['pending_events'] > 0)
                        <span class="notification-badge">{{ $stats['pending_events'] }}</span>
                    @endif
                </a>
                <a href="{{ route('admin.galleries.index') }}" class="sidebar-nav-item {{ request()->routeIs('admin.galleries.*') ? 'active' : '' }}">
                    <i class="fas fa-images"></i>
                    Gallery
                </a>
                <a href="{{ route('admin.executives.index') }}" class="sidebar-nav-item {{ request()->routeIs('admin.executives.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    Executives
                </a>
                <a href="{{ route('admin.pages.index') }}" class="sidebar-nav-item {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
                    <i class="fas fa-file-alt"></i>
                    Pages
                </a>
            </div>

            <div class="nav-section">
                <div class="nav-section-title">User Management</div>
                <a href="#" class="sidebar-nav-item">
                    <i class="fas fa-user-plus"></i>
                    Registrations
                    @if(isset($stats['pending_registrations']) && $stats['pending_registrations'] > 0)
                        <span class="notification-badge">{{ $stats['pending_registrations'] }}</span>
                    @endif
                </a>
            </div>

            <div class="nav-section">
                <div class="nav-section-title">System</div>
                <a href="{{ route('admin.navigations.index') }}" class="sidebar-nav-item {{ request()->routeIs('admin.navigations.*') ? 'active' : '' }}">
                    <i class="fas fa-bars"></i>
                    Navigation
                </a>
                <a href="#" class="sidebar-nav-item">
                    <i class="fas fa-cog"></i>
                    Settings
                </a>
            </div>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="admin-main">
        <div class="admin-content">
            @yield('content')
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Admin JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sidebar toggle for mobile
            const sidebarToggle = document.getElementById('sidebarToggle');
            const adminSidebar = document.getElementById('adminSidebar');

            if (sidebarToggle && adminSidebar) {
                sidebarToggle.addEventListener('click', function() {
                    adminSidebar.classList.toggle('show');
                });
            }

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(e) {
                if (window.innerWidth <= 768) {
                    if (!adminSidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                        adminSidebar.classList.remove('show');
                    }
                }
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    adminSidebar.classList.remove('show');
                }
            });
        });
    </script>

    @yield('scripts')
</body>
</html>
