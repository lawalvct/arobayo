@extends('layouts.admin')

@section('title', 'Events Management - Egbe Arobayo Admin')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="admin-page-title mb-2">
                        <i class="fas fa-calendar-alt me-3"></i>
                        Events Management
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">
                                    <i class="fas fa-home me-1"></i>Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item active">Events</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.events.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>
                        Create New Event
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

    <!-- Events Stats -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card stats-card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-primary text-white me-3">
                            <i class="fas fa-calendar"></i>
                        </div>
                        <div>
                            <h5 class="stats-number mb-0">{{ $events->total() }}</h5>
                            <p class="stats-label text-muted mb-0">Total Events</p>
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
                            <h5 class="stats-number mb-0">{{ $events->where('is_active', true)->count() }}</h5>
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
                        <div class="stats-icon bg-warning text-white me-3">
                            <i class="fas fa-star"></i>
                        </div>
                        <div>
                            <h5 class="stats-number mb-0">{{ $events->where('is_featured', true)->count() }}</h5>
                            <p class="stats-label text-muted mb-0">Featured</p>
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
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <h5 class="stats-number mb-0">{{ $events->where('event_date', '>=', now())->count() }}</h5>
                            <p class="stats-label text-muted mb-0">Upcoming</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Events Table -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-list me-2"></i>
                    All Events
                </h5>
                <div class="d-flex gap-2">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-filter me-1"></i>Filter
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('admin.events.index') }}">All Events</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.events.index') }}?status=active">Published Only</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.events.index') }}?status=draft">Drafts Only</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.events.index') }}?featured=1">Featured Only</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            @if($events->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" width="40">
                                    <input type="checkbox" class="form-check-input" id="selectAll">
                                </th>
                                <th scope="col">Event</th>
                                <th scope="col" width="120">Date</th>
                                <th scope="col" width="100">Location</th>
                                <th scope="col" width="80" class="text-center">Featured</th>
                                <th scope="col" width="80" class="text-center">Status</th>
                                <th scope="col" width="120" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($events as $event)
                            <tr class="event-row" data-event-id="{{ $event->id }}">
                                <td>
                                    <input type="checkbox" class="form-check-input event-checkbox" value="{{ $event->id }}">
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($event->image)
                                            <img src="{{ asset('storage/' . $event->image) }}"
                                                 alt="{{ $event->title }}"
                                                 class="rounded me-3"
                                                 style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center"
                                                 style="width: 50px; height: 50px;">
                                                <i class="fas fa-calendar text-muted"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <h6 class="mb-1 fw-semibold">{{ $event->title }}</h6>
                                            <small class="text-muted">{{ Str::limit($event->description, 60) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-medium text-primary">
                                        {{ $event->event_date ? $event->event_date->format('M j, Y') : 'TBD' }}
                                    </span>
                                    @if($event->event_date)
                                        <br><small class="text-muted">{{ $event->event_date->format('g:i A') }}</small>
                                    @endif
                                </td>
                                <td>
                                    <span class="text-muted">{{ $event->location ?: 'TBD' }}</span>
                                </td>
                                <td class="text-center">
                                    @if($event->is_featured)
                                        <span class="badge bg-warning">Featured</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($event->is_active)
                                        <span class="badge bg-success">Published</span>
                                    @else
                                        <span class="badge bg-secondary">Draft</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('admin.events.show', $event) }}"
                                           class="btn btn-outline-info"
                                           title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.events.edit', $event) }}"
                                           class="btn btn-outline-primary"
                                           title="Edit Event">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button"
                                                class="btn btn-outline-danger"
                                                title="Delete Event"
                                                onclick="confirmDelete({{ $event->id }}, '{{ $event->title }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Hidden delete form -->
                                    <form id="delete-form-{{ $event->id }}"
                                          action="{{ route('admin.events.destroy', $event) }}"
                                          method="POST"
                                          style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($events->hasPages())
                    <div class="card-footer bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted">
                                Showing {{ $events->firstItem() }} to {{ $events->lastItem() }} of {{ $events->total() }} events
                            </div>
                            {{ $events->links() }}
                        </div>
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-calendar fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted">No Events Found</h5>
                        <p class="text-muted mb-4">Start by creating your first event to engage your community.</p>
                    </div>
                    <a href="{{ route('admin.events.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>
                        Create Your First Event
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Bulk Actions (if events exist) -->
    @if($events->isNotEmpty())
        <div class="mt-3">
            <div class="d-flex gap-2" id="bulkActions" style="display: none !important;">
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="bulkDelete()">
                    <i class="fas fa-trash me-1"></i>Delete Selected
                </button>
                <button type="button" class="btn btn-sm btn-outline-success" onclick="bulkPublish()">
                    <i class="fas fa-eye me-1"></i>Publish Selected
                </button>
                <button type="button" class="btn btn-sm btn-outline-warning" onclick="bulkFeature()">
                    <i class="fas fa-star me-1"></i>Feature Selected
                </button>
            </div>
        </div>
    @endif
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle text-danger me-2"></i>
                    Confirm Delete
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this event?</p>
                <div class="alert alert-warning">
                    <strong id="eventTitle"></strong>
                </div>
                <p class="text-danger mb-0">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    This action cannot be undone.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Cancel
                </button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                    <i class="fas fa-trash me-2"></i>
                    Delete Event
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
/* Page Header */
.admin-page-title {
    color: var(--primary-color);
    font-weight: 700;
    font-size: 1.75rem;
}

.breadcrumb {
    background: transparent;
    padding: 0;
    margin: 0;
    font-size: 0.9rem;
}

.breadcrumb-item a {
    color: #6c757d;
    text-decoration: none;
}

.breadcrumb-item a:hover {
    color: var(--primary-color);
}

/* Statistics Cards */
.stats-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    border-radius: 12px;
}

.stats-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
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
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--primary-color);
}

.stats-label {
    font-size: 0.85rem;
    font-weight: 500;
}

/* Table Enhancements */
.table th {
    border-top: none;
    font-weight: 600;
    color: #495057;
    font-size: 0.9rem;
    background-color: #f8f9fa;
}

.event-row {
    transition: background-color 0.2s ease;
}

.event-row:hover {
    background-color: #f8f9fa;
}

.btn-group-sm > .btn, .btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
    border-radius: 6px;
}

/* Action Buttons */
.btn-outline-info:hover {
    background-color: #17a2b8;
    border-color: #17a2b8;
    color: white;
}

.btn-outline-primary:hover {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
    color: white;
}

.btn-outline-danger:hover {
    background-color: #dc3545;
    border-color: #dc3545;
    color: white;
}

/* Empty State */
.empty-state {
    padding: 4rem 2rem;
}

/* Modal Enhancements */
.modal-header {
    border-bottom: 1px solid #dee2e6;
    background-color: #f8f9fa;
}

.modal-footer {
    border-top: 1px solid #dee2e6;
    background-color: #f8f9fa;
}

/* Bulk Actions */
#bulkActions {
    padding: 10px;
    background: #f8f9fa;
    border-radius: 8px;
    border: 1px solid #dee2e6;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .admin-page-title {
        font-size: 1.5rem;
    }

    .stats-number {
        font-size: 1.5rem;
    }

    .btn-group-sm .btn {
        padding: 0.2rem 0.4rem;
    }

    .table-responsive {
        font-size: 0.875rem;
    }
}

/* Loading States */
.loading {
    opacity: 0.6;
    pointer-events: none;
}

/* Badge Styles */
.badge {
    font-size: 0.75rem;
    font-weight: 500;
}
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select All functionality
    const selectAllCheckbox = document.getElementById('selectAll');
    const eventCheckboxes = document.querySelectorAll('.event-checkbox');
    const bulkActions = document.getElementById('bulkActions');

    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            eventCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            toggleBulkActions();
        });
    }

    // Individual checkbox handling
    eventCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const allChecked = Array.from(eventCheckboxes).every(cb => cb.checked);
            const someChecked = Array.from(eventCheckboxes).some(cb => cb.checked);

            if (selectAllCheckbox) {
                selectAllCheckbox.checked = allChecked;
                selectAllCheckbox.indeterminate = someChecked && !allChecked;
            }

            toggleBulkActions();
        });
    });

    // Toggle bulk actions visibility
    function toggleBulkActions() {
        const selectedCount = Array.from(eventCheckboxes).filter(cb => cb.checked).length;
        if (bulkActions) {
            bulkActions.style.display = selectedCount > 0 ? 'flex' : 'none';
        }
    }
});

// Delete confirmation function
let eventIdToDelete = null;

function confirmDelete(eventId, eventTitle) {
    eventIdToDelete = eventId;
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    const eventTitleElement = document.getElementById('eventTitle');
    const confirmBtn = document.getElementById('confirmDeleteBtn');

    // Set the event title in the modal
    eventTitleElement.textContent = eventTitle;

    // Set up the confirm button click handler
    confirmBtn.onclick = function() {
        if (eventIdToDelete) {
            document.getElementById('delete-form-' + eventIdToDelete).submit();
        }
    };

    // Show the modal
    modal.show();
}

// Bulk actions
function bulkDelete() {
    const selectedIds = Array.from(document.querySelectorAll('.event-checkbox:checked')).map(cb => cb.value);
    if (selectedIds.length === 0) {
        alert('Please select events to delete.');
        return;
    }

    if (confirm(`Are you sure you want to delete ${selectedIds.length} selected events? This action cannot be undone.`)) {
        // Create and submit a form for bulk delete
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.events.bulk-delete") }}';

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

function bulkPublish() {
    const selectedIds = Array.from(document.querySelectorAll('.event-checkbox:checked')).map(cb => cb.value);
    if (selectedIds.length === 0) {
        alert('Please select events to publish.');
        return;
    }

    // Implementation for bulk publish
    console.log('Bulk publish:', selectedIds);
}

function bulkFeature() {
    const selectedIds = Array.from(document.querySelectorAll('.event-checkbox:checked')).map(cb => cb.value);
    if (selectedIds.length === 0) {
        alert('Please select events to feature.');
        return;
    }

    // Implementation for bulk feature
    console.log('Bulk feature:', selectedIds);
}

// Success/Error message auto-hide
setTimeout(function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        if (alert.classList.contains('alert-success') || alert.classList.contains('alert-info')) {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }
    });
}, 5000);

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl+N for new event
    if (e.ctrlKey && e.key === 'n') {
        e.preventDefault();
        window.location.href = '{{ route("admin.events.create") }}';
    }

    // Escape to close modals
    if (e.key === 'Escape') {
        const modals = document.querySelectorAll('.modal.show');
        modals.forEach(modal => {
            bootstrap.Modal.getInstance(modal)?.hide();
        });
    }
});
</script>
@endsection
