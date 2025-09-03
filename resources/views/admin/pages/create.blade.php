@extends('layouts.admin')

@section('title', 'Create New Page - Egbe Arobayo')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="admin-page-title">
            <i class="fas fa-plus me-3"></i>
            Create New Page
        </h2>
        <p class="admin-page-subtitle mb-0">
            Create a new page for your website
        </p>
    </div>
    <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>
        Back to Pages
    </a>
</div>

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        Please fix the following errors:
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<form action="{{ route('admin.pages.store') }}" method="POST">
    @csrf

    <div class="row">
        <div class="col-lg-8">
            <!-- Main Content -->
            <div class="admin-card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-edit me-2"></i>
                        Page Content
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Page Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                               id="title" name="title" value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="slug" class="form-label">Page URL Slug <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">{{ url('/') }}/</span>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                   id="slug" name="slug" value="{{ old('slug') }}" required>
                        </div>
                        <div class="form-text">URL-friendly version of the page title. Use lowercase letters, numbers, and hyphens only.</div>
                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Page Content <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('content') is-invalid @enderror"
                                  id="content" name="content" rows="15" required>{{ old('content') }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">You can use HTML tags and basic styling.</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Page Settings -->
            <div class="admin-card mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-cogs me-2"></i>
                        Page Settings
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="template" class="form-label">Template</label>
                        <select class="form-select @error('template') is-invalid @enderror" id="template" name="template">
                            <option value="default" {{ old('template', 'default') == 'default' ? 'selected' : '' }}>Default Page</option>
                            <option value="home" {{ old('template') == 'home' ? 'selected' : '' }}>Home Page</option>
                        </select>
                        @error('template')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Choose the template for this page.</div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input @error('is_active') is-invalid @enderror"
                                   type="checkbox" id="is_active" name="is_active" value="1"
                                   {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Page Active
                            </label>
                            @error('is_active')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-text">Only active pages are visible to visitors.</div>
                    </div>
                </div>
            </div>

            <!-- SEO Settings -->
            <div class="admin-card mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-search me-2"></i>
                        SEO Settings
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="meta_title" class="form-label">Meta Title</label>
                        <input type="text" class="form-control @error('meta_title') is-invalid @enderror"
                               id="meta_title" name="meta_title" value="{{ old('meta_title') }}" maxlength="255">
                        @error('meta_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Leave empty to use the page title.</div>
                    </div>

                    <div class="mb-3">
                        <label for="meta_description" class="form-label">Meta Description</label>
                        <textarea class="form-control @error('meta_description') is-invalid @enderror"
                                  id="meta_description" name="meta_description" rows="3" maxlength="500">{{ old('meta_description') }}</textarea>
                        @error('meta_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Brief description for search engines (max 500 characters).</div>
                    </div>
                </div>
            </div>

            <!-- Publish -->
            <div class="admin-card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fas fa-rocket me-2"></i>
                        Publish
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn admin-btn-primary">
                            <i class="fas fa-plus me-2"></i>
                            Create Page
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="saveDraft()">
                            <i class="fas fa-save me-2"></i>
                            Save Draft
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
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

.form-text {
    font-size: 0.875rem;
    color: #6c757d;
}

#content {
    font-family: 'Courier New', monospace;
    font-size: 0.9rem;
}

.input-group-text {
    background: #f8f9fa;
    border-color: #ced4da;
    color: #6c757d;
}
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-generate slug from title
    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');

    titleInput.addEventListener('input', function() {
        const title = this.value;
        const slug = title.toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '') // Remove special characters
            .replace(/\s+/g, '-') // Replace spaces with hyphens
            .replace(/-+/g, '-') // Replace multiple hyphens with single
            .trim('-'); // Remove leading/trailing hyphens

        if (!slugInput.hasAttribute('data-manual')) {
            slugInput.value = slug;
        }
    });

    // Mark slug as manually edited if user types in it
    slugInput.addEventListener('input', function() {
        this.setAttribute('data-manual', 'true');
    });

    // Template change handler
    const templateSelect = document.getElementById('template');
    const contentTextarea = document.getElementById('content');

    templateSelect.addEventListener('change', function() {
        if (this.value === 'home' && !contentTextarea.value.trim()) {
            contentTextarea.value = getDefaultHomeContent();
        }
    });
});

function getDefaultHomeContent() {
    return `<!-- Home Page Content -->
<div class="home-content">
    <h1>Welcome to Our Website</h1>
    <p>This is the home page content. You can edit this content to match your needs.</p>

    <section class="features">
        <h2>Features</h2>
        <ul>
            <li>Feature 1</li>
            <li>Feature 2</li>
            <li>Feature 3</li>
        </ul>
    </section>
</div>`;
}

function saveDraft() {
    // Temporarily uncheck active status
    const activeCheckbox = document.getElementById('is_active');
    const wasChecked = activeCheckbox.checked;
    activeCheckbox.checked = false;

    // Submit form
    document.querySelector('form').submit();
}
</script>
@endsection
