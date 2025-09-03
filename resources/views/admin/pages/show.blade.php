@extends('layouts.admin')

@section('title', 'View Page - Egbe Arobayo')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="admin-page-title">
            <i class="fas fa-eye me-3"></i>
            View Page
        </h2>
        <p class="admin-page-subtitle mb-0">
            Preview "{{ $page->title }}"
        </p>
    </div>
    <div>
        <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary me-2">
            <i class="fas fa-arrow-left me-2"></i>
            Back to Pages
        </a>
        <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-outline-primary me-2">
            <i class="fas fa-edit me-2"></i>
            Edit Page
        </a>
        <a href="{{ url($page->slug === 'home' ? '/' : '/' . $page->slug) }}"
           class="btn btn-outline-success" target="_blank">
            <i class="fas fa-external-link-alt me-2"></i>
            View Live
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Page Preview -->
        <div class="admin-card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-desktop me-2"></i>
                    Page Preview
                </h5>
            </div>
            <div class="card-body">
                @if($page->isHomePage())
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        This is the home page with special sections. The content below is stored in JSON format.
                        <a href="{{ route('admin.pages.edit', $page) }}" class="alert-link">Edit home sections</a>
                    </div>

                    @php
                        $homeContent = $page->home_content;
                    @endphp

                    <div class="home-sections-preview">
                        <!-- Hero Section -->
                        <div class="section-preview mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <h6 class="mb-0 me-3">Hero/Slider Section</h6>
                                <span class="badge {{ $homeContent['hero']['enabled'] ? 'bg-success' : 'bg-danger' }}">
                                    {{ $homeContent['hero']['enabled'] ? 'Enabled' : 'Disabled' }}
                                </span>
                            </div>
                            @if($homeContent['hero']['enabled'] && !empty($homeContent['hero']['slides']))
                                <div class="row">
                                    @foreach($homeContent['hero']['slides'] as $index => $slide)
                                        <div class="col-md-6 mb-3">
                                            <div class="card border-primary">
                                                <div class="card-header bg-primary text-white py-2">
                                                    <small>Slide {{ $index + 1 }}</small>
                                                </div>
                                                <div class="card-body">
                                                    <h6 class="card-title">{{ $slide['title'] ?? 'No Title' }}</h6>
                                                    <p class="card-text text-muted">{{ $slide['subtitle'] ?? 'No Subtitle' }}</p>
                                                    @if(!empty($slide['button_text']))
                                                        <a href="#" class="btn btn-sm btn-primary">{{ $slide['button_text'] }}</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <!-- Mission Section -->
                        <div class="section-preview mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <h6 class="mb-0 me-3">{{ $homeContent['mission']['title'] ?? 'Mission Section' }}</h6>
                                <span class="badge {{ $homeContent['mission']['enabled'] ? 'bg-success' : 'bg-danger' }}">
                                    {{ $homeContent['mission']['enabled'] ? 'Enabled' : 'Disabled' }}
                                </span>
                            </div>
                            @if($homeContent['mission']['enabled'])
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h6 class="card-title text-primary">Vision</h6>
                                                <p class="card-text">{{ $homeContent['mission']['vision'] ?? 'No vision text' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h6 class="card-title text-success">Mission</h6>
                                                <p class="card-text">{{ $homeContent['mission']['mission'] ?? 'No mission text' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h6 class="card-title text-info">Objectives</h6>
                                                <p class="card-text">{{ $homeContent['mission']['objective'] ?? 'No objective text' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- History Section -->
                        <div class="section-preview mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <h6 class="mb-0 me-3">{{ $homeContent['history']['title'] ?? 'History Section' }}</h6>
                                <span class="badge {{ $homeContent['history']['enabled'] ? 'bg-success' : 'bg-danger' }}">
                                    {{ $homeContent['history']['enabled'] ? 'Enabled' : 'Disabled' }}
                                </span>
                            </div>
                            @if($homeContent['history']['enabled'])
                                <div class="card">
                                    <div class="card-body">
                                        <p>{{ $homeContent['history']['text'] ?? 'No history text' }}</p>
                                        @if(!empty($homeContent['history']['image']))
                                            <small class="text-muted">Image: {{ $homeContent['history']['image'] }}</small>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Other sections -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="section-preview mb-4">
                                    <div class="d-flex align-items-center mb-2">
                                        <h6 class="mb-0 me-2">Executives</h6>
                                        <span class="badge {{ $homeContent['executives']['enabled'] ? 'bg-success' : 'bg-danger' }}">
                                            {{ $homeContent['executives']['enabled'] ? 'On' : 'Off' }}
                                        </span>
                                    </div>
                                    <small class="text-muted">{{ $homeContent['executives']['title'] ?? 'Our Executives' }}</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="section-preview mb-4">
                                    <div class="d-flex align-items-center mb-2">
                                        <h6 class="mb-0 me-2">Call to Action</h6>
                                        <span class="badge {{ $homeContent['cta']['enabled'] ? 'bg-success' : 'bg-danger' }}">
                                            {{ $homeContent['cta']['enabled'] ? 'On' : 'Off' }}
                                        </span>
                                    </div>
                                    <small class="text-muted">{{ $homeContent['cta']['title'] ?? 'Join Us Today' }}</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="section-preview mb-4">
                                    <div class="d-flex align-items-center mb-2">
                                        <h6 class="mb-0 me-2">Latest Events</h6>
                                        <span class="badge {{ $homeContent['events']['enabled'] ? 'bg-success' : 'bg-danger' }}">
                                            {{ $homeContent['events']['enabled'] ? 'On' : 'Off' }}
                                        </span>
                                    </div>
                                    <small class="text-muted">{{ $homeContent['events']['title'] ?? 'Latest Events' }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Regular page content -->
                    <div class="page-content-preview">
                        {!! $page->content !!}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Page Details -->
        <div class="admin-card mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Page Details
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-12">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Status:</span>
                            <span>
                                @if($page->is_active)
                                    <span class="badge bg-success">
                                        <i class="fas fa-eye me-1"></i>
                                        Active
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        <i class="fas fa-eye-slash me-1"></i>
                                        Inactive
                                    </span>
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Template:</span>
                            <span>
                                <span class="badge {{ $page->template === 'home' ? 'bg-warning' : 'bg-secondary' }}">
                                    {{ ucfirst($page->template) }}
                                </span>
                            </span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">URL:</span>
                            <span class="fw-bold text-primary">
                                /{{ $page->slug === 'home' ? '' : $page->slug }}
                            </span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Created:</span>
                            <span>{{ $page->created_at->format('M d, Y h:i A') }}</span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Modified:</span>
                            <span>{{ $page->updated_at->format('M d, Y h:i A') }}</span>
                        </div>
                    </div>
                    @if($page->updated_at != $page->created_at)
                    <div class="col-12">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Last Update:</span>
                            <span class="text-success">{{ $page->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- SEO Information -->
        @if($page->meta_title || $page->meta_description)
        <div class="admin-card mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">
                    <i class="fas fa-search me-2"></i>
                    SEO Information
                </h5>
            </div>
            <div class="card-body">
                @if($page->meta_title)
                    <div class="mb-3">
                        <label class="form-label text-muted">Meta Title:</label>
                        <p class="fw-bold">{{ $page->meta_title }}</p>
                    </div>
                @endif
                @if($page->meta_description)
                    <div class="mb-3">
                        <label class="form-label text-muted">Meta Description:</label>
                        <p>{{ $page->meta_description }}</p>
                    </div>
                @endif
                @if(!$page->meta_title && !$page->meta_description)
                    <p class="text-muted mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        No custom SEO settings. Using default page title.
                    </p>
                @endif
            </div>
        </div>
        @endif

        <!-- Quick Actions -->
        <div class="admin-card">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0">
                    <i class="fas fa-bolt me-2"></i>
                    Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.pages.edit', $page) }}" class="btn admin-btn-primary">
                        <i class="fas fa-edit me-2"></i>
                        Edit Page
                    </a>
                    <a href="{{ url($page->slug === 'home' ? '/' : '/' . $page->slug) }}"
                       class="btn btn-outline-success" target="_blank">
                        <i class="fas fa-external-link-alt me-2"></i>
                        View Live Page
                    </a>
                    @if($page->slug !== 'home')
                        <button type="button" class="btn btn-outline-danger"
                                onclick="confirmDelete('{{ $page->id }}', '{{ $page->title }}')">
                            <i class="fas fa-trash me-2"></i>
                            Delete Page
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@if($page->slug !== 'home')
<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                    Confirm Deletion
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this page?</p>
                <div class="alert alert-warning">
                    <i class="fas fa-info-circle me-2"></i>
                    This action cannot be undone. The page will be moved to trash and can be restored later.
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>
                        Delete Page
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@section('styles')
<style>
.admin-page-title {
    color: #2596be;
    font-weight: 700;
    font-size: 2rem;
    margin: 0;
}

.admin-page-subtitle {
    color: #6c757d;
    font-size: 1rem;
}

.section-preview {
    padding: 15px;
    border-left: 4px solid #e9ecef;
    background: #f8f9fa;
    border-radius: 5px;
}

.page-content-preview {
    background: white;
    padding: 20px;
    border: 1px solid #dee2e6;
    border-radius: 8px;
}

.page-content-preview h1,
.page-content-preview h2,
.page-content-preview h3 {
    color: #2596be;
}

.badge {
    font-size: 0.75rem;
}
</style>
@endsection

@section('scripts')
@if($page->slug !== 'home')
<script>
function confirmDelete(pageId, pageTitle) {
    document.getElementById('deleteForm').action = '{{ route("admin.pages.destroy", ":id") }}'.replace(':id', pageId);

    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}
</script>
@endif
@endsection
