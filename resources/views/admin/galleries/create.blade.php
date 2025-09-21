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
                                    <label for="image" class="form-label">Image <span class="text-danger">*</span></label>
                                    <input type="file"
                                           class="form-control @error('image') is-invalid @enderror"
                                           id="image"
                                           name="image"
                                           accept="image/*"
                                           required>
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        Supported formats: JPEG, PNG, JPG, GIF, WebP. Maximum size: 5MB
                                    </div>

                                    <!-- Image Preview -->
                                    <div id="imagePreview" class="mt-3" style="display: none;">
                                        <img id="previewImg" src="" alt="Preview" class="img-thumbnail" style="max-width: 200px;">
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
@endsection

@section('scripts')
<script>
// Image preview functionality
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');

    if (file) {
        // Check file size (5MB = 5 * 1024 * 1024 bytes)
        if (file.size > 5 * 1024 * 1024) {
            alert('File size must be less than 5MB');
            e.target.value = '';
            preview.style.display = 'none';
            return;
        }

        // Check file type
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
        if (!allowedTypes.includes(file.type)) {
            alert('Please select a valid image file (JPEG, PNG, GIF, WebP)');
            e.target.value = '';
            preview.style.display = 'none';
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        preview.style.display = 'none';
    }
});

// Auto-generate category suggestions
document.getElementById('category').addEventListener('input', function(e) {
    const value = e.target.value.toLowerCase();
    // You could add AJAX call here to get dynamic suggestions
});

// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    const title = document.getElementById('title').value.trim();
    const image = document.getElementById('image').files[0];

    if (!title) {
        alert('Please enter a title for the gallery image');
        e.preventDefault();
        return;
    }

    if (!image) {
        alert('Please select an image to upload');
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
