@extends('member.partials.main')
@section('title')
    {{ $page_title }}
@endsection

@section('content')
   <div class="row">
      <div class="col-md-5 mx-auto">
         <div class="card">
            <div class="card-body">
               <h4 class="mb-3">Loan Request Form</h4>
               <form action="#" method="POST" id="loan_form"> 
                  @csrf
                  <div class="form-group">
                     <label for="type_id">Loan Type</label>
                     <select class="form-control" name="type_id" id="type_id">
                        <option value="">select loan type</option>
                        @foreach($types as $data)
                        <option value="{{ $data->id }}">{{ $data->title }}</option>
                        @endforeach
                     </select>
                     <span class="invalid-feedback"></span>
                  </div>
                  <div class="form-group">
                     <label for="request_amount">Request Amount</label>
                     <input type="text" name="request_amount" id="request_amount" class="form-control">
                     <span class="invalid-feedback"></span>
                  </div>
                  <div class="form-group">
                     <label for="reason">Request Reason</label>
                     <textarea name="reason" class="form-control" id="reason" rows="3"></textarea>
                     <span class="invalid-feedback"></span>
                  </div>
                  <div class="form-group mt-3">
                     <button type="submit" class="btn btn-block btn-info" id="btn_loan">Submit Request</button>
                  </div>
               </form>
            </div>
         </div>      
      </div>
   </div>
@endsection
@section('scripts')
   <script type="text/javascript">
      $("#loan_form").submit(function(e) {
        e.preventDefault();
        $("#btn_loan").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Submitting');
        $("#btn_loan").prop("disabled", true);
        $.ajax({
          url:'{{ route('member.loan.store') }}',
          method: 'post',
          data: $(this).serialize(),
          dataType: 'json',
          success: function(response){
            if(response.status == 400){
              $.each(response.message, function (key, value) {
                showError(key, value);
              });
              $("#btn_loan").html('Submit Request');
              $("#btn_loan").prop("disabled", false);
            } else if(response.status == 200){
              removeErrors("#loan_form");
              $("#btn_loan").html('Submit Request');
              $("#btn_loan").prop("disabled", false);
              setTimeout(function(){
                window.location.href = response.url;
              }, 1000);

            }
          }
        });
      });
   </script>
@endsection