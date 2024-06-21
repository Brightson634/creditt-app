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
               <a href="javascript:void(0);" onclick="goBack()" class="btn btn-sm btn-info mr-2"> <i class="fa fa-reply"></i> Back</a> 
                {{ $page_title }}
            </h3>
         </div>
      </div>
   </div>
</div>

   @if($loans->count() > 0)
   <div class="row">
      <div class="col-md-8 mx-auto">
         @foreach($loans as $row)
         <div class="card">
            <div class="card-header @if($row->status == 0) bg-warning @endif">
               <h5 class="text-black">{{ fullDate($row->request_date) }}</h5>
            </div>
            <div class="card-body">
               <h5 class="mb-1">Request Amount: <span class="float-right">{!! showAmount($row->principal_amount) !!}</span></h5>
               <h5 class="mb-1">Loan Type: <span class="float-right">Individual Loan</h5>
               @if($row->status == 0)
               <h5>Status: <span class="float-right text-warning">Pending</span></h5>
               @endif
            </div>
         </div>
         @endforeach
      </div>
   </div>
   @else
      <div class="d-flex flex-column align-items-center mt-5">
         <img src="{{ asset('assets/uploads/defaults/nodata.png') }}" width="200">
         <span class="mt-3">No Loan Transactions</span>
      </div>
   @endif
@endsection