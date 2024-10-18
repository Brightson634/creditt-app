<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>{{ $page_title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('assets/uploads/site/'. $gs->favicon ) }}">
    <link href="{{ asset('assets/backend/css/bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/backend/css/icons.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/backend/css/theme.css') }}" rel="stylesheet" type="text/css" />

</head>

<body>
  @yield('content')
    
    <script src="{{ asset('assets/backend/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/metismenu.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/theme.js') }}"></script>
    <script src="{{ asset('assets/backend/js/custom/functions.js') }}"></script>
    @yield('scripts')
</body>

</html>