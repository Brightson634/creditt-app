<footer id="dtr-footer" >
   <div class="container dtr-mb-20">
      <div class="row"> 
         <div class="col-12 col-lg-4 col-md-4 mx-auto"> 
            <a href="{{ route('home') }}" class="d-block dtr-mb-15">
               <img src="{{ asset('assets/uploads/generals/'. $gs->footerlogo ) }}" width="180"  alt="logo">
            </a>
            <p>{{ nl2br($data->description) }}</p>
         </div>
         <div class="col-6 col-lg-3 col-md-3">
            <h4 class="color-green">Company</h4>
            <ul class="dtr-list-simple">
               <li><a href="#" class="dtr-styled-link">Features</a></li>
               <li><a href="#" class="dtr-styled-link">Plan</a></li>
               <li><a href="#" class="dtr-styled-link">Blog</a></li>
               <li><a href="#" class="dtr-styled-link">Contact</a></li>
            </ul>
         </div>
         <div class="col-6 col-lg-3 col-md-3">
            <h4 class="color-green">Support</h4>
            <ul class="dtr-list-simple">
               <li><a href="#" class="dtr-styled-link">Careers</a></li>
               <li><a href="#" class="dtr-styled-link">Help</a></li>
               <li><a href="#" class="dtr-styled-link">Privacy Policy</a></li>
               <li><a href="#" class="dtr-styled-link">Terms</a></li>
            </ul>
         </div>
      </div>
   </div>
   <div class="container">
      <div class="row cs-copyright justify-content-md-center">
         <div class="col-md-6 mx-auto">
            <div class=" text-center">
               <p>Copyright © {{ date('Y') }} {{ $data->copyright }}</p>
            </div>
         </div>
      </div>
   </div>
</footer>