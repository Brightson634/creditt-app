@extends('webmaster.partials.dashboard.main')
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
      <div class="col-xl-11 mx-auto">
         <div class="card">
            <div class="card-body">
               <div class="clearfix mb-3">
                  <div class="float-left">
                     <h3 class="card-title">Staff Information</h3>
                  </div>
                  <div class="float-right">
                     <a href="{{ route('webmaster.staffs') }}" class="btn btn-sm btn-theme"> <i class="fa fa-eye"></i> View Staffs</a>
                  </div>
               </div>
               <form action="#" method="POST" id="staff_form">
               @csrf
               <div class="row">
                  <div class="col-md-2">
                     <div class="form-group">
                        <label for="staff_no" class="form-label">Staff No</label>
                        <input type="text" name="staff_no" id="staff_no" class="form-control" value="{{ $staff_no }}" readonly>
                     </div>
                  </div>
                  <div class="col-md-2">
                     <div class="form-group">
                        <label for="title" class="form-label">Title</label>
                        <select class="form-control" name="title" id="title">
                        	<option value="">select title</option>
                           <option value="Mr">Mr</option>
                           <option value="Mrs">Mrs</option>
                           <option value="Hon">Hon</option>
                        </select>
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="fname" class="form-label">First Name</label>
                        <input type="text" name="fname" id="fname" class="form-control" autocomplete="off">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="lname" class="form-label">Last Name</label>
                        <input type="text" name="lname" id="lname" class="form-control" autocomplete="off">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="telephone" class="form-label">Telephone</label>
                        <input type="text" name="telephone" id="telephone" class="form-control" autocomplete="off">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                         <input type="email" name="email" id="email" class="form-control" autocomplete="off">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" autocomplete="off">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>

               </div>

               <div class="row">
                  <div class="col-md-4">
                     <div class="form-group">
                     	<label for="branch_id" class="form-label">Branch Name</label>
                        <select class="form-control" name="branch_id" id="branch_id">
                           <option value="">select branch</option>
                           @foreach($branches as $data)
                           <option value="{{ $data->id }}">{{ $data->name }}</option>
                           @endforeach
                        </select>
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="branchposition_id" class="form-label">Designation</label>
                        <select class="form-control" name="branchposition_id" id="branchposition_id">
                           <option value="">select branch position</option>
                           @foreach($positions as $data)
                           <option value="{{ $data->id }}">{{ $data->name }}</option>
                           @endforeach
                        </select>
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>

               </div>

               <div class="row mt-2">
                  <div class="col-sm-9">
                     <button type="submit" class="btn btn-theme" id="btn_staff">Add Staff</button>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>


@endsection


@section('scripts')
<script type="text/javascript">

   $("#staff_form").submit(function(e) {
        e.preventDefault();
        $("#btn_staff").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding');
        $("#btn_staff").prop("disabled", true);
        $.ajax({
          url:'{{ route('webmaster.staff.store') }}',
          method: 'post',
          data: $(this).serialize(),
          dataType: 'json',
          success: function(response){
            if(response.status == 400){
              $.each(response.message, function (key, value) {
                showError(key, value);
              });
              $("#btn_staff").html('Add Staff');
              $("#btn_staff").prop("disabled", false);
            } else if(response.status == 200){
               $("#staff_form")[0].reset();
              removeErrors("#staff_form");
              $("#btn_staff").html('Add Staff');
              $("#btn_staff").prop("disabled", false);
              setTimeout(function(){
                window.location.href = response.url;
              }, 1000);

            }
          }
        });
      });
</script>
@endsection
