@extends('layouts.admin')

@section('title', 'Admin Dashboard - Egbe Arobayo')

@section('styles')
<style>
/* Dashboard-specific styles */
.dashboard-header {
    background: white;
    border-radius: 15px;
    padding: 25px 30px;
    margin-bottom: 30px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    border: 1px solid rgba(37, 150, 190, 0.1);
}

.dashboard-title {
    color: #2596be;
    font-weight: 700;
    font-size: 2rem;
    margin: 0;
}

.dashboard-subtitle {
    color: #6c757d;
    font-size: 1rem;
    margin-top: 5px;
}

.stat-card {
    background: white;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    border: none;
    transition: all 0.3s ease;
    height: 100%;
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--accent-color);
}

.stat-card.primary::before { background: linear-gradient(90deg, #2596be, #4b95c4); }
.stat-card.success::before { background: linear-gradient(90deg, #1cc88a, #17a673); }
.stat-card.info::before { background: linear-gradient(90deg, #36b9cc, #2c9cb4); }
.stat-card.warning::before { background: linear-gradient(90deg, #f3d40a, #d4af08); }

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.12);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin-bottom: 15px;
}

.stat-icon.primary { background: linear-gradient(135deg, #2596be, #4b95c4); color: white; }
.stat-icon.success { background: linear-gradient(135deg, #1cc88a, #17a673); color: white; }
.stat-icon.info { background: linear-gradient(135deg, #36b9cc, #2c9cb4); color: white; }
.stat-icon.warning { background: linear-gradient(135deg, #f3d40a, #d4af08); color: white; }

.stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2c3e50;
    line-height: 1;
    margin-bottom: 5px;
}

.stat-label {
    color: #6c757d;
    font-size: 0.9rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.dashboard-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    border: none;
    overflow: hidden;
}

.dashboard-card-header {
    background: linear-gradient(135deg, #2596be 0%, #4b95c4 100%);
    color: white;
    padding: 20px 25px;
    border-bottom: none;
    font-weight: 600;
}

.dashboard-card-body {
    padding: 25px;
}

.recent-item {
    padding: 15px 0;
    border-bottom: 1px solid #f1f3f4;
    transition: all 0.3s ease;
}

.recent-item:last-child {
    border-bottom: none;
}

.recent-item:hover {
    background: #f8f9fa;
    margin: 0 -25px;
    padding: 15px 25px;
    border-radius: 8px;
}

.recent-avatar {
    width: 45px;
    height: 45px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-action {
    padding: 8px 16px;
    border-radius: 8px;
    font-weight: 500;
    font-size: 0.875rem;
    transition: all 0.3s ease;
}

.btn-primary-custom {
    background: linear-gradient(135deg, #2596be, #4b95c4);
    border: none;
    color: white;
}

.btn-primary-custom:hover {
    background: linear-gradient(135deg, #1e7a9e, #3d7ba3);
    transform: translateY(-1px);
    box-shadow: 0 4px 15px rgba(37, 150, 190, 0.3);
}

.quick-actions {
    background: white;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    margin-bottom: 30px;
}

.quick-action-btn {
    background: linear-gradient(135deg, var(--bg-start), var(--bg-end));
    border: none;
    color: white;
    padding: 15px 20px;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
    display: block;
    width: 100%;
    text-decoration: none;
    margin-bottom: 10px;
}

.quick-action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    color: white;
}

.quick-action-btn.primary {
    --bg-start: #2596be;
    --bg-end: #4b95c4;
}

.quick-action-btn.success {
    --bg-start: #1cc88a;
    --bg-end: #17a673;
}

.quick-action-btn.warning {
    --bg-start: #f3d40a;
    --bg-end: #d4af08;
}

.quick-action-btn.danger {
    --bg-start: #af2f2e;
    --bg-end: #8b2626;
}

.quick-action-btn.info {
    --bg-start: #36b9cc;
    --bg-end: #2c9cb4;
}
</style>
@endsection

@section('content')
<!-- Dashboard Header -->
<div class="dashboard-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="dashboard-title">
                <i class="fas fa-tachometer-alt me-3"></i>
                Dashboard
            </h1>
            <p class="dashboard-subtitle mb-0">
                Welcome back, {{ Auth::user()->name }}! Here's what's happening with Egbe Arobayo.
            </p>
        </div>
        <div class="d-flex gap-2">
            <span class="badge bg-success fs-6">
                <i class="fas fa-circle me-2" style="font-size: 0.5rem;"></i>
                System Online
            </span>
        </div>
    </div>
</div>

                <!-- Quick Actions -->
                <div class="quick-actions">
                    <h5 class="mb-3">
                        <i class="fas fa-bolt me-2 text-warning"></i>
                        Quick Actions
                    </h5>
                    <div class="row">
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('admin.events.create') }}" class="quick-action-btn primary">
                                <i class="fas fa-plus me-2"></i>
                                Add Event
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="#" class="quick-action-btn success">
                                <i class="fas fa-image me-2"></i>
                                Add Gallery
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="#" class="quick-action-btn warning">
                                <i class="fas fa-user-tie me-2"></i>
                                Add Executive
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="#" class="quick-action-btn danger">
                                <i class="fas fa-cogs me-2"></i>
                                Site Settings
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('admin.pages.index') }}" class="quick-action-btn info">
                                <i class="fas fa-file-alt me-2"></i>
                                Manage Pages
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Stats Cards -->
                <div class="row mb-4">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="stat-card primary">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon primary">
                                    <i class="fas fa-calendar"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="stat-number">{{ $stats['total_events'] }}</div>
                                    <div class="stat-label">Total Events</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="stat-card success">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon success">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="stat-number">{{ $stats['upcoming_events'] }}</div>
                                    <div class="stat-label">Upcoming Events</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="stat-card info">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon info">
                                    <i class="fas fa-user-plus"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="stat-number">{{ $stats['total_registrations'] }}</div>
                                    <div class="stat-label">Total Registrations</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="stat-card warning">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon warning">
                                    <i class="fas fa-hourglass-half"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="stat-number">{{ $stats['pending_registrations'] }}</div>
                                    <div class="stat-label">Pending Registrations</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Recent Events and Registrations -->
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <div class="dashboard-card">
                            <div class="dashboard-card-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">
                                    <i class="fas fa-calendar me-2"></i>
                                    Recent Events
                                </h6>
                                <a href="{{ route('admin.events.index') }}" class="btn btn-sm btn-outline-light">
                                    View All
                                </a>
                            </div>
                            <div class="dashboard-card-body">
                                @forelse($recentEvents as $event)
                                    <div class="recent-item d-flex align-items-center">
                                        <div class="recent-avatar me-3">
                                            @if($event->image)
                                                <img src="{{ asset('storage/' . $event->image) }}"
                                                     alt="{{ $event->title }}"
                                                     class="rounded"
                                                     style="width: 45px; height: 45px; object-fit: cover;">
                                            @else
                                                <div style="background: linear-gradient(135deg, #2596be, #4b95c4); color: white; width: 45px; height: 45px;" class="rounded d-flex align-items-center justify-content-center">
                                                    <i class="fas fa-calendar"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 fw-semibold">{{ Str::limit($event->title, 35) }}</h6>
                                            <div class="d-flex align-items-center">
                                                <small class="text-muted me-2">
                                                    <i class="fas fa-calendar-alt me-1"></i>
                                                    {{ $event->event_date->format('M d, Y') }}
                                                </small>
                                                @if($event->is_featured)
                                                    <span class="badge bg-warning text-dark">Featured</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="ms-2">
                                            <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-4">
                                        <i class="fas fa-calendar fa-3x text-muted mb-3"></i>
                                        <p class="text-muted mb-0">No events found</p>
                                        <a href="{{ route('admin.events.create') }}" class="btn btn-primary-custom mt-2">
                                            <i class="fas fa-plus me-2"></i>Create First Event
                                        </a>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <div class="dashboard-card">
                            <div class="dashboard-card-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">
                                    <i class="fas fa-user-plus me-2"></i>
                                    Recent Registrations
                                </h6>
                                <a href="#" class="btn btn-sm btn-outline-light">
                                    View All
                                </a>
                            </div>
                            <div class="dashboard-card-body">
                                @forelse($recentRegistrations as $registration)
                                    <div class="recent-item d-flex align-items-center">
                                        <div class="recent-avatar me-3">
                                            <div style="background: linear-gradient(135deg, #1cc88a, #17a673); color: white;" class="rounded d-flex align-items-center justify-content-center">
                                                <i class="fas fa-user"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 fw-semibold">{{ $registration->full_name }}</h6>
                                            <div class="d-flex align-items-center">
                                                <small class="text-muted me-2">
                                                    <i class="fas fa-clock me-1"></i>
                                                    {{ $registration->created_at->diffForHumans() }}
                                                </small>
                                                <span class="badge bg-{{ $registration->status == 'pending' ? 'warning' : ($registration->status == 'approved' ? 'success' : 'danger') }}">
                                                    {{ ucfirst($registration->status) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="ms-2">
                                            @if($registration->status == 'pending')
                                                <button class="btn btn-sm btn-outline-success" title="Approve">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-4">
                                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                        <p class="text-muted mb-0">No registrations found</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
@endsection
