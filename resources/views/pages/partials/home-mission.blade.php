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
    </section>