@extends('member.partials.main')
@section('title')
    {{ $page_title }}
@endsection
@section('content')
<div class="row">
   <div class="col-md-8 mx-auto">
      <div class="page-heading">
         <div class="page-heading__title">      
            <h3>
               <a href="javascript:void(0);" onclick="goBack()" class="btn btn-sm btn-dark mr-2"> <i class="fa fas fa-reply"></i> Back</a> 
                {{ $page_title }}
            </h3>
         </div>
      </div>
   </div>
</div>


   <div class="row">
      <div class="col-md-8 mx-auto">
         <div class="row">
            <div class="col-md-11 mx-auto">
               <div class="card">
                  <div class="card-body">
                     <h4 class="mb-3">Change Password</h4>
                     <form action="#" method="POST" id="password_form"> 
                        @csrf
                        <div class="form-group row">
                           <label for="old_password" class="col-sm-3 col-form-label">Old Password</label>
                           <div class="col-sm-9">
                              <input type="password" name="old_password" id="old_password" class="form-control">
                              <span class="invalid-feedback"></span>
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="new_password" class="col-sm-3 col-form-label">New Password</label>
                           <div class="col-sm-9">
                              <input type="password" name="new_password" id="new_password" class="form-control">
                              <span class="invalid-feedback"></span>
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="confirm_password" class="col-sm-3 col-form-label">Confirm Password</label>
                           <div class="col-sm-9">
                              <input type="password" name="confirm_password" id="confirm_password" class="form-control">
                              <span class="invalid-feedback"></span>
                           </div>
                        </div>
                        <div class="form-group row mt-4">
                           <label class="col-sm-3 col-form-label"></label>
                           <div class="col-sm-9">
                              <button type="submit" class="btn btn-block btn-info" id="btn_password">Update Password</button>
                           </div>
                        </div>
                        </form>
                     </div>
                  </div>
               </div>            
            </div>
         </div>
      </div>
@endsection

@section('scripts')
<script type="text/javascript">
   $("#password_form").submit(function(e) {
      e.preventDefault();
      $("#btn_password").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Updating');
      $("#btn_password").prop("disabled", true);
      $.ajax({
         url:'{{ route('member.password.update') }}',
         method: 'post',
         data: $(this).serialize(),
         dataType: 'json',
         success: function(response){
            if(response.status == 400){
               $.each(response.message, function (key, value) {
                  showError(key, value);
               });
               $("#btn_password").html('Update Password');
               $("#btn_password").prop("disabled", false);
            } else if(response.status == 200){
               $("#password_form")[0].reset();
               removeErrors("#password_form");
               $("#btn_password").html('Update Password');
               $("#btn_password").prop("disabled", false);
               setTimeout(function(){
                  window.location.href = response.url;
               }, 1000);
            }
         }
      });
   });
</script>
@endsection

