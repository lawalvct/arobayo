@extends('layouts.app')

@section('title', 'Events - Egbe Arobayo')

@section('content')
    <!-- Page Header -->
    <div class="hero-section" style="height: 50vh; padding: 150px 0 80px;">
        <div class="container text-center">
            <h1 class="display-4 fw-bold">Our Events</h1>
            <p class="lead">Discover upcoming cultural events and programs</p>
        </div>
    </div>

    <!-- Events Grid -->
    <section class="section-padding">
        <div class="container">
            @if($events->isNotEmpty())
                <div class="row g-4">
                    @foreach($events as $event)
                    <div class="col-lg-4 col-md-6">
                        <div class="card border-0 shadow-sm card-hover h-100">
                            @if($event->image)
                                <img src="{{ asset('storage/' . $event->image) }}"
                                     alt="{{ $event->title }}"
                                     class="card-img-top"
                                     style="height: 250px; object-fit: cover;">
                            @else
                                <div class="bg-secondary-custom d-flex align-items-center justify-content-center" style="height: 250px;">
                                    <i class="fas fa-calendar fa-4x text-white"></i>
                                </div>
                            @endif

                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge bg-primary-custom">
                                        {{ $event->event_date->format('M d, Y') }}
                                    </span>
                                    @if($event->is_featured)
                                        <span class="badge bg-warning">Featured</span>
                                    @endif
                                </div>

                                <h5 class="card-title fw-bold">
                                    <a href="{{ route('events.show', $event->slug) }}"
                                       class="text-decoration-none text-dark">
                                        {{ $event->title }}
                                    </a>
                                </h5>

                                <p class="card-text text-muted flex-grow-1">
                                    {{ Str::limit($event->description, 120) }}
                                </p>

                                @if($event->location)
                                    <p class="small text-primary-custom mb-3">
                                        <i class="fas fa-map-marker-alt me-1"></i>
                                        {{ $event->location }}
                                    </p>
                                @endif

                                <div class="mt-auto">
                                    <a href="{{ route('events.show', $event->slug) }}"
                                       class="btn btn-primary-custom">
                                        Learn More
                                        <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-5">
                    {{ $events->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-calendar fa-4x text-muted mb-3"></i>
                    <h3 class="text-muted">No Events Found</h3>
                    <p class="text-muted">Check back soon for upcoming events and programs.</p>
                </div>
            @endif
        </div>
    </section>
@endsection
