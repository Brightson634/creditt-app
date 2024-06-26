@extends('member.partials.main')
@section('title')
    {{ $page_title }}
@endsection
@section('content')

<!-- , $accountdata,$loandata,$investmentdata -->



<div class="row">
   <div class="col-md-8 mx-auto">
      <div class="row">
         <div class="col-md-6 col-6">
            <div class="card">
               <div class="card-body">
                  <p class="card-title mb-0"><small>Available Amount</small></p>
                  <h2 class="align-items-center mb-0"><small>
                  {!! showAmount($accountdata->available_balance)!!}
               </small></h2>
               </div>
            </div>
         </div>
         <div class="col-md-6 col-6">
            <div class="card">
               <div class="card-body">
                  <p class="card-title mb-0"><small>Interest Amount</small></p>
                  <h2 class="align-items-center mb-0"><small>
                  {!! showAmount($investmentdata->interest_amount)!!}

                  </small></h2>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<div class="row">
   <div class="col-md-8 mx-auto">
      <div class="row">
         <div class="col-md-4 col-6">
            <div class="card bg-warning">
               <div class="card-body">
                  <p class="card-title mb-0 text-white"><small>Total Deposits</small></p>
                  <h2 class="align-items-center mb-0 text-white"><small>
                  {!! showAmount($savingdata->deposit_amount)!!}

                  </small></h2>
               </div>
            </div>
         </div>
         <div class="col-md-4 col-6">
            <div class="card bg-danger">
               <div class="card-body">
                  <p class="card-title mb-0 text-white"><small>Total Welfare</small></p>
                  <h2 class="align-items-center mb-0 text-white"><small>0.00</small></h2>
               </div>
            </div>
         </div>
         <div class="col-md-4 col-6">
            <div class="card bg-success">
               <div class="card-body">
                  <p class="card-title mb-0 text-white"><small>Saving Transactions</small></p>
                  <h2 class="align-items-center mb-0 text-white"><small>
                  {{ $savingdata->total_savings}}
                  </small></h2>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<div class="row">
   <div class="col-md-8 mx-auto">
      <div class="card">
         <div class="card-body">
            <div class="row">
               <div class="col-md-4 col-4">
                  <h6 class="text-muted mb-0"><small>Unsaved Welfare</small></h6>
                  <h4 class="text-success"><small>0.00</small></h4>
               </div>
               <div class="col-md-4 col-4">
                  <h6 class="text-muted mb-0"><small>Current Loan</small></h6>
                  <h4 class="text-danger"><small>
                  {!! showAmount($loandata->loan_amount)!!}

                  </small></h4>
               </div>
               <div class="col-md-4 col-4">
                  <h6 class="text-muted mb-0"><small>Loan Payments</small></h6>
                  <h4 class="text-danger"><small>
                  {!! showAmount($loandata->repaid_amount)!!}

                  </small></h4>
               </div>  
            </div>
         </div>
      </div>
   </div>
</div>



   <div class="row">
      <div class="col-md-8 mb-5 mx-auto">
         @if($transactions->count() > 0)
         <div class="section mt-4">
            <div class="section-heading">
                <h2 class="title">Transactions</h2>
                <a href="{{ route('member.transactions') }}" class="link">View All</a>
            </div>
            <div class="transactions mb-4">
               @foreach($transactions as $row)
               <a href="" class="item">
                  <div class="detail">
                     <div>
                        <strong>{{ $row->detail }}</strong>
                        <strong>{{ $row->member_id }}</strong>
                        <p>{{ showDateTime($row->created) }}</p>
                     </div>
                  </div>
                  <div class="right">
                      @if($row->status == 0)
                     <div class="price text-danger"> - {!! showAmount($row->amount) !!}</div>
                     @endif
                     @if($row->status == 1)
                     <div class="price text-success"> + {!! showAmount($row->amount) !!}</div>
                     @endif
                  </div>
               </a>
               @endforeach
            </div>
         </div>
         @else
            <div class="d-flex flex-column align-items-center mt-5">
               <img src="{{ asset('assets/uploads/defaults/nodata.png') }}" width="200">
               <span class="mt-3">No Transactions</span>
            </div>
         @endif
      </div>
   </div>
@endsection