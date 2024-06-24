@extends('webmaster.partials.dashboard.main')
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
      <div class="col-xl-12">
         <div class="card">
            <div class="card-body">
               <div class="clearfix mb-3">
                  <div class="float-left">
                     <h4 class="card-title">{{ $page_title }}</h4>
                  </div>
                  <div class="float-right">
                     <a href="{{ route('webmaster.loanpayment.create') }}" class="btn btn-sm btn-theme"> <i class="fa fa-plus"></i> Add Loan Payments</a>
                  </div>
               </div>
               @if($repayments->count() > 0)
               <div class="table-responsive">
                  <table class="table table-sm mb-0">
                     <thead>
                        <tr>
                           <th>Date</th>
                           <th>Member</th>
                           <th>Loan Amount</th>
                           <th>Amount Received</th>
                           <th>Remaining Balance</th>
                           <th>Paid By</th>
                           <th>Recieved By</th>
                        </tr>
                     </thead>
                     <tbody>
                        @php $i = 0; @endphp
                        @foreach($repayments as $row)
                        @php $i++; @endphp
                        <tr>
                           <td>{{ dateFormat($row->date) }}</td>
                           <td>{{ $row->member->fname }}</td>
                           <td>{!! showAmount($row->loan_amount) !!}</td>
                           <td>{!! showAmount($row->repaid_amount) !!}</td>
                           <td>{!! showAmount($row->balance_amount) !!}</td>
                           <td>{{ $row->paid_by }}</td>
                           <td>{{ $row->staff->fname }}</td>

                        <tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
               @else
               <div class="d-flex flex-column align-items-center mt-5">
                  <img src="{{ asset('assets/uploads/defaults/nodata.png') }}" width="200">
                  <span class="mt-3">No Data</span>
               </div>
               @endif
            </div>
         </div>
      </div>
   </div>
@endsection
@section('scripts')
   <script type="text/javascript">
      "use strict";
      $('[data-toggle="select2"]').select2();

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

      $("#payment_form").submit(function(e) {
         e.preventDefault();
         $("#btn_payment").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Paying');
         $("#btn_payment").prop("disabled", true);
         $.ajax({
            url:'{{ route('webmaster.loan.repayment.store') }}',
            method: 'post',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response){
               if(response.status == 400){
                  $.each(response.message, function (key, value) {
                     showError(key, value);
                  });
                  $("#btn_payment").html('Add Payments');
                  $("#btn_payment").prop("disabled", false);
               } else if(response.status == 200){
                  $("#payment_form")[0].reset();
                  removeErrors("#payment_form");
                  $("#btn_payment").html('Add Payments');
                  $("#btn_payment").prop("disabled", false);
                  setTimeout(function(){
                     window.location.reload();
                  }, 500);
               }
             }
           });
         });

   </script>
@endsection
