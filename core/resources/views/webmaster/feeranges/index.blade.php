@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection
@section('css')
<style>
   /* General Card Styling */
.card {
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  background-color: #f9f9f9;
  border: 1px solid #ddd;
  overflow: hidden;
  transition: box-shadow 0.3s ease, transform 0.3s ease;
}

.card:hover {
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
  transform: translateY(-2px); 
}

/* Card Body Styling */
.card-body {
  padding: 1.5rem; /* Adjust padding as needed */
}

/* Form Control Styling */
.form-control {
  border-radius: 4px;
  border: 1px solid #ced4da;
  background-color: #fff;
  box-shadow: none;
}

/* Form Label Styling */
.form-label {
  margin-bottom: .5rem;
  font-weight: bold;
}

/* Button Styling */
.btn-theme {
  background-color: #007bff;
  border-color: #007bff;
  color: #fff;
  border-radius: 4px;
  padding: 0.5rem 1rem;
  font-size: 0.875rem;
}

.btn-theme:hover {
  background-color: #0056b3;
  border-color: #004085;
}

/* Button Styling for Small Sizes */
.btn-sm {
  padding: 0.25rem 0.5rem;
  font-size: 0.75rem; 
  border-radius: 3px;
}

/* Spacing and Alignment */
.clearfix {
  margin-bottom: 1rem;
}

.mt-3 {
  margin-top: 1rem;
}

.invalid-feedback {
  display: block;
  color: #dc3545;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
  .card-body {
    padding: 1rem;
  }

  .btn-theme {
    padding: 0.5rem;
  }
}

</style>
@endsection
@section('content')
<div class="page-heading">
   {{-- <div class="page-heading__title">
      <h3>{{ $page_title }}</h3>
   </div> --}}
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
                     <a href="{{ route('webmaster.feerange.create') }}" class="btn btn-dark btn-sm btn-theme"> <i class="fa fa-plus"></i> Fee Range</a>
                  </div>
               </div>
               @if($feeranges->count() > 0)
               <div class="table-responsive">
                  <table class="table table-sm mb-0">
                     <thead>
                        <tr>
                           <th>#</th>
                           <th>Fee Name</th>
                           <th>Minimum Amount</th>
                           <th>Maximum Amount</th>
                           <th>Amount</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @php $i = 0; @endphp
                        @foreach($feeranges as $row)
                        @php $i++; @endphp
                        <tr>
                           <th scope="row">{{ $i }}</th>
                           <td>{{ $row->fee->name }}</td>
                           <td>{!! showAmount($row->min_amount) !!}</td>
                           <td>{!! showAmount($row->max_amount) !!}</td>
                           <td>{!! showAmount($row->amount) !!}</td>
                           <td>
                             <a href="#{{ route('webmaster.feerange.edit', $row->id) }}" class="btn btn-xs btn-dark"> <i class="far fa-edit"></i></a>
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
