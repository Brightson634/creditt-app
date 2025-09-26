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
        @can('add_category')
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#categoryModel">
                <i class="fa fa-plus-circle"></i> Add Category
            </button>
        @endcan
    </div>

    <div class="row rounded-lg bg-white p-2">
        @if ($categories->count() > 0)
            <div class="table-responsive">
                <table class="table table-sm table-bordered table-striped table-hover data-table">
                    <thead class="thead-light">
                        <tr>
                            <th>Category</th>
                            <th>Code</th>
                            <th>Account</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $row)
                            <tr>
                                <td>{{ $row->name }}</td>
                                <td>{{ $row->code }}</td>
                                <td>{{ $row->expense_account }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-primary dropdown-toggle" type="button"
                                            data-toggle="dropdown">
                                            Actions
                                        </button>
                                        <div class="dropdown-menu shadow animated--fade-in">
                                            @can('edit_category')
                                                <a class="dropdown-item" href="javascript:void(0)" id="editExpense"
                                                    data-href="{{ action([\App\Http\Controllers\Webmaster\ExpenseCategoryController::class, 'edit'], $row->id) }}">
                                                    <i class="far fa-edit text-primary"></i> Edit
                                                </a>
                                            @endcan

                                            @can('delete_category')
                                                <form action="{{ route('webmaster.expensecategory.destroy', $row->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger"
                                                        onclick="return confirm('Are you sure?')">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            {{-- Subcategories --}}
                            @php
                                $subcategories = \App\Models\ExpenseCategory::where('is_subcat', 1)
                                    ->where('parent_id', $row->id)
                                    ->get();

                                $accounts_lookup = [];
                                foreach ($accounts_array as $account) {
                                    $accounts_lookup[$account['id']] = $account['name'] . '-' . $account['primaryType'];
                                }
                            @endphp
                            @foreach ($subcategories as $subcat)
                                <tr>
                                    <td style="padding-left: 30px;">{{ $subcat->name }}</td>
                                    <td>{{ $subcat->code }}</td>
                                    <td>{{ $accounts_lookup[$subcat->expense_account] ?? $subcat->expense_account }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-primary dropdown-toggle" type="button"
                                                data-toggle="dropdown">
                                                Actions
                                            </button>
                                            <div class="dropdown-menu shadow animated--fade-in">
                                                @can('edit_category')
                                                    <a class="dropdown-item" href="javascript:void(0)" id="editExpense"
                                                        data-href="{{ action([\App\Http\Controllers\Webmaster\ExpenseCategoryController::class, 'edit'], $subcat->id) }}">
                                                        <i class="far fa-edit text-primary"></i> Edit
                                                    </a>
                                                @endcan

                                                @can('delete_category')
                                                    <form
                                                        action="{{ route('webmaster.expensecategory.destroy', $subcat->id) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger"
                                                            onclick="return confirm('Are you sure?')">
                                                            <i class="fas fa-trash"></i> Delete
                                                        </button>
                                                    </form>
                                                @endcan
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
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

    {{-- Add Category Modal --}}
    <div class="modal fade" id="categoryModel">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h4 class="card-title mb-4">Expense Category</h4>
                    <form action="#" method="POST" id="category_form">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="code">Code</label>
                            <input type="text" name="code" id="code" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="expenseAccount">Expense Account</label>
                            <select class="form-control" name="expenseAccount" id="expenseAccount" style="width:100%">
                                <option value="">Select Account</option>
                                @foreach ($accounts_array as $account)
                                    <option value="{{ $account['id'] }}" data-currency="{{ $account['currency'] }}">
                                        {{ $account['name'] }} - {{ $account['primaryType'] }} -
                                        {{ $account['subType'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="is_subcat" class="custom-control-input" id="is_subcat">
                                <label class="custom-control-label" for="is_subcat">Add as Sub-Category</label>
                            </div>
                        </div>
                        <div id="subCatDiv" style="display: none">
                            <div class="form-group">
                                <label for="parent_id">Select Parent Category</label>
                                <select class="form-control" name="parent_id" id="parent_id">
                                    <option value="">Select Parent Category</option>
                                    @foreach ($categories as $data)
                                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control" id="description" rows="3"></textarea>
                        </div>
                        <div class="form-group d-flex justify-content-end">
                            <button type="button" class="btn btn-sm btn-secondary mr-2"
                                data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary btn-sm" id="btn_category">Add Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Update Category Modal --}}
    <div class="modal fade" id="categoryUpdateModel">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" id="modalContent"></div>
        </div>
    </div>
@endsection


@section('scripts')
    <script type="text/javascript">
        $('#expenseAccount').select2();
        $('input[name="is_subcat"]').on('change', function() {
            $('#subCatDiv').toggle($(this).prop('checked'));
        });

        $("#category_form").submit(function(e) {
            e.preventDefault();
            $("#btn_category").html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding'
            ).prop("disabled", true);

            $.ajax({
                url: '{{ route('webmaster.expensecategory.store') }}',
                method: 'post',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == 400) {
                        $.each(response.message, function(key, value) {
                            showError(key, value);
                        });
                        $("#btn_category").html('Add Category').prop("disabled", false);
                    } else if (response.status == 200) {
                        $("#category_form")[0].reset();
                        removeErrors("#category_form");
                        $("#btn_category").html('Add Category').prop("disabled", false);
                        setTimeout(() => window.location.reload(), 1000);
                    }
                }
            });
        });

        $(document).on('click', '#editExpense', function() {
            $.ajax({
                type: "get",
                url: $(this).data('href'),
                success: function(response) {
                    $("#modalContent").html(response.html);
                    alert('God is good')
                    $('#expenseAccount').select2();
                    $("#categoryUpdateModel").modal("show");
                },
                error: function(xhr) {
                    if (xhr.status === 403) {
                        toastr.error(xhr.responseJSON.message);
                    } else {
                        toastr.warning("Something went wrong");
                    }
                }
            });
        });

        $(document).on('click', '#btn_update_category', function() {
            var form = $('#category_form_update');
            $.ajax({
                type: "post",
                url: '{{ route('webmaster.expensecategory.update') }}',
                data: form.serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status === 200) {
                        toastr.success(response.message);
                        $("#categoryUpdateModel").modal("hide");
                    } else if (response.status === 400) {
                        $.each(response.message, function(key, value) {
                            toastr.error(value);
                        });
                    } else {
                        toastr.error('Something went wrong!');
                    }
                },
                error: function() {
                    toastr.error('Something went wrong!');
                }
            });
        });
    </script>
@endsection
