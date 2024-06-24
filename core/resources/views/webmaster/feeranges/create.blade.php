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
      <div class="col-xl-9 mx-auto">
         <div class="card">
            <div class="card-body">
               <div class="clearfix mb-3">
                  <div class="float-left">
                     <h3 class="card-title">Fee Range Information</h3>
                  </div>
                  <div class="float-right">
                     <a href="{{ route('webmaster.feeranges') }}" class="btn btn-sm btn-theme"> <i class="fa fa-eye"></i> View Ranges</a>
                  </div>
               </div>
               <form action="#" method="POST" id="fee_form">
               @csrf
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="fee_id" class="form-label">Fee</label>
                        <select class="form-control" name="fee_id" id="fee_id">
                           <option value="">select fee</option>
                           @foreach($fees as $data)
                           <option value="{{ $data->id }}">{{ $data->name }}</option>
                           @endforeach
                        </select>
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="min_amount" class="form-label">Minimum Amount</label>
                        <input type="text" name="min_amount" id="min_amount" class="form-control">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
               </div>
                <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="max_amount" class="form-label">Maximum Amount</label>
                        <input type="text" name="max_amount" id="max_amount" class="form-control">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="text" name="amount" id="amount" class="form-control">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
               </div>

               <div class="form-group row mt-3">
                  <div class="col-sm-9">
                     <button type="submit" class="btn btn-theme" id="btn_fee">Add Range</button>
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
   "use strict";

   $("#fee_form").submit(function(e) {
        e.preventDefault();
        $("#btn_fee").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding');
        $("#btn_fee").prop("disabled", true);
        $.ajax({
          url:'{{ route('webmaster.feerange.store') }}',
          method: 'post',
          data: $(this).serialize(),
          dataType: 'json',
          success: function(response){
            if(response.status == 400){
              $.each(response.message, function (key, value) {
                showError(key, value);
              });
              $("#btn_fee").html('Add Range');
              $("#btn_fee").prop("disabled", false);
            } else if(response.status == 200){
               $("#fee_form")[0].reset();
              removeErrors("#fee_form");
              $("#btn_fee").html('Add Range');
              $("#btn_fee").prop("disabled", false);
              setTimeout(function(){
                window.location.href = response.url;
              }, 1000);

            }
          }
        });
      });
</script>
@endsection
