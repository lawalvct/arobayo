@extends('layouts.admin')

@section('title', 'Pages Management - Egbe Arobayo')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="admin-page-title">
            <i class="fas fa-file-alt me-3"></i>
            Pages Management
        </h2>
        <p class="admin-page-subtitle mb-0">
            Manage website pages and content sections
        </p>
    </div>
    <a href="{{ route('admin.pages.create') }}" class="btn admin-btn-primary">
        <i class="fas fa-plus me-2"></i>
        Add New Page
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="admin-card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">
            <i class="fas fa-list me-2"></i>
            All Pages
        </h5>
    </div>
    <div class="card-body p-0">
        @if($pages->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Page</th>
                            <th>Template</th>
                            <th>Status</th>
                            <th>Last Modified</th>
                            <th width="200">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pages as $page)
                            <tr>
                                <td>
                                    <div>
                                        <h6 class="mb-1">{{ $page->title }}</h6>
                                        <small class="text-muted">
                                            <i class="fas fa-link me-1"></i>
                                            /{{ $page->slug }}
                                            @if($page->slug === 'home')
                                                <span class="badge bg-warning text-dark ms-2">
                                                    <i class="fas fa-home me-1"></i>
                                                    Home Page
                                                </span>
                                            @endif
                                        </small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge {{ $page->template === 'home' ? 'bg-info' : 'bg-secondary' }}">
                                        {{ ucfirst($page->template) }}
                                    </span>
                                </td>
                                <td>
                                    @if($page->is_active)
                                        <span class="badge bg-success">
                                            <i class="fas fa-eye me-1"></i>
                                            Active
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            <i class="fas fa-eye-slash me-1"></i>
                                            Inactive
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ $page->updated_at->format('M d, Y') }}
                                        <br>
                                        {{ $page->updated_at->format('h:i A') }}
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.pages.show', $page) }}"
                                           class="btn btn-outline-info btn-sm"
                                           title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.pages.edit', $page) }}"
                                           class="btn btn-outline-primary btn-sm"
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if($page->slug === 'home')
                                            <a href="{{ route('admin.pages.edit', $page) }}"
                                               class="btn btn-outline-warning btn-sm"
                                               title="Edit Home Sections">
                                                <i class="fas fa-cogs"></i>
                                            </a>
                                        @endif
                                        <a href="{{ url($page->slug === 'home' ? '/' : '/' . $page->slug) }}"
                                           class="btn btn-outline-secondary btn-sm"
                                           title="Preview"
                                           target="_blank">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                        @if($page->slug !== 'home')
                                            <button type="button"
                                                    class="btn btn-outline-danger btn-sm"
                                                    title="Delete"
                                                    onclick="confirmDelete('{{ $page->id }}', '{{ $page->title }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No Pages Found</h5>
                <p class="text-muted mb-4">Get started by creating your first page</p>
                <a href="{{ route('admin.pages.create') }}" class="btn admin-btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    Create Your First Page
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                    Confirm Deletion
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the page <strong id="pageTitle"></strong>?</p>
                <div class="alert alert-warning">
                    <i class="fas fa-info-circle me-2"></i>
                    This action cannot be undone. The page will be moved to trash and can be restored later.
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>
                        Delete Page
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.admin-page-title {
    color: #2596be;
    font-weight: 700;
    font-size: 2rem;
    margin: 0;
}

.admin-page-subtitle {
    color: #6c757d;
    font-size: 1rem;
}

.table th {
    border-top: none;
    font-weight: 600;
    color: #495057;
    font-size: 0.9rem;
}

.table td {
    vertical-align: middle;
    border-top: 1px solid #f1f3f4;
}

.badge {
    font-size: 0.75rem;
}

.btn-group .btn {
    margin-right: 2px;
}

.btn-group .btn:last-child {
    margin-right: 0;
}
</style>
@endsection

@section('scripts')
<script>
function confirmDelete(pageId, pageTitle) {
    document.getElementById('pageTitle').textContent = pageTitle;
    document.getElementById('deleteForm').action = '{{ route("admin.pages.destroy", ":id") }}'.replace(':id', pageId);

    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}
</script>
@endsection
