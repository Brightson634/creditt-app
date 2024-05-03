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
                     <h3 class="card-title">Account Information</h3>
                  </div>
                  <div class="float-right">
                     <a href="{{ route('webmaster.memberaccounts') }}" class="btn btn-sm btn-theme"> <i class="fa fa-eye"></i> View Accounts</a>
                  </div>
               </div>
               <form action="#" method="POST" id="account_form"> 
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
                        <label for="accounttype_id" class="form-label">Account Type</label>
                        <select class="form-control" name="accounttype_id" id="accounttype_id">
                           <option value="">select account type </option>
                           @foreach($accounttypes as $data)
                           <option value="{{ $data->id }}">{{ $data->name }}</option>
                           @endforeach
                        </select>
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="account_no" class="form-label">Account No:</label>
                        <input type="text" name="account_no" id="account_no" class="form-control" value="{{ $account_no }}" readonly>
                     </div>
                  </div>
               </div>
                <div class="row">
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="opening_balance" class="form-label">Opening Balance</label>
                     <input type="text" name="opening_balance" id="opening_balance" class="form-control">
                     <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-4">
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
                        <label for="account_purpose" class="form-label">Account Purpose</label>
                        <input type="text" name="account_purpose" id="account_purpose" class="form-control">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
               </div> 
               <div class="row">
                  
               </div>
               <div class="row mt-2">
                  <div class="col-sm-9">
                     <button type="submit" class="btn btn-theme" id="btn_account">Add Account</button>
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
   $('[data-toggle="select2"]').select2();

   $("#account_form").submit(function(e) {
        e.preventDefault();
        $("#btn_account").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding');
        $("#btn_account").prop("disabled", true);
        $.ajax({
          url:'{{ route('webmaster.memberaccount.store') }}',
          method: 'post',
          data: $(this).serialize(),
          dataType: 'json',
          success: function(response){
            if(response.status == 400){
              $.each(response.message, function (key, value) {
                showError(key, value);
              });
              $("#btn_account").html('Add Account');
              $("#btn_account").prop("disabled", false);
            } else if(response.status == 200){
               $("#account_form")[0].reset();
              removeErrors("#account_form");
              $("#btn_account").html('Add Account');
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