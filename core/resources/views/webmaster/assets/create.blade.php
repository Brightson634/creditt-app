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
      <div class="col-xl-12 mx-auto">
         <div class="card">
            <div class="card-body">
               <div class="clearfix mb-3">
                  <div class="float-left">
                     <h3 class="card-title">Asset Information</h3>
                  </div>
                  <div class="float-right">
                     <a href="{{ route('webmaster.assets') }}" class="btn btn-dark btn-sm btn-theme"> <i class="fa fa-eye"></i> View Assets</a>
                  </div>
               </div>
               <form action="#" method="POST" id="asset_form">
               @csrf
               <div class="row">
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="asset_no" class="form-label">Asset No:</label>
                        <input type="text" name="asset_no" id="asset_no" class="form-control" value="{{ $asset_no }}" readonly>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="name" class="form-label">Asset Name:</label>
                        <input type="text" name="name" id="name" class="form-control">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                  <label for="assetgroup_id" class="col-label">Asset Group</label>
                     <select class="form-control" name="assetgroup_id" id="assetgroup_id">
                           <option value="">select asset group</option>
                           @foreach($assetgroups as $data)
                           <option value="{{ $data->id }}">{{ $data->name }}</option>
                           @endforeach
                        </select>
                       <span class="invalid-feedback"></span>
               </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="serial_no" class="form-label">Asset Serial/Model</label>
                        <input type="text" name="serial_no" id="serial_no" class="form-control">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="cost_price" class="form-label">Asset Cost Price:</label>
                        <input type="text" name="cost_price" id="cost_price" class="form-control">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="purchase_date" class="form-label">Asset Purchase Date</label>
                        <input type="text" name="purchase_date" class="form-control" data-provide="datepicker" data-date-autoclose="true" data-date-format="yyyy-mm-dd" id="purchase_date" autocomplete="off">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="staff_id" class="form-label">Asset Managed By</label>
                        <select class="form-control" name="staff_id" id="staff_id">
                           <option value="">select staff member</option>
                           @foreach($staffs as $data)
                           <option value="{{ $data->id }}">{{ $data->salutation }} {{ $data->fname }} {{ $data->lname }} - {{ $data->staff_no }}</option>
                           @endforeach
                        </select>
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="location" class="form-label">Asset Location</label>
                        <input type="text" name="location" class="form-control" id="location" autocomplete="off">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="warrant_period" class="form-label">Warrant Period (in months)</label>
                        <input type="text" name="warrant_period" class="form-control" id="warrant_period" autocomplete="off">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="depreciation_period" class="form-label">Depreciation Period (in months)</label>
                        <input type="text" name="depreciation_period" id="depreciation_period" class="form-control">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="depreciation_amount" class="form-label">Depreciation Amount</label>
                        <input type="text" name="depreciation_amount" id="depreciation_amount" class="form-control">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="supplier_id" class="form-label">Supplier</label>
                        <select class="form-control" name="supplier_id" id="supplier_id">
                           <option value="">select supplier</option>
                           @foreach($suppliers as $data)
                           <option value="{{ $data->id }}">{{ $data->name }} - {{ $data->supplier_no }}</option>
                           @endforeach
                        </select>
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
               </div>
               <div class="row mt-2">
                  <div class="col-sm-9">
                     <button type="submit" class="btn btn-primary btn-theme" id="btn_asset">Add Asset</button>
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

   $("#asset_form").submit(function(e) {
        e.preventDefault();
        $("#btn_asset").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding');
        $("#btn_asset").prop("disabled", true);
        $.ajax({
          url:'{{ route('webmaster.asset.store') }}',
          method: 'post',
          data: $(this).serialize(),
          dataType: 'json',
          success: function(response){
            if(response.status == 400){
              $.each(response.message, function (key, value) {
                showError(key, value);
              });
              $("#btn_asset").html('Add Asset');
              $("#btn_asset").prop("disabled", false);
            } else if(response.status == 200){
               $("#asset_form")[0].reset();
              removeErrors("#asset_form");
              $("#btn_asset").html('Add Asset');
              $("#btn_asset").prop("disabled", false);
              setTimeout(function(){
                window.location.href = response.url;
              }, 1000);

            }
          }
        });
      });
</script>
@endsection
