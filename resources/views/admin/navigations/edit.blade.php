@extends('layouts.admin')

@section('title', 'Edit Navigation - Egbe Arobayo')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 mb-0">Edit Navigation Item</h2>
            <p class="text-muted">{{ $navigation->label }}</p>
        </div>
        <a href="{{ route('admin.navigations.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>Back
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.navigations.update', $navigation->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Navigation Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="label" class="form-label">Label *</label>
                            <input type="text" class="form-control @error('label') is-invalid @enderror" 
                                   id="label" name="label" value="{{ old('label', $navigation->label) }}" required>
                            @error('label')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Link Type</label>
                            <div class="btn-group w-100" role="group">
                                <input type="radio" class="btn-check" name="link_type" id="type_page" value="page" 
                                       {{ old('link_type', $navigation->page_id ? 'page' : 'url') == 'page' ? 'checked' : '' }}>
                                <label class="btn btn-outline-primary" for="type_page">Page</label>
                                <input type="radio" class="btn-check" name="link_type" id="type_url" value="url"
                                       {{ old('link_type', $navigation->page_id ? 'page' : 'url') == 'url' ? 'checked' : '' }}>
                                <label class="btn btn-outline-primary" for="type_url">Custom URL</label>
                            </div>
                        </div>

                        <div class="mb-3" id="page_field" style="{{ old('link_type', $navigation->page_id ? 'page' : 'url') == 'page' ? 'display:block' : 'display:none' }}">
                            <label for="page_id" class="form-label">Select Page</label>
                            <select class="form-select @error('page_id') is-invalid @enderror" id="page_id" name="page_id">
                                <option value="">Choose a page...</option>
                                @foreach($pages as $page)
                                    <option value="{{ $page->id }}" {{ old('page_id', $navigation->page_id) == $page->id ? 'selected' : '' }}>
                                        {{ $page->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('page_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3" id="url_field" style="{{ old('link_type', $navigation->page_id ? 'page' : 'url') == 'url' ? 'display:block' : 'display:none' }}">
                            <label for="url" class="form-label">URL</label>
                            <input type="text" class="form-control @error('url') is-invalid @enderror" 
                                   id="url" name="url" value="{{ old('url', $navigation->url) }}" placeholder="/about or https://example.com">
                            @error('url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="icon" class="form-label">Icon (Optional)</label>
                            <input type="text" class="form-control @error('icon') is-invalid @enderror" 
                                   id="icon" name="icon" value="{{ old('icon', $navigation->icon) }}" placeholder="fas fa-home">
                            @error('icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Font Awesome class. <a href="https://fontawesome.com/icons" target="_blank">Browse icons</a></small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Settings</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="parent_id" class="form-label">Parent Menu</label>
                            <select class="form-select @error('parent_id') is-invalid @enderror" id="parent_id" name="parent_id">
                                <option value="">None (Main Menu)</option>
                                @foreach($parentNavigations as $parent)
                                    <option value="{{ $parent->id }}" {{ old('parent_id', $navigation->parent_id) == $parent->id ? 'selected' : '' }}>
                                        {{ $parent->label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('parent_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="target" class="form-label">Link Target</label>
                            <select class="form-select @error('target') is-invalid @enderror" id="target" name="target">
                                <option value="_self" {{ old('target', $navigation->target) == '_self' ? 'selected' : '' }}>Same Window</option>
                                <option value="_blank" {{ old('target', $navigation->target) == '_blank' ? 'selected' : '' }}>New Window</option>
                            </select>
                            @error('target')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                                   id="sort_order" name="sort_order" value="{{ old('sort_order', $navigation->sort_order) }}" min="0">
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                       value="1" {{ old('is_active', $navigation->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary w-100 mb-2">
                            <i class="fas fa-save me-1"></i>Update Navigation
                        </button>
                        <button type="button" class="btn btn-outline-danger w-100" onclick="confirmDelete()">
                            <i class="fas fa-trash me-1"></i>Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this navigation item?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.navigations.destroy', $navigation->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.querySelectorAll('input[name="link_type"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const pageField = document.getElementById('page_field');
        const urlField = document.getElementById('url_field');
        
        if (this.value === 'page') {
            pageField.style.display = 'block';
            urlField.style.display = 'none';
            document.getElementById('url').value = '';
        } else {
            pageField.style.display = 'none';
            urlField.style.display = 'block';
            document.getElementById('page_id').value = '';
        }
    });
});

function confirmDelete() {
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
@endsection