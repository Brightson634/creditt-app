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
    <link rel="shortcut icon"
        href="{{ asset('assets/uploads/generals/' . $gs->favicon) }}">

    <!-- vendor css -->
    <link href="{{ asset('assets/backend/dash/lib/fontawesome-free/css/all.min.css') }}"
        rel="stylesheet">
    <link href="{{ asset('assets/backend/dash/lib/ionicons/css/ionicons.min.css') }}"
        rel="stylesheet">
    <link href="{{ asset('assets/backend/dash/lib/typicons.font/typicons.css') }}"
        rel="stylesheet">
    <link href="{{ asset('assets/backend/dash/lib/jqvmap/jqvmap.min.css') }}"
        rel="stylesheet">

    <!-- azia CSS -->
    <link rel="stylesheet" href="{{ asset('assets/backend/dash/css/azia.css') }}">

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

    <script src="{{ asset('assets/backend/dash/lib/jquery/jquery.min.js') }}"></script>
    <script
        src="{{ asset('assets/backend/dash/lib/bootstrap/js/bootstrap.bundle.min.js') }}">
    </script>
    <script src="{{ asset('assets/backend/dash/lib/ionicons/ionicons.js') }}"></script>
    <script src="{{ asset('assets/backend/dash/lib/jquery.flot/jquery.flot.js') }}">
    </script>
    <script src="{{ asset('assets/backend/dash/lib/jquery.flot/jquery.flot.resize.js') }}">
    </script>
    <script src="{{ asset('assets/backend/dash/lib/peity/jquery.peity.min.js') }}"></script>

    <script src="{{ asset('assets/backend/dash/js/azia.js') }}"></script>
    <script src="{{ asset('assets/backend/dash/js/chart.flot.sampledata.js') }}"></script>
    <script>
        $(function () {
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

            $('.az-iconbar .nav-link').on('click', function (e) {
                e.preventDefault();

                $(this).addClass('active');
                $(this).siblings().removeClass('active');

                $('.az-iconbar-aside').addClass('show');

                var targ = $(this).attr('href');
                $(targ).addClass('show');
                $(targ).siblings().removeClass('show');
            });

            $('.az-iconbar-body .with-sub').on('click', function (e) {
                e.preventDefault();
                $(this).parent().addClass('show');
                $(this).parent().siblings().removeClass('show');
            });

            $('.az-iconbar-toggle-menu').on('click', function (e) {
                e.preventDefault();

                if (window.matchMedia('(min-width: 992px)').matches) {
                    $('.az-iconbar .nav-link.active').removeClass('active');
                    $('.az-iconbar-aside').removeClass('show');
                } else {
                    $('body').removeClass('az-iconbar-show');
                }
            })

            $('#azIconbarShow').on('click', function (e) {
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
    <!--scripts-->
    @yield('scripts')
</body>

</html>
