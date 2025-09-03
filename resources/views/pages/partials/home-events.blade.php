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
