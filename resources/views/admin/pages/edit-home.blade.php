@extends('layouts.admin')

@section('title', 'Edit Home Page - Egbe Arobayo')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="admin-page-title">
            <i class="fas fa-home me-3"></i>
            Edit Home Page
        </h2>
        <p class="admin-page-subtitle mb-0">
            Manage home page sections, slider, and content
        </p>
    </div>
    <div>
        <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary me-2">
            <i class="fas fa-arrow-left me-2"></i>
            Back to Pages
        </a>
        <a href="{{ route('home') }}" class="btn btn-outline-primary" target="_blank">
            <i class="fas fa-external-link-alt me-2"></i>
            Preview
        </a>
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

    <!-- Basic Settings -->
    <div class="admin-card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="fas fa-cog me-2"></i>
                Basic Settings
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="title" class="form-label">Page Title</label>
                        <input type="text" class="form-control" id="title" name="title"
                               value="{{ old('title', $page->title) }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="meta_title" class="form-label">Meta Title (SEO)</label>
                        <input type="text" class="form-control" id="meta_title" name="meta_title"
                               value="{{ old('meta_title', $page->meta_title) }}">
                    </div>
                </div>
                <div class="col-12">
                    <div class="mb-3">
                        <label for="meta_description" class="form-label">Meta Description (SEO)</label>
                        <textarea class="form-control" id="meta_description" name="meta_description" rows="2">{{ old('meta_description', $page->meta_description) }}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                               value="1" {{ old('is_active', $page->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            Page Active
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hero/Slider Section -->
    <div class="admin-card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center"
             style="background: linear-gradient(135deg, #2596be, #4b95c4); color: white;">
            <h5 class="mb-0">
                <i class="fas fa-images me-2"></i>
                Hero Slider Section
            </h5>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="hero_enabled" name="hero_enabled"
                       value="1" {{ old('hero_enabled', $homeSettings['hero']['enabled'] ?? true) ? 'checked' : '' }}>
                <label class="form-check-label text-white" for="hero_enabled">
                    Enable Section
                </label>
            </div>
        </div>
        <div class="card-body" id="heroSection">
            <div id="heroSlides">
                @php
                    $slides = old('hero_slides', $homeSettings['hero']['slides'] ?? []);
                    if (empty($slides)) {
                        $slides = [['title' => '', 'subtitle' => '', 'button_text' => '', 'button_link' => '', 'image' => '']];
                    }
                @endphp

                @foreach($slides as $index => $slide)
                    <div class="slide-item border rounded p-3 mb-3" data-slide="{{ $index }}">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0">Slide {{ $index + 1 }}</h6>
                            <div>
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeSlide(this)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Slide Title</label>
                                    <input type="text" class="form-control"
                                           name="hero_slides[{{ $index }}][title]"
                                           value="{{ $slide['title'] ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Subtitle</label>
                                    <input type="text" class="form-control"
                                           name="hero_slides[{{ $index }}][subtitle]"
                                           value="{{ $slide['subtitle'] ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Button Text</label>
                                    <input type="text" class="form-control"
                                           name="hero_slides[{{ $index }}][button_text]"
                                           value="{{ $slide['button_text'] ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Button Link</label>
                                    <input type="text" class="form-control"
                                           name="hero_slides[{{ $index }}][button_link]"
                                           value="{{ $slide['button_link'] ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Background Image</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control"
                                               name="hero_slides[{{ $index }}][image]"
                                               value="{{ $slide['image'] ?? '' }}"
                                               id="image_{{ $index }}">
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

            <button type="button" class="btn btn-outline-primary" onclick="addSlide()">
                <i class="fas fa-plus me-2"></i>
                Add Slide
            </button>
        </div>
    </div>

    <!-- Mission Section -->
    <div class="admin-card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center"
             style="background: linear-gradient(135deg, #1cc88a, #17a673); color: white;">
            <h5 class="mb-0">
                <i class="fas fa-bullseye me-2"></i>
                Mission, Vision & Objectives
            </h5>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="mission_enabled" name="mission_enabled"
                       value="1" {{ old('mission_enabled', $homeSettings['mission']['enabled'] ?? true) ? 'checked' : '' }}>
                <label class="form-check-label text-white" for="mission_enabled">
                    Enable Section
                </label>
            </div>
        </div>
        <div class="card-body" id="missionSection">
            <div class="mb-3">
                <label class="form-label">Section Title</label>
                <input type="text" class="form-control" name="mission_title"
                       value="{{ old('mission_title', $homeSettings['mission']['title'] ?? 'Our Mission, Vision & Objectives') }}">
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Vision</label>
                        <textarea class="form-control" name="vision_text" rows="4">{{ old('vision_text', $homeSettings['mission']['vision'] ?? '') }}</textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Mission</label>
                        <textarea class="form-control" name="mission_text" rows="4">{{ old('mission_text', $homeSettings['mission']['mission'] ?? '') }}</textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Objectives</label>
                        <textarea class="form-control" name="objective_text" rows="4">{{ old('objective_text', $homeSettings['mission']['objective'] ?? '') }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- History Section -->
    <div class="admin-card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center"
             style="background: linear-gradient(135deg, #36b9cc, #2c9cb4); color: white;">
            <h5 class="mb-0">
                <i class="fas fa-history me-2"></i>
                History Section
            </h5>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="history_enabled" name="history_enabled"
                       value="1" {{ old('history_enabled', $homeSettings['history']['enabled'] ?? true) ? 'checked' : '' }}>
                <label class="form-check-label text-white" for="history_enabled">
                    Enable Section
                </label>
            </div>
        </div>
        <div class="card-body" id="historySection">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Section Title</label>
                        <input type="text" class="form-control" name="history_title"
                               value="{{ old('history_title', $homeSettings['history']['title'] ?? 'Our History') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">History Text</label>
                        <textarea class="form-control" name="history_text" rows="6">{{ old('history_text', $homeSettings['history']['text'] ?? '') }}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">History Image</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="history_image"
                                   value="{{ old('history_image', $homeSettings['history']['image'] ?? '') }}"
                                   id="history_image">
                            <button type="button" class="btn btn-outline-secondary" onclick="selectImage('history_image')">
                                <i class="fas fa-image"></i>
                            </button>
                        </div>
                    </div>
                    <div class="history-image-preview mt-2" style="max-height: 200px; overflow: hidden;">
                        @if(!empty($homeSettings['history']['image']))
                            <img src="{{ $homeSettings['history']['image'] }}" class="img-fluid rounded" alt="History Image">
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Other sections (Executives, CTA, Events) -->
    <div class="row">
        <!-- Executives Section -->
        <div class="col-md-4">
            <div class="admin-card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center"
                     style="background: linear-gradient(135deg, #f3d40a, #d4af08); color: white;">
                    <h6 class="mb-0">
                        <i class="fas fa-user-tie me-2"></i>
                        Executives
                    </h6>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="executives_enabled" name="executives_enabled"
                               value="1" {{ old('executives_enabled', $homeSettings['executives']['enabled'] ?? true) ? 'checked' : '' }}>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Section Title</label>
                        <input type="text" class="form-control" name="executives_title"
                               value="{{ old('executives_title', $homeSettings['executives']['title'] ?? 'Our Executives') }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="col-md-4">
            <div class="admin-card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center"
                     style="background: linear-gradient(135deg, #af2f2e, #8b2626); color: white;">
                    <h6 class="mb-0">
                        <i class="fas fa-bullhorn me-2"></i>
                        Call to Action
                    </h6>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="cta_enabled" name="cta_enabled"
                               value="1" {{ old('cta_enabled', $homeSettings['cta']['enabled'] ?? true) ? 'checked' : '' }}>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">CTA Title</label>
                        <input type="text" class="form-control" name="cta_title"
                               value="{{ old('cta_title', $homeSettings['cta']['title'] ?? 'Join Egbe Arobayo Today') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">CTA Text</label>
                        <textarea class="form-control" name="cta_text" rows="3">{{ old('cta_text', $homeSettings['cta']['text'] ?? '') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Button Text</label>
                        <input type="text" class="form-control" name="cta_button_text"
                               value="{{ old('cta_button_text', $homeSettings['cta']['button_text'] ?? 'Register Now') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Button Link</label>
                        <input type="text" class="form-control" name="cta_button_link"
                               value="{{ old('cta_button_link', $homeSettings['cta']['button_link'] ?? '/register') }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- Events Section -->
        <div class="col-md-4">
            <div class="admin-card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center"
                     style="background: linear-gradient(135deg, #6f42c1, #5a36b3); color: white;">
                    <h6 class="mb-0">
                        <i class="fas fa-calendar me-2"></i>
                        Latest Events
                    </h6>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="events_enabled" name="events_enabled"
                               value="1" {{ old('events_enabled', $homeSettings['events']['enabled'] ?? true) ? 'checked' : '' }}>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Section Title</label>
                        <input type="text" class="form-control" name="events_title"
                               value="{{ old('events_title', $homeSettings['events']['title'] ?? 'Latest Events') }}">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Save Button -->
    <div class="d-flex justify-content-end gap-3">
        <button type="submit" class="btn admin-btn-primary btn-lg">
            <i class="fas fa-save me-2"></i>
            Update Home Page
        </button>
    </div>
</form>

<!-- Image Selection Modal -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row" id="imageGrid">
                    <!-- Images will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let slideCounter = {{ count($slides) }};
let currentImageInput = null;

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
                        <input type="text" class="form-control" name="hero_slides[${slideCounter}][title]">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Subtitle</label>
                        <input type="text" class="form-control" name="hero_slides[${slideCounter}][subtitle]">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Button Text</label>
                        <input type="text" class="form-control" name="hero_slides[${slideCounter}][button_text]">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Button Link</label>
                        <input type="text" class="form-control" name="hero_slides[${slideCounter}][button_link]">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Background Image</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="hero_slides[${slideCounter}][image]" id="image_${slideCounter}">
                            <button type="button" class="btn btn-outline-secondary" onclick="selectImage('image_${slideCounter}')">
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

function selectImage(inputId) {
    currentImageInput = inputId;
    // In a real implementation, you would load images from the gallery
    // For now, we'll just show some sample paths
    const sampleImages = [
        '/images/slider/slide1.jpg',
        '/images/slider/slide2.jpg',
        '/images/slider/slide3.jpg',
        '/storage/uploads/slides/sample1.jpg',
        '/storage/uploads/slides/sample2.jpg'
    ];

    const imageGrid = document.getElementById('imageGrid');
    imageGrid.innerHTML = '';

    sampleImages.forEach(imagePath => {
        const imageHtml = `
            <div class="col-md-4 mb-3">
                <div class="card" style="cursor: pointer;" onclick="selectImagePath('${imagePath}')">
                    <img src="${imagePath}" class="card-img-top" alt="Image" style="height: 150px; object-fit: cover;" onerror="this.src='/images/placeholder.jpg'">
                    <div class="card-body p-2">
                        <small class="text-muted">${imagePath.split('/').pop()}</small>
                    </div>
                </div>
            </div>
        `;
        imageGrid.insertAdjacentHTML('beforeend', imageHtml);
    });

    const modal = new bootstrap.Modal(document.getElementById('imageModal'));
    modal.show();
}

function selectImagePath(imagePath) {
    if (currentImageInput) {
        document.getElementById(currentImageInput).value = imagePath;
    }

    const modal = bootstrap.Modal.getInstance(document.getElementById('imageModal'));
    modal.hide();
}
</script>
@endsection
