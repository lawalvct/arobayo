@extends('layouts.admin')

@section('title', 'Add New Gallery Image - Egbe Arobayo Admin')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="admin-page-title mb-2">
                        <i class="fas fa-plus me-3"></i>
                        Add New Gallery Image
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">
                                    <i class="fas fa-home me-1"></i>Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.galleries.index') }}" class="text-decoration-none">Gallery</a>
                            </li>
                            <li class="breadcrumb-item active">Add New</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.galleries.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>
                        Back to Gallery
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-image me-2"></i>
                        Gallery Image Details
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-12">
                                <!-- Title -->
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                    <input type="text"
                                           class="form-control @error('title') is-invalid @enderror"
                                           id="title"
                                           name="title"
                                           value="{{ old('title') }}"
                                           required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror"
                                              id="description"
                                              name="description"
                                              rows="3">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Optional description for the image</div>
                                </div>

                                <!-- Image Upload -->
                                <div class="mb-3">
                                    <label class="form-label">Image <span class="text-danger">*</span></label>
                                    <div class="btn-group w-100 mb-2" role="group">
                                        <input type="radio" class="btn-check" name="image_source" id="upload_new" value="upload" checked>
                                        <label class="btn btn-outline-primary" for="upload_new">
                                            <i class="fas fa-upload me-1"></i> Upload New
                                        </label>
                                        <input type="radio" class="btn-check" name="image_source" id="from_media" value="media">
                                        <label class="btn btn-outline-primary" for="from_media">
                                            <i class="fas fa-photo-video me-1"></i> Choose from Media
                                        </label>
                                    </div>

                                    <div id="uploadSection">
                                        <input type="file"
                                               class="form-control @error('images') is-invalid @enderror"
                                               id="images"
                                               name="images[]"
                                               accept="image/*"
                                               multiple>
                                        @error('images')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">
                                            Select multiple images. Max 5MB per file.
                                        </div>
                                        <div id="imagePreview" class="mt-3 d-flex flex-wrap gap-2"></div>
                                    </div>

                                    <div id="mediaSection" style="display: none;">
                                        <div id="selectedMediaIds"></div>
                                        <button type="button" class="btn btn-outline-secondary w-100" data-bs-toggle="modal" data-bs-target="#mediaModal">
                                            <i class="fas fa-images me-2"></i>Select from Media Library
                                        </button>
                                        <div id="selectedMedia" class="mt-3 d-flex flex-wrap gap-2"></div>
                                    </div>
                                </div>

                                <!-- Category -->
                                <div class="mb-3">
                                    <label for="category" class="form-label">Category</label>
                                    <div class="input-group">
                                        <input type="text"
                                               class="form-control @error('category') is-invalid @enderror"
                                               id="category"
                                               name="category"
                                               value="{{ old('category') }}"
                                               list="categoryList">
                                        <datalist id="categoryList">
                                            @foreach($categories as $cat)
                                                <option value="{{ $cat }}">
                                            @endforeach
                                        </datalist>
                                        @error('category')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-text">Optional category for organizing images</div>
                                </div>

                                <!-- Sort Order -->
                                <div class="mb-3">
                                    <label for="sort_order" class="form-label">Sort Order</label>
                                    <input type="number"
                                           class="form-control @error('sort_order') is-invalid @enderror"
                                           id="sort_order"
                                           name="sort_order"
                                           value="{{ old('sort_order', 0) }}"
                                           min="0">
                                    @error('sort_order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Lower numbers appear first (0 = highest priority)</div>
                                </div>

                                <!-- Status -->
                                <div class="mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               id="is_active"
                                               name="is_active"
                                               value="1"
                                               {{ old('is_active', true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            <strong>Active</strong>
                                            <small class="text-muted d-block">Make this image visible in the public gallery</small>
                                        </label>
                                    </div>
                                </div>

                                <!-- Submit Buttons -->
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i>
                                        Save Gallery Image
                                    </button>
                                    <button type="submit" name="save_and_new" value="1" class="btn btn-success">
                                        <i class="fas fa-plus me-1"></i>
                                        Save & Add Another
                                    </button>
                                    <a href="{{ route('admin.galleries.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times me-1"></i>
                                        Cancel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar with Tips -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-lightbulb me-2"></i>
                        Tips for Great Gallery Images
                    </h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Use high-quality images (at least 800px wide)
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Choose descriptive titles for better organization
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Group related images using categories
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Use sort order to feature important images first
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            WebP format provides best compression
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-info text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Image Specifications
                    </h6>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <td><strong>Formats:</strong></td>
                            <td>JPEG, PNG, GIF, WebP</td>
                        </tr>
                        <tr>
                            <td><strong>Max Size:</strong></td>
                            <td>5MB</td>
                        </tr>
                        <tr>
                            <td><strong>Recommended:</strong></td>
                            <td>800px × 600px or larger</td>
                        </tr>
                        <tr>
                            <td><strong>Aspect Ratio:</strong></td>
                            <td>4:3 or 16:9 preferred</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Media Library Modal -->
<div class="modal fade" id="mediaModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-photo-video me-2"></i>
                    Select from Media Library
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <button type="button" class="btn btn-success" onclick="confirmMediaSelection()">
                        <i class="fas fa-check me-2"></i>Confirm Selection
                    </button>
                    <span id="selectionCount" class="ms-2 text-muted">0 selected</span>
                </div>
                <div class="row g-3" id="mediaLibrary">
                    <div class="col-12 text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let selectedMediaItems = [];

// Toggle between upload and media selection
document.querySelectorAll('input[name="image_source"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const uploadSection = document.getElementById('uploadSection');
        const mediaSection = document.getElementById('mediaSection');
        const imageInput = document.getElementById('images');
        
        if (this.value === 'upload') {
            uploadSection.style.display = 'block';
            mediaSection.style.display = 'none';
            imageInput.required = true;
            selectedMediaItems = [];
        } else {
            uploadSection.style.display = 'none';
            mediaSection.style.display = 'block';
            imageInput.required = false;
            imageInput.value = '';
            document.getElementById('imagePreview').innerHTML = '';
        }
    });
});

// Load media library
const mediaModal = document.getElementById('mediaModal');
mediaModal.addEventListener('show.bs.modal', function() {
    fetch('/admin/media?ajax=1')
        .then(response => response.json())
        .then(data => {
            const mediaLibrary = document.getElementById('mediaLibrary');
            mediaLibrary.innerHTML = '';
            
            if (data.media && data.media.length > 0) {
                data.media.forEach(item => {
                    if (item.type === 'image') {
                        const isSelected = selectedMediaItems.some(m => m.id === item.id);
                        const col = document.createElement('div');
                        col.className = 'col-md-3';
                        col.innerHTML = `
                            <div class="media-item-select ${isSelected ? 'border border-primary' : ''}" onclick="toggleMediaSelection(${item.id}, '${item.url}', '${item.title}')" style="cursor: pointer; position: relative;">
                                <img src="${item.url}" class="img-thumbnail" style="width: 100%; height: 150px; object-fit: cover;">
                                <p class="text-center mt-2 mb-0 small">${item.title}</p>
                                ${isSelected ? '<div style="position: absolute; top: 10px; right: 10px; background: #0d6efd; color: white; border-radius: 50%; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;"><i class="fas fa-check"></i></div>' : ''}
                            </div>
                        `;
                        mediaLibrary.appendChild(col);
                    }
                });
            } else {
                mediaLibrary.innerHTML = '<div class="col-12 text-center py-4"><p class="text-muted">No images in media library</p></div>';
            }
            updateSelectionCount();
        });
});

function toggleMediaSelection(id, url, title) {
    const index = selectedMediaItems.findIndex(m => m.id === id);
    if (index > -1) {
        selectedMediaItems.splice(index, 1);
    } else {
        selectedMediaItems.push({ id, url, title });
    }
    
    // Reload media library to show selection
    mediaModal.dispatchEvent(new Event('show.bs.modal'));
}

function confirmMediaSelection() {
    const container = document.getElementById('selectedMedia');
    const idsContainer = document.getElementById('selectedMediaIds');
    container.innerHTML = '';
    idsContainer.innerHTML = '';
    
    selectedMediaItems.forEach(item => {
        idsContainer.innerHTML += `<input type="hidden" name="media_ids[]" value="${item.id}">`;
        container.innerHTML += `
            <div class="position-relative">
                <img src="${item.url}" class="img-thumbnail" style="width: 150px; height: 150px; object-fit: cover;">
                <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0" onclick="removeMediaItem(${item.id})">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
    });
    
    bootstrap.Modal.getInstance(document.getElementById('mediaModal')).hide();
}

function removeMediaItem(id) {
    selectedMediaItems = selectedMediaItems.filter(m => m.id !== id);
    confirmMediaSelection();
}

function updateSelectionCount() {
    document.getElementById('selectionCount').textContent = `${selectedMediaItems.length} selected`;
}

// Image preview functionality
document.getElementById('images').addEventListener('change', function(e) {
    const files = Array.from(e.target.files);
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';

    files.forEach(file => {
        if (file.size > 5 * 1024 * 1024) {
            alert(`${file.name} is too large (max 5MB)`);
            return;
        }

        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
        if (!allowedTypes.includes(file.type)) {
            alert(`${file.name} is not a valid image`);
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            const div = document.createElement('div');
            div.innerHTML = `<img src="${e.target.result}" class="img-thumbnail" style="width: 150px; height: 150px; object-fit: cover;">`;
            preview.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
});

// Auto-generate category suggestions
document.getElementById('category').addEventListener('input', function(e) {
    const value = e.target.value.toLowerCase();
    // You could add AJAX call here to get dynamic suggestions
});

// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    const title = document.getElementById('title').value.trim();
    const imageSource = document.querySelector('input[name="image_source"]:checked').value;
    const images = document.getElementById('images').files;

    if (!title) {
        alert('Please enter a title for the gallery');
        e.preventDefault();
        return;
    }

    if (imageSource === 'upload' && images.length === 0) {
        alert('Please select at least one image to upload');
        e.preventDefault();
        return;
    }

    if (imageSource === 'media' && selectedMediaItems.length === 0) {
        alert('Please select at least one image from media library');
        e.preventDefault();
        return;
    }
});

// Handle Save & Add Another functionality
document.addEventListener('DOMContentLoaded', function() {
    @if(session('success') && request()->has('save_and_new'))
        // Clear form for new entry
        document.querySelector('form').reset();
        document.getElementById('imagePreview').style.display = 'none';
    @endif
});
</script>
@endsection
