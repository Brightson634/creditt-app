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
    <link href="{{ asset('assets/backend/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- azia CSS -->
    <link rel="stylesheet" href="{{ asset('assets/backend/dash/css/azia.css') }}">
    <!--charts-->
    <link href="{{ asset('assets/backend/dash/lib/morris.js/morris.css') }}" rel="stylesheet">
    @yield('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highcharts/8.2.0/highcharts.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"
        rel="stylesheet">
    <!-- Select2 CSS -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
    <link href="{{ asset('assets/backend/dash/lib/select2/css/select2.min.css') }}" rel="stylesheet">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.min.css">
    <link href="{{ asset('assets/backend/dash/lib/lightslider/css/lightslider.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/backend/dash/lib/morris.js/morris.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.css" />
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js'></script>


</head>
<style>
    /* General Card Styling */
    .card {
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        overflow: hidden;
        transition: box-shadow 0.3s ease, transform 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        /* transform: translateY(-2px);  */
    }

    /* Card Body Styling */
    .card-body {
        padding: 1.5rem;
    }

    /* Form Control Styling */
    .form-control {
        border-radius: 4px;
        border: 1px solid #ced4da;
        background-color: #fff;
        box-shadow: none;
    }

    /* Form Label Styling */
    .form-label {
        margin-bottom: .5rem;
        font-weight: bold;
    }

    /* Button Styling */
    .btn-theme {
        background-color: #007bff;
        border-color: #007bff;
        color: #fff;
        border-radius: 4px;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
    }

    .btn-theme:hover {
        background-color: #0056b3;
        border-color: #004085;
    }

    /* Button Styling for Small Sizes */
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
        border-radius: 3px;
    }

    /* Spacing and Alignment */
    .clearfix {
        margin-bottom: 1rem;
    }

    .mt-3 {
        margin-top: 1rem;
    }

    .invalid-feedback {
        display: block;
        color: #dc3545;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .card-body {
            padding: 1rem;
        }

        .btn-theme {
            padding: 0.5rem;
        }
    }

    /* table styles*/
    .table th,
    .table td {
        text-align: center !important;
        vertical-align: middle !important;
    }

    .table {
        width: 100% !important;
        table-layout: auto;
    }

    select. select2-hidden-accessible {
        height: 38px !important;
    }

    /* .az-iconbar {
        height: 100vh;
        width: 90px;
        overflow-y: auto;
        overflow-x: hidden;
    }

    .az-iconbar .nav {
        display: flex;
        flex-direction: column;
    } */
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
    <!-- jQuery and Bootstrap JS -->
    <script src="{{ asset('assets/backend/dash/lib/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/backend/dash/lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Ionicons, Flot, and Peity JS -->
    <script src="{{ asset('assets/backend/dash/lib/ionicons/ionicons.js') }}"></script>
    <script src="{{ asset('assets/backend/dash/lib/jquery.flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('assets/backend/dash/lib/jquery.flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('assets/backend/dash/lib/peity/jquery.peity.min.js') }}"></script>

    <!-- Azia and other JS -->
    <script src="{{ asset('assets/backend/dash/js/azia.js') }}"></script>
    <script src="{{ asset('assets/backend/dash/js/chart.flot.sampledata.js') }}"></script>
    <script src="{{ asset('assets/backend/dash/lib/jquery-ui/ui/widgets/datepicker.js') }}"></script>

    <!-- AmazeUI and Simple DateTime Picker JS -->
    <script src="{{ asset('assets/backend/dash/lib/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js') }}"></script>
    <script src="{{ asset('assets/backend/dash/lib/jquery-simple-datetimepicker/jquery.simple-dtpicker.js') }}"></script>

    <!-- Additional JS libraries -->
    {{-- <script src="{{ asset('assets/backend/dash/lib/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
<script src="{{ asset('assets/backend/dash/lib/pickerjs/picker.min.js') }}"></script> --}}
    <script src="{{ asset('assets/backend/dash/lib/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/custom/functions.js') }}"></script>
    <script src="{{ asset('assets/backend/js/bootstrap-datepicker.min.js') }}"></script>

    <!-- Charts and Morris.js -->
    <script src="{{ asset('assets/backend/dash/lib/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('assets/backend/dash/lib/morris.js/morris.min.js') }}"></script>
    <script src="{{ asset('assets/backend/dash/js/chart.morris.js') }}"></script>
    <script src="{{ asset('assets/backend/dash/lib/peity/jquery.peity.min.js') }}"></script>
    <script src="{{ asset('assets/backend/dash/lib/jquery.flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('assets/backend/dash/lib/jquery.flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('assets/backend/dash/js/chart.flot.js') }}"></script>
    <script src="{{ asset('assets/backend/dash/lib/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('assets/backend/dash/lib/chart.js/Chart.bundle.min.js') }}"></script>

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- DataTables JS -->
    {{-- <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script> --}}

    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <!-- Buttons JS -->
    <script src="https://cdn.datatables.net/buttons/2.3.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.2.2/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.3/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.3/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

    <!-- Highcharts JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/8.2.0/highcharts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/8.2.0/modules/exporting.js"></script>

    <!-- Moment.js for DateTime handling -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <!-- Bootstrap Datepicker JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <!-- Date Range Picker -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <!-- SweetAlert2 JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.all.min.js"></script>
    <script src="{{ asset('assets/backend/dash/lib/lightslider/js/lightslider.min.js') }}"></script>
    <!-- form wizard-->
    <script src="{{ asset('assets/backend/dash/lib/jquery-steps/jquery.steps.min.js') }}"></script>
    <script src="{{ asset('assets/backend/dash/lib/parsleyjs/parsley.min.js') }}"></script>

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
        });
    </script>

    <script>
        $(function() {
            'use strict'

            // Toggle Switches
            $('.az-toggle').on('click', function() {
                $(this).toggleClass('on');
            })
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#wizard1').steps({
                headerTag: 'h3',
                bodyTag: 'section',
                autoFocus: true,
                titleTemplate: '<span class="number">#index#</span> <span class="title">#title#</span>'
            });
            $('[data-toggle="tooltip-primary"]').tooltip({
                // placement: 'right',
                container: 'body',
                template: '<div class="tooltip tooltip-primary" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
            });
            $('#navComplex').lightSlider({
                autoWidth: true,
                pager: false,
                slideMargin: 3
            });

            $('.az-nav-tabs .tab-link').on('click', function(e) {
                e.preventDefault();
                $(this).addClass('active');
                $(this).parent().siblings().find('.tab-link').removeClass('active');

                var target = $(this).attr('href');
                $(target).addClass('active');
                $(target).siblings().removeClass('active');
            })
        });
    </script>

    @include('webmaster.partials.notify')

    <script>
        //App base path
        var base_path = "{{ url('/') }}";
        //toastr options
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
        // date-range-settings.js
        var dateRangeSettings = {
            startDate: moment().subtract(6, 'days'),
            endDate: moment(),
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'This Year': [moment().startOf('year'), moment()],
                'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
                'Custom Range': [null, null]
            },
            alwaysShowCalendars: true,
            locale: {
                format: 'MM/DD/YYYY'
            }
        };
    </script>
    <script src="{{ asset('assets/backend/js/plotly.js') }}"></script>
    {{-- @include('webmaster.partials.javascripts') --}}
    @yield('scripts')
</body>

</html>
