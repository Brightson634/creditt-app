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
                     <h3 class="card-title">Chart Of Account Information</h3>
                  </div>
                  <div class="float-right">
                     <a href="{{ route('webmaster.chartofaccounts') }}" class="btn btn-sm btn-theme"> <i class="fa fa-eye"></i> View Chart Of Accounts</a>
                  </div>
               </div>
               <form action="#" method="POST" id="account_form"> 
               @csrf
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="name" class="form-label">Name:</label>
                        <input type="text" name="name" id="name" class="form-control">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="accountsubtype_id">Account Type</label>
                        <select class="form-control" id="accountsubtype_id" name="accountsubtype_id">
                           <option value="">Select account</option>
                           @foreach($accounttypes as $accounttype)
                           <optgroup label="{{ $accounttype->name }}">
                           @php
                           $accountsubtypes = \App\Models\ChartOfAccountType::where('is_subaccount', 1)->where('parent_id', $accounttype->id)->get();
                           @endphp
                           @foreach($accountsubtypes as $accountsubtype)
                              <option value="{{ $accountsubtype->id }}">{{ $accountsubtype->name }}</option>
                           @endforeach
                           </optgroup>
                           @endforeach
                        </select>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="code" class="form-label">General Ledge Code</label>
                        <input type="text" name="code" id="code" class="form-control">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="currency_id" class="form-label">Currency</label>
                         <select class="form-control" name="currency_id" id="currency_id">
                           <option value="">select currency</option>
                           @foreach($currencies as $data)
                           <option value="{{ $data->id }}">{{ $data->name }} - {{ $data->code }}</option>
                           @endforeach
                        </select>
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
               </div>
               <div class="row mb-3">
                  <div class="col-md-6">
                     <div class="form-group">
                        <div class="custom-control custom-checkbox">
                           <input type="checkbox" name="is_subaccount" class="custom-control-input" id="is_subaccount">
                           <label class="custom-control-label" for="is_subaccount">Make this a sub-account</label>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6 parentDiv" style="display: none;">
                     <div class="form-group">
                        <label for="parent_id" class="form-label">Parent Account</label>
                         <select class="form-control" name="parent_id" id="parent_id">
                           <option value="">select parent account</option>
                           @foreach($parentaccounts as $data)
                           <option value="{{ $data->id }}">{{ $data->code }} - {{ $data->name }}</option>
                           @endforeach
                        </select>
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <div class="custom-control custom-radio custom-control-inline">
                           <input type="radio" id="yes" name="status" class="custom-control-input" value="1" checked>
                            <label class="custom-control-label" for="yes">Active</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                           <input type="radio" id="no" name="status" class="custom-control-input" value="0">
                           <label class="custom-control-label" for="no">Not Active</label>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <div class="custom-control custom-checkbox">
                           <input type="checkbox" name="has_balance" class="custom-control-input" id="has_balance" value="1">
                           <label class="custom-control-label" for="has_balance">Has Opening Balance</label>
                        </div>
                     </div>
                  </div>
               </div>
               <div id="balanceDiv" style="display: none;">
                  <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="opening_balance" class="form-label">Opening Balance</label>
                        <input type="text" name="opening_balance" id="opening_balance" class="form-control">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="paymenttype_id" class="form-label">Payment Type</label>
                         <select class="form-control" name="paymenttype_id" id="paymenttype_id">
                           <option value="">select payment type</option>
                           @foreach($paymenttypes as $data)
                           <option value="{{ $data->id }}">{{ $data->name }}</option>
                           @endforeach
                        </select>
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
               </div>
               </div>
               <div class="row">
                  <div class="col-md-12">
                     <div class="form-group">
                        <label for="description" class="form-label">Notes</label>
                        <textarea type="text" name="description" id="description" class="form-control" rows="3"> </textarea>
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
               </div>
               <div class="row mt-2">
                  <div class="col-sm-9">
                     <button type="submit" class="btn btn-theme" id="btn_account">Add Chart of Account</button>
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

   $('input[name="is_subaccount"]').on('change', function() {
      if ($(this).prop('checked')) {
         $('.parentDiv').show();
      } else {
         $('.parentDiv').hide();
      }
   });

   $('input[name="has_balance"]').on('change', function() {
      if ($(this).prop('checked')) {
         $('#balanceDiv').show();
      } else {
         $('#balanceDiv').hide();
      }
   });

   $("#account_form").submit(function(e) {
        e.preventDefault();
        $("#btn_account").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding');
        $("#btn_account").prop("disabled", true);
        $.ajax({
          url:'{{ route('webmaster.chartofaccount.store') }}',
          method: 'post',
          data: $(this).serialize(),
          dataType: 'json',
          success: function(response){
            if(response.status == 400){
              $.each(response.message, function (key, value) {
                showError(key, value);
              });
              $("#btn_account").html('Add Chart of Account');
              $("#btn_account").prop("disabled", false);
            } else if(response.status == 200){
               $("#account_form")[0].reset();
              removeErrors("#account_form");
              $("#btn_account").html('Add Chart of Account');
              $("#btn_account").prop("disabled", false);
              setTimeout(function(){
                window.location.href = response.url;
              }, 1000);

            }
          }
        });
      });
</script>
@endsection