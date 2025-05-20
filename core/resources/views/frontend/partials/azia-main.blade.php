@php
    $navbar_btn['text'] = 'Try For Free';
    $navbar_btn['link'] = route('register');
    if(isset($__site_details['btns']) && isset($__site_details['btns']['navbar']) && !empty($__site_details['btns']['navbar']['text'])) {
        $navbar_btn['text'] = $__site_details['btns']['navbar']['text'] ?? 'Try For Free';
    }
    if(isset($__site_details['btns']) && isset($__site_details['btns']['navbar']) && !empty($__site_details['btns']['navbar']['link'])) {
        $navbar_btn['link'] = $__site_details['btns']['navbar']['link'] ?? route('register');
    }

    $hero_btn['text'] = 'Start your Free Trial';
    $hero_btn['link'] = route('register');
    if(isset($__site_details['btns']) && isset($__site_details['btns']['hero']) && !empty($__site_details['btns']['hero']['text'])) {
        $hero_btn['text'] = $__site_details['btns']['hero']['text'] ?? 'Start your Free Trial';
    }
    if(isset($__site_details['btns']) && isset($__site_details['btns']['hero']) && !empty($__site_details['btns']['hero']['link'])) {
        $hero_btn['link'] = $__site_details['btns']['hero']['link'] ?? route('register');
    }

    $industry_btn['text'] = 'Get Started';
    $industry_btn['link'] = route('register');
    if(isset($__site_details['btns']) && isset($__site_details['btns']['industry']) && !empty($__site_details['btns']['industry']['text'])) {
        $industry_btn['text'] = $__site_details['btns']['industry']['text'] ?? 'Get Started';
    }
    if(isset($__site_details['btns']) && isset($__site_details['btns']['industry']) && !empty($__site_details['btns']['industry']['link'])) {
        $industry_btn['link'] = $__site_details['btns']['industry']['link'] ?? route('register');
    }

    //partner with us button
    $partnership_btn['text'] = 'Partner With Us';
    $partnership_btn['link'] = route('partnership');
    if(isset($details['btns']) && isset($__site_details['btns']['industry']) && !empty($__site_details['btns']['industry']['text'])) {
        $partnership_btn['text'] = $__site_details['btns']['partnership']['text'] ?? 'Partner With Us';
    }
    if(isset($details['btns']) && isset($__site_details['btns']['partnership']) && !empty($__site_details['btns']['partnership']['link'])) {
        $partnership_btn['link'] = $__site_details['btns']['partnership']['link'] ?? route('partnership');
    }

    $cta_btn['text'] = 'Try Now';
    $cta_btn['link'] = route('register');
    if(isset($__site_details['btns']) && isset($__site_details['btns']['cta']) && !empty($__site_details['btns']['cta']['text'])) {
        $cta_btn['text'] = $__site_details['btns']['cta']['text'] ?? 'Try Now';
    }
    if(isset($__site_details['btns']) && isset($__site_details['btns']['cta']) && !empty($__site_details['btns']['cta']['link'])) {
        $cta_btn['link'] = $__site_details['btns']['cta']['link'] ?? route('register');
    }
@endphp

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-130582519-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'UA-130582519-1');
    </script>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Meta -->
    <meta name="description" content="">
    <meta name="author" content="ThemePixels">
    <title>@yield('title') | {{ config('app.name', 'Nimora ERP') }}</title>
    <!-- vendor css -->
    <link href=" {{ asset('assets/backend/dash/lib/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href=" {{ asset('assets/backend/dash/lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <link href=" {{ asset('assets/backend/dash/lib/typicons.font/typicons.css') }}" rel="stylesheet">
    <!-- azia CSS -->
    <link href=" {{ asset('assets/backend/dash/lib/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
    <link href=" {{ asset('assets/backend/dash/lib/dropzone/dropzone.min.css') }}" rel="stylesheet">
    <link href=" {{ asset('assets/backend/dash/lib/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href=" {{ asset('assets/backend/dash/lib/pace/pace.css') }}" rel="stylesheet">
    <link rel="stylesheet" href=" {{ asset('assets/backend/dash/css/azia.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!--include additional styling-->
    @include('frontend.partials.azia-css')
    @yield('css')
</head>

<body>
    @inject('request', 'Illuminate\Http\Request')
    <!-- navbar header -->
    @if (!empty($login))
    @else
        @include('frontend.partials.azia-header')
    @endif
    <!-- Main Content Wrapper -->
    <div class="content-wrapper">
        @yield('content')
    </div>
    <!--include footer-->
    @if (!empty($login))
    @else
        @include('frontend.partials.azia-footer')
    @endif
    <!--scripts-->
    @include('frontend.partials.azia-scripts')
    @yield('scripts')
</body>

</html>
