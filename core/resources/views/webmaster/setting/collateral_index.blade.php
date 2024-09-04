@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection
@section('css')
    <style>
        .custom-card {
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            background-color: #f9f9f9;
            border: none;
        }

        .custom-card .card-body {
            padding: 20px;
        }

        .table {
            margin-top: 15px;
        }

        .table th,
        .table td {
            border-color: #eaeaea;
        }

        .btn-theme {
            background-color: #007bff;
            border: none;
            color: white;
            border-radius: 5px;
        }
    </style>
@endsection
@section('content')
    <div class="page-heading ">
        @include('webmaster.setting.commonheader')
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card custom-card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Add Collateral Items</h4>
                    <div id='formdiv'>
                        <form method="POST" id="collateralForm">
                            @csrf
                            <!-- Collateral Name Field -->
                            <div class="form-group">
                                <label for="collateral_name">Collateral Name</label>
                                <input type="text" class="form-control" id="collateral_name" name="collateral_name"
                                    placeholder="Enter collateral name" required>
                            </div>

                            <!-- Status Field -->
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>

                            <!-- Minimum Account Balance as Collateral Checkbox -->
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="min_balance_collateral"
                                    name="min_balance_collateral">
                                <label class="form-check-label" for="min_balance_collateral">Consider minimum account
                                    balance as
                                    collateral</label>
                            </div>

                            <!-- Submit Button -->
                            <div class="form-group mt-4">
                                <button type="button" class="btn btn-success" id='saveCollateral'>Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-6">
            <div class="card custom-card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Saved Collateral Items</h4>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Collateral Name</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($collaterals as $index => $collateral)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $collateral->name }}</td>
                                    <td>
                                        @if ($collateral->status == 1)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td style="display: flex; gap: 10px;">
                                        <a href="{{ route('webmaster.collaterals.edit', $collateral->id) }}"
                                           class="btn btn-sm btn-primary" id="updateCollateralItem" title='Update'>
                                           <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('webmaster.collaterals.destroy', $collateral->id) }}" title='Delete'
                                           class="btn btn-sm btn-danger" id='deleteCollateral'>
                                           <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No collaterals available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $(document).on('click','#saveCollateral',function(e) {
                e.preventDefault();
                alert('God is good')
                formData= $(collateralForm).serialize()
                $.ajax({
                    url: "{{ route('webmaster.collaterals.store') }}",
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            $('#collateralForm')[0].reset();
                            location.reload(true);
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                toastr.error(value[0]);
                            });
                        } else {
                            toastr.error('An error occurred while saving the collateral.');
                        }
                    }
                });
            });

            //update type
            $(document).on('click', '#updateCollateralItem', function() {
                event.preventDefault();
                url = $(this).attr('href');
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        // console.log(response);
                        if (response.status == 200) {
                            $('#formdiv').html(response.html)
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr)
                    }
                });
            })

            //store updated info
            $(document).on('click', '#updateCollateral', function(event) {
                event.preventDefault();
                const id = $('#collateralId').val()
                var url = `{{ route('webmaster.collaterals.update', '__id__') }}`.replace('__id__', id);
                var formData = $("#collateralFormUpdate").serialize();
                $.ajax({
                    url: url,
                    type: 'PUT',
                    data: formData,
                    success: function(response) {
                        toastr.success(response.message);
                        location.reload(true);
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        for (var key in errors) {
                            if (errors.hasOwnProperty(key)) {
                                toastr.error(errors[key][0]);
                            }
                        }
                    }
                });
            });

            //delete
            $(document).on('click', '#deleteCollateral', function(e) {
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
                                    'content'),
                            },
                            success: function(response) {
                                if (response.status === 200) {
                                    Swal.fire(
                                        'Deleted!',
                                        'Collateral item has been deleted.',
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
