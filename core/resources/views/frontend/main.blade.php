<!doctype html>
<html lang="en">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ $data->meta_title }}</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
@include('frontend.seo')
<link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/uploads/generals/'. $gs->favicon ) }}">

<!-- FAVICON FILES -->
<link href="assets/images/icons/apple-touch-icon-144-precomposed.png" rel="apple-touch-icon" sizes="144x144">
<link href="assets/images/icons/apple-touch-icon-120-precomposed.png" rel="apple-touch-icon" sizes="120x120">
<link href="assets/images/icons/apple-touch-icon-76-precomposed.png" rel="apple-touch-icon" sizes="76x76">
<link href="assets/images/icons/favicon.png" rel="shortcut icon">

<!-- CSS FILES -->
<link rel="stylesheet" href="{{ asset('assets/frontend/css/bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('assets/frontend/fonts/iconfonts.css') }}">
<link rel="stylesheet" href="{{ asset('assets/frontend/css/plugins.css') }}">
<link rel="stylesheet" href="{{ asset('assets/frontend/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('assets/frontend/css/responsive.css') }}">
<link rel="stylesheet" href="{{ asset('assets/frontend/css/color.css') }}">

<script type="application/ld+json">
       {
         "@context": "https://schema.org",
         "@type": "WebSite",
         "name": "{{ $data->meta_title }}",
         "description": "{{ $data->meta_description }}",
         "url": "{{ url()->current() }}",
         "image": "{{ asset('assets/uploads/pages/'. $data->meta_photo ) }}",
         "author": {
           "@type": "Person",
           "name": "Author Name"
         },
         "datePublished": "{{ $data->updated_at == NULL ? $data->created_at->tz('UTC')->toAtomString() : $data->updated_at->tz('UTC')->toAtomString() }}",
         "dateModified": "{{ $data->updated_at == NULL ? $data->created_at->tz('UTC')->toAtomString() : $data->updated_at->tz('UTC')->toAtomString() }}"
       }
     </script>
</head>
<body>
<div> 
  @include('frontend.header')
   <div id="dtr-main-content"> 
      @yield('content')
      @include('frontend.footer')
    </div>
</div>

<script> let base_url = '{{ url('/') }}'; </script>
<script src="{{ asset('assets/frontend/js/jquery.min.js') }}"></script> 
<script src="{{ asset('assets/frontend/js/bootstrap.min.js') }}"></script> 
<script src="{{ asset('assets/frontend/js/plugins.js') }}"></script> 
<script src="{{ asset('assets/frontend/js/custom.js') }}"></script>
<script src="{{ asset('assets/frontend/js/function.js') }}"></script>
      @include('frontend.notify')
</body>
</html>