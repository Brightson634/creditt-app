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
                     <h3 class="card-title">Member Information</h3>
                  </div>
                  <div class="float-right">
                     <a href="{{ route('webmaster.members') }}" class="btn btn-sm btn-theme"> <i class="fa fa-eye"></i> View Members</a>
                  </div>
               </div>
               <form action="#" method="POST" id="member_form">
               @csrf
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="member_no" class="form-label">Member No</label>
                        <input type="text" name="member_no" id="member_no" class="form-control" value="{{ $member_no }}" readonly>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="member_type" class="form-label">Individual / Group </label>
                        <select class="form-control" name="member_type" id="member_type">
                           <option value="">select member type</option>
                           <option value="individual">Individual Member</option>
                           <option value="group">Group Member</option>
                        </select>
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
               </div>
               <div id="individualDiv">
                  <div class="row">
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
                           <label for="fname" class="form-label">First Name:</label>
                           <input type="text" name="fname" id="fname" class="form-control">
                           <span class="invalid-feedback"></span>
                        </div>
                     </div>
                     <div class="col-md-3">
                       <div class="form-group">
                           <label for="lname" class="form-label">Last Name</label>
                           <input type="text" name="lname" id="lname" class="form-control">
                           <span class="invalid-feedback"></span>
                       </div>
                     </div>
                     <div class="col-md-3">
                       <div class="form-group">
                           <label for="oname" class="form-label">Other Name</label>
                           <input type="text" name="oname" id="oname" class="form-control">
                           <span class="invalid-feedback"></span>
                       </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-3">
                        <div class="form-group">
                           <label for="gender" class="form-label">Gender</label>
                           <select class="form-control" name="gender" id="gender">
                              <option value="">select gender</option>
                              <option value="Male">Male</option>
                              <option value="Female">Female</option>
                              <option value="Other">Others</option>
                           </select>
                           <span class="invalid-feedback"></span>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group">
                           <label for="marital_status" class="form-label">Marital Status</label>
                           <select class="form-control" name="marital_status" id="marital_status">
                              <option value="">select status</option>
                              <option value="NA">N/A</option>
                              <option value="Single">Single</option>
                              <option value="Married">Married</option>
                           </select>
                           <span class="invalid-feedback"></span>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group">
                           <label for="dob" class="form-label">Date of Birth</label>
                           <input type="text" name="dob" class="form-control" data-provide="datepicker" data-date-autoclose="true" data-date-format="yyyy-mm-dd" id="dob" autocomplete="off">
                           <span class="invalid-feedback"></span>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <label for="disability" class="form-label">Disability</label>
                        <div class="form-group">
                           <div class="custom-control custom-radio custom-control-inline">
                              <input type="radio" id="dno" name="disability" class="custom-control-input" value="No" checked>
                              <label class="custom-control-label" for="dno">NO</label>
                           </div>
                           <div class="custom-control custom-radio custom-control-inline">
                              <input type="radio" id="dyes" name="disability" class="custom-control-input" value="Yes">
                              <label class="custom-control-label" for="dyes">YES</label>
                           </div>
                        </div>
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
               </div>
               <div id="groupDiv" style="display: none;">
                  <div class="row">
                     <div class="col-md-6">
                       <div class="form-group">
                           <label for="group_name" class="form-label">Group Name</label>
                           <input type="text" name="group_name" id="group_name" class="form-control">
                           <span class="invalid-feedback"></span>
                       </div>
                     </div>
                     <div class="col-md-6">
                       <div class="form-group">
                           <label for="description" class="form-label">Description</label>
                           <input type="text" name="description" id="description" class="form-control">
                           <span class="invalid-feedback"></span>
                       </div>
                     </div>
                  </div>
               </div>

               <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="telephone" class="form-label">Telephone</label>
                        <input type="text" name="telephone" id="telephone" class="form-control">
                        <span class="invalid-feedback"></span>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control">
                        <span class="invalid-feedback"></span>
                    </div>
                  </div>
               </div>

               <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="password" class="form-label">Member Password</label>
                        <input type="password" name="password" id="password" class="form-control" value="12345678" readonly>
                        <small class="form-text text-muted">The default password is <strong>12345678</strong></small>
                    </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="subscriptionplan_id" class="form-label">Subscription Plan</label>
                        <select class="form-control" name="subscriptionplan_id" id="subscriptionplan_id">
                           <option value="">select branch</option>
                           @foreach($branches as $data)
                           <option value="{{ $data->id }}">{{ $data->name }}</option>
                           @endforeach
                        </select>
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
               </div>

               <div class="row mt-2">
                  <div class="col-sm-9">
                     <button type="submit" class="btn btn-theme" id="btn_member">Add Member</button>
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
   "use strict";

   $('#member_type').change(function() {
      let member_type = $(this).val();
      if (member_type == 'individual') {
         $('#individualDiv').show();
         $('#groupDiv').hide();
      } else if (member_type == 'group') {
         $('#individualDiv').hide();
         $('#groupDiv').show();
      } else {
         $('#individualDiv').show();
         $('#groupDiv').hide();
      }
   });

   $("#member_form").submit(function(e) {
        e.preventDefault();
        $("#btn_member").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding');
        $("#btn_member").prop("disabled", true);
        $.ajax({
          url:'{{ route('webmaster.member.store') }}',
          method: 'post',
          data: $(this).serialize(),
          dataType: 'json',
          success: function(response){
            if(response.status == 400){
              $.each(response.message, function (key, value) {
                showError(key, value);
              });
              $("#btn_member").html('Add Member');
              $("#btn_member").prop("disabled", false);
            } else if(response.status == 200){
               $("#member_form")[0].reset();
              removeErrors("#member_form");
              $("#btn_member").html('Add Member');
              $("#btn_member").prop("disabled", false);
              setTimeout(function(){
                window.location.href = response.url;
              }, 1000);

            }
          }
        });
      });
</script>
@endsection
