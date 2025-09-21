@extends('layouts.admin')

@section('title', $executive->name . ' - Executive Details')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="admin-page-title mb-2">
                        <i class="fas fa-user me-3"></i>
                        Executive Details
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
                            <li class="breadcrumb-item active">{{ Str::limit($executive->name, 30) }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.executives.edit', $executive) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-1"></i>
                        Edit
                    </a>
                    <a href="{{ route('admin.executives.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>
                        Back to Executives
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Executive Profile -->
    <div class="row">
        <div class="col-lg-8">
            <!-- Profile Header Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            @if($executive->image)
                                <img src="{{ asset('storage/' . $executive->image) }}"
                                     alt="{{ $executive->name }}"
                                     class="rounded-circle"
                                     style="width: 120px; height: 120px; object-fit: cover;">
                            @else
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center"
                                     style="width: 120px; height: 120px;">
                                    <i class="fas fa-user fa-3x text-muted"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h2 class="mb-1">{{ $executive->name }}</h2>
                                    <h5 class="text-primary mb-2">{{ $executive->position }}</h5>
                                </div>
                                <div class="d-flex gap-2">
                                    @if($executive->is_active)
                                        <span class="badge bg-success fs-6">Active</span>
                                    @else
                                        <span class="badge bg-secondary fs-6">Inactive</span>
                                    @endif
                                    <span class="badge bg-info fs-6">Order: {{ $executive->sort_order }}</span>
                                </div>
                            </div>

                            <!-- Contact Information -->
                            <div class="row">
                                @if($executive->email)
                                <div class="col-md-6 mb-2">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-envelope text-muted me-2"></i>
                                        <a href="mailto:{{ $executive->email }}" class="text-decoration-none">
                                            {{ $executive->email }}
                                        </a>
                                    </div>
                                </div>
                                @endif

                                @if($executive->phone)
                                <div class="col-md-6 mb-2">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-phone text-muted me-2"></i>
                                        <a href="tel:{{ $executive->phone }}" class="text-decoration-none">
                                            {{ $executive->phone }}
                                        </a>
                                    </div>
                                </div>
                                @endif
                            </div>

                            <!-- Social Media Links -->
                            @if($executive->social_links && count($executive->social_links) > 0)
                            <div class="mt-3">
                                <div class="d-flex gap-2">
                                    @if(isset($executive->social_links['facebook']) && $executive->social_links['facebook'])
                                        <a href="{{ $executive->social_links['facebook'] }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                            <i class="fab fa-facebook-f"></i> Facebook
                                        </a>
                                    @endif
                                    @if(isset($executive->social_links['twitter']) && $executive->social_links['twitter'])
                                        <a href="{{ $executive->social_links['twitter'] }}" target="_blank" class="btn btn-outline-info btn-sm">
                                            <i class="fab fa-twitter"></i> Twitter
                                        </a>
                                    @endif
                                    @if(isset($executive->social_links['linkedin']) && $executive->social_links['linkedin'])
                                        <a href="{{ $executive->social_links['linkedin'] }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                            <i class="fab fa-linkedin"></i> LinkedIn
                                        </a>
                                    @endif
                                    @if(isset($executive->social_links['instagram']) && $executive->social_links['instagram'])
                                        <a href="{{ $executive->social_links['instagram'] }}" target="_blank" class="btn btn-outline-danger btn-sm">
                                            <i class="fab fa-instagram"></i> Instagram
                                        </a>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Biography Card -->
            @if($executive->bio)
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user-graduate me-2"></i>
                        Biography
                    </h5>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $executive->bio }}</p>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Executive Information -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Executive Information
                    </h6>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td><strong>Full Name:</strong></td>
                            <td>{{ $executive->name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Position:</strong></td>
                            <td><span class="badge bg-primary">{{ $executive->position }}</span></td>
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
                        <tr>
                            <td><strong>Email:</strong></td>
                            <td>
                                @if($executive->email)
                                    <a href="mailto:{{ $executive->email }}">{{ $executive->email }}</a>
                                @else
                                    <span class="text-muted">Not provided</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Phone:</strong></td>
                            <td>
                                @if($executive->phone)
                                    <a href="tel:{{ $executive->phone }}">{{ $executive->phone }}</a>
                                @else
                                    <span class="text-muted">Not provided</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Created:</strong></td>
                            <td>
                                {{ $executive->created_at->format('M j, Y') }}<br>
                                <small class="text-muted">{{ $executive->created_at->format('g:i A') }}</small>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Updated:</strong></td>
                            <td>
                                {{ $executive->updated_at->format('M j, Y') }}<br>
                                <small class="text-muted">{{ $executive->updated_at->format('g:i A') }}</small>
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
                        <a href="{{ route('admin.executives.edit', $executive) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit me-1"></i>
                            Edit Executive
                        </a>

                        @if($executive->is_active)
                            <form action="{{ route('admin.executives.bulk-toggle-status') }}" method="POST" style="display: inline;">
                                @csrf
                                <input type="hidden" name="ids[]" value="{{ $executive->id }}">
                                <input type="hidden" name="status" value="deactivate">
                                <button type="submit" class="btn btn-warning btn-sm w-100">
                                    <i class="fas fa-eye-slash me-1"></i>
                                    Deactivate
                                </button>
                            </form>
                        @else
                            <form action="{{ route('admin.executives.bulk-toggle-status') }}" method="POST" style="display: inline;">
                                @csrf
                                <input type="hidden" name="ids[]" value="{{ $executive->id }}">
                                <input type="hidden" name="status" value="activate">
                                <button type="submit" class="btn btn-success btn-sm w-100">
                                    <i class="fas fa-eye me-1"></i>
                                    Activate
                                </button>
                            </form>
                        @endif

                        @if($executive->email)
                        <a href="mailto:{{ $executive->email }}" class="btn btn-info btn-sm">
                            <i class="fas fa-envelope me-1"></i>
                            Send Email
                        </a>
                        @endif

                        <button type="button"
                                class="btn btn-danger btn-sm"
                                onclick="deleteExecutive()">
                            <i class="fas fa-trash me-1"></i>
                            Delete Executive
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
                        <a href="{{ route('admin.executives.create') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-plus me-1"></i>
                            Add New Executive
                        </a>
                        <a href="{{ route('admin.executives.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-list me-1"></i>
                            All Executives
                        </a>
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
// Delete executive function
function deleteExecutive() {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // E = Edit
    if (e.key === 'e' || e.key === 'E') {
        window.location.href = '{{ route("admin.executives.edit", $executive) }}';
    }

    // D = Delete
    if (e.key === 'd' || e.key === 'D') {
        deleteExecutive();
    }

    // Escape = Back to index
    if (e.key === 'Escape') {
        window.location.href = '{{ route("admin.executives.index") }}';
    }
});
</script>
@endsection
