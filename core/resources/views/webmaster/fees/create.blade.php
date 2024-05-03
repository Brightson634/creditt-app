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
      <div class="col-xl-11 mx-auto">
         <div class="card">
            <div class="card-body">
               <div class="clearfix mb-3">
                  <div class="float-left">
                     <h3 class="card-title">Fee Information</h3>
                  </div>
                  <div class="float-right">
                     <a href="{{ route('webmaster.fees') }}" class="btn btn-sm btn-theme"> <i class="fa fa-eye"></i> View Fee</a>
                  </div>
               </div>
               <form action="#" method="POST" id="fee_form"> 
               @csrf
               <div class="row">
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="name" class="form-label">Fee Name</label>
                        <input type="text" name="name" id="name" class="form-control">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="type" class="form-label">Fee Type</label>
                        <select class="form-control" name="type" id="type">
                           <option value="">select fee type</option>
                           <option value="Mandatory">Mandatory</option>
                           <option value="Optional">Optional</option>
                           <option value="Adjustable">Adjustable</option>
                        </select>
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="rate_type" class="form-label">Rate Type</label>
                        <select class="form-control" name="rate_type" id="rate_type">
                           <option value="">select rate type</option>
                           <option value="fixed">Fixed Amount</option>
                           <option value="percent">Percentage</option>
                           <option value="range">Range</option>
                        </select>
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
               </div>
                <div class="row">
                     <div class="col-md-4 amountDiv" style="display: none;">
                        <div class="form-group">
                           <label for="amount" class="form-label">Amount</label>
                           <input type="text" name="amount" id="amount" class="form-control">
                           <span class="invalid-feedback"></span>
                        </div>
                     </div>
                     <div class="col-md-4 rateDiv" style="display: none;">
                        <div class="form-group">
                           <label for="rate" class="form-label">Rate</label>
                           <input type="text" name="rate" id="rate" class="form-control">
                           <span class="invalid-feedback"></span>
                        </div>
                     </div>

                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="period" class="form-label">Fee Period</label>
                        <select class="form-control" name="period" id="period">
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
               
               <div class="form-group row mt-4">
                  <div class="col-sm-9">
                     <button type="submit" class="btn btn-theme" id="btn_fee">Add Fee</button>
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

   $('#rate_type').change(function() {
      let rate_type = $(this).val();
      if (rate_type == 'percent') {
         $('.rateDiv').show();
         $('.amountDiv').hide();
      } else if (rate_type == 'fixed') {
         $('.rateDiv').hide();
         $('.amountDiv').show();
      } else if (rate_type == 'range') {
         $('.rateDiv').hide();
         $('.amountDiv').hide();
      } else {
         $('.rateDiv').hide();
         $('.amountDiv').hide();
      } 
   });

   $("#fee_form").submit(function(e) {
        e.preventDefault();
        $("#btn_fee").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding');
        $("#btn_fee").prop("disabled", true);
        $.ajax({
          url:'{{ route('webmaster.fee.store') }}',
          method: 'post',
          data: $(this).serialize(),
          dataType: 'json',
          success: function(response){
            if(response.status == 400){
              $.each(response.message, function (key, value) {
                showError(key, value);
              });
              $("#btn_fee").html('Add Fee');
              $("#btn_fee").prop("disabled", false);
            } else if(response.status == 200){
               $("#fee_form")[0].reset();
              removeErrors("#fee_form");
              $("#btn_fee").html('Add Fee');
              $("#btn_fee").prop("disabled", false);
              setTimeout(function(){
                window.location.href = response.url;
              }, 1000);

            }
          }
        });
      });
</script>
@endsection