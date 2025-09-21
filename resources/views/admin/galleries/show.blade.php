@extends('layouts.admin')

@section('title', $gallery->title . ' - Gallery Details')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="admin-page-title mb-2">
                        <i class="fas fa-image me-3"></i>
                        Gallery Image Details
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
                            <li class="breadcrumb-item active">{{ Str::limit($gallery->title, 30) }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.galleries.edit', $gallery) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-1"></i>
                        Edit
                    </a>
                    <a href="{{ route('admin.galleries.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>
                        Back to Gallery
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Gallery Details -->
    <div class="row">
        <div class="col-lg-8">
            <!-- Main Image Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-image me-2"></i>
                            {{ $gallery->title }}
                        </h5>
                        <div class="d-flex gap-2">
                            @if($gallery->is_active)
                                <span class="badge bg-success fs-6">Active</span>
                            @else
                                <span class="badge bg-secondary fs-6">Inactive</span>
                            @endif
                            @if($gallery->category)
                                <span class="badge bg-primary fs-6">{{ ucfirst($gallery->category) }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="text-center bg-light p-4">
                        <img src="{{ asset('storage/' . $gallery->image) }}"
                             alt="{{ $gallery->title }}"
                             class="img-fluid rounded shadow"
                             style="max-height: 500px; cursor: pointer;"
                             onclick="openFullScreen()">
                        <div class="mt-3">
                            <a href="{{ asset('storage/' . $gallery->image) }}"
                               target="_blank"
                               class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-external-link-alt me-1"></i>
                                View Full Size
                            </a>
                            <button type="button"
                                    class="btn btn-outline-info btn-sm ms-2"
                                    onclick="downloadImage()">
                                <i class="fas fa-download me-1"></i>
                                Download
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description Card -->
            @if($gallery->description)
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-align-left me-2"></i>
                        Description
                    </h5>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $gallery->description }}</p>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Image Information -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Image Information
                    </h6>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td><strong>Title:</strong></td>
                            <td>{{ $gallery->title }}</td>
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
                            <td><strong>Sort Order:</strong></td>
                            <td><span class="badge bg-info">{{ $gallery->sort_order }}</span></td>
                        </tr>
                        <tr>
                            <td><strong>Created:</strong></td>
                            <td>
                                {{ $gallery->created_at->format('M j, Y') }}<br>
                                <small class="text-muted">{{ $gallery->created_at->format('g:i A') }}</small>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Updated:</strong></td>
                            <td>
                                {{ $gallery->updated_at->format('M j, Y') }}<br>
                                <small class="text-muted">{{ $gallery->updated_at->format('g:i A') }}</small>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-bolt me-2"></i>
                        Quick Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.galleries.edit', $gallery) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit me-1"></i>
                            Edit Image
                        </a>

                        @if($gallery->is_active)
                            <form action="{{ route('admin.galleries.bulk-toggle-status') }}" method="POST" style="display: inline;">
                                @csrf
                                <input type="hidden" name="ids[]" value="{{ $gallery->id }}">
                                <input type="hidden" name="status" value="deactivate">
                                <button type="submit" class="btn btn-warning btn-sm w-100">
                                    <i class="fas fa-eye-slash me-1"></i>
                                    Deactivate
                                </button>
                            </form>
                        @else
                            <form action="{{ route('admin.galleries.bulk-toggle-status') }}" method="POST" style="display: inline;">
                                @csrf
                                <input type="hidden" name="ids[]" value="{{ $gallery->id }}">
                                <input type="hidden" name="status" value="activate">
                                <button type="submit" class="btn btn-success btn-sm w-100">
                                    <i class="fas fa-eye me-1"></i>
                                    Activate
                                </button>
                            </form>
                        @endif

                        <a href="{{ asset('storage/' . $gallery->image) }}"
                           target="_blank"
                           class="btn btn-info btn-sm">
                            <i class="fas fa-external-link-alt me-1"></i>
                            View Full Size
                        </a>

                        <button type="button"
                                class="btn btn-danger btn-sm"
                                onclick="deleteGallery()">
                            <i class="fas fa-trash me-1"></i>
                            Delete Image
                        </button>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-info text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-arrows-alt-h me-2"></i>
                        Navigation
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.galleries.create') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-plus me-1"></i>
                            Add New Image
                        </a>
                        <a href="{{ route('admin.galleries.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-list me-1"></i>
                            All Gallery Images
                        </a>
                        <a href="{{ route('gallery.index') }}" target="_blank" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-eye me-1"></i>
                            View Public Gallery
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Full Screen Modal -->
<div class="modal fade" id="fullScreenModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $gallery->title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0 text-center">
                <img src="{{ asset('storage/' . $gallery->image) }}"
                     alt="{{ $gallery->title }}"
                     class="img-fluid">
            </div>
            @if($gallery->description)
            <div class="modal-footer">
                <p class="mb-0 text-muted">{{ $gallery->description }}</p>
            </div>
            @endif
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
// Open full screen modal
function openFullScreen() {
    const modal = new bootstrap.Modal(document.getElementById('fullScreenModal'));
    modal.show();
}

// Delete gallery function
function deleteGallery() {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}

// Download image function
function downloadImage() {
    const link = document.createElement('a');
    link.href = '{{ asset("storage/" . $gallery->image) }}';
    link.download = '{{ $gallery->title }}.{{ pathinfo($gallery->image, PATHINFO_EXTENSION) }}';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // E = Edit
    if (e.key === 'e' || e.key === 'E') {
        window.location.href = '{{ route("admin.galleries.edit", $gallery) }}';
    }

    // D = Delete
    if (e.key === 'd' || e.key === 'D') {
        deleteGallery();
    }

    // F = Full screen
    if (e.key === 'f' || e.key === 'F') {
        openFullScreen();
    }

    // Escape = Back to index
    if (e.key === 'Escape') {
        window.location.href = '{{ route("admin.galleries.index") }}';
    }
});
</script>
@endsection
