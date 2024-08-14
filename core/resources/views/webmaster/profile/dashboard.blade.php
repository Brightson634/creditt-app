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
            text-transform: capitalize;
        }

        .table thead th {
            background-color: #596882;
            /* background-color:#0040ff; */
            color: white;
            text-transform: capitalize;
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

        /**Streams css**/
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
            max-height: 400px;
            /* Set the max height for scrollable area */
            overflow-y: auto;
            margin-left: 10px;
            /* Adjusted to align with hamburger icon */
        }

        .timeline::before {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            width: 2px;
            /* Thinner timeline line */
            background: #28a745;
            /* Green color */
            left: 50px;
            /* Adjusted to align with hamburger icon */
            margin-right: -2px;
        }

        .timeline-item {
            position: relative;
            margin: 0 0 20px;
            padding-left: 70px;
            /* Adjusted to align with hamburger icon */
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 46px;
            /* Adjusted to align with timeline line */
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #ffffff;
            /* White color */
            border: 1px solid #4b5158
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
            color: rgb(51 65 85)
        }
    </style>
@endsection
@section('content')
    {{-- <div class="az-content-body">
        <div class="az-content-body-left">
            <h2 class="az-content-title tx-24 mg-b-5">Hi, welcome back!</h2>
            <p class="mg-b-20">Your product performance and management dashboard template.</p>

            <div class="row row-sm mg-b-20">
                <div class="col-sm-6 col-lg-4">
                    <div class="card card-dashboard-twentysix">
                        <div class="card-header">
                            <h6 class="card-title">Customers</h6>
                            <div class="chart-legend">
                                <div><span class="bg-primary"></span> New</div>
                                <div><span class="bg-teal"></span> Returning</div>
                            </div><!-- chart-legend -->
                        </div><!-- card-header -->
                        <div class="card-body">
                            <div class="pd-x-15">
                                <h6>156 <span class="tx-success"><i class="icon ion-md-arrow-up"></i> 3.7%</span></h6>
                                <label>Avg. Customers/Day</label>
                            </div>
                            <div class="chart-wrapper">
                                <div id="flotChart7" class="flot-chart"></div>
                            </div><!-- chart-wrapper -->
                        </div><!-- card-body -->
                    </div><!-- card -->
                </div><!-- col -->
                <div class="col-sm-6 col-lg-4 mg-t-20 mg-sm-t-0">
                    <div class="card card-dashboard-twentysix card-dark-one">
                        <div class="card-header">
                            <h6 class="card-title">Conversions</h6>
                        </div><!-- card-header -->
                        <div class="card-body">
                            <div class="pd-x-15">
                                <h6>0.23% <span><i class="icon ion-md-arrow-up"></i> 0.20%</span></h6>
                                <label>Purchased</label>
                            </div>
                            <div class="chart-wrapper">
                                <div id="flotChart8" class="flot-chart"></div>
                            </div><!-- chart-wrapper -->
                        </div><!-- card-body -->
                    </div><!-- card -->
                </div><!-- col -->
                <div class="col-lg-4 mg-t-20 mg-lg-t-0">
                    <div class="card card-dashboard-twentysix card-dark-two">
                        <div class="card-header">
                            <h6 class="card-title">Revenue</h6>
                        </div><!-- card-header -->
                        <div class="card-body">
                            <div class="pd-x-15">
                                <h6>$7,299 <span><i class="icon ion-md-arrow-up"></i> 1.18%</span></h6>
                                <label>Total Sales</label>
                            </div>
                            <div class="chart-wrapper">
                                <div id="flotChart9" class="flot-chart"></div>
                            </div><!-- chart-wrapper -->
                        </div><!-- card-body -->
                    </div><!-- card -->
                </div><!-- col -->
            </div><!-- row -->

            <div class="card card-body card-dashboard-twentyfive mg-b-20">
                <h6 class="card-title">Conversions</h6>
                <div class="row row-sm">
                    <div class="col-6 col-sm-4 col-lg">
                        <label class="card-label">Conversion Rate</label>
                        <h6 class="card-value">0.81<small>%</small></h6>
                        <div class="chart-wrapper">
                            <div id="flotChart1" class="flot-chart"></div>
                        </div><!-- chart-wrapper -->
                    </div><!-- col -->
                    <div class="col-6 col-sm-4 col-lg">
                        <label class="card-label">Revenue</label>
                        <h6 class="card-value"><span>$</span>1,095,190</h6>
                        <div class="chart-wrapper">
                            <div id="flotChart2" class="flot-chart"></div>
                        </div><!-- chart-wrapper -->
                    </div><!-- col -->
                    <div class="col-6 col-sm-4 col-lg mg-t-20 mg-sm-t-0">
                        <label class="card-label">Unique Purchases</label>
                        <h6 class="card-value">53</h6>
                        <div class="chart-wrapper">
                            <div id="flotChart3" class="flot-chart"></div>
                        </div><!-- chart-wrapper -->
                    </div><!-- col -->
                    <div class="col-6 col-sm-4 col-lg mg-t-20 mg-lg-t-0">
                        <label class="card-label">Transactions</label>
                        <h6 class="card-value">31</h6>
                        <div class="chart-wrapper">
                            <div id="flotChart4" class="flot-chart"></div>
                        </div><!-- chart-wrapper -->
                    </div><!-- col -->
                    <div class="col-6 col-sm-4 col-lg mg-t-20 mg-lg-t-0">
                        <label class="card-label">Avg. Order Value</label>
                        <h6 class="card-value"><span>$</span>306.20</h6>
                        <div class="chart-wrapper">
                            <div id="flotChart5" class="flot-chart"></div>
                        </div><!-- chart-wrapper -->
                    </div><!-- col -->
                    <div class="col-6 col-sm-4 col-lg mg-t-20 mg-lg-t-0">
                        <label class="card-label">Quantity</label>
                        <h6 class="card-value">52</h6>
                        <div class="chart-wrapper">
                            <div id="flotChart6" class="flot-chart"></div>
                        </div><!-- chart-wrapper -->
                    </div><!-- col -->
                </div><!-- row -->
            </div><!-- card -->

            <div class="row row-sm">
                <div class="col-lg-6">
                    <div class="card card-dashboard-twentyfour">
                        <div class="card-header">
                            <h6 class="card-title">Real Time Sales</h6>
                            <span>This Week</span>
                        </div><!-- card-header -->
                        <div class="card-body">
                            <div class="card-body-top">
                                <div>
                                    <h6><span>$</span>150,200<small>.00</small></h6>
                                    <label>Total Sales</label>
                                </div>
                                <div>
                                    <h6><span>$</span>21,830<small>.25</small></h6>
                                    <label>Avg. Sales per Day</label>
                                </div>
                            </div><!-- card-body-top -->

                            <div class="d-flex justify-content-between mg-b-15">
                                <label class="az-content-label">Sales Per Hour</label>
                                <div class="chart-legend">
                                    <div><span class="bg-primary"></span> Today</div>
                                    <div><span class="bg-gray-400"></span> Yesterday</div>
                                </div><!-- chart-legend -->
                            </div>
                            <div class="chart-wrapper">
                                <div id="flotBar1" class="flot-chart"></div>
                            </div><!-- chart-wrapper -->
                        </div><!-- card-body -->
                    </div><!-- card -->
                </div><!-- col -->
                <div class="col-lg-6 mg-t-20 mg-lg-t-0">
                    <div class="card card-dashboard-twentyfour">
                        <div class="card-header">
                            <h6 class="card-title">Store Visitors</h6>
                            <span>This Week</span>
                        </div><!-- card-header -->
                        <div class="card-body">
                            <div class="card-body-top">
                                <div>
                                    <h6>297,506</h6>
                                    <label>Total Visitors</label>
                                </div>
                                <div>
                                    <h6>38,130</h6>
                                    <label>Visits per Day</label>
                                </div>
                                <div>
                                    <h6>35.07%</h6>
                                    <label>Bounce Rate</label>
                                </div>
                            </div><!-- card-body-top -->

                            <div class="d-flex justify-content-between mg-b-15">
                                <label class="az-content-label">Visitors Per Hour</label>
                                <div class="chart-legend">
                                    <div><span class="bg-pink"></span> Today</div>
                                    <div><span class="bg-gray-400"></span> Yesterday</div>
                                </div><!-- chart-legend -->
                            </div>
                            <div class="chart-wrapper">
                                <div id="flotLine1" class="flot-chart"></div>
                            </div><!-- chart-wrapper -->
                        </div><!-- card-body -->
                    </div><!-- card -->
                </div><!-- col -->
                <div class="col-lg-8 mg-t-20">
                    <div class="card card-table-two">
                        <h6 class="card-title">Most Recent Earnings</h6>
                        <span class="d-block mg-b-20">This is the most recent earnings for today's date.</span>
                        <div class="table-responsive">
                            <table class="table table-striped table-dashboard-two mg-b-0">
                                <thead>
                                    <tr>
                                        <th class="wd-lg-25p">Date</th>
                                        <th class="wd-lg-25p tx-right">Sales Count</th>
                                        <th class="wd-lg-25p tx-right">Earnings</th>
                                        <th class="wd-lg-25p tx-right">Tax Witheld</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>05 Oct 2018</td>
                                        <td class="tx-right tx-medium tx-inverse">25</td>
                                        <td class="tx-right tx-medium tx-inverse">$380.50</td>
                                        <td class="tx-right tx-medium tx-danger">-$23.50</td>
                                    </tr>
                                    <tr>
                                        <td>04 Oct 2018</td>
                                        <td class="tx-right tx-medium tx-inverse">34</td>
                                        <td class="tx-right tx-medium tx-inverse">$503.20</td>
                                        <td class="tx-right tx-medium tx-danger">-$13.45</td>
                                    </tr>
                                    <tr>
                                        <td>03 Oct 2018</td>
                                        <td class="tx-right tx-medium tx-inverse">30</td>
                                        <td class="tx-right tx-medium tx-inverse">$489.65</td>
                                        <td class="tx-right tx-medium tx-danger">-$20.98</td>
                                    </tr>
                                    <tr>
                                        <td>02 Oct 2018</td>
                                        <td class="tx-right tx-medium tx-inverse">27</td>
                                        <td class="tx-right tx-medium tx-inverse">$421.80</td>
                                        <td class="tx-right tx-medium tx-danger">-$22.22</td>
                                    </tr>
                                    <tr>
                                        <td>01 Oct 2018</td>
                                        <td class="tx-right tx-medium tx-inverse">31</td>
                                        <td class="tx-right tx-medium tx-inverse">$518.60</td>
                                        <td class="tx-right tx-medium tx-danger">-$23.01</td>
                                    </tr>
                                    <tr>
                                        <td>01 Oct 2018</td>
                                        <td class="tx-right tx-medium tx-inverse">31</td>
                                        <td class="tx-right tx-medium tx-inverse">$518.60</td>
                                        <td class="tx-right tx-medium tx-danger">-$23.01</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div><!-- table-responsive -->
                    </div><!-- card-dashboard-five -->
                </div><!-- col -->
                <div class="col-lg-4 mg-t-20">
                    <div class="card card-dashboard-eight bg-white">
                        <h6 class="card-title">Your Top Countries</h6>
                        <span class="d-block mg-b-20">Sales performance revenue based by country</span>

                        <div class="list-group">
                            <div class="list-group-item">
                                <i class="flag-icon flag-icon-us flag-icon-squared"></i>
                                <p>United States</p>
                                <span>$1,671.10</span>
                            </div><!-- list-group-item -->
                            <div class="list-group-item">
                                <i class="flag-icon flag-icon-nl flag-icon-squared"></i>
                                <p>Netherlands</p>
                                <span>$1,064.75</span>
                            </div><!-- list-group-item -->
                            <div class="list-group-item">
                                <i class="flag-icon flag-icon-gb flag-icon-squared"></i>
                                <p>United Kingdom</p>
                                <span>$1,055.98</span>
                            </div><!-- list-group-item -->
                            <div class="list-group-item">
                                <i class="flag-icon flag-icon-ca flag-icon-squared"></i>
                                <p>Canada</p>
                                <span>$1,045.49</span>
                            </div><!-- list-group-item -->
                            <div class="list-group-item">
                                <i class="flag-icon flag-icon-au flag-icon-squared"></i>
                                <p>Australia</p>
                                <span>$1,042.00</span>
                            </div><!-- list-group-item -->
                        </div><!-- list-group -->
                    </div><!-- card -->
                </div><!-- col -->
            </div><!-- row -->
        </div>
        <div class="az-content-body-right">
            <div class="row mg-b-20">
                <div class="col">
                    <label class="az-rating-label">Seller Score</label>
                    <h6 class="az-rating-value">98%</h6>
                </div><!-- col -->
                <div class="col">
                    <label class="az-rating-label">Rating Score</label>
                    <h6 class="az-rating-value">4.5</h6>
                </div><!-- col -->
            </div><!-- row -->
            <hr class="mg-y-25">
            <label class="az-content-label tx-base mg-b-25">2 Recent Reviews</label>
            <div class="az-media-list-reviews">
                <div class="media">
                    <div class="az-img-user"><img src="https://via.placeholder.com/500" alt=""></div>
                    <div class="media-body">
                        <div class="d-flex justify-content-between mg-b-10">
                            <div>
                                <h6 class="mg-b-0">Socrates Itumay</h6>
                                <div class="az-star-group">
                                    <div class="az-star-item"><i class="icon ion-md-star"></i></div>
                                    <div class="az-star-item"><i class="icon ion-md-star"></i></div>
                                    <div class="az-star-item"><i class="icon ion-md-star"></i></div>
                                    <div class="az-star-item"><i class="icon ion-md-star"></i></div>
                                    <div class="az-star-item"><i class="icon ion-md-star"></i></div>
                                    <span>4.1</span>
                                </div><!-- star-group -->
                            </div>
                            <small>1 hour ago</small>
                        </div>
                        <p class="mg-b-0">Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed amet...<a
                                href="">Read more</a></p>
                    </div><!-- media-body -->
                </div><!-- media -->
                <div class="media">
                    <div class="az-img-user"><img src="https://via.placeholder.com/500" alt=""></div>
                    <div class="media-body">
                        <div class="d-flex justify-content-between mg-b-10">
                            <div>
                                <h6 class="mg-b-0">Reynante Labares</h6>
                                <div class="az-star-group">
                                    <div class="az-star-item"><i class="icon ion-md-star"></i></div>
                                    <div class="az-star-item"><i class="icon ion-md-star"></i></div>
                                    <div class="az-star-item"><i class="icon ion-md-star"></i></div>
                                    <div class="az-star-item"><i class="icon ion-md-star"></i></div>
                                    <div class="az-star-item"><i class="icon ion-md-star"></i></div>
                                    <span>4.5</span>
                                </div><!-- star-group -->
                            </div>
                            <small>2 days ago</small>
                        </div>
                        <p class="mg-b-0">Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed amet...<a
                                href="">Read more</a></p>
                    </div><!-- media-body -->
                </div><!-- media -->
            </div><!-- media-list -->

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
            <a href="" class="btn btn-outline-light btn-block">View All Activities</a>
        </div>
    </div> --}}
    <div class="row row-sm">
        <div class='row'>
            <div class="col-md-7 col-lg-7 col-xl-8">
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

            <div class="col-sm-6 col-lg-5" style="padding-bottom:20px">
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
                        <div class="col-sm-8 col-md-5">
                            <div class="row">
                                <div class="col-sm-7">
                                    <div id="flotPie" class="wd-100p ht-200"></div>
                                </div>
                                <div class="col-sm-5">
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
                                </div>
                            </div>
                        </div><!-- col -->


                        <div id="revenueChart">

                        </div>
                    </div><!-- card-body -->
                </div><!-- card -->
            </div>
        </div>

        <div class="col-sm-6 col-lg-4">
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
        <div class="col-lg-4">

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
        <!--activity stream-->
        <div class="col-sm-6 col-lg-4">
            <div class="card">
                <div class="card-header">
                    <span class="hamburger-icon">☰</span>
                    <span class="latest_activity">Activity Stream</span>
                </div>
                <div class="card-body">
                    <ul class="timeline">
                        <li class="timeline-item">
                            <span class="time">2 HRS AGO</span>
                            <div class="content">
                                <h5 class="mb-1">Jasmin Harris - Task Status Changed</h5>
                                <p class="mb-1"><strong>Project Name:</strong> <a href="#">Website
                                        Redesign</a></p>
                                <p>Fix an open issue in our software - <span class="badge badge-secondary">Not
                                        Started</span></p>
                            </div>
                        </li>
                        <li class="timeline-item">
                            <span class="time">10 HRS AGO</span>
                            <div class="content">
                                <h5 class="mb-1">Jasmin Harris - Commented on discussion</h5>
                                <p class="mb-1"><strong>Project Name:</strong> <a href="#">Build Website</a>
                                </p>
                                <p>Feedback for the mockup</p>
                            </div>
                        </li>
                        <li class="timeline-item">
                            <span class="time">10 HRS AGO</span>
                            <div class="content">
                                <h5 class="mb-1">Jasmin Harris - Commented on discussion</h5>
                                <p class="mb-1"><strong>Project Name:</strong> <a href="#">Build Website</a>
                                </p>
                                <p>Feedback for the mockup</p>
                            </div>
                        </li>
                        <li class="timeline-item">
                            <span class="time">10 HRS AGO</span>
                            <div class="content">
                                <h5 class="mb-1">Jasmin Harris - Commented on discussion</h5>
                                <p class="mb-1"><strong>Project Name:</strong> <a href="#">Build Website</a>
                                </p>
                                <p>Feedback for the mockup</p>
                            </div>
                        </li>
                        <li class="timeline-item">
                            <span class="time">10 HRS AGO</span>
                            <div class="content">
                                <h5 class="mb-1">Jasmin Harris - Commented on discussion</h5>
                                <p class="mb-1"><strong>Project Name:</strong> <a href="#">Build Website</a>
                                </p>
                                <p>Feedback for the mockup</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>


        </div>
        <!--loan overview-->
        <div class="col-4">
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
        <!--statistics overview-->
        <div class="col-sm-6 col-lg-4">
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
                                        <td>{{ ucwords(strtolower($item->member->fname)) }}</td>
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
