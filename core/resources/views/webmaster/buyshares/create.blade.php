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
                     <h3 class="card-title">Share Information</h3>
                  </div>
                  <div class="float-right">
                     <a href="{{ route('webmaster.buyshares') }}" class="btn btn-sm btn-theme"> <i class="fa fa-eye"></i> View Shares</a>
                  </div>
               </div>
               <form action="#" method="POST" id="share_form"> 
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
                        <label for="share_id" class="form-label">Share Category</label>
                        <select class="form-control" name="share_id" id="share_id">
                           <option value="">select share category</option>
                           @foreach($shares as $data)
                           <option value="{{ $data->id }}">{{ $data->name }}</option>
                           @endforeach
                        </select>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="unit_buy_price" class="form-label">Share Buy Price</label>
                        <input type="text" name="unit_buy_price" id="unit_buy_price" class="form-control" readonly>
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="total_share" class="form-label">Total Shares for Buying</label>
                        <input type="text" name="total_share" id="total_share" class="form-control">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="total_amount" class="form-label">Total Amount</label>
                        <input type="text" name="total_amount" id="total_amount" class="form-control" readonly>
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
               </div>
               <div class="row mt-2">
                  <div class="col-sm-9">
                     <button type="submit" class="btn btn-theme" id="btn_share">Add Share</button>
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

   $('#share_id').change(function() {
      let share_id = $(this).val();
      if (share_id === "") {
         share_id = 0;
      }
      let url = `${baseurl}/webmaster/buyshare/share/${share_id}`;
      $.get(url, function(response){
         $("#unit_buy_price").val(response.unit_price);
         $('#total_share').trigger('input');
      });
   });

   $('#total_share').on('input', function() {
      let total_share = parseFloat($('#total_share').val()) || 0;
      let unit_buy_price = parseFloat($('#unit_buy_price').val()) || 0;
      let total_amount = total_share * unit_buy_price;
      $("#total_amount").val(isNaN(total_amount) ? '' : total_amount);
   });

   $("#share_form").submit(function(e) {
        e.preventDefault();
        $("#btn_share").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding');
        $("#btn_share").prop("disabled", true);
        $.ajax({
          url:'{{ route('webmaster.buyshare.store') }}',
          method: 'post',
          data: $(this).serialize(),
          dataType: 'json',
          success: function(response){
            if(response.status == 400){
              $.each(response.message, function (key, value) {
                showError(key, value);
              });
              $("#btn_share").html('Add Share');
              $("#btn_share").prop("disabled", false);
            } else if(response.status == 200){
               $("#share_form")[0].reset();
              removeErrors("#share_form");
              $("#btn_share").html('Add Share');
              $("#btn_share").prop("disabled", false);
              setTimeout(function(){
                window.location.href = response.url;
              }, 1000);

            }
          }
        });
      });
</script>
@endsection