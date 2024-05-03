@extends('webmaster.partials.main')
@section('title')
    {{ $page_title }}
@endsection
@section('content')
<div class="page-heading ">
   <div class="page-heading__title">
      <h3>{{ $page_title }}</h3>
   </div>
</div>
<div class="row">
         <div class="col-md-12">
            <div class="card">
               <div class="card-body">
                  <div class="clearfix mb-3">
                     <div class="float-left">
                        <h3 class="card-title">Account Types</h3>
                     </div>
                     <div class="float-right">
                        <button type="button" class="btn btn-sm btn-theme" data-toggle="modal" data-target="#accounttypeModel"> 
                           <i class="fa fa-plus"></i> Add Account Type
                        </button>
                        <div class="modal fade" id="accounttypeModel">
                           <div class="modal-dialog modal-dialog-centered" role="document">
                              <div class="modal-content">
                                 <div class="modal-body">
                                    <h4 class="card-title mb-4"> Account Type Form </h4>
                                    <form action="#" method="POST" id="accounttype_form"> 
                                      @csrf
                                      <div class="form-group">
                                          <label for="name">Account Type Name</label>
                                          <input type="text" name="name" id="name" class="form-control">
                                          <span class="invalid-feedback"></span>
                                       </div>
                                       <div class="form-group">
                                          <div class="custom-control custom-checkbox">
                                             <input type="checkbox" name="is_subaccount" class="custom-control-input" id="is_subaccount">
                                             <label class="custom-control-label" for="is_subaccount">Add as a Sub-Account</label>
                                          </div>
                                       </div>
                                       <div id="subAccountDiv" style="display: none">
                                          <div class="form-group">
                                          <label for="parent_id">Select Parent Account</label>
                                          <select class="form-control" name="parent_id" id="parent_id">
                                             <option value="">select parent account</option>
                                             @foreach($accounttypes as $data)
                                             <option value="{{ $data->id }}">{{ $data->name }}</option>
                                             @endforeach
                                          </select>
                                       </div>
                                       </div>
                                       <div class="form-group">
                                          <label for="description">Account Type Description</label>
                                          <textarea name="description" class="form-control" id="description" rows="3"></textarea>
                                          <span class="invalid-feedback"></span>
                                       </div>
                                        <div class="form-group">
                                           <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
                                           <button type="submit" class="btn btn-sm btn-theme" id="btn_accounttype">Add Account Type</button>
                                        </div>
                                     </form>
                                  </div>
                               </div>
                            </div>
                         </div>
                     </div>
                  </div>
                  @if($accounttypes->count() > 0)
                  <div class="table-responsive">
                     <table class="table table-sm mb-0">
                        <thead>
                           <tr>
                              <th>Account Type</th>
                              <th>Description</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach($accounttypes as $row)
                           <tr>
                              <td>{{ $row->name }}</td>
                              <td>{{ $row->description }}</td>
                              <td> 
                                <a href="#" class="btn btn-xs btn-dark"> <i class="far fa-edit"></i> Edit</a>
                              </td>
                           <tr>
                           @php
                           $subaccounts = \App\Models\ChartOfAccountType::where('is_subaccount', 1)->where('parent_id', $row->id)->get();
                           @endphp
                           @foreach($subaccounts as $subaccount)
                           <tr>
                              <td style="padding-left: 30px;">{{ $subaccount->name }}</td>
                              <td>{{ $subaccount->description }}</td>
                              <td> 
                                 <a href="#" class="btn btn-xs btn-dark"> <i class="far fa-edit"></i> Edit</a>
                              </td>
                           </tr>
                           @endforeach
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
   
   $('input[name="is_subaccount"]').on('change', function() {
      if ($(this).prop('checked')) {
         $('#subAccountDiv').show();
      } else {
         $('#subAccountDiv').hide();
      }
   });

      $("#accounttype_form").submit(function(e) {
        e.preventDefault();
        $("#btn_accounttype").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding');
        $("#btn_v").prop("disabled", true);
        $.ajax({
          url:'{{ route('webmaster.accounttype.store') }}',
          method: 'post',
          data: $(this).serialize(),
          dataType: 'json',
          success: function(response){
            if(response.status == 400){
              $.each(response.message, function (key, value) {
                showError(key, value);
              });
              $("#btn_accounttype").html('Add Account Type');
              $("#btn_accounttype").prop("disabled", false);
            } else if(response.status == 200){
               $("#accounttype_form")[0].reset();
              removeErrors("#accounttype_form");
              $("#btn_accounttype").html('Add Account Type');
              $("#btn_accounttype").prop("disabled", false);
              setTimeout(function(){
                window.location.reload();
              }, 1000);

            }
          }
        });
      });
</script>
@endsection