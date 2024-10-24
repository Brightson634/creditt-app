@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection
@section('css')
    <style>
    </style>
@endsection
@section('content')
    <div class="page-heading ">
        @include('webmaster.setting.commonheader')
    </div>
    <div class="row">
        <!-- Left Column: Prefix Settings Form -->
        <div class="col-md-5">
            <div class="card custom-card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Add Account Types</h4>
                    <div id="formdiv">
                        <form method="POST" id='accountForm'>
                            @csrf
                            <!-- Account Name Field -->
                            <div class="form-group">
                                <label for="account_name">Account Name</label>
                                <input type="text" class="form-control" id="account_name" name="account_name"
                                    placeholder="Enter account name">
                            </div>
                            <!-- Minimum Amount Field -->
                            <div class="form-group">
                                <label for="minimum_amount">Minimum Amount</label>
                                <input type="number" class="form-control" id="minimum_amount" name="minimum_amount"
                                    placeholder="Enter minimum amount">
                            </div>

                            <!-- Description Field -->
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter description"></textarea>
                            </div>
                            <!-- Status Field -->
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status">
                                    <option value=''>Select Status</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>

                            <!-- Submit Button -->
                            <div class="form-group mt-4">
                                @can('add_account_types_settings')
                                    <button type="submit" class="btn btn-success">Save</button>
                                @endcan
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card custom-card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Saved Account Types</h4>

                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Account Name</th>
                                <th>Minimum Amount</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($accountTypes as $index => $accountType)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $accountType->name }}</td>
                                    <td>{{ number_format($accountType->min_amount, 2) }}</td>
                                    <td>{{ $accountType->description }}</td>
                                    <td>
                                        @if ($accountType->status == 1)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        @can('edit_account_types_settings')
                                            <a href="{{ route('webmaster.acctypes.edit', $accountType->id) }}"
                                                class="btn btn-sm btn-primary" id="updateType" title='Update'><i
                                                    class="fas fa-edit"></i></a>
                                        @endcan
                                        @can('delete_account_types_settings')
                                            <a href="{{ route('webmaster.acctypes.destroy', $accountType->id) }}" title='Delete'
                                                class="btn btn-sm btn-danger" id='deleteType'><i class="fas fa-trash"></i></a>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No account types available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5">
            <div class="card custom-card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Add Default Accounts</h4>
                    <div id="formdiv">
                        @php
                            $accounts_array = AllChartsOfAccounts();
                        @endphp
                        <form method="POST" id='defaultAccountForm'>
                            @csrf
                            <!-- Account Name Field -->
                            <div class="form-group">
                                <label for="default_loan_repayment_account">Default Loan Repayment Account</label>
                                <select name="default_loan_repayment_account" class="form-control accounts-dropdown"
                                    id='default_loan_repayment_account' style="width: 100%;">
                                    <option value=''>Select Account</option>
                                    @foreach ($accounts_array as $account)
                                        <option value="{{ $account['id'] }}" data-currency="{{ $account['currency'] }}"
                                         @if(getSystemInfo()->default_loan_repayment_account ===$account['id'] ) selected @endif>
                                            {{ $account['name'] }}
                                            -{{ $account['primaryType'] }}-{{ $account['subType'] }}
                                        </option>
                                    @endforeach
                                </select>
                                <p class="text-muted">This will be used to hold loan repayments from members</p>
                            </div>
                            <!-- Minimum Amount Field -->
                            <div class="form-group">
                                <label for="default_investment_account" class="form-label">Default Investment
                                    Account</label>
                                <select name="default_investment_account" class="form-control accounts-dropdown"
                                    id='default_investment_account' style="width: 100%;">
                                    <option value=''>Select Account</option>
                                    @foreach ($accounts_array as $account)
                                        <option value="{{ $account['id'] }}" data-currency="{{ $account['currency'] }}"
                                        @if(getSystemInfo()->default_loan_repayment_account ===$account['id'] ) selected @endif>
                                            {{ $account['name'] }}
                                            -{{ $account['primaryType'] }}-{{ $account['subType'] }}
                                        </option>
                                    @endforeach
                                </select>
                                <p class="text-muted">This will be used to hold investments from members</p>
                            </div>
                            <!-- Submit Button -->
                            <div class="form-group mt-4">
                                @can('add_account_types_settings')
                                    <button type="submit" class="btn btn-success" id="defaultAcc">Set/Update</button>
                                @endcan
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#default_loan_repayment_account').select2({
                placeholder: 'Select  default loan repayment account'
            })
            $('#default_investment_account').select2({
                placeholder: 'Select default investment account'
            })

            $('#accountForm').on('submit', function(e) {
                e.preventDefault();

                let formData = {
                    account_name: $('#account_name').val(),
                    minimum_amount: $('#minimum_amount').val(),
                    description: $('#description').val(),
                    status: $('#status').val(),
                    _token: '{{ csrf_token() }}'
                };

                $.ajax({
                    url: "{{ route('webmaster.acctypes.store') }}",
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            $('#accountForm')[0].reset();
                            location.reload(true);
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 403) {
                            return toastr.error(xhr.responseJSON.message)
                        }
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                toastr.error(value[0]);
                            });
                        } else {
                            toastr.error('An error occurred while saving the account.');
                        }
                    }
                });
            });

            //update type
            $(document).on('click', '#updateType', function() {
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
                        if (xhr.status === 403) {
                            return toastr.error(xhr.responseJSON.message)
                        }
                    }
                });
            })

            //store updated info
            $(document).on('click', '#updatedType', function(event) {
                event.preventDefault();
                const id = $('#accTypeId').val()
                var url = `{{ route('webmaster.acctypes.update', '__id__') }}`.replace('__id__', id);
                var formData = $("#accountFormUpdate").serialize();
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
            $(document).on('click', '#deleteType', function(e) {
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
                                        'The Account type has been deleted.',
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
                                    return
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

            //save default account info
            $('#defaultAccountForm').on('submit', function(e) {
                e.preventDefault();
                // Get form data
                var formData = {
                    _token: $('input[name="_token"]').val(),
                    default_investment_account: $('#default_investment_account').val(),
                    default_loan_repayment_account: $('#default_loan_repayment_account').val()
                };

                $.ajax({
                    url: "{{ route('webmaster.accounts.defaultaccounts') }}",
                    type: "POST",
                    data: formData,
                    dataType: "json",
                    success: function(response) {
                        if (response.status === 200) {
                            toastr.success('Settings Updated');
                            location.reload(true);
                        } else {
                            toastr.error('Error updating settings. Please try again.');
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle server errors
                        console.error(xhr.responseText);
                        toastr.error('An unexpected error occurred!');
                    }
                });
            });
        });
    </script>
@endsection
