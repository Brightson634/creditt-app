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
               @if($staffs->count() > 0)
               <div class="card card-dashboard-table-six">
                  <h6 class="card-title">{{ $page_title }}<div class="float-right">
                     <a href="{{ route('webmaster.staff.create') }}" class="btn btn-dark btn-sm btn-theme"> <i class="fa fa-plus"></i> New Staff</a>
                  </div></h6>
                  <div class="table-responsive">
                     <table class="table table-striped">
                        <thead>
                           <tr>
                              <th>#</th>
                              <th>Code</th>
                              <th>Name</th>
                              <th>Position</th>
                              <th>Branch</th>
                              <th>Telephone</th>
                              <th>Email</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           @php $i = 0; @endphp
                           @foreach($staffs as $row)
                           @php $i++; @endphp
                           <tr>
                              <th scope="row">{{ $i }}</th>
                              <td><a href="{{ route('webmaster.staff.dashboard', $row->staff_no) }}">{{ $row->staff_no }}</a></td>
                              <td>{{ $row->fname }} - {{ $row->lname }}</td>
                              <td>{{ $row->branchposition->name }}</td>
                              <td>{{ $row->branch->name }}</td>
                              <td>{{ $row->telephone }}</td>
                              <td>{{ $row->email }}</td>
                              <td>
                              <a href="#{{ route('webmaster.staff.edit', $row->staff_no) }}" class="btn btn-xs btn-dark"> <i class="far fa-edit"></i></a>
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
