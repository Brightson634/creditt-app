@extends('webmaster.partials.dashboard.main')

@section('title')
    {{ $page_title }}
@endsection

@section('css')
    <style>
        .custom-card {
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .custom-table thead th {
            background-color: #f8f9fa;
        }

        .custom-table tbody tr {
            transition: background-color 0.3s ease;
        }

        .custom-table tbody tr:hover {
            background-color: #f1f1f1;
        }

        .card-body {
            padding: 1.5rem;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
    </style>
@endsection

@section('content')
    <div class="d-flex justify-content-end align-items-center p-2">
        @can('add_expenses')
            <a class="btn btn-primary btn-sm" href="{{ route('webmaster.expense.create') }}">
                <i class="fas fa-plus-circle"></i> Add Expense
            </a>
        @endcan
    </div>

    <div class="row rounded-lg bg-white p-2">
        @if ($expenses->count() > 0)
            <div class="table-responsive">
                <table class="table table-sm table-bordered table-striped table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Expense</th>
                            <th>Category</th>
                            <th>Amount</th>
                            <th>Created By</th>
                            <th>Date Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 0; @endphp
                        @foreach ($expenses as $row)
                            @php $i++; @endphp
                            <tr>
                                <th scope="row">{{ $i }}</th>
                                <td>{{ $row->name }}</td>
                                <td>{{ optional($row->subcategory)->name ?? getParentExpenseCategoryName($row->category_id) }}
                                </td>
                                <td>{!! showAmount($row->amount) !!}</td>
                                <td>{{ $row->staff ? $row->staff->fname . ' ' . $row->staff->lname : 'N/A' }}</td>
                                <td>{{ $row->created_at->format('F d, Y') }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-primary dropdown-toggle" type="button"
                                            data-toggle="dropdown">
                                            Actions
                                        </button>
                                        <div class="dropdown-menu shadow animated--fade-in">
                                            @can('edit_expenses')
                                                <a class="dropdown-item" href="{{ route('webmaster.expense.edit', $row->id) }}">
                                                    <i class="far fa-edit text-primary"></i> Edit
                                                </a>
                                            @endcan

                                            @can('delete_expenses')
                                                <form action="{{ route('webmaster.expense.destroy', $row->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger"
                                                        onclick="return confirm('Are you sure?')">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                            @endcan

                                            <a href="javascript:void(0)" class="dropdown-item text-info" data-toggle="modal"
                                                data-target="#refundModel{{ $row->id }}">
                                                <i class="far fa-eye"></i> Refund
                                            </a>
                                        </div>
                                    </div>

                                    {{-- Refund Modal --}}
                                    <div class="modal fade" id="refundModel{{ $row->id }}" tabindex="-1"
                                        role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Refund Expense: {{ $row->name }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    {{-- Expense Information --}}
                                                    <h5 class="mb-3">Expense Information</h5>
                                                    <div class="mb-4">
                                                        <p class="mb-2"><strong>Expense:</strong> {{ $row->name }}</p>
                                                        <p class="mb-2"><strong>Category:</strong>
                                                            {{ optional($row->category)->name }} /
                                                            {{ optional($row->subcategory)->name }}
                                                        </p>
                                                        <p class="mb-2"><strong>Amount:</strong> {!! showAmount($row->amount) !!}
                                                        </p>
                                                        <p class="mb-2"><strong>Date:</strong>
                                                            {{ dateFormat($row->date) }}</p>
                                                        <p class="mb-2"><strong>Account:</strong>
                                                            {{ optional($row->account)->name }}</p>
                                                    </div>

                                                    {{-- Refund Info Form --}}
                                                    <h5 class="mb-3">Refund Information</h5>
                                                    <form id="expense_form" method="POST"
                                                        action="{{ route('webmaster.expenserefund.store') }}">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="amount" class="form-label">Amount</label>
                                                                    <input type="text" name="amount"
                                                                        class="form-control"
                                                                        placeholder="Enter refund amount">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="form-group">
                                                                    <label for="paymenttype_id" class="form-label">Payment
                                                                        Type</label>
                                                                    <select class="form-control" name="paymenttype_id">
                                                                        <option value="">Select payment type</option>
                                                                        @foreach ($payments as $data)
                                                                            <option value="{{ $data->id }}">
                                                                                {{ $data->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label">Payment Account</label>
                                                                    <select name="account_id_pay" class="form-control">
                                                                        <option value="">Select Account</option>
                                                                        @foreach ($accounts_array as $account)
                                                                            <option value="{{ $account['id'] }}">
                                                                                {{ $account['name'] }} -
                                                                                {{ $account['primaryType'] }} -
                                                                                {{ $account['subType'] }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label">Expense Account</label>
                                                                    <select name="account_id_expense" class="form-control">
                                                                        <option value="">Select Account</option>
                                                                        @foreach ($accounts_array as $account)
                                                                            <option value="{{ $account['id'] }}">
                                                                                {{ $account['name'] }} -
                                                                                {{ $account['primaryType'] }} -
                                                                                {{ $account['subType'] }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label">Paid On</label>
                                                                    <input type="text" name="date"
                                                                        class="form-control datepicker"
                                                                        value="{{ now()->format('Y-m-d') }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label">Description</label>
                                                                    <textarea name="description" class="form-control" rows="2" placeholder="Enter description"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="submit" id="btn_expense"
                                                                class="btn btn-primary">Submit Refund</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- End Refund Modal --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="d-flex flex-column align-items-center mt-5">
                <img src="{{ asset('assets/uploads/defaults/nodata.png') }}" width="200" alt="No Data">
                <span class="mt-3 text-muted">No Data Available</span>
            </div>
        @endif
    </div>
@endsection



@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('select.account_id').select2();
            $("#expense_form").submit(function(e) {
                e.preventDefault();
                $("#btn_expense").html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding'
                );
                $("#btn_expense").prop("disabled", true);
                $.ajax({
                    url: '{{ route('webmaster.expenserefund.store') }}',
                    method: 'post',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 400) {
                            $.each(response.message, function(key, value) {
                                showError(key, value);
                            });
                            $("#btn_expense").html('Add Expense');
                            $("#btn_expense").prop("disabled", false);
                        } else if (response.status == 200) {
                            $("#expense_form")[0].reset();
                            removeErrors("#expense_form");
                            $("#btn_expense").html('Add Expense');
                            $("#btn_expense").prop("disabled", false);
                            setTimeout(function() {
                                window.location.href = response.url;
                            }, 1000);
                        }
                    }
                });
            });
        });
    </script>
@endsection
