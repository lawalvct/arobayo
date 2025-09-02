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