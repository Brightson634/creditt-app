@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection
@section('css')
@endsection
@section('content')
    <div class="page-heading ">
        @include('webmaster.setting.commonheader')
    </div>
    <div class="row">
        <!-- Left Column: Prefix Settings Form -->
        <div class="col-md-6">
            <div class="card custom-card">
                <div class="card-header">
                    <h5>Choose Collateral Method</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('webmaster.loansetting.saveCollateralMethod') }}" method="POST"
                        id='collateral_form'>
                        @csrf
                        <div class="mb-3">
                            <label for="collateralMethod" class="form-label">Collateral Method</label>
                            <select class="form-control" id="collateralMethod" name="collateralMethod" required>
                                <option value="" disabled selected>Select Collateral Method</option>
                                <option value="collateral_items">Collateral Items</option>
                                <option value="min_balance">Minimum Member Account Balance</option>
                                <option value="both">Both Methods</option>
                            </select>
                            <span class="invalid-feedback"></span>
                        </div>
                        @can('add_loan_settings')
                        <button type="button" class="btn btn-primary" id='saveCollateralMethod'>Save Settings</button>
                        @endcan
                    </form>
                </div>
            </div>
        </div>


        <div class="col-md-6">
            <div class="card custom-card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Collateral Methods</h4>

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Method</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="collateral-methods-tbody">
                            @foreach ($collateralMethods as $method)
                                @if (!empty($method))
                                    <tr id="method-{{ $method }}">
                                        <td>
                                            @if ($method == 'collateral_items')
                                                Collateral Items
                                            @elseif($method == 'min_balance')
                                                Minimum Member Account Balance
                                            @endif
                                        </td>
                                        <td>
                                            @can('delete_loan_settings')
                                            <button class="btn btn-danger btn-sm delete-method-btn"
                                                data-method="{{ $method }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            @endcan
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            //save method
            $('#saveCollateralMethod').on('click', function(e) {
                e.preventDefault();
                $('.invalid-feedback').text('');
                $('.form-control').removeClass('is-invalid');

                var formData = $('#collateral_form').serialize();
                $.ajax({
                    url: "{{ route('webmaster.loansetting.saveCollateralMethod') }}",
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Methods Saved',
                                text: 'Collateral method saved successfully.',
                            });

                            location.reload(true);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 403) {
                            return toastr.error(xhr.responseJSON.message);
                        }
                        var errors = xhr.responseJSON.errors;
                        if (errors) {
                            $.each(errors, function(key, value) {
                                toastr.error(value[0])
                                var input = $('#' + key);
                                input.addClass('is-invalid');
                                input.siblings('.invalid-feedback').text(value[0]);
                            });
                        }
                    }
                });
            });

            //delete method
            $(document).on('click', '.delete-method-btn', function(e) {
                var method = $(this).data('method');

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
                            url: '{{ route('webmaster.collateral.delete', '') }}/' + method,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.status === 200) {
                                    Swal.fire(
                                        'Deleted!',
                                        'The Method has been deleted.',
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
                                    Swal.fire(
                                        'Error!',
                                        `${xhr.responseJSON.message}`,
                                        'error'
                                    );
                                    return;
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
