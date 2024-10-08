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
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="clearfix">
                        <div class="float-left">
                            <h4 class="card-title mb-4">Edit Role Information</h4>
                        </div>
                        <div class="float-right">
                            <a href="{{ route('webmaster.roles') }}" class="btn btn-dark btn-sm btn-theme">
                                <i class="fa fa-eye"></i> View Roles
                            </a>
                        </div>
                    </div>

                    <!-- Form for Editing Role -->
                    <form action="" method="POST" id="role_form">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Role Name</label>
                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ $role->name }}">
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="form-group">
                            <label for="description">Role Description</label>
                            <textarea name="description" class="form-control" id="description" rows="3">{{ $role->description }}</textarea>
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="form-group">
                            <label for="permissions">Accord Role Permissions</label>
                            <select class="form-control roleSelect" name="permissions[]" multiple="multiple"
                                id="permissions">
                                @foreach ($permissions as $permission)
                                    <option value="{{ $permission->id }}" @if (in_array($permission->id, $rolePermissions)) selected @endif>
                                        {{ $permission->name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary btn-theme" id="btn_role">Update Role</button>
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
            $("#btn_role").html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Updating'
                );
            $("#btn_role").prop("disabled", true);
            $.ajax({
                url: '{{ route('webmaster.role.update') }}',
                method: 'post',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == 400) {
                        $.each(response.message, function(key, value) {
                            showError(key, value);
                        });
                        $("#btn_role").html('Update Role');
                        $("#btn_role").prop("disabled", false);
                    } else if (response.status == 200) {
                        removeErrors("#role_form");
                        $("#btn_role").html('Update Role');
                        $("#btn_role").prop("disabled", false);
                        setTimeout(function() {
                            window.location.href = response.url;
                        }, 1000);

                    }
                },
                error: function(xhr) {
                    if (xhr.status === 403) {
                        toastr.error(xhr.responseJSON.message)
                        return
                    }
                }
            });
        });
    </script>
@endsection
