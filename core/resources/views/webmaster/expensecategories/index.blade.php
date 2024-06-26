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
                        <h3 class="card-title">Expense Categories</h3>
                     </div>
                     <div class="float-right">
                        <button type="button" class="btn btn-sm btn-theme" data-toggle="modal" data-target="#categoryModel"> 
                           <i class="fa fa-plus"></i> Add Category
                        </button>
                        <div class="modal fade" id="categoryModel">
                           <div class="modal-dialog modal-dialog-centered" role="document">
                              <div class="modal-content">
                                 <div class="modal-body">
                                    <h4 class="card-title mb-4"> Category Information Form</h4>
                                    <form action="#" method="POST" id="category_form"> 
                                      @csrf
                                      <div class="form-group">
                                          <label for="name">Name</label>
                                          <input type="text" name="name" id="name" class="form-control">
                                          <span class="invalid-feedback"></span>
                                       </div>
                                       <div class="form-group">
                                          <label for="code">Code</label>
                                          <input type="text" name="code" id="code" class="form-control">
                                          <span class="invalid-feedback"></span>
                                       </div>
                                       <div class="form-group">
                                          <div class="custom-control custom-checkbox">
                                             <input type="checkbox" name="is_subcat" class="custom-control-input" id="is_subcat">
                                             <label class="custom-control-label" for="is_subcat">Add as Sub-Category</label>
                                          </div>
                                       </div>
                                       <div id="subCatDiv" style="display: none">
                                          <div class="form-group">
                                          <label for="parent_id">Select Parent Category</label>
                                          <select class="form-control" name="parent_id" id="parent_id">
                                             <option value="">select parent category</option>
                                             @foreach($categories as $data)
                                             <option value="{{ $data->id }}">{{ $data->name }}</option>
                                             @endforeach
                                          </select>
                                       </div>
                                       </div>
                                       <div class="form-group">
                                          <label for="description">Description</label>
                                          <textarea name="description" class="form-control" id="description" rows="3"></textarea>
                                          <span class="invalid-feedback"></span>
                                       </div>
                                        <div class="form-group">
                                           <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
                                           <button type="submit" class="btn btn-sm btn-theme" id="btn_category">Add Category</button>
                                        </div>
                                     </form>
                                  </div>
                               </div>
                            </div>
                         </div>






                     </div>
                  </div>
                  @if($categories->count() > 0)
                  <div class="table-responsive">
                     <table class="table table-sm mb-0">
                        <thead>
                           <tr>
                              <th>Category</th>
                              <th>Code</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           @php $i = 0; @endphp
                           @foreach($categories as $row)
                           <tr>
                              <td>{{ $row->name }}</td>
                              <td>{{ $row->code }}</td>
                              <td> 
                                <a href="#" class="btn btn-xs btn-dark"> <i class="far fa-edit"></i> Edit</a>
                              </td>
                           <tr>
                           @php
                           $subcategories = \App\Models\ExpenseCategory::where('is_subcat', 1)->where('parent_id', $row->id)->get();
                           @endphp
                           @foreach($subcategories as $subcat)
                           <tr>
                              <td style="padding-left: 30px;">{{ $subcat->name }}</td>
                              <td>{{ $subcat->code }}</td>
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

   $('input[name="is_subcat"]').on('change', function() {
      if ($(this).prop('checked')) {
         $('#subCatDiv').show();
      } else {
         $('#subCatDiv').hide();
      }
   });

      $("#category_form").submit(function(e) {
        e.preventDefault();
        $("#btn_category").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding');
        $("#btn_v").prop("disabled", true);
        $.ajax({
          url:'{{ route('webmaster.expensecategory.store') }}',
          method: 'post',
          data: $(this).serialize(),
          dataType: 'json',
          success: function(response){
            if(response.status == 400){
              $.each(response.message, function (key, value) {
                showError(key, value);
              });
              $("#btn_category").html('Add Category');
              $("#btn_category").prop("disabled", false);
            } else if(response.status == 200){
               $("#category_form")[0].reset();
              removeErrors("#category_form");
              $("#btn_category").html('Add Category');
              $("#btn_category").prop("disabled", false);
              setTimeout(function(){
                window.location.reload();
              }, 1000);

            }
          }
        });
      });
</script>
@endsection