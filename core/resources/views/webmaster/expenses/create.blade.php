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
                     <h3 class="card-title">Expense Information</h3>
                  </div>
                  <div class="float-right">
                     <a href="{{ route('webmaster.expenses') }}" class="btn btn-dark btn-sm btn-theme"> <i class="fa fa-eye"></i> View Expenses</a>
                  </div>
               </div>
               <form action="#" method="POST" id="expense_form">
               @csrf
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="name" class="form-label">Expense</label>
                        <input type="text" name="name" id="name" class="form-control">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-6">
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
               </div>
               <div class="row">
                  <div class="col-md-3">
                     <div class="form-group">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="text" name="amount" id="amount" class="form-control">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="account_id" class="form-label">Account</label>
                        <select class="form-control" name="account_id" id="account_id">
                           <option value="">select account</option>
                           @foreach($accounts as $data)
                           <option value="{{ $data->id }}">{{ $data->code }} - {{ $data->name }}</option>
                           @endforeach
                        </select>
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-group">
                        <label for="email" class="form-label">Date</label>
                        <input type="text" name="date" class="form-control" data-provide="datepicker" data-date-autoclose="true" data-date-format="yyyy-mm-dd" id="date" value="{{ now()->format('Y-m-d') }}" autocomplete="off">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
               </div>
               <div class="row">
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
@endsection
