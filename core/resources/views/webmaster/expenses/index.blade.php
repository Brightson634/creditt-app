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
      <div class="col-xl-12 mx-auto">
         <div class="card">
            <div class="card-body">
               <div class="clearfix mb-3">
                  <div class="float-left">
                     <h3 class="card-title">{{ $page_title }}</h3>
                  </div>
                  <div class="float-right">
                     <a href="{{ route('webmaster.expense.create') }}" class="btn btn-sm btn-theme"> <i class="fa fa-plus"></i> Add Expense</a>
                  </div>
               </div>
               @if($expenses->count() > 0)
               <div class="table-responsive">
                  <table class="table table-sm mb-0">
                     <thead>
                        <tr>
                           <th>#</th>
                           <th>Expense</th>
                           <th>Category</th>
                           <th>Amount</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @php $i = 0 @endphp
                        @foreach($expenses as $row)
                        @php $i++ @endphp
                        <tr>
                           <th>{{ $i }}</th>
                           <td>{{ $row->name }}</td>
                           <td>{{ $row->subcategory->name }}</td>
                           <td>{!! showAmount($row->amount) !!}</td>
                           <td>
                             <a href="#{{ route('webmaster.expense.edit', $row->id) }}" class="btn btn-xs btn-dark"> <i class="far fa-edit"></i></a>
                           </td>
                           <td>
                             <a href="javascript:void(0)" class="btn btn-xs btn-info" data-toggle="modal" data-target="#refundModel{{ $row->id }}"> <i class="far fa-eye"></i> Refund</a>
                             <div class="modal fade" id="refundModel{{ $row->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                 <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                       <div class="modal-body">
                                          <h4 class="card-title mb-4"> Expense Information </h4>
                                          <div class="mb-4">
                                             <p class="mb-2"><strong>Expense: </strong> {{ $row->name }}</p>
                                             <p class="mb-2"><strong>Category: </strong>{{ $row->category->name }} / {{ $row->subcategory->name }}</p>
                                             <p class="mb-2"><strong>Amount: </strong> {!! showAmount($row->amount) !!}</p>
                                             <p class="mb-2"><strong>Date: </strong> {{ dateFormat($row->date) }}</p>
                                             <p class="mb-2"><strong>Account: </strong>{{ $row->account->name }}</p>
                                          </div>

                                          <h4 class="card-title mb-3"> Refund Information</h4>
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
                        <label for="account_id" class="form-label">Payment Account</label>
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
                        <label for="email" class="form-label">Paid on</label>
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




                                          <div class="float-right">
                                           <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
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

   $("#expense_form").submit(function(e) {
        e.preventDefault();
        $("#btn_expense").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding');
        $("#btn_expense").prop("disabled", true);
        $.ajax({
          url:'{{ route('webmaster.expenserefund.store') }}',
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
