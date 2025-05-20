@php
    $mail_us =
        isset($__site_details['mail_us']) && !empty($__site_details['mail_us']) ? $__site_details['mail_us'] : [];
    $mail_us_collection = collect($mail_us);
    $filtered_mail_us = $mail_us_collection->filter(function ($value, $key) {
        return !empty($value['label']) && !empty($value['email']);
    });
    $first_email = optional($filtered_mail_us->first())['email'] ?? null;

    $contact_us =
        isset($__site_details['contact_us']) && !empty($__site_details['contact_us'])
            ? $__site_details['contact_us']
            : [];
    $contact_us_collection = collect($contact_us);
    $filtered_contact_us = $contact_us_collection->filter(function ($value, $key) {
        return !empty($value['label']) && !empty($value['num']);
    });
    $first_contact_number = optional($filtered_contact_us->first())['num'] ?? null;
@endphp
<footer class="bg-dark text-white mt-5 py-4">
    <div class="container">
        <div class="row">
            <!-- About -->
            <div class="col-md-4">
                <div class="footer-logo mb-3">
                    <img src="{{ asset('uploads/cms/logo.png') }}" alt="Creditt Logo" class="footer-logo-img">
                </div>
                <h5 class="text-uppercase">About Creditt</h5>
                <p class="">
                    Creditt offers a seamless and intelligent solution for managing your entire credit
                    process—from application intake to final approval. Whether you're a microfinance, SACCO, or
                    enterprise lender, our platform simplifies client onboarding, automates evaluations, and helps you
                    make faster, smarter credit decisions.
                </p>
            </div>

            <!-- Quick Links -->
            <div class="col-md-2">
                <h5 class="text-uppercase">Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('home') }}#features" class="text-white">Features</a></li>
                    <li><a href="{{ route('home') }}#pricing" class="text-white">Packages</a></li>
                    <li><a href="{{ route('contact_us') }}" class="text-white">Contact</a></li>
                    <li><a href="#" class="text-white">Terms of Service</a></li>
                    <li><a href="#" class="text-white">Privacy Policy</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="col-md-3">
                <h5 class="text-uppercase">Contact Us</h5>
                <ul class="list-unstyled">
                    <li><i class="fas fa-envelope"></i>&nbsp;<a href="mailto:{{ $first_email }}" target="_blank"
                            class="text-white text-decoration-none">{{ $first_email }}
                        </a></li>
                    <li><i class="fas fa-phone"></i>&nbsp;{{ $first_contact_number }}</li>
                    <li><i class="fas fa-map-marker-alt"></i> Kampala, Uganda</li>
                </ul>
            </div>

            <!-- Social Media -->
            <div class="col-md-3">
                <h5 class="text-uppercase">Follow Us</h5>
                <a href="#" class="text-white me-3"><i class="fab fa-facebook fa-lg"></i></a>
                <a href="#" class="text-white me-3"><i class="fab fa-twitter fa-lg"></i></a>
                <a href="#" class="text-white me-3"><i class="fab fa-linkedin fa-lg"></i></a>
                <a href="#" class="text-white"><i class="fab fa-instagram fa-lg"></i></a>
            </div>
        </div>

        <hr class="bg-light">
        <div class="text-center">
            <p class="small mb-0">© <span id='currentYear'>2024</span> Creditt. All rights reserved.</p>
        </div>
    </div>
</footer>
