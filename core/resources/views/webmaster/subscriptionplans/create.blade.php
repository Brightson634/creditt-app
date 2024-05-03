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
      <div class="col-xl-9 mx-auto">
         <div class="card">
            <div class="card-body">
               <div class="clearfix mb-3">
                  <div class="float-left">
                     <h3 class="card-title">Subscription Plan Information</h3>
                  </div>
                  <div class="float-right">
                     <a href="{{ route('webmaster.subscriptionplans') }}" class="btn btn-sm btn-theme"> <i class="fa fa-eye"></i> View plans</a>
                  </div>
               </div>
               <form action="#" method="POST" id="plan_form"> 
               @csrf
               <div class="form-group">
                                            <label for="name">Plan Name</label>
                                            <input type="text" name="name" id="name" class="form-control">
                                            <span class="invalid-feedback"></span>
                                        </div>

                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea name="description" class="form-control" id="description" rows="3"></textarea>
                                            <span class="invalid-feedback"></span>
                                        </div>
               <div class="form-group row mt-4">
                  <div class="col-sm-9">
                     <button type="submit" class="btn btn-theme" id="btn_plan">Add Plan</button>
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

   $("#plan_form").submit(function(e) {
        e.preventDefault();
        $("#btn_plan").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding');
        $("#btn_v").prop("disabled", true);
        $.ajax({
          url:'{{ route('webmaster.subscriptionplan.store') }}',
          method: 'post',
          data: $(this).serialize(),
          dataType: 'json',
          success: function(response){
            if(response.status == 400){
              $.each(response.message, function (key, value) {
                showError(key, value);
              });
              $("#btn_plan").html('Add Plan');
              $("#btn_plan").prop("disabled", false);
            } else if(response.status == 200){
               $("#plan_form")[0].reset();
              removeErrors("#plan_form");
              $("#btn_plan").html('Add Plan');
              $("#btn_plan").prop("disabled", false);
              setTimeout(function(){
                window.location.href = response.url;
              }, 1000);

            }
          }
        });
      });
</script>
@endsection