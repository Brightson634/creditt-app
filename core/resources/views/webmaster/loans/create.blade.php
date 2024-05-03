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
                     <h3 class="card-title">Loan Information</h3>
                  </div>
                  <div class="float-right">
                     <a href="{{ route('webmaster.loans') }}" class="btn btn-sm btn-theme"> <i class="fa fa-eye"></i> View Loans</a>
                  </div>
               </div>
               <form action="#" method="POST" id="loan_form"> 
               @csrf
               <div class="row">
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="loan_no" class="form-label">Loan No:</label>
                        <input type="text" name="loan_no" id="loan_no" class="form-control" value="{{ $loan_no }}" readonly>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="loan_type" class="form-label">Loan Type</label>
                        <select class="form-control" name="loan_type" id="loan_type">
                           <option value="">select loan type</option>
                           <option value="individual">Individual Loan</option>
                           <option value="group">Group Loan</option>
                        </select>
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-4 memberDiv">
                     <div class="form-group">
                        <label for="member_id" class="form-label">Member</label>
                        <select class="form-control member_id" name="member_id" id="member_id">
                           <option value="">select member</option>
                           @foreach($members as $data)
                           <option value="{{ $data->id }}">{{ $data->fname }} - {{ $data->lname }}</option>
                           @endforeach
                        </select>
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-4 groupDiv" style="display: none;">
                     <div class="form-group">
                        <label for="group_id" class="form-label">Group</label>
                        <select class="form-control member_id" name="group_id" id="group_id">
                           <option value="">select group</option>
                           @foreach($groups as $data)
                           <option value="{{ $data->id }}">{{ $data->fname }}</option>
                           @endforeach
                        </select>
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
               </div>
                <div class="row">
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="principal_amount" class="form-label">Principal Amount</label>
                        <input type="text" name="principal_amount" id="principal_amount" class="form-control">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="loanproduct_id" class="form-label">Loan Product</label>
                           <select class="form-control" name="loanproduct_id" id="loanproduct_id">
                           <option value="">select loan product</option>
                           @foreach($loanproducts as $data)
                           <option value="{{ $data->id }}" data-duration="{{ $data->duration }}" data-interestvalue="{{ $data->interest_value }}">{{ $data->name }} - 
                              @if($data->duration == 'day') DAILY   @endif
                              @if($data->duration == 'week') WEEKLY   @endif
                              @if($data->duration == 'month') MONTHLY @endif
                              @if($data->duration == 'year') YEARLY   @endif - {{ $data->interest_rate }}%</option>
                           @endforeach
                       </select>
                       <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="loan_period" class="form-label">Loan Term/Period</label>
                        <div class="input-group">
                          <input type="text" name="loan_period" id="loan_period" class="form-control">
                          <div class="input-group-append">
                            <span class="input-group-text" id="duration_plan"></span>
                          </div>
                           <span class="invalid-feedback"></span>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="interest_amount" class="form-label">Interest Amount</label>
                         <input type="text" name="interest_amount" id="interest_amount" class="form-control" readonly>
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="repayment_amount" class="form-label">Loan Repayment Amount</label>
                         <input type="text" name="repayment_amount" id="repayment_amount" class="form-control" readonly>
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="end_date" class="form-label">Loan End Date</label>
                         <input type="text" name="end_date" id="end_date" class="form-control" readonly>
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-8">
                     <div class="form-group">
                        <label for="fees_id" class="form-label">Applicable Fees</label>
                        <select class="form-control select2" data-toggle="select2" multiple="multiple" name="fees_id[]" id="fees_id">
                           <option value="">select fees </option>
                           @foreach($fees as $data)
                           <option value="{{ $data->id }}">{{ $data->name }}</option>
                           @endforeach
                        </select>
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="fees_total" class="form-label">Fees Total</label>
                        <input type="text" name="fees_total" id="fees_total" class="form-control" readonly>
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
               </div>

               <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                        <label for="payment_mode" class="form-label">Payment Mode</label>
                        <select class="form-control" name="payment_mode" id="payment_mode">
                           <option value="">select payment option</option>
                           <option value="cash">Cash Payment</option>
                           <option value="savings">Saving Account</option>
                           <option value="loan">Loan Principal</option>
                        </select>
                        <span class="invalid-feedback"></span>
                    </div>
                  </div>
                  <div class="col-md-4 cashDiv" style="display: none;">
                     <div class="form-group">
                        <label for="cash_amount" class="form-label">Cash Amount</label>
                        <input type="text" name="cash_amount" id="cash_amount" class="form-control" readonly>
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-4 savingDiv" style="display: none;">
                     <div class="form-group">
                        <label for="account_id" class="form-label">Account No</label>
                        <select name="account_id" class="form-control account_id" id="account_id">
                          <option value="">select account number</option>
                        </select>
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>

                  <div class="col-md-4 loanDiv" style="display: none;">
                     <div class="form-group">
                        <label for="loan_principal" class="form-label">Loan Principal</label>
                        <input type="text" name="loan_principal" id="loan_principal" class="form-control" readonly>
                     </div>
                  </div>
               </div>

               <div class="row mt-2">
                  <div class="col-sm-9">
                     <button type="submit" class="btn btn-theme" id="btn_loan">Add Loan</button>
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
   $('[data-toggle="select2"]').select2();

   $('#loanproduct_id').change(function() {
      let selectedOption = $(this).find(':selected');
      let duration = selectedOption.data("duration");
      let durationSpan = $("#duration_plan");
      if (duration === 'day') {
         durationSpan.text('Days');
      } else if (duration === 'week') {
         durationSpan.text('Weeks');
      } else if (duration === 'month') {
         durationSpan.text('Months');
      } else if (duration === 'year') {
         durationSpan.text('Years');
      } else {
         durationSpan.text('');
      }
   });

   $('#loanproduct_id, #principal_amount, #loan_period').on('input', function() {
      let selectedOption = $('#loanproduct_id').find(':selected');
      let duration = selectedOption.data("duration");
      let interest_value = selectedOption.data("interestvalue");
      let principal_amount = parseFloat($('#principal_amount').val()) || 0;
      let loan_period = parseFloat($('#loan_period').val()) || 0;
      let interest_rate = parseFloat(selectedOption.text().split('-')[1]) || 0;
      let interest_amount = 0;
      let repayment_amount = 0;
      let end_date = new Date();

      if (duration === 'day') {
         interest_amount = interest_value * principal_amount * loan_period;
         repayment_amount = principal_amount + interest_amount;
         end_date = new Date();
         end_date.setDate(end_date.getDate() + loan_period);
      } else if (duration === 'week') {
         interest_amount = interest_value * principal_amount * (loan_period * 7);
         repayment_amount = principal_amount + interest_amount;
         end_date = new Date();
         end_date.setDate(end_date.getDate() + (loan_period * 7));
      } else if (duration === 'month') {
         interest_amount = interest_value * principal_amount * loan_period;
         repayment_amount = principal_amount + interest_amount;
         end_date = new Date();
         end_date.setMonth(end_date.getMonth() + loan_period);
      } else if (duration === 'year') {
         interest_amount = interest_value * principal_amount * loan_period;
         repayment_amount = principal_amount + interest_amount;
         end_date = new Date();
         end_date.setFullYear(end_date.getFullYear() + loan_period);
      }

      let formatted_end_date = end_date.getFullYear() + '-' + (end_date.getMonth() + 1).toString().padStart(2, '0') + '-' + end_date.getDate().toString().padStart(2, '0');

      $('#interest_amount').val(isNaN(interest_amount) ? '' : interest_amount);
      $('#repayment_amount').val(isNaN(repayment_amount) ? '' : repayment_amount);
      $('#end_date').val(formatted_end_date);
   });

   $('#fees_id').change(function() {
      let selectedFeesIds = $('#fees_id option:checked').map(function() {
         return $(this).val();
      }).get();
      let principalAmount = parseFloat($('#principal_amount').val()) || 0;
      calculateFeesTotal(selectedFeesIds, principalAmount);
   });

   $('#principal_amount').on('input', function() {
      let principalAmount = $(this).val();
      $('#loan_principal').val(principalAmount);
      let selectedFeesIds = ['0'];
      calculateFeesTotal(selectedFeesIds, principalAmount);
   });

   function calculateFeesTotal(selectedFeesIds, principalAmount) {
      //var selectedFeesIds = $('#fees_id option:checked').map(function() {
         //return $(this).val();
      //}).get();
      //let principalAmount = parseFloat($('#principal_amount').val()) || 0;

      $.ajax({
         url:'{{ route('webmaster.loan.feescalculate') }}',
         method: "post",
         headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
         },
         data: {
            'fees_id' : selectedFeesIds, 
            'principal_amount' : principalAmount
         },
         dataType: 'json',
         success:function(data){
            $('#fees_total').val(data.fees_total.toFixed(2));
            $('#cash_amount').val(data.fees_total.toFixed(2));
         },
         error:function (data) {
            //
         }
      });
   }

   $('#loan_type').change(function() {
      let loan_type = $(this).val();
      if (loan_type == 'member') {
         $('.memberDiv').show();
         $('.groupDiv').hide();
      } else if (loan_type == 'group') {
         $('.memberDiv').hide();
         $('.groupDiv').show();
      } else {
         $('.memberDiv').show();
         $('.groupDiv').hide();
      } 
   });

   $('#payment_mode').change(function() {
      let payment_mode = $(this).val();
      if (payment_mode == 'cash') {
         let feesTotal = parseFloat($('#fees_total').val()) || 0;
         $('#cash_amount').val(feesTotal);
         $('.cashDiv').show();
         $('.savingDiv').hide();
         $('.loanDiv').hide();
      } else if (payment_mode == 'savings') {
         $('.cashDiv').hide();
         $('.savingDiv').show();
         $('.loanDiv').hide();
      } else if (payment_mode == 'loan') {
         $('.cashDiv').hide();
         $('.savingDiv').hide();
         $('.loanDiv').show();
      } else {
         $('.cashDiv').hide();
         $('.savingDiv').hide();
         $('.loanDiv').hide();
      } 
   });

   $('.member_id').change(function() {
      var member_id = $(this).val();
      let url = `${baseurl}/webmaster/saving/getaccounts/${member_id}`;
      $.get(url, function(response){
         $(".account_id").html(response);
      });
   });


   $("#loan_form").submit(function(e) {
        e.preventDefault();
        $("#btn_loan").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding');
        $("#btn_loan").prop("disabled", true);
        $.ajax({
          url:'{{ route('webmaster.loan.store') }}',
          method: 'post',
          data: $(this).serialize(),
          dataType: 'json',
          success: function(response){
            if(response.status == 400){
              $.each(response.message, function (key, value) {
                showError(key, value);
              });
              $("#btn_loan").html('Add Loan');
              $("#btn_loan").prop("disabled", false);
            } else if(response.status == 200){
               $("#loan_form")[0].reset();
              removeErrors("#loan_form");
              $("#btn_loan").html('Add Loan');
              $("#btn_loan").prop("disabled", false);
              setTimeout(function(){
                window.location.href = response.url;
              }, 1000);

            }
          }
        });
      });
</script>
@endsection