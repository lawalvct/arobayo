@extends('layouts.admin')

@section('title', 'Create New Page - Egbe Arobayo')

@section('content')
<div class="page-header mb-4">
    <div class="d-flex justify-content-between align-items-center">
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
            <div class="admin-card mb-4">
                <div class="card-header">
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
                        <div id="editor" style="height: 400px;"></div>
                        <textarea class="form-control @error('content') is-invalid @enderror"
                                  id="content" name="content" style="display:none;" required>{{ old('content') }}</textarea>
                        @error('content')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="admin-card mb-4">
                <div class="card-header">
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

            <div class="admin-card mb-4">
                <div class="card-header">
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

            <div class="admin-card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-rocket me-2"></i>
                        Publish
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-plus me-2"></i>
                            Create Page
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('styles')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
.page-header {
    background: white;
    border-radius: 15px;
    padding: 25px 30px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}

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

.admin-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    overflow: hidden;
    border: none;
}

.admin-card .card-header {
    background: linear-gradient(135deg, #2596be 0%, #4b95c4 100%);
    color: white;
    padding: 18px 25px;
    border: none;
}

.admin-card .card-body {
    padding: 25px;
}

.form-label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 8px;
}

.form-control, .form-select {
    padding: 10px 15px;
    border-radius: 8px;
    border: 1px solid #dee2e6;
}

.form-control:focus, .form-select:focus {
    border-color: #2596be;
    box-shadow: 0 0 0 0.2rem rgba(37, 150, 190, 0.15);
}

.form-text {
    font-size: 0.875rem;
    color: #6c757d;
    margin-top: 6px;
}

.input-group-text {
    background: #f8f9fa;
    border-color: #dee2e6;
    color: #6c757d;
    padding: 10px 15px;
}

#editor {
    background: white;
    border-radius: 8px;
}

.ql-toolbar {
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
    border-color: #dee2e6;
    background: #f8f9fa;
}

.ql-container {
    border-bottom-left-radius: 8px;
    border-bottom-right-radius: 8px;
    font-size: 16px;
    border-color: #dee2e6;
}

.btn-lg {
    padding: 12px 20px;
    font-size: 1.1rem;
    border-radius: 8px;
}

.alert {
    border-radius: 12px;
    padding: 15px 20px;
}

.mb-3 {
    margin-bottom: 1.5rem !important;
}

.mb-4 {
    margin-bottom: 1.75rem !important;
}
</style>
@endsection

@section('scripts')
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
let quill;

document.addEventListener('DOMContentLoaded', function() {
    // Initialize Quill editor
    quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                ['link', 'image'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'align': [] }],
                ['clean']
            ]
        }
    });

    // Set initial content
    const content = document.getElementById('content').value;
    if (content) {
        quill.root.innerHTML = content;
    }

    // Auto-generate slug from title
    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');

    titleInput.addEventListener('input', function() {
        const title = this.value;
        const slug = title.toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim('-');

        if (!slugInput.hasAttribute('data-manual')) {
            slugInput.value = slug;
        }
    });

    slugInput.addEventListener('input', function() {
        this.setAttribute('data-manual', 'true');
    });

    // Sync Quill content to textarea on form submit
    document.querySelector('form').addEventListener('submit', function() {
        document.getElementById('content').value = quill.root.innerHTML;
    });
});
</script>
@endsection
