@extends('member.partials.auth')
@section('title')
   {{ $page_title }}
@endsection
@section('content')

<div class="col-md-5 mx-auto">
   <div class="card">
      <div class="card-body">
         <div class="p-4">
         <div class="text-center mb-3">
            <img src="{{ asset('assets/uploads/generals/'. $gs->logo ) }}">
            </div>
            <p class="">Enter your member ID and password to access Member panel.</p>
         <form action="#" method="POST" id="login_form">
            @csrf
            <div class="form-group">
               <label for="member_no">Member ID</label>
               <input type="text" name="member_no" id="member_no" class="form-control">
               <span class="invalid-feedback"></span>
            </div>
            <div class="form-group">
               <label for="password">Password</label>
               <input type="password" name="password" id="password" class="form-control">
               <span class="invalid-feedback"></span>
            </div>
           <div class="mb-3">
               <button class="btn btn-lg btn-info btn-block" id="btn_login">Login</button>
            </div> 
         </form>
      </div>
      </div>
   </div>
</div>
                
@endsection

@section('scripts')
  <script>
      $("#login_form").submit(function(e) {
        e.preventDefault();
        $("#btn_login").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span>');
        $("#btn_login").prop("disabled", true);
        $.ajax({
          url:'{{ route('member.login.submit') }}',
          method: 'post',
          data: $(this).serialize(),
          dataType: 'json',
          success: function(response){
            if(response.status == 400){
              $.each(response.message, function (key, value) {
                showError(key, value);
              });
              $("#btn_login").html('Login');
              $("#btn_login").prop("disabled", false);
            } else if(response.status == 200){
              $("#login_form")[0].reset();
              removeErrors("#login_form");
              $("#btn_login").html('Login');
              setTimeout(function(){
                $("#btn_login").prop("disabled", false);
                window.location.href = response.url;
              }, 300);

            }
          }
        });
      });
  </script> 
@endsection