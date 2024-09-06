@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection
@section('content')
    <div class="page-heading ">
        @php
            $accounts_array = AllChartsOfAccounts();
        @endphp
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="clearfix mb-3">
                        <div class="float-left">
                            <h3 class="card-title">Account Transfers</h3>
                        </div>
                        <div class="float-right">
                            <button type="button" class="btn btn-dark btn-sm btn-theme" data-toggle="modal"
                                data-target="#accounttransferModel">
                                <i class="fa fa-plus"></i> Add Account Transfer
                            </button>
                            <div class="modal fade" id="accounttransferModel">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <h4 class="card-title mb-4"> Account Transfer Form </h4>
                                            <form action="#" method="POST" id="accounttransfer_form">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="debit_account">Transfer From</label>
                                                    <select name="debit_account"
                                                        class="form-control accounts-dropdown debit_account"
                                                        style="width: 100%;" id='debit_account'>
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
                                                <div class="form-group">
                                                    <label for="credit_account">Transfer To</label>
                                                    <select name="credit_account"
                                                        class="form-control accounts-dropdown credit_account"
                                                        style="width: 100%;" id="credit_account">
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
                                                <div class="form-group">
                                                    <label for="amount">Amount</label>
                                                    <input type="text" name="amount" id="amount"
                                                        class="form-control">
                                                    <span class="invalid-feedback"></span>
                                                </div>

                                                <div class="form-group">
                                                    <label for="description">Description</label>
                                                    <textarea name="description" class="form-control" id="description" rows="3"></textarea>
                                                    <span class="invalid-feedback"></span>
                                                </div>
                                                <div class="form-group">
                                                    <label for="date" class="form-label">Transaction Date</label>
                                                    <input type="text" name="date" class="form-control"
                                                        data-provide="datepicker" data-date-autoclose="true"
                                                        data-date-format="yyyy-mm-dd" id="date"
                                                        value="{{ now()->format('Y-m-d') }}" autocomplete="off">
                                                    <span class="invalid-feedback"></span>
                                                </div>
                                                <div class="form-group">
                                                    <button type="button" class="btn btn-danger btn-sm btn-secondary"
                                                        data-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary btn-sm btn-theme"
                                                        id="btn_accounttransfer">Add Account Transfer</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($accounttransfers->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Debit Account</th>
                                        <th>Credit Account</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($accounttransfers as $row)
                                        <tr>
                                            <td>{{ dateFormat($row->date) }}</td>
                                            <td>{!! showAmount($row->amount) !!}</td>
                                            <td>{{ $row->debitaccount->account_no }}</td>
                                            <td>{{ $row->creditaccount->account_no }}</td>
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
                                                            href="{{ route('webmaster.accounttransfer.show', $row->id) }}">
                                                            <i class="fas fa-eye"></i> View Details
                                                        </a>

                                                        <!-- Edit Action -->
                                                        <a class="dropdown-item view-edit-btn"
                                                            href="{{ route('webmaster.accounttransfer.edit', $row->id) }}">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>

                                                        <!-- Delete Action -->
                                                        <a class="dropdown-item"
                                                            href="{{ route('webmaster.accounttransfer.destroy', $row->id) }}"
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

    <!--view modal -->
    <div id="viewModal" class="modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">View Transfer Details</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="transfer-details">

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
    <div id="transferModel" class="modal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-content-demo" id="transfer-details-edit">

            </div>
        </div><!-- modal-dialog -->
    </div><!-- modal -->
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $(".credit_account, .debit_account").select2({
                placeholder: "Select an account",
                allowClear: true,
                dropdownParent: $('#accounttransferModel')
            })
            //   $('#debit_account').change(function() {
            //       var debit_account = $(this).val();
            //       let url = `${baseurl}/webmaster/accounttransfer/getcreditaccounts/${debit_account}`;
            //       $.get(url, function(response) {
            //           $("#credit_account").html(response);
            //       });
            //   });
            $("#accounttransfer_form").submit(function(e) {
                e.preventDefault();
                $("#btn_accounttransfer").html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding'
                );
                $("#btn_accounttransfer").prop("disabled", true);
                $.ajax({
                    url: '{{ route('webmaster.accounttransfer.store') }}',
                    method: 'post',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 400) {
                            if (response.overdraft) {
                                $("#btn_accounttransfer").html('Add Account Transfer');
                                $("#btn_accounttransfer").prop("disabled", false);
                                return toastr.error(response.overdraft)
                            }
                            $.each(response.message, function(key, value) {
                                toastr.error(value);
                                showError(key, value);
                            });
                            $("#btn_accounttransfer").html('Add Account Transfer');
                            $("#btn_accounttransfer").prop("disabled", false);
                        } else if (response.status == 200) {
                            $("#accounttransfer_form")[0].reset();
                            removeErrors("#accounttransfer_form");
                            $("#btn_accounttransfer").html('Add Account Transfer');
                            $("#btn_accounttransfer").prop("disabled", false);
                            setTimeout(function() {
                                window.location.reload();
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
                        $('#transfer-details').html(response.details);
                        $('#viewModal').modal('show')
                    },
                    error: function(xhr) {
                        console.log(response)
                        $('#transfer-details').html(
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
                        $('#transfer-details-edit').html(response.details);
                        $('#transferModel').modal('show')
                    },
                    error: function(xhr) {
                        console.log(response)
                        $('#deposit-details-edit').html(
                            '<p class="text-danger">Unable to load details.</p>');
                    }
                });
            })

            //update
            //store update info
            $(document).on('click', '.updateTransferBtn', function(event) {
                event.preventDefault()
                alert('Hi')
                const url = $("#accounttransferUpdate_form").attr('action')
                $(".btn_accountwithdraw").html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Updating'
                );
                $(".btn_accountwithdraw").prop("disabled", true);
                $.ajax({
                    url: url,
                    method: 'put',
                    data: $("#accounttransferUpdate_form").serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 400) {
                            $.each(response.message, function(key, value) {
                                toastr.error(value)
                                showError(key, value);
                            });
                            $(".updateTransferBtn").html('Update Transfer Withdraw');
                            $(".updateTransferBtn").prop("disabled", false);
                        } else if (response.status == 200) {
                            $("#accounttransferUpdate_form")[0].reset();
                            removeErrors("#accounttransferUpdate_form");
                            $(".updateTransferBtn").html('Update Transfer Withdraw');
                            $(".updateTransferBtn").prop("disabled", false);
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

        });
    </script>
@endsection
