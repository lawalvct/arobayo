@extends('layouts.admin')

@section('title', 'Event Details - Egbe Arobayo Admin')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="admin-page-title mb-1">
                        <i class="fas fa-calendar text-primary me-2"></i>
                        Event Details
                    </h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">
                                    <i class="fas fa-home me-1"></i>Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.events.index') }}" class="text-decoration-none">
                                    <i class="fas fa-calendar me-1"></i>Events
                                </a>
                            </li>
                            <li class="breadcrumb-item active">{{ Str::limit($event->title, 30) }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('events.show', $event->slug) }}" class="btn btn-outline-success" target="_blank">
                        <i class="fas fa-external-link-alt me-1"></i>
                        View Live
                    </a>
                    <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-1"></i>
                        Edit Event
                    </a>
                    <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>
                        Back to Events
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Left Column - Event Content -->
        <div class="col-xl-8 col-lg-7">
            <!-- Event Overview -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-gradient-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Event Overview
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-12">
                            <h3 class="text-primary mb-3">{{ $event->title }}</h3>
                        </div>

                        <div class="col-md-6">
                            <div class="info-box">
                                <label class="info-label">
                                    <i class="fas fa-calendar-alt me-2 text-primary"></i>
                                    Event Date & Time
                                </label>
                                <div class="info-content">
                                    <strong>{{ $event->event_date->format('l, F j, Y') }}</strong><br>
                                    <span class="text-muted">{{ $event->event_date->format('g:i A') }}</span>
                                </div>
                            </div>
                        </div>

                        @if($event->location)
                        <div class="col-md-6">
                            <div class="info-box">
                                <label class="info-label">
                                    <i class="fas fa-map-marker-alt me-2 text-danger"></i>
                                    Location
                                </label>
                                <div class="info-content">
                                    {{ $event->location }}
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="col-12">
                            <div class="info-box">
                                <label class="info-label">
                                    <i class="fas fa-align-left me-2 text-info"></i>
                                    Event Description
                                </label>
                                <div class="info-content">
                                    <div class="description-content">
                                        {!! nl2br(e($event->description)) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Event Image -->
            @if($event->image)
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-gradient-secondary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-image me-2"></i>
                        Event Image
                    </h5>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <img src="{{ asset('storage/' . $event->image) }}"
                             alt="{{ $event->title }}"
                             class="img-fluid rounded shadow-sm"
                             style="max-height: 400px; object-fit: cover;">
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column - Event Details & Actions -->
        <div class="col-xl-4 col-lg-5">
            <!-- Status & Settings -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-gradient-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-cog me-2"></i>
                        Event Status
                    </h5>
                </div>
                <div class="card-body">
                    <div class="status-grid">
                        <div class="status-item">
                            <div class="status-label">
                                <i class="fas fa-eye me-2"></i>
                                Publication Status
                            </div>
                            <div class="status-value">
                                @if($event->is_active)
                                    <span class="badge bg-success">Published</span>
                                @else
                                    <span class="badge bg-warning">Draft</span>
                                @endif
                            </div>
                        </div>

                        <div class="status-item">
                            <div class="status-label">
                                <i class="fas fa-star me-2"></i>
                                Featured Status
                            </div>
                            <div class="status-value">
                                @if($event->is_featured)
                                    <span class="badge bg-warning">Featured</span>
                                @else
                                    <span class="badge bg-secondary">Regular</span>
                                @endif
                            </div>
                        </div>

                        <div class="status-item">
                            <div class="status-label">
                                <i class="fas fa-clock me-2"></i>
                                Event Status
                            </div>
                            <div class="status-value">
                                @if($event->event_date->isFuture())
                                    <span class="badge bg-info">Upcoming</span>
                                @elseif($event->event_date->isToday())
                                    <span class="badge bg-success">Today</span>
                                @else
                                    <span class="badge bg-secondary">Past</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-gradient-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-bolt me-2"></i>
                        Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="action-buttons">
                        <a href="{{ route('admin.events.edit', $event) }}" class="action-btn primary">
                            <i class="fas fa-edit"></i>
                            <span>Edit Event</span>
                        </a>
                        <a href="{{ route('events.show', $event->slug) }}" class="action-btn success" target="_blank">
                            <i class="fas fa-external-link-alt"></i>
                            <span>View Live</span>
                        </a>
                        <button type="button" class="action-btn danger" onclick="confirmDelete()">
                            <i class="fas fa-trash"></i>
                            <span>Delete Event</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Event Information -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-gradient-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Event Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-link me-2"></i>
                                Slug
                            </div>
                            <div class="info-value">
                                <code class="url-display">{{ $event->slug }}</code>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-globe me-2"></i>
                                Public URL
                            </div>
                            <div class="info-value">
                                <a href="{{ route('events.show', $event->slug) }}" target="_blank" class="text-primary">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-calendar me-2"></i>
                                Created
                            </div>
                            <div class="info-value">
                                <small>{{ $event->created_at->format('M j, Y') }}<br>{{ $event->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-edit me-2"></i>
                                Last Modified
                            </div>
                            <div class="info-value">
                                <small>{{ $event->updated_at->format('M j, Y') }}<br>{{ $event->updated_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this event?</p>
                <p><strong>{{ $event->title }}</strong></p>
                <p class="text-danger"><i class="fas fa-exclamation-triangle me-2"></i>This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Event</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
/* Page Header */
.admin-page-title {
    color: #2596be;
    font-weight: 700;
    font-size: 1.75rem;
}

.breadcrumb {
    background: transparent;
    padding: 0;
    margin: 0;
    font-size: 0.9rem;
}

.breadcrumb-item a {
    color: #6c757d;
}

/* Cards */
.card {
    border: none;
    border-radius: 12px;
    overflow: hidden;
}

/* Gradient Headers */
.bg-gradient-primary {
    background: linear-gradient(135deg, #2596be 0%, #4b95c4 100%);
}

.bg-gradient-secondary {
    background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
}

.bg-gradient-success {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
}

.bg-gradient-info {
    background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%);
}

.bg-gradient-warning {
    background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
}

/* Info Boxes */
.info-box {
    margin-bottom: 1.5rem;
}

.info-label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 8px;
    display: block;
}

.info-content {
    background: #f8f9fa;
    padding: 12px 16px;
    border-radius: 8px;
    border-left: 4px solid #2596be;
}

.description-content {
    line-height: 1.6;
    color: #495057;
}

/* Status Grid */
.status-grid {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.status-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 8px 0;
    border-bottom: 1px solid #f1f3f4;
}

.status-item:last-child {
    border-bottom: none;
}

.status-label {
    font-weight: 500;
    color: #495057;
    font-size: 0.9rem;
}

.status-value {
    text-align: right;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.action-btn {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    border: none;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
    cursor: pointer;
    background: none;
    width: 100%;
}

.action-btn.primary {
    background: linear-gradient(135deg, #2596be, #4b95c4);
    color: white;
}

.action-btn.success {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
}

.action-btn.danger {
    background: linear-gradient(135deg, #dc3545, #c82333);
    color: white;
}

.action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    color: white;
}

.action-btn i {
    font-size: 1.1rem;
}

/* Info Grid */
.info-grid {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.info-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 8px 0;
    border-bottom: 1px solid #f1f3f4;
}

.info-item:last-child {
    border-bottom: none;
}

.info-label {
    font-weight: 500;
    color: #495057;
    font-size: 0.9rem;
    flex: 1;
}

.info-value {
    text-align: right;
    font-size: 0.85rem;
}

.url-display {
    background: #e9ecef;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 0.8rem;
    color: #2596be;
    font-weight: 600;
}

/* Responsive Design */
@media (max-width: 768px) {
    .admin-page-title {
        font-size: 1.5rem;
    }

    .info-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 4px;
    }

    .info-value {
        text-align: left;
    }
}
</style>
@endsection

@section('scripts')
<script>
function confirmDelete() {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}
</script>
@endsection
