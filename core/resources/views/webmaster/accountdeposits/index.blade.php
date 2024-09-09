@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection
@section('content')
    <div class="page-heading ">
        {{-- <div class="page-heading__title">
      <h3>{{ $page_title }}</h3>
   </div> --}}
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="clearfix mb-3">
                        <div class="float-left">
                            <h3 class="card-title">Account Deposits</h3>
                        </div>
                        <div class="float-right">
                            <button type="button" class="btn btn-dark btn-sm btn-theme" data-toggle="modal"
                                data-target="#accountdepositModel">
                                <i class="fa fa-plus"></i> Add Account Deposit
                            </button>
                            <div class="modal fade" id="accountdepositModel">
                                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <h4 class="card-title mb-4"> Account Deposit Form </h4>
                                            <div class="row" id='member_profile'>
                                             
                                            </div>
                                            <form action="#" method="POST" id="accountdeposit_form">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            @php
                                                                $accounts_array = AllChartsOfAccounts();
                                                            @endphp
                                                            <label for="account_id">Account</label>
                                                            <select name="account_id"
                                                                class="form-control accounts-dropdown account_id"
                                                                style="width: 100%;">
                                                                <option value=''>Select Account</option>
                                                                @foreach ($accounts_array as $account)
                                                                    <option value="{{ $account['id'] }}"
                                                                        data-currency="{{ $account['currency'] }}">
                                                                        {{ $account['name'] }}
                                                                        -{{ $account['primaryType'] }}-{{ $account['subType'] }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <span class="invalid-feedback"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="paymenttype_id">Payment Type</label>
                                                            <select class="form-control" name="paymenttype_id"
                                                                id="paymenttype_id">
                                                                <option value="">select payment type </option>
                                                                @foreach ($payments as $data)
                                                                    <option value="{{ $data->id }}">{{ $data->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <span class="invalid-feedback"></span>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="amount">Amount</label>
                                                            <input type="text" name="amount" id="amount"
                                                                class="form-control">
                                                            <span class="invalid-feedback"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="depositor">Depositor</label>
                                                            <input type="text" name="depositor" id="depositor"
                                                                class="form-control">
                                                            <span class="invalid-feedback"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="date" class="form-label">Transaction
                                                                Date</label>
                                                            <input type="text" name="date" class="form-control"
                                                                data-provide="datepicker" data-date-autoclose="true"
                                                                data-date-format="yyyy-mm-dd" id="date"
                                                                value="{{ now()->format('Y-m-d') }}" autocomplete="off">
                                                            <span class="invalid-feedback"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="description">Description</label>
                                                            <textarea name="description" class="form-control" id="description" rows="3"></textarea>
                                                            <span class="invalid-feedback"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <button type="button" class="btn btn-danger btn-sm btn-secondary"
                                                        data-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary btn-sm btn-theme"
                                                        id="btn_accountdeposit">Add Account Deposit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($accountdeposits->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Account</th>
                                        <th>Payment Type</th>
                                        <th>Depositor</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($accountdeposits as $row)
                                        <tr>
                                            <td>{{ dateFormat($row->date) }}</td>
                                            <td>{!! showAmount($row->amount) !!}</td>
                                            <td>{{ $row->memberAccount->account_no }}</td>
                                            <td>{{ $row->paymenttype->name }}</td>
                                            <td>{{ $row->depositor }}</td>
                                            <td>
                                                <!-- Actions Dropdown -->
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                                        id="actionsDropdown" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <i class="fas fa-cog"></i> Actions
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="actionsDropdown">
                                                        <!-- View Details Action -->
                                                        <a class="dropdown-item view-details-btn"
                                                            href="{{ route('webmaster.accountdeposit.show', $row->id) }}">
                                                            <i class="fas fa-eye"></i> View Details
                                                        </a>

                                                        <!-- Edit Action -->
                                                        <a class="dropdown-item view-edit-btn"
                                                            href="{{ route('webmaster.accountdeposit.edit', $row->id) }}">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>

                                                        <!-- Delete Action -->
                                                        <a class="dropdown-item"
                                                            href="{{ route('webmaster.accountdeposit.destroy', $row->id) }}"
                                                            id='delete-btn'>
                                                            <i class="fas fa-trash"></i> Delete
                                                        </a>
                                                    </div>
                                                </div>

                                            </td>
                                        <tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="d-flex flex-column align-items-center mt-5">
                            <img src="{{ asset('assets/uploads/defaults/nodata.png') }}" width="200">
                            <span class="mt-3">No Data</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>

    <!--view modal -->
    <div id="viewModal" class="modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">View Deposit Details</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="deposit-details">

                    </div>
                    <div class="modal-footer">
                        {{-- <button type="button" class="btn btn-indigo">Save changes</button> --}}
                        <button type="button" class="btn btn-outline-light" data-dismiss="modal">Dismiss</button>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- modal -->
    <!--edit modal-->
    <div id="editDeposit" class="modal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-content-demo" id="deposit-details-edit">

            </div>
        </div><!-- modal-dialog -->
    </div><!-- modal -->
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $(".account_id").select2({
                placeholder: "Select an account",
                allowClear: true,
                dropdownParent: $('#accountdepositModel')
            })
            $("#accountdeposit_form").submit(function(e) {
                e.preventDefault();
                $("#btn_accountdeposit").html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding'
                );
                $("#btn_accountdeposit").prop("disabled", true);
                $.ajax({
                    url: '{{ route('webmaster.accountdeposit.store') }}',
                    method: 'post',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 400) {
                            $.each(response.message, function(key, value) {
                                showError(key, value);
                            });
                            $("#btn_accountdeposit").html('Add Account Deposit');
                            $("#btn_accountdeposit").prop("disabled", false);
                        } else if (response.status == 200) {
                            $("#accountdeposit_form")[0].reset();
                            removeErrors("#accountdeposit_form");
                            $("#btn_accountdeposit").html('Add Account Deposit');
                            $("#btn_accountdeposit").prop("disabled", false);
                            setTimeout(function() {
                                window.location.reload(true);
                            }, 1000);

                        }
                    }
                });
            });

            //load view details
            $('.view-details-btn').on('click', function(event) {
                event.preventDefault()

                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                const url = $(this).attr('href');
                $.ajax({
                    url: url,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(response) {
                        console.log(response)
                        $('#deposit-details').html(response.details);
                        $('#viewModal').modal('show')
                    },
                    error: function(xhr) {
                        console.log(response)
                        $('#deposit-details').html(
                            '<p class="text-danger">Unable to load details.</p>');
                    }
                });
            });

            //get details to update
            $('.view-edit-btn').on('click', function(event) {
                event.preventDefault();
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                const url = $(this).attr('href');
                $.ajax({
                    url: url,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(response) {
                        console.log(response)
                        $('#deposit-details-edit').html(response.details);
                        $('#editDeposit').modal('show')
                    },
                    error: function(xhr) {
                        console.log(response)
                        $('#deposit-details-edit').html(
                            '<p class="text-danger">Unable to load details.</p>');
                    }
                });
            })

            //store update info
            $("#accountdepositupdate_form").submit(function(e) {
                e.preventDefault();
                alert('God is good')
                const url = $(this).attr('action')
                $(".updateDepositBtn").html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Updating'
                );
                $(".updateDepositBtn").prop("disabled", true);
                $.ajax({
                    url: url,
                    method: 'put',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 400) {
                            $.each(response.message, function(key, value) {
                                showError(key, value);
                            });
                            $(".updateDepositBtn").html('Update Account Deposit');
                            $(".updateDepositBtn").prop("disabled", false);
                        } else if (response.status == 200) {
                            $("#accountdepositupdate_form")[0].reset();
                            removeErrors("#accountdepositupdate_form");
                            $(".updateDepositBtn").html('Update Account Deposit');
                            $(".updateDepositBtn").prop("disabled", false);
                            setTimeout(function() {
                                window.location.reload(true);
                            }, 1000);

                        }
                    }
                });
            });

            $(document).on('click', '.updateDepositBtn', function(event) {
                event.preventDefault()
                const url = $("#accountdepositupdate_form").attr('action')
                $(".updateDepositBtn").html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Updating'
                );
                $(".updateDepositBtn").prop("disabled", true);
                $.ajax({
                    url: url,
                    method: 'put',
                    data: $("#accountdepositupdate_form").serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 400) {
                            $.each(response.message, function(key, value) {
                                toastr.error(value)
                                showError(key, value);
                            });
                            $(".updateDepositBtn").html('Update Account Deposit');
                            $(".updateDepositBtn").prop("disabled", false);
                        } else if (response.status == 200) {
                            $("#accountdepositupdate_form")[0].reset();
                            removeErrors("#accountdepositupdate_form");
                            $(".updateDepositBtn").html('Update Account Deposit');
                            $(".updateDepositBtn").prop("disabled", false);
                            setTimeout(function() {
                                window.location.reload(true);
                            }, 1000);

                        }
                    }
                });
            })

            //delete transaction
            $(document).on('click', '#delete-btn', function(e) {
                e.preventDefault();
                var itemId = $(this).data('id');
                var url = $(this).attr('href');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
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
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                console.log(response)
                                if (response.success) {
                                    toastr.success(response.message)
                                    location.reload(true);
                                }
                            },
                            error: function(xhr) {
                                console.log(xhr)
                                toastr.error('Sorry unexpected error has occured')
                            }
                        });
                    }
                });
            });

            //showing account holder details
            $('.account_id').on('change', function() {

                var accountId = $(this).val();
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: '{{ route('webmaster.member.profile') }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        accId: accountId,
                    },
                    success: function(response) {

                        if (response.status == 200) {
                            $('#member_profile').html(response.html);
                            $('#withdrawer').val($('#memberName').val())
                        } else {
                            $('#member_profile').html('');
                            $('#withdrawer').val('');
                        }

                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        $('#member_profile').html('');
                        $('#withdrawer').val('');
                    }
                });

            })

        });
    </script>
@endsection
