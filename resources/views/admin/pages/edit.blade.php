@extends('layouts.admin')

@section('title', 'Edit Page - Egbe Arobayo')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 mb-0">Edit Page</h2>
            <p class="text-muted">{{ $page->title }}</p>
        </div>
        <div>
            <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary me-2">
                <i class="fas fa-arrow-left me-1"></i>Back
            </a>
            <a href="{{ url($page->slug === 'home' ? '/' : '/' . $page->slug) }}" 
               class="btn btn-outline-primary" target="_blank">
                <i class="fas fa-external-link-alt me-1"></i>Preview
            </a>
        </div>
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

    <form action="{{ route('admin.pages.update', $page) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Page Content</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', $page->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="slug" class="form-label">URL Slug *</label>
                            <div class="input-group">
                                <span class="input-group-text">{{ url('/') }}/</span>
                                <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                                       id="slug" name="slug" value="{{ old('slug', $page->slug) }}" 
                                       {{ $page->slug === 'home' ? 'readonly' : '' }} required>
                            </div>
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Content *</label>
                            <div id="editor" style="min-height: 300px; border: 1px solid #ced4da; border-radius: 0.375rem;"></div>
                            <textarea class="form-control @error('content') is-invalid @enderror d-none" 
                                      id="content" name="content" required>{{ old('content', $page->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
                            <label for="template" class="form-label">Template</label>
                            <select class="form-select @error('template') is-invalid @enderror" 
                                    id="template" name="template" {{ $page->slug === 'home' ? 'disabled' : '' }}>
                                <option value="default" {{ old('template', $page->template) == 'default' ? 'selected' : '' }}>Default</option>
                                <option value="home" {{ old('template', $page->template) == 'home' ? 'selected' : '' }}>Home</option>
                            </select>
                            @if($page->slug === 'home')
                                <input type="hidden" name="template" value="{{ $page->template }}">
                            @endif
                            @error('template')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                       value="1" {{ old('is_active', $page->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Published</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">SEO</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="meta_title" class="form-label">Meta Title</label>
                            <input type="text" class="form-control @error('meta_title') is-invalid @enderror" 
                                   id="meta_title" name="meta_title" value="{{ old('meta_title', $page->meta_title) }}">
                            @error('meta_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="meta_description" class="form-label">Meta Description</label>
                            <textarea class="form-control @error('meta_description') is-invalid @enderror" 
                                      id="meta_description" name="meta_description" rows="3">{{ old('meta_description', $page->meta_description) }}</textarea>
                            @error('meta_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Update Page
                            </button>
                            @if($page->slug !== 'home')
                                <button type="button" class="btn btn-outline-danger" 
                                        onclick="confirmDelete('{{ $page->id }}')">
                                    <i class="fas fa-trash me-1"></i>Delete Page
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@if($page->slug !== 'home')
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this page?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@section('styles')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endsection

@section('scripts')
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
// Initialize Quill editor
const quill = new Quill('#editor', {
    theme: 'snow',
    modules: {
        toolbar: [
            [{ 'header': [1, 2, 3, false] }],
            ['bold', 'italic', 'underline'],
            ['link', 'image'],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            [{ 'align': [] }],
            ['clean']
        ]
    }
});

// Set initial content
quill.root.innerHTML = document.getElementById('content').value;

// Update hidden textarea on content change
quill.on('text-change', function() {
    document.getElementById('content').value = quill.root.innerHTML;
});

// Auto-generate slug from title
document.getElementById('title').addEventListener('input', function() {
    if ('{{ $page->slug }}' !== 'home') {
        const title = this.value;
        const slug = title.toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim('-');
        document.getElementById('slug').value = slug;
    }
});

@if($page->slug !== 'home')
function confirmDelete(pageId) {
    document.getElementById('deleteForm').action = '{{ route("admin.pages.destroy", ":id") }}'.replace(':id', pageId);
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
@endif
</script>
@endsection