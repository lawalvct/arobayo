@extends('layouts.admin')

@section('title', 'Site Settings')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Site Settings</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label class="form-label fw-bold">Site Name</label>
                    <input type="text" name="settings[site_name]" class="form-control" 
                           value="{{ $settings->get('site_name')->value ?? 'Egbe Arobayo' }}">
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Site Tagline</label>
                    <input type="text" name="settings[site_tagline]" class="form-control" 
                           value="{{ $settings->get('site_tagline')->value ?? '' }}">
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Contact Email</label>
                    <input type="email" name="settings[contact_email]" class="form-control" 
                           value="{{ $settings->get('contact_email')->value ?? '' }}">
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Contact Phone</label>
                    <input type="text" name="settings[contact_phone]" class="form-control" 
                           value="{{ $settings->get('contact_phone')->value ?? '' }}">
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Address</label>
                    <textarea name="settings[address]" class="form-control" rows="3">{{ $settings->get('address')->value ?? '' }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Facebook URL</label>
                    <input type="url" name="settings[facebook_url]" class="form-control" 
                           value="{{ $settings->get('facebook_url')->value ?? '' }}">
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Twitter URL</label>
                    <input type="url" name="settings[twitter_url]" class="form-control" 
                           value="{{ $settings->get('twitter_url')->value ?? '' }}">
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Instagram URL</label>
                    <input type="url" name="settings[instagram_url]" class="form-control" 
                           value="{{ $settings->get('instagram_url')->value ?? '' }}">
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Footer Text</label>
                    <textarea name="settings[footer_text]" class="form-control" rows="2">{{ $settings->get('footer_text')->value ?? '' }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Save Settings
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
