@extends('layouts.admin')

@section('title', 'Gallery Management - Egbe Arobayo Admin')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="admin-page-title mb-2">
                        <i class="fas fa-images me-3"></i>
                        Gallery Management
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">
                                    <i class="fas fa-home me-1"></i>Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item active">Gallery</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.galleries.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>
                        Add New Image
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Error Message -->
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Gallery Stats -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card stats-card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-primary text-white rounded-circle p-3 me-3">
                            <i class="fas fa-images fa-lg"></i>
                        </div>
                        <div>
                            <div class="stats-number h3 mb-0">{{ $stats['total'] }}</div>
                            <div class="stats-label text-muted">Total Images</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card stats-card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-success text-white rounded-circle p-3 me-3">
                            <i class="fas fa-check-circle fa-lg"></i>
                        </div>
                        <div>
                            <div class="stats-number h3 mb-0">{{ $stats['active'] }}</div>
                            <div class="stats-label text-muted">Active Images</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card stats-card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-info text-white rounded-circle p-3 me-3">
                            <i class="fas fa-tags fa-lg"></i>
                        </div>
                        <div>
                            <div class="stats-number h3 mb-0">{{ $stats['categories'] }}</div>
                            <div class="stats-label text-muted">Categories</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card stats-card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-warning text-white rounded-circle p-3 me-3">
                            <i class="fas fa-calendar-plus fa-lg"></i>
                        </div>
                        <div>
                            <div class="stats-number h3 mb-0">{{ $stats['recent'] }}</div>
                            <div class="stats-label text-muted">Recent (30 days)</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gallery Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list me-2"></i>
                        Gallery Images
                    </h5>
                </div>
                <div class="col-auto">
                    <div class="d-flex gap-2" id="bulkActions" style="display: none !important;">
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="bulkDelete()">
                            <i class="fas fa-trash me-1"></i>
                            Delete Selected
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-success" onclick="bulkToggleStatus('activate')">
                            <i class="fas fa-check me-1"></i>
                            Activate Selected
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-warning" onclick="bulkToggleStatus('deactivate')">
                            <i class="fas fa-times me-1"></i>
                            Deactivate Selected
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            @if($galleries->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="50">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="selectAll">
                                    </div>
                                </th>
                                <th width="80">Image</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th width="100">Status</th>
                                <th width="80">Order</th>
                                <th width="120">Created</th>
                                <th width="150">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($galleries as $gallery)
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input gallery-checkbox" type="checkbox" value="{{ $gallery->id }}">
                                        </div>
                                    </td>
                                    <td>
                                        <img src="{{ asset('storage/' . $gallery->image) }}"
                                             alt="{{ $gallery->title }}"
                                             class="img-thumbnail"
                                             style="width: 60px; height: 60px; object-fit: cover;">
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $gallery->title }}</strong>
                                            @if($gallery->description)
                                                <br>
                                                <small class="text-muted">{{ Str::limit($gallery->description, 60) }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if($gallery->category)
                                            <span class="badge bg-light text-dark">{{ ucfirst($gallery->category) }}</span>
                                        @else
                                            <span class="text-muted">No category</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($gallery->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $gallery->sort_order }}</span>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $gallery->created_at->format('M j, Y') }}
                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.galleries.show', $gallery) }}"
                                               class="btn btn-sm btn-outline-info"
                                               title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.galleries.edit', $gallery) }}"
                                               class="btn btn-sm btn-outline-primary"
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button"
                                                    class="btn btn-sm btn-outline-danger"
                                                    onclick="deleteGallery({{ $gallery->id }}, '{{ addslashes($gallery->title) }}')"
                                                    title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted">
                            Showing {{ $galleries->firstItem() }} to {{ $galleries->lastItem() }} of {{ $galleries->total() }} results
                        </div>
                        {{ $galleries->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-images fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">No Gallery Images Found</h4>
                    <p class="text-muted mb-4">Start building your gallery by adding some images.</p>
                    <a href="{{ route('admin.galleries.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>
                        Add First Image
                    </a>
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
                <p>Are you sure you want to delete "<span id="galleryTitle"></span>"?</p>
                <p class="text-danger"><small><i class="fas fa-exclamation-triangle me-1"></i>This action cannot be undone and will also delete the image file.</small></p>
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

@endsection

@section('scripts')
<script>
// Auto-hide alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        let alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            let bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
});

// Select All functionality
document.getElementById('selectAll').addEventListener('change', function() {
    let checkboxes = document.querySelectorAll('.gallery-checkbox');
    let bulkActions = document.getElementById('bulkActions');

    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });

    // Show/hide bulk actions
    if (this.checked) {
        bulkActions.style.display = 'flex';
    } else {
        bulkActions.style.display = 'none';
    }
});

// Individual checkbox change
document.querySelectorAll('.gallery-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        let checkedBoxes = document.querySelectorAll('.gallery-checkbox:checked');
        let bulkActions = document.getElementById('bulkActions');
        let selectAll = document.getElementById('selectAll');

        // Show/hide bulk actions based on selection
        if (checkedBoxes.length > 0) {
            bulkActions.style.display = 'flex';
        } else {
            bulkActions.style.display = 'none';
        }

        // Update select all checkbox
        selectAll.checked = checkedBoxes.length === document.querySelectorAll('.gallery-checkbox').length;
    });
});

// Delete single gallery
function deleteGallery(galleryId, galleryTitle) {
    document.getElementById('galleryTitle').textContent = galleryTitle;
    document.getElementById('deleteForm').action = '{{ route("admin.galleries.index") }}/' + galleryId;

    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}

// Bulk actions
function bulkDelete() {
    const selectedIds = Array.from(document.querySelectorAll('.gallery-checkbox:checked')).map(cb => cb.value);
    if (selectedIds.length === 0) {
        alert('Please select gallery items to delete.');
        return;
    }

    if (confirm(`Are you sure you want to delete ${selectedIds.length} selected gallery items? This action cannot be undone.`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.galleries.bulk-delete") }}';

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken;
        form.appendChild(csrfInput);

        selectedIds.forEach(id => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'ids[]';
            input.value = id;
            form.appendChild(input);
        });

        document.body.appendChild(form);
        form.submit();
    }
}

function bulkToggleStatus(status) {
    const selectedIds = Array.from(document.querySelectorAll('.gallery-checkbox:checked')).map(cb => cb.value);
    if (selectedIds.length === 0) {
        alert('Please select gallery items to update.');
        return;
    }

    const action = status === 'activate' ? 'activate' : 'deactivate';
    if (confirm(`Are you sure you want to ${action} ${selectedIds.length} selected gallery items?`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.galleries.bulk-toggle-status") }}';

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken;
        form.appendChild(csrfInput);

        const statusInput = document.createElement('input');
        statusInput.type = 'hidden';
        statusInput.name = 'status';
        statusInput.value = status;
        form.appendChild(statusInput);

        selectedIds.forEach(id => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'ids[]';
            input.value = id;
            form.appendChild(input);
        });

        document.body.appendChild(form);
        form.submit();
    }
}

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + A = Select All
    if ((e.ctrlKey || e.metaKey) && e.key === 'a' && e.target.tagName !== 'INPUT') {
        e.preventDefault();
        document.getElementById('selectAll').click();
    }

    // Delete key = Delete selected
    if (e.key === 'Delete' && document.querySelectorAll('.gallery-checkbox:checked').length > 0) {
        e.preventDefault();
        bulkDelete();
    }
});
</script>
@endsection
