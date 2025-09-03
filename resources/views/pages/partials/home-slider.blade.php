@section('styles')
<style>
    /* Dynamic slider styles */
    @if($homeContent && isset($homeContent['hero']['slides']))
        @foreach($homeContent['hero']['slides'] as $index => $slide)
        .hero-slide.slide-{{ $index + 1 }} {
            background-image: url('{{ asset($slide['image'] ?? 'uploads/slides/slider' . ($index + 1) . '.jpeg') }}');
        }
        @endforeach
    @else
        .hero-slide.slide-1 { background-image: url('{{ asset('uploads/slides/slider1.jpeg') }}'); }
        .hero-slide.slide-2 { background-image: url('{{ asset('uploads/slides/slider2.jpeg') }}'); }
        .hero-slide.slide-3 { background-image: url('{{ asset('uploads/slides/slider3.jpeg') }}'); }
    @endif
</style>
@endsection

@section('content')
    <!-- Hero Slider Section -->
    <section class="hero-slider" id="heroSlider">
        @if($homeContent && isset($homeContent['hero']['slides']) && count($homeContent['hero']['slides']) > 0)
            @foreach($homeContent['hero']['slides'] as $index => $slide)
                <div class="hero-slide slide-{{ $index + 1 }} {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index }}">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="hero-content">
                                    <h1 class="hero-title">
                                        {{ $slide['title'] ?? 'Welcome to Egbe Arobayo' }}
                                    </h1>
                                    <p class="hero-subtitle">
                                        {{ $slide['subtitle'] ?? 'Preserving Yoruba culture, traditions, and values for future generations.' }}
                                    </p>
                                    @if(!empty($slide['button_text']) && !empty($slide['button_link']))
                                        <div class="hero-buttons">
                                            <a href="{{ $slide['button_link'] }}" class="btn btn-accent-yellow btn-lg">
                                                <i class="fas fa-arrow-right me-2"></i>
                                                {{ $slide['button_text'] }}
                                            </a>
                                            <a href="{{ route('events.index') }}" class="btn btn-outline-light btn-lg">
                                                <i class="fas fa-calendar me-2"></i>
                                                View Events
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <!-- Default slide if no content configured -->
            <div class="hero-slide slide-1 active" data-slide="0">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="hero-content">
                                <h1 class="hero-title">
                                    Welcome to Egbe Arobayo
                                </h1>
                                <p class="hero-subtitle">
                                    Preserving Yoruba culture, traditions, and values for future generations. Join us in celebrating our rich heritage.
                                </p>
                                <div class="hero-buttons">
                                    <a href="{{ route('register') }}" class="btn btn-accent-yellow btn-lg">
                                        <i class="fas fa-users me-2"></i>
                                        Join Our Community
                                    </a>
                                    <a href="{{ route('events.index') }}" class="btn btn-outline-light btn-lg">
                                        <i class="fas fa-calendar me-2"></i>
                                        View Events
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
                                    <i class="fas fa-calendar me-2"></i>
                                    View Events
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Slide 2 -->
        <div class="hero-slide slide-2" data-slide="1">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="hero-content">
                            <h1 class="hero-title">
                                Cultural Preservation
                            </h1>
                            <p class="hero-subtitle">
                                Keeping our rich Yoruba traditions alive through education, events, and community engagement. Experience the beauty of our ancestral heritage.
                            </p>
                            <div class="hero-buttons">
                                <a href="{{ route('gallery.index') }}" class="btn btn-accent-yellow btn-lg">
                                    <i class="fas fa-images me-2"></i>
                                    View Gallery
                                </a>
                                <a href="#our-purpose" class="btn btn-outline-light btn-lg scroll-to">
                                    <i class="fas fa-arrow-down me-2"></i>
                                    Learn More
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Slide 3 -->
        <div class="hero-slide slide-3" data-slide="2">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="hero-content">
                            <h1 class="hero-title">
                                Community Unity
                            </h1>
                            <p class="hero-subtitle">
                                Building bridges between generations and fostering unity among Yoruba people worldwide. Together, we are stronger.
                            </p>
                            <div class="hero-buttons">
                                <a href="#leadership" class="btn btn-accent-yellow btn-lg scroll-to">
                                    <i class="fas fa-crown me-2"></i>
                                    Meet Our Leaders
                                </a>
                                <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg">
                                    <i class="fas fa-handshake me-2"></i>
                                    Join Today
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Slider Navigation Dots -->
        <div class="slider-nav">
            @if($homeContent && isset($homeContent['hero']['slides']))
                @foreach($homeContent['hero']['slides'] as $index => $slide)
                    <div class="slider-dot {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index }}"></div>
                @endforeach
            @else
                <div class="slider-dot active" data-slide="0"></div>
                <div class="slider-dot" data-slide="1"></div>
                <div class="slider-dot" data-slide="2"></div>
            @endif
        </div>

        <!-- Slider Arrows -->
        <div class="slider-arrow prev" id="prevSlide">
            <i class="fas fa-chevron-left"></i>
        </div>
        <div class="slider-arrow next" id="nextSlide">
            <i class="fas fa-chevron-right"></i>
        </div>

        <!-- Floating Stats -->
        <div class="floating-stats d-none d-lg-block">
            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-text">
                    <strong>500+</strong><br>
                    Active Members
                </div>
            </div>
            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fas fa-calendar"></i>
                </div>
                <div class="stat-text">
                    <strong>50+</strong><br>
                    Annual Events
                </div>
            </div>
            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fas fa-award"></i>
                </div>
                <div class="stat-text">
                    <strong>25+</strong><br>
                    Years of Service
                </div>
            </div>
        </div>
    </section>