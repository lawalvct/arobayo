@extends('layouts.admin')

@section('title', 'Edit Event - Egbe Arobayo Admin')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="admin-page-title mb-1">
                        <i class="fas fa-edit text-primary me-2"></i>
                        Edit Event
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
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('events.show', $event->slug) }}" class="btn btn-outline-success" target="_blank">
                        <i class="fas fa-eye me-1"></i>
                        View Live
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

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('admin.events.update', $event) }}" method="POST" enctype="multipart/form-data" id="eventForm">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- Left Column - Main Content -->
            <div class="col-xl-8 col-lg-7">
                <!-- Basic Information -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-gradient-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            Basic Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="title" class="form-label fw-semibold">Event Title *</label>
                                <input type="text" class="form-control" id="title" name="title"
                                       value="{{ old('title', $event->title) }}" required
                                       placeholder="Enter event title">
                            </div>
                            <div class="col-md-6">
                                <label for="event_date" class="form-label fw-semibold">Event Date *</label>
                                <input type="datetime-local" class="form-control" id="event_date" name="event_date"
                                       value="{{ old('event_date', $event->event_date->format('Y-m-d\TH:i')) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="location" class="form-label fw-semibold">Location</label>
                                <input type="text" class="form-control" id="location" name="location"
                                       value="{{ old('location', $event->location) }}"
                                       placeholder="Event venue or address">
                            </div>
                            <div class="col-12">
                                <label for="description" class="form-label fw-semibold">Description *</label>
                                <textarea class="form-control" id="description" name="description" rows="6" required
                                          placeholder="Describe the event details, activities, and what attendees can expect...">{{ old('description', $event->description) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Event Image -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-gradient-secondary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-image me-2"></i>
                            Event Image
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="image" class="form-label fw-semibold">Upload New Image</label>
                                <input type="file" class="form-control" id="image" name="image"
                                       accept="image/jpeg,image/png,image/jpg,image/gif">
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Leave empty to keep current image. Recommended size: 1200x600px. Max file size: 2MB.
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Current Image</label>
                                <div class="image-preview border rounded" style="height: 150px; display: flex; align-items: center; justify-content: center; background: #f8f9fa;">
                                    @if($event->image)
                                        <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}"
                                             style="width: 100%; height: 150px; object-fit: cover; border-radius: 8px;">
                                    @else
                                        <div class="text-center text-muted">
                                            <i class="fas fa-image fa-2x mb-2"></i>
                                            <p class="mb-0">No image uploaded</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Settings & Actions -->
            <div class="col-xl-4 col-lg-5">
                <!-- Publishing Options -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-gradient-success text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-cog me-2"></i>
                            Publishing Options
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                           value="1" {{ old('is_active', $event->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold" for="is_active">
                                        <i class="fas fa-eye me-1"></i>
                                        Published & Visible
                                    </label>
                                    <div class="form-text">
                                        Event will be visible to website visitors
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured"
                                           value="1" {{ old('is_featured', $event->is_featured) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold" for="is_featured">
                                        <i class="fas fa-star me-1"></i>
                                        Featured Event
                                    </label>
                                    <div class="form-text">
                                        Mark as featured to highlight on homepage
                                    </div>
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
                            Actions
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>
                                Update Event
                            </button>
                            <button type="submit" name="save_and_continue" value="1" class="btn btn-outline-primary">
                                <i class="fas fa-save me-2"></i>
                                Save & Continue Editing
                            </button>
                            <a href="{{ route('events.show', $event->slug) }}" class="btn btn-outline-success" target="_blank">
                                <i class="fas fa-external-link-alt me-2"></i>
                                View Live Event
                            </a>
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
                                    <i class="fas fa-calendar me-2"></i>
                                    Created
                                </div>
                                <div class="info-value">
                                    <small>{{ $event->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-edit me-2"></i>
                                    Last Modified
                                </div>
                                <div class="info-value">
                                    <small>{{ $event->updated_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@include('admin.partials.image-modal')
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

/* Form Enhancements */
.form-label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 8px;
}

.form-control {
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    padding: 10px 15px;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #2596be;
    box-shadow: 0 0 0 0.2rem rgba(37, 150, 190, 0.25);
}

/* Enhanced Switches */
.form-check-input:checked {
    background-color: #2596be;
    border-color: #2596be;
}

.form-check-input:focus {
    border-color: #2596be;
    box-shadow: 0 0 0 0.25rem rgba(37, 150, 190, 0.25);
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
}
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Image preview functionality for new uploads
    const imageInput = document.getElementById('image');
    const imagePreview = document.querySelector('.image-preview');

    if (imageInput && imagePreview) {
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.innerHTML = `<img src="${e.target.result}" alt="Preview" style="width: 100%; height: 150px; object-fit: cover; border-radius: 8px;">`;
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Form validation
    const form = document.getElementById('eventForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            const title = document.getElementById('title').value.trim();
            const description = document.getElementById('description').value.trim();
            const eventDate = document.getElementById('event_date').value;

            if (!title) {
                e.preventDefault();
                alert('Please enter an event title.');
                document.getElementById('title').focus();
                return;
            }

            if (!description) {
                e.preventDefault();
                alert('Please enter an event description.');
                document.getElementById('description').focus();
                return;
            }

            if (!eventDate) {
                e.preventDefault();
                alert('Please select an event date.');
                document.getElementById('event_date').focus();
                return;
            }
        });
    }
});
</script>
@endsection
