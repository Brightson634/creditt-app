@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
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
               @if($assets->count() > 0)
               <div class="card card-dashboard-table-six">
                  <h6 class="card-title">{{ $page_title }}<div class="float-right">
                     <a href="{{ route('webmaster.asset.create') }}" class="btn btn-dark btn-sm btn-theme"> <i class="fa fa-plus"></i> New Asset</a>
                  </div></h6>
               <div class="table-responsive">
                  <table class="table table-striped">
                     <thead>
                        <tr>
                           <th>#</th>
                           <th>Asset No</th>
                           <th>Name</th>
                           <th>Serial No.</th>
                           <th>Cost Price</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @php $i = 0; @endphp
                        @foreach($assets as $row)
                        @php $i++; @endphp
                        <tr>
                           <th scope="row">{{ $i }}</th>
                           <td>{{ $row->asset_no }}</td>
                           <td>{{ $row->name }}</td>
                           <td>{{ $row->serial_no }}</td>
                           <td>{!! showAmount($row->cost_price) !!}</td>
                           <td>
                             <a href="#{{ route('webmaster.asset.edit', $row->asset_no) }}" class="btn btn-xs btn-dark"> <i class="far fa-edit"></i></a>
                           </td>
                        <tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
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
