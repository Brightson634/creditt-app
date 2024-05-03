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
      <div class="col-xl-12">
         <div class="card">
            <div class="card-body">
               <div class="clearfix mb-3">
                  <div class="float-left">
                     <h4 class="card-title">{{ $page_title }}</h4>
                  </div>
                  
                  <div class="float-right">
                     <a href="{{ route('webmaster.role.create') }}" class="btn btn-sm btn-theme"><i class="fa fa-plus"></i> Add Role</a>
                  </div>
                  
               </div>
               @if($roles->count() > 0)
               <div class="table-responsive">
                  <table class="table table-sm mb-0">
                     <thead>
                        <tr>
                           <th>#</th>
                           <th>Role Name</th>
                           <th>Role Description</th>
                           <th>Status</th>
                           <th>Action</th>
                           
                        </tr>
                     </thead>
                     <tbody>
                        @php $i = 0; @endphp
                        @foreach($roles as $role)
                        @php $i++; @endphp
                        <tr>
                           <th scope="row">{{ $i }}</th>
                           <td>{{ $role->name }}</td>
                           <td>{{ $role->description }}</td>
                           <td>
                            @if($role->status == 1)
                            <div class="badge badge-success">Active</div>
                            @else
                            <div class="badge badge-danger">Inactive</div>
                            @endif
                           </td>
                           <td>
                            <a href="{{ route('webmaster.role.edit', $role->id) }}" class="btn btn-xs btn-dark"> <i class="far fa-edit"></i> Edit</a>
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