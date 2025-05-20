<style>
    .nav-item.dropdown:hover .dropdown-menu {
        display: block;
        margin-top: 0;
    }

    .dropdown-menu-wide {
        width: 100%;
        left: 0;
        right: 0;
        top: 100%;
        max-height: 80vh;
        overflow-y: auto;
        overflow-x: hidden;
        scroll-behavior: smooth;
    }

    .dropdown-content-wrapper {
        padding: 1rem 2rem;
    }

    .navbar-nav .dropdown-menu {
        border-top: 3px solid #ffc107;
    }

    @media (max-width: 991.98px) {
        .navbar .dropdown-menu {
            position: static !important;
            float: none;
        }
    }
</style>

<nav class="navbar navbar-expand-lg navbar-light sticky-top-nav">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <img src="{{ asset('uploads/cms/logo.png') }}" alt="Credit Logo" class="brand-logo">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <!-- Apps Mega Menu -->
                {{-- <li class="nav-item dropdown position-static">
                    <a class="nav-link nav-link-sm dropdown-toggle" href="#" id="appsDropdown" role="button">
                        Apps
                    </a>
                    <div class="dropdown-menu dropdown-menu-wide" aria-labelledby="appsDropdown">
                        <div class="dropdown-content-wrapper">
                            <div class="row">
                                <!-- Finance -->
                                <div class="col-md-3">
                                    <h6 class="dropdown-header">Finance</h6>
                                    <a class="dropdown-item" href="#">Accounting</a>
                                    <a class="dropdown-item" href="#">Invoicing</a>
                                    <a class="dropdown-item" href="#">Expenses</a>
                                    <a class="dropdown-item" href="#">Spreadsheet (BI)</a>
                                    <a class="dropdown-item" href="#">Documents</a>
                                    <a class="dropdown-item" href="#">Sign</a>
                                </div>

                                <!-- Productivity -->
                                <div class="col-md-3">
                                    <h6 class="dropdown-header">Productivity</h6>
                                    <a class="dropdown-item" href="#">Discuss</a>
                                    <a class="dropdown-item" href="#">Approvals</a>
                                    <a class="dropdown-item" href="#">IoT</a>
                                    <a class="dropdown-item" href="#">VoIP</a>
                                    <a class="dropdown-item" href="#">Knowledge</a>
                                    <a class="dropdown-item" href="#">WhatsApp</a>
                                </div>

                                <!-- Sales -->
                                <div class="col-md-3">
                                    <h6 class="dropdown-header">Sales</h6>
                                    <a class="dropdown-item" href="#">CRM</a>
                                    <a class="dropdown-item" href="#">Sales</a>
                                    <a class="dropdown-item" href="#">POS Shop</a>
                                    <a class="dropdown-item" href="#">POS Restaurant</a>
                                    <a class="dropdown-item" href="#">Subscriptions</a>
                                    <a class="dropdown-item" href="#">Rental</a>
                                </div>

                                <!-- Marketing -->
                                <div class="col-md-3">
                                    <h6 class="dropdown-header">Marketing</h6>
                                    <a class="dropdown-item" href="#">Social Marketing</a>
                                    <a class="dropdown-item" href="#">Email Marketing</a>
                                    <a class="dropdown-item" href="#">SMS Marketing</a>
                                    <a class="dropdown-item" href="#">Events</a>
                                    <a class="dropdown-item" href="#">Marketing Automation</a>
                                    <a class="dropdown-item" href="#">Surveys</a>
                                </div>

                                <!-- Supply Chain -->
                                <div class="col-md-3">
                                    <h6 class="dropdown-header">Supply Chain</h6>
                                    <a class="dropdown-item" href="#">Inventory</a>
                                    <a class="dropdown-item" href="#">Manufacturing</a>
                                    <a class="dropdown-item" href="#">PLM</a>
                                    <a class="dropdown-item" href="#">Purchase</a>
                                    <a class="dropdown-item" href="#">Maintenance</a>
                                    <a class="dropdown-item" href="#">Quality</a>
                                </div>

                                <!-- Services -->
                                <div class="col-md-3">
                                    <h6 class="dropdown-header">Services</h6>
                                    <a class="dropdown-item" href="#">Project</a>
                                    <a class="dropdown-item" href="#">Timesheets</a>
                                    <a class="dropdown-item" href="#">Field Service</a>
                                    <a class="dropdown-item" href="#">Helpdesk</a>
                                    <a class="dropdown-item" href="#">Planning</a>
                                    <a class="dropdown-item" href="#">Appointments</a>
                                </div>

                                <!-- Human Resources -->
                                <div class="col-md-3">
                                    <h6 class="dropdown-header">Human Resources</h6>
                                    <a class="dropdown-item" href="#">Employees</a>
                                    <a class="dropdown-item" href="#">Recruitment</a>
                                    <a class="dropdown-item" href="#">Time Off</a>
                                    <a class="dropdown-item" href="#">Appraisals</a>
                                    <a class="dropdown-item" href="#">Referrals</a>
                                    <a class="dropdown-item" href="#">Fleet</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li> --}}

                <!-- Other Links -->
                <li class="nav-item">
                    <a class="nav-link nav-link-sm" href="{{ route('home') }}">Home</a>
                </li>
                <!-- Industries Mega Menu -->
                {{-- <li class="nav-item dropdown position-static">
                    <a class="nav-link nav-link-sm dropdown-toggle" href="#">Industries</a>
                    <div class="dropdown-menu dropdown-menu-wide">
                        <div class="dropdown-content-wrapper">
                            <div class="row">
                                <!-- Services -->
                                <div class="col-md-3">
                                    <h6 class="dropdown-header">Services</h6>
                                    <a class="dropdown-item" href="#">Bike Leasing</a>
                                    <a class="dropdown-item" href="#">Billboard Rental</a>
                                    <a class="dropdown-item" href="#">Hair Salon</a>
                                    <a class="dropdown-item" href="#">Handyman</a>
                                    <a class="dropdown-item" href="#">Law Firm</a>
                                    <a class="dropdown-item" href="#">Real Estate</a>
                                </div>

                                <!-- Construction -->
                                <div class="col-md-3">
                                    <h6 class="dropdown-header">Construction</h6>
                                    <a class="dropdown-item" href="#">Architecture Firm</a>
                                    <a class="dropdown-item" href="#">Construction</a>
                                    <a class="dropdown-item" href="#">Gardening</a>
                                    <a class="dropdown-item" href="#">Solar Energy</a>
                                </div>

                                <!-- Supply Chain -->
                                <div class="col-md-3">
                                    <h6 class="dropdown-header">Supply Chain</h6>
                                    <a class="dropdown-item" href="#">Beverage Distributor</a>
                                    <a class="dropdown-item" href="#">Corporate Gifts</a>
                                    <a class="dropdown-item" href="#">Custom Furniture</a>
                                    <a class="dropdown-item" href="#">Micro Brewery</a>
                                </div>

                                <!--Health & Fitness-->
                                <div class="col-md-3">
                                    <h6 class="dropdown-header">Health & Fitness</h6>
                                    <a class="dropdown-item" href="#">Eyewear Store</a>
                                    <a class="dropdown-item" href="#">Fitness Center</a>
                                    <a class="dropdown-item" href="#">Sports Club</a>
                                    <a class="dropdown-item" href="#">Wellness</a>
                                </div>
                                <!--hospitality and bar-->
                                <div class="col-md-3">
                                    <h6 class="dropdown-header mt-3">Hospitality</h6>
                                    <a class="dropdown-item" href="#">Bar and Pub</a>
                                    <a class="dropdown-item" href="#">Fast Food</a>
                                    <a class="dropdown-item" href="#">Fine Dining Restaurant</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li> --}}

                <li class="nav-item">
                    <a class="nav-link nav-link-sm" href="{{ route('home') }}#pricing">Packages</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-sm" href="{{ route('contact_us') }}">Contact Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-sm" href="{{ route('home') }}#faq">FAQ</a>
                </li>
            </ul>

            <ul class="navbar-nav d-flex">
                {{-- <li class="nav-item mr-3">
                    <a class="nav-link nav-link-sm" href="{{ route('partnership') }}">
                        {{ $partnership_btn['text'] }}</a>
                </li> --}}

                @if (Auth::check())
                    <li class="nav-item">
                        <a class="nav-link nav-link-sm" href="{{ route('home') }}">
                            @lang('cms::lang.dashboard')</a>
                    </li>
                @else
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link nav-link-sm" href="{{ route('login') }}">
                                Login</a>
                        </li>
                    @endif
                @endif
            </ul>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dropdowns = document.querySelectorAll('.nav-item.dropdown');

        dropdowns.forEach(dropdown => {
            let timeout;

            dropdown.addEventListener('mouseenter', () => {
                clearTimeout(timeout);
                dropdown.classList.add('show');
                dropdown.querySelector('.dropdown-menu').classList.add('show');
            });

            dropdown.addEventListener('mouseleave', () => {
                timeout = setTimeout(() => {
                    dropdown.classList.remove('show');
                    dropdown.querySelector('.dropdown-menu').classList.remove('show');
                }, 200); // Delay in ms before closing
            });

            const menu = dropdown.querySelector('.dropdown-menu');
            if (menu) {
                menu.addEventListener('mouseenter', () => {
                    clearTimeout(timeout);
                });
                menu.addEventListener('mouseleave', () => {
                    timeout = setTimeout(() => {
                        dropdown.classList.remove('show');
                        menu.classList.remove('show');
                    }, 200);
                });
            }
        });
    });
</script>
