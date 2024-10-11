@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection
@section('content')
@section('css')
    <style>
        .card {
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border: none;
            background-color: #ffffff;
        }

        .card-body {
            padding: 1.5rem;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 500;
        }

        .table {
            border-radius: 8px;
            overflow: hidden;
        }

        .table thead th {
            background-color: #f8f9fa;
        }

        .btn-theme {
            border-radius: 20px;
        }

        .btn-dark {
            background-color: #343a40;
            border: none;
        }

        .btn-dark:hover {
            background-color: #23272b;
        }
    </style>
@endsection
<div class="page-heading">
    {{-- <div class="page-heading__title">
      <h3>{{ $page_title }}</h3>
   </div> --}}
</div>
<!--update Modal-->
@include('webmaster.branches.edit')
<div class="row">
    <div class="col-xl-12 mx-auto">

        <div class="card card-dashboard-table-six">
            <h6 class="card-title">
                {{ $page_title }}
                <div class="float-right">
                    @can('add_branch')
                    <a href="{{ route('webmaster.branch.create') }}" class="btn btn-dark btn-sm btn-theme">
                        <i class="fa fa-plus"></i> New Branch
                    </a>
                    @endcan
                </div>
            </h6>
            @if ($branches->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Telephone</th>
                                <th>Email</th>
                                <th>Physical Address</th>
                                <th>Default Currency</th>
                                <th>Postal Address</th>
                                <th>Is Main</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 0; @endphp
                            @foreach ($branches as $row)
                                @php $i++; @endphp
                                <tr>
                                    <th scope="row">{{ $i }}</th>
                                    <td>{{ $row->branch_no }}</td>
                                    <td>{{ $row->name }}</td>
                                    <td>{{ $row->telephone }}</td>
                                    <td>{{ $row->email }}</td>
                                    <td>{{ $row->physical_address }}</td>
                                    <td>{{ $row->default_currency }}</td>
                                    <td>{{ $row->postal_address }}</td>
                                    <td>
                                        @if ($row->is_main == 1)
                                            Main Branch
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @can('edit_branch')
                                        <a href="#" id="editBranch" data-toggle="tooltip-primary"
                                            title="Update Branch" data_branch="{{ $row->id }}"
                                            class="btn btn-xs btn-dark">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        @endcan
                                        @can('delete_branch')
                                        <a href="#" id="deleBranch" data-toggle="tooltip-primary"
                                            title="Delete Branch" data_branch="{{ $row->id }}"
                                            class="btn btn-xs btn-dark">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="d-flex flex-column align-items-center mt-5">
                    <img src="{{ asset('assets/uploads/defaults/nodata.png') }}" width="200">
                    <span class="mt-3">No Data</span>
                </div>
        </div>
        @endif

    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $(document).on('click', '#editBranch', function() {
            branchId = $(this).attr('data_branch')
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: "POST",
                url: "{{ route('webmaster.branch.edit') }}",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    'branchId': branchId
                },
                dataType: "json",
                success: function(response) {
                    if (response.status === 200) {
                        $('#branch_no').val(response.branch.branch_no);
                        $('#name').val(response.branch.name);
                        $('#branch_id').val(response.branch.id);
                        $('#default_curr').val(response.branch.default_currency);
                        $('#telephone').val(response.branch.telephone);
                        $('#email').val(response.branch.email);
                        $('#physical_address').val(response.branch.physical_address);
                        $('#postal_address').val(response.branch.postal_address);
                        $('input[name="is_main"][value="' + response.branch.is_main + '"]')
                            .prop('checked', true);
                        $("#update_account_modal").modal('show');
                    } else {
                        toastr.warning(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    if(xhr.status === 403)
                        {
                            Swal.fire(
                                'Error!',
                                `${xhr.responseJSON.message}`,
                                'error'
                            );
                            return;
                        }
                    toastr.error('An unexpected error.');
                }

            });
        })

        //update
        $("#branch_form").submit(function(e) {
            e.preventDefault();
            // $("#update_btn").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding');
            $("#update_btn").prop("disabled", true);
            $.ajax({
                url: "{{ route('webmaster.branch.update') }}",
                method: 'post',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if (response.status == 400) {
                        $.each(response.message, function(key, value) {
                            showError(key, value);
                        });
                        $("#update_btn").html('Add Branch');
                        $("#update_btn").prop("disabled", false);
                    } else if (response.status == 200) {
                        $("#branch_form")[0].reset();
                        removeErrors("#branch_form");
                        $("#update_btn").html('Add Branch');
                        $("#update_btn").prop("disabled", false);
                    }

                    if (response.message) {
                        $('#update_account_modal').modal('hide')
                        toastr.success('Operation Successful')
                        location.reload()
                    }
                },
                error: function(xhr, status, error) {
                    console.log(error)
                    toastr.error('Unexpected error has occured')
                    $("#update_btn").prop("disabled", false);
                }
            });
        });

        //delete
        $(document).on('click', '#deleBranch', function(e) {
            e.preventDefault();
            var url = "{{route('webmaster.branch.delete')}}";
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
                                'content'),
                                id:$(this).attr('data_branch'),
                        },
                        success: function(response) {
                            if (response.status === 200) {
                                Swal.fire(
                                    'Deleted!',
                                    'Branch deleted.',
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
                                console.log(response)
                            }
                        },
                        error: function(xhr) {
                        if(xhr.status === 403)
                        {
                            Swal.fire(
                                'Error!',
                                `${xhr.responseJSON.message}`,
                                'error'
                            );
                            return;
                        }
                            Swal.fire(
                                'Error!',
                                'An error occurred while trying to delete the account type.',
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
