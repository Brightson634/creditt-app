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
      <div class="col-xl-12 mx-auto">
         <div class="card">
            <div class="card-body">
               <div class="clearfix mb-3">
                  <div class="float-left">
                     <h3 class="card-title">Expense Information</h3>
                  </div>
                  <div class="float-right">
                     <a href="{{ route('webmaster.expenses') }}" class="btn btn-dark btn-sm btn-theme"> <i class="fa fa-eye"></i> View Expenses</a>
                  </div>
               </div>
               <form action="#" method="POST" id="expense_form">
               @csrf
               <div class="row">
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="name" class="form-label">Expense</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder='Provide name'>
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="subcategory_id">Expense Category</label>
                        <select class="form-control" id="subcategory_id" name="subcategory_id">
                           <option value="">Select category</option>
                           @foreach($categories as $category)
                           <optgroup label="{{ $category->name }}">
                           @php
                           $subcategories = \App\Models\ExpenseCategory::where('is_subcat', 1)->where('parent_id', $category->id)->get();
                           @endphp
                           @foreach($subcategories as $subcategory)
                              <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                           @endforeach
                           </optgroup>
                           @endforeach
                        </select>
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="paymenttype_id">Payment Type</label>
                        <select class="form-control" name="paymenttype_id" id="paymenttype_id">
                           <option value="">select payment type </option>
                           @foreach($payments as $data)
                           <option value="{{ $data->id }}">{{ $data->name }}</option>
                           @endforeach
                        </select>
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="text" name="amount" id="amount" class="form-control">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="amount" class="form-label">Amount Currency</label>
                        <select name="amount_currency" id="amount_currency" class="form-control">
                            <option value="">Please Select Payment Currency</option>
                                @foreach ($currencies as $currency)
                                    <option value="{{ $currency->id }}">{{ $currency->country }} - {{ $currency->currency }}
                                    </option>
                                @endforeach
                        </select>
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <input type="hidden" name="exchangedAmount" id="exchangedAmount" class="form-control">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
               </div>
               <div class="row">
                   <div class="col-md-6">
                     <div class="form-group">
                        <label for="account_id" class="form-label">Account</label>
                        <select name="account_id" class="form-control accounts-dropdown account_id" style="width: 100%;">
                           @foreach ($accounts_array as $account)
                           <option value="{{$account['id']}}" data-currency="{{$account['currency']}}">{{$account['name']}}
                              -{{$account['primaryType']}}-{{$account['subType']}}
                           </option>
                           @endforeach
                               <span class="invalid-feedback"></span>
                        </select>
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="email" class="form-label">Date</label>
                        <input type="text" name="date" class="form-control" data-provide="datepicker" data-date-autoclose="true" data-date-format="yyyy-mm-dd" id="date" value="{{ now()->format('Y-m-d') }}" autocomplete="off">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-8">
                     <div class="form-group">
                        <label for="description" class="form-label">Description</label>
                        <textarea type="text" name="description" id="description" class="form-control" rows="2"> </textarea>
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
               </div>
               <div class="row mt-2">
                  <div class="col-sm-9">
                     <button type="submit" class="btn btn-primary btn-theme" id="btn_expense">Add Expense</button>
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
   $("#expense_form").submit(function(e) {
        e.preventDefault();
        $("#btn_expense").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding');
        $("#btn_expense").prop("disabled", true);
        $.ajax({
          url:'{{ route('webmaster.expense.store') }}',
          method: 'post',
          data: $(this).serialize(),
          dataType: 'json',
          success: function(response){
            if(response.status == 400){
              $.each(response.message, function (key, value) {
                showError(key, value);
              });
              $("#btn_expense").html('Add Expense');
              $("#btn_expense").prop("disabled", false);
            } else if(response.status == 200){
               $("#expense_form")[0].reset();
              removeErrors("#expense_form");
              $("#btn_expense").html('Add Expense');
              $("#btn_expense").prop("disabled", false);
              setTimeout(function(){
                window.location.href = response.url;
              }, 1000);

            }
          }
        });
      });
</script>
<script>
    $(document).ready(function () {
        $("select.accounts-dropdown").select2();
        $("select#amount_currency").select2();
        const exchangeRates = @json($exchangeRates);
        const defaultCurrency = @json($default_currency);

        console.log(exchangeRates)
        console.log(defaultCurrency)

        $('.account_id').change(function() {
         var selectedAccountId = $(this).val(); 
         var accountCurrency = $(this).find('option:selected').data('currency');
         var selectedPaymentCurrency=$('#amount_currency').val();
         
         //check if exchange rate for the payment currency exists
         const rateExists = exchangeRates.find(rate=>rate.from_currency_id==selectedPaymentCurrency);
         if(rateExists  ){
            const exchangeRate = Number(rateExists.exchange_rate)
            const exchangeRateToCurrency = Number(rateExists.to_currency_id)
            if(Number(selectedPaymentCurrency) !== Number(accountCurrency))
            {
               alert('Different Currency from selected account')
            }else{
               const paymentAmount = Number($("#amount").val())
               const exchangedPaymentAmount = exchangeRate*paymentAmount
               $("#exchangedAmount").val(exchangedPaymentAmount)
            }
         }else{
            alert('No  exchange Rate defined for the selected payment currency')
         }
       });
    });
</script>
@endsection
