@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection
@section('content')

<!-- {{$loans}} -->
<div class="page-heading">
   {{-- <div class="page-heading__title">
      <h3>{{ $page_title }}</h3>
   </div> --}}
</div>

   <div class="row">
      <div class="col-xl-7 mx-auto">
         <div class="card">
            <div class="card-body">
               <div class="clearfix mb-3">
                  <div class="float-left">
                     <h3 class="card-title">Loan Payment Information</h3>
                  </div>
                  <div class="float-right">
                     <a href="{{ route('webmaster.loanpayments') }}" class="btn btn-sm btn-dark btn-theme"> <i class="fa fa-eye"></i> View Loan Payments</a>
                  </div>
               </div>
               <form action="#" method="POST" id="repayment_form">
               @csrf
               <div class="form-group row">
                  <label for="loan_id" class="col-sm-3 col-form-label">Loan Member</label>
                  <div class="col-sm-9">
                     <select class="form-control" name="loan_id" id="loan_id">
                        <option value="">select loan member</option>
                        @foreach($loans as $data)
                        <option value="{{ $data->id }}">{{ $data->member->fname }} -- Ugx {{$data->repayment_amount}} </option>
                        @endforeach
                     </select>
                     <span class="invalid-feedback"></span>
                  </div>
               </div>
               <hr>
                <!-- <h3 class="mb-4"><small>Loan Balance:</small> <span id="loan-balance"></span></h3> -->

               <div class="form-group row mt-4">
                  <label for="payment_type" class="col-sm-4 col-form-label">Payment Type</label>
                  <div class="col-sm-8  col-form-label">
                     <div class="custom-control custom-radio custom-control-inline">
                           <input type="radio" id="partial" name="payment_type" class="custom-control-input" value="partial" checked>
                            <label class="custom-control-label" for="partial">PARTIAL PAYMENT</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                           <input type="radio" id="full" name="payment_type" class="custom-control-input" value="full">
                           <label class="custom-control-label" for="full">FULL PAYMENT</label>
                        </div>
                  </div>
               </div>

               <div id="partialPayment">
                  <div class="form-group row">
                  <label for="partial_payment" class="col-sm-4 col-form-label">Enter Partial Amount</label>
                  <div class="col-sm-8">
                     <input type="text" name="partial_payment" id="partial_payment" class="form-control">
                     <span class="invalid-feedback"></span>
                  </div>
               </div>
                                        </div>

                                        <div id="fullPayment" style="display:none;">

                                        <div class="form-group row">
                  <label for="full_payment" class="col-sm-4 col-form-label">Full Payment Amount</label>
                  <div class="col-sm-8">
                     <input type="text" name="full_payment" id="full_payment" class="form-control"  readonly>
                     <span class="invalid-feedback"></span>
                  </div>
               </div>
                           </div>

                     <div class="form-group row">
                  <label for="account_id" class="col-sm-4 col-form-label">Account</label>
                  <div class="col-sm-8">
                     <select class="form-control" name="account_id" id="account_id">
                           <option value="">select account</option>
                           @foreach($accounts as $data)
                           <option value="{{ $data->id }}">{{ $data->code }} - {{ $data->name }}</option>
                           @endforeach
                        </select>
                     <span class="invalid-feedback"></span>
                  </div>
               </div>



                  <div class="form-group row">
                  <label for="paid_by" class="col-sm-4 col-form-label">Paid By</label>
                  <div class="col-sm-8">
                     <input type="text" name="paid_by" id="paid_by" class="form-control">
                     <span class="invalid-feedback"></span>
                  </div>
               </div>

               <div class="form-group row">
                  <label for="staff_id" class="col-sm-4 col-form-label">Received By</label>
                  <div class="col-sm-8">
                     <select class="form-control" name="staff_id" id="staff_id">
                        <option value="">select the staff</option>
                        @foreach($staffs as $data)
                        <option value="{{ $data->id }}">{{ $data->title }} {{ $data->fname }} {{ $data->lname }}</option>
                         @endforeach
                     </select>
                     <span class="invalid-feedback"></span>
                  </div>
               </div>

               <div class="form-group row">
                  <label for="note" class="col-sm-4 col-form-label">Payment Note</label>
                  <div class="col-sm-8">
                     <textarea name="note" class="form-control" id="note" rows="4"></textarea>
                     <span class="invalid-feedback"></span>
                  </div>
               </div>

               <div class="form-group row mt-4">
                  <label class="col-sm-3 col-form-label"></label>
                  <div class="col-sm-9">
                     <button type="submit" class="btn btn-primary btn-theme" id="btn_repayment">Add Payments</button>
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

   $('#loan_id').change(function() {
      let loan_id = $(this).val();
      if (loan_id === "") {
         loan_id = 0;
         //$("#btn_repayment").prop("disabled", true);
      }
      let url = `${baseurl}/webmaster/loanpayment/member/${loan_id}`;
      $.get(url, function(response){
         $("#btn_repayment").prop("disabled", false);
         $("#loan-balance").html(response.formatloanamount);
         $("#full_payment").val(response.loan_amount);
         //$("#term_period").text(response.duration);
         //console.log(response.loan_amount);

         // Trigger the input event after fetching loan plan data
         //$('#loan_amount, #loan_term').trigger('input');
      });
   });

   $('input[name="payment_type"]').on('change', function() {
         let payment_type = $('input[name="payment_type"]:checked').val();
         if (payment_type == 'full') {
            $('#partialPayment').hide();
            $('#fullPayment').show();
         } else if (payment_type == 'partial') {
            $('#partialPayment').show();
            $('#fullPayment').hide();
         } else {
            $('#partialPayment').hide();
            $('#fullPayment').hide();
         }
      });

   $("#repayment_form").submit(function(e) {
        e.preventDefault();
        $("#btn_repayment").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding');
        $("#btn_repayment").prop("disabled", true);
        $.ajax({
          url:'{{ route('webmaster.loanpayment.store') }}',
          method: 'post',
          data: $(this).serialize(),
          dataType: 'json',
          success: function(response){
            if(response.status == 400){
              $.each(response.message, function (key, value) {
                showError(key, value);
              });
              $("#btn_repayment").html('Add Payment');
              $("#btn_repayment").prop("disabled", false);
            } else if(response.status == 200){
               $("#repayment_form")[0].reset();
              removeErrors("#repayment_form");
              $("#btn_repayment").html('Add Payment');
              $("#btn_repayment").prop("disabled", false);
              setTimeout(function(){
                window.location.href = response.url;
              }, 1000);

            }
          }
        });
      });
</script>
@endsection
