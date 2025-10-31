<footer class="footer section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5 class="fw-bold">{{ $siteSettings['site_name'] ?? 'Egbe Arobayo' }}</h5>
                    <p>{{ $siteSettings['footer_description'] ?? 'Preserving and promoting Yoruba culture, traditions, and values for future generations.' }}</p>
                    <div class="social-links">
                        @if(isset($siteSettings['facebook_url']))
                            <a href="{{ $siteSettings['facebook_url'] }}" class="text-white me-3" target="_blank">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        @endif
                        @if(isset($siteSettings['twitter_url']))
                            <a href="{{ $siteSettings['twitter_url'] }}" class="text-white me-3" target="_blank">
                                <i class="fab fa-twitter"></i>
                            </a>
                        @endif
                        @if(isset($siteSettings['instagram_url']))
                            <a href="{{ $siteSettings['instagram_url'] }}" class="text-white me-3" target="_blank">
                                <i class="fab fa-instagram"></i>
                            </a>
                        @endif
                    </div>
                </div>

                <div class="col-lg-2 mb-4">
                    <h6 class="fw-bold">Quick Links</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}" class="text-white-50">Home</a></li>
                        <li><a href="{{ route('events.index') }}" class="text-white-50">Events</a></li>
                        <li><a href="{{ route('gallery.index') }}" class="text-white-50">Gallery</a></li>
                        <li><a href="{{ route('register') }}" class="text-white-50">Join Us</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 mb-4">
                    <h6 class="fw-bold">Contact Info</h6>
                    <ul class="list-unstyled">
                        @if(isset($siteSettings['contact_phone']))
                            <li class="text-white-50">
                                <i class="fas fa-phone me-2"></i>
                                {{ $siteSettings['contact_phone'] }}
                            </li>
                        @endif
                        @if(isset($siteSettings['contact_email']))
                            <li class="text-white-50">
                                <i class="fas fa-envelope me-2"></i>
                                {{ $siteSettings['contact_email'] }}
                            </li>
                        @endif
                        @if(isset($siteSettings['address']))
                            <li class="text-white-50">
                                <i class="fas fa-map-marker-alt me-2"></i>
                                {{ $siteSettings['address'] }}
                            </li>
                        @endif
                    </ul>
                </div>

                <div class="col-lg-3 mb-4">
                    <h6 class="fw-bold">Newsletter</h6>
                    <p class="text-white-50">Stay updated with our latest news and events.</p>
                    <div class="input-group">
                        <input type="email" class="form-control" placeholder="Your email">
                        <button class="btn btn-outline-light" type="button">Subscribe</button>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="text-white-50 mb-0">
                        &copy; {{ date('Y') }} {{ $siteSettings['site_name'] ?? 'Egbe Arobayo' }}. All rights reserved.
                    </p>
                </div>
                <div class="col-md-6 text-end">
                    <a href="#" class="text-white-50 me-3">Privacy Policy</a>
                    <a href="#" class="text-white-50">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>
