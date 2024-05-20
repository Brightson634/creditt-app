@extends('webmaster.partials.main')
@section('title')
{{ $page_title }}
@endsection
@section('content')

<!-- {{ $loandata }} -->

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
                                 <a class="btn  btn-sm btn-outline-secondary" href="{{ route('webmaster.loanpayment.create') }}" role="button">Make payment</a>
                                 </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12 col-xl-12 col-12">
                                <div id="chart_div">
                                    {!! $lava->render('ColumnChart','IMDB', 'chart_div') !!}
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
                                                <small class='mb-0' style="color:#1976d2;">Savings for last 30 days </small>
                                            </div>
                                            <br />
                                            <br />
                                            <br/>
                                
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
                                            
                                            <br/>
                                            <br/>
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
                                                    {!! $lava->render('DonutChart','LOANS','chart') !!}

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
                                            <br/>
                                            <br/>
                                            <div class='col-md-12'>
                                                <div id='chart_expense'>
                                                    {!! $lava->render('DonutChart','EXPENSES','chart_expense') !!}

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
                                                    {!! $lava->render('AreaChart','Population','chart_pop') !!}

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
                                    {!! $lava->render('LineChart','STATISTIC', 'chart_divs') !!}
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
                                @foreach($recentTransaction as $item)

                                <div class="w-100 paper">
                                    <div class="row mx-0 d-flex justify-content-between w-100 align-items-center">
                                        <h5 class="card-title mb-0" style="font-size:10px">TID {{$item->id}}</h5>
                                       
                                        <div><i class="mdi mdi-checkbox-marked-circle-outline" style="color:#3366CC;"></i>
                                            <!-- <span class="font-size-12"> Pending</span> -->
                                        </div>
                                    </div>
                                    <br/>
                                    <div class="d-flex justify-content-between paperbody">
                                    <span class="font-size-12" style="color:#1976d2;">
                                    <span class="mdi mdi-account"/> &nbsp;
                                    {{$item->member->fname}}
                                    </span>
                                    </div>
                                    <div class="d-flex flex-column py-2 paperbody">
                                        <div class="d-flex justify-content-between">
                                            <span style='font-size:10px'>Previous Balance</span>
                                            <span style='font-size:10px'>{!! showAmount($item->loan_amount)!!}</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span style='font-size:10px; color:green;'>Amount Paid</span>
                                            <span style='font-size:10px; color:green;'>{!! showAmount($item->loan_amount - $item->balance_amount)!!}</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span style='font-size:10px; color:#f85359'>Remaining Balance</span>
                                            <span style='font-size:10px; color:#f85359'>{!!showAmount($item->balance_amount)!!}</span>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                    <i style='font-size:8px'>{{$item->updated_at}}</i>
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
                    <div class="row mx-0" >
                        <div class="row mx-0 d-flex justify-content-between mb-4 w-100" >
                            <h5 class="card-title mb-0" style="font-weight:700 ">LOAN APPLICATIONS</h5>
                            <i class="mdi mdi-pencil"></i>
                        </div>

                        @foreach($loanTransaction as $item)
                        <div class="col-md-12 px-0 d-flex flex-wrap w-100 gap_2 mb-3">
                            <div class="w-100 paper">
                                <div class="row mx-0 d-flex justify-content-between w-100 align-items-center">
                                    <h5 class="card-title mb-0 font-size-12" style="color:#808080; font-weight:500px">{{$item->loan_no}}</h5>
                                  
                                    <div><i class="mdi mdi-checkbox-marked-circle-outline" style="color:red;"></i>
                                        <!-- <span class="font-size-12"> Pending</span> -->
                                    </div>
                                </div>
</br>
                                <span class="paperbody font-size-12" style="color:#3366CC;text-transform:capitalize;"> 
                                <span class="mdi mdi-account"> &nbsp;{{$item->member->fname}}</span>
                                <div class="d-flex justify-content-between paperbody">
                                    <i class="font-size-12">{{$item->uptaded_at}}</i>
                                </div>
                                <div class="d-flex flex-column py-2 paperbody">
                                    <div class="d-flex justify-content-between">
                                        <span style="font-size:10px; color:#FF9900">Principal</span>
                                        <span style="font-size:10px; color:#FF9900"> {!! showAmount($item->principal_amount)!!}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span style="font-size:10px; color:#F85359">Loan Amount </span>
                                        <span style="font-size:10px; color:#F85359"> {!!showAmount($item->interest_amount)!!}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span style="font-size:10px; color:#337BD6">Loan Charges </span>
                                        <span style="font-size:10px; color:#337BD6"> {!! isset($loandata->fees_total) ? showAmount($loandata->fees_total) : 0 !!}</span>
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
                           <h6 class="text-muted mb-0">Interest Amount</h6>
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