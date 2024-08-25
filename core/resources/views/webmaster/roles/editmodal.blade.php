
    <form action="#" method="POST" id="role_form">
        @csrf
        @method('PUT')
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
        <div class="form-group">
            <label for="permissions">Accord Role Permissions</label>
            <select class="form-control roleSelect" name="permissions[]" multiple="multiple" id="permissions">
                @foreach ($permissions as $permission)
                    <option value="{{ $permission->id }}"
                        @if (in_array($permission->id, $rolePermissions)) selected @endif>
                        {{ $permission->name }}
                    </option>
                @endforeach
            </select>
            <span class="invalid-feedback"></span>
        </div>
        <div class="form-group mb-0">
            <button type="" class="btn btn-primary btn-theme" id="updateRoleBtn">Update Role</button>
        </div>
    </form>
    <script>
        $(document).ready(function () {
            $('.roleSelect').select2();
            $('#updateRoleBtn').on('click', function(e) {
        e.preventDefault();

        // Clear previous error messages
        $('.invalid-feedback').text('');
        $('.form-control').removeClass('is-invalid');

        // Gather form data
        var formData = $('#role_form').serialize();

        $.ajax({
            url: "{{ route('webmaster.role.update', $role->id) }}", 
            method: 'PUT',
            data: formData,
            success: function(response) {
                if (response.success) {
                    $('#updateRole').modal('hide')
                    // Display success message or redirect
                    Swal.fire({
                        icon: 'success',
                        title: 'Role Updated',
                        text: 'The role has been updated successfully.',
                    });

                }
            },
            error: function(xhr) {
                var errors = xhr.responseJSON.errors;
                
                // Display validation errors
                if (errors) {
                    $.each(errors, function(key, value) {
                        var input = $('#' + key);
                        input.addClass('is-invalid');
                        input.siblings('.invalid-feedback').text(value[0]);
                    });
                }
            }
        });
    });
        });
    </script>