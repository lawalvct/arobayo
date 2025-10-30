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
                        Site Navigation Menu
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
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="50">
                                    <input type="checkbox" class="form-check-input" id="selectAll">
                                </th>
                                <th width="50"><i class="fas fa-grip-vertical text-muted" title="Drag to reorder"></i></th>
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
                                <tr class="navigation-row" data-id="{{ $navigation->id }}" data-parent-id="{{ $navigation->parent_id }}">
                                    <td>
                                        <input type="checkbox" class="form-check-input navigation-checkbox" value="{{ $navigation->id }}">
                                    </td>
                                    <td class="drag-handle" style="cursor: grab;">
                                        <i class="fas fa-grip-vertical text-muted"></i>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($navigation->icon)
                                                <i class="{{ $navigation->icon }} me-2"></i>
                                            @endif
                                            <div>
                                                <div class="fw-bold">{{ $navigation->label }}</div>
                                                <small class="text-muted">ID: {{ $navigation->id }} | Sort: {{ $navigation->sort_order }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($navigation->page)
                                            <span class="badge bg-primary me-1">Page</span>
                                            <small>{{ $navigation->page->title }}</small><br>
                                            <small class="text-muted font-monospace">{{ $navigation->page->slug === 'home' ? '/' : '/' . $navigation->page->slug }}</small>
                                        @else
                                            <span class="badge bg-secondary me-1">URL</span>
                                            <small class="font-monospace">{{ $navigation->url ?? 'No URL' }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($navigation->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-warning">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $navigation->target === '_blank' ? 'info' : 'light' }}">
                                            {{ $navigation->target === '_blank' ? 'New Tab' : 'Same Tab' }}
                                            @if($navigation->target === '_blank')
                                                <i class="fas fa-external-link-alt ms-1"></i>
                                            @endif
                                        </span>
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
                                            @if($navigation->children->count() === 0)
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
                                            @else
                                                <button type="button"
                                                        class="btn btn-sm btn-outline-secondary"
                                                        title="Cannot delete - has sub-items"
                                                        disabled>
                                                    <i class="fas fa-lock"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>
                                        <tr class="navigation-row child-row" data-id="{{ $child->id }}" data-parent-id="{{ $child->parent_id }}">
                                            <td>
                                                <input type="checkbox" class="form-check-input navigation-checkbox" value="{{ $child->id }}">
                                            </td>
                                            <td class="drag-handle" style="cursor: grab;">
                                                <div class="ms-3">
                                                    <i class="fas fa-grip-vertical text-muted"></i>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="ms-3">
                                                        @if($child->icon)
                                                            <i class="{{ $child->icon }} me-2"></i>
                                                        @endif
                                                        <div>
                                                            <div class="fw-bold">{{ $child->label }}</div>
                                                            <small class="text-muted">ID: {{ $child->id }} | Sort: {{ $child->sort_order }} | Parent: {{ $navigation->label }}</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if($child->page)
                                                    <span class="badge bg-primary me-1">Page</span>
                                                    <small>{{ $child->page->title }}</small><br>
                                                    <small class="text-muted font-monospace">{{ $child->page->slug === 'home' ? '/' : '/' . $child->page->slug }}</small>
                                                @else
                                                    <span class="badge bg-secondary me-1">URL</span>
                                                    <small class="font-monospace">{{ $child->url ?? 'No URL' }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                @if($child->is_active)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-warning">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $child->target === '_blank' ? 'info' : 'light' }}">
                                                    {{ $child->target === '_blank' ? 'New Tab' : 'Same Tab' }}
                                                    @if($child->target === '_blank')
                                                        <i class="fas fa-external-link-alt ms-1"></i>
                                                    @endif
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    {{-- View Site --}}
                                                    @php
                                                        $childViewUrl = '#';
                                                        if ($child->page) {
                                                            $childViewUrl = $child->page->slug === 'home' ? route('home') : route('page.show', $child->page->slug);
                                                        } elseif ($child->url) {
                                                            $childViewUrl = $child->url;
                                                        }
                                                    @endphp

                                                    @if($childViewUrl !== '#')
                                                        <a href="{{ $childViewUrl }}"
                                                           class="btn btn-sm btn-outline-info"
                                                           title="View on Site"
                                                           target="{{ $child->target }}">
                                                            <i class="fas fa-external-link-alt"></i>
                                                        </a>
                                                    @endif

                                                    {{-- Edit --}}
                                                    <a href="{{ route('admin.navigations.edit', $child) }}"
                                                       class="btn btn-sm btn-outline-primary"
                                                       title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>

                                                    {{-- Toggle Status --}}
                                                    <form action="{{ route('admin.navigations.toggle-status', $child) }}"
                                                          method="POST" style="display: inline;">
                                                        @csrf
                                                        <button type="submit"
                                                                class="btn btn-sm {{ $child->is_active ? 'btn-outline-warning' : 'btn-outline-success' }}"
                                                                title="{{ $child->is_active ? 'Deactivate' : 'Activate' }}">
                                                            <i class="fas fa-{{ $child->is_active ? 'eye-slash' : 'eye' }}"></i>
                                                        </button>
                                                    </form>

                                                    {{-- Delete --}}
                                                    <form action="{{ route('admin.navigations.destroy', $child) }}"
                                                          method="POST"
                                                          style="display: inline;"
                                                          onsubmit="return confirm('Are you sure you want to delete \'{{ $child->label }}\'?');">
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
                                @endif
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
                                <th width="50"><i class="fas fa-grip-vertical text-muted"></i></th>
                                <th>Navigation Item</th>
                                <th>URL/Page</th>
                                <th>Status</th>
                                <th>Target</th>
                                <th width="200">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($allNavigations as $navigation)
                                <tr class="navigation-row" data-id="{{ $navigation->id }}" data-parent-id="{{ $navigation->parent_id }}">
                                    <td>
                                        <input type="checkbox" class="form-check-input navigation-checkbox" value="{{ $navigation->id }}">
                                    </td>
                                    <td class="drag-handle" style="cursor: grab;">
                                        <i class="fas fa-grip-vertical text-muted"></i>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($navigation->icon)
                                                <i class="{{ $navigation->icon }} me-2"></i>
                                            @endif
                                            <div>
                                                <div class="fw-bold">{{ $navigation->label }}</div>
                                                <small class="text-muted">ID: {{ $navigation->id }} | Sort: {{ $navigation->sort_order }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($navigation->page)
                                            <span class="badge bg-primary me-1">Page</span>
                                            <small>{{ $navigation->page->title }}</small><br>
                                            <small class="text-muted font-monospace">{{ $navigation->page->slug === 'home' ? '/' : '/' . $navigation->page->slug }}</small>
                                        @else
                                            <span class="badge bg-secondary me-1">URL</span>
                                            <small class="font-monospace">{{ $navigation->url ?? 'No URL' }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($navigation->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-warning">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $navigation->target === '_blank' ? 'info' : 'light' }}">
                                            {{ $navigation->target === '_blank' ? 'New Tab' : 'Same Tab' }}
                                            @if($navigation->target === '_blank')
                                                <i class="fas fa-external-link-alt ms-1"></i>
                                            @endif
                                        </span>
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
                                            @if($navigation->children->count() === 0)
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
                                            @else
                                                <button type="button"
                                                        class="btn btn-sm btn-outline-secondary"
                                                        title="Cannot delete - has sub-items"
                                                        disabled>
                                                    <i class="fas fa-lock"></i>
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
                        <a href="{{ route('admin.navigations.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>
                            Add New Menu Item
                        </a>

                        <hr class="my-3">

                        <button type="button" class="btn btn-outline-secondary" onclick="expandAll()">
                            <i class="fas fa-expand-arrows-alt me-2"></i>
                            Expand All
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="collapseAll()">
                            <i class="fas fa-compress-arrows-alt me-2"></i>
                            Collapse All
                        </button>

                        <hr class="my-3">

                        <button type="button" class="btn btn-outline-primary" onclick="selectAllItems()">
                            <i class="fas fa-check-square me-2"></i>
                            Select All
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="deselectAllItems()">
                            <i class="fas fa-square me-2"></i>
                            Deselect All
                        </button>

                        <hr class="my-3">

                        <div class="bulk-actions" id="bulkActions" style="display: none;">
                            <button type="button" class="btn btn-outline-success btn-sm" onclick="bulkActivate()">
                                <i class="fas fa-eye me-2"></i>
                                Activate Selected
                            </button>
                            <button type="button" class="btn btn-outline-warning btn-sm" onclick="bulkDeactivate()">
                                <i class="fas fa-eye-slash me-2"></i>
                                Deactivate Selected
                            </button>
                            <button type="button" class="btn btn-outline-danger btn-sm" onclick="bulkDelete()">
                                <i class="fas fa-trash me-2"></i>
                                Delete Selected
                            </button>
                        </div>

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

    // Initialize all functionality
    initializeSortable();
    initializeBulkActions();
    initializeExpandCollapseButtons();
});

function initializeSortable() {
    const tableBody = document.getElementById('navigation-tbody');
    if (!tableBody) {
        console.log('Navigation table body not found');
        return;
    }

    console.log('Initializing Sortable for navigation table');

    // Make table rows sortable
    new Sortable(tableBody, {
        animation: 150,
        handle: '.drag-handle', // Only allow dragging by the drag handle
        ghostClass: 'table-warning',
        chosenClass: 'table-info',
        dragClass: 'sortable-drag',
        onStart: function(evt) {
            console.log('Drag started', evt.item);
            evt.item.style.opacity = '0.5';
        },
        onEnd: function(evt) {
            console.log('Drag ended', evt.item);
            evt.item.style.opacity = '1';
            updateNavigationOrder();
        }
    });

    // Test if drag handles exist
    const dragHandles = document.querySelectorAll('.drag-handle');
    console.log('Found drag handles:', dragHandles.length);
}

function updateNavigationOrder() {
    const items = [];
    const rows = document.querySelectorAll('.navigation-row[data-id]');

    rows.forEach((row, index) => {
        items.push({
            id: row.dataset.id,
            parent_id: row.dataset.parentId || null,
            sort_order: index + 1
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

    // Select all functionality
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateBulkActionsVisibility();
        });
    }

    // Individual checkbox change
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateBulkActionsVisibility();

            // Update select all checkbox
            if (selectAllCheckbox) {
                const checkedCount = document.querySelectorAll('.navigation-checkbox:checked').length;
                selectAllCheckbox.checked = checkedCount === checkboxes.length;
                selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < checkboxes.length;
            }
        });
    });
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

function initializeExpandCollapseButtons() {
    const expandAllBtn = document.getElementById('expandAll');
    const collapseAllBtn = document.getElementById('collapseAll');

    if (expandAllBtn) {
        expandAllBtn.addEventListener('click', expandAll);
    }

    if (collapseAllBtn) {
        collapseAllBtn.addEventListener('click', collapseAll);
    }
}

function selectAllItems() {
    const checkboxes = document.querySelectorAll('.navigation-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = true;
    });
    updateBulkActionsVisibility();
}

function deselectAllItems() {
    const checkboxes = document.querySelectorAll('.navigation-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = false;
    });
    updateBulkActionsVisibility();
}

function updateBulkActionsVisibility() {
    const selectedCount = getSelectedIds().length;
    const bulkActions = document.getElementById('bulkActions');
    if (bulkActions) {
        bulkActions.style.display = selectedCount > 0 ? 'block' : 'none';
    }
}

function bulkActivate() {
    const selectedIds = getSelectedIds();
    if (selectedIds.length > 0) {
        if (confirm(`Are you sure you want to activate ${selectedIds.length} navigation item(s)?`)) {
            document.getElementById('bulkStatusIds').value = selectedIds.join(',');
            document.getElementById('bulkStatusValue').value = '1';
            document.getElementById('bulkStatusForm').submit();
        }
    }
}

function bulkDeactivate() {
    const selectedIds = getSelectedIds();
    if (selectedIds.length > 0) {
        if (confirm(`Are you sure you want to deactivate ${selectedIds.length} navigation item(s)?`)) {
            document.getElementById('bulkStatusIds').value = selectedIds.join(',');
            document.getElementById('bulkStatusValue').value = '0';
            document.getElementById('bulkStatusForm').submit();
        }
    }
}

function bulkDelete() {
    const selectedIds = getSelectedIds();
    if (selectedIds.length > 0) {
        if (confirm(`Are you sure you want to delete ${selectedIds.length} navigation item(s)? This action cannot be undone.`)) {
            document.getElementById('bulkDeleteIds').value = selectedIds.join(',');
            document.getElementById('bulkDeleteForm').submit();
        }
    }
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

    // Auto-dismiss after 5 seconds
    setTimeout(() => {
        alertDiv.remove();
    }, 5000);
}
</script>
@endsection
