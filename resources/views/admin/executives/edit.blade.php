@extends('layouts.admin')

@section('title', 'Edit Executive - Egbe Arobayo Admin')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="admin-page-title mb-2">
                        <i class="fas fa-edit me-3"></i>
                        Edit Executive
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">
                                    <i class="fas fa-home me-1"></i>Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.executives.index') }}" class="text-decoration-none">Executives</a>
                            </li>
                            <li class="breadcrumb-item active">Edit: {{ $executive->name }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.executives.show', $executive) }}" class="btn btn-info">
                        <i class="fas fa-eye me-1"></i>
                        View
                    </a>
                    <a href="{{ route('admin.executives.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>
                        Back to Executives
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
                        <i class="fas fa-user me-2"></i>
                        Executive Information
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.executives.update', $executive) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <!-- Name -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           id="name"
                                           name="name"
                                           value="{{ old('name', $executive->name) }}"
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- Position -->
                                <div class="mb-3">
                                    <label for="position" class="form-label">Position/Title <span class="text-danger">*</span></label>
                                    <input type="text"
                                           class="form-control @error('position') is-invalid @enderror"
                                           id="position"
                                           name="position"
                                           value="{{ old('position', $executive->position) }}"
                                           required>
                                    @error('position')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Biography -->
                        <div class="mb-3">
                            <label for="bio" class="form-label">Biography</label>
                            <textarea class="form-control @error('bio') is-invalid @enderror"
                                      id="bio"
                                      name="bio"
                                      rows="4">{{ old('bio', $executive->bio) }}</textarea>
                            @error('bio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Optional biography for the executive member</div>
                        </div>

                        <!-- Current Photo -->
                        @if($executive->image)
                        <div class="mb-3">
                            <label class="form-label">Current Photo</label>
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $executive->image) }}"
                                     alt="{{ $executive->name }}"
                                     class="img-thumbnail rounded-circle"
                                     style="width: 150px; height: 150px; object-fit: cover;">
                            </div>
                        </div>
                        @endif

                        <!-- New Profile Photo -->
                        <div class="mb-3">
                            <label for="image" class="form-label">{{ $executive->image ? 'Replace Photo' : 'Profile Photo' }}</label>
                            <input type="file"
                                   class="form-control @error('image') is-invalid @enderror"
                                   id="image"
                                   name="image"
                                   accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                {{ $executive->image ? 'Leave empty to keep current photo.' : '' }} Supported formats: JPEG, PNG, JPG, GIF, WebP. Maximum size: 5MB
                            </div>

                            <!-- New Image Preview -->
                            <div id="imagePreview" class="mt-3" style="display: none;">
                                <strong>New Photo Preview:</strong>
                                <img id="previewImg" src="" alt="Preview" class="img-thumbnail rounded-circle mt-2" style="width: 150px; height: 150px; object-fit: cover;">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           id="email"
                                           name="email"
                                           value="{{ old('email', $executive->email) }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- Phone -->
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel"
                                           class="form-control @error('phone') is-invalid @enderror"
                                           id="phone"
                                           name="phone"
                                           value="{{ old('phone', $executive->phone) }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Social Media Links -->
                        <div class="mb-3">
                            <label class="form-label">Social Media Links</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group mb-2">
                                        <span class="input-group-text"><i class="fab fa-facebook-f text-primary"></i></span>
                                        <input type="url"
                                               class="form-control @error('social_links.facebook') is-invalid @enderror"
                                               name="social_links[facebook]"
                                               value="{{ old('social_links.facebook', $executive->social_links['facebook'] ?? '') }}"
                                               placeholder="Facebook profile URL">
                                        @error('social_links.facebook')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group mb-2">
                                        <span class="input-group-text"><i class="fab fa-twitter text-info"></i></span>
                                        <input type="url"
                                               class="form-control @error('social_links.twitter') is-invalid @enderror"
                                               name="social_links[twitter]"
                                               value="{{ old('social_links.twitter', $executive->social_links['twitter'] ?? '') }}"
                                               placeholder="Twitter profile URL">
                                        @error('social_links.twitter')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group mb-2">
                                        <span class="input-group-text"><i class="fab fa-linkedin text-primary"></i></span>
                                        <input type="url"
                                               class="form-control @error('social_links.linkedin') is-invalid @enderror"
                                               name="social_links[linkedin]"
                                               value="{{ old('social_links.linkedin', $executive->social_links['linkedin'] ?? '') }}"
                                               placeholder="LinkedIn profile URL">
                                        @error('social_links.linkedin')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group mb-2">
                                        <span class="input-group-text"><i class="fab fa-instagram text-danger"></i></span>
                                        <input type="url"
                                               class="form-control @error('social_links.instagram') is-invalid @enderror"
                                               name="social_links[instagram]"
                                               value="{{ old('social_links.instagram', $executive->social_links['instagram'] ?? '') }}"
                                               placeholder="Instagram profile URL">
                                        @error('social_links.instagram')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-text">Optional social media profile links</div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <!-- Sort Order -->
                                <div class="mb-3">
                                    <label for="sort_order" class="form-label">Display Order</label>
                                    <input type="number"
                                           class="form-control @error('sort_order') is-invalid @enderror"
                                           id="sort_order"
                                           name="sort_order"
                                           value="{{ old('sort_order', $executive->sort_order) }}"
                                           min="0">
                                    @error('sort_order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Lower numbers appear first (0 = highest priority)</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- Status -->
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <div class="form-check">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               id="is_active"
                                               name="is_active"
                                               value="1"
                                               {{ old('is_active', $executive->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            <strong>Active</strong>
                                            <small class="text-muted d-block">Make this executive visible on the website</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>
                                Update Executive
                            </button>
                            <a href="{{ route('admin.executives.show', $executive) }}" class="btn btn-info">
                                <i class="fas fa-eye me-1"></i>
                                View
                            </a>
                            <a href="{{ route('admin.executives.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>
                                Cancel
                            </a>
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
                        Executive Information
                    </h6>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <td><strong>Created:</strong></td>
                            <td>{{ $executive->created_at->format('M j, Y g:i A') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Updated:</strong></td>
                            <td>{{ $executive->updated_at->format('M j, Y g:i A') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status:</strong></td>
                            <td>
                                @if($executive->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Display Order:</strong></td>
                            <td><span class="badge bg-info">{{ $executive->sort_order }}</span></td>
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
                        <a href="{{ route('admin.executives.show', $executive) }}" class="btn btn-outline-info btn-sm">
                            <i class="fas fa-eye me-1"></i>
                            View Details
                        </a>
                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="deleteExecutive()">
                            <i class="fas fa-trash me-1"></i>
                            Delete Executive
                        </button>
                    </div>
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
                <p>Are you sure you want to delete "<strong>{{ $executive->name }}</strong>"?</p>
                <p class="text-danger"><small><i class="fas fa-exclamation-triangle me-1"></i>This action cannot be undone and will also delete the profile photo.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.executives.destroy', $executive) }}" method="POST" style="display: inline;">
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

// Delete executive function
function deleteExecutive() {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}

// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    const name = document.getElementById('name').value.trim();
    const position = document.getElementById('position').value.trim();

    if (!name) {
        alert('Please enter the executive\'s full name');
        e.preventDefault();
        return;
    }

    if (!position) {
        alert('Please enter the executive\'s position/title');
        e.preventDefault();
        return;
    }
});
</script>
@endsection
