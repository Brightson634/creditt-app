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
                   <h3 class="card-title mb-0">Edit Fee Information</h3>
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
                               <input type="text" value='{{$fee->name}}' name="name" id="name" class="form-control">
                               <span class="invalid-feedback"></span>
                           </div>
                       </div>
                       <input type='hidden' name='id' value='{{$fee->id}}'>
                       <div class="col-md-4">
                           <div class="form-group">
                               <label for="type" class="form-label">Fee Type</label>
                               <select class="form-control" name="type" id="type">
                                   <option value="">Select Fee Type</option>
                                   <option value="Mandatory" @if($fee->type =='Mandatory') selected @endif>Mandatory</option>
                                   <option value="Optional"  @if($fee->type =='Optional') selected @endif>Optional</option>
                                   <option value="Adjustable" @if($fee->type =='Adjustable') selected @endif>Adjustable</option>
                               </select>
                               <span class="invalid-feedback"></span>
                           </div>
                       </div>
                       <div class="col-md-4">
                           <div class="form-group">
                               <label for="rate_type" class="form-label">Rate Type</label>
                               <select class="form-control" name="rate_type" id="rate_type">
                                   <option value="">Select Rate Type</option>
                                   <option value="fixed" @if($fee->rate_type =='fixed') selected @endif>Fixed Amount</option>
                                   <option value="percent" @if($fee->rate_type =='percent') selected @endif>Percentage</option>
                                   <option value="range" @if($fee->rate_type =='range') selected @endif>Range</option>
                               </select>
                               <span class="invalid-feedback"></span>
                           </div>
                       </div>
                   </div>
                   <div class="row">
                       <div class="col-md-4 amountDiv" style="display: none;">
                           <div class="form-group">
                               <label for="amount" class="form-label">Amount</label>
                               <input type="text" value="{{$fee->amount}}" name="amount" id="amount" class="form-control">
                               <span class="invalid-feedback"></span>
                           </div>
                       </div>
                       <div class="col-md-4 rateDiv" style="display: none;">
                           <div class="form-group">
                               <label for="rate" class="form-label">Rate</label>
                               <input type="text" value="{{$fee->rate}}" name="rate" id="rate" class="form-control">
                               <span class="invalid-feedback"></span>
                           </div>
                       </div>
                       <div class="col-md-4">
                           <div class="form-group">
                               <label for="period" class="form-label">Fee Period</label>
                               <select class="form-control" name="period" id="period">
                                   <option value="">Select Period</option>
                                   <option value="day" @if($fee->period =='day') selected @endif>Daily</option>
                                   <option value="week" @if($fee->period =='week') selected @endif>Weekly</option>
                                   <option value="month" @if($fee->period =='month') selected @endif>Monthly</option>
                                   <option value="year" @if($fee->period =='year') selected @endif>Yearly</option>
                                   <option value="other" @if($fee->period =='other') selected @endif>Other</option>
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
                                   <option value="{{ $account['id'] }}" @if($fee->account_id==$account['id']) selected @endif data-currency="{{ $account['currency'] }}">
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
                           <button type="submit" class="btn btn-primary btn-theme" id="btn_fee">Update Fee</button>
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
          url:'{{ route('webmaster.fee.update') }}',
          method: 'post',
          data: $(this).serialize(),
          dataType: 'json',
          success: function(response){
            if(response.status == 400){
              $.each(response.message, function (key, value) {
                showError(key, value);
              });
              $("#btn_fee").html('Update Fee');
              $("#btn_fee").prop("disabled", false);
            } else if(response.status == 200){
               $("#fee_form")[0].reset();
              removeErrors("#fee_form");
              $("#btn_fee").html('Update Fee');
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
