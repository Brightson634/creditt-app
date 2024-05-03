@extends('member.partials.main')
@section('title')
    {{ $page_title }}
@endsection

@section('content')
<div class="row">
   <div class="col-md-8 mx-auto">
      <div class="page-heading">
         <div class="page-heading__title">      
            <h3>
               <a href="javascript:void(0);" onclick="goBack()" class="btn btn-sm btn-info mr-2"> <i class="fa fas fa-reply"></i> Back</a> 
                {{ $page_title }}
            </h3>
         </div>
      </div>
   </div>
</div>

   @if($mysavings->count() > 0)
   <div class="row">
      <div class="col-md-8 mx-auto">
         @foreach($mysavings as $row)
         <div class="card">
            <div class="card-header bg-success">
               <h5 class="text-white">4343</h5>
            </div>
            <div class="card-body">
               <h5 class="mb-1">Deposits Amount: <span class="float-right">{!! showAmount($row->deposit_amount) !!}</span></h5>
               <h5 class="mb-1">Welfare Amount: <span class="float-right">{!! showAmount($row->previous_balance) !!}</span></h5>
               <h5 class="mb-1">Savings Amount: <span class="float-right">{!! showAmount($row->available_balance) !!}</span></h5>
               <h5>Status: <span class="float-right text-success">Approved</span></h5>
            </div>
         </div>
         @endforeach
      </div>
   </div>
   @else
      <div class="d-flex flex-column align-items-center mt-5">
         <img src="{{ asset('assets/uploads/defaults/nodata.png') }}" width="200">
         <span class="mt-3">No Data</span>
      </div>
   @endif
@endsection
