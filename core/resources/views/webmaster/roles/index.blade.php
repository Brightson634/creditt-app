@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection
@section('css')
    <style>

    </style>
@endsection
@section('content')
    <div class="page-heading">
        {{-- <div class="page-heading__title">
      <h3>{{ $page_title }}</h3>
   </div> --}}
    </div>

    <div class="row">
        <div class="col-xl-12">

            @if ($roles->count() > 0)
                <div class="card card-dashboard-table-six">
                    <h6 class="card-title">{{ $page_title }}<div class="float-right">
                            <a href="{{ route('webmaster.role.create') }}" class="btn btn-dark btn-sm btn-theme"><i
                                    class="fa fa-plus"></i> Add Role</a>
                        </div>
                    </h6>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Role Name</th>
                                    <th>Role Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 0; @endphp
                                @foreach ($roles as $role)
                                    @php $i++; @endphp
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>{{ $role->description }}</td>
                                        <td class='d-flex gap-between-buttons'>
                                            <a href="{{ route('webmaster.role.edit', $role->id) }}"
                                                class="btn btn-xs btn-dark updateRoleBtn" title="Update Role">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            <a href="{{ route('webmaster.role.delete', $role->id) }}"
                                                class="btn btn-xs btn-danger deleteRoleBtn" title="Delete Role">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                            <a href="{{ route('webmaster.role.assign.permissions', $role->id) }}"
                                                class="btn btn-xs btn-primary assignPermissionsBtn"
                                                title="Assign or Update Permissions">
                                                <i class="fas fa-shield-alt"></i> <!-- Shield icon for permissions -->
                                            </a>
                                        </td>



                                    <tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="d-flex flex-column align-items-center mt-5">
                    <img src="{{ asset('assets/uploads/defaults/nodata.png') }}" width="200">
                    <span class="mt-3">No Data</span>
                </div>
            @endif
        </div>
    </div>

    <div id="updateRole" class="modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Edit Role</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id='updateRoleContent'>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-indigo">Save changes</button>
                        <button type="button" data-dismiss="modal" class="btn btn-outline-light">Close</button>
                    </div>
                </div>
            </div><!-- modal-dialog -->
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            //update
            $(document).on('click', '.updateRoleBtn', function(event) {
                event.preventDefault();
                var url = $(this).attr('href');
                $.ajax({
                    type: "GET",
                    url: url,
                    success: function(response) {
                        $('#updateRoleContent').html(response.html)
                        $('#updateRole').modal('show');

                    },
                    error: function(xhr) {
                        if (xhr.status === 403) {
                            toastr.error(xhr.responseJSON.message)
                            return
                        }
                    }
                });
            });
            //delete role
            $(document).on('click', '.deleteRoleBtn', function(e) {
                e.preventDefault();
                var url = $(this).attr('href');

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You won\'t be able to revert this!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr(
                                    'content')
                            },
                            success: function(response) {
                                if (response.status === 200) {
                                    Swal.fire(
                                        'Deleted!',
                                        'The role has been deleted.',
                                        'success'
                                    ).then(() => {
                                        location.reload(true);
                                    });
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        response.message,
                                        'error'
                                    );
                                }
                            },
                            error: function(xhr) {
                                if (xhr.status === 403) {
                                    toastr.error(xhr.responseJSON.message)
                                    return
                                }
                                Swal.fire(
                                    'Error!',
                                    'An error occurred while trying to delete the role.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
