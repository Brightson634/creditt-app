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
                     <h3 class="card-title">Group Information</h3>
                  </div>
                  <div class="float-right">
                     <a href="{{ route('webmaster.groups') }}" class="btn btn-sm btn-theme"> <i class="fa fa-eye"></i> View Groups</a>
                  </div>
               </div>
               <form action="#" method="POST" id="group_form"> 
               @csrf
               <div class="form-group row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="group_no" class="form-label">Group No:</label>
                        <input type="text" name="group_no" id="group_no" class="form-control" value="{{ $group_no }}" readonly>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="name" class="form-label">Name:</label>
                        <input type="text" name="name" id="name" class="form-control">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
               </div>
               <div class="form-group row">
                  <div class="col-md-6">
                     <label for="telephone" class="form-label">Telephone:</label>
                     <input type="text" name="telephone" id="telephone" class="form-control">
                     <span class="invalid-feedback"></span>
                  </div>
                  <div class="col-md-6">
                     <label for="description" class="form-label">Description:</label>
                     <textarea name="description" class="form-control" id="description" rows="3"></textarea>
                     <span class="invalid-feedback"></span>
                  </div>
               </div>
               
               <div class="form-group row mt-4">
                  <div class="col-sm-9">
                     <button type="submit" class="btn btn-theme" id="btn_group">Add Group</button>
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

   $("#group_form").submit(function(e) {
        e.preventDefault();
        $("#btn_group").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding');
        $("#btn_group").prop("disabled", true);
        $.ajax({
          url:'{{ route('webmaster.group.store') }}',
          method: 'post',
          data: $(this).serialize(),
          dataType: 'json',
          success: function(response){
            if(response.status == 400){
              $.each(response.message, function (key, value) {
                showError(key, value);
              });
              $("#btn_group").html('Add Group');
              $("#btn_group").prop("disabled", false);
            } else if(response.status == 200){
               $("#group_form")[0].reset();
              removeErrors("#group_form");
              $("#btn_group").html('Add Group');
              $("#btn_group").prop("disabled", false);
              setTimeout(function(){
                window.location.href = response.url;
              }, 1000);

            }
          }
        });
      });
</script>
@endsection