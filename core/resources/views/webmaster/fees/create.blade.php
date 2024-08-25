@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection
@section('css')
<style>
   .custom-card {
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    background-color: #f9f9f9;
}

.custom-card .card-body {
    padding: 2rem;
}

.custom-card .form-group label {
    font-weight: bold;
}

.custom-card .btn-theme {
    background-color: #007bff;
    border-color: #007bff;
    border-radius: 5px;
}

.custom-card .btn-theme:hover {
    background-color: #0056b3;
    border-color: #004085;
}

.custom-card .table {
    border-collapse: separate;
    border-spacing: 0;
}

.custom-card .table thead th {
    background-color: #e9ecef;
    font-weight: bold;
}

.custom-card .table tbody tr {
    transition: background-color 0.2s ease;
}

.custom-card .table tbody tr:hover {
    background-color: #f1f1f1;
}

.invalid-feedback {
    color: #dc3545;
    font-size: 0.875rem;
}

</style>
@endsection
@section('content')
<div class="page-heading">
   {{-- <div class="page-heading__title">
      <h3>{{ $page_title }}</h3>
   </div> --}}
</div>

<div class="row">
   <div class="col-xl-11 mx-auto">
       <div class="card custom-card">
           <div class="card-body">
               <div class="d-flex justify-content-between mb-4">
                   <h3 class="card-title mb-0">Fee Information</h3>
                   <a href="{{ route('webmaster.fees') }}" class="btn btn-primary btn-sm">
                       <i class="fa fa-eye"></i> View Fee
                   </a>
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
                                   <option value="">Select Fee Type</option>
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
                                   <option value="">Select Rate Type</option>
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
                                   <option value="">Select Period</option>
                                   <option value="day">Daily</option>
                                   <option value="week">Weekly</option>
                                   <option value="month">Monthly</option>
                                   <option value="year">Yearly</option>
                                   <option value="other">Other</option>
                               </select>
                               <span class="invalid-feedback"></span>
                           </div>
                       </div>
                   </div>
                   <div class="row">
                       <div class="col-md-6">
                           <div class="form-group">
                               <label for="account_id" class="form-label">Account</label>
                               <select name="account_id" class="form-control accounts-dropdown" style="width: 100%;">
                                   <option></option>
                                   @foreach ($accounts_array as $account)
                                   <option value="{{ $account['id'] }}" data-currency="{{ $account['currency'] }}">
                                       {{ $account['name'] }} - {{ $account['primaryType'] }} - {{ $account['subType'] }}
                                   </option>
                                   @endforeach
                               </select>
                               <span class="invalid-feedback"></span>
                           </div>
                       </div>
                   </div>
                   <div class="form-group row mt-4">
                       <div class="col-sm-12">
                           <button type="submit" class="btn btn-primary btn-theme" id="btn_fee">Add Fee</button>
                       </div>
                   </div>
               </form>
           </div>
       </div>
   </div>
</div>

</div>
@endsection


@section('scripts')
<script type="text/javascript">
   "use strict";
   $('.account_id').select2({
    placeholder: "Select a Account",
    allowClear: true
   })
   
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
