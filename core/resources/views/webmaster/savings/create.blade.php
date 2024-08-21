@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection
@section('content')
<div class="page-heading">
@include('webmaster.partials.generalheader')
</div>
   <div class="row">
      <div class="col-xl-12 mx-auto">
         <div class="card">
            <div class="card-body">
               <div class="clearfix mb-3">
                  <div class="float-left">
                     <h3 class="card-title">Savings Information</h3>
                  </div>
                  <div class="float-right">
                     <a href="{{ route('webmaster.savings') }}" class="btn btn-sm btn-dark btn-theme"> <i class="fa fa-eye"></i> View Savings</a>
                  </div>
               </div>
               <form action="#" method="POST" id="saving_form">
               @csrf
               <div class="row">
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="member_id" class="form-label">Member</label>
                        <select class="form-control" name="member_id" id="member_id">
                           <option value="">select member</option>
                           @foreach($members as $data)
                           <option value="{{ $data->id }}">{{ $data->fname }} {{ $data->lname }}</option>
                           @endforeach
                        </select>
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="account_id" class="form-label">Account No</label>
                        <select name="account_id" class="form-control" id="account_id">
                          <option value="">select account number</option>
                        </select>
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="deposit_amount" class="form-label">Deposit Amount</label>
                        <input type="text" name="deposit_amount" id="deposit_amount" class="form-control">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="depositor_type" class="form-label">Member</label>
                        <select class="form-control" name="depositor_type" id="depositor_type">
                           <option value="">select depositor type</option>
                           <option value="1">Member </option>
                           <option value="0">Member Representative</option>
                        </select>
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-4 memberDiv" style="display: none;">
                     <div class="form-group">
                        <label for="depositor_name" class="form-label">Depositors Name</label>
                        <input type="text" name="depositor_name" id="depositor_name" class="form-control">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
               </div>
               <div class="row mt-2">
                  <div class="col-sm-9">
                     <button type="submit" class="btn btn-primary btn-theme" id="btn_saving">Add Savings</button>
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

    // $('.supplier_payment_type').on('change', function() {
    //     var paymentType = $('input[name="supplier_payment_type"]:checked').val();
    //     var accountDiv = $('#account_div');

    //     if (paymentType === 'bank') {
    //         accountDiv.show();
    //     } else {
    //         accountDiv.hide();
    //     }
    // });



     $('#depositor_type').change(function() {
      let depositor_type = $(this).val();
      if (depositor_type == 1) {
         $('.memberDiv').show();
      } else if (depositor_type == 0) {
         $('.memberDiv').show();
      } else if (depositor_type == '') {
         $('.memberDiv').hide();
      }else {
         $('.memberDiv').hide();
      }
   });


   $('#member_id').change(function() {
      var member_id = $(this).val();
      let url = `${baseurl}/webmaster/saving/getaccounts/${member_id}`;
      $.get(url, function(response){
         // var options = '<option value="">select account number</option>';
         // $.each(response, function(index, account) {
         //     options += '<option value="' + account.id + '">' + account.account_no + '</option>';
         // });
         // $("#account_id").html(options);
         $("#account_id").html(response);
      });
   });

   $("#saving_form").submit(function(e) {
        e.preventDefault();
        $("#btn_saving").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding');
        $("#btn_saving").prop("disabled", true);
        $.ajax({
          url:'{{ route('webmaster.saving.store') }}',
          method: 'post',
          data: $(this).serialize(),
          dataType: 'json',
          success: function(response){
            if(response.status == 400){
              $.each(response.message, function (key, value) {
                showError(key, value);
              });
              $("#btn_saving").html('Add Savings');
              $("#btn_saving").prop("disabled", false);
            } else if(response.status == 200){
               $("#saving_form")[0].reset();
              removeErrors("#saving_form");
              $("#btn_saving").html('Add Saving');
              $("#btn_saving").prop("disabled", false);
              setTimeout(function(){
                window.location.href = response.url;
              }, 1000);

            }
          }
        });
      });
</script>
@endsection
