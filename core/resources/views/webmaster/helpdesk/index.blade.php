@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection
@section('css')
@endsection
@section('content')
    <div class="az-content-header d-block d-md-flex">
        <div>
            <h2 class="az-content-title mg-b-5 mg-b-lg-8">Hi, welcome back!</h2>
            <p class="mg-b-0">Your customer service/help desk monitoring dashboard.</p>
        </div>
    </div><!-- az-content-header -->
    <div class="az-content-body">
        <div class="row row-sm">
            <div class="col-sm-6 col-lg-4 col-xl-3">
                <div class="card card-body card-dashboard-fifteen">
                    <h1>257</h1>
                    <label class="tx-purple">Support Requests</label>
                    <span>The total number of support requests that have come in.</span>
                    <div class="chart-wrapper">
                        <div id="flotChart1" class="flot-chart"></div>
                    </div><!-- chart-wrapper -->
                </div><!-- card -->
            </div><!-- col -->
            <div class="col-sm-6 col-lg-4 col-xl-3 mg-t-20 mg-sm-t-0">
                <div class="card card-body card-dashboard-fifteen">
                    <h1>187</h1>
                    <label class="tx-primary">Complaints Received</label>
                    <span>The total number of complaints that have been received.</span>
                    <div class="chart-wrapper">
                        <div id="flotChart2" class="flot-chart"></div>
                    </div><!-- chart-wrapper -->
                </div><!-- card -->
            </div><!-- col -->
            <div class="col-sm-6 col-lg-4 col-xl-3 mg-t-20 mg-sm-t-20 mg-lg-t-0">
                <div class="card card-body card-dashboard-fifteen">
                    <h1>125<span>/187</span></h1>
                    <label class="tx-teal">Complaints Resolved</label>
                    <span>The total number of complaints that resolved.</span>
                    <div class="chart-wrapper">
                        <div id="flotChart3" class="flot-chart"></div>
                    </div><!-- chart-wrapper -->
                </div><!-- card -->
            </div><!-- col -->
            <div class="col-sm-6 col-lg-12 col-xl-3 mg-t-20 mg-xl-t-0">
                <div class="d-lg-flex d-xl-block">
                    <div class="card wd-lg-50p wd-xl-auto">
                        <div class="card-header">
                            <h6 class="card-title tx-14 mg-b-0">Time to Resolve Complaint</h6>
                        </div><!-- card-header -->
                        <div class="card-body">
                            <h3 class="tx-bold tx-inverse lh--5 mg-b-15">7m:32s <span
                                    class="tx-base tx-normal tx-gray-600">/ Goal: 8m:0s</span></h3>
                            <div class="progress mg-b-0 ht-3">
                                <div class="progress-bar wd-85p bg-purple" role="progressbar" aria-valuenow="85"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div><!-- card-body -->
                    </div><!-- card -->
                    <div class="card mg-t-20 mg-lg-t-0 mg-xl-t-20 mg-lg-l-20 mg-xl-l-0">
                        <div class="card-header">
                            <h6 class="card-title tx-14 mg-b-5">Avg. Speed of Answer</h6>
                            <p class="tx-12 lh-4 tx-gray-500 mg-b-0">Measure how quickly support staff answer incoming
                                calls.</p>
                        </div><!-- card-header -->
                        <div class="card-body">
                            <h2 class="tx-bold tx-inverse lh--5 mg-b-5">0m:20s</h2>
                        </div><!-- card-body -->
                    </div><!-- card -->
                </div>
            </div><!-- col-3 -->
            <div class="col-xl-6 mg-t-15 mg-t-20">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title tx-14 mg-b-5">Customer Satisfaction</h6>
                        <p class="tx-gray-600 mg-b-0">Measures the quality or your support team’s efforts. It is important
                            to monitor your customer satisfaction status, as the opinion... <a href="">Learn more</a>
                        </p>
                    </div><!-- card-header -->
                    <div class="card-body row pd-25">
                        <div class="col-sm-8 col-md-7">
                            <div id="flotPie" class="wd-100p ht-200"></div>
                        </div><!-- col -->
                        <div class="col-sm-4 col-md-5 mg-t-30 mg-sm-t-0">
                            <ul class="list-unstyled">
                                <li class="d-flex align-items-center"><span
                                        class="d-inline-block wd-10 ht-10 bg-purple mg-r-10"></span> Very Satisfied (26%)
                                </li>
                                <li class="d-flex align-items-center mg-t-5"><span
                                        class="d-inline-block wd-10 ht-10 bg-primary mg-r-10"></span> Satisfied (39%)</li>
                                <li class="d-flex align-items-center mg-t-5"><span
                                        class="d-inline-block wd-10 ht-10 bg-teal mg-r-10"></span> Not Satisfied (20%)</li>
                                <li class="d-flex align-items-center mg-t-5"><span
                                        class="d-inline-block wd-10 ht-10 bg-gray-500 mg-r-10"></span> Satisfied (15%)</li>
                            </ul>
                        </div><!-- col -->
                    </div><!-- card-body -->
                </div><!-- card -->
            </div><!-- col -->
            <div class="col-gl-5 col-xl-6 mg-t-20">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title tx-14 mg-b-5">Talk Time</h6>
                        <p class="mg-b-0">Measure the amount of time your support agents spend talking to a customer. It
                            gives your team insight into how long they should set aside... <a href="">Learn more</a>
                        </p>
                    </div><!-- card-header -->
                    <div class="table-responsive mg-t-15">
                        <table class="table table-striped table-talk-time">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Call Agent</th>
                                    <th>Talk Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>21</td>
                                    <td>Socrates Itumay</td>
                                    <td>2m:12s</td>
                                </tr>
                                <tr>
                                    <td>22</td>
                                    <td>Isidore Dilao</td>
                                    <td>1m:17s</td>
                                </tr>
                                <tr>
                                    <td>23</td>
                                    <td>Joyce Chua</td>
                                    <td>2m:0s</td>
                                </tr>
                                <tr>
                                    <td>24</td>
                                    <td>Reynante Labares</td>
                                    <td>2m:1s</td>
                                </tr>
                                <tr>
                                    <td>25</td>
                                    <td>Owen Bongcaras</td>
                                    <td>2m:21s</td>
                                </tr>
                                <tr>
                                    <td>25</td>
                                    <td>Kirby Avendula</td>
                                    <td>2m:33s</td>
                                </tr>
                            </tbody>
                        </table>
                    </div><!-- table-responsive -->
                </div><!-- card -->
            </div><!-- col -->
            <div class="col-md-5 col-lg-5 col-xl-4 mg-t-20">
                <div class="card card-dashboard-sixteen">
                    <div class="card-header">
                        <h6 class="card-title tx-14 mg-b-0">Top Performer Help Agents</h6>
                    </div><!-- card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table mg-b-0">
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="az-img-user"><img src="https://via.placeholder.com/500"
                                                    alt=""></div>
                                        </td>
                                        <td>
                                            <h6 class="mg-b-0 tx-inverse">Socrates Itumay</h6>
                                            <small class="tx-11 tx-gray-500">Agent ID: 12022</small>
                                        </td>
                                        <td>
                                            <h6 class="mg-b-0 tx-inverse">87/100</h6>
                                            <small class="tx-11 tx-gray-500">Reached Goal</small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="az-img-user"><img src="https://via.placeholder.com/500"
                                                    alt=""></div>
                                        </td>
                                        <td>
                                            <h6 class="mg-b-0 tx-inverse">Reynante Labares</h6>
                                            <small class="tx-11 tx-gray-500">Agent ID: 12028</small>
                                        </td>
                                        <td>
                                            <h6 class="mg-b-0 tx-inverse">85/100</h6>
                                            <small class="tx-11 tx-gray-500">Reached Goal</small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="az-img-user"><img src="https://via.placeholder.com/500"
                                                    alt=""></div>
                                        </td>
                                        <td>
                                            <h6 class="mg-b-0 tx-inverse">Owen Bongcaras</h6>
                                            <small class="tx-11 tx-gray-500">Agent ID: 11500</small>
                                        </td>
                                        <td>
                                            <h6 class="mg-b-0 tx-inverse">83/100</h6>
                                            <small class="tx-11 tx-gray-500">Reached Goal</small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="az-img-user"><img src="https://via.placeholder.com/500"
                                                    alt=""></div>
                                        </td>
                                        <td>
                                            <h6 class="mg-b-0 tx-inverse">Mariane Galeon</h6>
                                            <small class="tx-11 tx-gray-500">Agent ID: 11600</small>
                                        </td>
                                        <td>
                                            <h6 class="mg-b-0 tx-inverse">82/100</h6>
                                            <small class="tx-11 tx-gray-500">Reached Goal</small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="az-img-user"><img src="https://via.placeholder.com/500"
                                                    alt=""></div>
                                        </td>
                                        <td>
                                            <h6 class="mg-b-0 tx-inverse">Joyce Chua</h6>
                                            <small class="tx-11 tx-gray-500">Agent ID: 11990</small>
                                        </td>
                                        <td>
                                            <h6 class="mg-b-0 tx-inverse">80/100</h6>
                                            <small class="tx-11 tx-gray-500">Reached Goal</small>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div><!-- table-responsive -->
                    </div><!-- card-body -->
                </div><!-- card -->
            </div><!-- col -->
            <div class="col-md-7 col-lg-7 col-xl-8 mg-t-20">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title tx-14 mg-b-5">Customer Complaints Comparison</h6>
                        <p class="mg-b-0">Monitor the total number of complaints that are resolved and unresolved.</p>
                    </div><!-- card-header -->
                    <div class="card-body">
                        <div class="dashboard-five-stacked-chart"><canvas id="chartStacked1"></canvas></div>
                    </div><!-- card-body -->
                </div><!-- card -->
            </div><!-- col -->
        </div><!-- row -->
    </div><!-- az-content-body -->
@endsection
@section('scripts')
    <script>
        $(function() {
            /* Dashboard content */
            $.plot('#flotChart1', [{
                data: flotSampleData5,
                color: '#8039f4'
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
                                opacity: 0.12
                            }]
                        }
                    }
                },
                grid: {
                    borderWidth: 0,
                    labelMargin: 10,
                    markings: [{
                        color: '#70737c',
                        lineWidth: 1,
                        font: {
                            color: '#000'
                        },
                        xaxis: {
                            from: 75,
                            to: 75
                        }
                    }]
                },
                yaxis: {
                    show: false
                },
                xaxis: {
                    show: true,
                    position: 'top',
                    color: 'rgba(102,16,242,.1)',
                    reserveSpace: false,
                    ticks: [
                        [15, '1h'],
                        [35, '1d'],
                        [55, '1w'],
                        [75, '1m'],
                        [95, '3m'],
                        [115, '1y']
                    ],
                    font: {
                        size: 10,
                        weight: '500',
                        family: 'Roboto, sans-serif',
                        color: '#999'
                    }
                }
            });

            $.plot('#flotChart2', [{
                data: flotSampleData2,
                color: '#007bff'
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
                                opacity: 0.5
                            }]
                        }
                    }
                },
                grid: {
                    borderWidth: 0,
                    labelMargin: 10,
                    markings: [{
                        color: '#70737c',
                        lineWidth: 1,
                        font: {
                            color: '#000'
                        },
                        xaxis: {
                            from: 75,
                            to: 75
                        }
                    }]
                },
                yaxis: {
                    show: false
                },
                xaxis: {
                    show: true,
                    position: 'top',
                    color: 'rgba(102,16,242,.1)',
                    reserveSpace: false,
                    ticks: [
                        [15, '1h'],
                        [35, '1d'],
                        [55, '1w'],
                        [75, '1m'],
                        [95, '3m'],
                        [115, '1y']
                    ],
                    font: {
                        size: 10,
                        weight: '500',
                        family: 'Roboto, sans-serif',
                        color: '#999'
                    }
                }
            });

            $.plot('#flotChart3', [{
                data: flotSampleData5,
                color: '#00cccc'
            }], {
                series: {
                    shadowSize: 0,
                    lines: {
                        show: true,
                        lineWidth: 2,
                        fill: true,
                        fillColor: {
                            colors: [{
                                opacity: 0.2
                            }, {
                                opacity: 0.5
                            }]
                        }
                    }
                },
                grid: {
                    borderWidth: 0,
                    labelMargin: 10,
                    markings: [{
                        color: '#70737c',
                        lineWidth: 1,
                        font: {
                            color: '#000'
                        },
                        xaxis: {
                            from: 75,
                            to: 75
                        }
                    }]
                },
                yaxis: {
                    show: false
                },
                xaxis: {
                    show: true,
                    position: 'top',
                    color: 'rgba(102,16,242,.1)',
                    reserveSpace: false,
                    ticks: [
                        [15, '1h'],
                        [35, '1d'],
                        [55, '1w'],
                        [75, '1m'],
                        [95, '3m'],
                        [115, '1y']
                    ],
                    font: {
                        size: 10,
                        weight: '500',
                        family: 'Roboto, sans-serif',
                        color: '#999'
                    }
                }
            });

            $.plot('#flotPie', [{
                    label: 'Very Satisfied',
                    data: [
                        [1, 25]
                    ],
                    color: '#6f42c1'
                },
                {
                    label: 'Satisfied',
                    data: [
                        [1, 38]
                    ],
                    color: '#007bff'
                },
                {
                    label: 'Not Satisfied',
                    data: [
                        [1, 20]
                    ],
                    color: '#00cccc'
                },
                {
                    label: 'Very Unsatisfied',
                    data: [
                        [1, 15]
                    ],
                    color: '#969dab'
                }
            ], {
                series: {
                    pie: {
                        show: true,
                        radius: 1,
                        innerRadius: 0.5,
                        label: {
                            show: true,
                            radius: 3 / 4,
                            formatter: labelFormatter
                        }
                    }
                },
                legend: {
                    show: false
                }
            });

            function labelFormatter(label, series) {
                return '<div style="font-size:11px; font-weight:500; text-align:center; padding:2px; color:white;">' +
                    Math.round(series.percent) + '%</div>';
            }

            var ctx6 = document.getElementById('chartStacked1');
            new Chart(ctx6, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov',
                        'Dec'
                    ],
                    datasets: [{
                        data: [10, 24, 20, 25, 35, 50, 20, 30, 28, 33, 45, 65],
                        backgroundColor: '#6610f2',
                        borderWidth: 1,
                        fill: true
                    }, {
                        data: [20, 30, 28, 33, 45, 65, 25, 35, 50, 20, 30, 28],
                        backgroundColor: '#00cccc',
                        borderWidth: 1,
                        fill: true
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    legend: {
                        display: false,
                        labels: {
                            display: false
                        }
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                fontSize: 11
                            }
                        }],
                        xAxes: [{
                            barPercentage: 0.4,
                            ticks: {
                                fontSize: 11
                            }
                        }]
                    }
                }
            });
        });
    </script>
@endsection
