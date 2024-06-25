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
                     <h3 class="card-title">Share Information</h3>
                  </div>
                  <div class="float-right">
                     <a href="{{ route('webmaster.shares') }}" class="btn btn-dark btn-sm btn-theme"> <i class="fa fa-eye"></i> View Shares</a>
                  </div>
               </div>
               <form action="#" method="POST" id="share_form">
               @csrf
               <div class="row">
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="name" class="form-label">Share Category</label>
                        <input type="text" name="name" id="name" class="form-control">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="unit_price" class="form-label">Unit Price of Share</label>
                        <input type="text" name="unit_price" id="unit_price" class="form-control">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="total_share" class="form-label">Number of Shares</label>
                        <input type="text" name="total_share" id="total_share" class="form-control">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="min_total_share" class="form-label">Mimimum Shares for Buying</label>
                        <input type="text" name="min_total_share" id="min_total_share" class="form-control">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="max_total_share" class="form-label">Maximum Shares for Buying</label>
                        <input type="text" name="max_total_share" id="max_total_share" class="form-control">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="min_buy_price" class="form-label">Minimum Buy Price</label>
                         <input type="text" name="min_buy_price" id="min_buy_price" class="form-control">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
               </div>
               <div class="row mt-2">
                  <div class="col-sm-9">
                     <button type="submit" class="btn btn-primary btn-theme" id="btn_share">Add Share</button>
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

   $("#share_form").submit(function(e) {
        e.preventDefault();
        $("#btn_share").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding');
        $("#btn_share").prop("disabled", true);
        $.ajax({
          url:'{{ route('webmaster.share.store') }}',
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
