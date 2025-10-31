@extends('layouts.admin')

@section('title', 'Site Settings')

@section('content')
<div class="page-header mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2 class="admin-page-title">
                <i class="fas fa-cogs me-3"></i>
                Site Settings
            </h2>
            <p class="admin-page-subtitle mb-0">
                Configure your website settings and preferences
            </p>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<form id="settingsForm" action="{{ route('admin.settings.update') }}" method="POST">
    @csrf

    <div class="row">
        <div class="col-lg-8">
            <!-- General Settings -->
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        General Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Site Name</label>
                        <input type="text" name="settings[site_name]" class="form-control"
                               value="{{ $settings->get('site_name')->value ?? 'Egbe Arobayo' }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Site Tagline</label>
                        <input type="text" name="settings[site_tagline]" class="form-control"
                               value="{{ $settings->get('site_tagline')->value ?? '' }}">
                        <small class="text-muted">A short description of your website</small>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-address-book me-2"></i>
                        Contact Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Contact Email</label>
                        <input type="email" name="settings[contact_email]" class="form-control"
                               value="{{ $settings->get('contact_email')->value ?? '' }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Contact Phone</label>
                        <input type="text" name="settings[contact_phone]" class="form-control"
                               value="{{ $settings->get('contact_phone')->value ?? '' }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Address</label>
                        <textarea name="settings[address]" class="form-control" rows="3">{{ $settings->get('address')->value ?? '' }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Social Media -->
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-share-alt me-2"></i>
                        Social Media Links
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            <i class="fab fa-facebook text-primary me-2"></i>Facebook URL
                        </label>
                        <input type="url" name="settings[facebook_url]" class="form-control"
                               value="{{ $settings->get('facebook_url')->value ?? '' }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            <i class="fab fa-twitter text-info me-2"></i>Twitter URL
                        </label>
                        <input type="url" name="settings[twitter_url]" class="form-control"
                               value="{{ $settings->get('twitter_url')->value ?? '' }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            <i class="fab fa-instagram text-danger me-2"></i>Instagram URL
                        </label>
                        <input type="url" name="settings[instagram_url]" class="form-control"
                               value="{{ $settings->get('instagram_url')->value ?? '' }}">
                    </div>
                </div>
            </div>

            <!-- Footer Settings -->
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-align-left me-2"></i>
                        Footer Settings
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Footer Text</label>
                        <textarea name="settings[footer_text]" class="form-control" rows="3">{{ $settings->get('footer_text')->value ?? '' }}</textarea>
                        <small class="text-muted">Text displayed in the website footer</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Save Card -->
            <div class="admin-card mb-4 sticky-top" style="top: 90px;">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-save me-2"></i>
                        Save Changes
                    </h5>
                </div>
                <div class="card-body">
                    <button type="submit" class="btn btn-primary w-100 btn-lg">
                        <i class="fas fa-save me-2"></i>Save Settings
                    </button>
                    <small class="text-muted d-block mt-2 text-center">
                        <i class="fas fa-keyboard me-1"></i>Ctrl+S to save
                    </small>
                </div>
            </div>

            <!-- Help Card -->
            <div class="admin-card">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Quick Tips
                    </h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Changes take effect immediately
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Leave fields empty to hide them
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Use full URLs for social media
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</form>
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
    border: none;
}

.admin-card .card-header {
    background: linear-gradient(135deg, #2596be 0%, #4b95c4 100%);
    color: white;
    padding: 18px 25px;
    border: none;
}

.admin-card .card-body {
    padding: 25px;
}

.form-label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 8px;
}

.form-control {
    padding: 10px 15px;
    border-radius: 8px;
    border: 1px solid #dee2e6;
}

.form-control:focus {
    border-color: #2596be;
    box-shadow: 0 0 0 0.2rem rgba(37, 150, 190, 0.15);
}

.btn-lg {
    padding: 12px 20px;
    font-size: 1.1rem;
    border-radius: 8px;
}
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 's') {
            e.preventDefault();
            document.getElementById('settingsForm').submit();
        }
    });
</script>
@endsection
