   <meta name="robots" content="index, follow" />
   <!-- <link href="https://www.google.com/ping?sitemap={{ route('sitemap.index') }}"/>-->
    <meta name="googlebot" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1" />
    <meta name="bingbot" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1" />

   <meta name="title" Content="{{ $data->meta_title }}">
   <meta name="description" content="{{ $data->meta_description }}">
   <meta name="keywords" content="{{ $data->meta_keyword }}">
   <link rel="shortcut icon" href="" type="image/x-icon">
   <link rel="apple-touch-icon" href="{{ asset('assets/uploads/generals/'. $gs->logo ) }}">
   <meta name="apple-mobile-web-app-capable" content="yes">
   <meta name="apple-mobile-web-app-status-bar-style" content="black">
   <meta name="apple-mobile-web-app-title" content="{{ $data->meta_title }}">
   <meta itemprop="name" content="{{ $data->meta_title }}">
   <meta itemprop="description" content="{{ $data->meta_description }}">
   <meta itemprop="image" content="{{ asset('assets/uploads/sections/'. $data->meta_photo ) }}">
   <meta name="author" content="{{ $data->company_name }}"/>
   <meta property="og:locale" content="en_US"/>
   <meta property="og:site_name" content="{{ $data->company_name }}">
   <meta property="og:type" content="website">
   <meta property="og:title" content="{{ $data->meta_title }}">
   <meta property="og:description" content="{{ $data->meta_description }}">
   <meta property="og:image" content="{{ asset('assets/uploads/sections/'. $data->meta_photo ) }}"/>
   <meta property="og:image:url" content="{{ asset('assets/uploads/sections/'. $data->meta_photo ) }}" />
   <meta property="og:image:type" content="" />
   <meta property="og:image:width" content="" />
   <meta property="og:image:height" content="" />
   <meta property="og:url" content="{{ url()->current() }}">
   <meta property="fb:app_id" content=""/>
   <meta name="twitter:card" content="summary_large_image">
   <meta name="twitter:site" content="@Sese Systems"/>
   <meta name="twitter:title" content="{{ $data->meta_title }}"/>
   <meta name="twitter:description" content="{{ $data->meta_description }}"/>
   <meta name="twitter:image" content="{{ asset('assets/uploads/sections/'. $data->meta_photo ) }}"/>

   <link rel="canonical" href="{{ url()->current() }}"/>
   <link rel="alternate" href="{{ url()->current() }}" hreflang="en_US"/>
