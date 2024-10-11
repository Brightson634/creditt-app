@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection
@section('css')
    <style>
        /* Custom card styling */
        .custom-card {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            background-color: #ffffff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* Custom card header styling */
        .custom-card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #e0e0e0;
            padding: 1rem 1.5rem;
        }

        /* Custom table styling */
        .custom-table thead {
            background-color: #f8f9fa;
            color: #495057;
        }

        .custom-table th {
            border-bottom: 2px solid #e0e0e0;
        }

        .custom-table tbody tr:hover {
            background-color: #f1f1f1;
        }

        /* Custom button group styling */
        .btn-group .btn {
            margin-right: 0.5rem;
        }

        .btn-dark {
            background-color: #343a40;
            border-color: #343a40;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        /* Ensure tooltips are properly styled */
        [data-toggle="tooltip"] {
            cursor: pointer;
        }
    </style>
@endsection
@section('content')
    <div class="page-heading">
        <ul class="nav nav-tabs">
            <li class="nav-item">

            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-xl-11 mx-auto">
            <div class="card custom-card">
                <div class="card-header custom-card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0"> Rates</h4>
                    @can('add_exchange_rates_settings')
                        <a class="btn btn-indigo btn-sm exchangeLink" data-toggle="tooltip" data-placement="bottom"
                            title="Add Exchange Rate" href="#">Add Exchange Rate</a>
                    @endcan

                </div>
                <div class="card-body">
                    <div class="container mb-4">
                        <h6>Default Branch Currency <span class="text-muted">
                                @isset($default_branch_curr->currency)
                                    {{ $default_branch_curr->currency }}
                                @endisset
                            </span>
                        </h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table custom-table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Currency</th>
                                    <th>Code</th>
                                    <th>Exchange Rate</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @isset($exchangeRates)
                                    @foreach ($exchangeRates as $rate)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $rate->foreign_currency }}</td>
                                            <td>{{ $rate->code }}</td>
                                            <td>{{ number_format($rate->exchange_rate, 2) }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    @can('edit_exchange_rate_settings')
                                                        <a href="#" class="btn btn-dark btn-sm edit-rate"
                                                            data-editrate="{{ $rate->id }}" data-toggle="tooltip"
                                                            title="Edit Rate"> <i class="far fa-edit"></i>
                                                        </a>
                                                    @endcan
                                                    @can('delete_exchange_rate_settings')
                                                        <a href="#" class="btn btn-danger btn-sm del-rate"
                                                            data-delrate="{{ $rate->id }}" data-toggle="tooltip"
                                                            title="Delete Rate"> <i class="far fa-trash-alt"></i>
                                                        </a>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endisset
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    @include('webmaster.setting.updateexchangeratemodal')
    @include('webmaster.setting.exchangemodal')

@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.exchangeLink', function() {
                $('#exchange_modal').modal('show');
            })

            //save rates
            $('#exchangerateForm').on('submit', function(event) {
                event.preventDefault();
                clearErrors()
                var formData = {
                    froCurrency: $('#froCurrency').val(),
                    exchangeRate: $('#exchangeRate').val(),
                    _token: '{{ csrf_token() }}'
                };
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#exchange_modal').modal('hide');
                        toastr.success('Exchange rate saved successfully!');
                        location.reload(true);
                    },
                    error: function(xhr, status, err) {
                        var errors = xhr.responseJSON.errors;
                        if (xhr.status === 403) {
                            return toastr.error(xhr.responseJSON.message)
                        }
                        if (errors) {
                            if (errors.froCurrency) {
                                showError('froCurrencyError', errors.froCurrency[0]);
                            }
                            if (errors.exchangeRate) {
                                showError('exchangeRateError', errors.exchangeRate[0]);
                            }
                        } else {
                            toastr.error('An error occurred while saving the exchange rate.');
                        }
                    }
                });
            });

            //delete exchange rate
            $(document).on('click', '.del-rate', function() {

                Swal.fire({
                    title: 'Are you sure of this operation?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    dangerMode: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        const rateId = $(this).attr('data-delrate')
                        const url = `{{ route('webmaster.exchangerate.delete') }}`;
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            data: {
                                rateId: rateId,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    toastr.success(response.message);
                                    location.reload();
                                } else {
                                    toastr.error(response.message);
                                }
                            },
                            error: function(xhr, status, err) {
                                if (xhr.status === 403) {
                                    return toastr.error(xhr.responseJSON.message)
                                }
                                console.error('Error:', err);
                                toastr.error(
                                    'An error occurred while deleting the exchange rate.'
                                );
                            }
                        });
                    }
                });

            })



            //update exchange rate
            $(document).on('click', '.edit-rate', function() {
                const rateId = $(this).attr('data-editrate')
                // alert(rateId);
                $.ajax({
                    url: `{{ route('webmaster.exchangerate.get') }}`,
                    type: 'GET',
                    data: {
                        rateId: rateId
                    },
                    success: function(response) {
                        $('#froCurrencyUpdate').val(response.froCurrencyId);
                        $('#exchangeRateUpdate').val(response.exchangeRate);
                        $('#exchangeRateId').val(rateId)
                        // Open the modal
                        $('#exchange_update').modal('show');
                    },
                    error: function(xhr, status, err) {
                        if (xhr.status === 403) {
                            return toastr.error(xhr.responseJSON.message)
                        }
                        toastr.error(
                            'An error occurred while fetching the exchange rate details.');
                    }
                });
            })

            // Update exchange rate
            $(document).on('click', '#rateUpdateBtn', function() {
                // Debugging: Log the action URL and form data
                const url = $('#exchangerateUpdateForm').attr('action');
                console.log('Action URL:', url);

                var formData = {
                    froCurrency: $('#froCurrencyUpdate').val(),
                    exchangeRate: $('#exchangeRateUpdate').val(),
                    rateId: $('#exchangeRateId').val(), // Correctly get the value
                    _token: '{{ csrf_token() }}'
                };

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    success: function(response) {

                        console.log(response)
                        $('#exchange_update').modal('hide');
                        toastr.success('Exchange rate saved successfully!');
                        location.reload(); // Reload the page
                    },
                    error: function(xhr, status, err) {
                        console.error('Error:', err); // Log the error for debugging
                        var errors = xhr.responseJSON.errors;
                        if (errors) {
                            if (errors.froCurrency) {
                                showError('froCurrencyErrorUpdate', errors.froCurrency[0]);
                            }
                            if (errors.exchangeRate) {
                                showError('exchangeRateErrorUpdate', errors.exchangeRate[0]);
                            }
                        } else {
                            toastr.error('Server error');
                        }
                    }
                });
            });

            // Function to show error message
            function showError(elementId, message) {
                $('#' + elementId).text(message).show();
            }

            // Function to remove error message
            function removeError(elementId) {
                $('#' + elementId).hide().text('');
            }

            // Clear previous error messages
            function clearErrors() {
                removeError('froCurrencyError');
                removeError('exchangeRateError');
            }

        });
    </script>
@endsection
