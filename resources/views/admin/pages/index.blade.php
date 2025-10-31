@extends('layouts.admin')

@section('title', 'Pages Management - Egbe Arobayo')

@section('content')
<div class="page-header mb-4">
    <div class="d-flex justify-content-between align-items-center">
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
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="fas fa-list me-2"></i>
            All Pages ({{ $pages->count() }})
        </h5>
        <div class="search-box">
            <input type="text" id="searchPages" class="form-control form-control-sm" placeholder="Search pages...">
        </div>
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
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('admin.pages.edit', $page) }}"
                                           class="btn btn-sm btn-primary"
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ url($page->slug === 'home' ? '/' : '/' . $page->slug) }}"
                                           class="btn btn-sm btn-secondary"
                                           title="Preview"
                                           target="_blank">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                        @if($page->slug !== 'home')
                                            <button type="button"
                                                    class="btn btn-sm btn-danger"
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
.page-header {
    background: white;
    border-radius: 15px;
    padding: 25px 30px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}

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

.admin-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    overflow: hidden;
}

.admin-card .card-header {
    background: linear-gradient(135deg, #2596be 0%, #4b95c4 100%);
    color: white;
    padding: 20px 25px;
    border: none;
}

.search-box input {
    width: 250px;
    border-radius: 8px;
}

.table th {
    border-top: none;
    font-weight: 600;
    color: #495057;
    font-size: 0.9rem;
    background: #f8f9fa;
}

.table td {
    vertical-align: middle;
    border-top: 1px solid #f1f3f4;
}

.table tbody tr:hover {
    background: #f8f9fa;
}

.badge {
    font-size: 0.75rem;
    padding: 5px 10px;
}

.d-flex.gap-1 {
    gap: 0.25rem;
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

// Search functionality
document.getElementById('searchPages').addEventListener('keyup', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});
</script>
@endsection
