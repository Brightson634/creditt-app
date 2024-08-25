@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection
@section('css')
    <style>
        /* General styles */
        .morris-hover {
            position: absolute;
            z-index: 1000;
        }

        .morris-hover.morris-default-style {
            border-radius: 10px;
            padding: 6px;
            color: #666;
            background: rgba(255, 255, 255, 0.8);
            border: solid 2px rgba(230, 230, 230, 0.8);
            font-family: sans-serif;
            font-size: 12px;
            text-align: center;
        }

        svg .bar {
            stroke-width: 1px;
        }

        #chart-container {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .legendLabel {
            font-weight: bold;
        }

        #expenseChart {
            width: 200px;
            height: 200px;
            margin: 0;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .select-wrapper {
            display: flex;
            align-items: center;
        }

        .select-wrapper select {
            appearance: none;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background: white;
            width: 150px;
            margin-left: 10px;
        }

        .select-wrapper::after {
            content: '▼';
            margin-left: -25px;
            pointer-events: none;
        }

        .recentTransactions {}

        .paper {
            border: 1px solid gray;
            border-radius: 10px;
            background-color: #EDEDED;
            padding: 10px;
        }

        #revenueChart {
            width: 150px;
            height: 150px;
            margin: 0 auto;
            position: relative;
        }

        .statusBtn {
            padding: 1px 3px;
            font-size: 10px;
            line-height: 0.5;
            border-width: 1px;
            border-radius: 50%;
        }

        .table th,
        .table td {
            text-transform: capitalize;
        }

        .table thead th {
            background-color: #596882;
            color: white;
            text-align: center;
        }

        .table tbody tr td span {
            display: block;
            width: 8px;
            height: 8px;
            border-radius: 100%;
        }

        .table tbody tr td button {
            border: none;
        }

        /** Streams CSS **/
        .card-header {
            display: flex;
            align-items: center;
        }

        .card-header .hamburger-icon {
            margin-right: 10px;
        }

        .timeline {
            position: relative;
            padding: 0;
            list-style: none;
            margin-left: 10px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #28a745;
            left: 50px;
            margin-right: -2px;
        }

        .timeline-item {
            position: relative;
            margin: 0 0 20px;
            padding-left: 70px;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 46px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #ffffff;
            border: 1px solid #4b5158;
        }

        .timeline-item .time {
            border-bottom: 1px dashed #bbb;
            padding-bottom: 2px;
        }

        .timeline-item .content {
            padding: 10px 15px;
            border-radius: 5px;
            background: #fff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .latest_activity {
            color: rgb(51 65 85);
        }

        /* Cards styles */
        .card {
            border-radius: 10px;
            box-shadow: rgba(0, 0, 0, 0.02) 0px 1px 3px 0px, rgba(27, 31, 35, 0.15) 0px 0px 0px 1px;
            background-color: #f8f9fa;
        }

        .card-header {
            border-bottom: none;
            background-color: transparent;
        }

        .card-title {
            color: #333;
        }

        .card-body {
            padding: 20px;
        }

        /* Activity stream */
        .card.h-100 {
            display: flex;
            flex-direction: column;
        }

        .card-body {
            flex: 1;
            overflow-y: auto;
            max-height: 100%;
            /* Ensure it takes up available height */
            padding: 15px;
            /* Optional: Adds some padding inside the scrollable area */
        }

        .timeline {
            padding-left: 0;
            list-style: none;
            margin: 0;
        }

        .timeline-item {
            margin-bottom: 15px;
        }

        .time {
            font-size: 0.875rem;
            color: #6c757d;
        }

        .content {
            padding-left: 10px;
            border-left: 2px solid #007bff;
        }

        /* General card styles */
        .card.h-100 {
            display: flex;
            flex-direction: column;
            height: 100%;

        }

        /* Card body scrollable area */
        .card-body {
            flex: 1;
            overflow-y: auto;
            /* Enables vertical scrolling */
        }

        /* Timeline styles */
        /* .card-body {
    display: flex;
    flex-direction: column;
    height: 100%;
}

.timeline {
    max-height: 100%;
    overflow-y: auto;
    padding-left: 0;
}

.timeline-item {
    margin-bottom: 15px;
}

.timeline-item .time {
    font-size: 0.8rem;
    color: #888;
}

.timeline-item .content {
    background-color: #f9f9f9;
    padding: 10px;
    border-radius: 5px; 
 } */

        /* .timeline {
            padding-left: 0;
            list-style: none;
            margin: 0;
        }

        .timeline-item {
            margin-bottom: 15px;
        }

        .time {
            font-size: 0.875rem;
            color: #6c757d;
        }

        .content {
            padding-left: 10px;
            border-left: 2px solid #007bff;
        } */

    </style>
@endsection
@section('content')
    @include('webmaster.partials.generalheader')
    <div class="row row-sm">
        <div class="col-md-8 col-lg-8 col-xl-8">
            <!-- Loan Overview -->
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="card-title tx-14 mg-b-5">Loan Overview</h6>
                    <p class="mg-b-0">Monthly loan overview information</p>
                </div><!-- card-header -->
                <div class="card-body">
                    <div class="dashboard-five-stacked-chart">
                        <canvas id="chartStacked1"></canvas>
                    </div>
                </div><!-- card-body -->
            </div><!-- card -->

            <!-- Savings, Expenses, Revenues, Statistics Overview -->
            <div class="row d-flex align-items-stretch">
                <div class="col-md-6 d-flex">
                    <!-- Savings Overview -->
                    <div class="card mb-3 w-100">
                        <div class="card-header">
                            <h6 class="card-title mg-b-10">Savings Overview</h6>
                        </div><!-- card-header -->
                        <div class="card-body">
                            <!-- Savings content here -->
                            <div class='col-md-12 mt-3'>
                                <div class='row'>
                                    <div class='col-md-12'>
                                        <h4><strong>
                                                {!! isset($savingdata->deposit_amount) ? showAmount($savingdata->deposit_amount) : 0 !!}
                                            </strong>
                                        </h4>
                                    </div>
                                    <div class='col-md-12'>
                                        <small class='mb-0' style="color:#1976d2;">Savings for last 30 days</small>
                                    </div>
                                    <br />
                                    <br />
                                    <br />
                                    <div class='col-md-6 col-xl-6 col-6'>
                                        <small style="color:0000;"><b>
                                                {!! isset($accountdata->current_balance) ? showAmount($accountdata->current_balance) : 0 !!}
                                            </b></small>
                                    </div>
                                    <div class='col-md-6 col-xl-6 col-6'>
                                        <small style="color:0000;">
                                            <b>
                                                {!! isset($accountdata->available_balance) ? showAmount($accountdata->available_balance) : 0 !!}
                                            </b>
                                        </small>
                                    </div>
                                    <div class='col-md-6 col-xl-6 col-6'>
                                        <small>Current balance</small>
                                    </div>
                                    <div class='col-md-6 col-xl-6 col-6'>
                                        <small>Available balance</small>
                                    </div>
                                    <div class='col-md-12 mt-1'>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-lg bg-success wd-60p" role="progressbar"
                                                aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <br />
                                    <br />
                                    <br />
                                    <div class='col-md-6 col-xl-6 col-6'>
                                        <small style="color:0000;"><b>
                                                {!! showAmount($loandata->repaid_amount) !!}
                                            </b></small>
                                    </div>
                                    <div class='col-md-6 col-xl-6 col-6'>
                                        <small style="color:0000;">
                                            <b>
                                                {!! showAmount($loandata->principal_amount) !!}
                                            </b>
                                        </small>
                                    </div>
                                    <div class='col-md-6 col-xl-6 col-6'>
                                        <small>Deposited</small>
                                    </div>
                                    <div class='col-md-6 col-xl-6 col-6'>
                                        <small>Not deposited</small>
                                    </div>
                                    <div class='col-md-12 mt-1'>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-lg bg-danger wd-60p" role="progressbar"
                                                aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- card-body -->
                    </div><!-- card -->
                </div>

                <div class="col-md-6 d-flex">
                    <!-- Expenses -->
                    <div class="card mb-3 w-100">
                        <div class="card-header">
                            <h6 class="card-title mg-b-10">Expenses</h6>
                            <div class="select-wrapper">
                                <select id="filter-select" style="border:none;">
                                    <option value="last-month">Last Month</option>
                                    <option value="last-quarter">Last Quarter</option>
                                    <option value="last-year">Last Year</option>
                                </select>
                            </div>
                        </div><!-- card-header -->
                        <div class="card-body">
                            <!-- Expenses content here -->
                            <div>
                                <span><strong>{!! showAmount($expense->amount) !!}</strong></span>
                                <p class='text-muted'>Total Expenses</p>
                            </div>
                            <div id="chart-container">
                                <div id="expenseChart"></div>
                                <div id="donut-chart-legend"></div>
                            </div>
                        </div><!-- card-body -->
                    </div><!-- card -->
                </div>

                <div class="col-md-6 d-flex">
                    <!-- Revenues -->
                    <div class="card mb-3 w-100">
                        <div class="card-header">
                            <h6 class="card-title mg-b-10">Revenues</h6>
                            <div class="select-wrapper">
                                <select id="filter-select" class="form-select">
                                    <option value="last-month">Last Month</option>
                                    <option value="last-quarter">Last Quarter</option>
                                    <option value="last-year">Last Year</option>
                                </select>
                            </div>
                        </div><!-- card-header -->
                        <div class="card-body">
                            <!-- Revenues content here -->
                            <div>
                                <span><strong>{!! showAmount($loandata->fees_total) !!}</strong></span>
                                <p class="text-muted">Total Revenues</p>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div id="flotPie" class="wd-100p ht-200"></div>
                                </div>
                                <div class="col-sm-6">
                                    <ul class="list-unstyled">
                                        <li class="d-flex align-items-center">
                                            <span class="d-inline-block wd-10 ht-10 bg-purple mg-r-10"></span>
                                            Very Satisfied (26%)
                                        </li>
                                        <li class="d-flex align-items-center mg-t-5">
                                            <span class="d-inline-block wd-10 ht-10 bg-primary mg-r-10"></span>
                                            Satisfied (39%)
                                        </li>
                                        <li class="d-flex align-items-center mg-t-5">
                                            <span class="d-inline-block wd-10 ht-10 bg-teal mg-r-10"></span>
                                            Not Satisfied (20%)
                                        </li>
                                        <li class="d-flex align-items-center mg-t-5">
                                            <span class="d-inline-block wd-10 ht-10 bg-gray-500 mg-r-10"></span>
                                            Satisfied (15%)
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div><!-- card-body -->
                    </div><!-- card -->
                </div>

                <div class="col-md-6 d-flex">
                    <!-- Statistics Overview -->
                    <div class="card mb-3 w-100">
                        <div class="card-header">
                            <h6 class="card-title mg-b-10">Statistics Overview</h6>
                            <div class="select-wrapper">
                                <select id="filter-select" style="border:none;">
                                    <option value="last-month">Last Month</option>
                                    <option value="last-quarter">Last Quarter</option>
                                    <option value="last-year">Last Year</option>
                                </select>
                            </div>
                        </div><!-- card-header -->
                        <div class="card-body">
                            <!-- Statistics content here -->
                            <div id='statisticsChart' style='width:320px; height:298px'></div>
                        </div><!-- card-body -->
                    </div><!-- card -->
                </div>
            </div><!-- row -->

        </div><!-- col -->

        <!-- Activity Stream -->
        <div class="col-md-4 col-lg-4 col-xl-4 d-flex">
            <div class="card h-100 w-100">
                <div class="card-header">
                    <span class="hamburger-icon">☰</span>
                    <span class="latest_activity">Activity Stream</span>
                </div>
                <div class="card-body d-flex flex-column">
                    <ul class="timeline flex-grow-1 overflow-auto" style="max-height: 1000px;">
                        @foreach ($activityStreams as $activity)
                        <li class="timeline-item">
                            <span class="time">{{ $activity->formatted_time }}</span>
                            <div class="content">
                                @if($activity->activity == "New Loan")
                                <h5 class="mb-1">Loan Application Submission</h5>
                                <p class="mb-1">New Loan Application <strong>{{$activity->loan_number}} created: by {{$activity->staffname}}</strong> <a href="{{ route('webmaster.loan.dashboard', ['id' => $activity->loan_number]) }}"
                                     title="Loan Application {{$activity->loan_number}}">View More</a></p>
                                <p>It has been sent for review</p>
                                @elseif($activity->activity == "Loan Reviewed")
                                <h5 class="mb-1">Loan Reviewed!</h5>
                                <p class="mb-1">Loan Application <strong>{{$activity->loan_number}} reviewed : by {{$activity->staffname}}</strong> <a href="{{ route('webmaster.loan.dashboard', ['id' => $activity->loan_number]) }}"
                                     title="Loan Application {{$activity->loan_number}}">View More</a></p>
                                <p>It has been sent for Approval</p>
    
                                @elseif($activity->activity == "Loan Approved")
                                <h5 class="mb-1">Loan Approved!</h5>
                                <p class="mb-1">Loan Application <strong>{{$activity->loan_number}} approved : by {{$activity->staffname}}</strong> <a href="{{ route('webmaster.loan.dashboard', ['id' => $activity->loan_number]) }}"
                                     title="Loan Application {{$activity->loan_number}}">View More</a></p>
                                <p>It is waiting disbursement</p>
                            
                                @elseif($activity->activity == "Loan Rejected")
                                <h5 class="mb-1">Loan Rejected!</h5>
                                <p class="mb-1">Loan Application <strong>{{$activity->loan_number}} rejected : by {{$activity->staffname}}</strong> <a href="{{ route('webmaster.loan.dashboard', ['id' => $activity->loan_number]) }}"
                                     title="Loan Application {{$activity->loan_number}}">View More</a></p>
                                <p></p>
                                @endif
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div><!-- card -->
        </div><!-- col -->
    </div><!-- row -->
    <div class="row row-sm">

        <div class="col-md-12 mg-t-20">
            <div class="card card-dashboard-table-six">
                <h6 class="card-title">Recent Transactions</h6>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Trans ID</th>
                                <th>Member Name</th>
                                <th>Previous Balance</th>
                                <th>Amount Paid</th>
                                <th>Remaining Balance</th>
                                <th>Payment Type</th>
                                <th>Paid By</th>
                                <th>Trans Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentTransaction as $item)
                                <tr>
                                    <td><span class="bg-success"></span></td>
                                    <td>TID-{{ ucwords(strtolower($item->id)) }}-{{ ucwords(strtolower($item->date)) }}
                                    </td>
                                    <td>{{ ucwords(strtolower($item->member->fname)) }}</td>
                                    <td>{!! showAmount(ucwords(strtolower($item->loan_amount))) !!}</td>
                                    <td>{!! showAmount(ucwords(strtolower($item->loan_amount - $item->balance_amount))) !!}</td>
                                    <td>{!! showAmount(ucwords(strtolower($item->balance_amount))) !!}</span></td>
                                    @if ($item->payment_type === 'partial')
                                        <td><button
                                                class="badge badge-pill badge-warning">{{ ucwords(strtolower($item->payment_type)) }}</button>
                                        </td>
                                    @else
                                        <td><button
                                                class="badge badge-pill badge-success">{{ ucwords(strtolower($item->payment_type)) }}</button>
                                        </td>
                                    @endif
                                    <td>{{ ucwords(strtolower($item->paid_by)) }}</td>
                                    <td>{{ $item->date }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div><!-- table-responsive -->
            </div><!-- card -->
        </div>

        <div class="col-12 mg-t-20">
            <div class="card card-dashboard-table-six">
                <h6 class="card-title">Recent Loan Applications</h6>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Loan Number</th>
                                <th>Member Name</th>
                                <th>Loan Type</th>
                                <th>Loan Product</th>
                                <th>Principal Amount</th>
                                <th>Loan Interest</th>
                                <th>Payment Mode</th>
                                <th>Loan Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($loanTransaction as $item)
                                <tr>
                                    @if ($item->status === 0)
                                        <td><span class="bg-warning"></span></td>
                                    @elseif($item->status === 1)
                                        <td><span class="bg-info"></span></td>
                                    @elseif($item->status === 2)
                                        <td><span class="bg-success"></span></td>
                                    @else
                                        <td><span class="bg-danger"></span></td>
                                    @endif
                                    <td>{{ ucwords(strtolower($item->loan_no)) }}</td>
                                    <td>{{ ucwords(strtolower(optional($item->member)->fname ?? '')) }}</td>
                                    <td>{{ ucwords(strtolower($item->loan_type)) }}</td>
                                    <td>{{ ucwords(strtolower($item->loanproduct->name)) }}</td>
                                    <td>{!! showAmount(ucwords(strtolower($item->principal_amount))) !!}</td>
                                    <td>{!! showAmount(ucwords(strtolower($item->interest_amount))) !!}</td>
                                    <td>{{ ucwords(strtolower($item->payment_mode)) }}</td>
                                    @if ($item->status === 0)
                                        <td><button class="badge badge-pill badge-warning">Pending</button></td>
                                    @elseif($item->status === 1)
                                        <td><button class="badge badge-pill badge-info">Reviewed</span></td>
                                    @elseif($item->status === 2)
                                        <td><button class="badge badge-pill badge-success">Approved</button></td>
                                    @else
                                        <td><button class="badge badge-pill badge-danger">Rejected</button></td>
                                    @endif
                                    <td>{{ $item->updated_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div><!-- table-responsive -->
            </div><!-- card -->
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        var loanData = @json($loanOverViewData);
        var loan = @json($monthlyLoanData);
        var expenseData = @json($expenseCategoryData);
        var revenueData = @json($revenueData);
        var recentTransact = @json($recentTransaction);
        var statisticsData = @json($statisticsData);
        // console.log(recentTransact);
        // console.log(loan)
        // console.log(loanData)
        var formattedLoanData = [];
        var formattedExpenseData = [];

        var formattedExpenseData = [];
        for (var key in expenseData) {
            if (expenseData.hasOwnProperty(key)) {
                formattedExpenseData.push({
                    label: key,
                    data: parseFloat(expenseData[key])
                });
            }
        }

        for (var key in loanData) {
            if (loanData.hasOwnProperty(key)) {
                formattedLoanData.push({
                    label: key,
                    value: loanData[key]
                });
            }
        }

        // var barColors = ['#0b62a4', '#7a92a3', '#4da74d'];

        // new Morris.Bar({
        //     element: 'loanOverViewBar',
        //     data: formattedLoanData,
        //     xkey: 'label',
        //     ykeys: ['value'],
        //     labels: ['Amount'],
        //     barColors: function(row, series, type) {
        //         return barColors[row.x];
        //     },
        //     resize: true
        // });


        $.plot('#expenseChart', formattedExpenseData, {
            series: {
                pie: {
                    show: true,
                    radius: 0.8,
                    innerRadius: 0.5,
                    label: {
                        show: true,
                        radius: 2 / 3,
                        formatter: labelFormatter,
                        threshold: 0.1,
                        background: {
                            opacity: 0.5,
                            color: "#000"
                        }
                    }
                }
            },
            legend: {
                show: true,
                container: '#donut-chart-legend',
                labelFormatter: function(label, series) {
                    return '<span class="legendLabel">' + label + ' (UGX' + series.data[0][1].toLocaleString() +
                        ')</span>';
                }
            },
            grid: {
                hoverable: true,
                clickable: true
            }
        });

        function labelFormatter(label, series) {
            return '<div style="font-size:10px; text-align:center; padding:2px; color:white;">' +
                Math.round(series.percent) + '%</div>';
        }

        const plotRevenues = () => {
            // Data passed from Laravel to JavaScript
            var revenueData = @json($revenueData);

            // Format data for Morris
            var formattedData = [];
            for (var key in revenueData) {
                if (revenueData.hasOwnProperty(key)) {
                    formattedData.push({
                        label: key,
                        value: revenueData[key]
                    });
                }
            }

            // Function to format numbers with commas
            function numberWithCommas(x) {
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

            // Render the chart
            new Morris.Donut({
                element: 'revenueChart',
                data: formattedData,
                colors: ['#0b62a4'],
                resize: true,
                formatter: function(y, data) {
                    return 'UGX' + numberWithCommas(y);
                }
            });
            // Reduce the donut radius after rendering
            setTimeout(function() {
                var paths = $('#chart-container').find('path');
                paths.attr('transform', 'scale(0.8, 0.8) translate(30, 30)');
                paths.addClass('hover-effect');
            }, 100);
        }

        // plotRevenues();

        const plotStatisticsOverView = () => {
            // Data passed from Laravel to JavaScript
            var statisticsData = @json($statisticsData);

            // Format data for Morris
            var formattedData = [];
            for (var key in statisticsData) {
                if (statisticsData.hasOwnProperty(key)) {
                    formattedData.push({
                        y: key,
                        value: statisticsData[key]
                    });
                }
            }

            // Calculate dimensions based on container size
            var container = $('#statisticsChart');
            var width = container.width();
            var height = container.height();

            // Render the chart
            new Morris.Line({
                element: 'statisticsChart',
                data: formattedData,
                xkey: 'y',
                ykeys: ['value'],
                labels: ['Value'],
                lineColors: ['#0b62a4'],
                parseTime: false, // If x values are not date-based
                hideHover: 'auto',
                resize: true,
                xLabels: 'auto',
                lineWidth: 2, // Optional: Adjust line width
                pointSize: 4, // Optional: Adjust point size
                gridTextColor: '#333', // Optional: Adjust grid text color
                gridTextSize: 12 // Optional: Adjust grid text size
            }).on('resize', function() {
                // Re-calculate dimensions on resize
                width = container.width();
                height = container.height();
            });

            // Adjust chart dimensions
            $('#statisticsChart').css({
                width: width,
                height: height
            });
        }

        plotStatisticsOverView()

        // var ctx6 = $('#chartStacked1');
        // new Chart(ctx6, {
        //     type: 'bar',
        //     data: {
        //         labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov',
        //             'Dec'
        //         ],
        //         datasets: [{
        //             data: [10, 24, 20, 25, 35, 50, 20, 30, 28, 33, 45, 65],
        //             backgroundColor: '#6610f2',
        //             borderWidth: 1,
        //             fill: true
        //         }, {
        //             data: [20, 30, 28, 33, 45, 65, 25, 35, 50, 20, 30, 28],
        //             backgroundColor: '#00cccc',
        //             borderWidth: 1,
        //             fill: true
        //         }]
        //     },
        //     options: {
        //         maintainAspectRatio: false,
        //         legend: {
        //             display: false,
        //             labels: {
        //                 display: false
        //             }
        //         },
        //         scales: {
        //             yAxes: [{
        //                 ticks: {
        //                     beginAtZero: true,
        //                     fontSize: 11
        //                 }
        //             }],
        //             xAxes: [{
        //                 barPercentage: 0.4,
        //                 ticks: {
        //                     fontSize: 11
        //                 }
        //             }]
        //         }
        //     }
        // });

        //new loan plot
        // var labelsInfo = loan.map(item=>item.date)
        // var repaidData = loan.map(item=>item.repaid_amount)
        // var issuedData  = loan.map(item=>item.principal_amount)
        // var dueData = loan.map(item=>item.loan_amount-item.repaid_amount)
        // Initialize arrays for each dataset with 12 zeros (one for each month)

        //ploting loan overview data
        var issuedData = Array(12).fill(0);
        var repaidData = Array(12).fill(0);
        var dueData = Array(12).fill(0);
        console.log(dueData);

        // Populate the arrays based on the month from the data
        loan.forEach(item => {
            var monthIndex = parseInt(item.date.split('-')[1]) - 1; // Extract month and convert to 0-based index
            issuedData[monthIndex] = item.principal_amount;
            repaidData[monthIndex] = item.repaid_amount;
            dueData[monthIndex] = item.loan_amount - item.repaid_amount;
        });

        var ctx = $('#chartStacked1');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                        label: 'Loans Issued',
                        data: issuedData,
                        backgroundColor: '#6610f2',
                        borderWidth: 1,
                        fill: true
                    },
                    {
                        label: 'Loans Repaid',
                        data: repaidData,
                        backgroundColor: '#00cccc',
                        borderWidth: 1,
                        fill: true
                    },
                    {
                        label: 'Loans Due',
                        data: dueData,
                        backgroundColor: '#ffcc00',
                        borderWidth: 1,
                        fill: true
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            fontSize: 11
                        }
                    }],
                    xAxes: [{
                        barPercentage: 0.6,
                        categoryPercentage: 0.8, // Adjust space between the bars
                        ticks: {
                            fontSize: 11
                        }
                    }]
                },
                legend: {
                    display: true, // Display the legend
                }
            }
        });


        //to be used for revenues
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
    </script>
@endsection
