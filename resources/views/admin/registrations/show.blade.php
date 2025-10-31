@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <a href="{{ route('admin.registrations.index') }}" class="btn btn-outline-secondary btn-sm mb-2">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
        <h2 class="mb-0">Registration Details</h2>
    </div>
    <form method="POST" action="{{ route('admin.registrations.destroy', $registration->id) }}" onsubmit="return confirm('Delete this registration?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">
            <i class="fas fa-trash me-1"></i> Delete
        </button>
    </form>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <div class="col-lg-8">
        <div class="card admin-card mb-4">
            <div class="card-body" style="padding: 25px;">
                <h5 class="mb-4">Personal Information</h5>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="text-muted small">First Name</label>
                        <p class="mb-0 fw-bold">{{ $registration->first_name }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">Last Name</label>
                        <p class="mb-0 fw-bold">{{ $registration->last_name }}</p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="text-muted small">Email</label>
                        <p class="mb-0">{{ $registration->email }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">Phone</label>
                        <p class="mb-0">{{ $registration->phone }}</p>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="text-muted small">Address</label>
                    <p class="mb-0">{{ $registration->address }}</p>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="text-muted small">Occupation</label>
                        <p class="mb-0">{{ $registration->occupation ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">Membership Type</label>
                        <p class="mb-0"><span class="badge bg-secondary">{{ ucfirst($registration->membership_type) }}</span></p>
                    </div>
                </div>
                <div class="mb-0">
                    <label class="text-muted small">Registration Date</label>
                    <p class="mb-0">{{ $registration->created_at->format('F d, Y h:i A') }}</p>
                </div>
            </div>
        </div>

        @if($registration->documents->count() > 0)
        <div class="card admin-card">
            <div class="card-body" style="padding: 25px;">
                <h5 class="mb-4">Submitted Documents</h5>
                <div class="list-group">
                    @foreach($registration->documents as $document)
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-file-pdf text-danger me-2"></i>
                            <strong>{{ $document->document_type_label }}</strong>
                            <br>
                            <small class="text-muted">{{ $document->original_filename }} ({{ $document->file_size_human }})</small>
                        </div>
                        <a href="{{ route('admin.registrations.documents.download', $document->id) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-download"></i> Download
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="col-lg-4">
        <div class="card admin-card">
            <div class="card-body" style="padding: 25px;">
                <h5 class="mb-4">Update Status</h5>
                <form method="POST" action="{{ route('admin.registrations.update-status', $registration->id) }}" id="statusForm">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="pending" {{ $registration->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ $registration->status == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ $registration->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="4" placeholder="Add notes...">{{ $registration->notes }}</textarea>
                    </div>
                    <button type="submit" class="btn admin-btn-primary w-100 btn-lg">
                        <i class="fas fa-save me-1"></i> Update Status
                    </button>
                    <div class="text-center mt-2">
                        <small class="text-muted">Press <kbd>Ctrl</kbd> + <kbd>S</kbd> to save</small>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('keydown', function(e) {
    if ((e.ctrlKey || e.metaKey) && e.key === 's') {
        e.preventDefault();
        document.getElementById('statusForm').submit();
    }
});
</script>
@endsection
