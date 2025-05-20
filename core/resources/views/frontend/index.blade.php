@extends('frontend.partials.azia-main')
@section('title', 'Home')
@php
    $navbar_btn['text'] = 'Try For Free';
    $navbar_btn['link'] = route('register');
    if (
        isset($__site_details['btns']) &&
        isset($__site_details['btns']['navbar']) &&
        !empty($__site_details['btns']['navbar']['text'])
    ) {
        $navbar_btn['text'] = $__site_details['btns']['navbar']['text'] ?? 'Try For Free';
    }
    if (
        isset($__site_details['btns']) &&
        isset($__site_details['btns']['navbar']) &&
        !empty($__site_details['btns']['navbar']['link'])
    ) {
        $navbar_btn['link'] = $__site_details['btns']['navbar']['link'] ?? route('register');
    }

    $hero_btn['text'] = 'Start your Free Trial';
    $hero_btn['link'] = route('register');
    if (
        isset($__site_details['btns']) &&
        isset($__site_details['btns']['hero']) &&
        !empty($__site_details['btns']['hero']['text'])
    ) {
        $hero_btn['text'] = $__site_details['btns']['hero']['text'] ?? 'Start your Free Trial';
    }
    if (
        isset($__site_details['btns']) &&
        isset($__site_details['btns']['hero']) &&
        !empty($__site_details['btns']['hero']['link'])
    ) {
        $hero_btn['link'] = $__site_details['btns']['hero']['link'] ?? route('register');
    }

    $industry_btn['text'] = 'Get Started';
    $industry_btn['link'] = route('register');
    if (
        isset($__site_details['btns']) &&
        isset($__site_details['btns']['industry']) &&
        !empty($__site_details['btns']['industry']['text'])
    ) {
        $industry_btn['text'] = $__site_details['btns']['industry']['text'] ?? 'Get Started';
    }
    if (
        isset($__site_details['btns']) &&
        isset($__site_details['btns']['industry']) &&
        !empty($__site_details['btns']['industry']['link'])
    ) {
        $industry_btn['link'] = $__site_details['btns']['industry']['link'] ?? route('register');
    }

    //partner with us button
    $partnership_btn['text'] = 'Partner With Us';
    $partnership_btn['link'] = route('partnership');
    if (
        isset($details['btns']) &&
        isset($__site_details['btns']['industry']) &&
        !empty($__site_details['btns']['industry']['text'])
    ) {
        $partnership_btn['text'] = $__site_details['btns']['partnership']['text'] ?? 'Partner With Us';
    }
    if (
        isset($details['btns']) &&
        isset($__site_details['btns']['partnership']) &&
        !empty($__site_details['btns']['partnership']['link'])
    ) {
        $partnership_btn['link'] = $__site_details['btns']['partnership']['link'] ?? route('partnership');
    }

    $cta_btn['text'] = 'Try Now';
    $cta_btn['link'] = route('register');
    if (
        isset($__site_details['btns']) &&
        isset($__site_details['btns']['cta']) &&
        !empty($__site_details['btns']['cta']['text'])
    ) {
        $cta_btn['text'] = $__site_details['btns']['cta']['text'] ?? 'Try Now';
    }
    if (
        isset($__site_details['btns']) &&
        isset($__site_details['btns']['cta']) &&
        !empty($__site_details['btns']['cta']['link'])
    ) {
        $cta_btn['link'] = $__site_details['btns']['cta']['link'] ?? route('register');
    }
@endphp
@section('content')
    @php
        $industry = [];
        $feature = [];
        $page_meta = collect(); // default to empty collection

        if (isset($page) && $page && method_exists($page, 'pageMeta')) {
            $page_meta = $page->pageMeta->keyBy('meta_key');

            if (
                isset($page_meta['industry']) &&
                isset($page_meta['industry']['meta_value']) &&
                !empty($page_meta['industry']['meta_value'])
            ) {
                $industry = json_decode($page_meta['industry']['meta_value'], true);
            }

            if (
                isset($page_meta['feature']) &&
                isset($page_meta['feature']['meta_value']) &&
                !empty($page_meta['feature']['meta_value'])
            ) {
                $feature = json_decode($page_meta['feature']['meta_value'], true);
            }
        }

        // $packages = getNimoraPackages();

    @endphp

    <!-- Hero Section -->
    <section class="hero-section py-5">
        <div class="container">
            <div class="row align-items-center">
                <!-- Left Column: Text and Buttons -->
                <div class="col-lg-6 col-md-12 mb-4 mb-lg-0">
                    <h1 class="text-white">Modernize Your Credit Workflow with Creditt</h1>
                    <p class="text-white mb-4">
                        Creditt empowers financial institutions with a secure and scalable platform for managing credit
                        applications, approvals, and client onboarding—all in one place.
                    </p>
                    <div class="mb-4">
                        <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg mr-2">Try Now</a>
                        <a class="btn btn-primary btn-lg" href="{{ $hero_btn['link'] }}">
                            {{-- {{ $hero_btn['text'] }} --}}
                            Register
                        </a>
                    </div>
                </div>
                <!-- Right Column: Mockup Image -->
                <div class="col-lg-6 col-md-12">
                    <div class="mockup-wrapper">
                        <img src="{{ asset('/uploads/cms/1713083306_download.svg') }}"
                            alt="" class="img-fluid mockup-img">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Updated Dashboard Preview Section -->
    <section class="container dashboard-preview py-5">
        <div class="row">
            <div class="col-12">
                <div class="card mockup-card">
                    <div class="card-body p-0">
                        <img src="{{ asset('/uploads/cms/analytic.jpg') }}" alt="Web Analytics Dashboard Mockup"
                            class="img-fluid mockup-img">
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if (!empty($feature))
        <!-- Features Section -->
        <section class="features-section py-5" id="features">
            <div class="container">
                <div class="row justify-content-center flex-column-reverse flex-lg-row">
                    <!-- Heading and Description -->
                    <div class="col-lg-4 col-xl-5 mb-5 pe-lg-5">
                        <div class="sticky-content" data-margin-top="30px">
                            <h2 class="features-heading">{{ $feature['title'] ?? '' }}</h2>
                            <p class="features-description">{!! $feature['description'] ?? '' !!}</p>
                        </div>
                    </div>
                    <!-- Feature Cards -->
                    @if (!empty($feature['content']))
                        <div class="col-lg-8 col-xl-7">
                            <div class="row">
                                @foreach ($feature['content'] as $content)
                                    @if (!empty($content['icon']) && !empty($content['title']) && !empty($content['description']))
                                        <div class="col-md-6 mb-4">
                                            <div class="feature-card">
                                                <div class="feature-icon">
                                                    <i class="{{ $content['icon'] }} fa-lg"></i>
                                                </div>
                                                <h3 class="feature-title">{{ $content['title'] ?? '' }}</h3>
                                                <p class="feature-description">{{ $content['description'] ?? '' }}</p>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif

    <!-- Trust Indicators Section -->
    {{-- <section class="trust-indicators py-5">
        <div class="container">
            <!-- Heading and Subheading -->
            <div class="text-center mb-5">
                <h2 class="trust-heading">Nimora’s Statistics & Numbers</h2>
                <p class="trust-subheading">More & More businesses are adopting our all in one cloud-based business
                    management solution</p>
            </div>
            <!-- Statistics -->
            <div class="row text-center stats-container">
                <div class="col-md-3 col-6 mb-4">
                    <div class="stat-item">
                        <h3 class="stat-number">150+</h3>
                        <p class="stat-label">Registered Businesses</p>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <div class="stat-item">
                        <h3 class="stat-number">500+</h3>
                        <p class="stat-label">Daily Users</p>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <div class="stat-item">
                        <h3 class="stat-number">500K</h3>
                        <p class="stat-label">Invoices Created</p>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <div class="stat-item">
                        <h3 class="stat-number">56+</h3>
                        <p class="stat-label">Online Resources</p>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <!-- Screens Section -->
    <section class="screens-section py-5">
        <div class="container">
            <!-- Professional Heading -->
            <div class="text-center mb-5">
                <h2 class="overview-heading">Creditt Screenshots</h2>
            </div>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="screen-card">
                        <img src="{{ asset('uploads/cms/main.png') }}" alt="Web Analytics Dashboard"
                            class="img-fluid rounded">
                        <p class="text-center text-muted">Home Dashboard</p>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="screen-card">
                        <img src="{{ asset('uploads/cms/pos.png') }}" alt="Loan Monitoring"
                            class="img-fluid rounded">
                        <p class="text-center text-muted">Loan View</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if (!empty($industry))
        <!-- Industries Section -->
        <section class="industries-section py-5">
            <div class="container">
                <!-- Heading and Description (Centered) -->
                <div class="row justify-content-center mb-5">
                    <div class="col-lg-6 text-center">
                        <h2 class="industries-heading">{{ $industry['title'] ?? '' }}</h2>
                        <p class="industries-description">{!! $industry['description'] ?? '' !!}</p>
                        <div class="mt-4">
                            {{-- <a href="{{ $industry_btn['link'] }}" class="btn btn-az-primary">
                                {{ $industry_btn['text'] }}
                            </a> --}}
                        </div>
                    </div>
                </div>
                <!-- Industry Cards -->
                @if (!empty($industry['content']))
                    <div class="row">
                        @foreach ($industry['content'] as $content)
                            @if (!empty($content['icon']) && !empty($content['title']) && !empty($content['description']))
                                <div class="col-md-4 col-sm-6 mb-4">
                                    <div class="industry-card">
                                        <div class="industry-icon">
                                            <i class="{{ $content['icon'] }} fa-2x"></i>
                                        </div>
                                        <h3 class="industry-title">{{ $content['title'] ?? '' }}</h3>
                                        <p class="industry-description">{{ $content['description'] ?? '' }}</p>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </section>
    @endif

    <!-- Testimonials Section -->
    @if (!empty($testimonials) && count($testimonials) > 0)
        <section class="testimonials-section py-5">
            <div class="container">
                <!-- Heading -->
                <div class="text-center mb-5">
                    <h2 class="testimonials-heading">What They Say About Us</h2>
                </div>
                <div class="row">
                    <!-- Testimonials -->
                    @foreach ($testimonials as $testimonial)
                        <div class="col-md-4 col-sm-6 mb-4">
                            <div class="testimonial-card">
                                <div class="d-flex align-items-center mb-3">
                                    @php
                                        $name = $testimonial->title;
                                        $image = $testimonial->feature_image_url;
                                        $initials = strtoupper(substr($name, 0, 1) . substr(strrchr($name, ' '), 1, 1));
                                    @endphp
                                    @isset($image)
                                        <img src="{{ $image }}" alt="{{ $name }}"
                                            class="rounded-circle mr-3" loading="lazy">
                                    @else
                                        <div class="initials-circle mr-3">{{ $initials }}</div>
                                    @endisset
                                    <div>
                                        <h5 class="mb-0">{{ $testimonial->title }}</h5>
                                        {{-- <p class="text-muted mb-0">UK</p> --}}
                                    </div>
                                </div>
                                <div class="testimonial-content-wrapper">
                                    <p>{!! $testimonial->content !!}</p>
                                    <i class="fas fa-quote-right quote-icon"></i>
                                </div>
                                <div class="rating">
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Pricing Section -->
    @if (!empty($packages) && count($packages) > 0)
        <section class="pricing-section py-5" id="pricing">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="pricing-heading">Creditt Package Subscriptions</h2>
                </div>
                <div class="row">
                    @php
                        // Sort packages: "Try for Free" first, then others
                        $sortedPackages = $packages->sortBy(function ($package) {
                            return $package->name === 'Try for Free' ? 0 : 1;
                        });
                    @endphp

                    @foreach ($sortedPackages as $package)
                        <!-- Basic+ Plan -->
                        <div class="col-md-4 mb-4">
                            <div class="pricing-card">
                                <div class="card-header bg-light">
                                    <h4 class="mb-0">{{ $package->name }}</h4>
                                </div>
                                <div class="card-body text-center">
                                    <h3 class="pricing-price mb-3">
                                        @if ($package->price != 0)
                                        @else
                                            <span class="text-muted">@lang('superadmin::lang.free_for_duration', ['duration' => $package->interval_count . ' ' . __('lang_v1.' . $package->interval)])</span>
                                        @endif
                                    </h3>
                                    <ul class="list-unstyled mb-4">
                                        @php
                                            if ($package->location_count == 0) {
                                                $packageLocations = __('superadmin::lang.unlimited');
                                            } else {
                                                $packageLocations = $package->location_count;
                                            }
                                            if ($package->user_count == 0) {
                                                $users = __('superadmin::lang.unlimited');
                                            } else {
                                                $users = $package->user_count;
                                            }
                                            if ($package->product_count == 0) {
                                                $products = __('superadmin::lang.unlimited');
                                            } else {
                                                $products = $package->product_count;
                                            }
                                            if ($package->invoice_count == 0) {
                                                $invoices = __('superadmin::lang.unlimited');
                                            } else {
                                                $invoices = $package->invoice_count;
                                            }
                                            $trialDays = 0;
                                            if ($package->trial_days != 0) {
                                                $trialDays = $package->trial_days;
                                            }
                                            $permission_formatted = getModulePermissions();
                                        @endphp
                                        <li class="text-success"><i class="fas fa-check mr-2"></i>
                                            {{ $packageLocations }} @lang('business.business_locations')
                                        </li>
                                        <li class="text-success"><i class="fas fa-check mr-2"></i> {{ $users }}
                                            @lang('superadmin::lang.users')</li>
                                        <li class="text-success"><i class="fas fa-check mr-2"></i> {{ $products }}
                                            @lang('superadmin::lang.products')</li>
                                        <li class="text-success"><i class="fas fa-check mr-2"></i>{{ $invoices }}
                                            @lang('superadmin::lang.invoices')</li>
                                        @if ($trialDays != 0)
                                            <li class="text-success"><i class="fas fa-check mr-2"></i>
                                                {{ $trialDays }}
                                                @lang('superadmin::lang.trial_days')</li>
                                        @endif
                                        @if (!empty($package->custom_permissions))
                                            @foreach ($package->custom_permissions as $permission => $value)
                                                @isset($permission_formatted[$permission])
                                                    <li class="text-success"><i class="fas fa-check mr-2"></i>
                                                        {{ $permission_formatted[$permission] }}
                                                    </li>
                                                @endisset
                                            @endforeach
                                        @endif
                                    </ul>
                                    <a href="#" class="btn btn-primary btn-block">Buy Now</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    <!-- FAQ Section -->
    @if (!empty($faqs) && isset($faqs))
        <section class="faq-section py-5" id="faq">
            <div class="container">
                <!-- Section Heading -->
                <div class="text-center mb-5">
                    <h2 class="faq-heading">Frequently Asked Questions</h2>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-9">
                        <div class="accordion" id="faqAccordion">
                            <!-- FAQ 2 -->
                            @foreach ($faqs as $key => $faq)
                                <div class="faq-item">
                                    <div class="faq-header" id="headingTwo">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link faq-question collapsed" type="button"
                                                data-toggle="collapse" data-target="#{{ 'collapse' . $key }}"
                                                aria-expanded="false" aria-controls="{{ 'collapse' . $key }}">
                                                {{ $faq['question'] ?? '' }}
                                                <span class="faq-icon"><i class="fas fa-chevron-down"></i></span>
                                            </button>
                                        </h5>
                                    </div>
                                    <div id="{{ 'collapse' . $key }}" class="collapse" aria-labelledby="headingTwo"
                                        data-parent="#faqAccordion">
                                        <div class="faq-body">
                                            {{ $faq['answer'] ?? '' }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection
