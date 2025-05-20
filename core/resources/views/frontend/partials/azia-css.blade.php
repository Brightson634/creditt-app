<style>
    html,
    body {
        height: 100%;
        margin: 0;
    }

    body {
        font-family: 'Roboto', sans-serif;
        /* background: linear-gradient(135deg, #6e48aa, #9d50bb); */
        color: #333;
        display: flex;
        flex-direction: column;
        padding-top: 70px;
    }

    .content-wrapper {
        flex: 1 0 auto;
    }

    footer {
        flex-shrink: 0;
    }

    .navbar {
        /* background-color: transparent !important; */
        background-color: rgb(233, 233, 236);
        /* background-color: whitesmoke; */
    }

    .navbar .nav-link {
        color: #fff !important;
        font-weight: 500;
    }

    .navbar .nav-link:hover {
        color: #ddd !important;
    }

    .hero-section {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: #fff;
    }

    .hero-section h1 {
        font-size: 3.5rem;
        font-weight: 700;
        line-height: 1.2;
    }

    .hero-section p {
        font-size: 1.25rem;
        margin-bottom: 2rem;
    }

    .btn-primary {
        background-color: #6e48aa;
        border-color: #6e48aa;
        padding: 10px 30px;
        font-size: 1.1rem;
    }

    .btn-primary:hover {
        background-color: #5a3a8b;
        border-color: #5a3a8b;
    }

    .btn-outline-light {
        border-color: #fff;
        color: #fff;
        padding: 10px 30px;
        font-size: 1.1rem;
    }

    .btn-outline-light:hover {
        background-color: #fff;
        color: #6e48aa;
    }

    .tech-icons img {
        width: 40px;
        margin: 0 10px;
        background: #fff;
        border-radius: 50%;
        padding: 5px;
    }

    .dashboard-preview {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        margin-top: -100px;
        padding: 30px;
    }

    .dashboard-preview h2 {
        font-size: 1.5rem;
        font-weight: 700;
    }

    .dashboard-preview .card {
        border: none;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .dashboard-preview .card-body {
        padding: 20px;
    }

    .dashboard-preview .display-4 {
        font-size: 2.5rem;
        font-weight: 700;
        color: #333;
    }

    .dashboard-preview .text-muted {
        font-size: 0.9rem;
    }

    .app-icons img {
        width: 80px;
        margin: 15px;
    }

    footer a {
        text-decoration: none;
    }

    footer a:hover {
        text-decoration: underline;
    }

    footer ul {
        padding-left: 0;
    }

    footer ul li {
        margin-bottom: 8px;
    }

    .overview-section {
        background: #f8f9fa;
        color: #333;
    }

    .overview-section h2 {
        font-size: 2.5rem;
        font-weight: 700;
        color: #333;
    }

    .overview-section p {
        font-size: 1rem;
        line-height: 1.6;
    }

    .overview-section h3 {
        font-size: 1.5rem;
        font-weight: 700;
    }

    .feature-item {
        font-size: 1rem;
        color: #333;
    }

    .feature-item i {
        font-size: 1.2rem;
        color: #6e48aa;
    }

    .trust-indicators {
        border-top: 1px dashed #ddd;
        border-bottom: 1px dashed #ddd;
    }

    .trust-indicators p {
        font-size: 0.9rem;
        color: #333;
    }

    .trust-indicators strong {
        font-size: 1.1rem;
    }

    .screens-section h2 {
        font-size: 2.5rem;
        font-weight: 700;
        color: #1e3c72;
        position: relative;
        display: inline-block;
        padding-bottom: 10px;
        margin-bottom: 0;
    }

    .screen-card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        padding: 15px;
        transition: transform 0.3s ease;
    }

    .screen-card:hover {
        transform: translateY(-5px);
    }

    .screen-card img {
        width: 100%;
        height: auto;
    }

    .screen-card p {
        font-size: 1rem;
        font-weight: 600;
        color: #333;
    }

    .screen-card .text-muted {
        font-size: 0.9rem;
    }

    .pricing-section {
        background: #f8f9fa;
        color: #333;
    }

    .pricing-section .text-primary {
        color: #6e48aa !important;
    }

    .pricing-card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .pricing-card:hover {
        transform: translateY(-5px);
    }

    .pricing-card .card-header {
        position: relative;
        padding: 15px;
        border-bottom: 1px solid #ddd;
    }

    .pricing-card .card-header h4 {
        font-size: 1.25rem;
        font-weight: 700;
        color: #333;
    }

    .pricing-card .badge {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 0.8rem;
        padding: 5px 10px;
    }

    .pricing-card .card-body {
        padding: 20px;
    }

    .pricing-price {
        font-size: 2rem;
        font-weight: 700;
        color: #333;
    }

    .pricing-price .text-muted {
        font-size: 1rem;
        font-weight: 400;
    }

    .pricing-card ul li {
        font-size: 0.9rem;
        margin-bottom: 10px;
    }

    .pricing-card .text-success i {
        color: #28a745;
    }

    .pricing-card .text-danger i {
        color: #dc3545;
    }

    .pricing-card .btn-primary {
        padding: 10px;
        font-size: 1rem;
    }

    .testimonials-section {
        background: #f8f9fa;
        color: #333;
    }

    .testimonial-card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        padding: 20px;
        transition: transform 0.3s ease;
    }

    .testimonial-card:hover {
        transform: translateY(-5px);
    }

    .testimonial-card img {
        width: 50px;
        height: 50px;
    }

    .testimonial-card h5 {
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
    }

    .testimonial-card p {
        font-size: 0.9rem;
        line-height: 1.6;
        color: #666;
    }

    .testimonial-card .text-muted {
        font-size: 0.8rem;
    }

    .testimonial-card .rating i {
        font-size: 1rem;
    }

    .navbar .nav-link.nav-link-sm {
        font-size: 0.9rem;
        padding: 5px 10px;
    }

    .navbar .nav-link:hover {
        color: #ddd !important;
    }

    .navbar .btn-outline-light {
        border-width: 1px;
        font-size: 0.9rem;
        padding: 5px 15px;
    }

    .navbar .btn-smaller {
        font-size: 0.8rem;
        padding: 4px 12px;
    }

    .navbar .ml-2 {
        margin-left: 0.5rem;
    }

    .nav-item.dropdown:hover .dropdown-menu {
        display: block;
        margin-top: 0;
    }

    .dropdown-header {
        font-size: 0.9rem;
        font-weight: 700;
        color: #333;
        text-transform: uppercase;
        padding: 5px 15px;
        border-bottom: 1px solid #e9ecef;
        margin-bottom: 10px;
    }

    .dropdown-item {
        font-size: 0.85rem;
        color: #666;
        padding: 5px 15px;
        transition: color 0.3s ease;
    }

    .dropdown-item:hover {
        background: none;
        color: #6e48aa;
    }

    .dropdown-toggle::after {
        border-top: 0.3em solid #fff;
        border-right: 0.3em solid transparent;
        border-left: 0.3em solid transparent;
        vertical-align: middle;
    }

    .apps-overview-section {
        background: #f8f9fa;
        color: #333;
    }

    .app-card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        padding: 15px;
        transition: transform 0.3s ease;
    }

    .app-card:hover {
        transform: translateY(-3px);
    }

    .app-icon img {
        width: 50px;
        height: 50px;
    }

    .app-label {
        font-size: 0.9rem;
        font-weight: 500;
        color: #666;
        margin-bottom: 0;
    }

    .dashboard-preview {
        background: #f8f9fa;
        padding-top: 3rem !important;
        padding-bottom: 3rem !important;
    }

    .mockup-card {
        border: none;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        border-radius: 20px;
        overflow: hidden;
    }

    .mockup-img {
        width: 100%;
        height: auto;
        transition: transform 0.3s ease;
    }

    .mockup-img:hover {
        transform: scale(1.03);
    }

    .brand-logo {
        height: 40px;
        width: auto;
        vertical-align: middle;
        transition: opacity 0.3s ease;
    }

    .brand-logo:hover {
        opacity: 0.9;
    }

    .navbar-brand {
        padding-top: 0;
        padding-bottom: 0;
    }

    .hero-section {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        position: relative;
        overflow: hidden;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('https://via.placeholder.com/1500x1500?text=Grid+Pattern') repeat;
        opacity: 0.1;
        z-index: 0;
    }

    .hero-section .container {
        position: relative;
        z-index: 1;
    }

    .hero-section h1 {
        font-size: 2.5rem;
        font-weight: 700;
        line-height: 1.3;
    }

    .hero-section p {
        font-size: 1.1rem;
        opacity: 0.9;
    }

    .hero-section .btn-outline-light {
        border-color: #fff;
        color: #fff;
        transition: all 0.3s ease;
    }

    .hero-section .btn-outline-light:hover {
        background: #fff;
        color: #2a5298;
    }

    .hero-section .btn-primary {
        background: #007bff;
        border: none;
        transition: all 0.3s ease;
    }

    .hero-section .btn-primary:hover {
        background: #0056b3;
    }

    .mockup-wrapper {
        position: relative;
        text-align: center;
    }

    .mockup-img {
        max-width: 100%;
        height: auto;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease;
    }

    .mockup-img:hover {
        transform: scale(1.05);
    }

    @media (max-width: 991px) {
        .hero-section h1 {
            font-size: 2rem;
        }

        .hero-section p {
            font-size: 1rem;
        }

        .mockup-img {
            margin-top: 2rem;
        }
    }

    .sticky-top-nav {
        position: fixed !important;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1030;
        /* background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); */
        background-color: rgb(233, 233, 236);
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        transition: background 0.3s ease;
    }

    .sticky-top-nav .nav-link {
        color: #fff !important;
    }

    .sticky-top-nav .nav-link:hover {
        color: #ddd !important;
    }

    .sticky-top-nav .btn-outline-light {
        border-color: #fff;
        color: #fff;
    }

    .sticky-top-nav .btn-outline-light:hover {
        background: #fff;
        color: #2a5298;
    }

    .sticky-top-nav .dropdown-menu {
        top: 100%;
        margin-top: 0;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .footer-logo {
        text-align: left;
    }

    .footer-logo-img {
        height: 40px;
        width: auto;
        filter: brightness(0) invert(1);
        transition: opacity 0.3s ease;
    }

    .footer-logo-img:hover {
        opacity: 0.8;
    }

    @media (max-width: 576px) {
        .footer-logo-img {
            height: 30px;
        }
    }

    /* Contact Us Styles */
    .contact-us-section {
        background: #f8f9fa;
    }

    .contact-us-section h2 {
        font-size: 2rem;
        font-weight: 700;
        color: #1e3c72;
    }

    .contact-us-section .text-muted {
        font-size: 1.1rem;
    }

    .contact-us-section .form-control {
        /* border-radius: 8px;
        border: 1px solid #e0e0e0;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        transition: border-color 0.3s ease, box-shadow 0.3s ease; */
    }

    .contact-us-section .form-control:focus {
        /* border-color: #007bff; */
        /* box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25); */
    }

    .contact-us-section .btn-primary {
        background: #007bff;
        border: none;
        border-radius: 8px;
        padding: 0.75rem;
        font-weight: 600;
        transition: background 0.3s ease;
    }

    .contact-us-section .btn-primary:hover {
        background: #0056b3;
    }

    .contact-details h5 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1e3c72;
    }

    .contact-details ul li {
        font-size: 0.95rem;
        color: #333;
    }

    .contact-details ul li i {
        font-size: 1rem;
        width: 20px;
    }

    .contact-details ul li a {
        color: #333;
        text-decoration: none;
    }

    .contact-details ul li a:hover {
        color: #007bff;
        text-decoration: underline;
    }

    @media (max-width: 991px) {
        .illustration-img {
            margin-bottom: 2rem;
        }

        .contact-us-section h2 {
            font-size: 1.75rem;
        }

        .contact-us-section .text-muted {
            font-size: 1rem;
        }
    }


    .testimonials-section {
        background: #f8f9fa;
    }

    .testimonials-heading,
    .pricing-heading {
        font-size: 2.5rem;
        font-weight: 700;
        color: #1e3c72;
        position: relative;
        display: inline-block;
        padding-bottom: 10px;
        margin-bottom: 0;
    }

    .testimonials-heading::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 50px;
        height: 3px;
        background: #007bff;
        border-radius: 2px;
    }

    .testimonial-card {
        background: #fff;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .testimonial-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }

    .testimonial-card img {
        width: 50px;
        height: 50px;
        object-fit: cover;
    }

    .initials-circle {
        width: 50px;
        height: 50px;
        background: #e9ecef;
        color: #1e3c72;
        font-size: 1.2rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        border: 3px solid #007bff;
    }

    .testimonial-card h5 {
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
    }

    .testimonial-card .text-muted {
        font-size: 0.85rem;
        color: #999;
    }

    .testimonial-content-wrapper {
        position: relative;
        flex-grow: 1;
        margin-bottom: 1rem;
    }

    .testimonial-content-wrapper p {
        font-size: 0.95rem;
        color: #666;
        margin-bottom: 0;
    }

    .quote-icon {
        position: absolute;
        bottom: 0;
        right: 0;
        font-size: 1.5rem;
        color: #007bff;
        opacity: 0.3;
    }

    .rating {
        margin-top: 1rem;
    }

    .rating i {
        font-size: 1rem;
    }

    @media (max-width: 767px) {
        .testimonials-heading {
            font-size: 2rem;
        }

        .testimonial-card {
            padding: 15px;
        }

        .testimonial-card h5 {
            font-size: 1rem;
        }

        .testimonial-content-wrapper p {
            font-size: 0.9rem;
        }

        .quote-icon {
            font-size: 1.2rem;
        }
    }

    /* FAQ Section Styles */
    .faq-section {
        background: #f8f9fa;
    }

    .faq-heading {
        font-size: 2.5rem;
        font-weight: 700;
        color: #1e3c72;
        position: relative;
        display: inline-block;
        padding-bottom: 10px;
        margin-bottom: 0;
    }

    .faq-heading::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 50px;
        height: 3px;
        background: #007bff;
        border-radius: 2px;
    }

    .faq-item {
        border-bottom: 1px solid #e9ecef;
        margin-bottom: 10px;
    }

    .faq-header {
        padding: 0;
    }

    .faq-question {
        width: 100%;
        text-align: left;
        padding: 15px 20px;
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
        background: #fff;
        border: none;
        border-radius: 5px;
        transition: background 0.3s ease, color 0.3s ease;
        display: flex;
        justify-content: space-between;
        align-items: center;
        text-decoration: none;
    }

    .faq-question:hover {
        background: #f1f3f5;
        color: #007bff;
        text-decoration: none;
    }

    .faq-question.collapsed {
        background: #fff;
    }

    .faq-question:not(.collapsed) {
        background: #e7f1ff;
        color: #007bff;
    }

    .faq-icon {
        transition: transform 0.3s ease;
    }

    .faq-question:not(.collapsed) .faq-icon {
        transform: rotate(180deg);
    }

    .faq-body {
        padding: 15px 20px;
        font-size: 0.95rem;
        color: #666;
        background: #fff;
        border-top: 1px solid #e9ecef;
        border-radius: 0 0 5px 5px;
    }

    @media (max-width: 767px) {
        .faq-heading {
            font-size: 2rem;
        }

        .faq-question {
            font-size: 1rem;
            padding: 10px 15px;
        }

        .faq-body {
            font-size: 0.9rem;
            padding: 10px 15px;
        }
    }

    /* Trust Indicators Section */
    .trust-indicators {
        /* background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);  */
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        /* background-image: linear-gradient(230deg, rgb(10, 31, 68), rgb(2, 0, 36)) */
        position: relative;
        overflow: hidden;
        color: #fff;
        padding: 60px 0;
    }

    /* Background Pattern (Wave-like) */
    .trust-indicators::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.1)" fill-opacity="1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,112C672,96,768,96,864,112C960,128,1056,160,1152,160C1248,160,1344,128,1392,112L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') repeat-x bottom;
        opacity: 0.3;
        z-index: 0;
    }

    /* Ensure content is above the background pattern */
    .trust-indicators .container {
        position: relative;
        z-index: 1;
    }

    /* Heading */
    .trust-heading {
        font-size: 2.5rem;
        font-weight: 700;
        color: #fff;
        margin-bottom: 10px;
        text-transform: uppercase;
    }

    /* Subheading */
    .trust-subheading {
        font-size: 1.1rem;
        color: white !important;
        /* Light blue for contrast */
        margin-bottom: 0;
    }

    /* Stats Container */
    .stats-container {
        background: rgba(255, 255, 255, 0.1);
        /* Slight white overlay for contrast */
        border-radius: 15px;
        padding: 30px 15px;
    }

    /* Stat Item */
    .stat-item {
        position: relative;
        padding: 0 15px;
    }

    /* Dividers (Dashed Pattern) */
    .stat-item:not(:last-child)::after {
        content: '';
        position: absolute;
        right: 0;
        top: 10%;
        height: 80%;
        width: 1px;
        background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="1" height="10"><line x1="0" y1="0" x2="0" y2="10" stroke="rgba(255,255,255,0.3)" stroke-width="1" stroke-dasharray="2,2"/></svg>') repeat-y;
    }

    /* Stat Number */
    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: #fff;
        margin-bottom: 5px;
    }

    /* Stat Label */
    .stat-label {
        font-size: 0.95rem;
        color: white !important;
        font-weight: bold !important;
        background-color: #0056b3;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 0;
    }

    /* Responsive Adjustments */
    @media (max-width: 767px) {
        .trust-heading {
            font-size: 2rem;
        }

        .trust-subheading {
            font-size: 1rem;
        }

        .stat-number {
            font-size: 2rem;
        }

        .stat-label {
            font-size: 0.85rem;
        }

        .stat-item:not(:last-child)::after {
            display: none;
            /* Remove vertical dividers on mobile */
        }

        /* Add horizontal dividers on mobile */
        .col-6:nth-child(odd) .stat-item::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 15px;
            right: 15px;
            height: 1px;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="10" height="1"><line x1="0" y1="0" x2="10" y2="0" stroke="rgba(255,255,255,0.3)" stroke-width="1" stroke-dasharray="2,2"/></svg>') repeat-x;
        }
    }
</style>
<style>
    /* Industries Section */
    .industries-section {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        /* Light gradient background */
        position: relative;
        overflow: hidden;
        padding: 60px 0;
    }

    /* Background Pattern (Subtle Wave) */
    .industries-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(0,0,0,0.05)" fill-opacity="1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,112C672,96,768,96,864,112C960,128,1056,160,1152,160C1248,160,1344,128,1392,112L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') repeat-x bottom;
        opacity: 0.2;
        z-index: 0;
    }

    .industries-section .container {
        position: relative;
        z-index: 1;
    }

    /* Heading */
    .industries-heading {
        font-size: 2.5rem;
        font-weight: 700;
        color: #1e3c72;
        margin-bottom: 15px;
        position: relative;
        display: inline-block;
    }

    .industries-heading::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 0;
        width: 50px;
        height: 3px;
        background: #007bff;
        border-radius: 2px;
    }

    /* Description */
    .industries-description {
        font-size: 1.1rem;
        color: #666;
        margin-bottom: 0;
    }

    .btn-az-primary {
        background: #007bff;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        font-size: 1rem;
        color: #fff;
        transition: background 0.3s ease;
    }

    .btn-az-primary:hover {
        background: #0056b3;
    }

    /* Industry Card */
    .industry-card {
        background: #fff;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .industry-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }

    /* Industry Icon */
    .industry-icon {
        margin-bottom: 15px;
    }

    .industry-icon i {
        color: #007bff;
        /* Blue icon color */
        transition: color 0.3s ease;
    }

    .industry-card:hover .industry-icon i {
        color: #0056b3;
        /* Darker blue on hover */
    }

    /* Industry Title */
    .industry-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
    }

    /* Industry Description */
    .industry-description {
        font-size: 0.95rem;
        color: #666;
        flex-grow: 1;
    }

    /* Responsive Adjustments */
    @media (max-width: 767px) {
        .industries-heading {
            font-size: 2rem;
        }

        .industries-description {
            font-size: 1rem;
        }

        .industry-title {
            font-size: 1.1rem;
        }

        .industry-description {
            font-size: 0.9rem;
        }

        .industry-card {
            padding: 15px;
        }
    }

    /* Navbar Nav (Center Alignment) */
    .navbar-nav {
        /* background: transparent !important; */
        background-color: rgb(233, 233, 236);
    }

    /* Nav Links */
    .nav-link.nav-link-sm {
        font-weight: 700;
        /* Bold text */
        color: #1e3c72 !important;
        font-size: 1rem;
        transition: color 0.3s ease;
    }

    .nav-link.nav-link-sm:hover {
        color: #007bff !important;
    }

    /* Dropdown Toggle */
    .nav-link.dropdown-toggle::after {
        border-top-color: #1e3c72;
    }

    .nav-link.dropdown-toggle:hover::after {
        border-top-color: #007bff;
    }

    /* Dropdown Menu */
    .dropdown-menu {
        background: #fff;
        border: none;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
        padding: 10px 0;
    }

    /* Dropdown Header */
    .dropdown-header {
        font-size: 0.9rem;
        font-weight: 600;
        color: #1e3c72;
        text-transform: uppercase;
        padding: 10px 20px;
    }

    /* Dropdown Item */
    .dropdown-item {
        font-size: 0.95rem;
        color: #333;
        padding: 8px 20px;
        transition: background 0.3s ease, color 0.3s ease;
    }

    .dropdown-item:hover {
        background: #f1f3f5;
        color: #007bff;
    }

    /* Buttons (Partner With Us, Login) */
    .btn-outline-light {
        border: 1px solid #1e3c72 !important;
        color: white !important;
        background: transparent;
        transition: background 0.3s ease, color 0.3s ease, border-color 0.3s ease;
    }

    .btn-outline-light:hover {
        background: #007bff !important;
        color: #fff !important;
        border-color: #007bff !important;
    }

    /* Toggler Icon (Mobile) */
    .navbar-toggler {
        border: none;
    }

    .navbar-toggler-icon {
        background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(30, 60, 114, 1)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
    }

    /* Responsive Adjustments */
    @media (max-width: 991px) {
        .navbar-nav {
            background: #fff !important;
            padding: 15px;
            border-radius: 5px;
            margin-top: 10px;
        }

        .nav-link.nav-link-sm {
            font-size: 0.95rem;
            padding: 10px 15px;
        }

        .dropdown-menu {
            box-shadow: none;
            border: none;
            padding: 0;
            margin: 0;
        }

        .dropdown-item {
            padding: 8px 30px;
        }
    }

    /* Features Section */
    .features-section {
        background: #393A3E;
        position: relative;
        overflow: hidden;
        color: #fff;
        padding: 60px 0;
    }

    /* Background Pattern (Subtle Wave) */
    .features-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.05)" fill-opacity="1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,112C672,96,768,96,864,112C960,128,1056,160,1152,160C1248,160,1344,128,1392,112L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') repeat-x bottom;
        opacity: 0.2;
        z-index: 0;
    }

    /* Ensure content is above the background pattern */
    .features-section .container {
        position: relative;
        z-index: 1;
    }

    /* Sticky Content */
    .sticky-content {
        position: sticky;
        top: 30px;
    }

    /* Heading */
    .features-heading {
        font-size: 3rem;
        font-weight: 700;
        color: #2CA01C;
        margin-bottom: 20px;
        position: relative;
        display: inline-block;
    }

    .features-heading::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 0;
        width: 50px;
        height: 3px;
        background: #2CA01C;
        border-radius: 2px;
    }

    /* Description */
    .features-description {
        font-size: 1.1rem;
        color: #d1d1d1;
        margin-bottom: 0;
    }

    /* Feature Card */
    .feature-card {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        padding: 20px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
    }

    /* Feature Icon */
    .feature-icon {
        margin-bottom: 15px;
    }

    .feature-icon i {
        color: #2CA01C;
        transition: color 0.3s ease;
    }

    .feature-card:hover .feature-icon i {
        color: #1a6b0f;
    }

    /* Feature Title */
    .feature-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #fff;
        margin-bottom: 10px;
    }

    /* Feature Description */
    .feature-description {
        font-size: 0.95rem;
        color: #d1d1d1;
        flex-grow: 1;
    }

    /* Responsive Adjustments */
    @media (max-width: 767px) {
        .features-heading {
            font-size: 2rem;
        }

        .features-description {
            font-size: 1rem;
        }

        .feature-title {
            font-size: 1.1rem;
        }

        .feature-description {
            font-size: 0.9rem;
        }

        .feature-card {
            padding: 15px;
        }
    }

    /* Pricing Card */
    .pricing-card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
    }

    .pricing-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }

    /* Card Header */
    .card-header {
        background: #f8f9fa;
        padding: 15px;
        text-align: center;
        border-bottom: 1px solid #e9ecef;
    }

    .card-header h4 {
        font-size: 1.5rem;
        font-weight: 600;
        color: #1e3c72;
    }

    .card-body {
        padding: 20px;
    }

    /* Pricing Price */
    .pricing-price {
        font-size: 2rem;
        font-weight: 700;
        color: #1e3c72;
        margin-bottom: 20px;
    }

    .pricing-price span.text-muted {
        font-size: 1rem;
        font-weight: 400;
    }

    /* List Items */
    .list-unstyled li {
        font-size: 0.95rem;
        margin-bottom: 10px;
    }

    .list-unstyled .text-success {
        color: #28a745;
    }

    .list-unstyled .text-muted {
        color: #6c757d;
    }

    .list-unstyled i {
        font-size: 1rem;
    }

    .btn-primary {
        background: #007bff;
        border: none;
        border-radius: 5px;
        padding: 10px;
        font-size: 1rem;
        transition: background 0.3s ease;
    }

    .btn-primary:hover {
        background: #0056b3;
    }

    /* Responsive Adjustments */
    @media (max-width: 767px) {
        .pricing-price {
            font-size: 1.5rem;
        }

        .pricing-price span.text-muted {
            font-size: 0.9rem;
        }

        .list-unstyled li {
            font-size: 0.9rem;
        }

        .card-header h4 {
            font-size: 1.25rem;
        }
    }

    /* Sticky Top Nav (White Background) */
    .sticky-top-nav {
        background: #fff;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    /* Navbar (Transparent Background) */
    .navbar {
        /* background: transparent !important; */
        /* background-color: rgb(233, 233, 236); */
        background-color: white;
    }

    /* Navbar Nav (Center Alignment) */
    .navbar-nav {
        background: transparent !important;
    }

    /* Nav Links */
    .nav-link.nav-link-sm {
        font-weight: 700;
        color: #1e3c72 !important;
        font-size: 1rem;
        transition: color 0.3s ease;
    }

    .nav-link.nav-link-sm:hover {
        color: #007bff !important;
    }

    /* Dropdown Toggle */
    .nav-link.dropdown-toggle::after {
        border-top-color: #1e3c72;
    }

    .nav-link.dropdown-toggle:hover::after {
        border-top-color: #007bff;
    }


    /* Center the dropdown content within the container */
    .dropdown-content-wrapper {
        max-width: 1140px;
        margin: 0 auto;
        padding: 0 15px;
    }

    /* Dropdown Header */
    .dropdown-header {
        font-size: 0.9rem;
        font-weight: 600;
        color: #1e3c72;
        text-transform: uppercase;
        padding: 10px 20px;
    }

    /* Dropdown Item */
    .dropdown-item {
        font-size: 0.95rem;
        color: #333;
        padding: 8px 20px;
        transition: background 0.3s ease, color 0.3s ease;
    }

    .dropdown-item:hover {
        background: #f1f3f5;
        color: #007bff;
    }

    /* Buttons (Partner With Us, Login) */
    .nav-item .nav-link-sm[href*='business.partnership'],
    .nav-item .nav-link-sm[href*='login'] {
        border: 1px solid #1e3c72 !important;
        color: #1e3c72 !important;
        background: transparent;
        padding: 8px 15px;
        border-radius: 5px;
        transition: background 0.3s ease, color 0.3s ease, border-color 0.3s ease;
    }

    .nav-item .nav-link-sm[href*='business.partnership']:hover,
    .nav-item .nav-link-sm[href*='login']:hover {
        background: #007bff !important;
        color: #fff !important;
        border-color: #007bff !important;
    }

    /* Toggler Icon (Mobile) */
    .navbar-toggler {
        border: none;
    }

    .navbar-toggler-icon {
        background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(30, 60, 114, 1)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
    }

    /* Responsive Adjustments */
    @media (max-width: 991px) {
        .navbar-nav {
            background: #fff !important;
            padding: 15px;
            border-radius: 5px;
            margin-top: 10px;
        }

        .nav-link.nav-link-sm {
            font-size: 0.95rem;
            padding: 10px 15px;
        }
    }
</style>

<style>
    /* Dropdown Header */
    .dropdown-header {
        font-size: 0.95rem;
        font-weight: 700;
        color: #1e3c72;
        text-transform: uppercase;
        padding: 10px 20px;
        border-bottom: 1px solid rgba(0, 123, 255, 0.1);
        margin-bottom: 5px;
    }

    /* Add spacing between categories in the same column */
    .dropdown-header.mt-3 {
        margin-top: 1.5rem;
    }

    /* Dropdown Item */
    .dropdown-item {
        font-size: 0.9rem;
        color: #333;
        padding: 8px 20px;
        border-radius: 4px;
        transition: background 0.3s ease, color 0.3s ease, transform 0.2s ease;
        position: relative;
        white-space: nowrap;
    }

    .dropdown-item:hover {
        background: #007bff !important;
        color: #fff !important;
        transform: translateX(5px);
    }

    /* Add a subtle icon before each dropdown item */
    .dropdown-item::before {
        content: '\f105';
        /* FontAwesome angle-right icon */
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        margin-right: 8px;
        font-size: 0.8rem;
        color: #007bff;
        opacity: 0.7;
        transition: color 0.3s ease;
    }

    .dropdown-item:hover::before {
        color: #fff;
        /* White icon on hover */
        opacity: 1;
    }

    /* Responsive Adjustments */
    @media (max-width: 991px) {
        .dropdown-menu-wide {
            width: 100% !important;
            /* Full width of parent on mobile */
            position: static !important;
            box-shadow: none !important;
            border: none !important;
            padding: 0 !important;
            margin: 0 !important;
            background: #fff !important;
            overflow-x: hidden;
        }

        .dropdown-content-wrapper {
            max-width: 100% !important;
            min-width: 100% !important;
            padding: 0 !important;
        }

        .dropdown-header {
            font-size: 0.9rem;
            padding: 8px 30px;
            border-bottom: none;
        }

        .dropdown-item {
            padding: 8px 30px;
            border-radius: 0;
            white-space: normal;
        }

        .dropdown-item::before {
            content: none;
        }

        .dropdown-item:hover {
            transform: none;
            background: #f1f3f5 !important;
            color: #007bff !important;
        }
    }
</style>
{{-- <style>
    .dropdown-menu-wide {
        width: 100vw !important;
        position: absolute !important;
        left: 0 !important;
        margin: 0 !important;
        border: none !important;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15) !important;
        border-radius: 0 !important;
        background: linear-gradient(145deg, rgba(255, 255, 255, 0.85), rgba(248, 249, 250, 0.85)) !important;
        padding: 20px 0 !important;
        overflow-x: auto;
        scroll-behavior: smooth;
    }

    .dropdown-content-wrapper {
        max-width: 1140px;
        margin: 0 auto;
        padding: 0 15px;
    }

    .dropdown-content-wrapper .row {
        display: flex;
        flex-wrap: nowrap;
    }

    .dropdown-content-wrapper .col-md-3 {
        flex: 0 0 25%;
        max-width: 25%;
    }

    .dropdown-header {
        font-size: 0.95rem;
        font-weight: 700;
        color: #1e3c72;
        text-transform: uppercase;
        padding: 10px 20px;
        border-bottom: 1px solid rgba(0, 123, 255, 0.1);
        margin-bottom: 5px;
    }

    .dropdown-header.mt-3 {
        margin-top: 1.5rem;
    }

    .dropdown-item {
        font-size: 0.9rem;
        color: #333;
        padding: 8px 20px;
        border-radius: 4px;
        transition: background 0.3s ease, color 0.3s ease, transform 0.2s ease;
        position: relative;
        white-space: nowrap;
    }

    .dropdown-item:hover {
        background: #007bff !important;
        color: #fff !important;
        transform: translateX(5px);
    }

    .dropdown-item::before {
        content: '\f105';
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        margin-right: 8px;
        font-size: 0.8rem;
        color: #007bff;
        opacity: 0.7;
        transition: color 0.3s ease;
    }

    .dropdown-item:hover::before {
        color: #fff;
        opacity: 1;
    }

    @media (max-width: 991px) {
        .dropdown-menu-wide {
            width: 100% !important;
            position: static !important;
            box-shadow: none !important;
            border: none !important;
            padding: 0 !important;
            margin: 0 !important;
            background: #fff !important;
            overflow-x: hidden;
        }

        .dropdown-content-wrapper {
            max-width: 100% !important;
            padding: 0 !important;
        }

        .dropdown-content-wrapper .row {
            display: block;
        }

        .dropdown-content-wrapper .col-md-3 {
            flex: 0 0 100%;
            max-width: 100%;
        }

        .dropdown-header {
            font-size: 0.9rem;
            padding: 8px 30px;
            border-bottom: none;
        }

        .dropdown-item {
            padding: 8px 30px;
            border-radius: 0;
            white-space: normal;
        }

        .dropdown-item::before {
            content: none;
        }

        .dropdown-item:hover {
            transform: none;
            background: #f1f3f5 !important;
            color: #007bff !important;
        }
    }
</style> --}}
