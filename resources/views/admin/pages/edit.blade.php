@extends('layouts.admin')

@section('title', 'Edit Page - Egbe Arobayo')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="admin-page-title">
            <i class="fas fa-edit me-3"></i>
            Edit Page
        </h2>
        <p class="admin-page-subtitle mb-0">
            Edit "{{ $page->title }}"
        </p>
    </div>
    <div class="btn-toolbar gap-2" role="toolbar">
        <div class="btn-group" role="group">
            <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>
                Back to Pages
            </a>
            <a href="{{ url($page->slug === 'home' ? '/' : '/' . $page->slug) }}"
               class="btn btn-outline-primary" target="_blank">
                <i class="fas fa-external-link-alt me-2"></i>
                Preview
            </a>
        </div>
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-info" id="togglePreview">
                <i class="fas fa-eye me-2"></i>
                <span id="previewText">Show Preview</span>
            </button>
            <button type="button" class="btn btn-warning" id="autoSaveStatus" disabled>
                <i class="fas fa-save me-2"></i>
                <span id="saveStatusText">Saved</span>
            </button>
        </div>
    </div>
</div>

<!-- Auto-save Notification -->
<div class="alert alert-info alert-dismissible fade" id="autoSaveAlert" role="alert" style="display: none;">
    <i class="fas fa-info-circle me-2"></i>
    <span id="autoSaveMessage">Draft saved automatically</span>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
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

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<form action="{{ route('admin.pages.update', $page) }}" method="POST">
    @csrf
    @method('PUT')

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
                        <label for="title" class="form-label fw-bold">Page Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg @error('title') is-invalid @enderror"
                               id="title" name="title" value="{{ old('title', $page->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <span id="titleCount">{{ strlen(old('title', $page->title)) }}</span>/255 characters
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="slug" class="form-label fw-bold">Page URL Slug <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">{{ url('/') }}/</span>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                   id="slug" name="slug" value="{{ old('slug', $page->slug) }}" required
                                   {{ $page->slug === 'home' ? 'readonly' : '' }}>
                        </div>
                        @if($page->slug === 'home')
                            <div class="form-text text-warning">
                                <i class="fas fa-lock me-1"></i>
                                The home page slug cannot be changed.
                            </div>
                        @else
                            <div class="form-text">URL-friendly version of the page title. Use lowercase letters, numbers, and hyphens only.</div>
                        @endif
                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label fw-bold">Page Content <span class="text-danger">*</span></label>

                        <!-- Editor Toolbar -->
                        <div class="editor-toolbar mb-2 border rounded p-2 bg-light">
                            <div class="btn-toolbar" role="toolbar">
                                <div class="btn-group btn-group-sm me-2" role="group">
                                    <button type="button" class="btn btn-outline-secondary editor-btn" data-command="bold" title="Bold">
                                        <i class="fas fa-bold"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary editor-btn" data-command="italic" title="Italic">
                                        <i class="fas fa-italic"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary editor-btn" data-command="underline" title="Underline">
                                        <i class="fas fa-underline"></i>
                                    </button>
                                </div>
                                <div class="btn-group btn-group-sm me-2" role="group">
                                    <button type="button" class="btn btn-outline-secondary editor-btn" data-command="justifyLeft" title="Align Left">
                                        <i class="fas fa-align-left"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary editor-btn" data-command="justifyCenter" title="Center">
                                        <i class="fas fa-align-center"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary editor-btn" data-command="justifyRight" title="Align Right">
                                        <i class="fas fa-align-right"></i>
                                    </button>
                                </div>
                                <div class="btn-group btn-group-sm me-2" role="group">
                                    <button type="button" class="btn btn-outline-secondary editor-btn" data-command="insertUnorderedList" title="Bullet List">
                                        <i class="fas fa-list-ul"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary editor-btn" data-command="insertOrderedList" title="Numbered List">
                                        <i class="fas fa-list-ol"></i>
                                    </button>
                                </div>
                                <div class="btn-group btn-group-sm me-2" role="group">
                                    <button type="button" class="btn btn-outline-secondary" id="insertLink" title="Insert Link">
                                        <i class="fas fa-link"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" id="insertImage" title="Insert Image">
                                        <i class="fas fa-image"></i>
                                    </button>
                                </div>
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-outline-secondary" id="htmlMode" title="HTML Mode">
                                        <i class="fas fa-code"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" id="visualMode" title="Visual Mode">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Editor Container -->
                        <div class="editor-container position-relative">
                            <div id="visualEditor" class="form-control" style="min-height: 400px; display: block; padding: 15px;" contenteditable="true">
                                {!! old('content', $page->content) !!}
                            </div>
                            <textarea class="form-control @error('content') is-invalid @enderror"
                                      id="content" name="content" rows="20" required style="display: none; font-family: 'Courier New', monospace;">{{ old('content', $page->content) }}</textarea>
                        </div>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text d-flex justify-content-between">
                            <span>You can use HTML tags and basic styling. Switch to HTML mode for advanced editing.</span>
                            <span id="contentCount">{{ strlen(old('content', $page->content)) }}</span> characters
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Live Preview Panel (Initially Hidden) -->
        <div class="col-lg-4" id="previewColumn" style="display: none;">
            <div class="admin-card position-sticky" style="top: 20px;">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-eye me-2"></i>
                        Live Preview
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div id="previewContent" class="p-3" style="max-height: 600px; overflow-y: auto; background: white;">
                        <!-- Preview content will be inserted here -->
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4" id="settingsColumn">
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
                        <label for="template" class="form-label fw-bold">Template</label>
                        <select class="form-select @error('template') is-invalid @enderror" id="template" name="template"
                                {{ $page->slug === 'home' ? 'disabled' : '' }}>
                            <option value="default" {{ old('template', $page->template) == 'default' ? 'selected' : '' }}>Default Page</option>
                            <option value="home" {{ old('template', $page->template) == 'home' ? 'selected' : '' }}>Home Page</option>
                        </select>
                        @if($page->slug === 'home')
                            <input type="hidden" name="template" value="{{ $page->template }}">
                            <div class="form-text text-warning">
                                <i class="fas fa-lock me-1"></i>
                                The home page template cannot be changed.
                            </div>
                        @endif
                        @error('template')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Page Statistics -->
                    <div class="border-top pt-3 mt-3">
                        <h6 class="text-muted mb-3">
                            <i class="fas fa-chart-bar me-1"></i>
                            Page Information
                        </h6>
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-2">
                                    <small class="text-muted d-block">Created</small>
                                    <small class="fw-bold">{{ $page->created_at->format('M d, Y') }}</small>
                                </div>
                                <div class="mb-2">
                                    <small class="text-muted d-block">Status</small>
                                    <span class="badge {{ $page->is_active ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $page->is_active ? 'Published' : 'Draft' }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-2">
                                    <small class="text-muted d-block">Modified</small>
                                    <small class="fw-bold">{{ $page->updated_at->format('M d, Y') }}</small>
                                </div>
                                <div class="mb-2">
                                    <small class="text-muted d-block">Template</small>
                                    <small class="fw-bold text-capitalize">{{ $page->template }}</small>
                                </div>
                            </div>
                        </div>
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
                        <label for="meta_title" class="form-label fw-bold">Meta Title</label>
                        <input type="text" class="form-control @error('meta_title') is-invalid @enderror"
                               id="meta_title" name="meta_title" value="{{ old('meta_title', $page->meta_title) }}"
                               maxlength="60">
                        @error('meta_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text d-flex justify-content-between">
                            <span>Leave empty to use the page title.</span>
                            <span id="metaTitleCount">{{ strlen(old('meta_title', $page->meta_title)) }}</span>/60 characters
                        </div>
                        <div class="progress mt-1" style="height: 4px;">
                            <div class="progress-bar" id="metaTitleProgress" role="progressbar" style="width: 0%"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="meta_description" class="form-label fw-bold">Meta Description</label>
                        <textarea class="form-control @error('meta_description') is-invalid @enderror"
                                  id="meta_description" name="meta_description" rows="3"
                                  maxlength="160">{{ old('meta_description', $page->meta_description) }}</textarea>
                        @error('meta_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text d-flex justify-content-between">
                            <span>Brief description for search engines.</span>
                            <span id="metaDescCount">{{ strlen(old('meta_description', $page->meta_description)) }}</span>/160 characters
                        </div>
                        <div class="progress mt-1" style="height: 4px;">
                            <div class="progress-bar" id="metaDescProgress" role="progressbar" style="width: 0%"></div>
                        </div>
                    </div>

                    <!-- SEO Preview -->
                    <div class="alert alert-light border">
                        <h6 class="fw-bold mb-2">Search Engine Preview:</h6>
                        <div class="seo-preview">
                            <div class="text-primary fw-bold" id="seoTitle">{{ $page->meta_title ?: $page->title }}</div>
                            <div class="text-success small" id="seoUrl">{{ url($page->slug === 'home' ? '/' : '/' . $page->slug) }}</div>
                            <div class="text-muted small" id="seoDescription">{{ $page->meta_description ?: 'No meta description set.' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Update -->
            <div class="admin-card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fas fa-save me-2"></i>
                        Publish & Save
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input @error('is_active') is-invalid @enderror"
                                   type="checkbox" id="is_active" name="is_active" value="1"
                                   {{ old('is_active', $page->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="is_active">
                                Publish Page
                            </label>
                            @error('is_active')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-text">Only published pages are visible to visitors.</div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn admin-btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i>
                            Update Page
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="saveDraft()">
                            <i class="fas fa-file-alt me-2"></i>
                            Save as Draft
                        </button>
                        @if($page->slug !== 'home')
                            <hr>
                            <button type="button" class="btn btn-outline-danger"
                                    onclick="confirmDelete('{{ $page->id }}', '{{ $page->title }}')">
                                <i class="fas fa-trash me-2"></i>
                                Delete Page
                            </button>
                        @endif
                    </div>

                    <!-- Auto-save Settings -->
                    <div class="border-top pt-3 mt-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="autoSaveEnabled" checked>
                            <label class="form-check-label small" for="autoSaveEnabled">
                                Auto-save drafts
                            </label>
                        </div>
                        <small class="text-muted d-block mt-1">
                            Last saved: <span id="lastSaved">Never</span>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

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

<!-- Insert Link Modal -->
<div class="modal fade" id="insertLinkModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-link me-2"></i>
                    Insert Link
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="linkText" class="form-label">Link Text</label>
                    <input type="text" class="form-control" id="linkText" placeholder="Enter link text">
                </div>
                <div class="mb-3">
                    <label for="linkUrl" class="form-label">URL</label>
                    <input type="url" class="form-control" id="linkUrl" placeholder="https://example.com">
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="linkNewTab">
                    <label class="form-check-label" for="linkNewTab">
                        Open in new tab
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="insertLinkBtn">Insert Link</button>
            </div>
        </div>
    </div>
</div>

<!-- Insert Image Modal -->
<div class="modal fade" id="insertImageModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-image me-2"></i>
                    Insert Image
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs mb-3" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="upload-tab" data-bs-toggle="tab" data-bs-target="#upload" type="button" role="tab">
                            <i class="fas fa-upload me-1"></i>
                            Upload Image
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="url-tab" data-bs-toggle="tab" data-bs-target="#url" type="button" role="tab">
                            <i class="fas fa-link me-1"></i>
                            Image URL
                        </button>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="upload" role="tabpanel">
                        <div class="mb-3">
                            <input type="file" class="form-control" id="imageUpload" accept="image/*">
                            <div class="form-text">Supported formats: JPG, PNG, GIF, WebP (Max 2MB)</div>
                        </div>
                        <div id="imagePreview" class="text-center" style="display: none;">
                            <img id="previewImg" src="" alt="Preview" class="img-thumbnail" style="max-height: 200px;">
                        </div>
                    </div>
                    <div class="tab-pane fade" id="url" role="tabpanel">
                        <div class="mb-3">
                            <label for="imageUrl" class="form-label">Image URL</label>
                            <input type="url" class="form-control" id="imageUrl" placeholder="https://example.com/image.jpg">
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="imageAlt" class="form-label">Alt Text</label>
                    <input type="text" class="form-control" id="imageAlt" placeholder="Describe the image for accessibility">
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="imageWidth" class="form-label">Width</label>
                        <input type="number" class="form-control" id="imageWidth" placeholder="Auto">
                    </div>
                    <div class="col-md-6">
                        <label for="imageHeight" class="form-label">Height</label>
                        <input type="number" class="form-control" id="imageHeight" placeholder="Auto">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="insertImageBtn">Insert Image</button>
            </div>
        </div>
    </div>
</div>
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

.form-control-lg {
    font-weight: 600;
}

.fw-bold {
    font-weight: 600 !important;
}

/* Editor Styles */
.editor-toolbar {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
}

.editor-toolbar .btn {
    border: none;
    margin: 0 1px;
}

.editor-toolbar .btn:hover {
    background: #e9ecef;
}

.editor-toolbar .btn.active {
    background: #0d6efd;
    color: white;
}

#visualEditor {
    border: 1px solid #ced4da;
    border-radius: 0.375rem;
    padding: 15px;
    min-height: 400px;
    overflow-y: auto;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    line-height: 1.6;
}

#visualEditor:focus {
    outline: none;
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

#visualEditor p {
    margin-bottom: 1rem;
}

#visualEditor h1, #visualEditor h2, #visualEditor h3 {
    margin-top: 1.5rem;
    margin-bottom: 1rem;
    font-weight: 600;
}

#visualEditor ul, #visualEditor ol {
    margin-bottom: 1rem;
    padding-left: 2rem;
}

#visualEditor blockquote {
    margin: 1rem 0;
    padding-left: 1rem;
    border-left: 4px solid #dee2e6;
    color: #6c757d;
    font-style: italic;
}

#content {
    font-family: 'Courier New', monospace;
    font-size: 0.9rem;
}

/* SEO Preview Styles */
.seo-preview {
    font-family: Arial, sans-serif;
    font-size: 14px;
    line-height: 1.4;
}

.seo-preview div:first-child {
    color: #1a0dab;
    font-size: 18px;
    line-height: 1.2;
    margin-bottom: 2px;
}

.seo-preview div:nth-child(2) {
    color: #006621;
    font-size: 14px;
    margin-bottom: 2px;
}

.seo-preview div:last-child {
    color: #545454;
    font-size: 13px;
    line-height: 1.4;
}

/* Progress Bars */
.progress {
    height: 4px;
    background-color: #e9ecef;
}

/* Live Preview */
#previewContent {
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    line-height: 1.6;
    color: #333;
}

#previewContent h1 {
    color: #2596be;
    border-bottom: 2px solid #dee2e6;
    padding-bottom: 0.5rem;
}

#previewContent .content {
    margin-top: 1rem;
}

#previewContent .content p {
    margin-bottom: 1rem;
}

#previewContent .content img {
    max-width: 100%;
    height: auto;
    border-radius: 0.25rem;
    margin: 1rem 0;
}

/* Auto-save Alert */
#autoSaveAlert {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 1050;
    max-width: 300px;
}

/* Button Toolbar */
.btn-toolbar .btn-group {
    margin-right: 0.5rem;
}

/* Input Group Styles */
.input-group-text {
    background: #f8f9fa;
    border-color: #ced4da;
    color: #6c757d;
    font-weight: 500;
}

input[readonly] {
    background-color: #f8f9fa;
    opacity: 0.8;
}

select[disabled] {
    background-color: #f8f9fa;
    opacity: 0.8;
}

/* Character Counter Colors */
.text-warning {
    color: #fd7e14 !important;
}

.text-danger {
    color: #dc3545 !important;
}

/* Modal Enhancements */
.modal-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-bottom: none;
}

.modal-header .btn-close {
    filter: invert(1);
}

/* Tab Styles */
.nav-tabs .nav-link {
    color: #6c757d;
    border: 1px solid transparent;
}

.nav-tabs .nav-link.active {
    color: #0d6efd;
    border-color: #dee2e6 #dee2e6 #fff;
}

/* Badge Styles */
.badge {
    font-size: 0.75em;
    padding: 0.35em 0.65em;
}

/* Responsive Design */
@media (max-width: 768px) {
    .admin-page-title {
        font-size: 1.5rem;
    }

    .btn-toolbar {
        flex-direction: column;
        gap: 0.5rem;
    }

    .btn-group {
        width: 100%;
    }

    #previewColumn {
        order: -1;
        margin-bottom: 1rem;
    }

    .editor-toolbar .btn-toolbar {
        flex-wrap: wrap;
    }

    .editor-toolbar .btn-group {
        margin-bottom: 0.25rem;
    }
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    #visualEditor {
        background-color: #1a1a1a;
        color: #e9ecef;
        border-color: #495057;
    }

    .editor-toolbar {
        background-color: #343a40;
        border-color: #495057;
    }

    .seo-preview {
        background-color: #2d3748;
        color: #e2e8f0;
    }
}
</style>
@endsection

@section('scripts')
<script>
let autoSaveInterval;
let isHtmlMode = false;

document.addEventListener('DOMContentLoaded', function() {
    initializeEditor();
    initializeSEOTools();
    initializeAutoSave();
    initializePreview();

    // Only enable slug auto-generation for non-home pages
    @if($page->slug !== 'home')
    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');

    titleInput.addEventListener('input', function() {
        updateCharacterCount('title', 'titleCount', 255);
        const title = this.value;
        const slug = title.toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '') // Remove special characters
            .replace(/\s+/g, '-') // Replace spaces with hyphens
            .replace(/-+/g, '-') // Replace multiple hyphens with single
            .trim('-'); // Remove leading/trailing hyphens

        if (!slugInput.hasAttribute('data-manual')) {
            slugInput.value = slug;
        }
        updateSEOPreview();
    });

    // Mark slug as manually edited if user types in it
    slugInput.addEventListener('input', function() {
        this.setAttribute('data-manual', 'true');
        updateSEOPreview();
    });
    @endif
});

function initializeEditor() {
    const visualEditor = document.getElementById('visualEditor');
    const textarea = document.getElementById('content');
    const editorBtns = document.querySelectorAll('.editor-btn');

    // Editor toolbar functionality
    editorBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const command = this.dataset.command;
            document.execCommand(command, false, null);
            visualEditor.focus();
        });
    });

    // Mode switching
    document.getElementById('htmlMode').addEventListener('click', function() {
        if (!isHtmlMode) {
            textarea.value = visualEditor.innerHTML;
            visualEditor.style.display = 'none';
            textarea.style.display = 'block';
            isHtmlMode = true;
            this.classList.add('btn-primary');
            this.classList.remove('btn-outline-secondary');
        }
    });

    document.getElementById('visualMode').addEventListener('click', function() {
        if (isHtmlMode) {
            visualEditor.innerHTML = textarea.value;
            textarea.style.display = 'none';
            visualEditor.style.display = 'block';
            isHtmlMode = false;
            document.getElementById('htmlMode').classList.remove('btn-primary');
            document.getElementById('htmlMode').classList.add('btn-outline-secondary');
        }
    });

    // Sync content between editors
    visualEditor.addEventListener('input', function() {
        if (!isHtmlMode) {
            textarea.value = this.innerHTML;
            updateCharacterCount('content', 'contentCount');
            updatePreview();
        }
    });

    textarea.addEventListener('input', function() {
        if (isHtmlMode) {
            updateCharacterCount('content', 'contentCount');
            updatePreview();
        }
    });

    // Insert Link functionality
    document.getElementById('insertLink').addEventListener('click', function() {
        const selection = window.getSelection();
        if (selection.rangeCount > 0) {
            const selectedText = selection.toString();
            document.getElementById('linkText').value = selectedText;
        }
        new bootstrap.Modal(document.getElementById('insertLinkModal')).show();
    });

    document.getElementById('insertLinkBtn').addEventListener('click', function() {
        const text = document.getElementById('linkText').value;
        const url = document.getElementById('linkUrl').value;
        const newTab = document.getElementById('linkNewTab').checked;

        if (text && url) {
            const target = newTab ? ' target="_blank"' : '';
            const linkHtml = `<a href="${url}"${target}>${text}</a>`;

            if (isHtmlMode) {
                const textarea = document.getElementById('content');
                const start = textarea.selectionStart;
                const end = textarea.selectionEnd;
                textarea.value = textarea.value.substring(0, start) + linkHtml + textarea.value.substring(end);
            } else {
                document.execCommand('insertHTML', false, linkHtml);
            }

            bootstrap.Modal.getInstance(document.getElementById('insertLinkModal')).hide();
        }
    });

    // Insert Image functionality
    document.getElementById('insertImage').addEventListener('click', function() {
        new bootstrap.Modal(document.getElementById('insertImageModal')).show();
    });

    document.getElementById('imageUpload').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById('previewImg');
                img.src = e.target.result;
                document.getElementById('imagePreview').style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });

    document.getElementById('insertImageBtn').addEventListener('click', function() {
        const alt = document.getElementById('imageAlt').value;
        const width = document.getElementById('imageWidth').value;
        const height = document.getElementById('imageHeight').value;

        const uploadedFile = document.getElementById('imageUpload').files[0];
        const imageUrl = document.getElementById('imageUrl').value;

        if (uploadedFile) {
            // Upload the file first
            const formData = new FormData();
            formData.append('image', uploadedFile);
            formData.append('type', 'content');
            formData.append('_token', document.querySelector('input[name="_token"]').value);

            // Show uploading state
            this.disabled = true;
            this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Uploading...';

            fetch('/admin/pages/upload-image', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    insertImageToEditor(data.url, alt, width, height);
                    bootstrap.Modal.getInstance(document.getElementById('insertImageModal')).hide();
                } else {
                    alert('Upload failed. Please try again.');
                }
            })
            .catch(error => {
                console.error('Upload error:', error);
                alert('Upload failed. Please try again.');
            })
            .finally(() => {
                this.disabled = false;
                this.innerHTML = 'Insert Image';
            });
        } else if (imageUrl) {
            insertImageToEditor(imageUrl, alt, width, height);
            bootstrap.Modal.getInstance(document.getElementById('insertImageModal')).hide();
        } else {
            alert('Please select an image or enter an image URL.');
        }
    });

    function insertImageToEditor(src, alt, width, height) {
        let imgHtml = `<img src="${src}" alt="${alt}"`;
        if (width) imgHtml += ` width="${width}"`;
        if (height) imgHtml += ` height="${height}"`;
        imgHtml += ' class="img-fluid">';

        if (isHtmlMode) {
            const textarea = document.getElementById('content');
            const start = textarea.selectionStart;
            const end = textarea.selectionEnd;
            textarea.value = textarea.value.substring(0, start) + imgHtml + textarea.value.substring(end);
        } else {
            document.execCommand('insertHTML', false, imgHtml);
        }

        // Clear the form
        document.getElementById('imageUpload').value = '';
        document.getElementById('imageUrl').value = '';
        document.getElementById('imageAlt').value = '';
        document.getElementById('imageWidth').value = '';
        document.getElementById('imageHeight').value = '';
        document.getElementById('imagePreview').style.display = 'none';
    }
}

function initializeSEOTools() {
    const metaTitle = document.getElementById('meta_title');
    const metaDesc = document.getElementById('meta_description');

    metaTitle.addEventListener('input', function() {
        updateCharacterCount('meta_title', 'metaTitleCount', 60);
        updateProgressBar('metaTitleProgress', this.value.length, 60);
        updateSEOPreview();
    });

    metaDesc.addEventListener('input', function() {
        updateCharacterCount('meta_description', 'metaDescCount', 160);
        updateProgressBar('metaDescProgress', this.value.length, 160);
        updateSEOPreview();
    });

    // Initialize progress bars
    updateProgressBar('metaTitleProgress', metaTitle.value.length, 60);
    updateProgressBar('metaDescProgress', metaDesc.value.length, 160);
    updateSEOPreview();
}

function initializeAutoSave() {
    const autoSaveEnabled = document.getElementById('autoSaveEnabled');

    if (autoSaveEnabled.checked) {
        startAutoSave();
    }

    autoSaveEnabled.addEventListener('change', function() {
        if (this.checked) {
            startAutoSave();
        } else {
            stopAutoSave();
        }
    });
}

function initializePreview() {
    const toggleBtn = document.getElementById('togglePreview');
    const previewColumn = document.getElementById('previewColumn');
    const editorColumn = document.getElementById('editorColumn');
    const settingsColumn = document.getElementById('settingsColumn');

    toggleBtn.addEventListener('click', function() {
        if (previewColumn.style.display === 'none') {
            previewColumn.style.display = 'block';
            editorColumn.classList.remove('col-lg-8');
            editorColumn.classList.add('col-lg-4');
            settingsColumn.classList.remove('col-lg-4');
            settingsColumn.classList.add('col-lg-4');
            document.getElementById('previewText').textContent = 'Hide Preview';
            updatePreview();
        } else {
            previewColumn.style.display = 'none';
            editorColumn.classList.remove('col-lg-4');
            editorColumn.classList.add('col-lg-8');
            settingsColumn.classList.remove('col-lg-4');
            settingsColumn.classList.add('col-lg-4');
            document.getElementById('previewText').textContent = 'Show Preview';
        }
    });
}

function updateCharacterCount(fieldId, counterId, maxLength = null) {
    const field = document.getElementById(fieldId);
    const counter = document.getElementById(counterId);
    const length = field.value.length;

    if (maxLength) {
        counter.textContent = `${length}/${maxLength}`;
        if (length > maxLength * 0.9) {
            counter.className = 'text-warning';
        } else if (length > maxLength) {
            counter.className = 'text-danger';
        } else {
            counter.className = '';
        }
    } else {
        counter.textContent = length;
    }
}

function updateProgressBar(progressId, current, max) {
    const progress = document.getElementById(progressId);
    const percentage = (current / max) * 100;
    progress.style.width = `${Math.min(percentage, 100)}%`;

    if (percentage < 50) {
        progress.className = 'progress-bar bg-success';
    } else if (percentage < 90) {
        progress.className = 'progress-bar bg-warning';
    } else {
        progress.className = 'progress-bar bg-danger';
    }
}

function updateSEOPreview() {
    const title = document.getElementById('meta_title').value || document.getElementById('title').value;
    const description = document.getElementById('meta_description').value || 'No meta description set.';
    const slug = document.getElementById('slug').value;

    document.getElementById('seoTitle').textContent = title;
    document.getElementById('seoDescription').textContent = description;

    const url = slug === 'home' ? '{{ url("/") }}' : `{{ url("/") }}/${slug}`;
    document.getElementById('seoUrl').textContent = url;
}

function updatePreview() {
    const previewContent = document.getElementById('previewContent');
    if (previewContent && previewContent.parentElement.style.display !== 'none') {
        const title = document.getElementById('title').value;
        const content = isHtmlMode ?
            document.getElementById('content').value :
            document.getElementById('visualEditor').innerHTML;

        previewContent.innerHTML = `
            <h1 class="mb-4">${title}</h1>
            <div class="content">${content}</div>
        `;
    }
}

function startAutoSave() {
    autoSaveInterval = setInterval(function() {
        if (hasUnsavedChanges()) {
            saveDraft(true); // Auto-save
        }
    }, 30000); // Every 30 seconds
}

function stopAutoSave() {
    if (autoSaveInterval) {
        clearInterval(autoSaveInterval);
    }
}

function hasUnsavedChanges() {
    // Simple check - could be more sophisticated
    return true;
}

function saveDraft(isAutoSave = false) {
    const statusBtn = document.getElementById('autoSaveStatus');
    const statusText = document.getElementById('saveStatusText');
    const alertDiv = document.getElementById('autoSaveAlert');
    const alertMsg = document.getElementById('autoSaveMessage');

    if (isAutoSave) {
        // Update UI to show saving
        statusBtn.disabled = false;
        statusBtn.className = 'btn btn-warning';
        statusText.textContent = 'Saving...';

        // Collect form data
        const formData = new FormData();
        formData.append('title', document.getElementById('title').value);
        formData.append('content', isHtmlMode ?
            document.getElementById('content').value :
            document.getElementById('visualEditor').innerHTML);
        formData.append('slug', document.getElementById('slug').value);
        formData.append('meta_title', document.getElementById('meta_title').value);
        formData.append('meta_description', document.getElementById('meta_description').value);
        formData.append('_token', document.querySelector('input[name="_token"]').value);

        // AJAX save as draft
        fetch(`/admin/pages/{{ $page->id }}/save-draft`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                statusBtn.className = 'btn btn-success';
                statusText.textContent = 'Draft Saved';
                document.getElementById('lastSaved').textContent = data.last_saved;

                alertMsg.textContent = 'Draft saved automatically';
                alertDiv.style.display = 'block';
                alertDiv.classList.add('show');

                setTimeout(() => {
                    alertDiv.classList.remove('show');
                    setTimeout(() => alertDiv.style.display = 'none', 150);
                }, 3000);

                // Reset status after 3 seconds
                setTimeout(() => {
                    statusBtn.className = 'btn btn-warning';
                    statusBtn.disabled = true;
                    statusText.textContent = 'Saved';
                }, 3000);
            }
        })
        .catch(error => {
            console.error('Auto-save failed:', error);
            statusBtn.className = 'btn btn-danger';
            statusText.textContent = 'Save Failed';

            setTimeout(() => {
                statusBtn.className = 'btn btn-warning';
                statusBtn.disabled = true;
                statusText.textContent = 'Saved';
            }, 5000);
        });
    } else {
        // Manual save as draft - temporarily uncheck active and submit form
        const activeCheckbox = document.getElementById('is_active');
        const wasChecked = activeCheckbox.checked;
        activeCheckbox.checked = false;
        document.querySelector('form').submit();
    }
}

@if($page->slug !== 'home')
function confirmDelete(pageId, pageTitle) {
    document.getElementById('deleteForm').action = `/admin/pages/${pageId}`;

    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}
@endif
</script>
@endsection
