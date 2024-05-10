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
                     <a href="{{ route('webmaster.fee.create') }}" class="btn btn-sm btn-theme"> <i class="fa fa-plus"></i> New Fee</a>
                  </div>
               </div>
               @if($fees->count() > 0)
               <div class="table-responsive">
                  <table class="table table-sm mb-0">
                     <thead>
                        <tr>
                           <th>#</th>
                           <th>Fee Name</th>
                           <th>Fee Type</th>
                           <th>Rate Type</th>
                           <th>Amount</th>
                           <th>Rate</th>
                           <th>Period</th>
                           <th>Ledger Account</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @php $i = 0; @endphp
                        @foreach($fees as $row)
                        @php $i++; @endphp
                        <tr>
                           <th scope="row">{{ $i }}</th>
                           <td>{{ $row->name }}</td>
                           <td>{{ $row->type }}</td>
                           <td>
                              @if($row->rate_type == 'percent') Percentage @endif
                              @if($row->rate_type == 'fixed') Fixed Amount @endif
                              @if($row->rate_type == 'range') Range @endif
                           </td>
                           <td>
                              @if($row->rate_type == 'percent') - @endif
                              @if($row->rate_type == 'fixed') {!! showAmount($row->amount) !!} @endif
                              @if($row->rate_type == 'range') - @endif
                           </td>
                           <td>
                              @if($row->rate_type == 'percent') {{ $row->rate }} @endif
                              @if($row->rate_type == 'fixed') - @endif
                              @if($row->rate_type == 'range') - @endif
                           </td>
                           <td>
                              @if($row->period == 'day') DAILY @endif
                              @if($row->period == 'week') WEEKLY @endif
                              @if($row->period == 'month') MONTHLY @endif
                              @if($row->period == 'year') YEARLY @endif
                           </td>
                           <td>{{ $row->account->name }}</td>
                           <td> 
                             <a href="#{{ route('webmaster.fee.edit', $row->id) }}" class="btn btn-xs btn-dark"> <i class="far fa-edit"></i></a>
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