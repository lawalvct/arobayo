@extends('layouts.admin')

@section('title', 'Navigation Management - Egbe Arobayo')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="admin-page-title mb-2">
                        <i class="fas fa-bars me-3"></i>
                        Navigation Management
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">
                                    <i class="fas fa-home me-1"></i>Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item active">Navigation</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.navigations.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>
                        Add Navigation Item
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

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            Please fix the following errors:
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Navigation Stats -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card stats-card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-primary text-white me-3">
                            <i class="fas fa-bars"></i>
                        </div>
                        <div>
                            <h5 class="stats-number mb-0">{{ $allNavigations->count() }}</h5>
                            <p class="stats-label text-muted mb-0">Total Items</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card stats-card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-success text-white me-3">
                            <i class="fas fa-eye"></i>
                        </div>
                        <div>
                            <h5 class="stats-number mb-0">{{ $allNavigations->where('is_active', true)->count() }}</h5>
                            <p class="stats-label text-muted mb-0">Active Items</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card stats-card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-info text-white me-3">
                            <i class="fas fa-sitemap"></i>
                        </div>
                        <div>
                            <h5 class="stats-number mb-0">{{ $navigations->count() }}</h5>
                            <p class="stats-label text-muted mb-0">Main Items</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card stats-card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-warning text-white me-3">
                            <i class="fas fa-layer-group"></i>
                        </div>
                        <div>
                            <h5 class="stats-number mb-0">{{ $allNavigations->whereNotNull('parent_id')->count() }}</h5>
                            <p class="stats-label text-muted mb-0">Sub Items</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <!-- Navigation Structure -->
                <!-- Main Content -->
    <div class="card border-0 shadow-sm">
        <div class="card-header border-0 bg-white">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-sitemap me-2 text-primary"></i>
                        Navigation Structure
                    </h6>
                </div>
                <div class="col-auto">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-primary btn-sm" id="expandAll">
                            <i class="fas fa-expand me-1"></i>Expand All
                        </button>
                        <button type="button" class="btn btn-outline-primary btn-sm" id="collapseAll">
                            <i class="fas fa-compress me-1"></i>Collapse All
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            @if($navigations->isNotEmpty())
                <div class="table-responsive">
                    <div id="navigation-tree" class="navigation-tree p-3">
                        @foreach($navigations as $navigation)
                            @include('admin.navigations.partials.tree-item', ['navigation' => $navigation])
                        @endforeach
                    </div>
                </div>
            @else
                <div class="empty-state text-center py-5">
                    <div class="empty-state-icon mb-3">
                        <i class="fas fa-sitemap text-muted" style="font-size: 4rem; opacity: 0.3;"></i>
                    </div>
                    <h5 class="text-muted mb-2">No Navigation Items</h5>
                    <p class="text-muted mb-4">Create your first navigation item to get started with organizing your site structure.</p>
                    <a href="{{ route('admin.navigations.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Create First Navigation Item
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Bulk Actions -->
    <form id="bulkDeleteForm" action="{{ route('admin.navigations.bulk-delete') }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
        <input type="hidden" name="ids" id="bulkDeleteIds">
    </form>

    <form id="bulkStatusForm" action="{{ route('admin.navigations.bulk-toggle-status') }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="ids" id="bulkStatusIds">
        <input type="hidden" name="status" id="bulkStatusValue">
    </form>
        </div>

        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="admin-card mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-lightning-bolt me-2"></i>
                        Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.navigations.create') }}" class="btn btn-outline-primary">
                            <i class="fas fa-plus me-2"></i>
                            Add New Item
                        </a>
                        <button type="button" class="btn btn-outline-secondary" onclick="expandAll()">
                            <i class="fas fa-expand-arrows-alt me-2"></i>
                            Expand All
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="collapseAll()">
                            <i class="fas fa-compress-arrows-alt me-2"></i>
                            Collapse All
                        </button>
                        <a href="{{ route('home') }}" class="btn btn-outline-success" target="_blank">
                            <i class="fas fa-external-link-alt me-2"></i>
                            Preview Site
                        </a>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="admin-card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-bar me-2"></i>
                        Statistics
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="text-center">
                                <div class="display-6 fw-bold text-primary">{{ $allNavigations->count() }}</div>
                                <small class="text-muted">Total Items</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <div class="display-6 fw-bold text-success">{{ $allNavigations->where('is_active', true)->count() }}</div>
                                <small class="text-muted">Active Items</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <div class="display-6 fw-bold text-info">{{ $navigations->count() }}</div>
                                <small class="text-muted">Main Items</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <div class="display-6 fw-bold text-warning">{{ $allNavigations->whereNotNull('parent_id')->count() }}</div>
                                <small class="text-muted">Sub Items</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Action Forms -->
    <!-- Bulk Actions -->
    <form id="bulkDeleteForm" action="{{ route('admin.navigations.bulk-delete') }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
        <input type="hidden" name="ids" id="bulkDeleteIds">
    </form>

    <form id="bulkStatusForm" action="{{ route('admin.navigations.bulk-toggle-status') }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="ids" id="bulkStatusIds">
        <input type="hidden" name="status" id="bulkStatusValue">
    </form>
</div>

<style>
.stats-card {
    transition: transform 0.2s ease-in-out;
}

.stats-card:hover {
    transform: translateY(-2px);
}

.stats-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
}

.stats-number {
    font-size: 1.5rem;
    font-weight: 600;
    color: #2c3e50;
}

.stats-label {
    font-size: 0.875rem;
    font-weight: 500;
}

.empty-state {
    padding: 3rem 2rem;
}

.empty-state-icon {
    margin-bottom: 1.5rem;
}

.navigation-tree {
    margin: 0;
    padding: 0;
}

.card {
    border: none !important;
    box-shadow: 0 0.125rem 0.5rem rgba(0, 0, 0, 0.075) !important;
}

.card-header {
    background: white !important;
    border-bottom: 1px solid #e3e6f0 !important;
    padding: 1.25rem 1.5rem !important;
}

.card-title {
    font-size: 1rem;
    font-weight: 600;
    color: #2c3e50;
}

.btn-group .btn {
    font-size: 0.875rem;
    padding: 0.5rem 1rem;
}
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

/* Navigation Tree Styles */
.navigation-tree {
    margin: 0;
    padding: 0;
    list-style: none;
}

.tree-item {
    margin: 0;
    padding: 0;
    border: 1px solid #e3e6f0;
    border-radius: 0.5rem;
    background: #fff;
    margin-bottom: 0.5rem;
    transition: all 0.3s ease;
}

.tree-item:hover {
    box-shadow: 0 0.125rem 0.5rem rgba(0, 0, 0, 0.1);
    transform: translateY(-1px);
}

.tree-item.dragging {
    opacity: 0.5;
    transform: rotate(5deg);
}

.tree-item.drag-over {
    border-color: #4e73df;
    box-shadow: 0 0 0 2px rgba(78, 115, 223, 0.25);
}

.tree-content {
    display: flex;
    align-items: center;
    padding: 1rem;
    cursor: move;
}

.tree-level-1 .tree-content {
    padding-left: 2.5rem;
}

.tree-level-2 .tree-content {
    padding-left: 4rem;
}

.tree-drag-handle {
    color: #6c757d;
    margin-right: 1rem;
    cursor: grab;
    font-size: 1rem;
    padding: 0.25rem;
    border-radius: 0.25rem;
    transition: all 0.2s ease;
}

.tree-drag-handle:hover {
    color: #4e73df;
    background-color: #f8f9fc;
}

.tree-drag-handle:active {
    cursor: grabbing;
}

.tree-info {
    flex: 1;
    margin-left: 1rem;
}

.tree-label {
    font-weight: 600;
    color: #333;
    margin-bottom: 0.25rem;
}

.tree-url {
    font-size: 0.875rem;
    color: #6c757d;
    font-family: 'Courier New', monospace;
}

.tree-meta {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-left: auto;
}

.tree-actions {
    display: flex;
    gap: 0.5rem;
}

.tree-actions .btn {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
}

.tree-children {
    padding-left: 1.5rem;
    border-left: 2px solid #e3e6f0;
    margin-left: 1rem;
    margin-top: 0.5rem;
}

.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 1rem;
    font-size: 0.75rem;
    font-weight: 600;
}

.status-active {
    background: #d4edda;
    color: #155724;
}

.status-inactive {
    background: #f8d7da;
    color: #721c24;
}

.tree-checkbox {
    margin-right: 1rem;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .tree-content {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }

    .tree-meta {
        margin-left: 0;
        width: 100%;
        justify-content: space-between;
    }

    .tree-actions {
        flex-wrap: wrap;
    }
}
</style>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Check if Sortable is loaded
    if (typeof Sortable === 'undefined') {
        console.error('Sortable.js is not loaded!');
        return;
    }
    console.log('Sortable.js version:', Sortable.version || 'unknown');

    initializeSortable();
    initializeBulkActions();
});

function initializeSortable() {
    const treeContainer = document.getElementById('navigation-tree');
    if (!treeContainer) {
        console.log('Navigation tree container not found');
        return;
    }

    console.log('Initializing Sortable for navigation tree');

    // Only make direct children of navigation-tree sortable (top-level items)
    new Sortable(treeContainer, {
        animation: 150,
        handle: '.tree-drag-handle', // Only allow dragging by the drag handle
        ghostClass: 'dragging',
        chosenClass: 'drag-over',
        dragClass: 'sortable-drag',
        filter: '.tree-children', // Exclude nested children from direct sorting
        preventOnFilter: false,
        onStart: function(evt) {
            console.log('Drag started', evt.item);
            evt.item.classList.add('dragging');
        },
        onEnd: function(evt) {
            console.log('Drag ended', evt.item);
            evt.item.classList.remove('dragging');
            updateNavigationOrder();
        },
        onMove: function(evt) {
            console.log('Item moved', evt);
            // Prevent dropping into nested areas
            if (evt.related.classList.contains('tree-children')) {
                return false;
            }
        }
    });

    // Test if drag handles exist
    const dragHandles = document.querySelectorAll('.tree-drag-handle');
    console.log('Found drag handles:', dragHandles.length);

    // Also initialize nested children containers
    const nestedContainers = document.querySelectorAll('.tree-children');
    nestedContainers.forEach(container => {
        new Sortable(container, {
            group: 'nested',
            animation: 150,
            handle: '.tree-drag-handle',
            ghostClass: 'dragging',
            chosenClass: 'drag-over',
            onEnd: function(evt) {
                updateNavigationOrder();
            }
        });
    });
}

function updateNavigationOrder() {
    const items = [];
    const treeItems = document.querySelectorAll('.tree-item[data-id]');

    treeItems.forEach((item, index) => {
        items.push({
            id: item.dataset.id,
            parent_id: item.dataset.parentId || null,
            sort_order: index
        });
    });

    fetch('{{ route("admin.navigations.update-order") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content || '{{ csrf_token() }}'
        },
        body: JSON.stringify({ items: items })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('success', 'Navigation order updated successfully!');
        } else {
            showAlert('danger', 'Failed to update navigation order.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('danger', 'An error occurred while updating navigation order.');
    });
}

function initializeBulkActions() {
    const checkboxes = document.querySelectorAll('.navigation-checkbox');
    const selectAllCheckbox = document.getElementById('selectAll');
    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
    const bulkActivateBtn = document.getElementById('bulkActivateBtn');
    const bulkDeactivateBtn = document.getElementById('bulkDeactivateBtn');

    // Check all functionality
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateBulkActionButtons();
        });
    }

    // Individual checkbox change
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateBulkActionButtons();

            // Update select all checkbox
            if (selectAllCheckbox) {
                const checkedCount = document.querySelectorAll('.navigation-checkbox:checked').length;
                selectAllCheckbox.checked = checkedCount === checkboxes.length;
                selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < checkboxes.length;
            }
        });
    });

    // Bulk action buttons
    if (bulkDeleteBtn) {
        bulkDeleteBtn.addEventListener('click', function() {
            const selectedIds = getSelectedIds();
            if (selectedIds.length > 0) {
                if (confirm(`Are you sure you want to delete ${selectedIds.length} navigation item(s)?`)) {
                    document.getElementById('bulkDeleteIds').value = selectedIds.join(',');
                    document.getElementById('bulkDeleteForm').submit();
                }
            }
        });
    }

    if (bulkActivateBtn) {
        bulkActivateBtn.addEventListener('click', function() {
            const selectedIds = getSelectedIds();
            if (selectedIds.length > 0) {
                document.getElementById('bulkStatusIds').value = selectedIds.join(',');
                document.getElementById('bulkStatusValue').value = '1';
                document.getElementById('bulkStatusForm').submit();
            }
        });
    }

    if (bulkDeactivateBtn) {
        bulkDeactivateBtn.addEventListener('click', function() {
            const selectedIds = getSelectedIds();
            if (selectedIds.length > 0) {
                document.getElementById('bulkStatusIds').value = selectedIds.join(',');
                document.getElementById('bulkStatusValue').value = '0';
                document.getElementById('bulkStatusForm').submit();
            }
        });
    }
}

function updateBulkActionButtons() {
    const selectedCount = getSelectedIds().length;
    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
    const bulkActivateBtn = document.getElementById('bulkActivateBtn');
    const bulkDeactivateBtn = document.getElementById('bulkDeactivateBtn');

    if (bulkDeleteBtn) bulkDeleteBtn.disabled = selectedCount === 0;
    if (bulkActivateBtn) bulkActivateBtn.disabled = selectedCount === 0;
    if (bulkDeactivateBtn) bulkDeactivateBtn.disabled = selectedCount === 0;
}

function getSelectedIds() {
    const checkedBoxes = document.querySelectorAll('.navigation-checkbox:checked');
    return Array.from(checkedBoxes).map(checkbox => checkbox.value);
}

function confirmDelete(id, label) {
    if (confirm(`Are you sure you want to delete "${label}"?`)) {
        document.getElementById('deleteForm-' + id).submit();
    }
}

function expandAll() {
    document.querySelectorAll('.tree-children').forEach(children => {
        children.style.display = 'block';
    });
    document.querySelectorAll('.toggle-btn').forEach(btn => {
        btn.innerHTML = '<i class="fas fa-minus"></i>';
    });
}

function collapseAll() {
    document.querySelectorAll('.tree-children').forEach(children => {
        children.style.display = 'none';
    });
    document.querySelectorAll('.toggle-btn').forEach(btn => {
        btn.innerHTML = '<i class="fas fa-plus"></i>';
    });
}

// Add event listeners for the new expand/collapse buttons
document.addEventListener('DOMContentLoaded', function() {
    const expandAllBtn = document.getElementById('expandAll');
    const collapseAllBtn = document.getElementById('collapseAll');

    if (expandAllBtn) {
        expandAllBtn.addEventListener('click', expandAll);
    }

    if (collapseAllBtn) {
        collapseAllBtn.addEventListener('click', collapseAll);
    }
});

function showAlert(type, message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
    alertDiv.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    const container = document.querySelector('.container-fluid');
    const firstCard = container.querySelector('.admin-card');
    container.insertBefore(alertDiv, firstCard);

    // Auto-dismiss after 5 seconds
    setTimeout(() => {
        alertDiv.remove();
    }, 5000);
}
</script>
@endsection
