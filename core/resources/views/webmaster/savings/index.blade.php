@extends('webmaster.partials.main')
@section('title')
    {{ $page_title }}
@endsection
@section('content')
<div class="page-heading">
   <div class="page-heading__title">
      <h3>{{ $page_title }}</h3>
   </div>
</div>

   <div class="row">
      <div class="col-xl-12 mx-auto">
         <div class="card">
            <div class="card-body">
               <div class="clearfix mb-3">
                  <div class="float-left">
                     <h3 class="card-title">{{ $page_title }}</h3>
                  </div>
                  <div class="float-right">
                     <a href="{{ route('webmaster.saving.create') }}" class="btn btn-sm btn-theme"> <i class="fa fa-plus"></i> Add Savings</a>
                     <a href="{{ route('webmaster.saving.pdf') }}" target="_blank" class="btn btn-sm btn-secondary"> <i class="fa fa-print"></i> print PDF</a>
                  </div>
               </div>
               @if($savings->count() > 0)
               <div class="table-responsive">
                  <table class="table table-sm mb-0">
                     <thead>
                        <tr>
                           <th>#</th>
                           <th>Member</th>
                           <th>Deposited Amount</th>
                           <th>Account</th>
                           <th>Available Balance</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @php $i = 0; @endphp
                        @foreach($savings as $row)
                        @php $i++; @endphp
                        <tr>
                           <th scope="row">{{ $i }}</th>
                           <td>{{ $row->member->fname }} {{ $row->member->lname }}</td>
                           <td>{!! showAmount($row->deposit_amount) !!}</td>
                           <td>{{ $row->account->account_no }}</td>
                           <td>{!! showAmount($row->current_balance) !!}</td>
                           <td> 
                             <a href="#{{ route('webmaster.buyshare.edit', $row->id) }}" class="btn btn-xs btn-dark"> <i class="far fa-edit"></i></a>
                           </td>
                        <tr>
                        @endforeach
                     </tbody>
                  </table>
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
@endsection