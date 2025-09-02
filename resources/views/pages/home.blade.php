@extends('layouts.app')

@section('title', 'Home - Egbe Arobayo')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-4">
                        {{ $siteSettings['hero_title'] ?? 'Welcome to Egbe Arobayo' }}
                    </h1>
                    <p class="lead mb-4">
                        {{ $siteSettings['hero_subtitle'] ?? 'Preserving Yoruba culture, traditions, and values for future generations. Join us in celebrating our rich heritage.' }}
                    </p>
                    <a href="{{ route('register') }}" class="btn btn-accent-yellow btn-lg me-3">Join Our Community</a>
                    <a href="{{ route('events.index') }}" class="btn btn-outline-light btn-lg">View Events</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Vision, Mission, Objectives Section -->
    <section class="section-padding bg-light-cream">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <h2 class="display-5 fw-bold text-primary-custom">Our Purpose</h2>
                    <p class="lead">Building a stronger community through cultural preservation and unity</p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="card h-100 card-hover border-0 shadow-sm vision-mission-card">
                        <div class="card-body text-center p-5">
                            <div class="mb-4">
                                <i class="fas fa-eye fa-3x icon-primary"></i>
                            </div>
                            <h4 class="fw-bold mb-3 text-primary-custom">Our Vision</h4>
                            <p>{{ $siteSettings['vision'] ?? 'To be the leading platform for preserving and promoting Yoruba culture, fostering unity among our people worldwide.' }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card h-100 card-hover border-0 shadow-sm vision-mission-card">
                        <div class="card-body text-center p-5">
                            <div class="mb-4">
                                <i class="fas fa-bullseye fa-3x icon-accent"></i>
                            </div>
                            <h4 class="fw-bold mb-3 text-primary-custom">Our Mission</h4>
                            <p>{{ $siteSettings['mission'] ?? 'To preserve, promote, and celebrate Yoruba traditions while creating opportunities for cultural education and community development.' }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card h-100 card-hover border-0 shadow-sm vision-mission-card">
                        <div class="card-body text-center p-5">
                            <div class="mb-4">
                                <i class="fas fa-flag fa-3x icon-red"></i>
                            </div>
                            <h4 class="fw-bold mb-3 text-primary-custom">Our Objectives</h4>
                            <p>{{ $siteSettings['objectives'] ?? 'Cultural preservation, education, community building, youth engagement, and promoting Yoruba values in modern society.' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>    <!-- History Section -->
    <section class="section-padding">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <img src="{{ $siteSettings['history_image'] ?? '/images/history-default.jpg' }}"
                         alt="Our History"
                         class="img-fluid rounded shadow">
                </div>
                <div class="col-lg-6">
                    <h2 class="display-5 fw-bold text-primary-custom mb-4">Our Rich History</h2>
                    <p class="lead mb-4">
                        {{ $siteSettings['history_text'] ?? 'Egbe Arobayo has been at the forefront of preserving Yoruba culture for decades. Our organization was founded with the vision of maintaining our ancestral traditions while adapting to modern times.' }}
                    </p>
                    <p>
                        {{ $siteSettings['history_extended'] ?? 'Through various cultural programs, educational initiatives, and community events, we have successfully bridged the gap between generations, ensuring that our rich heritage continues to thrive.' }}
                    </p>
                    <a href="#" class="btn btn-primary-custom">Learn More About Us</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Executives Section -->
    @if($executives->isNotEmpty())
    <section class="section-padding bg-light">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <h2 class="display-5 fw-bold text-primary-custom">Meet Our Leadership</h2>
                    <p class="lead">Dedicated leaders working to preserve our cultural heritage</p>
                </div>
            </div>

            <div class="row g-4">
                @foreach($executives as $executive)
                <div class="col-lg-3 col-md-6">
                    <div class="card border-0 shadow-sm card-hover executive-card">
                        <div class="card-body text-center p-4">
                            @if($executive->image)
                                <img src="{{ asset('storage/' . $executive->image) }}"
                                     alt="{{ $executive->name }}"
                                     class="rounded-circle mb-3"
                                     style="width: 120px; height: 120px; object-fit: cover;">
                            @else
                                <div class="bg-secondary-custom rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 120px; height: 120px;">
                                    <i class="fas fa-user fa-3x text-white"></i>
                                </div>
                            @endif
                            <h5 class="fw-bold">{{ $executive->name }}</h5>
                            <p class="text-primary-custom fw-semibold">{{ $executive->position }}</p>
                            @if($executive->bio)
                                <p class="small text-muted">{{ Str::limit($executive->bio, 100) }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Call to Action -->
    <section class="section-padding bg-primary-custom text-white">
        <div class="container text-center">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h2 class="display-5 fw-bold mb-4">Join Our Community Today</h2>
                    <p class="lead mb-5">
                        Become part of a vibrant community dedicated to preserving and celebrating Yoruba culture.
                        Together, we can ensure our traditions continue for future generations.
                    </p>
                    <div class="d-grid d-md-flex justify-content-md-center gap-3">
                        <a href="{{ route('register') }}" class="btn btn-accent-yellow btn-lg px-5">
                            <i class="fas fa-user-plus me-2"></i>
                            Register Now
                        </a>
                        <a href="{{ route('events.index') }}" class="btn btn-outline-light btn-lg px-5">
                            <i class="fas fa-calendar me-2"></i>
                            View Events
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest Events Section -->
    @if($featuredEvents->isNotEmpty())
    <section class="section-padding">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <h2 class="display-5 fw-bold text-primary-custom">Upcoming Events</h2>
                    <p class="lead">Don't miss out on our exciting cultural events and programs</p>
                </div>
            </div>

            <div class="row g-4">
                @foreach($featuredEvents as $event)
                <div class="col-lg-3 col-md-6">
                    <div class="card border-0 shadow-sm card-hover event-card">
                        @if($event->image)
                            <img src="{{ asset('storage/' . $event->image) }}"
                                 alt="{{ $event->title }}"
                                 class="card-img-top"
                                 style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body">
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
                            <p class="card-text text-muted">{{ Str::limit($event->description, 100) }}</p>
                            @if($event->location)
                                <p class="small text-primary-custom">
                                    <i class="fas fa-map-marker-alt me-1"></i>
                                    {{ $event->location }}
                                </p>
                            @endif
                        </div>
                        <div class="card-footer bg-transparent border-0">
                            <a href="{{ route('events.show', $event->slug) }}"
                               class="btn btn-primary-custom btn-sm">
                                Learn More
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="text-center mt-5">
                <a href="{{ route('events.index') }}" class="btn btn-outline-primary">
                    View All Events
                    <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>
    @endif
@endsection
