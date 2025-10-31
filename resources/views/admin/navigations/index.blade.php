@extends('layouts.admin')

@section('title', 'Site Navigation - Egbe Arobayo')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="admin-page-title mb-2">
                        <i class="fas fa-sitemap me-3"></i>
                        Site Navigation
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">
                                    <i class="fas fa-home me-1"></i>Admin Panel
                                </a>
                            </li>
                            <li class="breadcrumb-item active">Site Navigation</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.navigations.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>
                        Create Navigation Item
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
                            <p class="stats-label text-muted mb-0">Menu Items</p>
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
                            <p class="stats-label text-muted mb-0">Published</p>
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
                            <p class="stats-label text-muted mb-0">Top Level</p>
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
                            <p class="stats-label text-muted mb-0">Sub Menus</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="card border-0 shadow-sm">
        <div class="card-header border-0 bg-white">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-sitemap me-2 text-primary"></i>
                        Site Navigation Menu
                    </h6>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            @if($navigations->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="50">
                                    <input type="checkbox" class="form-check-input" id="selectAll">
                                </th>
                                <th width="50" title="Drag to reorder">
                                    <i class="fas fa-grip-vertical text-muted"></i>
                                </th>
                                <th>Menu Label</th>
                                <th>Status</th>
                                <th width="200">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="navigation-tbody">
                            @foreach($navigations as $navigation)
                                <tr class="navigation-row" data-id="{{ $navigation->id }}" data-sort-order="{{ $navigation->sort_order }}">
                                    <td>
                                        <input type="checkbox" class="form-check-input navigation-checkbox" value="{{ $navigation->id }}">
                                    </td>
                                    <td class="drag-handle" style="cursor: grab;" title="Drag to reorder">
                                        <i class="fas fa-grip-vertical text-muted"></i>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($navigation->icon)
                                                <i class="{{ $navigation->icon }} me-2 text-primary"></i>
                                            @endif
                                            <div>
                                                <div class="fw-bold">{{ $navigation->label }}</div>
                                                <small class="text-muted">Sort Order: {{ $navigation->sort_order }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($navigation->is_active)
                                            <span class="badge bg-success">
                                                <i class="fas fa-check me-1"></i>Active
                                            </span>
                                        @else
                                            <span class="badge bg-warning">
                                                <i class="fas fa-pause me-1"></i>Inactive
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            {{-- View Site --}}
                                            @php
                                                $viewUrl = '#';
                                                if ($navigation->page) {
                                                    $viewUrl = $navigation->page->slug === 'home' ? route('home') : route('page.show', $navigation->page->slug);
                                                } elseif ($navigation->url) {
                                                    $viewUrl = $navigation->url;
                                                }
                                            @endphp

                                            @if($viewUrl !== '#')
                                                <a href="{{ $viewUrl }}"
                                                   class="btn btn-sm btn-outline-info"
                                                   title="View on Site"
                                                   target="{{ $navigation->target }}">
                                                    <i class="fas fa-external-link-alt"></i>
                                                </a>
                                            @endif

                                            {{-- Edit --}}
                                            <a href="{{ route('admin.navigations.edit', $navigation) }}"
                                               class="btn btn-sm btn-outline-primary"
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            {{-- Toggle Status --}}
                                            <form action="{{ route('admin.navigations.toggle-status', $navigation) }}"
                                                  method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit"
                                                        class="btn btn-sm {{ $navigation->is_active ? 'btn-outline-warning' : 'btn-outline-success' }}"
                                                        title="{{ $navigation->is_active ? 'Deactivate' : 'Activate' }}">
                                                    <i class="fas fa-{{ $navigation->is_active ? 'eye-slash' : 'eye' }}"></i>
                                                </button>
                                            </form>

                                            {{-- Delete --}}
                                            <form action="{{ route('admin.navigations.destroy', $navigation) }}"
                                                  method="POST"
                                                  style="display: inline;"
                                                  onsubmit="return confirm('Are you sure you want to delete \'{{ $navigation->label }}\'?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-sm btn-outline-danger"
                                                        title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @elseif($allNavigations->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="50">
                                    <input type="checkbox" class="form-check-input" id="selectAll">
                                </th>
                                <th width="50" title="Drag to reorder">
                                    <i class="fas fa-grip-vertical text-muted"></i>
                                </th>
                                <th>Menu Label</th>
                                <th>Status</th>
                                <th width="200">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="navigation-tbody">
                            @foreach($allNavigations as $navigation)
                                <tr class="navigation-row" data-id="{{ $navigation->id }}" data-sort-order="{{ $navigation->sort_order }}">
                                    <td>
                                        <input type="checkbox" class="form-check-input navigation-checkbox" value="{{ $navigation->id }}">
                                    </td>
                                    <td class="drag-handle" style="cursor: grab;" title="Drag to reorder">
                                        <i class="fas fa-grip-vertical text-muted"></i>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($navigation->icon)
                                                <i class="{{ $navigation->icon }} me-2 text-primary"></i>
                                            @endif
                                            <div>
                                                <div class="fw-bold">{{ $navigation->label }}</div>
                                                <small class="text-muted">Sort Order: {{ $navigation->sort_order }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($navigation->is_active)
                                            <span class="badge bg-success">
                                                <i class="fas fa-check me-1"></i>Active
                                            </span>
                                        @else
                                            <span class="badge bg-warning">
                                                <i class="fas fa-pause me-1"></i>Inactive
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            {{-- View Site --}}
                                            @php
                                                $viewUrl = '#';
                                                if ($navigation->page) {
                                                    $viewUrl = $navigation->page->slug === 'home' ? route('home') : route('page.show', $navigation->page->slug);
                                                } elseif ($navigation->url) {
                                                    $viewUrl = $navigation->url;
                                                }
                                            @endphp

                                            @if($viewUrl !== '#')
                                                <a href="{{ $viewUrl }}"
                                                   class="btn btn-sm btn-outline-info"
                                                   title="View on Site"
                                                   target="{{ $navigation->target }}">
                                                    <i class="fas fa-external-link-alt"></i>
                                                </a>
                                            @endif

                                            {{-- Edit --}}
                                            <a href="{{ route('admin.navigations.edit', $navigation) }}"
                                               class="btn btn-sm btn-outline-primary"
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            {{-- Toggle Status --}}
                                            <form action="{{ route('admin.navigations.toggle-status', $navigation) }}"
                                                  method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit"
                                                        class="btn btn-sm {{ $navigation->is_active ? 'btn-outline-warning' : 'btn-outline-success' }}"
                                                        title="{{ $navigation->is_active ? 'Deactivate' : 'Activate' }}">
                                                    <i class="fas fa-{{ $navigation->is_active ? 'eye-slash' : 'eye' }}"></i>
                                                </button>
                                            </form>

                                            {{-- Delete --}}
                                            <form action="{{ route('admin.navigations.destroy', $navigation) }}"
                                                  method="POST"
                                                  style="display: inline;"
                                                  onsubmit="return confirm('Are you sure you want to delete \'{{ $navigation->label }}\'?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-sm btn-outline-danger"
                                                        title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state text-center py-5">
                    <div class="empty-state-icon mb-3">
                        <i class="fas fa-sitemap text-muted" style="font-size: 4rem; opacity: 0.3;"></i>
                    </div>
                    <h5 class="text-muted mb-2">No Menu Items Found</h5>
                    <p class="text-muted mb-4">Start building your site navigation by creating your first menu item.</p>
                    <a href="{{ route('admin.navigations.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Create First Menu Item
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Bulk Actions Forms -->
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
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize sortable functionality
    const tableBody = document.getElementById('navigation-tbody');
    if (tableBody) {
        new Sortable(tableBody, {
            animation: 150,
            handle: '.drag-handle',
            ghostClass: 'table-warning',
            chosenClass: 'table-info',
            onEnd: function(evt) {
                updateNavigationOrder();
            }
        });
    }

    // Initialize bulk actions
    initializeBulkActions();
});

function updateNavigationOrder() {
    const items = [];
    const rows = document.querySelectorAll('.navigation-row[data-id]');

    rows.forEach((row, index) => {
        items.push({
            id: row.dataset.id,
            sort_order: index + 1
        });
    });

    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    const token = csrfToken ? csrfToken.content : '{{ csrf_token() }}';

    fetch('{{ route("admin.navigations.update-order") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({ items: items })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('success', 'Navigation order updated successfully!');
            // Update sort order display
            rows.forEach((row, index) => {
                const sortOrderText = row.querySelector('small.text-muted');
                if (sortOrderText) {
                    sortOrderText.textContent = `Sort Order: ${index + 1}`;
                }
            });
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

    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    }

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            if (selectAllCheckbox) {
                const checkedCount = document.querySelectorAll('.navigation-checkbox:checked').length;
                selectAllCheckbox.checked = checkedCount === checkboxes.length;
                selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < checkboxes.length;
            }
        });
    });
}

function showAlert(type, message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
    alertDiv.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    const container = document.querySelector('.container-fluid');
    const firstCard = container.querySelector('.card');
    container.insertBefore(alertDiv, firstCard);

    setTimeout(() => {
        alertDiv.remove();
    }, 5000);
}
</script>
@endsection
