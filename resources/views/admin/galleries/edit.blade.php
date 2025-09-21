@extends('layouts.admin')

@section('title', 'Edit Gallery Image - Egbe Arobayo Admin')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="admin-page-title mb-2">
                        <i class="fas fa-edit me-3"></i>
                        Edit Gallery Image
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
                            <li class="breadcrumb-item active">Edit: {{ $gallery->title }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.galleries.show', $gallery) }}" class="btn btn-info">
                        <i class="fas fa-eye me-1"></i>
                        View
                    </a>
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
                    <form action="{{ route('admin.galleries.update', $gallery) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-12">
                                <!-- Title -->
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                    <input type="text"
                                           class="form-control @error('title') is-invalid @enderror"
                                           id="title"
                                           name="title"
                                           value="{{ old('title', $gallery->title) }}"
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
                                              rows="3">{{ old('description', $gallery->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Optional description for the image</div>
                                </div>

                                <!-- Current Image -->
                                <div class="mb-3">
                                    <label class="form-label">Current Image</label>
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $gallery->image) }}"
                                             alt="{{ $gallery->title }}"
                                             class="img-thumbnail"
                                             style="max-width: 200px;">
                                    </div>
                                </div>

                                <!-- New Image Upload -->
                                <div class="mb-3">
                                    <label for="image" class="form-label">Replace Image</label>
                                    <input type="file"
                                           class="form-control @error('image') is-invalid @enderror"
                                           id="image"
                                           name="image"
                                           accept="image/*">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        Leave empty to keep current image. Supported formats: JPEG, PNG, JPG, GIF, WebP. Maximum size: 5MB
                                    </div>

                                    <!-- New Image Preview -->
                                    <div id="imagePreview" class="mt-3" style="display: none;">
                                        <strong>New Image Preview:</strong>
                                        <img id="previewImg" src="" alt="Preview" class="img-thumbnail mt-2" style="max-width: 200px;">
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
                                               value="{{ old('category', $gallery->category) }}"
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
                                           value="{{ old('sort_order', $gallery->sort_order) }}"
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
                                               {{ old('is_active', $gallery->is_active) ? 'checked' : '' }}>
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
                                        Update Gallery Image
                                    </button>
                                    <a href="{{ route('admin.galleries.show', $gallery) }}" class="btn btn-info">
                                        <i class="fas fa-eye me-1"></i>
                                        View
                                    </a>
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

        <!-- Sidebar with Info -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-info text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Image Information
                    </h6>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <td><strong>Created:</strong></td>
                            <td>{{ $gallery->created_at->format('M j, Y g:i A') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Updated:</strong></td>
                            <td>{{ $gallery->updated_at->format('M j, Y g:i A') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status:</strong></td>
                            <td>
                                @if($gallery->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Category:</strong></td>
                            <td>
                                @if($gallery->category)
                                    <span class="badge bg-light text-dark">{{ ucfirst($gallery->category) }}</span>
                                @else
                                    <span class="text-muted">No category</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Sort Order:</strong></td>
                            <td><span class="badge bg-info">{{ $gallery->sort_order }}</span></td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-warning text-dark">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-lightbulb me-2"></i>
                        Quick Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.galleries.show', $gallery) }}" class="btn btn-outline-info btn-sm">
                            <i class="fas fa-eye me-1"></i>
                            View in Detail
                        </a>
                        <a href="{{ asset('storage/' . $gallery->image) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-external-link-alt me-1"></i>
                            View Full Size
                        </a>
                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="deleteGallery()">
                            <i class="fas fa-trash me-1"></i>
                            Delete Image
                        </button>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-primary text-white">
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
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete "<strong>{{ $gallery->title }}</strong>"?</p>
                <p class="text-danger"><small><i class="fas fa-exclamation-triangle me-1"></i>This action cannot be undone and will also delete the image file.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.galleries.destroy', $gallery) }}" method="POST" style="display: inline;">
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

// Delete gallery function
function deleteGallery() {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}

// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    const title = document.getElementById('title').value.trim();

    if (!title) {
        alert('Please enter a title for the gallery image');
        e.preventDefault();
        return;
    }
});
</script>
@endsection
