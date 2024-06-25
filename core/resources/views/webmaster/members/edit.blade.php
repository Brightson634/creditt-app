@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection
@section('content')
<div class="page-heading ">
   {{-- <div class="page-heading__title">
      <h3>{{ $page_title }}</h3>
   </div> --}}
</div>
   <div class="row">
      <div class="col-xl-9 mx-auto">
         <div class="card">
            <div class="card-body">
               <div class="clearfix mb-3">
                  <div class="float-left">
                     <h3 class="card-title">Member Information</h3>
                  </div>
                  <div class="float-right">
                     <a href="{{ route('webmaster.members') }}" class="btn btn-dark btn-sm btn-theme"> <i class="fa fa-eye"></i> View Members</a>
                  </div>
               </div>
               <form action="#" method="POST" id="member_form">
               @csrf
               <input type="hidden" name="id" class="form-control" value="{{ $member->id }}">

               <div class="form-group row">
                  <label for="name" class="col-sm-3 col-form-label">Member Names:</label>
                  <div class="col-sm-9">
                     <input type="text" name="name" id="name" class="form-control"value="{{ $member->name }}">
                     <span class="invalid-feedback"></span>
                  </div>
               </div>
               <div class="form-group row">
                  <label for="email" class="col-sm-3 col-form-label">Member Email:</label>
                  <div class="col-sm-9">
                     <input type="email" name="email" id="email" class="form-control" value="{{ $member->email }}">
                     <span class="invalid-feedback"></span>
                  </div>
               </div>
               <div class="form-group row">
                  <label for="telephone" class="col-sm-3 col-form-label">Member Telephones</label>
                  <div class="col-sm-9">
                     <input type="text" name="telephone" id="telephone" class="form-control" value="{{ $member->telephone }}">
                     <span class="invalid-feedback"></span>
                  </div>
               </div>
               <div class="form-group row">
                  <label for="address" class="col-sm-3 col-form-label">Member Address</label>
                  <div class="col-sm-9">
                     <input type="text" name="address" id="address" class="form-control" value="{{ $member->address }}">
                     <span class="invalid-feedback"></span>
                  </div>
               </div>

               <div class="form-group row mt-4">
                  <label class="col-sm-3 col-form-label"></label>
                  <div class="col-sm-9">
                     <button type="submit" class="btn btn-primary btn-theme" id="btn_member">Update Member</button>
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

   $("#member_form").submit(function(e) {
        e.preventDefault();
        $("#btn_member").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Updating');
        $("#btn_member").prop("disabled", true);
        $.ajax({
          url:'{{ route('webmaster.member.update') }}',
          method: 'post',
          data: $(this).serialize(),
          dataType: 'json',
          success: function(response){
            if(response.status == 400){
              $.each(response.message, function (key, value) {
                showError(key, value);
              });
              $("#btn_member").html('Update Member');
              $("#btn_member").prop("disabled", false);
            } else if(response.status == 200){
              removeErrors("#member_form");
              $("#btn_member").html('Update Member');
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
