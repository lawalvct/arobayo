@extends('layouts.admin')

@section('title', 'Edit Home Page - Egbe Arobayo')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="admin-page-title mb-1">
                        <i class="fas fa-home text-primary me-2"></i>
                        Edit Home Page
                    </h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.pages.index') }}" class="text-decoration-none">
                                    <i class="fas fa-file-alt me-1"></i>Pages
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.pages.show', $page) }}" class="text-decoration-none">
                                    {{ $page->title }}
                                </a>
                            </li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.pages.show', $page) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-eye me-1"></i>
                        Preview
                    </a>
                    <a href="{{ route('home') }}" class="btn btn-outline-success" target="_blank">
                        <i class="fas fa-external-link-alt me-1"></i>
                        View Live
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

    <form action="{{ route('admin.pages.update', $page) }}" method="POST" id="homePageForm">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- Left Column - Main Content -->
            <div class="col-xl-8 col-lg-7">
                <!-- Basic Settings -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-gradient-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-cog me-2"></i>
                            Basic Settings
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="title" class="form-label fw-semibold">Page Title</label>
                                <input type="text" class="form-control" id="title" name="title"
                                       value="{{ old('title', $page->title) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="meta_title" class="form-label fw-semibold">Meta Title (SEO)</label>
                                <input type="text" class="form-control" id="meta_title" name="meta_title"
                                       value="{{ old('meta_title', $page->meta_title) }}">
                            </div>
                            <div class="col-12">
                                <label for="meta_description" class="form-label fw-semibold">Meta Description (SEO)</label>
                                <textarea class="form-control" id="meta_description" name="meta_description" rows="2"
                                          placeholder="Brief description of your home page for search engines">{{ old('meta_description', $page->meta_description) }}</textarea>
                            </div>
                            <div class="col-12">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                           value="1" {{ old('is_active', $page->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold" for="is_active">
                                        <i class="fas fa-toggle-on me-1"></i>
                                        Page Active & Visible
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hero/Slider Section -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-gradient-hero text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="fas fa-images me-2"></i>
                                Hero Slider Section
                            </h5>
                            <div class="form-check form-switch">
                                <input class="form-check-input section-toggle" type="checkbox" id="hero_enabled" name="hero_enabled"
                                       value="1" {{ old('hero_enabled', (isset($homeSettings['hero']['enabled']) && $homeSettings['hero']['enabled']) ? true : false) ? 'checked' : '' }}>
                                <label class="form-check-label text-white fw-semibold" for="hero_enabled">
                                    Enable Section
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="card-body section-body" id="heroSection">
                        <div class="section-description mb-4">
                            <div class="alert alert-info border-0">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Hero Slider:</strong> Create engaging slides with images, titles, and call-to-action buttons to capture visitor attention.
                            </div>
                        </div>

                        <div id="heroSlides">
                            @php
                                $slides = old('hero_slides', isset($homeSettings['hero']['slides']) && is_array($homeSettings['hero']['slides']) ? $homeSettings['hero']['slides'] : []);
                                if (empty($slides)) {
                                    $slides = [['title' => '', 'subtitle' => '', 'button_text' => '', 'button_link' => '', 'image' => '']];
                                }
                            @endphp

                            @foreach($slides as $index => $slide)
                                <div class="slide-editor-card mb-4" data-slide="{{ $index }}">
                                    <div class="slide-header">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0 fw-bold">
                                                <i class="fas fa-play-circle me-2"></i>
                                                Slide {{ $index + 1 }}
                                            </h6>
                                            <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeSlide(this)">
                                                <i class="fas fa-trash me-1"></i>
                                                Remove
                                            </button>
                                        </div>
                                    </div>
                                    <div class="slide-body">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Slide Title</label>
                                                <input type="text" class="form-control"
                                                       name="hero_slides[{{ $index }}][title]"
                                                       value="{{ isset($slide['title']) && !is_array($slide['title']) ? $slide['title'] : '' }}"
                                                       placeholder="Enter compelling headline">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Subtitle</label>
                                                <input type="text" class="form-control"
                                                       name="hero_slides[{{ $index }}][subtitle]"
                                                       value="{{ isset($slide['subtitle']) && !is_array($slide['subtitle']) ? $slide['subtitle'] : '' }}"
                                                       placeholder="Supporting description">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-semibold">Button Text</label>
                                                <input type="text" class="form-control"
                                                       name="hero_slides[{{ $index }}][button_text]"
                                                       value="{{ isset($slide['button_text']) && !is_array($slide['button_text']) ? $slide['button_text'] : '' }}"
                                                       placeholder="e.g., Learn More">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-semibold">Button Link</label>
                                                <input type="text" class="form-control"
                                                       name="hero_slides[{{ $index }}][button_link]"
                                                       value="{{ isset($slide['button_link']) && !is_array($slide['button_link']) ? $slide['button_link'] : '' }}"
                                                       placeholder="/about-us or external URL">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-semibold">Background Image</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control"
                                                           name="hero_slides[{{ $index }}][image]"
                                                           value="{{ isset($slide['image']) && !is_array($slide['image']) ? $slide['image'] : '' }}"
                                                           id="image_{{ $index }}"
                                                           placeholder="Image URL or path">
                                                    <button type="button" class="btn btn-outline-secondary"
                                                            onclick="selectImage('image_{{ $index }}')">
                                                        <i class="fas fa-image"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <button type="button" class="btn btn-outline-primary btn-lg" onclick="addSlide()">
                            <i class="fas fa-plus me-2"></i>
                            Add New Slide
                        </button>
                    </div>
                </div>

                <!-- Mission Section -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-gradient-mission text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="fas fa-bullseye me-2"></i>
                                Mission, Vision & Objectives
                            </h5>
                            <div class="form-check form-switch">
                                <input class="form-check-input section-toggle" type="checkbox" id="mission_enabled" name="mission_enabled"
                                       value="1" {{ old('mission_enabled', (isset($homeSettings['mission']['enabled']) && $homeSettings['mission']['enabled']) ? true : false) ? 'checked' : '' }}>
                                <label class="form-check-label text-white fw-semibold" for="mission_enabled">
                                    Enable Section
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="card-body section-body" id="missionSection">
                        <div class="section-description mb-4">
                            <div class="alert alert-success border-0">
                                <i class="fas fa-lightbulb me-2"></i>
                                <strong>Core Values:</strong> Define your organization's vision, mission, and key objectives to communicate your purpose.
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Section Title</label>
                            <input type="text" class="form-control" name="mission_title"
                                   value="{{ old('mission_title', (isset($homeSettings['mission']['title']) && !is_array($homeSettings['mission']['title'])) ? $homeSettings['mission']['title'] : 'Our Mission, Vision & Objectives') }}"
                                   placeholder="Section heading display name">
                        </div>

                        <div class="row g-4">
                            <div class="col-md-4">
                                <div class="mission-input-card vision-card">
                                    <div class="mission-input-header">
                                        <i class="fas fa-eye me-2"></i>
                                        <h6 class="mb-0">Vision</h6>
                                    </div>
                                    <textarea class="form-control border-0" name="vision_text" rows="5"
                                              placeholder="Your organization's vision for the future...">{{ old('vision_text', (isset($homeSettings['mission']['vision']) && !is_array($homeSettings['mission']['vision'])) ? $homeSettings['mission']['vision'] : '') }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mission-input-card mission-card">
                                    <div class="mission-input-header">
                                        <i class="fas fa-bullseye me-2"></i>
                                        <h6 class="mb-0">Mission</h6>
                                    </div>
                                    <textarea class="form-control border-0" name="mission_text" rows="5"
                                              placeholder="Your organization's core mission statement...">{{ old('mission_text', (isset($homeSettings['mission']['mission']) && !is_array($homeSettings['mission']['mission'])) ? $homeSettings['mission']['mission'] : '') }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mission-input-card objectives-card">
                                    <div class="mission-input-header">
                                        <i class="fas fa-target me-2"></i>
                                        <h6 class="mb-0">Objectives</h6>
                                    </div>
                                    <textarea class="form-control border-0" name="objective_text" rows="5"
                                              placeholder="Key objectives and goals you want to achieve...">{{ old('objective_text', (isset($homeSettings['mission']['objective']) && !is_array($homeSettings['mission']['objective'])) ? $homeSettings['mission']['objective'] : '') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- History Section -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-gradient-history text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="fas fa-history me-2"></i>
                                History Section
                            </h5>
                            <div class="form-check form-switch">
                                <input class="form-check-input section-toggle" type="checkbox" id="history_enabled" name="history_enabled"
                                       value="1" {{ old('history_enabled', (isset($homeSettings['history']['enabled']) && $homeSettings['history']['enabled']) ? true : false) ? 'checked' : '' }}>
                                <label class="form-check-label text-white fw-semibold" for="history_enabled">
                                    Enable Section
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="card-body section-body" id="historySection">
                        <div class="section-description mb-4">
                            <div class="alert alert-info border-0">
                                <i class="fas fa-book-open me-2"></i>
                                <strong>Your Story:</strong> Share your organization's history, achievements, and journey to build trust with visitors.
                            </div>
                        </div>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Section Title</label>
                                    <input type="text" class="form-control" name="history_title"
                                           value="{{ old('history_title', (isset($homeSettings['history']['title']) && !is_array($homeSettings['history']['title'])) ? $homeSettings['history']['title'] : 'Our History') }}"
                                           placeholder="e.g., Our Journey, Our Heritage">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">History Content</label>
                                    <textarea class="form-control" name="history_text" rows="8"
                                              placeholder="Share your organization's story, founding, milestones, and achievements...">{{ old('history_text', (isset($homeSettings['history']['text']) && !is_array($homeSettings['history']['text'])) ? $homeSettings['history']['text'] : '') }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">History Image</label>
                                    <div class="image-input-group">
                                        <input type="text" class="form-control" name="history_image"
                                               value="{{ old('history_image', (isset($homeSettings['history']['image']) && !is_array($homeSettings['history']['image'])) ? $homeSettings['history']['image'] : '') }}"
                                               id="history_image" placeholder="Image URL or upload path">
                                        <button type="button" class="btn btn-outline-primary" onclick="selectImage('history_image')">
                                            <i class="fas fa-image me-1"></i>
                                            Browse
                                        </button>
                                    </div>
                                </div>
                                <div class="history-image-preview">
                                    @if(isset($homeSettings['history']['image']) && !empty($homeSettings['history']['image']) && !is_array($homeSettings['history']['image']))
                                        <img src="{{ $homeSettings['history']['image'] }}" class="img-fluid rounded shadow-sm" alt="History Image">
                                    @else
                                        <div class="image-placeholder">
                                            <i class="fas fa-image fa-3x text-muted"></i>
                                            <p class="text-muted mt-2">Image preview will appear here</p>
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
                <!-- Quick Actions -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-gradient-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-bolt me-2"></i>
                            Quick Actions
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="action-buttons">
                            <button type="submit" class="action-btn primary">
                                <i class="fas fa-save"></i>
                                <span>Save Changes</span>
                            </button>
                            <a href="{{ route('admin.pages.show', $page) }}" class="action-btn info">
                                <i class="fas fa-eye"></i>
                                <span>Preview Page</span>
                            </a>
                            <a href="{{ route('home') }}" class="action-btn success" target="_blank">
                                <i class="fas fa-external-link-alt"></i>
                                <span>View Live</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Other Sections -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-gradient-secondary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-th-large me-2"></i>
                            Additional Sections
                        </h5>
                    </div>
                    <div class="card-body p-3">
                        <!-- Executives Section -->
                        <div class="mini-section-card mb-3">
                            <div class="mini-section-header">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-user-tie text-warning me-2"></i>
                                    <h6 class="mb-0">Executives</h6>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="executives_enabled" name="executives_enabled"
                                           value="1" {{ old('executives_enabled', (isset($homeSettings['executives']['enabled']) && $homeSettings['executives']['enabled']) ? true : false) ? 'checked' : '' }}>
                                </div>
                            </div>
                            <div class="mini-section-body">
                                <input type="text" class="form-control form-control-sm" name="executives_title"
                                       value="{{ old('executives_title', (isset($homeSettings['executives']['title']) && !is_array($homeSettings['executives']['title'])) ? $homeSettings['executives']['title'] : 'Our Executives') }}"
                                       placeholder="Section title">
                            </div>
                        </div>

                        <!-- CTA Section -->
                        <div class="mini-section-card mb-3">
                            <div class="mini-section-header">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-bullhorn text-danger me-2"></i>
                                    <h6 class="mb-0">Call to Action</h6>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="cta_enabled" name="cta_enabled"
                                           value="1" {{ old('cta_enabled', (isset($homeSettings['cta']['enabled']) && $homeSettings['cta']['enabled']) ? true : false) ? 'checked' : '' }}>
                                </div>
                            </div>
                            <div class="mini-section-body">
                                <div class="row g-2">
                                    <div class="col-12">
                                        <input type="text" class="form-control form-control-sm mb-2" name="cta_title"
                                               value="{{ old('cta_title', (isset($homeSettings['cta']['title']) && !is_array($homeSettings['cta']['title'])) ? $homeSettings['cta']['title'] : 'Join Egbe Arobayo Today') }}"
                                               placeholder="CTA Title">
                                    </div>
                                    <div class="col-12">
                                        <textarea class="form-control form-control-sm mb-2" name="cta_text" rows="2"
                                                  placeholder="CTA description">{{ old('cta_text', (isset($homeSettings['cta']['text']) && !is_array($homeSettings['cta']['text'])) ? $homeSettings['cta']['text'] : '') }}</textarea>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control form-control-sm" name="cta_button_text"
                                               value="{{ old('cta_button_text', (isset($homeSettings['cta']['button_text']) && !is_array($homeSettings['cta']['button_text'])) ? $homeSettings['cta']['button_text'] : 'Register Now') }}"
                                               placeholder="Button text">
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control form-control-sm" name="cta_button_link"
                                               value="{{ old('cta_button_link', (isset($homeSettings['cta']['button_link']) && !is_array($homeSettings['cta']['button_link'])) ? $homeSettings['cta']['button_link'] : '/register') }}"
                                               placeholder="Button link">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Events Section -->
                        <div class="mini-section-card">
                            <div class="mini-section-header">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-calendar text-purple me-2"></i>
                                    <h6 class="mb-0">Latest Events</h6>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="events_enabled" name="events_enabled"
                                           value="1" {{ old('events_enabled', (isset($homeSettings['events']['enabled']) && $homeSettings['events']['enabled']) ? true : false) ? 'checked' : '' }}>
                                </div>
                            </div>
                            <div class="mini-section-body">
                                <input type="text" class="form-control form-control-sm" name="events_title"
                                       value="{{ old('events_title', (isset($homeSettings['events']['title']) && !is_array($homeSettings['events']['title'])) ? $homeSettings['events']['title'] : 'Latest Events') }}"
                                       placeholder="Section title">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Page Information -->
                <div class="card shadow-sm border-0">
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
                                    <i class="fas fa-home me-2"></i>
                                    Template
                                </div>
                                <div class="info-value">
                                    <span class="badge bg-warning">Home Page</span>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-link me-2"></i>
                                    URL
                                </div>
                                <div class="info-value">
                                    <code class="url-display">/</code>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-calendar me-2"></i>
                                    Last Modified
                                </div>
                                <div class="info-value">
                                    <small>{{ $page->updated_at->diffForHumans() }}</small>
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

.bg-gradient-hero {
    background: linear-gradient(135deg, #2596be 0%, #4b95c4 100%);
}

.bg-gradient-mission {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
}

.bg-gradient-history {
    background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%);
}

.bg-gradient-secondary {
    background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
}

.bg-gradient-info {
    background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%);
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

/* Section Descriptions */
.section-description .alert {
    background: rgba(37, 150, 190, 0.1);
    border: 1px solid rgba(37, 150, 190, 0.2);
    color: #1e40af;
}

/* Section Toggle */
.section-toggle:checked {
    background-color: #2596be;
    border-color: #2596be;
}

/* Section Body Transitions */
.section-body {
    transition: opacity 0.3s ease;
}

.section-body.disabled {
    opacity: 0.5;
    pointer-events: none;
}

/* Slide Editor Cards */
.slide-editor-card {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    overflow: hidden;
}

.slide-header {
    background: #f8fafc;
    padding: 15px 20px;
    border-bottom: 1px solid #e2e8f0;
}

.slide-body {
    padding: 20px;
}

/* Mission Input Cards */
.mission-input-card {
    background: #fff;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    overflow: hidden;
    height: 100%;
    transition: all 0.3s ease;
}

.mission-input-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.vision-card {
    border-color: #17a2b8;
}

.mission-card {
    border-color: #28a745;
}

.objectives-card {
    border-color: #6f42c1;
}

.mission-input-header {
    background: #f8fafc;
    padding: 12px 16px;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
}

.vision-card .mission-input-header {
    background: linear-gradient(135deg, #17a2b8, #20c997);
    color: white;
}

.mission-card .mission-input-header {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
}

.objectives-card .mission-input-header {
    background: linear-gradient(135deg, #6f42c1, #8b5cf6);
    color: white;
}

.mission-input-card textarea {
    resize: none;
    background: transparent;
}

/* Image Input Group */
.image-input-group {
    display: flex;
    gap: 8px;
}

.image-input-group .form-control {
    flex: 1;
}

/* Image Preview */
.history-image-preview {
    height: 200px;
    border: 2px dashed #e2e8f0;
    border-radius: 8px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}

.history-image-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.image-placeholder {
    text-align: center;
    color: #9ca3af;
}

/* Mini Section Cards */
.mini-section-card {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    overflow: hidden;
}

.mini-section-header {
    padding: 12px 16px;
    background: white;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: between;
}

.mini-section-body {
    padding: 12px 16px;
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

.action-btn.info {
    background: linear-gradient(135deg, #17a2b8, #20c997);
    color: white;
}

.action-btn.success {
    background: linear-gradient(135deg, #28a745, #20c997);
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
    justify-content: between;
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

/* Color Helpers */
.text-purple {
    color: #6f42c1 !important;
}

/* Responsive Design */
@media (max-width: 768px) {
    .admin-page-title {
        font-size: 1.5rem;
    }

    .mission-input-card {
        margin-bottom: 20px;
    }

    .slide-editor-card .slide-body .row > div {
        margin-bottom: 15px;
    }
}

/* Loading States */
.form-control:disabled {
    background-color: #f8f9fa;
    opacity: 0.8;
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

/* Success States */
.alert-success {
    background: linear-gradient(135deg, #d4edda, #c3e6cb);
    border: none;
    color: #155724;
}
</style>
@endsection

@section('scripts')
<script>
let slideCounter = {{ count($slides) }};

// Toggle sections
document.querySelectorAll('[id$="_enabled"]').forEach(checkbox => {
    const sectionId = checkbox.id.replace('_enabled', 'Section');
    const section = document.getElementById(sectionId);

    if (section) {
        toggleSection(section, checkbox.checked);

        checkbox.addEventListener('change', function() {
            toggleSection(section, this.checked);
        });
    }
});

function toggleSection(section, enabled) {
    section.style.opacity = enabled ? '1' : '0.5';
    section.style.pointerEvents = enabled ? 'auto' : 'none';

    const inputs = section.querySelectorAll('input, textarea');
    inputs.forEach(input => {
        input.disabled = !enabled;
    });
}

function addSlide() {
    const slidesContainer = document.getElementById('heroSlides');
    const slideHtml = `
        <div class="slide-item border rounded p-3 mb-3" data-slide="${slideCounter}">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">Slide ${slideCounter + 1}</h6>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeSlide(this)">
                    <i class="fas fa-trash"></i>
                </button>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Slide Title</label>
                        <input type="text" class="form-control" name="hero_slides[\${slideCounter}][title]">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Subtitle</label>
                        <input type="text" class="form-control" name="hero_slides[\${slideCounter}][subtitle]">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Button Text</label>
                        <input type="text" class="form-control" name="hero_slides[\${slideCounter}][button_text]">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Button Link</label>
                        <input type="text" class="form-control" name="hero_slides[\${slideCounter}][button_link]">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Background Image</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="hero_slides[\${slideCounter}][image]" id="image_\${slideCounter}">
                            <button type="button" class="btn btn-outline-secondary" onclick="selectImage('image_\${slideCounter}')">
                                <i class="fas fa-image"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;

    slidesContainer.insertAdjacentHTML('beforeend', slideHtml);
    slideCounter++;
}

function removeSlide(button) {
    const slideItem = button.closest('.slide-item');
    slideItem.remove();

    // Renumber slides
    const slides = document.querySelectorAll('.slide-item');
    slides.forEach((slide, index) => {
        const title = slide.querySelector('h6');
        title.textContent = `Slide ${index + 1}`;
    });
}
</script>
@endsection
