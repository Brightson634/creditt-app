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
      <div class="col-xl-11 mx-auto">
         <div class="card">
            <div class="card-body">
               <div class="clearfix mb-3">
                  <div class="float-left">
                     <h3 class="card-title">Investment Plan Information</h3>
                  </div>
                  <div class="float-right">
                     <a href="{{ route('webmaster.investmentplans') }}" class="btn btn-dark btn-sm btn-theme"> <i class="fa fa-eye"></i> View Plans</a>
                  </div>
               </div>
               <form action="#" method="POST" id="plan_form">
               @csrf
               <div class="row">
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="name" class="form-label">Plan Name</label>
                        <input type="text" name="name" id="name" class="form-control">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="min_amount" class="form-label">Minimum Amount</label>
                        <input type="text" name="min_amount" id="min_amount" class="form-control">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="max_amount" class="form-label">Maximum Amount</label>
                        <input type="text" name="max_amount" id="max_amount" class="form-control">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="interest_rate" class="form-label">Interest Rate</label>
                        <input type="text" name="interest_rate" id="interest_rate" class="form-control">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="duration" class="form-label">Duration Period</label>
                        <select class="form-control" name="duration" id="duration">
                           <option value="">select period</option>
                           <option value="day">Daily</option>
                           <option value="week">Weekly</option>
                           <option value="month">Monthly</option>
                           <option value="year">Yearly</option>
                        </select>
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
               </div>
               <div class="row mt-2">
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
        $("#btn_plan").prop("disabled", true);
        $.ajax({
          url:'{{ route('webmaster.investmentplan.store') }}',
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
