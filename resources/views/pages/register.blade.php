@extends('layouts.app')

@section('title', 'Register - Egbe Arobayo')

@section('content')
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

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('register.store') }}" method="POST">
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

                            <div class="mt-4 p-4 bg-light-cream rounded" style="border-left: 4px solid var(--accent-yellow);">
                                <h6 class="fw-bold mb-3 text-primary-custom">Membership Benefits</h6>
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
@endsection
