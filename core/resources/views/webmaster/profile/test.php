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

            <!-- Revenues -->
            <div class="col-md-5 col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title mg-b-10">Revenues</h6>
                        <div class="select-wrapper">
                            <select id="filter-select" class="form-select">
                                <option value="last-month">Last Month</option>
                                <option value="last-quarter">Last Quarter</option>
                                <option value="last-year">Last Year</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
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
                                    <li class="d-flex align-items-center"><span
                                            class="d-inline-block wd-10 ht-10 bg-purple mg-r-10"></span> Very Satisfied
                                        (26%)</li>
                                    <li class="d-flex align-items-center mg-t-5"><span
                                            class="d-inline-block wd-10 ht-10 bg-primary mg-r-10"></span> Satisfied (39%)
                                    </li>
                                    <li class="d-flex align-items-center mg-t-5"><span
                                            class="d-inline-block wd-10 ht-10 bg-teal mg-r-10"></span> Not Satisfied (20%)
                                    </li>
                                    <li class="d-flex align-items-center mg-t-5"><span
                                            class="d-inline-block wd-10 ht-10 bg-gray-500 mg-r-10"></span> Satisfied (15%)
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div id="revenueChart"></div>
                    </div>
                </div>
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
</div>

<div class="row row-sm">
        <div class='row'>
            <div class="col-md-7 col-lg-7 col-xl-8">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title tx-14 mg-b-5">Loan Overview</h6>
                        <p class="mg-b-0">Monthly loan overview information</p>
                    </div><!-- card-header -->
                    <div class="card-body">
                        <div class="dashboard-five-stacked-chart"><canvas id="chartStacked1"></canvas></div>
                    </div><!-- card-body -->
                </div><!-- card -->
            </div><!-- col -->

            <!-- Revenues -->
            <div class="col-md-5 col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title mg-b-10">Revenues</h6>
                        <div class="select-wrapper">
                            <select id="filter-select" class="form-select">
                                <option value="last-month">Last Month</option>
                                <option value="last-quarter">Last Quarter</option>
                                <option value="last-year">Last Year</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
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
                                    <li class="d-flex align-items-center"><span
                                            class="d-inline-block wd-10 ht-10 bg-purple mg-r-10"></span> Very Satisfied
                                        (26%)</li>
                                    <li class="d-flex align-items-center mg-t-5"><span
                                            class="d-inline-block wd-10 ht-10 bg-primary mg-r-10"></span> Satisfied (39%)
                                    </li>
                                    <li class="d-flex align-items-center mg-t-5"><span
                                            class="d-inline-block wd-10 ht-10 bg-teal mg-r-10"></span> Not Satisfied (20%)
                                    </li>
                                    <li class="d-flex align-items-center mg-t-5"><span
                                            class="d-inline-block wd-10 ht-10 bg-gray-500 mg-r-10"></span> Satisfied (15%)
                                    </li>
                                </ul>
                            </div>
                        </div>
                        {{-- <div id="revenueChart"></div> --}}
                    </div>
                </div>
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
    </div>