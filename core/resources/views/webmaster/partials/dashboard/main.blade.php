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
    {{-- <script>
        //Default settings for daterangePicker
            var LANG = {
            today: "Today",
            yesterday: "Yesterday",
            last_7_days: "Last 7 Days",
            last_30_days: "Last 30 Days",
            this_month: "This Month",
            last_month: "Last Month",
            this_month_last_year: "This Month Last Year",
            this_year: "This Year",
            last_year: "Last Year",
            this_financial_year: "This Financial Year",
            last_financial_year: "Last Financial Year",
            clear: "Clear",
            apply: "Apply",
            custom_range: "Custom Range"
        };

        var financial_year = {
            start: moment('{{ Session::get("financial_year.start") }}'),
            end: moment('{{ Session::get("financial_year.end") }}'),
         }
        var datepicker_date_format = "{{$datepicker_date_format}}";
        var moment_date_format = "{{$moment_date_format}}";
        var moment_time_format = "{{$moment_time_format}}";

        var ranges = {};
        ranges[LANG.today] = [moment(), moment()];
        ranges[LANG.yesterday] = [moment().subtract(1, 'days'), moment().subtract(1, 'days')];
        ranges[LANG.last_7_days] = [moment().subtract(6, 'days'), moment()];
        ranges[LANG.last_30_days] = [moment().subtract(29, 'days'), moment()];
        ranges[LANG.this_month] = [moment().startOf('month'), moment().endOf('month')];
        ranges[LANG.last_month] = [
            moment().subtract(1, 'month').startOf('month'),
            moment().subtract(1, 'month').endOf('month'),
        ];
        ranges[LANG.this_month_last_year] = [
            moment().subtract(1, 'year').startOf('month'),
            moment().subtract(1, 'year').endOf('month'),
        ];
        ranges[LANG.this_year] = [moment().startOf('year'), moment().endOf('year')];
        ranges[LANG.last_year] = [
            moment().startOf('year').subtract(1, 'year'),
            moment().endOf('year').subtract(1, 'year'),
        ];
        ranges[LANG.this_financial_year] = [financial_year.start, financial_year.end];
        ranges[LANG.last_financial_year] = [
            moment(financial_year.start._i).subtract(1, 'year'),
            moment(financial_year.end._i).subtract(1, 'year'),
        ];

        var dateRangeSettings = {
            ranges: ranges,
            startDate: financial_year.start,
            endDate: financial_year.end,
            locale: {
                cancelLabel: LANG.clear,
                applyLabel: LANG.apply,
                customRangeLabel: LANG.custom_range,
                format: moment_date_format,
                toLabel: '~',
            },
        };
    </script> --}}
    <!--scripts-->
      {{-- @include('webmaster.partials.javascripts') --}}
    @yield('scripts')
</body>

</html>
