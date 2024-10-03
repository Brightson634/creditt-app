@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection
@section('content')
@section('css')
<style>
   .custom-card {
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.custom-table thead th {
    background-color: #f8f9fa;
}

.custom-table tbody tr {
    transition: background-color 0.3s ease;
}

.custom-table tbody tr:hover {
    background-color: #f1f1f1;
}

.card-body {
    padding: 1.5rem;
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
}

.btn-primary:hover {
    background-color: #0056b3;
    border-color: #004085;
}

</style>
@endsection
<div class="page-heading">
   {{-- <div class="page-heading__title">
      <h3>{{ $page_title }}</h3>
   </div> --}}
</div>

<div class="row">
   <div class="col-xl-12 mx-auto">
       <div class="card custom-card">
           <div class="card-body">
               <div class="d-flex justify-content-between mb-4">
                   <h3 class="card-title mb-0">{{ $page_title }}</h3>
                   <a href="{{ route('webmaster.fee.create') }}" class="btn btn-primary btn-sm"> 
                       <i class="fa fa-plus"></i> New Fee
                   </a>
               </div>

               @if($fees->count() > 0)
               <div class="table-responsive">
                   <table class="table table-sm table-bordered table-hover custom-table mb-0">
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
                               <td>{{ $row->account->name ?? 'none' }}</td>
                               <td>
                                   <a href="{{ route('webmaster.fee.edit', $row->id) }}" class="btn btn-dark btn-sm">
                                       <i class="far fa-edit"></i>
                                   </a>
                                   <form action="{{ route('webmaster.fee.destroy', $row->id) }}"
                                    method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-dark">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                               </td>
                           </tr>
                           @endforeach
                       </tbody>
                   </table>
               </div>
               @else
               <div class="d-flex flex-column align-items-center mt-5">
                   <img src="{{ asset('assets/uploads/defaults/nodata.png') }}" width="200" alt="No Data">
                   <span class="mt-3 text-muted">No Data Available</span>
               </div>
               @endif
           </div>
       </div>
   </div>
</div>

@endsection
