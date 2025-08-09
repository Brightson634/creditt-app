@extends('webmaster.partials.dashboard.main')

@section('title', $page_title)

@section('css')
    <!-- Datatables CSS -->
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap5.min.css" rel="stylesheet" />

    <style>
        .card {
            border-radius: 0.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border: 1px solid #e0e0e0;
            background-color: #fff;
        }

        .card-title {
            font-size: 1.4rem;
            font-weight: 700;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e0e0e0;
            margin-bottom: 0;
        }

        .badge-status {
            font-size: 0.875rem;
            border-radius: 0.375rem;
            padding: 0.4em 0.7em;
            font-weight: 600;
            text-transform: uppercase;
        }

        .badge-info {
            background-color: #17a2b8;
            color: #fff;
        }

        .badge-warning {
            background-color: #ffc107;
            color: #212529;
        }

        .badge-success {
            background-color: #28a745;
            color: #fff;
        }

        .badge-danger {
            background-color: #dc3545;
            color: #fff;
        }

        .badge-secondary {
            background-color: #6c757d;
            color: #fff;
        }

        /* Table hover */
        table.dataTable tbody tr:hover {
            background-color: #f8f9fa;
        }

        .no-data {
            text-align: center;
            margin-top: 4rem;
        }

        /* Modal tweaks */
        .modal-content {
            border-radius: 0.5rem;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
        }

        /* Buttons */
        .btn-indigo {
            background-color: #4f46e5;
            color: #fff;
        }

        .btn-indigo:hover {
            background-color: #4338ca;
            color: #fff;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12 mx-auto">
            @if ($loans->count() > 0)
                <div class="card mt-5 shadow-sm">
                    <h6 class="card-title">{{ $page_title }}</h6>
                    <div class="table-responsive px-3 pb-3">
                        <table id="loansTable" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    {{-- <th>#</th> --}}
                                    <th>Loan No</th>
                                    <th>Member / Group</th>
                                    <th>Loan Product</th>
                                    <th>Principal Amount</th>
                                    <th>Repayment Amount</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($loans as $index => $row)
                                    @php $loan_account_exists = loan_account_exists($row->loan_no); @endphp
                                    <tr>
                                        {{-- <td>{{ $loop->iteration}}</td> --}}
                                        <td>{{ $row->loan_no }}</td>
                                        <td>
                                            @if ($row->loan_type == 'individual')
                                                {{ optional($row->member)->fname }} {{ optional($row->member)->lname }}
                                            @elseif ($row->loan_type == 'group')
                                                {{ $row->member->fname }}
                                            @endif
                                        </td>
                                        <td>{{ optional($row->loanproduct)->name }}</td>
                                        <td>{!! showAmount($row->principal_amount) !!}</td>
                                        <td>{!! showAmount($row->repayment_amount) !!}</td>
                                        <td>
                                            @php
                                                $statusBadges = [
                                                    0 => ['label' => 'Submitted', 'class' => 'badge badge-info'],
                                                    12 => ['label' => 'Under Review', 'class' => 'badge badge-warning'],
                                                    2 => ['label' => 'Reviewed', 'class' => 'badge badge-warning'],
                                                    3 => ['label' => 'Approved', 'class' => 'badge badge-success'],
                                                    13 => ['label' => 'Under Approval', 'class' => 'badge badge-success'],
                                                    4 => ['label' => 'Rejected', 'class' => 'badge badge-danger'],
                                                    9 => ['label' => 'Waiting Review', 'class' => 'badge badge-warning'],
                                                    5 => ['label' => 'Disbursed', 'class' => 'badge badge-success'],
                                                    6 => ['label' => 'Cancelled', 'class' => 'badge badge-danger'],
                                                ];
                                                $status = $statusBadges[$row->status] ?? [
                                                    'label' => 'Unknown',
                                                    'class' => 'badge-secondary',
                                                ];
                                            @endphp
                                            <div
                                                class="{{ $status['class'] }}">{{ $status['label'] }}</div>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-indigo dropdown-toggle" type="button"
                                                    id="loanActions{{ $row->id }}" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                    Actions
                                                </button>
                                                <div class="dropdown-menu"
                                                    aria-labelledby="loanActions{{ $row->id }}">
                                                    @if ($row->status == 3)
                                                        <a class="dropdown-item"
                                                            href="{{ route('webmaster.loan.disburse', $row->loan_no) }}">
                                                            <i class="far fa-edit mr-2"></i>Disburse Loan
                                                        </a>
                                                    @endif
                                                    @if ($row->status == 0 || $row->status == 12)
                                                        <a class="dropdown-item"
                                                            href="{{ route('webmaster.loan.review', $row->loan_no) }}">
                                                            <i class="far fa-edit mr-2"></i>Review Loan
                                                        </a>
                                                    @endif
                                                    @if ($row->status == 9)
                                                        <a class="dropdown-item"
                                                            href="{{ route('webmaster.loan.edit', $row->id) }}">
                                                            <i class="far fa-edit mr-2"></i>Update Loan
                                                        </a>
                                                    @endif
                                                    @if ($row->status == 2 || $row->status == 13)
                                                        <a class="dropdown-item"
                                                            href="{{ route('webmaster.loan.approval', $row->loan_no) }}">
                                                            <i class="far fa-edit mr-2"></i>Approve Loan
                                                        </a>
                                                    @endif
                                                    @if ($row->status == 5 && !$loan_account_exists)
                                                        <a class="dropdown-item btn-generate"
                                                            href="{{ route('webmaster.loan.generate_schedule', ['id' => $row->id]) }}"
                                                            data-loan="{{ $row->loan_no }}">
                                                            <i class="far fa-calendar-alt mr-2"></i>Generate Schedule
                                                        </a>
                                                    @endif
                                                    <a class="dropdown-item"
                                                        href="{{ route('webmaster.loan.preview', $row->loan_no) }}">
                                                        <i class="far fa-eye mr-2"></i>Preview Loan
                                                    </a>
                                                </div>
                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="d-flex flex-column align-items-center mt-5 no-data">
                    <img src="{{ asset('assets/uploads/defaults/nodata.png') }}" width="200" alt="No Data">
                    <span class="mt-3 fs-5 text-muted">No Data Available</span>
                </div>
            @endif
        </div>
    </div>

    <!-- Generate Repayment Schedule Modal (Bootstrap 5) -->
    <div id="genModal" class="modal fade" tabindex="-1" aria-labelledby="genModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content shadow-sm rounded-3 border-0">

                <div class="modal-header text-white">
                    <h5 class="modal-title fw-bold" id="genModalLabel">
                        <i class="fas fa-calendar-alt me-2"></i> Generate Repayment Schedule
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="" id="genForm" method="POST" class="needs-validation" novalidate>
                    @csrf
                    <div class="modal-body">

                        <div class="alert alert-info small mb-4 d-flex align-items-center">
                            <i class="fas fa-info-circle me-2"></i>
                            The following member loan account will be created for tracking the disbursed loan funds.
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="loan_account_no" class="form-label fw-semibold">Loan Account No</label>
                                <input type="text" readonly name="loan_account_no" id="loan_account_no"
                                    class="form-control" />
                            </div>

                            <div class="col-md-6">
                                @php $account_sub_types = getParentAccounts(); @endphp
                                <label for="parent_id" class="form-label fw-semibold">Parent Account</label>
                                <select name="parent_id" id="parent_id" class="form-select select2" required
                                    style="width: 100%;">
                                    <option value="">Select Parent Account</option>
                                    @foreach ($account_sub_types as $account_type)
                                        <option value="{{ $account_type->id }}">{{ $account_type->account_type_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a parent account for loan member account.</div>
                            </div>
                        </div>

                        <div class="row g-3 mt-2">
                            @php $accounts_array = AllChartsOfAccounts(); @endphp
                            <div class="col-md-6">
                                <label for="disbursement_account" class="form-label fw-semibold">Disbursement
                                    Account</label>
                                <select name="disbursement_account" id="disbursement_account"
                                    class="form-select select2 accounts-dropdown" required style="width: 100%;">
                                    <option value="">Select Account</option>
                                    @foreach ($accounts_array as $account)
                                        <option value="{{ $account['id'] }}" data-currency="{{ $account['currency'] }}">
                                            {{ $account['name'] }} - {{ $account['primaryType'] }} -
                                            {{ $account['subType'] }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a disbursement account.</div>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-indigo px-4">
                            <i class="fas fa-check-circle me-1"></i> Generate
                        </button>
                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Close
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Datatables JS + dependencies -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <!-- Datatables Buttons for export -->
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>

    <!-- Toastr -->
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script> --}}

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#loansTable').DataTable({
                responsive: true,
                dom: 'Bfrtip',
                buttons: ['copy', 'excel', 'csv', 'pdf', 'print'],
                pageLength: 15,
                order: [
                    [1, 'desc']
                ],
                language: {
                    emptyTable: "No loans found."
                }
            });

            // Initialize Select2 inside modal
            $('.select2').select2({
                dropdownParent: $('#genModal')
            });

            // Open modal and set data on Generate Schedule click
            $(document).on('click',".btn-generate", function(event) {
                event.preventDefault();
                let href = $(this).attr('href');
                let loan_number = $(this).data('loan');
                $('#loan_account_no').val(loan_number);
                $("#genForm").attr('action', href);
                $('#genModal').modal('show');
            });

            // Bootstrap validation for form
            $('#genForm').on('submit', function(e) {
                let form = this;
                if (!form.checkValidity()) {
                    e.preventDefault();
                    e.stopPropagation();
                    $(form).addClass('was-validated');
                    $(form).find(':invalid').first().focus();
                    return false;
                }
                return true;
            });

            // Toastr flash messages
            @if (session('success'))
                toastr.success(@json(session('success')));
            @endif

            @if (session('error'))
                toastr.error(@json(session('error')));
            @endif

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    toastr.error(@json($error));
                @endforeach
            @endif
        });
    </script>
@endsection
