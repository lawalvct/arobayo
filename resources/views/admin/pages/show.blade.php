@extends('layouts.admin')

@section('title', 'View Page - Egbe Arobayo')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="admin-page-title mb-1">
                        <i class="fas fa-eye text-primary me-2"></i>
                        {{ $page->title }}
                    </h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.pages.index') }}" class="text-decoration-none">
                                    <i class="fas fa-file-alt me-1"></i>Pages
                                </a>
                            </li>
                            <li class="breadcrumb-item active">{{ $page->title }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>
                        Back
                    </a>
                    <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-1"></i>
                        Edit
                    </a>
                    <a href="{{ url($page->slug === 'home' ? '/' : '/' . $page->slug) }}"
                       class="btn btn-success" target="_blank">
                        <i class="fas fa-external-link-alt me-1"></i>
                        View Live
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="row">
        <!-- Left Column - Page Content -->
        <div class="col-xl-8 col-lg-7 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-gradient-primary text-white">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-desktop me-2"></i>
                        <h5 class="mb-0">Page Preview</h5>
                        @if($page->isHomePage())
                            <span class="badge bg-warning ms-auto">
                                <i class="fas fa-home me-1"></i>
                                Home Page
                            </span>
                        @endif
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($page->isHomePage())
                        <!-- Home Page Sections -->
                        <div class="bg-light p-3 border-bottom">
                            <div class="alert alert-info mb-0">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Special Home Page:</strong> This page contains dynamic sections stored in JSON format.
                                <a href="{{ route('admin.pages.edit', $page) }}" class="alert-link">
                                    <i class="fas fa-cog ms-2"></i>Manage Sections
                                </a>
                            </div>
                        </div>

                        <div class="p-4">

                            @if(isset($homeContent) && is_array($homeContent) && !empty($homeContent))
                                @php
                                    // Safely get values with defaults
                                    $heroEnabled = isset($homeContent['hero']['enabled']) ? $homeContent['hero']['enabled'] : true;
                                    $heroSlides = isset($homeContent['hero']['slides']) && is_array($homeContent['hero']['slides']) ? $homeContent['hero']['slides'] : [];
                                    $missionEnabled = isset($homeContent['mission']['enabled']) ? $homeContent['mission']['enabled'] : true;
                                    $historyEnabled = isset($homeContent['history']['enabled']) ? $homeContent['history']['enabled'] : true;
                                    $executivesEnabled = isset($homeContent['executives']['enabled']) ? $homeContent['executives']['enabled'] : true;
                                    $ctaEnabled = isset($homeContent['cta']['enabled']) ? $homeContent['cta']['enabled'] : true;
                                    $eventsEnabled = isset($homeContent['events']['enabled']) ? $homeContent['events']['enabled'] : true;
                                @endphp

                                <!-- Hero/Slider Section -->
                                <div class="section-preview-card mb-4">
                                    <div class="section-header">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-images text-primary me-2"></i>
                                            <h6 class="mb-0 fw-bold">Hero/Slider Section</h6>
                                        </div>
                                        <span class="badge {{ $heroEnabled ? 'bg-success' : 'bg-danger' }} px-3">
                                            <i class="fas fa-{{ $heroEnabled ? 'check' : 'times' }} me-1"></i>
                                            {{ $heroEnabled ? 'Enabled' : 'Disabled' }}
                                        </span>
                                    </div>
                                    @if($heroEnabled && !empty($heroSlides))
                                        <div class="section-content">
                                            <div class="row g-3">
                                                @foreach($heroSlides as $index => $slide)
                                                    <div class="col-lg-6">
                                                        <div class="slide-card">
                                                            <div class="slide-header">
                                                                <i class="fas fa-play-circle me-1"></i>
                                                                Slide {{ $index + 1 }}
                                                            </div>
                                                            <div class="slide-content">
                                                                <h6 class="slide-title">
                                                                    {{ is_array($slide['title'] ?? 'No Title') ? 'Array Data' : ($slide['title'] ?? 'No Title') }}
                                                                </h6>
                                                                <p class="slide-subtitle">
                                                                    {{ is_array($slide['subtitle'] ?? 'No Subtitle') ? 'Array Data' : \Illuminate\Support\Str::limit($slide['subtitle'] ?? 'No Subtitle', 80) }}
                                                                </p>
                                                                @if(!empty($slide['button_text']) && !is_array($slide['button_text']))
                                                                    <span class="btn-preview">
                                                                        <i class="fas fa-mouse-pointer me-1"></i>
                                                                        {{ $slide['button_text'] }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        <div class="section-empty">
                                            <i class="fas fa-image"></i>
                                            <p>No slides configured or section is disabled</p>
                                        </div>
                                    @endif
                                </div>

                                <!-- Mission/Vision/Objectives Section -->
                                <div class="section-preview-card mb-4">
                                    <div class="section-header">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-bullseye text-success me-2"></i>
                                            <h6 class="mb-0 fw-bold">Mission, Vision & Objectives</h6>
                                        </div>
                                        <span class="badge {{ $missionEnabled ? 'bg-success' : 'bg-danger' }} px-3">
                                            <i class="fas fa-{{ $missionEnabled ? 'check' : 'times' }} me-1"></i>
                                            {{ $missionEnabled ? 'Enabled' : 'Disabled' }}
                                        </span>
                                    </div>
                                    @if($missionEnabled)
                                        <div class="section-content">
                                            <div class="row g-3">
                                                <div class="col-md-4">
                                                    <div class="mission-card vision-card">
                                                        <div class="mission-icon">
                                                            <i class="fas fa-eye"></i>
                                                        </div>
                                                        <h6 class="mission-title">Vision</h6>
                                                        <p class="mission-text">{{ isset($homeContent['mission']['vision']) ? (is_array($homeContent['mission']['vision']) ? 'Array Data' : $homeContent['mission']['vision']) : 'No vision text' }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mission-card mission-card-main">
                                                        <div class="mission-icon">
                                                            <i class="fas fa-bullseye"></i>
                                                        </div>
                                                        <h6 class="mission-title">Mission</h6>
                                                        <p class="mission-text">{{ isset($homeContent['mission']['mission']) ? (is_array($homeContent['mission']['mission']) ? 'Array Data' : $homeContent['mission']['mission']) : 'No mission text' }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mission-card objectives-card">
                                                        <div class="mission-icon">
                                                            <i class="fas fa-target"></i>
                                                        </div>
                                                        <h6 class="mission-title">Objectives</h6>
                                                        <p class="mission-text">{{ isset($homeContent['mission']['objective']) ? (is_array($homeContent['mission']['objective']) ? 'Array Data' : $homeContent['mission']['objective']) : 'No objective text' }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="section-empty">
                                            <i class="fas fa-bullseye"></i>
                                            <p>Mission section is disabled</p>
                                        </div>
                                    @endif
                                </div>

                                <!-- History Section -->
                                <div class="section-preview-card mb-4">
                                    <div class="section-header">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-history text-info me-2"></i>
                                            <h6 class="mb-0 fw-bold">{{ isset($homeContent['history']['title']) ? (is_array($homeContent['history']['title']) ? 'Array Data' : $homeContent['history']['title']) : 'History Section' }}</h6>
                                        </div>
                                        <span class="badge {{ $historyEnabled ? 'bg-success' : 'bg-danger' }} px-3">
                                            <i class="fas fa-{{ $historyEnabled ? 'check' : 'times' }} me-1"></i>
                                            {{ $historyEnabled ? 'Enabled' : 'Disabled' }}
                                        </span>
                                    </div>
                                    @if($historyEnabled)
                                        <div class="section-content">
                                            <div class="history-preview">
                                                <p class="history-text">{{ isset($homeContent['history']['text']) ? (is_array($homeContent['history']['text']) ? 'Array Data' : \Illuminate\Support\Str::limit($homeContent['history']['text'], 200)) : 'No history text' }}</p>
                                                @if(isset($homeContent['history']['image']) && !empty($homeContent['history']['image']) && !is_array($homeContent['history']['image']))
                                                    <div class="history-image">
                                                        <i class="fas fa-image me-2"></i>
                                                        <span class="text-muted">Image: {{ $homeContent['history']['image'] }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @else
                                        <div class="section-empty">
                                            <i class="fas fa-history"></i>
                                            <p>History section is disabled</p>
                                        </div>
                                    @endif
                                </div>

                                <!-- Additional Sections Summary -->
                                <div class="section-preview-card mb-4">
                                    <div class="section-header">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-th-large text-warning me-2"></i>
                                            <h6 class="mb-0 fw-bold">Other Sections</h6>
                                        </div>
                                    </div>
                                    <div class="section-content">
                                        <div class="row g-3">
                                            <div class="col-lg-4">
                                                <div class="other-section-card">
                                                    <div class="section-icon executives">
                                                        <i class="fas fa-users"></i>
                                                    </div>
                                                    <h6>Executives</h6>
                                                    <p>{{ isset($homeContent['executives']['title']) ? (is_array($homeContent['executives']['title']) ? 'Array Data' : $homeContent['executives']['title']) : 'Our Executives' }}</p>
                                                    <span class="badge {{ $executivesEnabled ? 'bg-success' : 'bg-danger' }}">
                                                        {{ $executivesEnabled ? 'Enabled' : 'Disabled' }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="other-section-card">
                                                    <div class="section-icon cta">
                                                        <i class="fas fa-bullhorn"></i>
                                                    </div>
                                                    <h6>Call to Action</h6>
                                                    <p>{{ isset($homeContent['cta']['title']) ? (is_array($homeContent['cta']['title']) ? 'Array Data' : $homeContent['cta']['title']) : 'Join Us Today' }}</p>
                                                    <span class="badge {{ $ctaEnabled ? 'bg-success' : 'bg-danger' }}">
                                                        {{ $ctaEnabled ? 'Enabled' : 'Disabled' }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="other-section-card">
                                                    <div class="section-icon events">
                                                        <i class="fas fa-calendar-alt"></i>
                                                    </div>
                                                    <h6>Latest Events</h6>
                                                    <p>{{ isset($homeContent['events']['title']) ? (is_array($homeContent['events']['title']) ? 'Array Data' : $homeContent['events']['title']) : 'Latest Events' }}</p>
                                                    <span class="badge {{ $eventsEnabled ? 'bg-success' : 'bg-danger' }}">
                                                        {{ $eventsEnabled ? 'Enabled' : 'Disabled' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="no-content-warning">
                                    <div class="text-center p-5">
                                        <i class="fas fa-exclamation-triangle text-warning fa-3x mb-3"></i>
                                        <h5>Home Page Content Not Available</h5>
                                        <p class="text-muted">The home page content is not properly configured.</p>
                                        <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-primary">
                                            <i class="fas fa-cog me-2"></i>Configure Home Page
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @else
                        <!-- Regular Page Content -->
                        <div class="p-4">
                            <div class="regular-page-preview">
                                <div class="content-preview">
                                    {!! $page->content !!}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column - Page Information -->
        <div class="col-xl-4 col-lg-5">
            <!-- Page Status Card -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-gradient-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Page Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-toggle-{{ $page->is_active ? 'on text-success' : 'off text-danger' }} me-2"></i>
                                Status
                            </div>
                            <div class="info-value">
                                <span class="badge {{ $page->is_active ? 'bg-success' : 'bg-danger' }} px-3">
                                    <i class="fas fa-{{ $page->is_active ? 'eye' : 'eye-slash' }} me-1"></i>
                                    {{ $page->is_active ? 'Published' : 'Draft' }}
                                </span>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-layer-group me-2"></i>
                                Template
                            </div>
                            <div class="info-value">
                                <span class="badge {{ $page->template === 'home' ? 'bg-warning' : 'bg-secondary' }} px-3">
                                    <i class="fas fa-{{ $page->template === 'home' ? 'home' : 'file-alt' }} me-1"></i>
                                    {{ ucfirst($page->template) }}
                                </span>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-link me-2"></i>
                                URL
                            </div>
                            <div class="info-value">
                                <code class="url-display">/{{ $page->slug === 'home' ? '' : $page->slug }}</code>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-calendar-plus me-2"></i>
                                Created
                            </div>
                            <div class="info-value">
                                <small>{{ $page->created_at->format('M d, Y') }}</small>
                                <br>
                                <small class="text-muted">{{ $page->created_at->format('h:i A') }}</small>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-calendar-edit me-2"></i>
                                Last Modified
                            </div>
                            <div class="info-value">
                                <small>{{ $page->updated_at->format('M d, Y') }}</small>
                                <br>
                                <small class="text-success">{{ $page->updated_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SEO Information -->
            @if($page->meta_title || $page->meta_description)
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-gradient-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-search me-2"></i>
                        SEO Settings
                    </h5>
                </div>
                <div class="card-body">
                    @if($page->meta_title)
                        <div class="seo-item mb-3">
                            <label class="seo-label">
                                <i class="fas fa-heading me-2"></i>Meta Title
                            </label>
                            <div class="seo-content">{{ $page->meta_title }}</div>
                        </div>
                    @endif
                    @if($page->meta_description)
                        <div class="seo-item">
                            <label class="seo-label">
                                <i class="fas fa-align-left me-2"></i>Meta Description
                            </label>
                            <div class="seo-content">{{ $page->meta_description }}</div>
                        </div>
                    @endif
                </div>
            </div>
            @else
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-gradient-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fas fa-search me-2"></i>
                        SEO Settings
                    </h5>
                </div>
                <div class="card-body text-center">
                    <i class="fas fa-exclamation-circle text-warning fa-2x mb-3"></i>
                    <p class="text-muted mb-3">No custom SEO settings configured</p>
                    <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-sm btn-warning">
                        <i class="fas fa-plus me-1"></i>Add SEO Settings
                    </a>
                </div>
            </div>
            @endif

            <!-- Quick Actions -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-gradient-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-bolt me-2"></i>
                        Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="action-buttons">
                        <a href="{{ route('admin.pages.edit', $page) }}" class="action-btn primary">
                            <i class="fas fa-edit"></i>
                            <span>Edit Page</span>
                        </a>
                        <a href="{{ url($page->slug === 'home' ? '/' : '/' . $page->slug) }}"
                           class="action-btn success" target="_blank">
                            <i class="fas fa-external-link-alt"></i>
                            <span>View Live</span>
                        </a>
                        @if($page->slug !== 'home')
                            <button type="button" class="action-btn danger"
                                    onclick="confirmDelete('{{ $page->id }}', '{{ $page->title }}')">
                                <i class="fas fa-trash"></i>
                                <span>Delete Page</span>
                            </button>
                        @endif
                    </div>
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

.card-header.bg-gradient-primary {
    background: linear-gradient(135deg, #2596be 0%, #4b95c4 100%);
    border: none;
}

.card-header.bg-gradient-info {
    background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%);
    border: none;
}

.card-header.bg-gradient-success {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    border: none;
}

.card-header.bg-gradient-warning {
    background: linear-gradient(135deg, #f3d40a 0%, #ffc107 100%);
    border: none;
}

/* Section Preview Cards */
.section-preview-card {
    background: #fff;
    border: 1px solid #e9ecef;
    border-radius: 10px;
    overflow: hidden;
}

.section-header {
    background: #f8f9fa;
    padding: 15px 20px;
    border-bottom: 1px solid #e9ecef;
    display: flex;
    align-items: center;
    justify-content: between;
}

.section-content {
    padding: 20px;
}

.section-empty {
    text-align: center;
    padding: 40px 20px;
    color: #6c757d;
}

.section-empty i {
    font-size: 2.5rem;
    margin-bottom: 15px;
    opacity: 0.5;
}

/* Slide Cards */
.slide-card {
    background: #fff;
    border: 2px solid #2596be;
    border-radius: 8px;
    overflow: hidden;
    height: 100%;
}

.slide-header {
    background: #2596be;
    color: white;
    padding: 8px 15px;
    font-size: 0.85rem;
    font-weight: 600;
}

.slide-content {
    padding: 15px;
}

.slide-title {
    font-size: 0.95rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 8px;
}

.slide-subtitle {
    font-size: 0.85rem;
    color: #6c757d;
    line-height: 1.4;
    margin-bottom: 10px;
}

.btn-preview {
    display: inline-block;
    background: #2596be;
    color: white;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
}

/* Mission Cards */
.mission-card {
    background: #fff;
    border: 2px solid #e9ecef;
    border-radius: 10px;
    padding: 20px;
    text-align: center;
    height: 100%;
    transition: all 0.3s ease;
}

.mission-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.vision-card {
    border-color: #17a2b8;
}

.mission-card-main {
    border-color: #28a745;
}

.objectives-card {
    border-color: #6f42c1;
}

.mission-icon {
    font-size: 2rem;
    margin-bottom: 15px;
}

.vision-card .mission-icon {
    color: #17a2b8;
}

.mission-card-main .mission-icon {
    color: #28a745;
}

.objectives-card .mission-icon {
    color: #6f42c1;
}

.mission-title {
    font-weight: 600;
    margin-bottom: 10px;
    color: #333;
}

.mission-text {
    font-size: 0.9rem;
    color: #6c757d;
    line-height: 1.5;
}

/* History Section */
.history-preview {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    border-left: 4px solid #17a2b8;
}

.history-text {
    font-size: 0.95rem;
    line-height: 1.6;
    color: #495057;
    margin-bottom: 10px;
}

.history-image {
    font-size: 0.85rem;
}

/* Other Sections */
.other-section-card {
    background: #fff;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 20px;
    text-align: center;
    height: 100%;
}

.section-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 15px;
    font-size: 1.5rem;
    color: white;
}

.section-icon.executives {
    background: linear-gradient(135deg, #6f42c1, #8b5cf6);
}

.section-icon.cta {
    background: linear-gradient(135deg, #f3d40a, #ffc107);
}

.section-icon.events {
    background: linear-gradient(135deg, #e74c3c, #ff6b6b);
}

/* Info Grid */
.info-grid {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.info-item {
    display: flex;
    align-items: center;
    justify-content: between;
    padding: 10px 0;
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

/* SEO Section */
.seo-item {
    border-left: 3px solid #28a745;
    padding-left: 15px;
}

.seo-label {
    font-size: 0.85rem;
    font-weight: 600;
    color: #495057;
    display: block;
    margin-bottom: 5px;
}

.seo-content {
    font-size: 0.9rem;
    color: #6c757d;
    line-height: 1.5;
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
    background: linear-gradient(135deg, #dc3545, #e74c3c);
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

/* Regular Page Content */
.regular-page-preview {
    background: #fff;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    overflow: hidden;
}

.content-preview {
    padding: 30px;
    font-family: Georgia, serif;
    line-height: 1.8;
}

.content-preview h1,
.content-preview h2,
.content-preview h3 {
    color: #2596be;
    margin-bottom: 20px;
}

/* No Content Warning */
.no-content-warning {
    background: #fff3cd;
    border: 1px solid #f3d40a;
    border-radius: 8px;
}

/* Responsive */
@media (max-width: 768px) {
    .admin-page-title {
        font-size: 1.5rem;
    }

    .section-header {
        flex-direction: column;
        gap: 10px;
        text-align: center;
    }

    .info-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 5px;
    }

    .info-value {
        text-align: left;
    }
}
</style>
@endsection

@section('scripts')
@if($page->slug !== 'home')
<script>
function confirmDelete(pageId, pageTitle) {
    // Set the form action with the correct route
    const form = document.getElementById('deleteForm');
    const route = '{{ route("admin.pages.destroy", ":id") }}';
    form.action = route.replace(':id', pageId);

    // Show the modal
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}
</script>
@endif
@endsection
