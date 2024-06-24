@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection
@section('content')
<div class="page-heading ">
   <div class="page-heading__title">
      <h3>{{ $page_title }}</h3>
   </div>
</div>
<div class="row">
         <div class="col-md-12">
            <div class="card">
               <div class="card-body">
                  <div class="clearfix mb-3">
                     <div class="float-left">
                        <h3 class="card-title">Account Deposits</h3>
                     </div>
                     <div class="float-right">
                        <button type="button" class="btn btn-sm btn-theme" data-toggle="modal" data-target="#accountdepositModel">
                           <i class="fa fa-plus"></i> Add Account Deposit
                        </button>
                        <div class="modal fade" id="accountdepositModel">
                           <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                              <div class="modal-content">
                                 <div class="modal-body">
                                    <h4 class="card-title mb-4"> Account Deposit Form </h4>
                                    <form action="#" method="POST" id="accountdeposit_form">
                                      @csrf
                                       <div class="row">
                                          <div class="col-md-8">
                                             <div class="form-group">
                                          <label for="account_id">Account</label>
                                          <select class="form-control" name="account_id" id="account_id">
                                             <option value="">select account</option>
                                             @foreach($accounts as $data)
                                             <option value="{{ $data->id }}">{{ $data->code }} - {{ $data->name }}</option>
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
                                          <div class="col-md-3">
                                             <div class="form-group">
                                          <label for="amount">Amount</label>
                                          <input type="text" name="amount" id="amount" class="form-control">
                                          <span class="invalid-feedback"></span>
                                       </div>
                                          </div>
                                          <div class="col-md-6">
                                             <div class="form-group">
                                          <label for="depositor">Depositor</label>
                                          <input type="text" name="depositor" id="depositor" class="form-control">
                                          <span class="invalid-feedback"></span>
                                       </div>
                                          </div>
                                          <div class="col-md-3">
                                             <div class="form-group">
                                          <label for="date" class="form-label">Transaction Date</label>
                                          <input type="text" name="date" class="form-control" data-provide="datepicker" data-date-autoclose="true" data-date-format="yyyy-mm-dd" id="date" value="{{ now()->format('Y-m-d') }}" autocomplete="off">
                                          <span class="invalid-feedback"></span>
                                       </div>
                                          </div>
                                       </div>
                                       <div class="row">
                                          <div class="col-md-12">
                                             <div class="form-group">
                                          <label for="description">Description</label>
                                          <textarea name="description" class="form-control" id="description" rows="3"></textarea>
                                          <span class="invalid-feedback"></span>
                                       </div>
                                          </div>
                                       </div>

                                        <div class="form-group">
                                           <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
                                           <button type="submit" class="btn btn-sm btn-theme" id="btn_accountdeposit">Add Account Deposit</button>
                                        </div>
                                     </form>
                                  </div>
                               </div>
                            </div>
                         </div>
                     </div>
                  </div>
                  @if($accountdeposits->count() > 0)
                  <div class="table-responsive">
                     <table class="table table-sm mb-0">
                        <thead>
                           <tr>
                              <th>Date</th>
                              <th>Amount</th>
                              <th>Account</th>
                              <th>Payment Type</th>
                              <th>Depositor</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach($accountdeposits as $row)
                           <tr>
                              <td>{{ dateFormat($row->date) }}</td>
                              <td>{!! showAmount($row->amount) !!}</td>
                              <td>{{ $row->account->name }}</td>
                              <td>{{ $row->paymenttype->name }}</td>
                              <td>{{ $row->depositor }}</td>
                              <td>
                                <a href="#" class="btn btn-xs btn-dark"> <i class="far fa-edit"></i> view</a>
                              </td>
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

   $("#accountdeposit_form").submit(function(e) {
      e.preventDefault();
      $("#btn_accountdeposit").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding');
      $("#btn_accountdeposit").prop("disabled", true);
      $.ajax({
          url:'{{ route('webmaster.accountdeposit.store') }}',
          method: 'post',
          data: $(this).serialize(),
          dataType: 'json',
          success: function(response){
            if(response.status == 400){
              $.each(response.message, function (key, value) {
                showError(key, value);
              });
              $("#btn_accountdeposit").html('Add Account Deposit');
              $("#btn_accountdeposit").prop("disabled", false);
            } else if(response.status == 200){
               $("#accountdeposit_form")[0].reset();
              removeErrors("#accountdeposit_form");
              $("#btn_accountdeposit").html('Add Account Deposit');
              $("#btn_accountdeposit").prop("disabled", false);
              setTimeout(function(){
                window.location.reload();
              }, 1000);

            }
          }
        });
      });
</script>
@endsection
