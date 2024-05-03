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
                     <h3 class="card-title">Journal Entry Information</h3>
                  </div>
                  <div class="float-right">
                     <a href="{{ route('webmaster.journalentries') }}" class="btn btn-sm btn-theme"> <i class="fa fa-eye"></i> View Journal Entries</a>
                  </div>
               </div>
               <form action="#" method="POST" id="journal_form"> 
               @csrf
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="journal_no" class="form-label">Journal Number</label>
                        <input type="text" name="journal_no" id="journal_no" class="form-control" value="{{ $journalno }}" readonly>
                     </div>
                  </div>
                  <div class="col-md-6">
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
                        <label for="description" class="form-label">Description</label>
                        <textarea type="text" name="description" id="description" class="form-control" rows="3"> </textarea>
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
               </div>
               <table class="table table-sm mb-2">
                  <thead>
                     <tr>
                        <th>Account</th>
                        <th>Debit Amount</th>
                        <th>Credit Amount</th>
                        <th><a href="javascript:void(0);" class="add_button btn btn-icon btn-sm btn-primary"><i class="fa fa-plus"></i></a></th>
                     </tr>
                  </thead>
                  <tbody class="field_wrapper">
                     <tr class="item">
                        <td>
                           <select class="form-control" name="account_id[]">
                              <option>---</option>
                              @foreach($accounts as $data)
                              <option value="{{ $data->id }}">{{ $data->code }} - {{ $data->name }}</option>
                              @endforeach
                           </select>
                        </td>
                        <td> 
                           <input type="text" class="form-control debit_amount" name="debit_amount[]" autocomplete="off">
                        </td>
                        <td> 
                           <input type="text" class="form-control credit_amount" name="credit_amount[]" autocomplete="off">
                        </td>
                        <td> <a href="javascript:void(0);" class="remove_button btn btn-icon btn-sm btn-danger"><i class="fa fa-trash"></i></a> </td>
                     </tr>
                  </tbody>
                  <tfoot>
                     <tr>
                        <td><strong>Total</strong></td>
                        <td>
                           <input type="text" name="total_debit" class="form-control" id="total_debit" readonly>
                        </td>
                        <td>
                           <input type="text" name="total_credit" class="form-control" id="total_credit" readonly>
                        </td>
                        <td> </td>
                     </tr>
                  </tfoot>
               </table>
               <div class="row mt-2">
                  <div class="col-sm-9">
                     <button type="submit" class="btn btn-theme" id="btn_journal">Add Journal Entry</button>
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

   $(document).on('keyup', '.debit_amount', function() {
      calculateDebitTotal($(this));
   });
   $(document).on('keyup', '.credit_amount', function() {
      calculateCreditTotal($(this));
   });

   var add_button = $('.add_button');
   var wrap = $('.field_wrapper');
   var html_field = '<tr class="item"><td><select name="account_id[]" class="form-control"><option value="">---</option>@foreach($accounts as $data)<option value="{{ $data->id }}">{{ $data->code }} - {{ $data->name }}</option>@endforeach</select></td> <td><input type="text" class="form-control debit_amount" name="debit_amount[]" autocomplete="off"></td> <td><input type="text" class="form-control credit_amount" name="credit_amount[]" autocomplete="off"></td> <td> <a href="javascript:void(0);" class="remove_button btn btn-icon btn-sm btn-danger"><i class="fa fa-trash"></i></a> </td></tr>';
   var x = 1;
   $(add_button).click(function(){
      x++;
      $(wrap).append(html_field);
   });
   $(wrap).on('click', '.remove_button', function(e){
      e.preventDefault();
      $(this).closest('tr').remove();
      x--;
      calculateDebitTotal($(this));
      calculateCreditTotal($(this));
   });

   function calculateDebitTotal(input) {
      let el = input.closest('tr');
      let debit = input.val();
      let credit = 0;
      el.find('.credit_amount').val(credit);
      el.find('.credit_amount').attr("readonly", true);
      let totalDebit = 0;
      $('.debit_amount').each(function() {
         let debitAmount = parseFloat($(this).val()) || 0;
         totalDebit += debitAmount;
      });
      $('#total_debit').val(totalDebit);
      if (debit == '') {
         el.find('.credit_amount').attr("readonly", false);
         el.find('.credit_amount').val('');
      }
   }

   function calculateCreditTotal(input) {
      let el = input.closest('tr');
      let credit = input.val();
      let debit = 0;
      el.find('.debit_amount').val(debit);
      el.find('.debit_amount').attr("readonly", true);
      let totalCredit = 0;
      $('.credit_amount').each(function() {
         let creditAmount = parseFloat($(this).val()) || 0;
         totalCredit += creditAmount;
      });
      $('#total_credit').val(totalCredit);
      if (credit == '') {
         el.find('.debit_amount').attr("readonly", false);
         el.find('.debit_amount').val('');
      }
   };

   $("#journal_form").submit(function(e) {
      e.preventDefault();
      var total_debit    = $("input[name=total_debit]").val();
      var total_credit   = $("input[name=total_credit]").val()

      if(total_debit != total_credit){
         Swal.fire({
           type: 'error',
           title: 'Oops...',
           text: 'Total Debit Amount is equal to Total Credit Amount',
           confirmButtonClass: 'btn btn-confirm mt-2',
       })

      }else {
      $("#btn_journal").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding');
      $("#btn_journal").prop("disabled", true);
      $.ajax({
         url:'{{ route('webmaster.journalentry.store') }}',
         method: 'post',
         data: $(this).serialize(),
         dataType: 'json',
         success: function(response){
            if(response.status == 400){
              $.each(response.message, function (key, value) {
                showError(key, value);
              });
              $("#btn_journal").html('Add Journal Entry');
              $("#btn_journal").prop("disabled", false);
            } else if(response.status == 200){
               $("#journal_form")[0].reset();
              removeErrors("#journal_form");
              $("#btn_journal").html('Add Journal Entry');
              $("#btn_journal").prop("disabled", false);
              setTimeout(function(){
                window.location.href = response.url;
              }, 1000);

            }
         }
      });
      }
   });
</script>
@endsection