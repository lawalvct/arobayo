@extends('layouts.admin')

@section('title', 'Executives Management - Egbe Arobayo Admin')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="admin-page-title mb-2">
                        <i class="fas fa-users me-3"></i>
                        Executives Management
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">
                                    <i class="fas fa-home me-1"></i>Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item active">Executives</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.executives.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>
                        Add New Executive
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

    <!-- Executives Stats -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card stats-card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-primary text-white rounded-circle p-3 me-3">
                            <i class="fas fa-users fa-lg"></i>
                        </div>
                        <div>
                            <div class="stats-number h3 mb-0">{{ $stats['total'] }}</div>
                            <div class="stats-label text-muted">Total Executives</div>
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
                            <div class="stats-label text-muted">Active</div>
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
                            <i class="fas fa-eye-slash fa-lg"></i>
                        </div>
                        <div>
                            <div class="stats-number h3 mb-0">{{ $stats['inactive'] }}</div>
                            <div class="stats-label text-muted">Inactive</div>
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

    <!-- Executives Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list me-2"></i>
                        Executive Team Members
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
            @if($executives->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="50">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="selectAll">
                                    </div>
                                </th>
                                <th width="80">Photo</th>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Contact</th>
                                <th width="100">Status</th>
                                <th width="80">Order</th>
                                <th width="120">Created</th>
                                <th width="150">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($executives as $executive)
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input executive-checkbox" type="checkbox" value="{{ $executive->id }}">
                                        </div>
                                    </td>
                                    <td>
                                        @if($executive->image)
                                            <img src="{{ asset('storage/' . $executive->image) }}"
                                                 alt="{{ $executive->name }}"
                                                 class="img-thumbnail rounded-circle"
                                                 style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center"
                                                 style="width: 50px; height: 50px;">
                                                <i class="fas fa-user text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $executive->name }}</strong>
                                            @if($executive->bio)
                                                <br>
                                                <small class="text-muted">{{ Str::limit($executive->bio, 60) }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $executive->position }}</span>
                                    </td>
                                    <td>
                                        @if($executive->email || $executive->phone)
                                            @if($executive->email)
                                                <div class="mb-1">
                                                    <i class="fas fa-envelope text-muted me-1"></i>
                                                    <small>{{ $executive->email }}</small>
                                                </div>
                                            @endif
                                            @if($executive->phone)
                                                <div>
                                                    <i class="fas fa-phone text-muted me-1"></i>
                                                    <small>{{ $executive->phone }}</small>
                                                </div>
                                            @endif
                                        @else
                                            <span class="text-muted">No contact info</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($executive->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $executive->sort_order }}</span>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $executive->created_at->format('M j, Y') }}
                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.executives.show', $executive) }}"
                                               class="btn btn-sm btn-outline-info"
                                               title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.executives.edit', $executive) }}"
                                               class="btn btn-sm btn-outline-primary"
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button"
                                                    class="btn btn-sm btn-outline-danger"
                                                    onclick="deleteExecutive({{ $executive->id }}, '{{ addslashes($executive->name) }}')"
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
                            Showing {{ $executives->firstItem() }} to {{ $executives->lastItem() }} of {{ $executives->total() }} results
                        </div>
                        {{ $executives->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-users fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">No Executives Found</h4>
                    <p class="text-muted mb-4">Start building your executive team by adding team members.</p>
                    <a href="{{ route('admin.executives.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>
                        Add First Executive
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
                <p>Are you sure you want to delete "<span id="executiveName"></span>"?</p>
                <p class="text-danger"><small><i class="fas fa-exclamation-triangle me-1"></i>This action cannot be undone and will also delete the profile image.</small></p>
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
    let checkboxes = document.querySelectorAll('.executive-checkbox');
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
document.querySelectorAll('.executive-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        let checkedBoxes = document.querySelectorAll('.executive-checkbox:checked');
        let bulkActions = document.getElementById('bulkActions');
        let selectAll = document.getElementById('selectAll');

        // Show/hide bulk actions based on selection
        if (checkedBoxes.length > 0) {
            bulkActions.style.display = 'flex';
        } else {
            bulkActions.style.display = 'none';
        }

        // Update select all checkbox
        selectAll.checked = checkedBoxes.length === document.querySelectorAll('.executive-checkbox').length;
    });
});

// Delete single executive
function deleteExecutive(executiveId, executiveName) {
    document.getElementById('executiveName').textContent = executiveName;
    document.getElementById('deleteForm').action = '{{ route("admin.executives.index") }}/' + executiveId;

    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}

// Bulk actions
function bulkDelete() {
    const selectedIds = Array.from(document.querySelectorAll('.executive-checkbox:checked')).map(cb => cb.value);
    if (selectedIds.length === 0) {
        alert('Please select executives to delete.');
        return;
    }

    if (confirm(`Are you sure you want to delete ${selectedIds.length} selected executives? This action cannot be undone.`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.executives.bulk-delete") }}';

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
    const selectedIds = Array.from(document.querySelectorAll('.executive-checkbox:checked')).map(cb => cb.value);
    if (selectedIds.length === 0) {
        alert('Please select executives to update.');
        return;
    }

    const action = status === 'activate' ? 'activate' : 'deactivate';
    if (confirm(`Are you sure you want to ${action} ${selectedIds.length} selected executives?`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.executives.bulk-toggle-status") }}';

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
    if (e.key === 'Delete' && document.querySelectorAll('.executive-checkbox:checked').length > 0) {
        e.preventDefault();
        bulkDelete();
    }
});
</script>
@endsection
