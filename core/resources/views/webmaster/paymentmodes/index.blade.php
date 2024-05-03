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
   <div class="col-xl-12">
      <div class="card-body">
         <div class="tab-content">
            <div class="tab-pane show active">
              <div class="card">
            <div class="card-body">
              
               <div class="clearfix mb-3">
                  <div class="float-left">
                     <h4 class="card-title">Payment Modes</h4>
                  </div>
                  <div class="float-right">
                     <button type="button" class="btn btn-sm btn-theme" data-toggle="modal" data-target="#positionModel">
                           <i class="fa fa-plus"></i>             Add Payment Mode
                                    </button>
                     <div class="modal fade" id="positionModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">                                                
                                                <div class="modal-body">
                                                    <h4 class="card-title mb-4"> Add Payment Mode</h4>
                                                    <form action="#" method="POST" id="category_form"> 
                                      @csrf
                                                      
                                         <div class="form-group">
                     <label for="name">Title</label>
                     <input type="text" name="name" id="name" class="form-control">
                     <span class="invalid-feedback"></span>
                  </div>
                  <div class="form-group">
                     <label for="description">Description</label>
                     <textarea name="description" class="form-control" id="description" rows="3"></textarea>
                     <span class="invalid-feedback"></span>
                  </div>
                                        

                                        <div class="form-group">
                                           <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
                                           <button type="submit" class="btn btn-sm btn-theme" id="btn_category">Add Payment Mode</button>
                                        </div>
                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                  </div>
               </div>
               <div class="table-responsive">
                  <table class="table table-sm mb-0">
                     <thead>
                        <tr>
                           <th>#</th>
                           <th>Payment Mode</th>
                           <th>Description</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @php $i = 0; @endphp
                        @foreach($paymentmodes as $row)
                        @php $i++; @endphp
                        <tr>
                           <th scope="row">{{ $i }}</th>
                           <td>{{ $row->name }}</td>
                           <td>{{ $row->description }}</td>
                           <td>
                            <a href="javascript:void(0)" data-toggle="modal" data-target="#editModel{{ $row->id }}" class="btn btn-xs btn-dark"> <i class="far fa-edit"></i></a>
                           <div class="modal fade" id="editModel{{ $row->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">                                                
                                                <div class="modal-body">
                                                    <h4 class="card-title mb-4"> Edit Share Category</h4>
                                                    <form action="#" method="POST" class="edit_form">
                                      @csrf
                                      <input type="hidden" name="id" class="form-control" value="{{ $row->id}}">
<div class="form-group">
                     <label for="name">Category Name</label>
                     <input type="text" name="name" id="name" class="form-control" value="{{ $row->name }}">
                     <span class="invalid-feedback"></span>
                  </div>
                  <div class="form-group">
                     <label for="description">Description</label>
                     <textarea name="description" class="form-control" id="description" rows="3">{{ $row->description }}</textarea>
                     <span class="invalid-feedback"></span>
                  </div>

                                        <div class="form-group">
                                           <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
                                           <button type="submit" class="btn btn-sm btn-theme btn_edit" >Update Payment Mode</button>
                                        </div>
                                        
                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                          </td>

                        <tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
             
            </div>
         </div>
            </div>
         </div>
      </div>
   </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript">
  $("#category_form").submit(function(e) {
        e.preventDefault();
        $("#btn_category").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding');
        $("#btn_category").prop("disabled", true);
        $.ajax({
          url:'{{ route('webmaster.paymentmode.store') }}',
          method: 'post',
          data: $(this).serialize(),
          dataType: 'json',
          success: function(response){
            if(response.status == 400){
              $.each(response.message, function (key, value) {
                showError(key, value);
              });
              $("#btn_category").html('Add Payment Mode');
              $("#btn_category").prop("disabled", false);
            } else if(response.status == 200){
               $("#category_form")[0].reset();
              removeErrors("#category_form");
              $("#btn_category").html('Add Payment Mode');
              setTimeout(function(){
               window.location.reload();
              }, 500);

            }
          }
        });
      });

      $(".edit_form").submit(function(e) {
        e.preventDefault();
        $(".btn_edit").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Updating');
        $(".btn_edit").prop("disabled", true);
        $.ajax({
         url:'{{ route('webmaster.paymentmode.update') }}',
          method: 'post',
          data: $(this).serialize(),
          dataType: 'json',
          success: function(response){
            if(response.status == 400){
              $.each(response.message, function (key, value) {
                showError(key, value);
              });
              $(".btn_edit").html('Update Payment Mode');
              $(".btn_edit").prop("disabled", false);
            } else if(response.status == 200){
               $(".edit_form")[0].reset();
              removeErrors(".edit_form");
              $(".btn_edit").html('Update Payment Mode');
              setTimeout(function(){
                window.location.reload();
              }, 500);

            }
          }
        });
      });
  
</script>
@endsection