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
    <div>
        <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary me-2">
            <i class="fas fa-arrow-left me-2"></i>
            Back to Pages
        </a>
        <a href="{{ url($page->slug === 'home' ? '/' : '/' . $page->slug) }}"
           class="btn btn-outline-primary" target="_blank">
            <i class="fas fa-external-link-alt me-2"></i>
            Preview
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
                        <label for="title" class="form-label">Page Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                               id="title" name="title" value="{{ old('title', $page->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="slug" class="form-label">Page URL Slug <span class="text-danger">*</span></label>
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
                        <label for="content" class="form-label">Page Content <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('content') is-invalid @enderror"
                                  id="content" name="content" rows="15" required>{{ old('content', $page->content) }}</textarea>
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

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input @error('is_active') is-invalid @enderror"
                                   type="checkbox" id="is_active" name="is_active" value="1"
                                   {{ old('is_active', $page->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Page Active
                            </label>
                            @error('is_active')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-text">Only active pages are visible to visitors.</div>
                    </div>

                    <!-- Page Info -->
                    <div class="border-top pt-3 mt-3">
                        <h6 class="text-muted mb-3">Page Information</h6>
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-2">
                                    <small class="text-muted d-block">Created</small>
                                    <small class="fw-bold">{{ $page->created_at->format('M d, Y') }}</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-2">
                                    <small class="text-muted d-block">Modified</small>
                                    <small class="fw-bold">{{ $page->updated_at->format('M d, Y') }}</small>
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
                        <label for="meta_title" class="form-label">Meta Title</label>
                        <input type="text" class="form-control @error('meta_title') is-invalid @enderror"
                               id="meta_title" name="meta_title" value="{{ old('meta_title', $page->meta_title) }}"
                               maxlength="255">
                        @error('meta_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Leave empty to use the page title.</div>
                    </div>

                    <div class="mb-3">
                        <label for="meta_description" class="form-label">Meta Description</label>
                        <textarea class="form-control @error('meta_description') is-invalid @enderror"
                                  id="meta_description" name="meta_description" rows="3"
                                  maxlength="500">{{ old('meta_description', $page->meta_description) }}</textarea>
                        @error('meta_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Brief description for search engines (max 500 characters).</div>
                    </div>
                </div>
            </div>

            <!-- Update -->
            <div class="admin-card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fas fa-save me-2"></i>
                        Update
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn admin-btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Update Page
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="saveDraft()">
                            <i class="fas fa-save me-2"></i>
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

input[readonly] {
    background-color: #f8f9fa;
    opacity: 0.8;
}

select[disabled] {
    background-color: #f8f9fa;
    opacity: 0.8;
}
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Only enable slug auto-generation for non-home pages
    @if($page->slug !== 'home')
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
    @endif
});

function saveDraft() {
    // Temporarily uncheck active status
    const activeCheckbox = document.getElementById('is_active');
    const wasChecked = activeCheckbox.checked;
    activeCheckbox.checked = false;

    // Submit form
    document.querySelector('form').submit();
}

@if($page->slug !== 'home')
function confirmDelete(pageId, pageTitle) {
    document.getElementById('deleteForm').action = '{{ route("admin.pages.destroy", ":id") }}'.replace(':id', pageId);

    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}
@endif
</script>
@endsection
