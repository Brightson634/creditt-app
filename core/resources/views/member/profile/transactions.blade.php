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
               <a href="javascript:void(0);" onclick="goBack()" class="btn btn-sm btn-dark mr-2"> <i class="fa fas fa-reply"></i> Back</a> 
                {{ $page_title }}
            </h3>
         </div>
      </div>
   </div>
</div>


   <div class="row mb-4">
      <div class="col-md-8 mx-auto">
         @if($transactions->count() > 0)
         <div class="section mt-4">
            <div class="transactions mb-4">
               @foreach($transactions as $row)
               <a href="" class="item">
                  <div class="detail">
                     <div>
                        <strong>{{ $row->detail }}</strong>
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
               <span class="mt-3">No Referals</span>
            </div>
         @endif
      </div>
   </div>
@endsection
