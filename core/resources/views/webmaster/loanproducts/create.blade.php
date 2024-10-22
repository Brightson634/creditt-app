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
                     <h3 class="card-title">Loan Product Information</h3>
                  </div>
                  <div class="float-right">
                     <a href="{{ route('webmaster.loanproducts') }}" class="btn btn-dark btn-sm btn-theme"> <i class="fa fa-eye"></i> View Loan Products</a>
                  </div>
               </div>
               <form action="#" method="POST" id="loanproduct_form">
               @csrf
               <div class="row">
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="min_amount" class="form-label">Minimum Amount:</label>
                        <input type="number" name="min_amount" id="min_amount" class="form-control">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="max_amount" class="form-label">Maximum Amount:</label>
                        <input type="number" name="max_amount" id="max_amount" class="form-control">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
               </div>
                <div class="form-group row">
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="interest_rate" class="form-label">Interest Rate</label>
                        <input type="number" name="interest_rate" id="interest_rate" class="form-control">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="comment" class="form-label">Duration Period</label>
                     <select class="form-control" name="duration" id="duration">
                           <option value="">select period</option>
                           <option value="day">Daily</option>
                           <option value="week">Weekly</option>
                           <option value="month">Monthly</option>
                           <option value="quarter">Quarterly<
                           <option value="semi_annual">Semi-Annually</option>
                           <option value="year">Yearly</option>
                        </select>
                     <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="cust_acc_balance" class="form-label">Minimum Customer Account Balance</label>
                        <input type='number' class='form-control' name='cust_acc_balance' id='cust_acc_balance' />
                        <p class='text-muted'>This field will be considered incase the loan creation process 
                           allows customer account balance to be used as collateral  </span>
                     <span class="invalid-feedback"></p>
                     </div>
                  </div>
               </div>

               <div class="row mt-2">
                  <div class="col-sm-9">
                     <button type="submit" class="btn btn-primary btn-theme" id="btn_loanproduct">Add Loan Product</button>
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

   $("#loanproduct_form").submit(function(e) {
        e.preventDefault();
        $("#btn_loanproduct").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding');
        $("#btn_loanproduct").prop("disabled", true);
        $.ajax({
          url:'{{ route('webmaster.loanproduct.store') }}',
          method: 'post',
          data: $(this).serialize(),
          dataType: 'json',
          success: function(response){
            if(response.status == 400){
              $.each(response.message, function (key, value) {
                showError(key, value);
              });
              $("#btn_loanproduct").html('Add Loan Product');
              $("#btn_loanproduct").prop("disabled", false);
            } else if(response.status == 200){
               $("#loanproduct_form")[0].reset();
              removeErrors("#loanproduct_form");
              $("#btn_loanproduct").html('Add Loan Product');
              $("#btn_loanproduct").prop("disabled", false);
              setTimeout(function(){
                window.location.href = response.url;
              }, 1000);

            }
          }
        });
      });
</script>
@endsection
