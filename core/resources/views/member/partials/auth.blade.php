<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('assets/uploads/generals/'. $gs->favicon ) }}" />
    <title>@yield('title') - {{ $gs->system_name }}</title>
    <link href="{{ asset('assets/member/css/bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/member/css/style.css') }}" rel="stylesheet"/>
    @stack('styles')
</head>

<body class="dashboard">
    <div id="main-wrapper">
      <div class="authincation">
        <div class="container ">
          <div class="row justify-content-center align-items-center">
            @yield('content')
          </div>
        </div>
      </div>
    </div>

    <script src="{{ asset('assets/member/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/member/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/member/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/member/js/functions.js') }}"></script>
    @include('webmaster.partials.notify')
    @yield('scripts')
</body>
</html> 