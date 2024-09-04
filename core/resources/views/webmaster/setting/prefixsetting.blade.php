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
        <!-- Left Column: Prefix Settings Form -->
        <div class="col-md-6">
            <div class="card custom-card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Prefix Settings</h4>

                    <form id="prefix_form">
                        @csrf
                        <div class="form-group">
                            <label for="loan_prefix">Loan Prefix</label>
                            <input type="text" name="loan_prefix" id="loan_prefix" class="form-control"
                                placeholder="Enter Loan Prefix">
                            <span class="invalid-feedback"></span>
                        </div>

                        <div class="form-group">
                            <label for="investment_prefix">Investment Prefix</label>
                            <input type="text" name="investment_prefix" id="investment_prefix" class="form-control"
                                placeholder="Enter Investment Prefix">
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="form-group">
                            <label for="member_account_prefix">Member Prefix</label>
                            <input type="text" name="member_prefix" id="member_account_prefix"
                                class="form-control" placeholder="Enter Member Prefix">
                            <span class="invalid-feedback"></span>
                        </div>

                        <div class="form-group">
                            <label for="member_account_prefix">Member Account Prefix</label>
                            <input type="text" name="member_account_prefix" id="member_account_prefix"
                                class="form-control" placeholder="Enter Member Account Prefix">
                            <span class="invalid-feedback"></span>
                        </div>

                        <div class="form-group mb-0">
                            <button type="button" class="btn btn-primary btn-theme" id="savePrefixesBtn">Save
                                Prefixes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Column: Table of Saved Prefixes -->
        <div class="col-md-6">
            <div class="card custom-card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Saved Prefixes</h4>

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Prefix</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($prefixes))
                                <tr>
                                    <td>Loan</td>
                                    <td>{{ $prefixes->loan_prefix }}</td>
                                    <td>
                                        @if($prefixes->loan_prefix !== null)
                                        <a href="{{ route('webmaster.prefix.settings.delete', $prefixes->id) }}"
                                            class="btn btn-xs btn-danger deletePrefixBtn" title="Delete Prefix" prefix='loan_prefix'> <i
                                                class="fas fa-trash"></i>
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Investment</td>
                                    <td>{{ $prefixes->investment_prefix }}</td>
                                    <td>
                                        @if($prefixes->investment_prefix !== null)
                                        <a href="{{ route('webmaster.prefix.settings.delete', $prefixes->id) }}"
                                            class="btn btn-xs btn-danger deletePrefixBtn" title="Delete Prefix" prefix='investment_prefix'> <i
                                                class="fas fa-trash"></i>
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Member</td>
                                    <td>{{ $prefixes->member_prefix }}</td>
                                    <td>
                                        @if($prefixes->member_prefix !== null)
                                        <a href="{{ route('webmaster.prefix.settings.delete', $prefixes->id) }}"
                                            class="btn btn-xs btn-danger deletePrefixBtn" title="Delete Prefix" prefix='member_prefix'> <i
                                                class="fas fa-trash"></i>
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Member Account</td>
                                    <td>{{ $prefixes->member_account_prefix }}</td>
                                    <td>
                                        @if($prefixes->member_account_prefix !== null)
                                        <a href="{{ route('webmaster.prefix.settings.delete', $prefixes->id) }}"
                                            class="btn btn-xs btn-danger deletePrefixBtn" title="Delete Prefix" prefix='member_account_prefix'> <i
                                                class="fas fa-trash"></i>
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                            @endif
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
            //save prefix
            $('#savePrefixesBtn').on('click', function(e) {
                e.preventDefault();
                $('.invalid-feedback').text('');
                $('.form-control').removeClass('is-invalid');

                var formData = $('#prefix_form').serialize();

                $.ajax({
                    url: "{{ route('webmaster.prefix.settings.save') }}",
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Prefixes Saved',
                                text: 'Prefix settings have been saved successfully.',
                            });

                            location.reload(true);
                        }
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        if (errors) {
                            $.each(errors, function(key, value) {
                                var input = $('#' + key);
                                toastr.error(value[0]);
                                input.addClass('is-invalid');
                                input.siblings('.invalid-feedback').text(value[0]);
                            });
                        }
                    }
                });
            });

            //delete prefix
            $(document).on('click', '.deletePrefixBtn', function(e) {
                e.preventDefault();
                var url = $(this).attr('href');
                var prefixType=$(this).attr('prefix');

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
                                prefixType:prefixType
                            },
                            success: function(response) {
                                if (response.status === 200) {
                                    Swal.fire(
                                        'Deleted!',
                                        'The prefix has been deleted.',
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
                                    'An error occurred while trying to delete the prefix.',
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
