@extends('layouts.admin')

@section('title', 'Create Navigation Item - Egbe Arobayo')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="admin-page-title">
                <i class="fas fa-plus me-3"></i>
                Create Navigation Item
            </h2>
            <p class="admin-page-subtitle mb-0">
                Add a new item to the website navigation menu
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

    <form action="{{ route('admin.navigations.store') }}" method="POST">
        @csrf

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
                                   id="label" name="label" value="{{ old('label') }}" required
                                   placeholder="Enter menu label (e.g., About Us, Contact)">
                            @error('label')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">This is the text that will appear in the navigation menu.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Link Type</label>
                            <div class="btn-group d-flex" role="group">
                                <input type="radio" class="btn-check" name="link_type" id="link_type_page" value="page" checked>
                                <label class="btn btn-outline-primary" for="link_type_page">
                                    <i class="fas fa-file-alt me-2"></i>Link to Page
                                </label>
                                <input type="radio" class="btn-check" name="link_type" id="link_type_url" value="url">
                                <label class="btn btn-outline-primary" for="link_type_url">
                                    <i class="fas fa-link me-2"></i>Custom URL
                                </label>
                            </div>
                        </div>

                        <div class="mb-3" id="page-selection">
                            <label for="page_id" class="form-label fw-bold">Select Page</label>
                            <select class="form-select @error('page_id') is-invalid @enderror" id="page_id" name="page_id">
                                <option value="">Choose a page...</option>
                                @foreach($pages as $page)
                                    <option value="{{ $page->id }}" {{ old('page_id') == $page->id ? 'selected' : '' }}>
                                        {{ $page->title }} ({{ $page->slug === 'home' ? '/' : '/'.$page->slug }})
                                    </option>
                                @endforeach
                            </select>
                            @error('page_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Select an existing page to link to.</div>
                        </div>

                        <div class="mb-3" id="url-input" style="display: none;">
                            <label for="url" class="form-label fw-bold">URL <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('url') is-invalid @enderror"
                                   id="url" name="url" value="{{ old('url') }}"
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
                                    <i id="icon-preview" class="{{ old('icon', 'fas fa-link') }}"></i>
                                </span>
                                <input type="text" class="form-control @error('icon') is-invalid @enderror"
                                       id="icon" name="icon" value="{{ old('icon') }}"
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
                                            {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
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
                                <option value="_self" {{ old('target', '_self') == '_self' ? 'selected' : '' }}>
                                    Same Window
                                </option>
                                <option value="_blank" {{ old('target') == '_blank' ? 'selected' : '' }}>
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
                                   id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}"
                                   min="0" placeholder="0">
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Lower numbers appear first. Leave 0 for auto-order.</div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input @error('is_active') is-invalid @enderror"
                                       type="checkbox" id="is_active" name="is_active" value="1"
                                       {{ old('is_active', '1') ? 'checked' : '' }}>
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
                                Create Navigation Item
                            </button>
                            <a href="{{ route('admin.navigations.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
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
    urlInputField.addEventListener('blur', function() {
        let url = this.value.trim();

        // Add leading slash for internal URLs if missing
        if (url && !url.startsWith('http') && !url.startsWith('#') && !url.startsWith('/')) {
            this.value = '/' + url;
        }
    });

    // Auto-generate sort order based on parent selection
    const parentSelect = document.getElementById('parent_id');
    const sortOrderInput = document.getElementById('sort_order');

    parentSelect.addEventListener('change', function() {
        if (sortOrderInput.value == 0 || sortOrderInput.value == '') {
            // You could make an AJAX call here to get the next sort order
            // For now, we'll just reset to 0
            sortOrderInput.value = 0;
        }
    });
});
</script>
@endsection
