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
                     <h4 class="mb-2">Profile Information</h4>
                     <form action="#" method="POST" id="profile_form"> 
                        @csrf
                        <div class="form-row">
                           <div class="col-md-6 mb-3">
                              <label for="name">Names</label>
                              <input type="text" name="name" id="name" class="form-control" value="{{ member()->name }}">
                              <span class="invalid-feedback"></span>
                           </div>
                           <div class="col-md-6 mb-3">
                              <label for="email">Email</label>
                              <input type="email" name="email" id="email" class="form-control" value="{{ member()->email }}">
                              <span class="invalid-feedback"></span>
                           </div>
                        </div>
                        <div class="form-row">
                           <div class="col-md-6 mb-3">
                              <label for="telephone">Telephone</label>
                                 <input type="text" name="telephone" id="telephone" class="form-control" value="{{ member()->telephone }}">
                              <span class="invalid-feedback"></span>
                           </div>
                           <div class="col-md-6 mb-3">
                              <label for="address">Current Address</label>
                              <input type="text" name="address" id="address" class="form-control" value="{{ member()->address }}">
                              <span class="invalid-feedback"></span>
                           </div>
                        </div>
                        
                        <div class="form-group mt-4">
                           <button type="submit" class="btn btn-block btn-info" id="btn_profile">Update Information</button>
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


      $("#profile_form").submit(function(e) {
        e.preventDefault();
        $("#btn_profile").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Updating');
        $("#btn_profile").prop("disabled", true);
        $.ajax({
          url:'{{ route('member.profile.update') }}',
          method: 'post',
          data: $(this).serialize(),
          dataType: 'json',
          success: function(response){
            if(response.status == 400){
              $.each(response.message, function (key, value) {
                showError(key, value);
              });
              $("#btn_profile").html('Update Information');
              $("#btn_profile").prop("disabled", false);
            } else if(response.status == 200){
              removeErrors("#profile_form");
              $("#btn_profile").html('Update Information');
              $("#btn_profile").prop("disabled", false);
              setTimeout(function(){
                window.location.reload();
              }, 1000);

            }
          }
        });
      });
</script>
@endsection