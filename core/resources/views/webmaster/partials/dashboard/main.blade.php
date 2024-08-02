<!DOCTYPE html>
<html lang="en">

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

    <!-- Twitter -->
    <meta name="twitter:site" content="@themepixels">
    <meta name="twitter:creator" content="@themepixels">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Azia">
    <meta name="twitter:description" content="Responsive Bootstrap 4 Dashboard Template">
    <meta name="twitter:image" content="http://themepixels.me/azia/img/azia-social.png">

    <!-- Facebook -->
    <meta property="og:url" content="http://themepixels.me/azia">
    <meta property="og:title" content="Azia">
    <meta property="og:description" content="Responsive Bootstrap 4 Dashboard Template">

    <meta property="og:image" content="http://themepixels.me/azia/img/azia-social.png">
    <meta property="og:image:secure_url" content="http://themepixels.me/azia/img/azia-social.png">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="600">

    <!-- Meta -->
    <meta name="description" content="Responsive Bootstrap 4 Dashboard Template">
    <meta name="author" content="ThemePixels">

    <title>@yield('title') - {{ $gs->system_name }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('assets/uploads/generals/' . $gs->favicon) }}">

    <!-- vendor css -->
    <link href="{{ asset('assets/backend/dash/lib/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/backend/dash/lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/backend/dash/lib/typicons.font/typicons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/backend/dash/lib/jqvmap/jqvmap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/backend/dash/lib/amazeui-datetimepicker/css/amazeui.datetimepicker.css') }}"
        rel="stylesheet">
    <link href="{{ asset('assets/backend/dash/lib/jquery-simple-datetimepicker/jquery.simple-dtpicker.css') }}"
        rel="stylesheet">
    <link href="{{ asset('assets/backend/dash/lib/pickerjs/picker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/backend/dash/lib/select2/css/select2.min.css') }}" rel="stylesheet">
     <link href="{{ asset('assets/backend/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- azia CSS -->
    <link rel="stylesheet" href="{{ asset('assets/backend/dash/css/azia.css') }}">
    <!--charts-->
     <link href="{{asset('assets/backend/dash/lib/morris.js/morris.css')}}" rel="stylesheet">
     @yield('css')
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highcharts/8.2.0/highcharts.css">
       <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css">
     <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">
       <!-- Select2 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.min.css">


</head>
<style>
    .modal-content {
    position: relative;
    display: flex;
    flex-direction: column;
    width: 100%;
    pointer-events: auto;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid rgba(0, 0, 0, 0.2);
    border-radius: 0.3rem;
    outline: 0;
}
</style>

<body class="az-body az-light">
    <!--sidebar-->
    @include('webmaster.partials.dashboard.sidebar')
    <div class="az-content az-content-dashboard-six">
        <!--top nav bar-->
        @include('webmaster.partials.dashboard.topbar')


        <!-- main body content-->
        <div class="az-content-body az-content-body-dashboard-six">
            @yield('content')
        </div><!-- az-content-body -->

        <!--footer-->
        @include('webmaster.partials.dashboard.footer')
    </div><!-- az-content -->

    <script>
        let baseurl = '{{ url('/') }}';
    </script>
    <script src="{{ asset('assets/backend/dash/lib/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/backend/dash/lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/backend/dash/lib/ionicons/ionicons.js') }}"></script>
    <script src="{{ asset('assets/backend/dash/lib/jquery.flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('assets/backend/dash/lib/jquery.flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('assets/backend/dash/lib/peity/jquery.peity.min.js') }}"></script>

    <script src="{{ asset('assets/backend/dash/js/azia.js') }}"></script>
    <script src="{{ asset('assets/backend/dash/js/chart.flot.sampledata.js') }}"></script>
    <script src="{{ asset('assets/backend/dash/lib/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <script src="{{ asset('assets/backend/dash/lib/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js') }}"></script>
    <script src="{{ asset('assets/backend/dash/lib/jquery-simple-datetimepicker/jquery.simple-dtpicker.js') }}"></script>
    <script src="{{ asset('assets/backend/dash/lib/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <script src="{{ asset('assets/backend/dash/lib/pickerjs/picker.min.js') }}"></script>
    <script src="{{ asset('assets/backend/dash/lib/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/custom/functions.js') }}"></script>
    <script src="{{ asset('assets/backend/js/bootstrap-datepicker.min.js') }}"></script>
    <!--charts-->
    <script src="{{asset('assets/backend/dash/lib/raphael/raphael.min.js')}}"></script>
    <script src="{{asset('assets/backend/dash/lib/morris.js/morris.min.js')}}"></script>
    <script src="{{asset('assets/backend/dash/js/chart.morris.js')}}"></script>
    <script src="{{asset('assets/backend/dash/lib/jquery.flot/jquery.flot.js')}}"></script>
    <script src="{{asset('assets/backend/dash/lib/jquery.flot/jquery.flot.pie.js')}}"></script>
    <script src="{{asset('assets/backend/dash/lib/jquery.flot/jquery.flot.resize.js')}}"></script>
    <script src="{{asset('assets/backend/dash/js/chart.flot.js')}}"></script>
    <!-- Toastr JS -->

    <script>
        $(function() {
            'use strict'

            if ($('.az-iconbar .nav-link.active').length) {
                var targ = $('.az-iconbar .nav-link.active').attr('href');
                $(targ).addClass('show');

                if (window.matchMedia('(min-width: 1200px)').matches) {
                    $('.az-iconbar-aside').addClass('remove');
                }

                if (window.matchMedia('(min-width: 992px)').matches &&
                    window.matchMedia('(max-width: 1199px)').matches) {
                    $('.az-iconbar .nav-link.active').removeClass('active');
                }
            }

            $('.az-iconbar .nav-link').on('click', function(e) {
                e.preventDefault();

                $(this).addClass('active');
                $(this).siblings().removeClass('active');

                $('.az-iconbar-aside').addClass('show');

                var targ = $(this).attr('href');
                $(targ).addClass('show');
                $(targ).siblings().removeClass('show');
            });

            $('.az-iconbar-body .with-sub').on('click', function(e) {
                e.preventDefault();
                $(this).parent().addClass('show');
                $(this).parent().siblings().removeClass('show');
            });

            $('.az-iconbar-toggle-menu').on('click', function(e) {
                e.preventDefault();
                if (window.matchMedia('(min-width: 992px)').matches) {
                    $('.az-iconbar .nav-link.active').removeClass('active');
                    $('.az-iconbar-aside').removeClass('show');
                } else {
                    $('body').removeClass('az-iconbar-show');
                }
            })

            $('#azIconbarShow').on('click', function(e) {
                e.preventDefault();
                $('body').toggleClass('az-iconbar-show');
            });


            // $.plot('#flotChart2', [{
            //     data: flotSampleData1,
            //     color: '#969dab'
            // }], {
            //     series: {
            //         shadowSize: 0,
            //         lines: {
            //             show: true,
            //             lineWidth: 2,
            //             fill: true,
            //             fillColor: {
            //                 colors: [{
            //                     opacity: 0
            //                 }, {
            //                     opacity: 0.2
            //                 }]
            //             }
            //         }
            //     },
            //     grid: {
            //         borderWidth: 0,
            //         labelMargin: 0
            //     },
            //     yaxis: {
            //         show: false
            //     },
            //     xaxis: {
            //         show: false
            //     }
            // });


            // // Mini Bar charts
            // $('.peity-bar').peity('bar');
        });
    </script>

    <script>
      $(function(){
        'use strict'

        // Toggle Switches
        $('.az-toggle').on('click', function(){
          $(this).toggleClass('on');
        })

      });
    </script>
    <script></script>
     <script>
        $(document).ready(function(){
            // $('[data-toggle="tooltip"]').tooltip();
            $('[data-toggle="tooltip-primary"]').tooltip({
            template: '<div class="tooltip tooltip-primary" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
            });
        });
    </script>
    @include('webmaster.partials.notify')
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/8.2.0/highcharts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/8.2.0/modules/exporting.js"></script>
     <!-- Include Moment.js from CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
       <!-- Bootstrap Datepicker JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <!-- SweetAlert2 JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.all.min.js"></script>
    <script>
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
    </script>
  <script src="{{asset('assets/backend/js/plotly.js')}}"></script>
      {{-- @include('webmaster.partials.javascripts') --}}
    @yield('scripts')
</body>

</html>
