@extends('layouts.app')

@section('title', $event->title . ' - Egbe Arobayo')

@section('meta_description', Str::limit($event->description, 160))

@section('content')
    <!-- Event Hero Section -->
    <div class="hero-section event-hero" style="min-height: 60vh; padding: 150px 0 80px;">
        @if($event->image)
            <div class="hero-bg" style="background-image: url('{{ asset('storage/' . $event->image) }}'); background-size: cover; background-position: center; position: absolute; top: 0; left: 0; right: 0; bottom: 0; opacity: 0.3;"></div>
        @endif
        <div class="container position-relative">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <div class="event-date-badge mb-3">
                        <span class="badge bg-primary-custom fs-6 px-3 py-2">
                            <i class="fas fa-calendar-alt me-2"></i>
                            {{ $event->event_date->format('l, F j, Y') }}
                        </span>
                    </div>
                    <h1 class="display-4 fw-bold text-primary-custom mb-3">{{ $event->title }}</h1>
                    @if($event->location)
                        <p class="lead text-muted">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            {{ $event->location }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Event Details Section -->
    <section class="section-padding">
        <div class="container">
            <div class="row g-5">
                <!-- Main Content -->
                <div class="col-lg-8">
                    <!-- Event Information -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <h3 class="card-title text-primary-custom mb-3">
                                <i class="fas fa-info-circle me-2"></i>
                                Event Information
                            </h3>
                            <div class="event-description">
                                {!! nl2br(e($event->description)) !!}
                            </div>
                        </div>
                    </div>

                    @if($event->image)
                    <!-- Event Image -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-0">
                            <img src="{{ asset('storage/' . $event->image) }}"
                                 alt="{{ $event->title }}"
                                 class="img-fluid w-100 rounded">
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Event Details Card -->
                    <div class="card border-0 shadow-sm mb-4 sticky-top">
                        <div class="card-header bg-primary-custom text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-calendar-check me-2"></i>
                                Event Details
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="event-details">
                                <!-- Date & Time -->
                                <div class="detail-item mb-3">
                                    <div class="detail-icon">
                                        <i class="fas fa-calendar-alt text-primary-custom"></i>
                                    </div>
                                    <div class="detail-content">
                                        <strong>Date & Time</strong><br>
                                        <span class="text-muted">{{ $event->event_date->format('l, F j, Y') }}</span><br>
                                        <span class="text-muted">{{ $event->event_date->format('g:i A') }}</span>
                                    </div>
                                </div>

                                @if($event->location)
                                <!-- Location -->
                                <div class="detail-item mb-3">
                                    <div class="detail-icon">
                                        <i class="fas fa-map-marker-alt text-danger"></i>
                                    </div>
                                    <div class="detail-content">
                                        <strong>Location</strong><br>
                                        <span class="text-muted">{{ $event->location }}</span>
                                    </div>
                                </div>
                                @endif

                                <!-- Event Status -->
                                <div class="detail-item mb-3">
                                    <div class="detail-icon">
                                        <i class="fas fa-clock text-info"></i>
                                    </div>
                                    <div class="detail-content">
                                        <strong>Status</strong><br>
                                        @if($event->event_date->isFuture())
                                            <span class="badge bg-success">Upcoming Event</span>
                                        @elseif($event->event_date->isToday())
                                            <span class="badge bg-warning">Happening Today</span>
                                        @else
                                            <span class="badge bg-secondary">Past Event</span>
                                        @endif
                                    </div>
                                </div>

                                @if($event->is_featured)
                                <!-- Featured Badge -->
                                <div class="detail-item mb-3">
                                    <div class="detail-icon">
                                        <i class="fas fa-star text-warning"></i>
                                    </div>
                                    <div class="detail-content">
                                        <span class="badge bg-warning">Featured Event</span>
                                    </div>
                                </div>
                                @endif
                            </div>

                            <!-- Action Buttons -->
                            <div class="mt-4">
                                @if($event->event_date->isFuture())
                                    <button class="btn btn-primary-custom btn-lg w-100 mb-2" onclick="addToCalendar()">
                                        <i class="fas fa-calendar-plus me-2"></i>
                                        Add to Calendar
                                    </button>
                                @endif

                                <button class="btn btn-outline-primary w-100" onclick="shareEvent()">
                                    <i class="fas fa-share-alt me-2"></i>
                                    Share Event
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Card -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-secondary-custom text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-question-circle me-2"></i>
                                Need More Info?
                            </h5>
                        </div>
                        <div class="card-body text-center">
                            <p class="text-muted mb-3">Have questions about this event? Contact us for more information.</p>
                            <a href="{{ route('contact') }}" class="btn btn-outline-primary">
                                <i class="fas fa-envelope me-2"></i>
                                Contact Us
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Events -->
    @if($relatedEvents->isNotEmpty())
    <section class="section-padding bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Other Events</h2>
                <p class="section-subtitle">Discover more upcoming events and programs</p>
            </div>

            <div class="row g-4">
                @foreach($relatedEvents as $relatedEvent)
                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 shadow-sm card-hover h-100">
                        @if($relatedEvent->image)
                            <img src="{{ asset('storage/' . $relatedEvent->image) }}"
                                 alt="{{ $relatedEvent->title }}"
                                 class="card-img-top"
                                 style="height: 200px; object-fit: cover;">
                        @else
                            <div class="bg-secondary-custom d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="fas fa-calendar fa-3x text-white"></i>
                            </div>
                        @endif

                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-primary-custom">
                                    {{ $relatedEvent->event_date->format('M d, Y') }}
                                </span>
                                @if($relatedEvent->is_featured)
                                    <span class="badge bg-warning">Featured</span>
                                @endif
                            </div>

                            <h5 class="card-title">
                                <a href="{{ route('events.show', $relatedEvent->slug) }}"
                                   class="text-decoration-none text-dark">
                                    {{ $relatedEvent->title }}
                                </a>
                            </h5>

                            <p class="card-text text-muted flex-grow-1">
                                {{ Str::limit($relatedEvent->description, 100) }}
                            </p>

                            <div class="mt-auto">
                                <a href="{{ route('events.show', $relatedEvent->slug) }}"
                                   class="btn btn-outline-primary">
                                    Learn More
                                    <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('events.index') }}" class="btn btn-primary-custom btn-lg">
                    <i class="fas fa-calendar me-2"></i>
                    View All Events
                </a>
            </div>
        </div>
    </section>
    @endif
@endsection

@section('styles')
<style>
.event-hero {
    background: linear-gradient(135deg, #2596be 0%, #4b95c4 100%);
    color: white;
    position: relative;
    overflow: hidden;
}

.event-details {
    padding: 0;
}

.detail-item {
    display: flex;
    align-items: flex-start;
    gap: 15px;
}

.detail-icon {
    flex-shrink: 0;
    width: 24px;
    text-align: center;
}

.detail-content {
    flex: 1;
}

.event-description {
    line-height: 1.7;
    color: #495057;
    font-size: 1.1rem;
}

.event-description p {
    margin-bottom: 1rem;
}

.sticky-top {
    top: 100px !important;
}

.card-hover {
    transition: all 0.3s ease;
}

.card-hover:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
}

@media (max-width: 991px) {
    .sticky-top {
        position: relative !important;
        top: auto !important;
    }
}
</style>
@endsection

@section('scripts')
<script>
function addToCalendar() {
    const eventTitle = "{{ $event->title }}";
    const eventDescription = "{{ strip_tags($event->description) }}";
    const eventLocation = "{{ $event->location }}";
    const startDate = new Date("{{ $event->event_date->toISOString() }}");
    const endDate = new Date(startDate.getTime() + (2 * 60 * 60 * 1000)); // 2 hours later

    // Format dates for Google Calendar
    const formatDate = (date) => {
        return date.toISOString().replace(/[-:]/g, '').split('.')[0] + 'Z';
    };

    const googleCalendarUrl = `https://calendar.google.com/calendar/render?action=TEMPLATE&text=${encodeURIComponent(eventTitle)}&dates=${formatDate(startDate)}/${formatDate(endDate)}&details=${encodeURIComponent(eventDescription)}&location=${encodeURIComponent(eventLocation)}`;

    window.open(googleCalendarUrl, '_blank');
}

function shareEvent() {
    if (navigator.share) {
        navigator.share({
            title: "{{ $event->title }}",
            text: "{{ Str::limit($event->description, 100) }}",
            url: window.location.href
        });
    } else {
        // Fallback: copy URL to clipboard
        navigator.clipboard.writeText(window.location.href).then(function() {
            alert('Event URL copied to clipboard!');
        });
    }
}
</script>
@endsection
