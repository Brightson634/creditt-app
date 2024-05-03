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
         <div class="card">
            <div class="card-body">
               <div class="clearfix">
                  <div class="float-left">
                     <h4 class="card-title mb-4">Role Information</h4>
                  </div>
                  <div class="float-right">
                     <a href="{{ route('webmaster.roles') }}" class="btn btn-sm btn-theme"> <i class="fa fa-eye"></i> View Roles</a>
                  </div>
                  
               </div>
               <form action="#" method="POST" id="role_form"> 
                  @csrf
                  <input type="hidden" name="id" class="form-control" value="{{ $role->id }}">
                  <div class="form-group">
                     <label for="name">Role Name</label>
                     <input type="text" name="name" id="name" class="form-control" value="{{ $role->name }}">
                     <span class="invalid-feedback"></span>
                  </div>
                  <div class="form-group">
                     <label for="description">Role Description</label>
                     <textarea name="description" class="form-control" id="description" rows="3">{{ $role->description }}</textarea>
                     <span class="invalid-feedback"></span>
                  </div>
                  @foreach ($modules as $module)
                  <div class="cardd card-body">
                     <div class="form-group mb-3">
                        <div class="custom-control custom-checkbox">
                           <input type="checkbox" class="custom-control-input module-checkbox" id="checkmeout{{ $module->id }}" data-module="{{ $module->module_name }}">
                           <label class="custom-control-label" for="checkmeout{{ $module->id }}">
                              {{ $module->module_name }}
                           </label>
                        </div>
                     </div>
                     @php
                     $permissions = \App\Models\Permission::where('module_name', $module->module_name)->get();
                     $role_permissions = \App\Models\RolePermission::where('role_id', $role->id)->pluck('permission_id')->toArray();
                     @endphp
                     <div class="form-row">
                        @foreach ($permissions as $permission)
                        <div class="mb-3 ml-3">
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" name="permission_id[]" class="custom-control-input permission-checkbox" id="{{ $permission->permission_name }}" value="{{ $permission->id }}" data-module="{{ $module->module_name }}" {{ in_array($permission->id, $role_permissions) ? 'checked' : '' }}>
                              <label class="custom-control-label" for="{{ $permission->permission_name }}">{{ $permission->permission_name }}</label>
                           </div>
                        </div>
                        @endforeach
                     </div>
                  </div>
                  @endforeach
                  <div class="form-group mb-0">
                     <button type="submit" class="btn btn-theme" id="btn_role">Create Role</button>
                  </div>
               </form>
            </div>
         </div>
      </div> 
   </div>
   

@endsection

@section('scripts')
<script type="text/javascript">
   $('.module-checkbox').change(function() {
      var moduleName = $(this).data('module');
      var isChecked = $(this).prop('checked');
      $('.permission-checkbox[data-module="' + moduleName + '"]').prop('checked', isChecked);
   });
  
   $("#role_form").submit(function(e) {
        e.preventDefault();
        $("#btn_role").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Updating');
        $("#btn_role").prop("disabled", true);
        $.ajax({
          url:'{{ route('webmaster.role.update') }}',
          method: 'post',
          data: $(this).serialize(),
          dataType: 'json',
          success: function(response){
            if(response.status == 400){
              $.each(response.message, function (key, value) {
                showError(key, value);
              });
              $("#btn_role").html('Update Role');
              $("#btn_role").prop("disabled", false);
            } else if(response.status == 200){
              removeErrors("#role_form");
              $("#btn_role").html('Update Role');
              $("#btn_role").prop("disabled", false);
              setTimeout(function(){
                window.location.href = response.url;
              }, 1000);

            }
          }
        });
      });

</script>
@endsection