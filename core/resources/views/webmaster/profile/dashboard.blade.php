@extends('webmaster.partials.main')
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
              <div class="col-md-8">
                <strong class="card-title align-self-center">CASH FLOW FORECAST</strong>
              </div>
              <div class="col-md-4">
                <div class="btn-group" role="group" aria-label="Basic example">
                  <button type="button" class="btn btn-outline-secondary btn-sm">Money in / out</button>
                  <button type="button" class="btn btn-outline-secondary btn-sm">Balance</button>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4 col-xl-4 col-6">
                <div class="card">
                  <div class="card-body">
                    <div class="mb-3">
                      <h6 class="text-muted mb-0">Total Deposits</h6>
                    </div>
                    <div class="align-items-center">
                      <h4 class="align-items-center mb-0">
                        {!! isset($savingdata->deposit_amount) ? showAmount($savingdata->deposit_amount) :
                        0!!}
                      </h4>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-xl-4 col-6">
                <div class="card">
                  <div class="card-body">
                    <div class="mb-3">
                      <h6 class="text-muted mb-0">Current balance</h6>
                    </div>
                    <div class="align-items-center">
                      <h4 class="d-flex align-items-center mb-0">
                        {!! isset($accountdata->current_balance) ? showAmount($accountdata->current_balance)
                        : 0 !!}
                      </h4>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-xl-4 col-6">
                <div class="card">
                  <div class="card-body">
                    <div class="mb-3">
                      <h6 class="text-muted mb-0">Available Balance</h6>
                    </div>
                    <div class="align-items-center">
                      <h4 class="d-flex align-items-center mb-0">
                        {!! isset($accountdata->available_balance) ?
                        showAmount($accountdata->available_balance) : 0 !!}
                      </h4>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-xl-4 col-6">
                <div class="card">
                  <div class="card-body">
                    <div class="mb-3">
                      <h6 class="text-muted mb-0">Total Accounts</h6>
                    </div>
                    <div class="align-items-center">
                      <h4 class="d-flex align-items-center mb-0">
                        {{ $accountdata->total_accounts }}
                      </h4>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-4 col-xl-4 col-6">
                <div class="card">
                  <div class="card-body">
                    <div class="mb-3">
                      <h6 class="text-muted mb-0">Savings Transactions</h6>
                    </div>
                    <div class="align-items-center">
                      <h4 class="d-flex align-items-center mb-0">
                        {{ $savingdata->total_savings }}
                      </h4>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-xl-4 col-6">
                <div class="card">
                  <div class="card-body">
                    <div class="mb-3">
                      <h6 class="text-muted mb-0">Banked Amount</h6>
                    </div>
                    <div class="align-items-center">
                      <h4 class="d-flex align-items-center mb-0">
                        0
                      </h4>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class='row'>
          <!--  -->
          <div class='col-md-6 col-xl-6 col-6'>
            <div class='card'>
              <div class="card-body">
                <div class='row'>
                  <div class='col-md-8'>
                    <strong class='fs-6'>EXPENSES</strong>
                  </div>
                  <div class=' col-md-4'>
                    <small class='text-muted mb-0'>last 30 days <i class='mdi mdi-chevron-down'></i></small>
                  </div>

                  <div class='col-md-12 mt-4'>
                    <div class='row'>
                      <div class='col-md-12'>
                        <strong>=/ 0.00</strong>
                      </div>
                      <div class='col-md-12'>
                        <small class='text-muted mb-0'>Total expenses</small>
                      </div>
                    </div>
                  </div>

                </div>

              </div>
            </div>
          </div>
          <!--  -->
          <div class='col-md-6 col-xl-6 col-6'>
            <div class='card'>
              <div class="card-body">
                <div class='row'>
                  <div class='col-md-12'>
                    <strong class='fs-6'>PROFIT AND LOST</strong>
                  </div>
                  <div class='col-md-12 mt-3'>
                    <div class='row'>
                      <div class='col-md-12'>
                        <small><b>=/ 0.00</b></small>
                      </div>
                      <div class='col-md-12'>
                        <small class='text-muted mb-0'>Net income for last 30 days </small>
                      </div>

                      <div class='col-md-12 mt-3'>
                        <small class='text-muted mb-0'><b>Incomes</b> </small>
                      </div>
                      <div class='col-md-12  mt-1'>
                        <div class="progress">
                          <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25"
                            aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                      </div>
                      <div class='col-md-12 mt-3'>
                        <small class='text-muted mb-0'><b>Expenses</b> </small>
                      </div>
                      <div class='col-md-12 mt-1'>
                        <div class="progress">
                          <div class="progress-bar bg-danger" role="progressbar" style="width: 70%" aria-valuenow="70"
                            aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                      </div>
                    </div>

                  </div>

                </div>

              </div>

            </div>
          </div>
          <!--  -->

        </div>
      </div>
    </div>

    <!-- row  -->
  </div>
  <div class="col-md-4">
    <div class="card mb-0">
      <div class="card-body">
        <div class="row mx-0">
          <div class="row mx-0 d-flex justify-content-between mb-4 w-100">
            <h5 class="card-title mb-0">BANK ACCOUNT</h5>
            <i class="mdi mdi-pencil"></i>
          </div>
          <div class="col-md-12 px-0 d-flex flex-wrap w-100 gap_2">
            <div class="w-100 paper">
              <div class="row mx-0 d-flex justify-content-between w-100 align-items-center">
                <h5 class="card-title mb-0 font-size-14">Checking(4000)</h5>
                <div><i class="mdi mdi-checkbox-marked-circle-outline"></i>
                  <span class="font-size-12">Reviewed</span>
                </div>
              </div>
              <div class="d-flex justify-content-between paperbody">
                <i class="font-size-12">Upadted 1 day ago</i>
              </div>
              <div class="d-flex flex-column py-2 paperbody">
                <div class="d-flex justify-content-between">
                  <span class="font-size-12">Bank Balance</span>
                  <span class="font-size-12">$589.49</span>
                </div>
                <div class="d-flex justify-content-between">
                  <span class="font-size-12">In Quickbooks</span>
                  <span class="font-size-12">$23,589.49</span>
                </div>
              </div>
            </div>

            <div class="w-100 paper">
              <div class="row mx-0 d-flex justify-content-between w-100 align-items-center">
                <h5 class="card-title mb-0 font-size-14">Checking(4000)</h5>
                <div><i class="mdi mdi-checkbox-marked-circle-outline"></i>
                  <span class="font-size-12">Reviewed</span>
                </div>
              </div>
              <div class="d-flex justify-content-between paperbody">
                <i class="font-size-12">Upadted 1 day ago</i>
              </div>
              <div class="d-flex flex-column py-2 paperbody">
                <div class="d-flex justify-content-between">
                  <span class="font-size-12">Bank Balance</span>
                  <span class="font-size-12">$589.49</span>
                </div>
                <div class="d-flex justify-content-between">
                  <span class="font-size-12">In Quickbooks</span>
                  <span class="font-size-12">$23,589.49</span>
                </div>
              </div>
            </div>

            <div class="w-100 paper">
              <div class="row mx-0 d-flex justify-content-between w-100 align-items-center">
                <h5 class="card-title mb-0 font-size-14">Checking(4000)</h5>
                <div><i class="mdi mdi-checkbox-marked-circle-outline"></i>
                  <span class="font-size-12">Reviewed</span>
                </div>
              </div>
              <div class="d-flex justify-content-between paperbody">
                <i class="font-size-12">Upadted 1 day ago</i>
              </div>
              <div class="d-flex flex-column py-2 paperbody">
                <div class="d-flex justify-content-between">
                  <span class="font-size-12">Bank Balance</span>
                  <span class="font-size-12">$589.49</span>
                </div>
                <div class="d-flex justify-content-between">
                  <span class="font-size-12">In Quickbooks</span>
                  <span class="font-size-12">$23,589.49</span>
                </div>
              </div>
            </div>

            <div class="w-100 paper">
              <div class="row mx-0 d-flex justify-content-between w-100 align-items-center">
                <h5 class="card-title mb-0 font-size-14">Checking(4000)</h5>
                <div><i class="mdi mdi-checkbox-marked-circle-outline"></i>
                  <span class="font-size-12">Reviewed</span>
                </div>
              </div>
              <div class="d-flex justify-content-between paperbody">
                <i class="font-size-12">Upadted 1 day ago</i>
              </div>
              <div class="d-flex flex-column py-2 paperbody">
                <div class="d-flex justify-content-between">
                  <span class="font-size-12">Bank Balance</span>
                  <span class="font-size-12">$589.49</span>
                </div>
                <div class="d-flex justify-content-between">
                  <span class="font-size-12">In Quickbooks</span>
                  <span class="font-size-12">$23,589.49</span>
                </div>
              </div>
            </div>

            <div class="w-100 paper">
              <div class="row mx-0 d-flex justify-content-between w-100 align-items-center">
                <h5 class="card-title mb-0 font-size-14">Checking(4000)</h5>
                <div><i class="mdi mdi-checkbox-marked-circle-outline"></i>
                  <span class="font-size-12">Reviewed</span>
                </div>
              </div>
              <div class="d-flex justify-content-between paperbody">
                <i class="font-size-12">Upadted 1 day ago</i>
              </div>
              <div class="d-flex flex-column py-2 paperbody">
                <div class="d-flex justify-content-between">
                  <span class="font-size-12">Bank Balance</span>
                  <span class="font-size-12">$589.49</span>
                </div>
                <div class="d-flex justify-content-between">
                  <span class="font-size-12">In Quickbooks</span>
                  <span class="font-size-12">$23,589.49</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- <div class="row">
   <div class="col-md-12">
      <div class="card">
         <div class="card-body">
            <div class="row">
               <div class="col-md-9">
            <h4 class="card-title">Loans Overview</h4>

            <div class="row">
               <div class="col-md-4 col-xl-4">
                  <div class="card">
                     <div class="card-body">
                        <div class="mb-3">
                           <h6 class="text-muted mb-0">Principal Amount</h6>
                        </div>
                        <div class="align-items-center">
                           <h4 class="align-items-center mb-0">
                            {!! showAmount($loandata->principal_amount) !!}
                           </h4>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-4 col-xl-4">
                  <div class="card">
                     <div class="card-body">
                        <div class="mb-3">
                           <h6 class="text-muted mb-0">Interests Amount</h6>
                        </div>
                        <div class="align-items-center">
                           <h4 class="d-flex align-items-center mb-0">
                             {!! showAmount($loandata->interest_amount) !!}
                           </h4>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-4 col-xl-4">
                  <div class="card">
                     <div class="card-body">
                        <div class="mb-3">
                           <h6 class="text-muted mb-0">Loan Amount</h6>
                        </div>
                        <div class="align-items-center">
                           <h4 class="d-flex align-items-center mb-0">
                           {!! showAmount($loandata->loan_amount) !!}
                           </h4>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-6 col-xl-6">
                  <div class="card shadow-lg">
                     <div class="card-body">
                        @php
                          $collectedPercentage = $loandata->repaid_amount != 0 ? round(($loandata->repaid_amount / $loandata->loan_amount) * 100, 2) : 0;
                        @endphp
                        <div class="mb-4">
                           <span class="text-success float-right"><strong>{{ $collectedPercentage }}%</strong></span>
                           <p class="card-title mb-0">Repaid Amount</p>
                        </div>
                        <div class="align-items-center mb-4">
                           <h2 class="align-items-center mb-0">
                             {!! showAmount($loandata->repaid_amount) !!}
                           </h2>
                        </div>
                        <div class="progress shadow-sm" style="height: 5px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $collectedPercentage }}%;"></div>
                </div>
                     </div>
                  </div>
               </div>
                
               <div class="col-md-6 col-xl-6">
                  <div class="card shadow-lg">
                     <div class="card-body">
                        @php
                          $balancePercentage = $loandata->balance_amount != 0 ?  round(($loandata->balance_amount / $loandata->loan_amount) * 100, 2) : 0;
                        @endphp

                        <div class="mb-4">
                           <span class="text-danger float-right"><strong>{{ $balancePercentage }}%</strong></span>
                           <h5 class="card-title mb-0">Balance Amount</h5>
                        </div>
                        <div class="align-items-center mb-4">
                           <h2 class="align-items-center mb-0">
                              {!! showAmount($loandata->balance_amount) !!}
                           </h2>
                        </div>
                        <div class="progress shadow-sm" style="height: 5px;">
                    
                    <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $balancePercentage }}%;"></div>
                </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-3">
            <div class="row">
         <div class="col-md-12">
            <div class="card shadow-lg mt-5">
                     <div class="card-body">
                        <div class="mb-3">
                           <h5 class="card-title mb-0">Loan Fees</h5>
                        </div>
                        <div class="row d-flex align-items-center">
                           <div class="col-8">
                              <h2 class="d-flex align-items-center mb-0">
                                {!! showAmount($loandata->fees_total) !!}
                              </h2>
                           </div>
                        </div>
                     </div>
                  </div>
         </div>
         <div class="col-md-12">
            <div class="card shadow-lg">
                     <div class="card-body">
                        <div class="mb-3">
                           <h5 class="card-title mb-0">Penalty Amount</h5>
                        </div>
                        <div class="row d-flex align-items-center mb-2">
                           <div class="col-8">
                              <h2 class="d-flex align-items-center mb-0">
                                 {!! showAmount($loandata->penalty_amount) !!}
                              </h2>
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
</div> -->

  @endsection$