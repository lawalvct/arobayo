@extends('layouts.admin')

@section('title', 'Create Navigation - Egbe Arobayo')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 mb-0">Create Navigation Item</h2>
            <p class="text-muted">Add a new item to the navigation menu</p>
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

    <form action="{{ route('admin.navigations.store') }}" method="POST">
        @csrf

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
                                   id="label" name="label" value="{{ old('label') }}" required>
                            @error('label')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Link Type</label>
                            <div class="btn-group w-100" role="group">
                                <input type="radio" class="btn-check" name="link_type" id="type_page" value="page" checked>
                                <label class="btn btn-outline-primary" for="type_page">Page</label>
                                <input type="radio" class="btn-check" name="link_type" id="type_url" value="url">
                                <label class="btn btn-outline-primary" for="type_url">Custom URL</label>
                            </div>
                        </div>

                        <div class="mb-3" id="page_field">
                            <label for="page_id" class="form-label">Select Page</label>
                            <select class="form-select @error('page_id') is-invalid @enderror" id="page_id" name="page_id">
                                <option value="">Choose a page...</option>
                                @foreach($pages as $page)
                                    <option value="{{ $page->id }}" {{ old('page_id') == $page->id ? 'selected' : '' }}>
                                        {{ $page->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('page_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3" id="url_field" style="display: none;">
                            <label for="url" class="form-label">URL</label>
                            <input type="text" class="form-control @error('url') is-invalid @enderror" 
                                   id="url" name="url" value="{{ old('url') }}" placeholder="/about or https://example.com">
                            @error('url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="icon" class="form-label">Icon (Optional)</label>
                            <input type="text" class="form-control @error('icon') is-invalid @enderror" 
                                   id="icon" name="icon" value="{{ old('icon') }}" placeholder="fas fa-home">
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
                                    <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
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
                                <option value="_self" {{ old('target', '_self') == '_self' ? 'selected' : '' }}>Same Window</option>
                                <option value="_blank" {{ old('target') == '_blank' ? 'selected' : '' }}>New Window</option>
                            </select>
                            @error('target')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                                   id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                       value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-save me-1"></i>Create Navigation
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
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
</script>
@endsection