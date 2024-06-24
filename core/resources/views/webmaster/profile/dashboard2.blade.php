@extends('webmaster.partials.dashboard.main')
@section('title')
{{ $page_title }}
@endsection
@section('content')
 <div class="row">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class='row  '>
                                <div class="col-md-6">
                                    <strong class="card-title align-self-center">LOAN OVERVIEW</strong>
                                </div>
                                <div class="col-md-6">
                                    <div class='row justify-content-end'>
                                        <a class="btn  btn-sm btn-outline-secondary"
                                            href="{{ route('webmaster.loanpayment.create') }}" role="button">Make
                                            payment</a>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-12 col-xl-12 col-12">
                                    <div id="chart_div">
                                        {!! $lava->render('ColumnChart', 'IMDB', 'chart_div') !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='row'>
                        <!--  -->
                        <div class='col-md-6 col-xl-6 col-12'>
                            <div class='card'>
                                <div class="card-body">
                                    <div class='row'>
                                        <div class='col-md-12'>
                                            <strong class='fs-6'>SAVINGS OVERVIEW</strong>
                                        </div>
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
                                                        <div class="progress-bar bg-warn" role="progressbar"
                                                            style="width: 70%" aria-valuenow="70" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
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
                                                        <div class="progress-bar bg-danger" role="progressbar"
                                                            style="width: 70%" aria-valuenow="70" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>
                        </div>
                        <!--  -->
                        <div class='col-md-6 col-xl-6 col-12'>
                            <div class='card'>
                                <div class="card-body">
                                    <div class='row'>
                                        <div class='col-md-8'>
                                            <strong class='fs-6'>REVENUES</strong>
                                        </div>
                                        <div class=' col-md-4'>
                                            <small class='text-muted mb-0'>30 days <i
                                                    class='mdi mdi-chevron-down'></i></small>
                                        </div>

                                        <div class='col-md-12 mt-2'>
                                            <div class='row'>
                                                <div class='col-md-12'>
                                                    <h4><strong>
                                                            {!! showAmount($loandata->fees_total) !!}
                                                        </strong></h4>
                                                </div>
                                                <div class='col-md-12'>
                                                    <small class='mb-0' style="color:#1976d2;">Total Revenues</small>
                                                </div>

                                                <div class='col-md-12'>
                                                    <div id='chart'>
                                                        {!! $lava->render('DonutChart', 'LOANS', 'chart') !!}

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <!--  -->
                        <div class='col-md-6 col-xl-6 col-12'>
                            <div class='card'>
                                <div class="card-body">
                                    <div class='row'>
                                        <div class='col-md-12'>
                                            <strong class='fs-6'>EXPENSES</strong>
                                        </div>

                                        <div class='col-md-12 mt-3'>
                                            <div class='row'>
                                                <div class='col-md-12'>
                                                    <h4><strong>
                                                            {!! showAmount($expense->amount) !!}
                                                        </strong></h4>
                                                </div>
                                                <div class='col-md-12'>
                                                    <small class='mb-0' style="color:#1976d2;">Total Expenses</small>
                                                </div>
                                                <br />
                                                <br />
                                                <div class='col-md-12'>
                                                    <div id='chart_expense'>
                                                        {!! $lava->render('ColumnChart', 'EXPENSES', 'chart_expense') !!}

                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>
                        </div>
                        <!--  -->
                        <div class='col-md-6 col-xl-6 col-12'>
                            <div class='card'>
                                <div class="card-body">
                                    <div class='row'>
                                        <div class='col-md-8'>
                                            <strong class='fs-6'>INVESTMENT</strong>
                                        </div>
                                        <div class=' col-md-4'>
                                            <small class='text-muted mb-0'>last 30 days <i
                                                    class='mdi mdi-chevron-down'></i></small>
                                        </div>

                                        <div class='col-md-12 mt-4'>
                                            <div class='row'>
                                                <div class='col-md-12'>
                                                    <h4><strong>
                                                            {!! isset($investmentdata->investment_amount) ? showAmount($investmentdata->investment_amount) : 0 !!}

                                                        </strong></h4>
                                                </div>
                                                <div class='col-md-12'>
                                                    <small class='mb-0' style="color:#1976d2;">Total investments</small>
                                                </div>
                                                <div class='col-md-12'>
                                                    <div id='chart_pop'>
                                                        {!! $lava->render('AreaChart', 'Population', 'chart_pop') !!}

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class='row  '>
                            <div class="col-md-12">
                                <strong class="card-title align-self-center">STATISTIC OVERVIEW</strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-xl-12 col-12">
                                <div id="chart_divs">
                                    {!! $lava->render('LineChart', 'STATISTIC', 'chart_divs') !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- row  -->
        </div>
        <div class="col-md-4">
            <div class='row'>

                <div class='col-md-12 col-xl-12 col-sm-12 mb-3'>
                    <div class="card mb-0">
                        <div class="card-body">
                            <div class="row mx-0">
                                <div class="row mx-0 d-flex justify-content-between mb-4 w-100">
                                    <h5 class="card-title mb-0" style="font-weight:700">RECENT TRANSACTIONS</h5>
                                    <i class="mdi mdi-pencil"></i>
                                </div>
                                <div class="col-md-12 px-0 d-flex flex-wrap w-100 gap_2">
                                    @foreach ($recentTransaction as $item)
                                        <div class="w-100 paper">
                                            <div class="row mx-0 d-flex justify-content-between w-100 align-items-center">
                                                <h5 class="card-title mb-0" style="font-size:10px">TID {{ $item->id }}
                                                </h5>

                                                <div><i class="mdi mdi-checkbox-marked-circle-outline"
                                                        style="color:#3366CC;"></i>
                                                    <!-- <span class="font-size-12"> Pending</span> -->
                                                </div>
                                            </div>
                                            <br />
                                            <div class="d-flex justify-content-between paperbody">
                                                <span class="font-size-12" style="color:#1976d2;">
                                                    <span class="mdi mdi-account" /> &nbsp;
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
                                                    <span
                                                        style='font-size:10px; color:green;'>{!! showAmount($item->loan_amount - $item->balance_amount) !!}</span>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <span style='font-size:10px; color:#f85359'>Remaining Balance</span>
                                                    <span
                                                        style='font-size:10px; color:#f85359'>{!! showAmount($item->balance_amount) !!}</span>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-end">
                                                <i style='font-size:8px'>{{ $item->updated_at }}</i>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>


            <div class='col-md-12 col-xl-12 col-sm-12'>
                <div class="card mb-0">
                    <div class="card-body">
                        <div class="row mx-0">
                            <div class="row mx-0 d-flex justify-content-between mb-4 w-100">
                                <h5 class="card-title mb-0" style="font-weight:700 ">LOAN APPLICATIONS</h5>
                                <i class="mdi mdi-pencil"></i>
                            </div>

                            @foreach ($loanTransaction as $item)
                                <div class="col-md-12 px-0 d-flex flex-wrap w-100 gap_2 mb-3">
                                    <div class="w-100 paper">
                                        <div class="row mx-0 d-flex justify-content-between w-100 align-items-center">
                                            <h5 class="card-title mb-0 font-size-12"
                                                style="color:#808080; font-weight:500px">{{ $item->loan_no }}</h5>

                                            <div><i class="mdi mdi-checkbox-marked-circle-outline" style="color:red;"></i>
                                                <!-- <span class="font-size-12"> Pending</span> -->
                                            </div>
                                        </div>
                                        </br>
                                        <span class="paperbody font-size-12"
                                            style="color:#3366CC;text-transform:capitalize;">
                                            <span class="mdi mdi-account"> &nbsp;{{ $item->member->fname }}</span>
                                            <div class="d-flex justify-content-between paperbody">
                                                <i class="font-size-12">{{ $item->uptaded_at }}</i>
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
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
          {{-- <div class="az-dashboard-one-title">
            <div>
              <h2 class="az-dashboard-title">Hi, welcome back!</h2>
              <p class="az-dashboard-text">Your web analytics dashboard template.</p>
            </div>
            <div class="az-content-header-right">
              <div class="media">
                <div class="media-body">
                  <label>Start Date</label>
                  <h6>Oct 10, 2018</h6>
                </div><!-- media-body -->
              </div><!-- media -->
              <div class="media">
                <div class="media-body">
                  <label>End Date</label>
                  <h6>Oct 23, 2018</h6>
                </div><!-- media-body -->
              </div><!-- media -->
              <div class="media">
                <div class="media-body">
                  <label>Event Category</label>
                  <h6>All Categories</h6>
                </div><!-- media-body -->
              </div><!-- media -->
              <a href="" class="btn btn-purple">Export</a>
            </div>
          </div><!-- az-dashboard-one-title -->

          <div class="az-dashboard-nav">
            <nav class="nav">
              <a class="nav-link active" data-toggle="tab" href="#">Overview</a>
              <a class="nav-link" data-toggle="tab" href="#">Audiences</a>
              <a class="nav-link" data-toggle="tab" href="#">Demographics</a>
              <a class="nav-link" data-toggle="tab" href="#">More</a>
            </nav>

            <nav class="nav">
              <a class="nav-link" href="#"><i class="far fa-save"></i> Save Report</a>
              <a class="nav-link" href="#"><i class="far fa-file-pdf"></i> Export to PDF</a>
              <a class="nav-link" href="#"><i class="far fa-envelope"></i>Send to Email</a>
              <a class="nav-link" href="#"><i class="fas fa-ellipsis-h"></i></a>
            </nav>
          </div>

          <div class="row row-sm mg-b-20">
            <div class="col-lg-7 ht-lg-100p">
              <div class="card card-dashboard-one">
                <div class="card-header">
                  <div>
                    <h6 class="card-title">Website Audience Metrics</h6>
                    <p class="card-text">Audience to which the users belonged while on the current date range.</p>
                  </div>
                  <div class="btn-group">
                    <button class="btn active">Day</button>
                    <button class="btn">Week</button>
                    <button class="btn">Month</button>
                  </div>
                </div><!-- card-header -->
                <div class="card-body">
                  <div class="card-body-top">
                    <div>
                      <label class="mg-b-0">Users</label>
                      <h2>13,956</h2>
                    </div>
                    <div>
                      <label class="mg-b-0">Bounce Rate</label>
                      <h2>33.50%</h2>
                    </div>
                    <div>
                      <label class="mg-b-0">Page Views</label>
                      <h2>83,123</h2>
                    </div>
                    <div>
                      <label class="mg-b-0">Sessions</label>
                      <h2>16,869</h2>
                    </div>
                  </div><!-- card-body-top -->
                  <div class="flot-chart-wrapper">
                    <div id="flotChart" class="flot-chart"></div>
                  </div><!-- flot-chart-wrapper -->
                </div><!-- card-body -->
              </div><!-- card -->
            </div><!-- col -->
            <div class="col-lg-5 mg-t-20 mg-lg-t-0">
              <div class="row row-sm">
                <div class="col-sm-6">
                  <div class="card card-dashboard-two">
                    <div class="card-header">
                      <h6>33.50% <i class="icon ion-md-trending-up tx-success"></i> <small>18.02%</small></h6>
                      <p>Bounce Rate</p>
                    </div><!-- card-header -->
                    <div class="card-body">
                      <div class="chart-wrapper">
                        <div id="flotChart1" class="flot-chart"></div>
                      </div><!-- chart-wrapper -->
                    </div><!-- card-body -->
                  </div><!-- card -->
                </div><!-- col -->
                <div class="col-sm-6 mg-t-20 mg-sm-t-0">
                  <div class="card card-dashboard-two">
                    <div class="card-header">
                      <h6>86k <i class="icon ion-md-trending-down tx-danger"></i> <small>0.86%</small></h6>
                      <p>Total Users</p>
                    </div><!-- card-header -->
                    <div class="card-body">
                      <div class="chart-wrapper">
                        <div id="flotChart2" class="flot-chart"></div>
                      </div><!-- chart-wrapper -->
                    </div><!-- card-body -->
                  </div><!-- card -->
                </div><!-- col -->
                <div class="col-sm-12 mg-t-20">
                  <div class="card card-dashboard-three">
                    <div class="card-header">
                      <p>All Sessions</p>
                      <h6>16,869 <small class="tx-success"><i class="icon ion-md-arrow-up"></i> 2.87%</small></h6>
                      <small>The total number of sessions within the date range. It is the period time a user is actively engaged with your website, page or app, etc.</small>
                    </div><!-- card-header -->
                    <div class="card-body">
                      <div class="chart"><canvas id="chartBar5"></canvas></div>
                    </div>
                  </div>
                </div>
              </div><!-- row -->
            </div><!--col -->
          </div><!-- row -->

          <div class="row row-sm mg-b-20">
            <div class="col-lg-4">
              <div class="card card-dashboard-pageviews">
                <div class="card-header">
                  <h6 class="card-title">Page Views by Page Title</h6>
                  <p class="card-text">This report is based on 100% of sessions.</p>
                </div><!-- card-header -->
                <div class="card-body">
                  <div class="az-list-item">
                    <div>
                      <h6>Admin Home</h6>
                      <span>/demo/admin/index.html</span>
                    </div>
                    <div>
                      <h6 class="tx-primary">7,755</h6>
                      <span>31.74% (-100.00%)</span>
                    </div>
                  </div><!-- list-group-item -->
                  <div class="az-list-item">
                    <div>
                      <h6>Form Elements</h6>
                      <span>/demo/admin/forms.html</span>
                    </div>
                    <div>
                      <h6 class="tx-primary">5,215</h6>
                      <span>28.53% (-100.00%)</span>
                    </div>
                  </div><!-- list-group-item -->
                  <div class="az-list-item">
                    <div>
                      <h6>Utilities</h6>
                      <span>/demo/admin/util.html</span>
                    </div>
                    <div>
                      <h6 class="tx-primary">4,848</h6>
                      <span>25.35% (-100.00%)</span>
                    </div>
                  </div><!-- list-group-item -->
                  <div class="az-list-item">
                    <div>
                      <h6>Form Validation</h6>
                      <span>/demo/admin/validation.html</span>
                    </div>
                    <div>
                      <h6 class="tx-primary">3,275</h6>
                      <span>23.17% (-100.00%)</span>
                    </div>
                  </div><!-- list-group-item -->
                  <div class="az-list-item">
                    <div>
                      <h6>Modals</h6>
                      <span>/demo/admin/modals.html</span>
                    </div>
                    <div>
                      <h6 class="tx-primary">3,003</h6>
                      <span>22.21% (-100.00%)</span>
                    </div>
                  </div><!-- list-group-item -->
                </div><!-- card-body -->
              </div><!-- card -->

            </div><!-- col -->
            <div class="col-lg-8 mg-t-20 mg-lg-t-0">
              <div class="card card-dashboard-four">
                <div class="card-header">
                  <h6 class="card-title">Sessions by Channel</h6>
                </div><!-- card-header -->
                <div class="card-body row">
                  <div class="col-md-6 d-flex align-items-center">
                    <div class="chart"><canvas id="chartDonut"></canvas></div>
                  </div><!-- col -->
                  <div class="col-md-6 col-lg-5 mg-lg-l-auto mg-t-20 mg-md-t-0">
                    <div class="az-traffic-detail-item">
                      <div>
                        <span>Organic Search</span>
                        <span>1,320 <span>(25%)</span></span>
                      </div>
                      <div class="progress">
                        <div class="progress-bar bg-purple wd-25p" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                      </div><!-- progress -->
                    </div>
                    <div class="az-traffic-detail-item">
                      <div>
                        <span>Email</span>
                        <span>987 <span>(20%)</span></span>
                      </div>
                      <div class="progress">
                        <div class="progress-bar bg-primary wd-20p" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                      </div><!-- progress -->
                    </div>
                    <div class="az-traffic-detail-item">
                      <div>
                        <span>Referral</span>
                        <span>2,010 <span>(30%)</span></span>
                      </div>
                      <div class="progress">
                        <div class="progress-bar bg-info wd-30p" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                      </div><!-- progress -->
                    </div>
                    <div class="az-traffic-detail-item">
                      <div>
                        <span>Social</span>
                        <span>654 <span>(15%)</span></span>
                      </div>
                      <div class="progress">
                        <div class="progress-bar bg-teal wd-15p" role="progressbar" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                      </div><!-- progress -->
                    </div>
                    <div class="az-traffic-detail-item">
                      <div>
                        <span>Other</span>
                        <span>400 <span>(10%)</span></span>
                      </div>
                      <div class="progress">
                        <div class="progress-bar bg-gray-500 wd-10p" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                      </div><!-- progress -->
                    </div>
                  </div><!-- col -->
                </div><!-- card-body -->
              </div><!-- card-dashboard-four -->
            </div><!-- col -->
          </div><!-- row -->

          <div class="row row-sm mg-b-20 mg-lg-b-0">
            <div class="col-lg-5 col-xl-4">
              <div class="row row-sm">
                <div class="col-md-6 col-lg-12 mg-b-20 mg-md-b-0 mg-lg-b-20">
                  <div class="card card-dashboard-five">
                    <div class="card-header">
                      <h6 class="card-title">Acquisition</h6>
                      <span class="card-text">Tells you where your visitors originated from, such as search engines, social networks or website referrals.</span>
                    </div><!-- card-header -->
                    <div class="card-body row row-sm">
                      <div class="col-6 d-sm-flex align-items-center">
                        <div class="card-chart bg-primary">
                          <span class="peity-bar" data-peity='{"fill": ["#fff"], "width": 20, "height": 20 }'>6,4,7,5,7</span>
                        </div>
                        <div>
                          <label>Bounce Rate</label>
                          <h4>33.50%</h4>
                        </div>
                      </div><!-- col -->
                      <div class="col-6 d-sm-flex align-items-center">
                        <div class="card-chart bg-purple">
                          <span class="peity-bar" data-peity='{"fill": ["#fff"], "width": 21, "height": 20 }'>7,4,5,7,2</span>
                        </div>
                        <div>
                          <label>Sessions</label>
                          <h4>9,065</h4>
                        </div>
                      </div><!-- col -->
                    </div><!-- card-body -->
                  </div><!-- card-dashboard-five -->
                </div><!-- col -->
                <div class="col-md-6 col-lg-12">
                  <div class="card card-dashboard-five">
                    <div class="card-header">
                      <h6 class="card-title">Sessions</h6>
                      <span class="card-text"> A session is the period time a user is actively engaged with your website, app, etc.</span>
                    </div><!-- card-header -->
                    <div class="card-body row row-sm">
                      <div class="col-6 d-sm-flex align-items-center">
                        <div class="mg-b-10 mg-sm-b-0 mg-sm-r-10">
                          <span class="peity-donut" data-peity='{ "fill": ["#007bff", "#cad0e8"],  "innerRadius": 14, "radius": 20 }'>4/7</span>
                        </div>
                        <div>
                          <label>% New Sessions</label>
                          <h4>26.80%</h4>
                        </div>
                      </div><!-- col -->
                      <div class="col-6 d-sm-flex align-items-center">
                        <div class="mg-b-10 mg-sm-b-0 mg-sm-r-10">
                          <span class="peity-donut" data-peity='{ "fill": ["#00cccc", "#cad0e8"],  "innerRadius": 14, "radius": 20 }'>2/7</span>
                        </div>
                        <div>
                          <label>Pages/Session</label>
                          <h4>1,005</h4>
                        </div>
                      </div><!-- col -->
                    </div><!-- card-body -->
                  </div><!-- card-dashboard-five -->
                </div><!-- col -->
              </div><!-- row -->
            </div><!-- col-lg-3 -->
            <div class="col-lg-7 col-xl-8 mg-t-20 mg-lg-t-0">
              <div class="card card-table-one">
                <h6 class="card-title">What pages do your users visit</h6>
                <p class="az-content-text mg-b-20">Part of this date range occurs before the new users metric had been calculated, so the old users metric is displayed.</p>
                <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <tr>
                        <th class="wd-5p">&nbsp;</th>
                        <th class="wd-45p">Country</th>
                        <th>Entrances</th>
                        <th>Bounce Rate</th>
                        <th>Exits</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><i class="flag-icon flag-icon-us flag-icon-squared"></i></td>
                        <td><strong>United States</strong></td>
                        <td><strong>134</strong> (1.51%)</td>
                        <td>33.58%</td>
                        <td>15.47%</td>
                      </tr>
                      <tr>
                        <td><i class="flag-icon flag-icon-gb flag-icon-squared"></i></td>
                        <td><strong>United Kingdom</strong></td>
                        <td><strong>290</strong> (3.30%)</td>
                        <td>9.22%</td>
                        <td>7.99%</td>
                      </tr>
                      <tr>
                        <td><i class="flag-icon flag-icon-in flag-icon-squared"></i></td>
                        <td><strong>India</strong></td>
                        <td><strong>250</strong> (3.00%)</td>
                        <td>20.75%</td>
                        <td>2.40%</td>
                      </tr>
                      <tr>
                        <td><i class="flag-icon flag-icon-ca flag-icon-squared"></i></td>
                        <td><strong>Canada</strong></td>
                        <td><strong>216</strong> (2.79%)</td>
                        <td>32.07%</td>
                        <td>15.09%</td>
                      </tr>
                      <tr>
                        <td><i class="flag-icon flag-icon-fr flag-icon-squared"></i></td>
                        <td><strong>France</strong></td>
                        <td><strong>216</strong> (2.79%)</td>
                        <td>32.07%</td>
                        <td>15.09%</td>
                      </tr>
                      <tr>
                        <td><i class="flag-icon flag-icon-ph flag-icon-squared"></i></td>
                        <td><strong>Philippines</strong></td>
                        <td><strong>197</strong> (2.12%)</td>
                        <td>32.07%</td>
                        <td>15.09%</td>
                      </tr>
                    </tbody>
                  </table>
                </div><!-- table-responsive -->
              </div><!-- card -->
            </div><!-- col-lg -->

          </div><!-- row --> --}}
@endsection
