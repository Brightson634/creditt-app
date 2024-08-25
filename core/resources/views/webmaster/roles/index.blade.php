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
      <div class="col-xl-12">
         <div class="card">
            <div class="card-body">
               @if($roles->count() > 0)
               <div class="card card-dashboard-table-six">
                  <h6 class="card-title">{{ $page_title }}<div class="float-right">
                     <a href="{{ route('webmaster.role.create') }}" class="btn btn-dark btn-sm btn-theme"><i class="fa fa-plus"></i> Add Role</a>
                  </div></h6>
                  <div class="table-responsive">
                     <table class="table table-striped">
                        <thead>
                           <tr>
                              <th>#</th>
                              <th>Role Name</th>
                              <th>Role Description</th>
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
                              <a href="{{ route('webmaster.role.edit', $role->id) }}" class="btn btn-xs btn-dark updateRoleBtn"> <i class="far fa-edit"></i> Edit</a>
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

<div id="updateRole" class="modal">
   <div class="modal-dialog" role="document">
     <div class="modal-content modal-content-demo">
       <div class="modal-header">
         <h6 class="modal-title">Edit Role</h6>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
         </button>
       </div>
       <div class="modal-body" id='updateRoleContent'>
       
       <div class="modal-footer">
         <button type="button" class="btn btn-indigo">Save changes</button>
         <button type="button" data-dismiss="modal" class="btn btn-outline-light">Close</button>
       </div>
     </div>
   </div><!-- modal-dialog -->
</div>
@endsection
@section('scripts')
<script>
   $(document).ready(function () {
      $(document).on('click','.updateRoleBtn',function (event) {
         event.preventDefault();
         alert('Hi God')
         var url = $(this).attr('href');
         alert(url)
         $.ajax({
            type: "GET",
            url: url,
            success: function (response) {
               console.log(response)
               $('#updateRoleContent').html(response.html)
               $('#updateRole').modal('show');
               
            },
            error:function(jqxhr){
               console.log(jqxhr)
            }
         });
      });
   });
</script>
@endsection
