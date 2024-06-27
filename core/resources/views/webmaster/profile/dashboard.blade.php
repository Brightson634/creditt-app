@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection
@section('css')
    <style>
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
            -webkit-appearance: none;
            -moz-appearance: none;
            padding: 10px;
            border: none;
            border-radius: 4px;
            background: white;
            width: 150px;
            margin-left: 10px;
            outline: none;
        }

        .select-wrapper select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
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

        div .recentTransactions {}

        div .paper {
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

        /*
            .morris-hover-row-label,
            .morris-hover-point {
                display: none;
            }

            .hover-effect path {
                fill-opacity: 0.8;
                cursor: pointer;
            }

            .hover-effect path:hover {
                fill-opacity: 1.0;
            } */

        #revenueChartPlot {
            width: 150px;
            height: 150px;
            margin: 0;
        }
    </style>
@endsection
@section('content')
    <div class="row row-sm">

        <div class="col-lg-4 mg-t-20 mg-lg-t-0">
            <div class="card card-dashboard-loan-over-view">
                <div class="card-header">
                    <h6 class="card-title mg-b-10">LOAN OVERVIEW</h6>
                    <div class="select-wrapper">
                        <select id="filter-select" style='border:none;'>
                            <option value="last-month">Last Month</option>
                            <option value="last-quarter">Last Quarter</option>
                            <option value="last-year">Last Year</option>
                        </select>
                    </div>
                </div><!-- card-header -->
                <div class="card-body">
                    <div id="loanOverViewBar"></div>
                </div><!-- card-body -->
            </div><!-- card -->
        </div>
        <div class="col-sm-6 col-lg-4">
            <div class="card ">
                <div class="card-header">
                    <h6 class="card-title mg-b-10">Expenses</h6>
                    <div class="select-wrapper">
                        <select id="filter-select" style='border:none;'>
                            <option value="last-month">Last Month</option>
                            <option value="last-quarter">Last Quarter</option>
                            <option value="last-year">Last Year</option>
                        </select>
                    </div>
                </div><!-- card-header -->
                <div class="card-body">
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
        <div class="col-sm-6 col-lg-4 mg-t-20 mg-sm-t-0">
            <div class="card card-dashboard-donut">
                <div class="card-header">
                    <h6 class="card-title mg-b-10">STATISTICS OVERVIEW</h6>
                    <div class="select-wrapper">
                        <select id="filter-select" style='border:none;'>
                            <option value="last-month">Last Month</option>
                            <option value="last-quarter">Last Quarter</option>
                            <option value="last-year">Last Year</option>
                        </select>
                    </div>
                </div><!-- card-header -->
                <div class="card-body">
                    <div id='statisticsChart' style='width:320px; height:298px'>
                    </div>
                </div><!-- card-body -->
            </div><!-- card -->
        </div>
        <div class="col-sm-6 col-lg-4 mg-t-20">
            <div class="card ">
                <div class="card-header">
                    <h6 class="card-title mg-b-10">Revenues</h6>
                    <div class="select-wrapper">
                        <select id="filter-select" style='border:none;'>
                            <option value="last-month">Last Month</option>
                            <option value="last-quarter">Last Quarter</option>
                            <option value="last-year">Last Year</option>
                        </select>
                    </div>
                </div><!-- card-header -->
                <div class="card-body">
                    <div>
                        <span><strong> {!! showAmount($loandata->fees_total) !!}</strong></span>
                        <p class='text-muted'>Total Revenues</p>
                    </div>
                    <div id="revenueChart">

                    </div>
                </div><!-- card-body -->
            </div><!-- card -->
        </div>
        <div class="col-sm-6 col-lg-4 mg-t-20">
            <div class="card ">
                <div class="card-header">
                    <h6 class="card-title mg-b-10">Savings Overview</h6>
                    {{-- <div class="select-wrapper">
                        <select id="filter-select" style='border:none;'>
                            <option value="last-month">Last Month</option>
                            <option value="last-quarter">Last Quarter</option>
                            <option value="last-year">Last Year</option>
                        </select>
                    </div> --}}
                </div><!-- card-header -->
                <div class="card-body">
                    <div class='col-md-12 mt-3'>
                        <div class='row'>
                            <div class='col-md-12'>
                                <h4><strong>
                                        {!! isset($savingdata->deposit_amount) ? showAmount($savingdata->deposit_amount) : 0 !!}
                                    </strong>
                                </h4>
                            </div>
                            <div class='col-md-12'>
                                <small class='mb-0' style="color:#1976d2;">Savings for last 30 days
                                </small>
                            </div>
                            <br />
                            <br />
                            <br />

                            <div class='col-md-6 col-xl-6 col-6'>
                                <small style="color:0000;"><b>
                                        {!! isset($accountdata->current_balance) ? showAmount($accountdata->current_balance) : 0 !!}

                                    </b></small>
                            </diV>
                            <div class='col-md-6 col-xl-6 col-6'>
                                <small style="color:0000;">
                                    <b>
                                        {!! isset($accountdata->available_balance) ? showAmount($accountdata->available_balance) : 0 !!}
                                    </b>
                                </small>
                            </diV>
                            <div class='col-md-6 col-xl-6 col-6'>
                                <small>
                                    Current balance
                                </small>
                            </diV>
                            <div class='col-md-6 col-xl-6 col-6'>
                                <small>
                                    Available balance
                                </small>
                            </diV>
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
                            </diV>
                            <div class='col-md-6 col-xl-6 col-6'>
                                <small style="color:0000;">
                                    <b>
                                        {!! showAmount($loandata->principal_amount) !!}
                                    </b>
                                </small>
                            </diV>
                            <div class='col-md-6 col-xl-6 col-6'>
                                <small>
                                    Deposited
                                </small>
                            </diV>
                            <div class='col-md-6 col-xl-6 col-6'>
                                <small>
                                    Not deposited
                                </small>
                            </diV>
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
        {{-- <div class="col-lg-6 mg-t-20">
            <div class="card card-dashboard-ratio">
                <div class="card-body">
                    <div>
                        <div class="card-icon"><i class="typcn typcn-chart-line-outline"></i></div>
                    </div>
                    <div>
                        <h6 class="card-title mg-b-7">Quick Ratio</h6>
                        <h5>0.9:8</h5>
                        <div class="progress ht-5 mg-b-5">
                            <div class="progress-bar bg-warning wd-90p" role="progressbar" aria-valuenow="90"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <span class="tx-12 tx-gray-500">Quick Ratio Goal: 1.0 or higher</span>

                        <p class="mg-t-10 mg-b-0">Measures your Current Assets + Accounts Receivable / Current
                            Liabilities <a href="">Learn more</a></p>
                    </div>
                </div><!-- card-body -->
                <div class="card-body">
                    <div>
                        <div class="card-icon"><i class="typcn typcn-chart-area-outline"></i></div>
                    </div>
                    <div>
                        <h6 class="card-title mg-b-7">Current Ratio</h6>
                        <h5>2.8</h5>
                        <div class="progress ht-5 mg-b-5">
                            <div class="progress-bar bg-success wd-60p" role="progressbar" aria-valuenow="60"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <span class="tx-12 tx-gray-500">Quick Ratio Goal: 2.0 or higher</span>
                        <p class="mg-t-10 mg-b-0">Measures your Current Assets / Current Liabilities. <a
                                href="">Learn more</a></p>
                    </div>
                </div><!-- card-body -->
            </div><!-- card -->
        </div> --}}
        {{-- <div class="col-lg-6 mg-t-20">
            <div class="row row-sm">
                <div class="col-sm-6">
                    <div class="card card-dashboard-finance">
                        <h6 class="card-title">Total Income</h6>
                        <span class="peity-bar"
                            data-peity='{ "fill": ["#560bd0"], "height": 27, "width": 70 }'>7,5,9,10,1,4,4,7,5,10,4,4</span>
                        <h2><span>$</span>83,320<small>.50</small></h2>
                        <span class="tx-12"><span class="tx-success tx-bold">18.2%</span> higher vs previous
                            month</span>
                    </div>
                </div><!-- col -->
                <div class="col-sm-6 mg-t-20 mg-sm-t-0">
                    <div class="card card-dashboard-finance">
                        <h6 class="card-title">Total Expenses</h6>
                        <span class="peity-bar"
                            data-peity='{ "fill": ["#007bff"], "height": 27, "width": 70 }'>10,4,4,7,5,9,10,3,4,4,7,5</span>
                        <h2><span>$</span>32,370<small>.00</small></h2>
                        <span class="tx-12"><span class="tx-danger tx-bold">0.7%</span> higher vs previous
                            month</span>
                    </div>
                </div><!-- col -->
                <div class="col-sm-6 mg-t-20">
                    <div class="card card-dashboard-finance">
                        <h6 class="card-title">Accounts Receivable</h6>
                        <span class="peity-bar"
                            data-peity='{ "fill": ["#00cccc"], "height": 27, "width": 70 }'>7,5,9,10,5,4,4,7,5,10,4,4</span>
                        <h2><span>$</span>9,112<small>.00</small></h2>
                        <span class="tx-12"><span class="tx-success tx-bold">0.7%</span> higher vs previous
                            month</span>
                    </div>
                </div><!-- col -->
                <div class="col-sm-6 mg-t-20">
                    <div class="card card-dashboard-finance">
                        <h6 class="card-title">Accounts Payable</h6>
                        <span class="peity-bar"
                            data-peity='{ "fill": ["#f10075"], "height": 27, "width": 70 }'>1,4,4,7,5,10,4,7,5,9,10,4</span>
                        <h2><span>$</span>8,216<small>.00</small></h2>
                        <span class="tx-12"><span class="tx-success tx-bold">0.7%</span> higher vs previous
                            month</span>
                    </div>
                </div><!-- col -->
            </div><!-- row -->
        </div> --}}
        {{-- <div class="col-12 mg-t-20">
            <div class="card card-dashboard-table-six">
                <div class=' card-header d-flex justify-content-between'>
                    <h6 class="card-title">RECENT TRANSACTIONS</h6>
                    <i class="typcn typcn-pencil"></i>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($recentTransaction as $item)
                            <div class="col-md-4 recentTransactions">
                                <div class="w-100 paper">
                                    <div class="row mx-0 d-flex justify-content-between w-100 align-items-center">
                                        <h5 class="card-title mb-0" style="font-size:10px">TID {{ $item->id }}</h5>

                                        <div><i class="typcn typcn-tick-outline icon" style="color:#3366CC;"></i>
                                            <!-- <span class="font-size-12"> Pending</span> -->
                                        </div>
                                    </div>
                                    <br />
                                    <div class="d-flex justify-content-between paperbody">
                                        <span class="font-size-12" style="color:#1976d2;">
                                            <i class="typcn typcn-user icon"></i> &nbsp;
                                            {{ $item->member->fname }}
                                        </span>
                                    </div>
                                    <div class="d-flex flex-column py-2 paperbody">
                                        <div class="d-flex justify-content-between">
                                            <span style='font-size:10px'>Previous Balance</span>
                                            <span style='font-size:10px'>{!! showAmount($item->loan_amount) !!}</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span style='font-size:10px; color:green;'>Amount Paid</span>
                                            <span style='font-size:10px; color:green;'>{!! showAmount($item->loan_amount - $item->balance_amount) !!}</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span style='font-size:10px; color:#f85359'>Remaining Balance</span>
                                            <span style='font-size:10px; color:#f85359'>{!! showAmount($item->balance_amount) !!}</span>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <i style='font-size:8px'>{{ $item->updated_at }}</i>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div><!-- card -->
        </div><!-- col --> --}}
        {{-- <div class="col-12 mg-t-20">
            <div class="card card-dashboard-table-six">
                <div class=' card-header d-flex justify-content-between'>
                    <h6 class="card-title">RECENT LOAN APPLICATIONS</h6>
                    <i class="typcn typcn-pencil"></i>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($loanTransaction as $item)
                            <div class="col-md-4 recentTransactions">
                                <div class="col-md-12 px-0 d-flex flex-wrap w-100 gap_2 mb-3">
                                    <div class="w-100 paper">
                                        <div class="row mx-0 d-flex justify-content-between w-100 align-items-center">
                                            <h5 class="card-title mb-0 font-size-12"
                                                style="color:#808080; font-weight:500px">
                                                {{ $item->loan_no }}</h5>

                                            <div><i class="typcn typcn-tick-outline icon" style="color:red;"></i>
                                                <!-- <span class="font-size-12"> Pending</span> -->
                                            </div>
                                        </div>
                                        </br>
                                        <span class="paperbody font-size-12"
                                            style="color:#3366CC;text-transform:capitalize;">
                                            <i class="typcn typcn-user icon">&nbsp;{{ $item->member->fname }}</i>
                                        </span>
                                        <div class="d-flex justify-content-between paperbody">
                                            <i class="font-size-12">{{ $item->updated_at }}</i>
                                        </div>
                                        <div class="d-flex flex-column py-2 paperbody">
                                            <div class="d-flex justify-content-between">
                                                <span style="font-size:10px; color:#FF9900">Principal</span>
                                                <span style="font-size:10px; color:#FF9900">
                                                    {!! showAmount($item->principal_amount) !!}</span>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <span style="font-size:10px; color:#F85359">Loan Amount </span>
                                                <span style="font-size:10px; color:#F85359">
                                                    {!! showAmount($item->interest_amount) !!}</span>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <span style="font-size:10px; color:#337BD6">Loan Charges </span>
                                                <span style="font-size:10px; color:#337BD6">
                                                    {!! isset($loandata->fees_total) ? showAmount($loandata->fees_total) : 0 !!}</span>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div><!-- card -->
        </div><!-- col --> --}}
        <div class="col-12 mg-t-20">
            <div class="card card-dashboard-table-six">
                <h6 class="card-title">Recent Transactions</h6>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
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
                                <td>{{$item->id}}</td>
                                <td>{{$item->member->fname}}</td>
                                <td>{!! showAmount($item->loan_amount) !!}</td>
                                <td>{!! showAmount($item->loan_amount - $item->balance_amount) !!}</td>
                                <td>{!! showAmount($item->balance_amount) !!}</span></td>
                                <td>{{$item->payment_type}}</td>
                                <td>{{$item->paid_by}}</td>
                                <td>{{$item->date}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div><!-- table-responsive -->
            </div><!-- card -->
        </div><!-- col -->
        <div class="col-12 mg-t-20">
            <div class="card card-dashboard-table-six">
                <h6 class="card-title">Recent Loan Applications</h6>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
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
                                <td>{{$item->loan_no}}</td>
                                <td>{{$item->member->fname}}</td>
                                <td>{{$item->loan_type}}</td>
                                <td>{{$item->loanproduct->name}}</td>
                                <td>{!! showAmount($item->principal_amount) !!}</td>
                                <td>{!! showAmount($item->interest_amount) !!}</td>
                                <td>{{$item->payment_mode}}</td>
                                @if($item->status === 0)
                                 <td><button class='btn btn-sm btn-warning'>PENDING</button></td>
                                @elseif($item->status === 1)
                                <td><button class='btn btn-sm btn-info'>REVIEWED</button></td>
                                @elseif($item->status === 2)
                                <td><button class='btn btn-sm btn-success'>APPROVED</button></td>
                                @else
                                <td><button class='btn btn-sm btn-danger'>REJECTED</button></td>
                                @endif
                                <td>{{$item->updated_at}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div><!-- table-responsive -->
            </div><!-- card -->
        </div><!-- col -->
        {{-- <div id="loanOverViewBar2" style='width:500px; height:500px'>
        </div> --}}
    </div><!-- row -->
@endsection
@section('scripts')
    <script>
        var loanData = @json($loanOverViewData);
        var expenseData = @json($expenseCategoryData);
        var revenueData = @json($revenueData);
        var recentTransact=@json($recentTransaction);
        var statisticsData = @json($statisticsData);
        console.log(recentTransact);
        console.log(@json($loanTransaction))
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

        var barColors = ['#0b62a4', '#7a92a3', '#4da74d'];

        new Morris.Bar({
            element: 'loanOverViewBar',
            data: formattedLoanData,
            xkey: 'label',
            ykeys: ['value'],
            labels: ['Amount'],
            barColors: function(row, series, type) {
                return barColors[row.x];
            },
            resize: true
        });


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

        plotRevenues();

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
    </script>
@endsection
