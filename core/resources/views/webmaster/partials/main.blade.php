<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>@yield('title') - {{ $gs->system_name }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

   <link rel="shortcut icon" href="{{ asset('assets/uploads/generals/'. $gs->favicon ) }}">
   <link href="{{ asset('assets/backend/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
   <link href="{{ asset('assets/backend/css/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
   <link href="{{ asset('assets/backend/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
   <link href="{{ asset('assets/backend/css/bootstrap.css') }}" rel="stylesheet" type="text/css" />
   <link href="{{ asset('assets/backend/css/icons.css') }}" rel="stylesheet" type="text/css" />
   <link href="{{ asset('assets/backend/css/theme.css') }}" rel="stylesheet" type="text/css" />

    </head>

    <body>

        <!-- Begin page -->
        <div id="layout-wrapper">
            @include('webmaster.partials.topbar')

            @include('webmaster.partials.sidebar')

            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
        <!-- Overlay-->
        <div class="menu-overlay"></div>


        <!-- jQuery  -->
        <script> let baseurl = '{{ url('/') }}'; </script>
        <script src="{{ asset('assets/backend/js/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/backend/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/backend/js/metismenu.min.js') }}"></script>
        <script src="{{ asset('assets/backend/js/simplebar.min.js') }}"></script>
        <script src="{{ asset('assets/backend/js/select2.min.js') }}"></script>
        <script src="{{ asset('assets/backend/js/bootstrap-datepicker.min.js') }}"></script>
        <script src="{{ asset('assets/backend/js/theme.js') }}"></script>
        <script src="{{ asset('assets/backend/js/custom/functions.js') }}"></script>
        <script>
         function goBack() {
              window.history.back();
          }
         $(document).ready(function () {
            "use strict";
            if ($(".nav-clock")[0]) {
               setInterval(function () {
                  var now = new Date();
                  var seconds = now.getSeconds();
                  $(".time-sec").html((seconds < 10 ? "0" : "") + seconds);
                  var minutes = now.getMinutes();
                  $(".time-min").html((minutes < 10 ? "0" : "") + minutes);
                  var hours = now.getHours();
                  $(".time-hours").html((hours < 10 ? "0" : "") + hours);
                  var options = { year: 'numeric', month: 'long', day: 'numeric' };
                  var formattedDate = now.toLocaleDateString(undefined, options);
                  $(".date").html(formattedDate);
               }, 1000);
            }
         });
      </script>
        @include('webmaster.partials.notify')

    @yield('scripts')
    </body>

</html>
