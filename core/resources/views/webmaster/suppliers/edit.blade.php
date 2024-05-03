@extends('backend.partials.main')
@section('title')
    {{ $page_title }}
@endsection
@section('content')
   <div class="row">
      <div class="col-xl-9 mx-auto">
                            <div class="card">
                                <div class="card-body">
                                  <div class="clearfix mb-1">
                                    <div class="float-left">
                     <h4 class="card-title">{{ $page_title }}</h4>
                  </div>
                 @if(hasAccess('supplier.view'))
                  <div class="float-right">
                     <a href="{{ route('admin.suppliers') }}" class="btn btn-sm btn-info"><i class="fa fa-eye"></i> View Suppliers</a>
                  </div>
                  @endif
                 
               </div>
                                    <form action="#" method="POST" id="supplier_form"> 
                                      @csrf
                                      <input type="hidden" name="id" class="form-control" value="{{ $supplier->id }}">
                                        <div class="form-group">
                                            <label for="name">Supplier Name</label>
                                            <input type="text" name="name" id="name" class="form-control" value="{{ $supplier->name }}">
                                            <span class="invalid-feedback"></span>
                                        </div>

                                        <div class="form-group">
                                            <label for="telephone">Supplier Telephone</label>
                                            <input type="text" name="telephone" id="telephone" class="form-control" value="{{ $supplier->telephone }}">
                                            <span class="invalid-feedback"></span>
                                        </div>

                                        <div class="form-group">
                                            <label for="address">Supplier Address</label>
                                            <textarea name="address" class="form-control" id="address" rows="3">{{ $supplier->address }}</textarea>
                                            <span class="invalid-feedback"></span>
                                        </div>

                                        <div class="form-group mb-0">
                                           <button type="submit" class="btn btn-info" id="btn_supplier">Update Supplier</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                           
                        </div> 
                        
                        </div>
   

@endsection

 
@section('scripts')
<script type="text/javascript">
  $(function() {
      $("#supplier_form").submit(function(e) {
        e.preventDefault();
        $("#btn_supplier").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Updating');
        $("#btn_supplier").prop("disabled", true);
        $.ajax({
          url:'{{ route('admin.supplier.update') }}',
          method: 'post',
          data: $(this).serialize(),
          dataType: 'json',
          success: function(response){
            if(response.status == 400){
              $.each(response.message, function (key, value) {
                showError(key, value);
              });
              $("#btn_supplier").html('Update Supplier');
              $("#btn_supplier").prop("disabled", false);
            } else if(response.status == 200){
              removeErrors("#supplier_form");
              $("#btn_supplier").html('Update Supplier');
              $("#btn_supplier").prop("disabled", false);
              setTimeout(function(){
                window.location.href = response.url;
              }, 500);

            }
          }
        });
      });
  });
</script>
@endsection