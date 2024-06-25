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
                     <h3 class="card-title">Supplier Information</h3>
                  </div>
                  <div class="float-right">
                     <a href="{{ route('webmaster.suppliers') }}" class="btn btn-dark btn-sm btn-theme"> <i class="fa fa-eye"></i> View Suppliers</a>
                  </div>
               </div>
               <form action="#" method="POST" id="supplier_form">
               @csrf
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="supplier_no" class="form-label">Supplier No:</label>
                        <input type="text" name="supplier_no" id="supplier_no" class="form-control" value="{{ $supplier_no }}" readonly>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="name" class="form-label">Supplier Name:</label>
                        <input type="text" name="name" id="name" class="form-control">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="telephone" class="form-label">Telephone</label>
                        <input type="text" name="telephone" id="telephone" class="form-control">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="address" class="form-label">Address</label>
                         <input type="text" name="address" id="address" class="form-control">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
               </div>
               <div class="row mt-2">
                  <div class="col-sm-9">
                     <button type="submit" class="btn btn-primary btn-theme" id="btn_supplier">Add Supplier</button>
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

   $("#supplier_form").submit(function(e) {
        e.preventDefault();
        $("#btn_supplier").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding');
        $("#btn_supplier").prop("disabled", true);
        $.ajax({
          url:'{{ route('webmaster.supplier.store') }}',
          method: 'post',
          data: $(this).serialize(),
          dataType: 'json',
          success: function(response){
            if(response.status == 400){
              $.each(response.message, function (key, value) {
                showError(key, value);
              });
              $("#btn_supplier").html('Add Supplier');
              $("#btn_supplier").prop("disabled", false);
            } else if(response.status == 200){
               $("#supplier_form")[0].reset();
              removeErrors("#supplier_form");
              $("#btn_supplier").html('Add Supplier');
              $("#btn_supplier").prop("disabled", false);
              setTimeout(function(){
                window.location.href = response.url;
              }, 1000);

            }
          }
        });
      });
</script>
@endsection
