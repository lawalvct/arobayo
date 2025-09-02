@extends('layouts.app')

@section('title', 'Gallery - Egbe Arobayo')

@section('content')
    <!-- Page Header -->
    <div class="bg-primary-custom text-white" style="padding: 150px 0 80px;">
        <div class="container text-center">
            <h1 class="display-4 fw-bold">Photo Gallery</h1>
            <p class="lead">Capturing moments from our cultural events and activities</p>
        </div>
    </div>

    <!-- Gallery Filter -->
    @if($categories->isNotEmpty())
    <section class="py-4 bg-light">
        <div class="container">
            <div class="text-center">
                <a href="{{ route('gallery.index') }}"
                   class="btn {{ !$currentCategory ? 'btn-primary-custom' : 'btn-outline-secondary' }} me-2 mb-2">
                    All
                </a>
                @foreach($categories as $category)
                    <a href="{{ route('gallery.index', ['category' => $category]) }}"
                       class="btn {{ $currentCategory == $category ? 'btn-primary-custom' : 'btn-outline-secondary' }} me-2 mb-2">
                        {{ ucfirst($category) }}
                    </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Gallery Grid -->
    <section class="section-padding">
        <div class="container">
            @if($galleries->isNotEmpty())
                <div class="row g-4">
                    @foreach($galleries as $gallery)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="card border-0 shadow-sm card-hover">
                            <img src="{{ asset('storage/' . $gallery->image) }}"
                                 alt="{{ $gallery->title }}"
                                 class="card-img-top"
                                 style="height: 200px; object-fit: cover;"
                                 data-bs-toggle="modal"
                                 data-bs-target="#imageModal{{ $gallery->id }}">

                            @if($gallery->title || $gallery->category)
                            <div class="card-body p-3">
                                @if($gallery->title)
                                    <h6 class="card-title mb-1">{{ $gallery->title }}</h6>
                                @endif
                                @if($gallery->category)
                                    <small class="text-primary-custom">{{ ucfirst($gallery->category) }}</small>
                                @endif
                            </div>
                            @endif
                        </div>

                        <!-- Modal for enlarged image -->
                        <div class="modal fade" id="imageModal{{ $gallery->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">{{ $gallery->title }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body p-0">
                                        <img src="{{ asset('storage/' . $gallery->image) }}"
                                             alt="{{ $gallery->title }}"
                                             class="img-fluid w-100">
                                    </div>
                                    @if($gallery->description)
                                    <div class="modal-footer">
                                        <p class="mb-0">{{ $gallery->description }}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-5">
                    {{ $galleries->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-images fa-4x text-muted mb-3"></i>
                    <h3 class="text-muted">No Images Found</h3>
                    <p class="text-muted">Check back soon for photos from our events and activities.</p>
                </div>
            @endif
        </div>
    </section>
@endsection
