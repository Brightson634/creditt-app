@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection
@section('content')
<div class="page-heading ">
   {{-- <div class="page-heading__title">
      <h3>{{ $page_title }}</h3>
   </div> --}}
</div>
<div class="row">
         <div class="col-md-12">
            <div class="card">
               <div class="card-body">
                  <div class="clearfix mb-3">
                     <div class="float-left">
                        <h3 class="card-title">Account Transfers</h3>
                     </div>
                     <div class="float-right">
                        <button type="button" class="btn btn-dark btn-sm btn-theme" data-toggle="modal" data-target="#accounttransferModel">
                           <i class="fa fa-plus"></i> Add Account Transfer
                        </button>
                        <div class="modal fade" id="accounttransferModel">
                           <div class="modal-dialog modal-dialog-centered" role="document">
                              <div class="modal-content">
                                 <div class="modal-body">
                                    <h4 class="card-title mb-4"> Account Transfer Form </h4>
                                    <form action="#" method="POST" id="accounttransfer_form">
                                      @csrf
                                       <div class="form-group">
                                          <label for="debit_account">Debit Account</label>
                                          <select class="form-control" name="debit_account" id="debit_account">
                                             <option value="">select debit account</option>
                                             @foreach($accounts as $data)
                                             <option value="{{ $data->id }}">{{ $data->code }} - {{ $data->name }}</option>
                                             @endforeach
                                          </select>
                                          <span class="invalid-feedback"></span>
                                       </div>
                                       <div class="form-group">
                                          <label for="credit_account">Credit Account</label>
                                          <select class="form-control" name="credit_account" id="credit_account">
                                             <option value="">select credit account</option>
                                          </select>
                                          <span class="invalid-feedback"></span>
                                       </div>
                                       <div class="form-group">
                                          <label for="amount">Amount</label>
                                          <input type="text" name="amount" id="amount" class="form-control">
                                          <span class="invalid-feedback"></span>
                                       </div>

                                       <div class="form-group">
                                          <label for="description">Description</label>
                                          <textarea name="description" class="form-control" id="description" rows="3"></textarea>
                                          <span class="invalid-feedback"></span>
                                       </div>
                                       <div class="form-group">
                                          <label for="date" class="form-label">Transaction Date</label>
                                          <input type="text" name="date" class="form-control" data-provide="datepicker" data-date-autoclose="true" data-date-format="yyyy-mm-dd" id="date" value="{{ now()->format('Y-m-d') }}" autocomplete="off">
                                          <span class="invalid-feedback"></span>
                                       </div>
                                        <div class="form-group">
                                           <button type="button" class="btn btn-danger btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
                                           <button type="submit" class="btn btn-primary btn-sm btn-theme" id="btn_accounttransfer">Add Account Transfer</button>
                                        </div>
                                     </form>
                                  </div>
                               </div>
                            </div>
                         </div>
                     </div>
                  </div>
                  @if($accounttransfers->count() > 0)
                  <div class="table-responsive">
                     <table class="table table-sm mb-0">
                        <thead>
                           <tr>
                              <th>Date</th>
                              <th>Amount</th>
                              <th>Debit Account</th>
                              <th>Credit Account</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach($accounttransfers as $row)
                           <tr>
                              <td>{{ dateFormat($row->date) }}</td>
                              <td>{!! showAmount($row->amount) !!}</td>
                              <td>{{ $row->debitaccount->name }}</td>
                               <td>{{ $row->creditaccount->name }}</td>
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
   $('#debit_account').change(function() {
      var debit_account = $(this).val();
      let url = `${baseurl}/webmaster/accounttransfer/getcreditaccounts/${debit_account}`;
      $.get(url, function(response){
         $("#credit_account").html(response);
      });
   });

   $("#accounttransfer_form").submit(function(e) {
      e.preventDefault();
      $("#btn_accounttransfer").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding');
      $("#btn_accounttransfer").prop("disabled", true);
      $.ajax({
          url:'{{ route('webmaster.accounttransfer.store') }}',
          method: 'post',
          data: $(this).serialize(),
          dataType: 'json',
          success: function(response){
            if(response.status == 400){
              $.each(response.message, function (key, value) {
                showError(key, value);
              });
              $("#btn_accounttransfer").html('Add Account Transfer');
              $("#btn_accounttransfer").prop("disabled", false);
            } else if(response.status == 200){
               $("#accounttransfer_form")[0].reset();
              removeErrors("#accounttransfer_form");
              $("#btn_accounttransfer").html('Add Account Transfer');
              $("#btn_accounttransfer").prop("disabled", false);
              setTimeout(function(){
                window.location.reload();
              }, 1000);

            }
          }
        });
      });
</script>
@endsection
