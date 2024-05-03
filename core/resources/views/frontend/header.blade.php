
    <div class="dtr-responsive-header fixed-top">
        <div class="container"> 
            <a href="{{ route('home') }}"><img src="{{ asset('assets/uploads/generals/'. $gs->logo ) }}" width="160" alt="logo"></a> 
            <button id="dtr-menu-button" class="dtr-hamburger" type="button"><span class="dtr-hamburger-lines-wrapper"><span class="dtr-hamburger-lines"></span></span></button>
        </div>
        <div class="dtr-responsive-header-menu"></div>
    </div>
    <header id="dtr-header-global" class="fixed-top bg-white">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between"> 
                
                <!-- header left starts -->
                <div class="dtr-header-left"> 
                    
                    <!-- logo --> 
                    <a class="logo-default dtr-scroll-link" href="#home"><img src="{{ asset('assets/uploads/generals/'. $gs->logo ) }}" width="160" alt="logo"></a> 
                    
                    <!-- logo on scroll --> 
                    <a class="logo-alt dtr-scroll-link" href="#home"><img src="{{ asset('assets/uploads/generals/'. $gs->logo ) }}" width="160"></a> 
                    <!-- logo on scroll ends --> 
                    
                </div>
                <!-- header left ends --> 
                
                <!-- menu starts-->
                <div class="main-navigation navbar navbar-expand-lg ml-auto">
                    <ul class="dtr-scrollspy navbar-nav dtr-nav dark-nav-on-load dark-nav-on-scroll">
                        <li class="nav-item"> <a class="nav-link active" href="#home">Home</a> </li>
                        <li class="nav-item"> <a class="nav-link" href="#features">About Us</a> </li>
                        <li class="nav-item"> <a class="nav-link" href="#plans">Saving Plans</a> </li>
                        <li class="nav-item"> <a class="nav-link" href="#faq">FAQs</a> </li>
                        <li class="nav-item"> <a class="nav-link" href="#contact">Contact Us</a> </li>
                    </ul>
                </div>
                <div class="dtr-header-right"> <a href="{{ route('member.login') }}" target="_blank" class="btn btn-theme">Member Portal</a> </div>
                
            </div>
        </div>
    </header>