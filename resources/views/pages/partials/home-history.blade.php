<section class="section-padding">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <img src="{{ $siteSettings['history_image'] ?? '/images/logo.png' }}"
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
