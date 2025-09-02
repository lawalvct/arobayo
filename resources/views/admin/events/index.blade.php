@extends('layouts.app')

@section('title', 'Admin - Events')

@section('content')
<div class="container-fluid" style="margin-top: 80px;">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-2 d-none d-md-block bg-light sidebar" style="height: calc(100vh - 80px); position: fixed; top: 80px;">
            <div class="sidebar-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('admin.events.index') }}">
                            <i class="fas fa-calendar me-2"></i>
                            Events
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main content -->
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4" style="margin-left: 16.666667%;">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Events</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="{{ route('admin.events.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus me-1"></i>
                        Add New Event
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

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Date</th>
                                    <th>Location</th>
                                    <th>Status</th>
                                    <th>Featured</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($events as $event)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($event->image)
                                                <img src="{{ asset('storage/' . $event->image) }}"
                                                     alt="{{ $event->title }}"
                                                     class="rounded me-2"
                                                     style="width: 40px; height: 40px; object-fit: cover;">
                                            @endif
                                            <div>
                                                <h6 class="mb-0">{{ Str::limit($event->title, 40) }}</h6>
                                                <small class="text-muted">{{ Str::limit($event->description, 50) }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-nowrap">{{ $event->event_date->format('M d, Y') }}</span>
                                        <br>
                                        <small class="text-muted">{{ $event->event_date->format('g:i A') }}</small>
                                    </td>
                                    <td>{{ $event->location ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $event->is_active ? 'success' : 'secondary' }}">
                                            {{ $event->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($event->is_featured)
                                            <span class="badge bg-warning">Featured</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('admin.events.show', $event) }}"
                                               class="btn btn-outline-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.events.edit', $event) }}"
                                               class="btn btn-outline-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button"
                                                    class="btn btn-outline-danger"
                                                    onclick="confirmDelete({{ $event->id }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>

                                        <form id="delete-form-{{ $event->id }}"
                                              action="{{ route('admin.events.destroy', $event) }}"
                                              method="POST"
                                              style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <i class="fas fa-calendar fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">No events found</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $events->links() }}
            </div>
        </main>
    </div>
</div>

<script>
function confirmDelete(eventId) {
    if (confirm('Are you sure you want to delete this event?')) {
        document.getElementById('delete-form-' + eventId).submit();
    }
}
</script>
@endsection
