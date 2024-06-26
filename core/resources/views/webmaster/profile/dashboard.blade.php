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
    </style>
@endsection
@section('content')
    <div class="row row-sm">
        <div class="col-sm-6 col-lg-4">
            <div class="card card-dashboard-donut">
                <div class="card-header">
                    <h6 class="card-title mg-b-10">Expenses</h6>
                </div><!-- card-header -->
                <div class="card-body">
                    <div class="" id='expenseChart' style='height:200px;width:200px'>

                    </div>
                </div><!-- card-body -->
            </div><!-- card -->
        </div>
        <div class="col-sm-6 col-lg-4 mg-t-20 mg-sm-t-0">
            <div class="card card-dashboard-donut">
                <div class="card-header">
                    <h6 class="card-title mg-b-10">Net Profit Margin</h6>
                    <p class="mg-b-0 tx-12 tx-gray-500">Measures your business at generating prof... <a href="">Learn
                            more</a></p>
                </div><!-- card-header -->
                <div class="card-body">
                    <div class="az-donut-chart chart2">
                        <div class="slice one"></div>
                        <div class="slice two"></div>
                        <div class="chart-center">
                            <span></span>
                        </div>
                    </div>
                </div><!-- card-body -->
            </div><!-- card -->
        </div>
        <div class="col-lg-4 mg-t-20 mg-lg-t-0">
            <div class="card card-dashboard-loan-over-view">
                <div class="card-header d-flex justify-content-between">
                    <h6 class="card-title mg-b-10">LOAN OVERVIEW</h6>
                    <a class="btn btn-info card-title mg-b-10 ml-auto"
                        href="{{ route('webmaster.loanpayment.create') }}">MAKE PAYMENT</a>
                </div><!-- card-header -->
                <div class="card-body">
                    <div id="loanOverViewBar" class="morris-wrapper-demo"></div>
                </div><!-- card-body -->
            </div><!-- card -->
        </div>
        <div class="col-lg-6 mg-t-20">
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
        </div>
        <div class="col-lg-6 mg-t-20">
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
        </div>
        <div class="col-12 mg-t-20">
            <div class="card card-dashboard-table-six">
                <h6 class="card-title">Financial Management Review</h6>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th colspan="5">Quarter To Date (QTD)</th>
                                <th colspan="2">Year To Date (YTD)</th>
                            </tr>
                            <tr>
                                <th>&nbsp;</th>
                                <th>Actual</th>
                                <th>Forecast</th>
                                <th>Variance</th>
                                <th>% Variance</th>
                                <th>Actual</th>
                                <th>Forecast</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Office &amp; Supplies</td>
                                <td>232,243</td>
                                <td>399,768</td>
                                <td>40,234</td>
                                <td>5.1%</td>
                                <td>2,983,098</td>
                                <td>2,092,243</td>
                            </tr>
                            <tr>
                                <td>Salaries &amp; Benefits</td>
                                <td>2,232,877</td>
                                <td>3,099,565</td>
                                <td>400,020</td>
                                <td>6.8%</td>
                                <td>28,983,091</td>
                                <td>29,092,765</td>
                            </tr>
                            <tr>
                                <td>Professional Services</td>
                                <td>32,435</td>
                                <td>99,789</td>
                                <td>20,020</td>
                                <td>16.9%</td>
                                <td>183,566</td>
                                <td>292,897</td>
                            </tr>
                            <tr>
                                <td>Human Resources</td>
                                <td>76,877</td>
                                <td>98,565</td>
                                <td>123,020</td>
                                <td>15.0%</td>
                                <td>101,675</td>
                                <td>122,232</td>
                            </tr>
                            <tr>
                                <td>Travel &amp; Entertainment</td>
                                <td>2,232</td>
                                <td>3,099</td>
                                <td>400</td>
                                <td>1.2%</td>
                                <td>13,091</td>
                                <td>14,765</td>
                            </tr>
                            <tr>
                                <td>Grand Total</td>
                                <td>3,433,232</td>
                                <td>4,768,099</td>
                                <td>999,400</td>
                                <td>88.2%</td>
                                <td>30,643,091</td>
                                <td>31,644,765</td>
                            </tr>
                        </tbody>
                    </table>
                </div><!-- table-responsive -->
            </div><!-- card -->
        </div><!-- col -->
    </div><!-- row -->
@endsection
@section('scripts')
    <script>
        var loanData = @json($loanOverViewData);
        var expenseData = @json($expenseCategoryData);


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
            position: 'ne',
            margin: [-20, 0] ,
            labelFormatter: function(label, series) {
                return '<div style="font-size:12px;">' + label + '</div>'; // Custom label formatter
            }
             },
            grid: {
                hoverable: true,
                clickable: true
            }
        });

        function labelFormatter(label, series) {
          return '<div style="font-size:10px; text-align:center; padding:2px; color:white;">' +
            '$' + series.data[0][1].toLocaleString() + ' (' + Math.round(series.percent) + '%)</div>';
        }

    </script>
@endsection
