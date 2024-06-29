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

        .statusBtn {
            padding: 1px 3px;
            font-size: 10px;
            line-height: 0.5;
            border-width: 1px;
            border-radius: 50%;
        }

        .table th,
        .table td {
            text-transform: uppercase;
        }

        .table thead th {
            /* background-color: #596882; */
            background-color:#0040ff;
            color: white;
            text-transform: uppercase;
            text-align: center;
        }

        .table tbody tr td span {
            display: block;
            width: 8px;
            height: 8px;
            border-radius: 100%;
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
    </div><!-- row -->
    <div class="row row-sm">
        <div class="col-md-8">
            <div class="col-12 mg-t-20">
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
                                        <td>TID-{{ $item->id }}-{{ $item->date }}</td>
                                        <td>{{ $item->member->fname }}</td>
                                        <td>{!! showAmount($item->loan_amount) !!}</td>
                                        <td>{!! showAmount($item->loan_amount - $item->balance_amount) !!}</td>
                                        <td>{!! showAmount($item->balance_amount) !!}</span></td>
                                        <td>{{ $item->payment_type }}</td>
                                        <td>{{ $item->paid_by }}</td>
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
                                        <td>{{ $item->loan_no }}</td>
                                        <td>{{ $item->member->fname }}</td>
                                        <td>{{ $item->loan_type }}</td>
                                        <td>{{ $item->loanproduct->name }}</td>
                                        <td>{!! showAmount($item->principal_amount) !!}</td>
                                        <td>{!! showAmount($item->interest_amount) !!}</td>
                                        <td>{{ $item->payment_mode }}</td>
                                        @if ($item->status === 0)
                                            <td><button class='btn btn-sm btn-warning statusBtn'>PENDING</button></td>
                                        @elseif($item->status === 1)
                                            <td><button class='btn btn-sm btn-info statusBtn'>REVIEWED</button></td>
                                        @elseif($item->status === 2)
                                            <td><button class='btn btn-sm btn-success statusBtn'>APPROVED</button></td>
                                        @else
                                            <td><button class='btn btn-sm btn-danger statusBtn'>REJECTED</button></td>
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
        <div class="col-4 mg-t-20 bg-white">
            <div class="az-content-body-right">
                <hr class="mg-y-25">
                <label class="az-content-label tx-base mg-b-25">Activity Stream</label>
                <div class="az-media-list-activity mg-b-20">
                    <div class="media">
                        <div class="media-icon bg-success"><i class="typcn typcn-tick-outline"></i></div>
                        <div class="media-body">
                            <h6>Successful Purchase</h6>
                            <span>Product ID: #0102</span>
                        </div>
                        <div class="media-right">2 hours</div>
                    </div><!-- media -->
                    <div class="media">
                        <div class="media-icon bg-primary"><i class="typcn typcn-shopping-cart"></i></div>
                        <div class="media-body">
                            <h6>Order Verification</h6>
                            <span>Product ID: #2200</span>
                        </div>
                        <div class="media-right">3 hours</div>
                    </div><!-- media -->
                    <div class="media">
                        <div class="media-icon bg-purple"><i class="typcn typcn-arrow-forward-outline"></i></div>
                        <div class="media-body">
                            <h6>Orders For Shipment</h6>
                            <span>Cleared By: Agent#20</span>
                        </div>
                        <div class="media-right">5 hours</div>
                    </div><!-- media -->
                    <div class="media">
                        <div class="media-icon bg-danger"><i class="typcn typcn-times-outline"></i></div>
                        <div class="media-body">
                            <h6>Purchase Cancellation</h6>
                            <span>Product ID: #0102</span>
                        </div>
                        <div class="media-right">6 hours</div>
                    </div><!-- media -->
                    <div class="media">
                        <div class="media-icon bg-success"><i class="typcn typcn-tick-outline"></i></div>
                        <div class="media-body">
                            <h6>Successful Purchase</h6>
                            <span>Product ID: #2070</span>
                        </div>
                        <div class="media-right">10 hours</div>
                    </div><!-- media -->
                    <div class="media">
                        <div class="media-icon bg-warning"><i class="typcn typcn-tick-outline"></i></div>
                        <div class="media-body">
                            <h6>Overdue Shipments</h6>
                            <span>Reminder from: Agent#30</span>
                        </div>
                        <div class="media-right">18 hours</div>
                    </div><!-- media -->
                    <div class="media">
                        <div class="media-icon bg-danger"><i class="typcn typcn-times-outline"></i></div>
                        <div class="media-body">
                            <h6>Purchase Cancellation</h6>
                            <span>Product ID: #0102</span>
                        </div>
                        <div class="media-right">Yesterday</div>
                    </div><!-- media -->
                    <div class="media">
                        <div class="media-icon bg-info"><i class="typcn typcn-times-outline"></i></div>
                        <div class="media-body">
                            <h6>New Item Added</h6>
                            <span>Department: Wearables</span>
                        </div>
                        <div class="media-right">Yesterday</div>
                    </div><!-- media -->
                    <div class="media">
                        <div class="media-icon bg-orange"><i class="typcn typcn-times-outline"></i></div>
                        <div class="media-body">
                            <h6>New Registered Seller</h6>
                            <span>Seller Name: Socrates</span>
                        </div>
                        <div class="media-right">3 days</div>
                    </div><!-- media -->
                    <div class="media">
                        <div class="media-icon bg-success"><i class="typcn typcn-tick-outline"></i></div>
                        <div class="media-body">
                            <h6>Successful Purchase</h6>
                            <span>Product ID: #2070</span>
                        </div>
                        <div class="media-right">4 days</div>
                    </div><!-- media -->
                </div><!-- az-media-list-activity -->
                <a href="" class="btn btn-outline-light btn-block mg-b-20">View All Activities</a>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        var loanData = @json($loanOverViewData);
        var expenseData = @json($expenseCategoryData);
        var revenueData = @json($revenueData);
        var recentTransact = @json($recentTransaction);
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
