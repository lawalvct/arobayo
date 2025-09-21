@extends('layouts.app')

@section('title', 'Register - Egbe Arobayo')

@section('content')
    <!-- Include success modal component -->
    <x-success-modal />

    <div class="container" style="margin-top: 100px;">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-primary-custom text-white text-center py-4">
                        <h2 class="fw-bold mb-0">Join Egbe Arobayo</h2>
                        <p class="mb-0">Become part of our cultural community</p>
                    </div>

                    <div class="card-body p-5">
                        <!-- Download Forms Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="bg-light rounded p-4 border">
                                    <h5 class="text-primary fw-bold mb-3">
                                        <i class="fas fa-download me-2"></i>
                                        Download Required Forms
                                    </h5>
                                    <p class="text-muted mb-3">Please download and complete the following forms before registration:</p>

                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <a href="{{ asset('forms/EGBE AROBAYO BLANK MEMBERSHIP FORM.pdf') }}"
                                               class="btn btn-outline-primary w-100 d-flex align-items-center justify-content-center py-3"
                                               target="_blank">
                                                <div class="text-center">
                                                    <i class="fas fa-file-pdf fa-2x mb-2"></i>
                                                    <div class="fw-semibold">Membership Form</div>
                                                    <small class="text-muted">Required</small>
                                                </div>
                                            </a>
                                        </div>

                                        <div class="col-md-4">
                                            <a href="{{ asset('forms/AKILE NEXT OF KIN FORM.pdf') }}"
                                               class="btn btn-outline-success w-100 d-flex align-items-center justify-content-center py-3"
                                               target="_blank">
                                                <div class="text-center">
                                                    <i class="fas fa-file-pdf fa-2x mb-2"></i>
                                                    <div class="fw-semibold">Next of Kin Form</div>
                                                    <small class="text-muted">Required</small>
                                                </div>
                                            </a>
                                        </div>

                                        <div class="col-md-4">
                                            <a href="{{ asset('forms/arobayo_cooop.pdf') }}"
                                               class="btn btn-outline-info w-100 d-flex align-items-center justify-content-center py-3"
                                               target="_blank">
                                                <div class="text-center">
                                                    <i class="fas fa-file-pdf fa-2x mb-2"></i>
                                                    <div class="fw-semibold">COOP Form</div>
                                                    <small class="text-muted">Optional</small>
                                                </div>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="alert alert-info mt-3 mb-0">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <strong>Note:</strong> After completing the forms, please return them along with your registration.
                                        You can submit them during our meetings or contact us for submission details.
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Success message will be shown in modal --}}

                        {{-- Temporary fallback for debugging --}}
                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert" id="temp-success-alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            <div class="mt-2">
                                {{-- <small class="text-muted d-block">
                                    (If modal doesn't appear, click the button below)
                                </small> --}}
                                {{-- <button type="button" class="btn btn-sm btn-primary mt-2" id="manualModalButton">
                                    <i class="fas fa-external-link-alt me-1"></i>
                                    Open Success Message
                                </button> --}}
                            </div>
                        </div>
                        @endif

                        <form action="{{ route('register.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="first_name" class="form-label fw-semibold">First Name *</label>
                                    <input type="text"
                                           class="form-control @error('first_name') is-invalid @enderror"
                                           id="first_name"
                                           name="first_name"
                                           value="{{ old('first_name') }}"
                                           required>
                                    @error('first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="last_name" class="form-label fw-semibold">Last Name *</label>
                                    <input type="text"
                                           class="form-control @error('last_name') is-invalid @enderror"
                                           id="last_name"
                                           name="last_name"
                                           value="{{ old('last_name') }}"
                                           required>
                                    @error('last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-semibold">Email Address *</label>
                                    <input type="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           id="email"
                                           name="email"
                                           value="{{ old('email') }}"
                                           required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="phone" class="form-label fw-semibold">Phone Number *</label>
                                    <input type="tel"
                                           class="form-control @error('phone') is-invalid @enderror"
                                           id="phone"
                                           name="phone"
                                           value="{{ old('phone') }}"
                                           required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="address" class="form-label fw-semibold">Address *</label>
                                    <textarea class="form-control @error('address') is-invalid @enderror"
                                              id="address"
                                              name="address"
                                              rows="3"
                                              required>{{ old('address') }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="occupation" class="form-label fw-semibold">Occupation</label>
                                    <input type="text"
                                           class="form-control @error('occupation') is-invalid @enderror"
                                           id="occupation"
                                           name="occupation"
                                           value="{{ old('occupation') }}">
                                    @error('occupation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="membership_type" class="form-label fw-semibold">Membership Type *</label>
                                    <select class="form-select @error('membership_type') is-invalid @enderror"
                                            id="membership_type"
                                            name="membership_type"
                                            required>
                                        <option value="">Select membership type</option>
                                        <option value="regular" {{ old('membership_type') == 'regular' ? 'selected' : '' }}>
                                            Regular Member
                                        </option>
                                        <option value="associate" {{ old('membership_type') == 'associate' ? 'selected' : '' }}>
                                            Associate Member
                                        </option>
                                        <option value="honorary" {{ old('membership_type') == 'honorary' ? 'selected' : '' }}>
                                            Honorary Member
                                        </option>
                                    </select>
                                    @error('membership_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Document Upload Section -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="card border-info">
                                        <div class="card-header bg-info text-white">
                                            <h6 class="card-title mb-0">
                                                <i class="fas fa-cloud-upload-alt me-2"></i>
                                                Upload Completed Forms (Optional)
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <p class="text-muted small mb-3">
                                                You can upload your completed forms here, or submit them during our meetings.
                                                Accepted formats: PDF only. Maximum file size: 5MB per file.
                                            </p>

                                            <div class="row g-3">
                                                <!-- Membership Form Upload -->
                                                <div class="col-md-4">
                                                    <label for="membership_form" class="form-label fw-semibold text-primary">
                                                        <i class="fas fa-file-pdf me-1"></i>
                                                        Membership Form
                                                        <span class="badge bg-warning text-dark ms-1">Required</span>
                                                    </label>
                                                    <input type="file"
                                                           class="form-control @error('membership_form') is-invalid @enderror"
                                                           id="membership_form"
                                                           name="membership_form"
                                                           accept=".pdf"
                                                           onchange="validateFileUpload(this, 'membership_form_info')">
                                                    <div id="membership_form_info" class="form-text"></div>
                                                    @error('membership_form')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <!-- Next of Kin Form Upload -->
                                                <div class="col-md-4">
                                                    <label for="next_of_kin_form" class="form-label fw-semibold text-success">
                                                        <i class="fas fa-file-pdf me-1"></i>
                                                        Next of Kin Form
                                                        <span class="badge bg-warning text-dark ms-1">Required</span>
                                                    </label>
                                                    <input type="file"
                                                           class="form-control @error('next_of_kin_form') is-invalid @enderror"
                                                           id="next_of_kin_form"
                                                           name="next_of_kin_form"
                                                           accept=".pdf"
                                                           onchange="validateFileUpload(this, 'next_of_kin_form_info')">
                                                    <div id="next_of_kin_form_info" class="form-text"></div>
                                                    @error('next_of_kin_form')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <!-- COOP Form Upload -->
                                                <div class="col-md-4">
                                                    <label for="coop_form" class="form-label fw-semibold text-info">
                                                        <i class="fas fa-file-pdf me-1"></i>
                                                        COOP Form
                                                        <span class="badge bg-secondary ms-1">Optional</span>
                                                    </label>
                                                    <input type="file"
                                                           class="form-control @error('coop_form') is-invalid @enderror"
                                                           id="coop_form"
                                                           name="coop_form"
                                                           accept=".pdf"
                                                           onchange="validateFileUpload(this, 'coop_form_info')">
                                                    <div id="coop_form_info" class="form-text"></div>
                                                    @error('coop_form')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="alert alert-warning mt-3 mb-0">
                                                <i class="fas fa-info-circle me-2"></i>
                                                <strong>Important:</strong> If you don't upload the forms now, you can submit them during our meetings.
                                                However, uploading them here will speed up the approval process.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 p-4 bg-light-cream rounded" style="border-left: 4px solid var(--accent-yellow);">
                                <h6 class="fw-bold mb-3 text-primary-custom">Online Membership Benefits</h6>
                                <ul class="list-unstyled mb-0">
                                    <li><i class="fas fa-check icon-primary me-2"></i> Access to all cultural events</li>
                                    <li><i class="fas fa-check icon-primary me-2"></i> Networking opportunities</li>
                                    <li><i class="fas fa-check icon-primary me-2"></i> Cultural education programs</li>
                                    <li><i class="fas fa-check icon-primary me-2"></i> Community support network</li>
                                    <li><i class="fas fa-check icon-primary me-2"></i> Monthly newsletter</li>
                                </ul>
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-accent-yellow btn-lg">
                                    <i class="fas fa-user-plus me-2"></i>
                                    Submit Registration
                                </button>
                            </div>
                        </form>

                        <div class="text-center mt-4">
                            <p class="text-muted small">
                                * Required fields. Your information will be reviewed by our membership committee.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>

@endsection

@section('styles')

<style>
.bg-light-info {
    background-color: #e3f2fd !important;
}

.modal-content {
    border-radius: 15px;
    overflow: hidden;
}

.modal-header {
    border-radius: 15px 15px 0 0;
}

#successModal .modal-dialog {
    max-width: 500px;
}

#successModal .fas.fa-user-check {
    animation: bounceIn 0.8s ease-out;
}

@keyframes bounceIn {
    0% {
        transform: scale(0.3);
        opacity: 0;
    }
    50% {
        transform: scale(1.1);
        opacity: 0.8;
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

/* File upload drag and drop styling */
.col-md-4.border-primary {
    border: 2px dashed #0d6efd !important;
    background-color: rgba(13, 110, 253, 0.05);
}
</style>
@endsection

@section('scripts')
<script>
// File upload validation
function validateFileUpload(input, infoElementId) {
    const file = input.files[0];
    const infoElement = document.getElementById(infoElementId);
    const maxSize = 5 * 1024 * 1024; // 5MB

    if (file) {
        // Check file type
        if (file.type !== 'application/pdf') {
            infoElement.innerHTML = '<small class="text-danger"><i class="fas fa-exclamation-triangle me-1"></i>Only PDF files are allowed</small>';
            input.value = '';
            return false;
        }

        // Check file size
        if (file.size > maxSize) {
            infoElement.innerHTML = '<small class="text-danger"><i class="fas fa-exclamation-triangle me-1"></i>File size must be less than 5MB</small>';
            input.value = '';
            return false;
        }

        // Show success message with file info
        const fileSize = (file.size / 1024 / 1024).toFixed(2);
        infoElement.innerHTML = `<small class="text-success"><i class="fas fa-check-circle me-1"></i>${file.name} (${fileSize} MB)</small>`;
        return true;
    } else {
        infoElement.innerHTML = '';
    }
}

// Form submission validation
document.querySelector('form').addEventListener('submit', function(e) {
    const membershipForm = document.getElementById('membership_form');
    const nextOfKinForm = document.getElementById('next_of_kin_form');

    // Check if at least one required form is uploaded if any form is uploaded
    const hasAnyUpload = membershipForm.files.length > 0 ||
                        nextOfKinForm.files.length > 0 ||
                        document.getElementById('coop_form').files.length > 0;

    if (hasAnyUpload) {
        // If user started uploading, encourage them to upload required forms
        if (membershipForm.files.length === 0 || nextOfKinForm.files.length === 0) {
            const missingForms = [];
            if (membershipForm.files.length === 0) missingForms.push('Membership Form');
            if (nextOfKinForm.files.length === 0) missingForms.push('Next of Kin Form');

            const proceed = confirm(
                `You haven't uploaded the following required forms: ${missingForms.join(', ')}.\n\n` +
                'You can still submit your registration and provide these forms during meetings.\n\n' +
                'Do you want to continue?'
            );

            if (!proceed) {
                e.preventDefault();
                return false;
            }
        }
    }

    return true;
});

// Drag and drop functionality for file inputs
function setupDragAndDrop(inputId) {
    const input = document.getElementById(inputId);
    const container = input.closest('.col-md-4');

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        container.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        container.addEventListener(eventName, () => container.classList.add('border-primary'), false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        container.addEventListener(eventName, () => container.classList.remove('border-primary'), false);
    });

    container.addEventListener('drop', function(e) {
        const dt = e.dataTransfer;
        const files = dt.files;

        if (files.length > 0) {
            input.files = files;
            validateFileUpload(input, inputId + '_info');
        }
    }, false);
}

// Initialize drag and drop for all file inputs
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM Content Loaded');

    // Setup file drag and drop
    setupDragAndDrop('membership_form');
    setupDragAndDrop('next_of_kin_form');
    setupDragAndDrop('coop_form');

    // Manual modal button handler
    const manualModalButton = document.getElementById('manualModalButton');
    if (manualModalButton) {
        manualModalButton.addEventListener('click', function() {
            console.log('Manual modal button clicked');
            const modalElement = document.getElementById('successModal');
            if (modalElement && typeof bootstrap !== 'undefined') {
                const successModal = new bootstrap.Modal(modalElement);
                successModal.show();
                // Hide the temp alert when manual modal works
                document.getElementById('temp-success-alert').style.display = 'none';
            } else {
                alert('Modal element or Bootstrap not found!');
            }
        });
    }
});

// Remove the old window.load event handler that was also trying to show the modal
</script>
