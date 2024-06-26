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

</head>

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
    <script>
        $(function() {
            'use strict'

            if ($('.az-iconbar .nav-link.active').length) {
                var targ = $('.az-iconbar .nav-link.active').attr('href');
                $(targ).addClass('show');

                if (window.matchMedia('(min-width: 1200px)').matches) {
                    $('.az-iconbar-aside').addClass('show');
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


            $.plot('#flotChart2', [{
                data: flotSampleData1,
                color: '#969dab'
            }], {
                series: {
                    shadowSize: 0,
                    lines: {
                        show: true,
                        lineWidth: 2,
                        fill: true,
                        fillColor: {
                            colors: [{
                                opacity: 0
                            }, {
                                opacity: 0.2
                            }]
                        }
                    }
                },
                grid: {
                    borderWidth: 0,
                    labelMargin: 0
                },
                yaxis: {
                    show: false
                },
                xaxis: {
                    show: false
                }
            });


            // Mini Bar charts
            $('.peity-bar').peity('bar');
        });
    </script>
    <script>
      $(function(){
        'use strict'

        // Toggle Switches
        $('.az-toggle').on('click', function(){
          $(this).toggleClass('on');
        })

        // Input Masks
        $('#dateMask').mask('99/99/9999');
        $('#phoneMask').mask('(999) 999-9999');
        $('#phoneExtMask').mask('(999) 999-9999? ext 99999');
        $('#ssnMask').mask('999-99-9999');

        // Color picker
        // $('#colorpicker').spectrum({
        //   color: '#17A2B8'
        // });

        // $('#showAlpha').spectrum({
        //   color: 'rgba(23,162,184,0.5)',
        //   showAlpha: true
        // });

        // $('#showPaletteOnly').spectrum({
        //     showPaletteOnly: true,
        //     showPalette:true,
        //     color: '#DC3545',
        //     palette: [
        //         ['#1D2939', '#fff', '#0866C6','#23BF08', '#F49917'],
        //         ['#DC3545', '#17A2B8', '#6610F2', '#fa1e81', '#72e7a6']
        //     ]
        // });

        // Datepicker
        $('.fc-datepicker').datepicker({
          showOtherMonths: true,
          selectOtherMonths: true
        });

        $('#datepickerNoOfMonths').datepicker({
          showOtherMonths: true,
          selectOtherMonths: true,
          numberOfMonths: 2
        });

        // AmazeUI Datetimepicker
        $('#datetimepicker').datetimepicker({
          format: 'yyyy-mm-dd hh:ii',
          autoclose: true
        });

        // jQuery Simple DateTimePicker
        $('#datetimepicker2').appendDtpicker({
          closeOnSelected: true,
          onInit: function(handler) {
            var picker = handler.getPicker();
            $(picker).addClass('az-datetimepicker');
          }
        });

        // new Picker(document.querySelector('#datetimepicker3'), {
        //   headers: true,
        //   format: 'MMMM DD, YYYY HH:mm',
        //   text: {
        //     title: 'Pick a Date and Time',
        //     year: 'Year',
        //     month: 'Month',
        //     day: 'Day',
        //     hour: 'Hour',
        //     minute: 'Minute'
        //   },
        // });


        // $(document).ready(function(){
        //   $('.select2').select2({
        //     placeholder: 'Choose one',
        //     searchInputPlaceholder: 'Search'
        //   });

        //   $('.select2-no-search').select2({
        //     minimumResultsForSearch: Infinity,
        //     placeholder: 'Choose one'
        //   });
        // });

        // $('.rangeslider1').ionRangeSlider();

        // $('.rangeslider2').ionRangeSlider({
        //     min: 100,
        //     max: 1000,
        //     from: 550
        // });

        // $('.rangeslider3').ionRangeSlider({
        //     type: 'double',
        //     grid: true,
        //     min: 0,
        //     max: 1000,
        //     from: 200,
        //     to: 800,
        //     prefix: '$'
        // });

        // $('.rangeslider4').ionRangeSlider({
        //     type: 'double',
        //     grid: true,
        //     min: -1000,
        //     max: 1000,
        //     from: -500,
        //     to: 500,
        //     step: 250
        // });

      });
    </script>
    <script></script>
    @include('webmaster.partials.notify')
    <!--scripts-->
    @yield('scripts')
</body>

</html>
