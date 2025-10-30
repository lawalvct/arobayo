@extends('layouts.admin')

@section('title', 'Edit Navigation Item - Egbe Arobayo')

@section('content')
@php
    // Handle case where $navigation might be a collection instead of a model
    if (is_object($navigation) && $navigation instanceof \Illuminate\Database\Eloquent\Collection) {
        $navigation = $navigation->first();
    }

    // If still not a valid navigation model, redirect back
    if (!is_object($navigation) || !method_exists($navigation, 'getAttribute')) {
        abort(404, 'Navigation item not found');
    }
@endphp

<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="admin-page-title">
                <i class="fas fa-edit me-3"></i>
                Edit Navigation Item
            </h2>
            <p class="admin-page-subtitle mb-0">
                Edit "{{ $navigation->label ?? 'Navigation Item' }}"
            </p>
        </div>
        <div class="btn-toolbar gap-2" role="toolbar">
            <div class="btn-group" role="group">
                <a href="{{ route('admin.navigations.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>
                    Back to Navigation
                </a>
            </div>
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

    <form action="{{ route('admin.navigations.update', $navigation->id ?? '') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-4">
            <div class="col-lg-8">
                <!-- Basic Information -->
                <div class="admin-card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            Basic Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="label" class="form-label fw-bold">Menu Label <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg @error('label') is-invalid @enderror"
                                   id="label" name="label" value="{{ old('label', $navigation->label ?? '') }}" required
                                   placeholder="Enter menu label (e.g., About Us, Contact)">
                            @error('label')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">This is the text that will appear in the navigation menu.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Link Type</label>
                            <div class="btn-group d-flex" role="group">
                                <input type="radio" class="btn-check" name="link_type" id="link_type_page" value="page"
                                       {{ old('link_type', ($navigation->page_id ?? null) ? 'page' : 'url') === 'page' ? 'checked' : '' }}>
                                <label class="btn btn-outline-primary" for="link_type_page">
                                    <i class="fas fa-file-alt me-2"></i>Link to Page
                                </label>
                                <input type="radio" class="btn-check" name="link_type" id="link_type_url" value="url"
                                       {{ old('link_type', ($navigation->page_id ?? null) ? 'page' : 'url') === 'url' ? 'checked' : '' }}>
                                <label class="btn btn-outline-primary" for="link_type_url">
                                    <i class="fas fa-link me-2"></i>Custom URL
                                </label>
                            </div>
                        </div>

                        <div class="mb-3" id="page-selection"
                             style="{{ old('link_type', ($navigation->page_id ?? null) ? 'page' : 'url') === 'page' ? 'display: block;' : 'display: none;' }}">
                            <label for="page_id" class="form-label fw-bold">Select Page</label>
                            <select class="form-select @error('page_id') is-invalid @enderror" id="page_id" name="page_id">
                                <option value="">Choose a page...</option>
                                @foreach($pages as $page)
                                    <option value="{{ $page->id }}"
                                            {{ old('page_id', $navigation->page_id ?? '') == $page->id ? 'selected' : '' }}>
                                        {{ $page->title }} ({{ $page->slug === 'home' ? '/' : '/'.$page->slug }})
                                    </option>
                                @endforeach
                            </select>
                            @error('page_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Select an existing page to link to.</div>
                        </div>

                        <div class="mb-3" id="url-input"
                             style="{{ old('link_type', ($navigation->page_id ?? null) ? 'page' : 'url') === 'url' ? 'display: block;' : 'display: none;' }}">
                            <label for="url" class="form-label fw-bold">URL <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('url') is-invalid @enderror"
                                   id="url" name="url" value="{{ old('url', $navigation->url ?? '') }}"
                                   placeholder="Enter URL (e.g., /about, https://example.com, #section)">
                            @error('url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <strong>Examples:</strong><br>
                                • <code>/about</code> - Internal page<br>
                                • <code>https://example.com</code> - External link<br>
                                • <code>#section</code> - Page anchor<br>
                                • <code>{{ route('events.index') }}</code> - Route URL
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="icon" class="form-label fw-bold">Icon (Optional)</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i id="icon-preview" class="{{ old('icon', $navigation->icon ?? 'fas fa-link') }}"></i>
                                </span>
                                <input type="text" class="form-control @error('icon') is-invalid @enderror"
                                       id="icon" name="icon" value="{{ old('icon', $navigation->icon ?? '') }}"
                                       placeholder="fas fa-home, fas fa-users, etc.">
                            </div>
                            @error('icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Font Awesome class (e.g., <code>fas fa-home</code>).
                                <a href="https://fontawesome.com/icons" target="_blank">Browse icons</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Settings -->
                <div class="admin-card mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-cogs me-2"></i>
                            Settings
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="parent_id" class="form-label fw-bold">Parent Menu</label>
                            <select class="form-select @error('parent_id') is-invalid @enderror"
                                    id="parent_id" name="parent_id">
                                <option value="">None (Main Menu Item)</option>
                                @foreach($parentNavigations as $parent)
                                    <option value="{{ $parent->id }}"
                                            {{ old('parent_id', $navigation->parent_id ?? '') == $parent->id ? 'selected' : '' }}>
                                        {{ $parent->label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('parent_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Select a parent to create a sub-menu item.</div>
                        </div>

                        <div class="mb-3">
                            <label for="target" class="form-label fw-bold">Link Target</label>
                            <select class="form-select @error('target') is-invalid @enderror"
                                    id="target" name="target" required>
                                <option value="_self" {{ old('target', $navigation->target ?? '_self') == '_self' ? 'selected' : '' }}>
                                    Same Window
                                </option>
                                <option value="_blank" {{ old('target', $navigation->target ?? '_self') == '_blank' ? 'selected' : '' }}>
                                    New Window/Tab
                                </option>
                            </select>
                            @error('target')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Choose how the link should open.</div>
                        </div>

                        <div class="mb-3">
                            <label for="sort_order" class="form-label fw-bold">Sort Order</label>
                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror"
                                   id="sort_order" name="sort_order" value="{{ old('sort_order', $navigation->sort_order ?? '') }}"
                                   min="0" placeholder="0">
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Lower numbers appear first.</div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input @error('is_active') is-invalid @enderror"
                                       type="checkbox" id="is_active" name="is_active" value="1"
                                       {{ old('is_active', $navigation->is_active ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="is_active">
                                    Active
                                </label>
                                @error('is_active')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-text">Only active items appear in the navigation menu.</div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Info -->
                <div class="admin-card mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-info me-2"></i>
                            Navigation Info
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-2">
                                    <small class="text-muted d-block">Created</small>
                                    <small class="fw-bold">{{ $navigation->created_at ? $navigation->created_at->format('M d, Y') : 'Unknown' }}</small>
                                </div>
                                <div class="mb-2">
                                    <small class="text-muted d-block">Status</small>
                                    <span class="badge {{ $navigation->is_active ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $navigation->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-2">
                                    <small class="text-muted d-block">Modified</small>
                                    <small class="fw-bold">{{ $navigation->updated_at ? $navigation->updated_at->format('M d, Y') : 'Unknown' }}</small>
                                </div>
                                <div class="mb-2">
                                    <small class="text-muted d-block">Sub-items</small>
                                    <small class="fw-bold">{{ $navigation->children ? $navigation->children->count() : 0 }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="admin-card">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">
                            <i class="fas fa-save me-2"></i>
                            Actions
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn admin-btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>
                                Update Navigation Item
                            </button>
                            <a href="{{ route('admin.navigations.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>
                                Cancel
                            </a>
                            @if($navigation->children->count() == 0)
                                <hr>
                                <button type="button" class="btn btn-outline-danger"
                                        onclick="confirmDelete('{{ $navigation->id }}', '{{ $navigation->label }}')">
                                    <i class="fas fa-trash me-2"></i>
                                    Delete Navigation Item
                                </button>
                            @else
                                <hr>
                                <div class="alert alert-warning mb-0">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <small>Cannot delete this item because it has {{ $navigation->children->count() }} sub-item(s).</small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@if($navigation->children->count() == 0)
<!-- Delete Confirmation -->
<form id="deleteForm" action="{{ route('admin.navigations.destroy', $navigation->id ?? '') }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
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

.form-control-lg {
    font-weight: 600;
}

.fw-bold {
    font-weight: 600 !important;
}

#icon-preview {
    color: #6c757d;
    transition: all 0.3s ease;
}

.input-group-text {
    background: #f8f9fa;
    border-color: #d1d3e2;
    color: #5a5c69;
    font-weight: 500;
}

.badge {
    font-size: 0.75em;
    padding: 0.5em 0.75em;
    border-radius: 0.5rem;
    font-weight: 600;
}
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Link type toggle functionality
    const linkTypeRadios = document.querySelectorAll('input[name="link_type"]');
    const pageSelection = document.getElementById('page-selection');
    const urlInput = document.getElementById('url-input');
    const pageSelect = document.getElementById('page_id');
    const urlField = document.getElementById('url');

    function toggleLinkType() {
        const selectedType = document.querySelector('input[name="link_type"]:checked').value;

        if (selectedType === 'page') {
            pageSelection.style.display = 'block';
            urlInput.style.display = 'none';
            pageSelect.required = true;
            urlField.required = false;
            urlField.value = '';
        } else {
            pageSelection.style.display = 'none';
            urlInput.style.display = 'block';
            pageSelect.required = false;
            urlField.required = true;
            pageSelect.value = '';
        }
    }

    linkTypeRadios.forEach(radio => {
        radio.addEventListener('change', toggleLinkType);
    });

    // Initialize on page load
    toggleLinkType();

    // Icon preview functionality
    const iconInput = document.getElementById('icon');
    const iconPreview = document.getElementById('icon-preview');

    iconInput.addEventListener('input', function() {
        const iconClass = this.value.trim();
        if (iconClass) {
            iconPreview.className = iconClass;
            iconPreview.style.color = '#4e73df';
        } else {
            iconPreview.className = 'fas fa-link';
            iconPreview.style.color = '#6c757d';
        }
    });

    // URL helper functionality
    const urlInputField = document.getElementById('url');
    if (urlInputField) {
        urlInputField.addEventListener('blur', function() {
            let url = this.value.trim();

            // Add leading slash for internal URLs if missing
            if (url && !url.startsWith('http') && !url.startsWith('#') && !url.startsWith('/')) {
                this.value = '/' + url;
            }
        });
    }
});

function confirmDelete(id, label) {
    if (confirm(`Are you sure you want to delete the navigation item "${label}"?\n\nThis action cannot be undone.`)) {
        document.getElementById('deleteForm').submit();
    }
}
</script>
@endsection
