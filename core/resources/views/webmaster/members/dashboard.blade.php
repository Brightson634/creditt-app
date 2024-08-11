@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection
@section('content')
   <div class="page-heading ">
      <div class="az-content-header d-block d-md-flex">
         <div>
               <h2 class="az-content-title tx-24 mg-b-5 mg-b-lg-8">Hi, welcome back!</h2>
               {{-- <p class="mg-b-0">Your sales monitoring dashboard template.</p> --}}
         </div>
         <div class="az-dashboard-header-right">
               <div>
                  <label class="tx-13">Customer Ratings</label>
                  <div class="az-star">
                     <i class="typcn typcn-star active"></i>
                     <i class="typcn typcn-star active"></i>
                     <i class="typcn typcn-star active"></i>
                     <i class="typcn typcn-star active"></i>
                     <i class="typcn typcn-star"></i>
                     <span>(12,775)</span>
                  </div>
               </div>
               {{-- <div>
                  <label class="tx-13">All Sales (Online)</label>
                  <h5>431,007</h5>
               </div>
               <div>
                  <label class="tx-13">All Sales (Offline)</label>
                  <h5>932,210</h5>
               </div> --}}
         </div><!-- az-dashboard-header-right -->
      </div><!-- az-content-header -->
      <div class="page-heading__title">
         <ul class="nav nav-tabs" style="background-color:#e3e7ed">
               <li class="nav-item">
                  <a class="nav-link active" href="#dashboard" title="Dashboard" data-toggle="tab"
                     aria-expanded="false"><i class="fas fa-chart-line"></i></a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="#accounts" data-toggle="tab" title="Accounts" aria-expanded="false"><i
                           class="far fa-user"></i></a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="#savings" data-toggle="tab" title="Savings" aria-expanded="false"><i
                           class="far fa-money-bill-alt"></i></a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="#loans" data-toggle="tab" aria-expanded="false" title="Loans"> <i
                           class="fas fa-credit-card"></i></a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="#repayments" data-toggle="tab" aria-expanded="false" title="Repayments"> <i
                           class="fas fa-redo"></i></a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="#statements" data-toggle="tab" aria-expanded="false" title="Statements"> <i
                           class="fas fa-file-invoice"></i></a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="#information" data-toggle="tab" aria-expanded="false" title="Information"> <i
                           class="fas fa-info-circle"></i></a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="{{ route('webmaster.member.create') }}" title="Add New Member"> <i
                           class="fas fa-user-plus"></i></a>
               </li>
         </ul>
      </div>
   </div>

   <div class="tab-content">
      <div class="tab-pane show active" id="dashboard">
         <div class="az-content-body dashboard-six">
               <div class="row row-sm">
                  <div class="col-sm-6 col-lg-3">
                     <div class="card card-dashboard-donut">
                           <div class="card-header">
                              <h6 class="card-title mg-b-10">Gross Profit Margin</h6>
                              <p class="mg-b-0 tx-12 tx-gray-500">The profit you make on each dollar of sales... <a
                                       href="">Learn more</a></p>
                           </div><!-- card-header -->
                           <div class="card-body">
                              <div class="az-donut-chart chart1">
                                 <div class="slice one"></div>
                                 <div class="slice two"></div>
                                 <div class="chart-center">
                                       <span></span>
                                 </div>
                              </div>
                           </div><!-- card-body -->
                     </div><!-- card -->
                  </div>
                  <div class="col-sm-6 col-lg-3 mg-t-20 mg-sm-t-0">
                     <div class="card card-dashboard-donut">
                           <div class="card-header">
                              <h6 class="card-title mg-b-10">Net Profit Margin</h6>
                              <p class="mg-b-0 tx-12 tx-gray-500">Measures your business at generating prof... <a
                                       href="">Learn more</a></p>
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
                  <div class="col-lg-6 mg-t-20 mg-lg-t-0">
                     <div class="card card-dashboard-balance">
                           <div class="card-body">
                              <i class="fab fa-cc-visa"></i>
                              <label class="az-content-label mg-b-0">Current Balance</label>
                              <h1 class="balance-amount">
                                 <span><small>{{ $gs->currency_symbol }}</small></span>{!! isset($accountdata->current_balance) ? formattedAmount($accountdata->current_balance) : 0 !!}
                              </h1>
                              <label class="az-content-label mg-b-0">Available Balance</label>
                              <h1 class="balance-amount">
                                 <span><small>{{ $gs->currency_symbol }}</small></span>{!! isset($accountdata->available_balance) ? formattedAmount($accountdata->available_balance) : 0 !!}
                              </h1>
                              <label class="az-content-label mg-b-2">Account Number</label>
                              <div class="account-number">
                                 <span>{{ $accountdata->accNumber }}</span>
                              </div><!-- account-number -->

                              <div class="d-sm-flex">
                                 <div>
                                       <label class="az-content-label">Account Holder</label>
                                       <h5 class="account-name">{{ ucwords(strtolower($member->fname . ' ' . $member->lname)) }}</h5>
                                 </div>
                                 <div class="mg-t-20 mg-sm-t-0 mg-sm-l-50">
                                       <label class="az-content-label">Account Type</label>
                                       <h5 class="account-name">{{ $accountdata->accType }}</h5>
                                 </div>
                              </div>
                           </div><!-- card-body -->
                           <div class="chart-wrapper">
                              <div id="flotChart2" class="flot-chart"></div>
                           </div><!-- chart-wrapper -->
                     </div><!-- card -->
                  </div>
                  <div class="col-lg-6 mg-t-20">
                     <div class="row row-sm">
                           <div class="col-sm-6">
                              <div class="card card-dashboard-finance">
                                 <h6 class="card-title">Principal Loan Amount</h6>
                                 <span class="peity-bar"
                                       data-peity='{ "fill": ["#560bd0"], "height": 27, "width": 70 }'>7,5,9,10,1,4,4,7,5,10,4,4</span>
                                 <h2><span><small>{{ $gs->currency_symbol }}</small></span> {!! isset($loandata->principal_amount) ? formattedAmount($loandata->principal_amount) : 0 !!}</h2>
                                 <span class="tx-12"><span class="tx-success tx-bold">18.2%</span> higher vs previous
                                       month</span>
                              </div>
                           </div><!-- col -->
                           <div class="col-sm-6 mg-t-20 mg-sm-t-0">
                              <div class="card card-dashboard-finance">
                                 <h6 class="card-title">Total Loan Fees</h6>
                                 <span class="peity-bar"
                                       data-peity='{ "fill": ["#007bff"], "height": 27, "width": 70 }'>10,4,4,7,5,9,10,3,4,4,7,5</span>
                                 <h2><span><small>{{ $gs->currency_symbol }}</small></span>{!! isset($loandata->fees_total) ? formattedAmount($loandata->fees_total) : 0 !!}</h2>
                                 <span class="tx-12"><span class="tx-danger tx-bold">0.7%</span> higher vs previous
                                       month</span>
                              </div>
                           </div><!-- col -->
                           <div class="col-sm-6 mg-t-20">
                              <div class="card card-dashboard-finance">
                                 <h6 class="card-title">Repayment Loan Amount</h6>
                                 <span class="peity-bar"
                                       data-peity='{ "fill": ["#00cccc"], "height": 27, "width": 70 }'>7,5,9,10,5,4,4,7,5,10,4,4</span>
                                 <h2><span><small>{{ $gs->currency_symbol }}</small></span>
                                       {!! isset($loandata->loan_amount) ? formattedAmount($loandata->loan_amount) : 0 !!}</h2>
                                 <span class="tx-12"><span class="tx-success tx-bold">0.7%</span> higher vs previous
                                       month</span>
                              </div>
                           </div><!-- col -->
                           <div class="col-sm-6 mg-t-20">
                              <div class="card card-dashboard-finance">
                                 <h6 class="card-title">Loan Interest Amount</h6>
                                 <span class="peity-bar"
                                       data-peity='{ "fill": ["#f10075"], "height": 27, "width": 70 }'>1,4,4,7,5,10,4,7,5,9,10,4</span>
                                 <h2><span><small>{{ $gs->currency_symbol }}</small></span>{!! isset($loandata->interest_amount) ? formattedAmount($loandata->interest_amount) : 0 !!}</h2>
                                 <span class="tx-12"><span class="tx-success tx-bold">0.7%</span> higher vs previous
                                       month</span>
                              </div>
                           </div><!-- col -->
                     </div><!-- row -->
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
                  <div class="col-lg-6 mg-t-20">
                     <div class="row row-sm">
                           <div class="col-sm-6">
                              <div class="card card-dashboard-finance">
                                 <h6 class="card-title">Total Deposits</h6>
                                 <span class="peity-bar"
                                       data-peity='{ "fill": ["#560bd0"], "height": 27, "width": 70 }'>7,5,9,10,1,4,4,7,5,10,4,4</span>
                                 <h2><span><small>{{ $gs->currency_symbol }}</small></span> {!! isset($savingdata->deposit_amount) ? formattedAmount($savingdata->deposit_amount) : 0 !!}</h2>
                                 <span class="tx-12"><span class="tx-success tx-bold">18.2%</span> higher vs previous
                                       month</span>
                              </div>
                           </div><!-- col -->
                           <div class="col-sm-6 mg-t-20 mg-sm-t-0">
                              <div class="card card-dashboard-finance">
                                 <h6 class="card-title">Total Savings</h6>
                                 <span class="peity-bar"
                                       data-peity='{ "fill": ["#00cccc"], "height": 27, "width": 70 }'>7,5,9,10,5,4,4,7,5,10,4,4</span>
                                 <h2><span><small>{{ $gs->currency_symbol }}</small></span>
                                       {!! isset($savingdata->total_savings) ? formattedAmount($savingdata->total_savings) : 0 !!}<small>.00</small></h2>
                                 <span class="tx-12"><span class="tx-success tx-bold">0.7%</span> higher vs previous
                                       month</span>
                              </div>
                           </div><!-- col -->
                           <div class="col-sm-6 mg-t-20">
                              <div class="card card-dashboard-finance">
                                 <h6 class="card-title">Investment Amount</h6>
                                 <span class="peity-bar"
                                       data-peity='{ "fill": ["#00cccc"], "height": 27, "width": 70 }'>7,5,9,10,5,4,4,7,5,10,4,4</span>
                                 <h2><span><small>{{ $gs->currency_symbol }}</small></span>
                                       {!! isset($investmentdata->investment_amount) ? formattedAmount($investmentdata->investment_amount) : 0 !!}</h2>
                                 <span class="tx-12"><span class="tx-success tx-bold">0.7%</span> higher vs previous
                                       month</span>
                              </div>
                           </div><!-- col -->
                           <div class="col-sm-6 mg-t-20">
                              <div class="card card-dashboard-finance">
                                 <h6 class="card-title">Investment Interest Amount</h6>
                                 <span class="peity-bar"
                                       data-peity='{ "fill": ["#f10075"], "height": 27, "width": 70 }'>1,4,4,7,5,10,4,7,5,9,10,4</span>
                                 <h2><span><small>{{ $gs->currency_symbol }}</small></span>{!! isset($investmentdata->interest_amount) ? formattedAmount($investmentdata->interest_amount) : 0 !!}</h2>
                                 <span class="tx-12"><span class="tx-success tx-bold">0.7%</span> higher vs previous
                                       month</span>
                              </div>
                           </div><!-- col -->
                     </div><!-- row -->
                  </div>
               </div><!-- row -->
               <div class="row row-sm">
                  <div class="col-lg-12 mg-t-20">
                     <div class="row row-sm">
                           <div class="col-sm-3">
                              <div class="card card-dashboard-finance">
                                 <h6 class="card-title">Repaid Loan Amount</h6>
                                 <span class="peity-bar"
                                       data-peity='{ "fill": ["#560bd0"], "height": 27, "width": 70 }'>7,5,9,10,1,4,4,7,5,10,4,4</span>
                                 <h2><span><small>{{ $gs->currency_symbol }}</small></span> {!! isset($loandata->repaid_amount) ? formattedAmount($loandata->repaid_amount) : 0 !!}
                                 </h2>
                                 @php
                                       $collectedPercentage =
                                          $loandata->repaid_amount != 0
                                             ? round(($loandata->repaid_amount / $loandata->loan_amount) * 100, 2)
                                             : 0;
                                 @endphp
                                 <span class="tx-12"><span
                                          class="tx-success tx-bold">{{ $collectedPercentage }}%</span>Paid</span>
                              </div>
                           </div><!-- col -->
                           <div class="col-sm-3">
                              <div class="card card-dashboard-finance">
                                 <h6 class="card-title">Outstanding Loan Amount</h6>
                                 <span class="peity-bar"
                                       data-peity='{ "fill": ["#00cccc"], "height": 27, "width": 70 }'>7,5,9,10,5,4,4,7,5,10,4,4</span>
                                 <h2><span><small>{{ $gs->currency_symbol }}</small></span>
                                       {!! isset($loandata->loan_amount) ? formattedAmount($loandata->loan_amount-$loandata->repaid_amount) : 0 !!}<small>.00</small></h2>
                                 @php
                                    $loanBalance =$loandata->loan_amount-$loandata->repaid_amount;
                                    $balancePercentage =
                                          $loanBalance != 0
                                             ? round(($loanBalance / $loandata->loan_amount) * 100, 2)
                                             : 100;
                                 @endphp
                                 <span class="tx-12"><span
                                          class="tx-danger tx-bold">{{ $balancePercentage }}%</span>Outstanding</span>
                              </div>
                           </div><!-- col -->
                           <div class="col-sm-3">
                              <div class="card card-dashboard-finance">
                                 <h6 class="card-title">Penalty Amount</h6>
                                 <span class="peity-bar"
                                       data-peity='{ "fill": ["#00cccc"], "height": 27, "width": 70 }'>7,5,9,10,5,4,4,7,5,10,4,4</span>
                                 <h2><span><small>{{ $gs->currency_symbol }}</small></span>
                                       {!! isset($loandata->penalty_amount) ? formattedAmount($loandata->penalty_amount) : 0 !!}</h2>
                                 <span class="tx-12"><span class="tx-success tx-bold">0.7%</span> higher vs previous
                                       month</span>
                              </div>
                           </div><!-- col -->
                           <div class="col-sm-3">
                              <div class="card card-dashboard-finance">
                                 <h6 class="card-title">Return On Investment Amount</h6>
                                 <span class="peity-bar"
                                       data-peity='{ "fill": ["#f10075"], "height": 27, "width": 70 }'>1,4,4,7,5,10,4,7,5,9,10,4</span>
                                 <h2><span><small>{{ $gs->currency_symbol }}</small></span>{!! isset($investmentdata->roi_amount) ? formattedAmount($investmentdata->roi_amount) : 0 !!}</h2>
                                 <span class="tx-12"><span class="tx-success tx-bold">0.7%</span> higher vs previous
                                       month</span>
                              </div>
                           </div><!-- col -->
                     </div><!-- row -->
                  </div>
               </div>
         </div><!-- az-content-body -->
         <div class="row mg-t-20">
               <div class="col-md-12">
                  <div class="row">
                     <div class="col-md-12">
                           <div class="card">
                              <div class="card-body">
                                 <h4 class="card-title mb-3">Savings Overview</h4>
                                 <div class="row">
                                    <div class="col-md-4 mg-t-20 mg-md-t-0">
                                        <div class="card bd-0">
                                            <div class="card-header tx-medium bd-0 tx-white bg-gray-800">
                                                ACCOUNT BALANCE SUMMARY
                                            </div>
                                            <div class="card-body bd bd-t-0">
                                                <div id='accountStatus'>

                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- col -->
                                    <div class="col-md-4 mg-t-20 mg-md-t-0">
                                        <div class="card bd-0">
                                            <div class="card-header tx-medium bd-0 tx-white bg-gray-800">
                                                INVESTMENT SUMMARY
                                            </div>
                                            <div class="card-body bd bd-t-0">
                                                <div id='investmentSummary'>

                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- col -->
                                    <div class="col-md-4 mg-t-20 mg-md-t-0">
                                       <div class="card bd-0">
                                           <div class="card-header tx-medium bd-0 tx-white bg-gray-800">
                                               SAVINGS SUMMARY
                                           </div>
                                           <div class="card-body bd bd-t-0">
                                               <div id='savingsSummary'>

                                               </div>
                                           </div>
                                       </div>
                                   </div><!-- col -->
                                </div>
                              </div>
                           </div>
                     </div>
                  </div>
               </div>
         </div>
         <div class="row mg-t-20">
            <div class="col-md-12">
               <div class="row">
                  <div class="col-md-12">
                        <div class="card">
                           <div class="card-body">
                              <h4 class="card-title mb-3">Loan Overview</h4>
                              <div class="row">
                                 <div class="col-md-6 mg-t-20 mg-md-t-0">
                                     <div class="card bd-0">
                                         <div class="card-header tx-medium bd-0 tx-white bg-gray-800">
                                             LOAN SUMMARY
                                         </div>
                                         <div class="card-body bd bd-t-0">
                                             <div id='loanStatus'>

                                             </div>
                                         </div>
                                     </div>
                                 </div><!-- col -->
                                 <div class="col-md-6 mg-t-20 mg-md-t-0">
                                     <div class="card bd-0">
                                         <div class="card-header tx-medium bd-0 tx-white bg-gray-800">
                                             LOAN INFO
                                         </div>
                                         <div class="card-body bd bd-t-0">
                                             <div id='loanInfo'>

                                             </div>
                                         </div>
                                     </div>
                                 </div><!-- col -->
                             </div>
                           </div>
                        </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="tab-pane" id="accounts">
         <div class="row">
               <div class="col-xl-12">
                  <div class="card">
                     <div class="card-body">
                           @if ($accounts->count() > 0)
                              <div class="card card-dashboard-table-six">
                                 <h6 class="card-title">Saving Accounts</h6>
                                 <div class="table-responsive">
                                       <table class="table table-striped">
                                          <thead>
                                             <tr>
                                                   <th>#</th>
                                                   <th>Account No</th>
                                                   <th>Opening Balance</th>
                                                   <th>Current Balance</th>
                                                   <th>Available Balance</th>
                                                   <th>Account Type</th>
                                                   <th>Status</th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                             @php $i = 0; @endphp
                                             @foreach ($accounts as $row)
                                                   @php  $i++;  @endphp
                                                   <tr>
                                                      <th scope="row">{{ $i }}</th>
                                                      <td>{{ $row->account_no }}</td>
                                                      <td>{!! showAmount($row->opening_balance) !!}</td>
                                                      <td>{!! showAmount($row->current_balance) !!}</td>
                                                      <td>{!! showAmount($row->available_balance) !!}</td>
                                                      <td>{{ $row->accounttype->name }}</td>
                                                      <td>
                                                         @if ($row->account_status == 1)
                                                               <div class="badge badge-success">ACTIVE</div>
                                                         @endif
                                                         @if ($row->account_status == 0)
                                                               <div class="badge badge-warning">INACTIVE</div>
                                                         @endif
                                                      </td>
                                                   <tr>
                                             @endforeach
                                          </tbody>
                                       </table>
                                 </div>
                              </div>
                           @else
                              <div class="d-flex flex-column align-items-center mt-5">
                                 <img src="{{ asset('assets/uploads/defaults/nodata.png') }}" width="200">
                                 <span class="mt-3">No Accounts</span>
                              </div>
                           @endif
                     </div>
                  </div>
               </div>
         </div>
      </div>

      <div class="tab-pane" id="savings">
         <div class="row">
               <div class="col-xl-12">
                  <div class="card">
                     <div class="card-body">
                           @if ($savings->count() > 0)
                              <div class="card card-dashboard-table-six">
                                 <h6 class="card-title">Savings</h6>
                                 <div class="table-responsive">
                                       <table class="table table-striped">
                                          <thead>
                                             <tr>
                                                   <th>#</th>
                                                   <th>Account No</th>
                                                   <th>Deposited Amount</th>
                                                   <th>Previous Balance</th>
                                                   <th>Current Balance</th>
                                                   <th>Transaction Date</th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                             @php $i = 0; @endphp
                                             @foreach ($savings as $row)
                                                   @php  $i++;  @endphp
                                                   <tr>
                                                      <th scope="row">{{ $i }}</th>
                                                      <td>{{ $row->account->account_no }}</td>
                                                      <td>{!! showAmount($row->deposit_amount) !!}</td>
                                                      <td>{!! showAmount($row->previous_balance) !!}</td>
                                                      <td>{!! showAmount($row->current_balance) !!}</td>
                                                      <td>{{ formatDate($row->created_at) }}</td>
                                                   <tr>
                                             @endforeach
                                          </tbody>
                                       </table>
                                 </div>
                              </div>
                           @else
                              <div class="d-flex flex-column align-items-center mt-5">
                                 <img src="{{ asset('assets/uploads/defaults/nodata.png') }}" width="200">
                                 <span class="mt-3">No Savings</span>
                              </div>
                           @endif
                     </div>
                  </div>
               </div>
         </div>
      </div>

      <div class="tab-pane" id="loans">
         <div class="row">
               <div class="col-xl-12">
                  <div class="card">
                     <div class="card-body">
                           @if ($loans->count() > 0)
                              <div class="card card-dashboard-table-six">
                                 <h6 class="card-title">Loans</h6>
                                 <div class="table-responsive">
                                       <table class="table table-striped">
                                          <thead>
                                             <tr>
                                                   <th>#</th>
                                                   <th>Loan No</th>
                                                   <th>Loan Type</th>
                                                   <th>Loan Product</th>
                                                   <th>Principal Amount</th>
                                                   <th>Repayment Amount</th>
                                                   <th>Fees Total</th>
                                                   <th>Status</th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                             @php $i = 0; @endphp
                                             @foreach ($loans as $row)
                                                   @php  $i++;  @endphp
                                                   <tr>
                                                      <th scope="row">{{ $i }}</th>
                                                      <td>{{ $row->loan_no }}</td>
                                                      <td>
                                                         @if ($row->loan_type == 'individual')
                                                               INDIVIDUAL LOAN
                                                         @endif
                                                         @if ($row->loan_type == 'group')
                                                               GROUP LOAN
                                                         @endif
                                                      </td>
                                                      <td>{{ $row->loanproduct->name }}</td>
                                                      <td>{!! showAmount($row->principal_amount) !!}</td>
                                                      <td>{!! showAmount($row->repayment_amount) !!}</td>
                                                      <td>{!! showAmount($row->fees_total) !!}</td>
                                                      <td>
                                                         @if ($row->status == 2)
                                                               <div class="badge badge-danger">REJECTED</div>
                                                         @endif
                                                         @if ($row->status == 1)
                                                               <div class="badge badge-success">APPROVED</div>
                                                         @endif
                                                         @if ($row->status == 0)
                                                               <div class="badge badge-warning">PENDING</div>
                                                         @endif
                                                      </td>
                                                   <tr>
                                             @endforeach
                                          </tbody>
                                       </table>
                                 </div>
                              </div>
                           @else
                              <div class="d-flex flex-column align-items-center mt-5">
                                 <img src="{{ asset('assets/uploads/defaults/nodata.png') }}" width="200">
                                 <span class="mt-3">No Loans</span>
                              </div>
                           @endif
                     </div>
                  </div>
               </div>
         </div>
      </div>

      <div class="tab-pane" id="repayments">
         <div class="row">
               <div class="col-xl-12">
                  <div class="card">
                     <div class="card-body">
                           @if ($repayments->count() > 0)
                              <div class="card card-dashboard-table-six">
                                 <h6 class="card-title">Loan Payments</h6>
                                 <div class="table-responsive">
                                       <table class="table table-striped">
                                          <thead>
                                             <tr>
                                                   <th>Date</th>
                                                   <th>Member</th>
                                                   <th>Loan Amount</th>
                                                   <th>Amount Received</th>
                                                   <th>Remaining Balance</th>
                                                   <th>Paid By</th>
                                                   <th>Recieved By</th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                             @php $i = 0; @endphp
                                             @foreach ($repayments as $row)
                                                   @php $i++; @endphp
                                                   <tr>
                                                      <td>{{ dateFormat($row->date) }}</td>
                                                      <td>{{ $row->member->fname }}</td>
                                                      <td>{!! showAmount($row->loan_amount) !!}</td>
                                                      <td>{!! showAmount($row->repaid_amount) !!}</td>
                                                      <td>{!! showAmount($row->balance_amount) !!}</td>
                                                      <td>{{ $row->paid_by }}</td>
                                                      <td>{{ $row->staff->fname }}</td>

                                                   <tr>
                                             @endforeach
                                          </tbody>
                                       </table>
                                 </div>
                              </div>
                           @else
                              <div class="d-flex flex-column align-items-center mt-5">
                                 <img src="{{ asset('assets/uploads/defaults/nodata.png') }}" width="200">
                                 <span class="mt-3">No Data</span>
                              </div>
                           @endif
                     </div>
                  </div>
               </div>
         </div>
      </div>

      <div class="tab-pane" id="statements">
         <div class="row">
               <div class="col-xl-12">
                  <div class="card">
                     <div class="card-body">
                           @if ($statements->count() > 0)
                              <div class="card card-dashboard-table-six">
                                 <h6 class="card-title">Statements</h6>
                                 <div class="table-responsive">
                                       <table class="table table-striped">
                                          <thead>
                                             <tr>
                                                   <th>#</th>
                                                   <th>Detail</th>
                                                   <th>Amount</th>
                                                   <th>Account No</th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                             @php $i = 0; @endphp
                                             @foreach ($statements as $row)
                                                   @php  $i++;  @endphp
                                                   <tr>
                                                      <th scope="row">{{ $i }}</th>
                                                      <td>{{ $row->detail }}</td>
                                                      <td>
                                                         @if ($row->status == 1)
                                                               <span class="text-success">+
                                                                  {!! showAmount($row->amount) !!}</span>
                                                         @endif

                                                         @if ($row->status == 0)
                                                               <span class="text-danger">- {!! showAmount($row->amount) !!}</span>
                                                         @endif
                                                      </td>
                                                      <td>
                                                         @if ($row->account_id != null)
                                                               {{ $row->account->account_no }}
                                                         @else
                                                               -
                                                         @endif
                                                      </td>
                                                   <tr>
                                             @endforeach
                                          </tbody>
                                       </table>
                                 </div>
                              </div>
                           @else
                              <div class="d-flex flex-column align-items-center mt-5">
                                 <img src="{{ asset('assets/uploads/defaults/nodata.png') }}" width="200">
                                 <span class="mt-3">No Loans</span>
                              </div>
                           @endif
                     </div>
                  </div>
               </div>
         </div>
      </div>

      <div class="tab-pane" id="information">
         <div class="row">
               <div class="col-xl-12">
                  <div class="tab-content">
                     <div class="tab-pane show active">
                           <div class="card">
                              <div class="card-body">
                                 <div class="row">
                                       <div class="col-sm-3 mb-2 mb-sm-0">
                                          <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist">
                                             <a class="nav-link active show mb-2" data-toggle="pill" href="#biodata"
                                                   role="tab"> <i class="far fa-file"></i> Group Details
                                             </a>
                                             <a class="nav-link mb-2" data-toggle="pill" href="#contacts"
                                                   role="tab"> <i class="fa fa-phone"></i> Phone Contacts
                                             </a>
                                             <a class="nav-link mb-2" data-toggle="pill" href="#emails"
                                                   role="tab"> <i class="far fa-envelope"></i> Email Address
                                             </a>
                                             @if ($member->member_type == 'individual')
                                                   <a class="nav-link mb-2" data-toggle="pill" href="#memberkycs"
                                                      role="tab"> <i class="far fa-user"></i> Individual Information
                                                   </a>
                                             @endif
                                             @if ($member->member_type == 'group')
                                                   <a class="nav-link mb-2" data-toggle="pill" href="#groupmembers"
                                                      role="tab"> <i class="fa fa-briefcase"></i> Group Signatories
                                                   </a>
                                             @endif
                                             <a class="nav-link mb-2" data-toggle="pill" href="#documents"
                                                   role="tab"> <i class="far fa-user"></i> Documents
                                             </a>
                                          </div>
                                       </div>
                                       <div class="col-sm-9">
                                          <div class="tab-content" id="v-pills-tabContent">

                                             <div class="tab-pane fade active show" id="biodata" role="tabpanel">

                                                   <h4 class="card-title mb-4">Information</h4>
                                                   <div class="row">
                                                      <input type="hidden" name="memberid" id="memberid"
                                                         class="form-control" value="{{ $member->id }}">
                                                      <div class="col-md-3">
                                                         <div class="text-center">
                                                               @if ($member->photo != null)
                                                                  <img alt="image" id="pp_preview"
                                                                     src="{{ asset('assets/uploads/members/' . $member->photo) }}"
                                                                     width="140" alt="photo" />
                                                               @else
                                                                  <img alt="image" id="pp_preview"
                                                                     src="{{ asset('assets/uploads/defaults/author.png') }}"
                                                                     width="140" class="avatar img-thumbnail"
                                                                     alt="avatar">
                                                               @endif
                                                               <div class="image-upload">
                                                                  <div class="thumb">
                                                                     <div class="upload-file">
                                                                           <input type="file" name="pphoto"
                                                                              class="form-control file-upload"
                                                                              id="pphoto">
                                                                           <label for="pphoto"
                                                                              class="btn btn-xs btn-theme">Change
                                                                              Photo</label>
                                                                           <span class="invalid-feedback"></span>
                                                                     </div>
                                                                  </div>
                                                               </div>
                                                         </div>
                                                      </div>
                                                      <div class="col-md-9">
                                                         <div class="card">
                                                               <div class="card-body">
                                                                  @if ($member->member_type == 'individual')
                                                                     <form action="#" method="POST"
                                                                           id="individual_form">
                                                                           @csrf
                                                                           <input type="hidden" name="id"
                                                                              class="form-control"
                                                                              value="{{ $member->id }}">
                                                                           <div class="row">
                                                                              <div class="col-md-4">
                                                                                 <div class="form-group">
                                                                                       <label for="fname">First
                                                                                          Name</label>
                                                                                       <input type="text"
                                                                                          name="fname" id="fname"
                                                                                          class="form-control"
                                                                                          value="{{ $member->fname }}">
                                                                                       <span
                                                                                          class="invalid-feedback"></span>
                                                                                 </div>
                                                                              </div>
                                                                              <div class="col-md-4">
                                                                                 <div class="form-group">
                                                                                       <label for="lname">Last
                                                                                          Name</label>
                                                                                       <input type="text"
                                                                                          name="lname" id="lname"
                                                                                          class="form-control"
                                                                                          value="{{ $member->lname }}">
                                                                                       <span
                                                                                          class="invalid-feedback"></span>
                                                                                 </div>
                                                                              </div>
                                                                              <div class="col-md-4">
                                                                                 <div class="form-group">
                                                                                       <label for="oname">Other
                                                                                          Name</label>
                                                                                       <input type="text"
                                                                                          name="oname" id="oname"
                                                                                          class="form-control"
                                                                                          value="{{ $member->oname }}">
                                                                                       <span
                                                                                          class="invalid-feedback"></span>
                                                                                 </div>
                                                                              </div>
                                                                           </div>
                                                                           <div class="row">
                                                                              <div class="col-md-4">
                                                                                 <div class="form-group">
                                                                                       <label for="title"
                                                                                          class="form-label">Title</label>
                                                                                       <select class="form-control"
                                                                                          name="title" id="title">
                                                                                          <option
                                                                                             {{ $member->title == 'Mr' ? 'selected' : '' }}
                                                                                             value="Mr">Mr</option>
                                                                                          <option
                                                                                             {{ $member->title == 'Mrs' ? 'selected' : '' }}
                                                                                             value="Mrs">Mrs</option>
                                                                                          <option
                                                                                             {{ $member->title == 'Hon' ? 'selected' : '' }}
                                                                                             value="Hon">Hon</option>
                                                                                       </select>
                                                                                       <span
                                                                                          class="invalid-feedback"></span>
                                                                                 </div>
                                                                              </div>
                                                                              <div class="col-md-4">
                                                                                 <div class="form-group">
                                                                                       <label for="gender"
                                                                                          class="form-label">Gender</label>
                                                                                       <select class="form-control"
                                                                                          name="gender" id="gender">
                                                                                          <option
                                                                                             {{ $member->gender == 'Male' ? 'selected' : '' }}
                                                                                             value="Male">Male
                                                                                          </option>
                                                                                          <option
                                                                                             {{ $member->gender == 'Female' ? 'selected' : '' }}
                                                                                             value="Female">Female
                                                                                          </option>
                                                                                          <option
                                                                                             {{ $member->gender == 'Other' ? 'selected' : '' }}
                                                                                             value="Other">Others
                                                                                          </option>
                                                                                       </select>
                                                                                       <span
                                                                                          class="invalid-feedback"></span>
                                                                                 </div>
                                                                              </div>
                                                                              <div class="col-md-4">
                                                                                 <div class="form-group">
                                                                                       <label for="marital_status"
                                                                                          class="form-label">Marital
                                                                                          Status</label>
                                                                                       <select class="form-control"
                                                                                          name="marital_status"
                                                                                          id="marital_status">
                                                                                          <option
                                                                                             {{ $member->marital_status == 'N/A' ? 'selected' : '' }}
                                                                                             value="N/A">N/A</option>
                                                                                          <option
                                                                                             {{ $member->marital_status == 'Single' ? 'selected' : '' }}
                                                                                             value="Single">Single
                                                                                          </option>
                                                                                          <option
                                                                                             {{ $member->marital_status == 'Married' ? 'selected' : '' }}
                                                                                             value="Married">Married
                                                                                          </option>
                                                                                       </select>
                                                                                       <span
                                                                                          class="invalid-feedback"></span>
                                                                                 </div>
                                                                              </div>
                                                                           </div>
                                                                           <div class="row">
                                                                              <div class="col-md-4">
                                                                                 <div class="form-group">
                                                                                       <label for="dob"
                                                                                          class="form-label">Date of
                                                                                          Birth</label>
                                                                                       <input type="text"
                                                                                          name="dob"
                                                                                          class="form-control"
                                                                                          data-provide="datepicker"
                                                                                          data-date-autoclose="true"
                                                                                          data-date-format="yyyy-mm-dd"
                                                                                          id="dob"
                                                                                          autocomplete="off"
                                                                                          value="{{ $member->dob }}">
                                                                                       <span
                                                                                          class="invalid-feedback"></span>
                                                                                 </div>
                                                                              </div>
                                                                              <div class="col-md-4">
                                                                                 <label for="disability"
                                                                                       class="form-label">Disability</label>
                                                                                 <div class="form-group">
                                                                                       <div
                                                                                          class="custom-control custom-radio custom-control-inline">
                                                                                          <input type="radio"
                                                                                             id="dno"
                                                                                             name="disability"
                                                                                             class="custom-control-input"
                                                                                             value="No"
                                                                                             @php echo $member->disability == 'No' ? 'checked' : '' @endphp>
                                                                                          <label
                                                                                             class="custom-control-label"
                                                                                             for="dno">NO</label>
                                                                                       </div>
                                                                                       <div
                                                                                          class="custom-control custom-radio custom-control-inline">
                                                                                          <input type="radio"
                                                                                             id="dyes"
                                                                                             name="disability"
                                                                                             class="custom-control-input"
                                                                                             value="Yes"
                                                                                             @php echo $member->disability == 'Yes' ? 'checked' : '' @endphp>
                                                                                          <label
                                                                                             class="custom-control-label"
                                                                                             for="dyes">YES</label>
                                                                                       </div>
                                                                                 </div>
                                                                                 <span class="invalid-feedback"></span>
                                                                              </div>
                                                                           </div>
                                                                           <div class="row mt-2">
                                                                              <div class="col-md-12">
                                                                                 <button type="submit"
                                                                                       class="btn btn-block btn-theme"
                                                                                       id="btn_individual">Update
                                                                                       Information</button>
                                                                              </div>
                                                                           </div>
                                                                     </form>
                                                                  @endif
                                                                  @if ($member->member_type == 'group')
                                                                     <form action="#" method="POST"
                                                                           id="mgroup_form">
                                                                           @csrf
                                                                           <input type="hidden" name="id"
                                                                              class="form-control"
                                                                              value="{{ $member->id }}">
                                                                           <div class="row">
                                                                              <div class="col-md-12">
                                                                                 <div class="form-group">
                                                                                       <label for="group_name">Group
                                                                                          Name</label>
                                                                                       <input type="text"
                                                                                          name="group_name"
                                                                                          id="group_name"
                                                                                          class="form-control"
                                                                                          value="{{ $member->fname }}">
                                                                                       <span
                                                                                          class="invalid-feedback"></span>
                                                                                 </div>
                                                                              </div>
                                                                              <div class="col-md-12">
                                                                                 <div class="form-group">
                                                                                       <label
                                                                                          for="description">Description</label>
                                                                                       <textarea name="description" class="form-control" id="description" rows="3">{{ $member->description }}</textarea>
                                                                                       <span
                                                                                          class="invalid-feedback"></span>
                                                                                 </div>
                                                                              </div>
                                                                           </div>
                                                                           <div class="row mt-2">
                                                                              <div class="col-md-12">
                                                                                 <button type="submit"
                                                                                       class="btn btn-block btn-theme"
                                                                                       id="btn_mgroup">Update
                                                                                       Information</button>
                                                                              </div>
                                                                           </div>
                                                                     </form>
                                                                  @endif


                                                               </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                             </div>
                                             <div class="tab-pane fade" id="contacts" role="tabpanel">
                                                   <div class="card shadow-lg">
                                                      <div class="card-body">
                                                         <div class="clearfix mb-3">
                                                               <div class="float-left">
                                                                  <h3 class="card-title">Contacts</h3>
                                                               </div>
                                                               <div class="float-right">
                                                                  <button type="button" class="btn btn-sm btn-theme"
                                                                     data-toggle="modal" data-target="#contactModel">
                                                                     <i class="fa fa-plus"></i> Add Contact
                                                                  </button>
                                                                  <div class="modal fade" id="contactModel"
                                                                     tabindex="-1" role="dialog"
                                                                     aria-labelledby="exampleModalCenterTitle"
                                                                     aria-hidden="true">
                                                                     <div class="modal-dialog modal-dialog-centered"
                                                                           role="document">
                                                                           <div class="modal-content">
                                                                              <div class="modal-body">
                                                                                 <h4 class="card-title mb-4">New Contact
                                                                                       Form</h4>
                                                                                 <form action="#" method="POST"
                                                                                       id="contact_form">
                                                                                       @csrf
                                                                                       <input type="hidden"
                                                                                          name="member_id"
                                                                                          class="form-control"
                                                                                          value="{{ $member->id }}">
                                                                                       <div class="form-group">
                                                                                          <label
                                                                                             for="telephone">Telephone</label>
                                                                                          <input type="text"
                                                                                             name="telephone"
                                                                                             id="telephone"
                                                                                             class="form-control">
                                                                                          <span
                                                                                             class="invalid-feedback"></span>
                                                                                       </div>
                                                                                       <div class="form-group">
                                                                                          <button type="button"
                                                                                             class="btn btn-sm btn-secondary"
                                                                                             data-dismiss="modal">Cancel</button>
                                                                                          <button type="submit"
                                                                                             class="btn btn-sm btn-theme"
                                                                                             id="btn_contact">Add
                                                                                             Contact</button>
                                                                                       </div>
                                                                                 </form>
                                                                              </div>
                                                                           </div>
                                                                     </div>
                                                                  </div>
                                                               </div>
                                                         </div>
                                                         @if ($contacts->count() > 0)
                                                               <div class="table-responsive">
                                                                  <table class="table table-sm mb-0">
                                                                     <thead>
                                                                           <tr>
                                                                              <th>#</th>
                                                                              <th>Telephone</th>
                                                                              <th>Action</th>
                                                                           </tr>
                                                                     </thead>
                                                                     <tbody>
                                                                           @php $i = 0; @endphp
                                                                           @foreach ($contacts as $row)
                                                                              @php $i++; @endphp
                                                                              <tr>
                                                                                 <th scope="row">{{ $i }}
                                                                                 </th>
                                                                                 <td>{{ $row->telephone }}</td>
                                                                                 <td>
                                                                                       <button type="button"
                                                                                          class="btn btn-xs btn-danger"
                                                                                          data-toggle="modal"
                                                                                          data-target="#deleteContactModel{{ $row->id }}">
                                                                                          <i
                                                                                             class="fa fa-trash"></i></button>
                                                                                       <div class="modal fade"
                                                                                          id="deleteContactModel{{ $row->id }}"
                                                                                          tabindex="-1" role="dialog"
                                                                                          aria-hidden="true">
                                                                                          <div class="modal-dialog modal-sm modal-dialog-centered"
                                                                                             role="document">
                                                                                             <div
                                                                                                   class="modal-content border-0">
                                                                                                   <div
                                                                                                      class="modal-body">
                                                                                                      <div class="alert alert-fwarning"
                                                                                                         role="alert">
                                                                                                         <i
                                                                                                               class="fa fa-exclamation-triangle d-block display-4 mt-2 mb-3 text-warning text-center"></i>
                                                                                                         <h3
                                                                                                               class="text-center">
                                                                                                               Delete
                                                                                                               Contact
                                                                                                               {{ $row->telephone }}?
                                                                                                         </h3>
                                                                                                         <form
                                                                                                               action="#"
                                                                                                               method="POST"
                                                                                                               class="delete_contact_form">
                                                                                                               @csrf
                                                                                                               <input
                                                                                                                  type="hidden"
                                                                                                                  name="id"
                                                                                                                  value="{{ $row->id }}">
                                                                                                               <div
                                                                                                                  class="form-group text-center mt-3">
                                                                                                                  <button
                                                                                                                     type="button"
                                                                                                                     class="btn btn-dark"
                                                                                                                     data-dismiss="modal">No,
                                                                                                                     Cancel</button>
                                                                                                                  <button
                                                                                                                     type="submit"
                                                                                                                     class="btn btn-danger delete_contact">Yes,
                                                                                                                     Delete</button>
                                                                                                               </div>
                                                                                                         </form>
                                                                                                      </div>
                                                                                                   </div>
                                                                                             </div>
                                                                                          </div>
                                                                                       </div>
                                                                                 </td>
                                                                              </tr>
                                                                           @endforeach
                                                                     </tbody>
                                                                  </table>
                                                               </div>
                                                         @else
                                                               <div class="d-flex flex-column align-items-center mt-5">
                                                                  <img src="{{ asset('assets/uploads/defaults/nodata.png') }}"
                                                                     width="200">
                                                                  <span class="mt-3">No Contacts</span>
                                                               </div>
                                                         @endif
                                                      </div>
                                                   </div>
                                             </div>
                                             <div class="tab-pane fade" id="emails" role="tabpanel">
                                                   <div class="card shadow-lg">
                                                      <div class="card-body">
                                                         <div class="clearfix mb-3">
                                                               <div class="float-left">
                                                                  <h3 class="card-title">Emails</h3>
                                                               </div>
                                                               <div class="float-right">
                                                                  <button type="button" class="btn btn-sm btn-theme"
                                                                     data-toggle="modal" data-target="#emailModel"> <i
                                                                           class="fa fa-plus"></i> Add Email
                                                                  </button>
                                                                  <div class="modal fade" id="emailModel"
                                                                     tabindex="-1" role="dialog"
                                                                     aria-labelledby="exampleModalCenterTitle"
                                                                     aria-hidden="true">
                                                                     <div class="modal-dialog modal-dialog-centered"
                                                                           role="document">
                                                                           <div class="modal-content">
                                                                              <div class="modal-body">
                                                                                 <h4 class="card-title mb-4">New Email
                                                                                       Form</h4>
                                                                                 <form action="#" method="POST"
                                                                                       id="memberemail_form">
                                                                                       @csrf
                                                                                       <input type="hidden"
                                                                                          name="member_id"
                                                                                          class="form-control"
                                                                                          value="{{ $member->id }}">
                                                                                       <div class="form-group">
                                                                                          <label
                                                                                             for="email">Email</label>
                                                                                          <input type="text"
                                                                                             name="email"
                                                                                             id="email"
                                                                                             class="form-control">
                                                                                          <span
                                                                                             class="invalid-feedback"></span>
                                                                                       </div>
                                                                                       <div class="form-group">
                                                                                          <button type="button"
                                                                                             class="btn btn-sm btn-secondary"
                                                                                             data-dismiss="modal">Cancel</button>
                                                                                          <button type="submit"
                                                                                             class="btn btn-sm btn-theme"
                                                                                             id="btn_memberemail">Add
                                                                                             Email</button>
                                                                                       </div>
                                                                                 </form>
                                                                              </div>
                                                                           </div>
                                                                     </div>
                                                                  </div>
                                                               </div>
                                                         </div>
                                                         @if ($emails->count() > 0)
                                                               <div class="table-responsive">
                                                                  <table class="table table-sm mb-0">
                                                                     <thead>
                                                                           <tr>
                                                                              <th>#</th>
                                                                              <th>Telephone</th>
                                                                              <th>Action</th>
                                                                           </tr>
                                                                     </thead>
                                                                     <tbody>
                                                                           @php $i = 0; @endphp
                                                                           @foreach ($emails as $row)
                                                                              @php $i++; @endphp
                                                                              <tr>
                                                                                 <th scope="row">{{ $i }}
                                                                                 </th>
                                                                                 <td>{{ $row->email }}</td>
                                                                                 <td>
                                                                                       <button type="button"
                                                                                          class="btn btn-xs btn-danger"
                                                                                          data-toggle="modal"
                                                                                          data-target="#deleteEmailModel{{ $row->id }}">
                                                                                          <i
                                                                                             class="fa fa-trash"></i></button>
                                                                                       <div class="modal fade"
                                                                                          id="deleteEmailModel{{ $row->id }}"
                                                                                          tabindex="-1" role="dialog"
                                                                                          aria-hidden="true">
                                                                                          <div class="modal-dialog modal-sm modal-dialog-centered"
                                                                                             role="document">
                                                                                             <div
                                                                                                   class="modal-content border-0">
                                                                                                   <div
                                                                                                      class="modal-body">
                                                                                                      <div class="alert alert-fwarning"
                                                                                                         role="alert">
                                                                                                         <i
                                                                                                               class="fa fa-exclamation-triangle d-block display-4 mt-2 mb-3 text-warning text-center"></i>
                                                                                                         <h3
                                                                                                               class="text-center">
                                                                                                               Delete Email
                                                                                                               {{ $row->email }}?
                                                                                                         </h3>
                                                                                                         <form
                                                                                                               action="#"
                                                                                                               method="POST"
                                                                                                               class="delete_memberemail_form">
                                                                                                               @csrf
                                                                                                               <input
                                                                                                                  type="hidden"
                                                                                                                  name="id"
                                                                                                                  value="{{ $row->id }}">
                                                                                                               <div
                                                                                                                  class="form-group text-center mt-3">
                                                                                                                  <button
                                                                                                                     type="button"
                                                                                                                     class="btn btn-dark"
                                                                                                                     data-dismiss="modal">No,
                                                                                                                     Cancel</button>
                                                                                                                  <button
                                                                                                                     type="submit"
                                                                                                                     class="btn btn-danger delete_memberemail">Yes,
                                                                                                                     Delete</button>
                                                                                                               </div>
                                                                                                         </form>
                                                                                                      </div>
                                                                                                   </div>
                                                                                             </div>
                                                                                          </div>
                                                                                       </div>
                                                                                 </td>
                                                                              </tr>
                                                                           @endforeach
                                                                     </tbody>
                                                                  </table>
                                                               </div>
                                                         @else
                                                               <div class="d-flex flex-column align-items-center mt-5">
                                                                  <img src="{{ asset('assets/uploads/defaults/nodata.png') }}"
                                                                     width="200">
                                                                  <span class="mt-3">No Emails</span>
                                                               </div>
                                                         @endif
                                                      </div>
                                                   </div>
                                             </div>

                                             @if ($member->member_type == 'individual')
                                                   <div class="tab-pane fade" id="memberkycs" role="tabpanel">
                                                      <div class="card shadow-lg">
                                                         <div class="card-body">
                                                               <div class="clearfix mb-3">
                                                                  <div class="float-left">
                                                                     <h3 class="card-title">Member Biodata</h3>
                                                                  </div>
                                                               </div>
                                                               <form action="#" method="POST" id="biodata_form">
                                                                  @csrf
                                                                  <input type="hidden" name="id"
                                                                     class="form-control" value="{{ $member->id }}">
                                                                  <div class="row">
                                                                     <div class="col-md-4">
                                                                           <div class="form-group">
                                                                              <label for="nin"
                                                                                 class="form-label">NIN Number</label>
                                                                              <input type="text" name="nin"
                                                                                 id="nin" class="form-control"
                                                                                 value="{{ $member->nin }}">
                                                                              <span class="invalid-feedback"></span>
                                                                           </div>
                                                                     </div>
                                                                     <div class="col-md-4">
                                                                           <div class="form-group">
                                                                              <label for="no_of_children"
                                                                                 class="form-label">Number of
                                                                                 children</label>
                                                                              <input type="text"
                                                                                 name="no_of_children"
                                                                                 id="no_of_children"
                                                                                 class="form-control"
                                                                                 value="{{ $member->no_of_children }}">
                                                                              <span class="invalid-feedback"></span>
                                                                           </div>
                                                                     </div>
                                                                     <div class="col-md-4">
                                                                           <div class="form-group">
                                                                              <label for="no_of_dependant"
                                                                                 class="form-label">Number of
                                                                                 dependants</label>
                                                                              <input type="text"
                                                                                 name="no_of_dependant"
                                                                                 id="no_of_dependant"
                                                                                 class="form-control"
                                                                                 value="{{ $member->no_of_dependant }}">
                                                                              <span class="invalid-feedback"></span>
                                                                           </div>
                                                                     </div>
                                                                  </div>
                                                                  <div class="row">
                                                                     <div class="col-md-4">
                                                                           <div class="form-group">
                                                                              <label for="crbcard_no"
                                                                                 class="form-label">CRB Card No</label>
                                                                              <input type="text" name="crbcard_no"
                                                                                 id="crbcard_no" class="form-control"
                                                                                 value="{{ $member->crbcard_no }}">
                                                                              <span class="invalid-feedback"></span>
                                                                           </div>
                                                                     </div>
                                                                     <div class="col-md-4">
                                                                           <div class="form-group">
                                                                              <label for="occupation"
                                                                                 class="form-label">Occupation</label>
                                                                              <input type="text" name="occupation"
                                                                                 id="occupation" class="form-control"
                                                                                 value="{{ $member->occupation }}">
                                                                              <span class="invalid-feedback"></span>
                                                                           </div>
                                                                     </div>
                                                                  </div>
                                                                  <div class="row mt-2">
                                                                     <div class="col-md-12">
                                                                           <button type="submit"
                                                                              class="btn btn-block btn-theme"
                                                                              id="btn_biodata">Update Data</button>
                                                                     </div>
                                                                  </div>
                                                               </form>
                                                         </div>
                                                      </div>
                                                   </div>
                                             @endif

                                             @if ($member->member_type == 'group')
                                                   <div class="tab-pane fade" id="groupmembers" role="tabpanel">
                                                      <div class="card">
                                                         <div class="card-body">
                                                               <div class="clearfix mb-3">
                                                                  <div class="float-left">
                                                                     <h3 class="card-title">Group Members</h3>
                                                                  </div>
                                                                  <div class="float-right">
                                                                     <button type="button"
                                                                           class="btn btn-sm btn-theme"
                                                                           data-toggle="modal"
                                                                           data-target="#groupMemberModel"> <i
                                                                              class="fa fa-plus"></i> Add Member
                                                                     </button>
                                                                     <div class="modal fade" id="groupMemberModel"
                                                                           tabindex="-1" role="dialog"
                                                                           aria-labelledby="exampleModalCenterTitle"
                                                                           aria-hidden="true">
                                                                           <div class="modal-dialog modal-lg modal-dialog-centered"
                                                                              role="document">
                                                                              <div class="modal-content">
                                                                                 <div class="modal-body">
                                                                                       <h4 class="card-title mb-4">New
                                                                                          Member Form</h4>
                                                                                       <form action="#"
                                                                                          method="POST"
                                                                                          id="gmember_form">
                                                                                          @csrf
                                                                                          <input type="hidden"
                                                                                             name="member_id"
                                                                                             class="form-control"
                                                                                             value="{{ $member->id }}">
                                                                                          <input type="hidden"
                                                                                             name="member_no"
                                                                                             class="form-control"
                                                                                             value="{{ $member->member_no }}">
                                                                                          <div class="row">
                                                                                             <div class="col-md-6">
                                                                                                   <div
                                                                                                      class="form-group">
                                                                                                      <label
                                                                                                         for="gname">Names</label>
                                                                                                      <input
                                                                                                         type="text"
                                                                                                         name="gname"
                                                                                                         id="gname"
                                                                                                         class="form-control">
                                                                                                      <span
                                                                                                         class="invalid-feedback"></span>
                                                                                                   </div>
                                                                                             </div>
                                                                                             <div class="col-md-6">
                                                                                                   <div
                                                                                                      class="form-group">
                                                                                                      <label
                                                                                                         for="gdesignation">Designation</label>
                                                                                                      <input
                                                                                                         type="text"
                                                                                                         name="gdesignation"
                                                                                                         id="gdesignation"
                                                                                                         class="form-control">
                                                                                                      <span
                                                                                                         class="invalid-feedback"></span>
                                                                                                   </div>
                                                                                             </div>
                                                                                          </div>
                                                                                          <div class="row">
                                                                                             <div class="col-md-6">
                                                                                                   <div
                                                                                                      class="form-group">
                                                                                                      <label
                                                                                                         for="gtelephone">Telephone</label>
                                                                                                      <input
                                                                                                         type="text"
                                                                                                         name="gtelephone"
                                                                                                         id="gtelephone"
                                                                                                         class="form-control">
                                                                                                      <span
                                                                                                         class="invalid-feedback"></span>
                                                                                                   </div>
                                                                                             </div>
                                                                                             <div class="col-md-6">
                                                                                                   <div
                                                                                                      class="form-group">
                                                                                                      <label
                                                                                                         for="gemail">Email</label>
                                                                                                      <input
                                                                                                         type="email"
                                                                                                         name="gemail"
                                                                                                         id="gemail"
                                                                                                         class="form-control">
                                                                                                      <span
                                                                                                         class="invalid-feedback"></span>
                                                                                                   </div>
                                                                                             </div>
                                                                                          </div>
                                                                                          <div class="row">
                                                                                             <div class="col-md-6">
                                                                                                   <div
                                                                                                      class="form-group">
                                                                                                      <label
                                                                                                         for="gaddress">Address</label>
                                                                                                      <textarea name="gaddress" class="form-control" id="gaddress" rows="2"></textarea>
                                                                                                      <span
                                                                                                         class="invalid-feedback"></span>
                                                                                                   </div>
                                                                                             </div>
                                                                                             <div class="col-md-6">
                                                                                                   <div
                                                                                                      class="form-group">
                                                                                                      <label
                                                                                                         for="gphoto">Photo</label>
                                                                                                      <div
                                                                                                         class="image-upload image-uploadx">
                                                                                                         <div
                                                                                                               class="thumb thumbx">
                                                                                                               <img alt="image"
                                                                                                                  class="mr-3"
                                                                                                                  id="gpreview"
                                                                                                                  src="{{ asset('assets/uploads/defaults/author.png') }}"
                                                                                                                  width="60">
                                                                                                               <div
                                                                                                                  class="upload-file">
                                                                                                                  <input
                                                                                                                     type="file"
                                                                                                                     name="gphoto"
                                                                                                                     class="form-control file-upload"
                                                                                                                     id="gphoto">
                                                                                                                  <label
                                                                                                                     for="gphoto"
                                                                                                                     class="btn bg-secondary">upload
                                                                                                                     photo
                                                                                                                  </label>
                                                                                                                  <span
                                                                                                                     class="invalid-feedback"></span>
                                                                                                               </div>
                                                                                                         </div>
                                                                                                      </div>
                                                                                                   </div>
                                                                                             </div>
                                                                                          </div>

                                                                                          <div class="form-group">
                                                                                             <button type="button"
                                                                                                   class="btn btn-sm btn-secondary"
                                                                                                   data-dismiss="modal">Cancel</button>
                                                                                             <button type="submit"
                                                                                                   class="btn btn-sm btn-theme"
                                                                                                   id="btn_gmember">Add
                                                                                                   Member</button>
                                                                                          </div>
                                                                                       </form>
                                                                                 </div>
                                                                              </div>
                                                                           </div>
                                                                     </div>
                                                                  </div>
                                                               </div>
                                                               @if ($groupmembers->count() > 0)
                                                                  <div class="row">
                                                                     <div class="col-md-11 mx-auto">
                                                                           <div class="row">
                                                                              @foreach ($groupmembers as $row)
                                                                                 <div class="col-md-4">
                                                                                       <div class="card shadow-lg">
                                                                                          <img class="card-img-top img-fluid"
                                                                                             src="{{ asset('assets/uploads/members/' . $row->photo) }}"
                                                                                             alt="Card image cap">
                                                                                          <div class="card-body">
                                                                                             <h5 class="card-title">
                                                                                                   {{ $row->name }}
                                                                                             </h5>
                                                                                             <button type="button"
                                                                                                   class="btn btn-xs btn-theme"
                                                                                                   data-toggle="modal"
                                                                                                   data-target="#editgroupMemberModel{{ $row->id }}">
                                                                                                   <i
                                                                                                      class="far fa-edit"></i>
                                                                                                   Edit</button>
                                                                                             <button type="button"
                                                                                                   class="btn btn-xs btn-danger"
                                                                                                   data-toggle="modal"
                                                                                                   data-target="#deletegroupMemberModel{{ $row->id }}">
                                                                                                   <i
                                                                                                      class="fa fa-trash"></i>
                                                                                                   Delete</button>
                                                                                             <div class="modal fade"
                                                                                                   id="deletegroupMemberModel{{ $row->id }}"
                                                                                                   tabindex="-1"
                                                                                                   role="dialog"
                                                                                                   aria-hidden="true">
                                                                                                   <div class="modal-dialog modal-sm modal-dialog-centered"
                                                                                                      role="document">
                                                                                                      <div
                                                                                                         class="modal-content border-0">
                                                                                                         <div
                                                                                                               class="modal-body">
                                                                                                               <div class="alert alert-fwarning"
                                                                                                                  role="alert">
                                                                                                                  <i
                                                                                                                     class="fa fa-exclamation-triangle d-block display-4 mt-2 mb-3 text-warning text-center"></i>
                                                                                                                  <h3
                                                                                                                     class="text-center">
                                                                                                                     Delete
                                                                                                                     Member
                                                                                                                     {{ $row->name }}?
                                                                                                                  </h3>
                                                                                                                  <form
                                                                                                                     action="#"
                                                                                                                     method="POST"
                                                                                                                     class="delete_gmember_form">
                                                                                                                     @csrf
                                                                                                                     <input
                                                                                                                           type="hidden"
                                                                                                                           name="id"
                                                                                                                           value="{{ $row->id }}">
                                                                                                                     <div
                                                                                                                           class="form-group text-center mt-3">
                                                                                                                           <button
                                                                                                                              type="button"
                                                                                                                              class="btn btn-dark"
                                                                                                                              data-dismiss="modal">No,
                                                                                                                              Cancel</button>
                                                                                                                           <button
                                                                                                                              type="submit"
                                                                                                                              class="btn btn-danger delete_gmember">Yes,
                                                                                                                              Delete</button>
                                                                                                                     </div>
                                                                                                                  </form>
                                                                                                               </div>
                                                                                                         </div>
                                                                                                      </div>
                                                                                                   </div>
                                                                                             </div>


                                                                                          </div>
                                                                                       </div>
                                                                                 </div>
                                                                              @endforeach
                                                                           </div>
                                                                     </div>
                                                                  </div>
                                                               @else
                                                                  <div
                                                                     class="d-flex flex-column align-items-center mt-5">
                                                                     <img src="{{ asset('assets/uploads/defaults/nodata.png') }}"
                                                                           width="200">
                                                                     <span class="mt-3">No Members</span>
                                                                  </div>
                                                               @endif
                                                         </div>
                                                      </div>
                                                   </div>
                                             @endif

                                             <div class="tab-pane fade" id="documents" role="tabpanel">
                                                   <div class="card shadow-lg">
                                                      <div class="card-body">
                                                         <div class="clearfix mb-3">
                                                               <div class="float-left">
                                                                  <h3 class="card-title">Document</h3>
                                                               </div>
                                                               <div class="float-right">
                                                                  <button type="button" class="btn btn-sm btn-theme"
                                                                     data-toggle="modal"
                                                                     data-target="#documentModel"> <i
                                                                           class="fa fa-plus"></i> Add Document
                                                                  </button>
                                                                  <div class="modal fade" id="documentModel"
                                                                     tabindex="-1" role="dialog"
                                                                     aria-labelledby="exampleModalCenterTitle"
                                                                     aria-hidden="true">
                                                                     <div class="modal-dialog modal-dialog-centered"
                                                                           role="document">
                                                                           <div class="modal-content">
                                                                              <div class="modal-body">
                                                                                 <h4 class="card-title mb-4">Add Member
                                                                                       Document</h4>
                                                                                 <form action="#" method="POST"
                                                                                       id="memberdocument_form">
                                                                                       @csrf
                                                                                       <input type="hidden"
                                                                                          name="member_id"
                                                                                          class="form-control"
                                                                                          value="{{ $member->id }}">
                                                                                       <input type="hidden"
                                                                                          name="member_no"
                                                                                          class="form-control"
                                                                                          value="{{ $member->member_no }}">
                                                                                       <div class="form-group">
                                                                                          <label
                                                                                             for="file_name">Document
                                                                                             Name</label>
                                                                                          <input type="text"
                                                                                             name="file_name"
                                                                                             id="file_name"
                                                                                             class="form-control"
                                                                                             autocomplete="off">
                                                                                          <span
                                                                                             class="invalid-feedback"></span>
                                                                                       </div>
                                                                                       <div class="form-group">
                                                                                          <label for="file">Upload
                                                                                             file</label>
                                                                                          <input type="file"
                                                                                             name="file"
                                                                                             id="file"
                                                                                             class="form-control">
                                                                                          <span
                                                                                             class="invalid-feedback"></span>
                                                                                       </div>
                                                                                       <div class="form-group mt-3">
                                                                                          <button type="button"
                                                                                             class="btn btn-sm btn-secondary"
                                                                                             data-dismiss="modal">Cancel</button>
                                                                                          <button type="submit"
                                                                                             class="btn btn-sm btn-theme"
                                                                                             id="btn_memberdocument">Upload
                                                                                             Document</button>
                                                                                       </div>
                                                                                 </form>
                                                                              </div>
                                                                           </div>
                                                                     </div>
                                                                  </div>
                                                               </div>
                                                         </div>
                                                         @if ($documents->count() > 0)
                                                               <div class="table-responsive">
                                                                  <table class="table table-sm mb-0">
                                                                     <thead>
                                                                           <tr>
                                                                              <th>#</th>
                                                                              <th>File Name</th>
                                                                              <th>File Type</th>
                                                                              <th>Action</th>
                                                                           </tr>
                                                                     </thead>
                                                                     <tbody>
                                                                           @php $i = 0; @endphp
                                                                           @foreach ($documents as $row)
                                                                              @php $i++; @endphp
                                                                              <tr>
                                                                                 <th scope="row">
                                                                                       {{ $i }}</th>
                                                                                 <td><a href="{{ asset('assets/uploads/members/' . $row->file) }}"
                                                                                          target="_blank">{{ $row->file_name }}</a>
                                                                                 </td>
                                                                                 <td>{{ $row->file_type }}</td>
                                                                                 <td>
                                                                                       <button type="button"
                                                                                          class="btn btn-xs btn-danger"
                                                                                          data-toggle="modal"
                                                                                          data-target="#deleteDocumentModel{{ $row->id }}">
                                                                                          <i
                                                                                             class="fa fa-trash"></i></button>
                                                                                       <div class="modal fade"
                                                                                          id="deleteDocumentModel{{ $row->id }}"
                                                                                          tabindex="-1"
                                                                                          role="dialog"
                                                                                          aria-hidden="true">
                                                                                          <div class="modal-dialog modal-sm modal-dialog-centered"
                                                                                             role="document">
                                                                                             <div
                                                                                                   class="modal-content border-0">
                                                                                                   <div
                                                                                                      class="modal-body">
                                                                                                      <div class="alert alert-fwarning"
                                                                                                         role="alert">
                                                                                                         <i
                                                                                                               class="fa fa-exclamation-triangle d-block display-4 mt-2 mb-3 text-warning text-center"></i>
                                                                                                         <h3
                                                                                                               class="text-center">
                                                                                                               Delete
                                                                                                               Document
                                                                                                               {{ $row->file_name }}?
                                                                                                         </h3>
                                                                                                         <form
                                                                                                               action="#"
                                                                                                               method="POST"
                                                                                                               class="delete_memberdocument_form">
                                                                                                               @csrf
                                                                                                               <input
                                                                                                                  type="hidden"
                                                                                                                  name="id"
                                                                                                                  value="{{ $row->id }}">
                                                                                                               <div
                                                                                                                  class="form-group text-center mt-3">
                                                                                                                  <button
                                                                                                                     type="button"
                                                                                                                     class="btn btn-dark"
                                                                                                                     data-dismiss="modal">No,
                                                                                                                     Cancel</button>
                                                                                                                  <button
                                                                                                                     type="submit"
                                                                                                                     class="btn btn-danger delete_memberdocument">Yes,
                                                                                                                     Delete</button>
                                                                                                               </div>
                                                                                                         </form>
                                                                                                      </div>
                                                                                                   </div>
                                                                                             </div>
                                                                                          </div>
                                                                                       </div>
                                                                                 </td>
                                                                              </tr>
                                                                           @endforeach
                                                                     </tbody>
                                                                  </table>
                                                               </div>
                                                         @else
                                                               <div class="d-flex flex-column align-items-center mt-5">
                                                                  <img src="{{ asset('assets/uploads/defaults/nodata.png') }}"
                                                                     width="200">
                                                                  <span class="mt-3">No Documents</span>
                                                               </div>
                                                         @endif
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
         </div>
      </div>
   </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        "use strict";
        $('.nav-tabs a').on('shown.bs.tab', function(event) {
            var tab = $(event.target).attr("href");
            var url = "{{ route('webmaster.member.dashboard', $member->member_no) }}";
            history.pushState({}, null, url + "?tab=" + tab.substring(1));
        });

        @if (isset($_GET['tab']))
            $('.nav-tabs a[href="#{{ $_GET['tab'] }}"]').tab('show');
        @endif

        // $('.nav-pills a').on('shown.bs.tab', function(event){
        //    var tab = $(event.target).attr("href");
        //    var url = "{{ route('webmaster.member.dashboard', $member->member_no) }}" + '?tab=information';
        //     history.pushState({}, null, url + "?tab=" + tab.substring(1));
        // });

        // @if (isset($_GET['tab']))
        //    $('.nav-pills a[href="#{{ $_GET['tab'] }}"]').tab('show');
        // @endif


        $("#pphoto").change(function(e) {
            const file = e.target.files[0];
            let url = window.URL.createObjectURL(file);
            $("#pp_preview").attr('src', url);
            let form_data = new FormData();
            form_data.append('pphoto', file);
            form_data.append('id', $("#memberid").val());
            form_data.append('_token', '{{ csrf_token() }}');
            $.ajax({
                url: '{{ route('webmaster.memberphoto.update') }}',
                method: 'post',
                data: form_data,
                cache: false,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    $("#pphoto").val('');
                    window.location.reload();
                }
            });
        });

        $("#individual_form").submit(function(e) {
            e.preventDefault();
            $("#btn_individual").html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Updating'
            );
            $("#btn_individual").prop("disabled", true);
            $.ajax({
                url: '{{ route('webmaster.member.individual.update') }}',
                method: 'post',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == 400) {
                        $.each(response.message, function(key, value) {
                            showError(key, value);
                        });
                        $("#btn_individual").html('Update Information');
                        $("#btn_individual").prop("disabled", false);
                    } else if (response.status == 200) {
                        //$("#individual_form")[0].reset();
                        removeErrors("#individual_form");
                        $("#btn_individual").html('Update Information');
                        $("#btn_individual").prop("disabled", false);
                        setTimeout(function() {
                            window.location.reload();
                        }, 500);

                    }
                }
            });
        });

        $("#biodata_form").submit(function(e) {
            e.preventDefault();
            $("#btn_biodata").html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Updating'
            );
            $("#btn_biodata").prop("disabled", true);
            $.ajax({
                url: '{{ route('webmaster.member.biodata.update') }}',
                method: 'post',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == 400) {
                        $.each(response.message, function(key, value) {
                            showError(key, value);
                        });
                        $("#btn_biodata").html('Update Data');
                        $("#btn_biodata").prop("disabled", false);
                    } else if (response.status == 200) {
                        //$("#biodata_form")[0].reset();
                        removeErrors("#biodata_form");
                        $("#btn_biodata").html('Update Data');
                        $("#btn_biodata").prop("disabled", false);
                        setTimeout(function() {
                            window.location.reload();
                        }, 500);

                    }
                }
            });
        });

        $("#mgroup_form").submit(function(e) {
            e.preventDefault();
            $("#btn_mgroup").html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Updating'
            );
            $("#btn_mgroup").prop("disabled", true);
            $.ajax({
                url: '{{ route('webmaster.member.group.update') }}',
                method: 'post',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == 400) {
                        $.each(response.message, function(key, value) {
                            showError(key, value);
                        });
                        $("#btn_mgroup").html('Update Information');
                        $("#btn_mgroup").prop("disabled", false);
                    } else if (response.status == 200) {
                        $("#mgroup_form")[0].reset();
                        removeErrors("#mgroup_form");
                        $("#btn_mgroup").html('Update Information');
                        $("#btn_mgroup").prop("disabled", false);
                        setTimeout(function() {
                            window.location.reload();
                        }, 500);

                    }
                }
            });
        });


        $("#contact_form").submit(function(e) {
            e.preventDefault();
            $("#btn_contact").html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding'
            );
            $("#btn_contact").prop("disabled", true);
            $.ajax({
                url: '{{ route('webmaster.membercontact.store') }}',
                method: 'post',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == 400) {
                        $.each(response.message, function(key, value) {
                            showError(key, value);
                        });
                        $("#btn_contact").html('Add Contact');
                        $("#btn_contact").prop("disabled", false);
                    } else if (response.status == 200) {
                        removeErrors("#contact_form");
                        $("#contact_form")[0].reset();
                        $("#btn_contact").html('Add Contact');
                        setTimeout(function() {
                            $("#btn_contact").prop("disabled", false);
                            window.location.reload();
                        }, 500);
                    }
                }
            });
        });

        $(".delete_contact_form").submit(function(e) {
            e.preventDefault();
            $(".delete_contact").html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Deleting..'
            );
            $(".delete_contact").prop("disabled", true);
            $.ajax({
                url: '{{ route('webmaster.membercontact.delete') }}',
                method: 'post',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    $(".delete_contact").html('Yes, Delete');
                    setTimeout(function() {
                        $(".delete_contact").prop("disabled", false);
                        window.location.reload();
                    }, 500);
                }
            });
        });

        $("#memberemail_form").submit(function(e) {
            e.preventDefault();
            $("#btn_memberemail").html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding'
            );
            $("#btn_memberemail").prop("disabled", true);
            $.ajax({
                url: '{{ route('webmaster.memberemail.store') }}',
                method: 'post',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == 400) {
                        $.each(response.message, function(key, value) {
                            showError(key, value);
                        });
                        $("#btn_memberemail").html('Add Email');
                        $("#btn_memberemail").prop("disabled", false);
                    } else if (response.status == 200) {
                        removeErrors("#memberemail_form");
                        $("#memberemail_form")[0].reset();
                        $("#btn_memberemail").html('Add Email');
                        setTimeout(function() {
                            $("#btn_memberemail").prop("disabled", false);
                            window.location.reload();
                        }, 500);
                    }
                }
            });
        });

        $(".delete_memberemail_form").submit(function(e) {
            e.preventDefault();
            $(".delete_memberemail").html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Deleting..'
            );
            $(".delete_memberemail").prop("disabled", true);
            $.ajax({
                url: '{{ route('webmaster.memberemail.delete') }}',
                method: 'post',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    $(".delete_memberemail").html('Yes, Delete');
                    setTimeout(function() {
                        $(".delete_memberemail").prop("disabled", false);
                        window.location.reload();
                    }, 500);
                }
            });
        });

        <?php if ($member->member_type == 'group') {  ?>

        previewImage("gphoto", "gpreview");
        $("#gmember_form").submit(function(e) {
            e.preventDefault();
            $("#btn_gmember").html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding'
            );
            $("#btn_gmember").prop("disabled", true);
            var formData = new FormData(this);
            $.ajax({
                url: '{{ route('webmaster.groupmember.store') }}',
                method: 'post',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 400) {
                        $.each(response.message, function(key, value) {
                            showError(key, value);
                        });
                        $("#btn_gmember").html('Add Member');
                        $("#btn_gmember").prop("disabled", false);
                    } else if (response.status == 200) {
                        $("#gmember_form")[0].reset();
                        removeErrors("#gmember_form");
                        $("#btn_gmember").html('Add Member');
                        $("#btn_gmember").prop("disabled", false);
                        setTimeout(function() {
                            window.location.reload();
                        }, 500);

                    }
                }
            });
        });

        $(".delete_gmember_form").submit(function(e) {
            e.preventDefault();
            $(".delete_gmember").html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Deleting..'
            );
            $(".delete_gmember").prop("disabled", true);
            $.ajax({
                url: '{{ route('webmaster.groupmember.delete') }}',
                method: 'post',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    $(".delete_gmember").html('Yes, Delete');
                    setTimeout(function() {
                        $(".delete_gmember").prop("disabled", false);
                        window.location.reload();
                    }, 500);
                }
            });
        });

        <?php } ?>

        $("#memberdocument_form").submit(function(e) {
            e.preventDefault();
            $("#btn_memberdocument").html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding'
            );
            $("#btn_memberdocument").prop("disabled", true);
            var formData = new FormData(this);
            $.ajax({
                url: '{{ route('webmaster.memberdocument.store') }}',
                method: 'post',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 400) {
                        $.each(response.message, function(key, value) {
                            showError(key, value);
                        });
                        $("#btn_memberdocument").html('Add Document');
                        $("#btn_memberdocument").prop("disabled", false);
                    } else if (response.status == 200) {
                        $("#memberdocument_form")[0].reset();
                        removeErrors("#memberdocument_form");
                        $("#btn_memberdocument").html('Add Document');
                        $("#btn_memberdocument").prop("disabled", false);
                        setTimeout(function() {
                            window.location.reload();
                        }, 500);

                    }
                }
            });
        });

        $(".delete_memberdocument_form").submit(function(e) {
            e.preventDefault();
            $(".delete_memberdocument").html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Deleting..'
            );
            $(".delete_memberdocument").prop("disabled", true);
            $.ajax({
                url: '{{ route('webmaster.memberdocument.delete') }}',
                method: 'post',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    $(".delete_memberdocument").html('Yes, Delete');
                    setTimeout(function() {
                        $(".delete_memberdocument").prop("disabled", false);
                        window.location.reload();
                    }, 500);
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
          // Mini Bar charts
            $('.peity-bar').peity('bar');
            var loanData = @json($loandata);
            var accountData = @json($accountdata);
            var investmentData = @json($investmentdata);
            var savingsData = @json($savingdata);
            console.log(loanData)
            const accountGraph = () =>{
               const availableBalance = accountData.available_balance;
               const currentBalance = accountData.current_balance;
                    var data = [{
                    values: [currentBalance, availableBalance],
                    labels: ['Current Balance', 'Available Balance'],
                    type: 'pie',
                    hoverinfo: 'label+value', // Show label and percentage on hover
                    // textinfo: 'label+value', // Display label and value on slices
                    // textposition: 'outside', // Position text outside the pie slices
                    automargin: true,
                    // marker: {
                    // colors: ['#1f77b4', '#ff7f0e'] // Custom colors for the slices
                    // }
                }];

                // Layout settings
                var layout = {
                    // title: 'Loan Amount Distribution',
                    height: 300,
                    showlegend: true, // Display legend
                    legend: {
                        x: 1,
                        y: 0.5,
                        orientation: 'v' // Vertical legend
                    },
                    margin: {
                        l: 10,
                        r: 10,
                        b: 10,
                        t: 10,
                        pad: 4
                    },
                    autosize: true,
                    responsive: true
                };

                // Configuration settings
                var config = {
                    responsive: true, // Make chart responsive
                    displayModeBar: true, // Show mode bar with zoom/pan options
                    displaylogo: false, // Remove Plotly logo
                    scrollZoom: true // Enable scroll zooming
                };

                Plotly.newPlot('accountStatus', data, layout, config);

                // Resize chart on window resize
                window.onresize = function() {
                    Plotly.Plots.resize('accountStatus');
                };
            }
            const investmentGraph = () =>{
               const investmentAmount = investmentData.investment_amount;
               const investmentInterest = investmentData.interest_amount;
               const returnOnInvestment = investmentData.roi;
                    var data = [{
                    values: [investmentAmount,investmentInterest,returnOnInvestment],
                    labels: ['Investment Amount', 'Interest', 'Return On Investment'],
                    type: 'pie',
                    hoverinfo: 'label+value', // Show label and percentage on hover
                    // textinfo: 'label+value', // Display label and value on slices
                    // textposition: 'outside', // Position text outside the pie slices
                    automargin: true,
                    // marker: {
                    // colors: ['#1f77b4', '#ff7f0e'] // Custom colors for the slices
                    // }
                }];

                // Layout settings
                var layout = {
                    // title: 'Loan Amount Distribution',
                    height: 300,
                    showlegend: true, // Display legend
                    legend: {
                        x: 1,
                        y: 0.5,
                        orientation: 'v' // Vertical legend
                    },
                    margin: {
                        l: 10,
                        r: 10,
                        b: 10,
                        t: 10,
                        pad: 4
                    },
                    autosize: true,
                    responsive: true
                };

                // Configuration settings
                var config = {
                    responsive: true, // Make chart responsive
                    displayModeBar: true, // Show mode bar with zoom/pan options
                    displaylogo: false, // Remove Plotly logo
                    scrollZoom: true // Enable scroll zooming
                };

                Plotly.newPlot('investmentSummary', data, layout, config);

                // Resize chart on window resize
                window.onresize = function() {
                    Plotly.Plots.resize('investmentSummary');
                };
            }
            const savingsGraph = () =>{
               const totalDeposits =savingsData.deposit_amount;
               const totalSavings = savingsData.total_savings;
                    var data = [{
                    values: [totalDeposits, totalSavings],
                    labels: ['Total Deposits', 'Total Savings'],
                    type: 'pie',
                    hoverinfo: 'label+value', // Show label and percentage on hover
                    // textinfo: 'label+value', // Display label and value on slices
                    // textposition: 'outside', // Position text outside the pie slices
                    automargin: true,
                    // marker: {
                    // colors: ['#1f77b4', '#ff7f0e'] // Custom colors for the slices
                    // }
                }];

                // Layout settings
                var layout = {
                    // title: 'Loan Amount Distribution',
                    height: 300,
                    showlegend: true, // Display legend
                    legend: {
                        x: 1,
                        y: 0.5,
                        orientation: 'v' // Vertical legend
                    },
                    margin: {
                        l: 10,
                        r: 10,
                        b: 10,
                        t: 10,
                        pad: 4
                    },
                    autosize: true,
                    responsive: true
                };

                // Configuration settings
                var config = {
                    responsive: true, // Make chart responsive
                    displayModeBar: true, // Show mode bar with zoom/pan options
                    displaylogo: false, // Remove Plotly logo
                    scrollZoom: true // Enable scroll zooming
                };

                Plotly.newPlot('savingsSummary', data, layout, config);

                // Resize chart on window resize
                window.onresize = function() {
                    Plotly.Plots.resize('savingsSummary');
                };
            }
            const loanGraph = () => {
                var principalAmount = loanData.principal_amount
                var repaymentAmount = loanData.loan_amount
                var interestAmount = loanData.interest_amount

                var data = [{
                    values: [principalAmount, interestAmount, repaymentAmount],
                    labels: ['Principal', 'Interest', 'Repayment Amount'],
                    type: 'pie',
                    hoverinfo: 'label+value', // Show label and percentage on hover
                    // textinfo: 'label+value', // Display label and value on slices
                    // textposition: 'outside', // Position text outside the pie slices
                    automargin: true,
                    // marker: {
                    // colors: ['#1f77b4', '#ff7f0e'] // Custom colors for the slices
                    // }
                }];

                // Layout settings
                var layout = {
                    // title: 'Loan Amount Distribution',
                    height: 300,
                    showlegend: true, // Display legend
                    legend: {
                        x: 1,
                        y: 0.5,
                        orientation: 'v' // Vertical legend
                    },
                    margin: {
                        l: 10,
                        r: 10,
                        b: 10,
                        t: 10,
                        pad: 4
                    },
                    autosize: true,
                    responsive: true
                };

                // Configuration settings
                var config = {
                    responsive: true, // Make chart responsive
                    displayModeBar: true, // Show mode bar with zoom/pan options
                    displaylogo: false, // Remove Plotly logo
                    scrollZoom: true // Enable scroll zooming
                };

                Plotly.newPlot('loanStatus', data, layout, config);

                // Resize chart on window resize
                window.onresize = function() {
                    Plotly.Plots.resize('loanStatus');
                };

            }

            const loanInfo = () => {
                const loanPaid = loanData.repaid_amount;
                const loanRemaining = loanData.loan_amount - loanPaid;
                const loanPenalty = loanData.penalty_amount;
                const loanFees = loanData.fees_total;
                // Custom titles for the x-axis
                var categories = ['Loan Paid', 'Outstanding Loan', 'Loan Penalty', 'Loan Fees'];
                var values = [loanPaid, loanRemaining, loanPenalty, loanFees];
                var data = [{
                    x: categories,
                    y: values,
                    type: 'bar',
                    marker: {
                        color: ['#1f77b4', '#ff7f0e', '#2ca02c',
                            '#d62728'
                        ] // Custom colors for each bar
                    }
                }];

                // Layout settings
                var layout = {
                    title: {
                        // text: 'Loan Data Summary',
                        x: 0.5, // Center the title
                        y: 0.95, // Position title below the mode bar
                        xanchor: 'center',
                        yanchor: 'top'
                    },
                    height: 300,
                    xaxis: {
                        // title: 'Category',
                        automargin: true,
                        tickangle: -45 // Tilt the x-axis labels if needed
                    },
                    yaxis: {
                        title: 'Amount',
                        automargin: true
                    },
                    autosize: true,
                    responsive: true,
                    margin: {
                        l: 20,
                        r: 20,
                        b: 50,
                        t: 40,
                        pad: 4 // Adjust bottom margin for tilted labels
                    }
                };

                // Configuration settings
                var config = {
                    responsive: true,
                    displayModeBar: true,
                    displaylogo: false,
                    scrollZoom: true
                };

                // Render the chart
                Plotly.newPlot('loanInfo', data, layout, config);

                // Resize chart on window resize
                window.onresize = function() {
                    Plotly.Plots.resize('loanInfo');
                };
            }


            accountGraph()
            savingsGraph()
            investmentGraph()
            loanGraph()
            loanInfo()
        });
    </script>
@endsection
