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
                    <div class="float-right">
                        <div class="modal fade" id="categoryModel">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <h4 class="card-title mb-4">Expense Category </h4>
                                        <form action="#" method="POST" id="category_form">
                                            @csrf
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input type="text" name="name" id="name" class="form-control">
                                                <span class="invalid-feedback"></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="code">Code</label>
                                                <input type="text" name="code" id="code" class="form-control">
                                                <span class="invalid-feedback"></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="expenseAccount">Expense Account</label>
                                                <select class='form-control' name='expenseAccount' id='expenseAccount'
                                                    style="width:100%">
                                                    <option value="">Select Account</option>
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
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="is_subcat" class="custom-control-input"
                                                        id="is_subcat">
                                                    <label class="custom-control-label" for="is_subcat">Add as
                                                        Sub-Category</label>
                                                </div>
                                            </div>
                                            <div id="subCatDiv" style="display: none">
                                                <div class="form-group">
                                                    <label for="parent_id">Select Parent Category</label>
                                                    <select class="form-control" name="parent_id" id="parent_id">
                                                        <option value="">select parent category</option>
                                                        @foreach ($categories as $data)
                                                            <option value="{{ $data->id }}">{{ $data->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="description">Description</label>
                                                <textarea name="description" class="form-control" id="description" rows="3"></textarea>
                                                <span class="invalid-feedback"></span>
                                            </div>
                                            <div class="form-group">
                                                <button type="button" class="btn btn-sm btn-secondary"
                                                    data-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary btn-sm btn-theme"
                                                    id="btn_category">Add Category</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    @if ($categories->count() > 0)
                        <div class="card card-dashboard-table-six">
                            <h6 class="card-title">Expense Categories <div class="float-right">
                                    <button type="button" class="btn btn-sm btn-dark btn-theme" data-toggle="modal"
                                        data-target="#categoryModel">
                                        <i class="fa fa-plus"></i> Add Category
                                    </button>
                                </div>
                            </h6>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Category</th>
                                            <th>Code</th>
                                            <th>Account</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $i = 0; @endphp
                                        @foreach ($categories as $row)
                                            <tr>
                                                <td>{{ $row->name }}</td>
                                                <td>{{ $row->code }}</td>
                                                <td>{{ $row->expense_account }}</td>
                                                <td>
                                                    <a href="#" class="btn btn-xs btn-dark" id='editExpense'
                                                        data-href="{{ action([\App\Http\Controllers\Webmaster\ExpenseCategoryController::class, 'edit'], $row->id) }}">
                                                        <i class="far fa-edit"></i>
                                                        Edit</a>
                                                </td>
                                                <tr>
                                                    @php
                                                        $subcategories = \App\Models\ExpenseCategory::where('is_subcat', 1)
                                                            ->where('parent_id', $row->id)
                                                            ->get();
                                                
                                                        // Create an associative array for quick lookup of accounts
                                                        $accounts_lookup = [];
                                                        foreach ($accounts_array as $account) {
                                                            $accounts_lookup[$account['id']] = $account['name'] . '-' . $account['primaryType'];
                                                        }
                                                    @endphp
                                                
                                                    @foreach ($subcategories as $subcat)
                                                        <tr>
                                                            <td style="padding-left: 30px;">{{ $subcat->name }}</td>
                                                            <td>{{ $subcat->code }}</td>
                                                            <td>
                                                                @php
                                                                    $expense_account_display = isset($accounts_lookup[$subcat->expense_account])
                                                                        ? $accounts_lookup[$subcat->expense_account]
                                                                        : $subcat->expense_account;
                                                                @endphp
                                                                {{ $expense_account_display }}
                                                            </td>
                                                            <td>
                                                                <a href="#" class="btn btn-xs btn-dark" id='editExpense'
                                                                    data-href="{{ action([\App\Http\Controllers\Webmaster\ExpenseCategoryController::class, 'edit'], $subcat->id) }}">
                                                                    <i class="far fa-edit"></i>
                                                                    Edit</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tr>
                                                
                    @endforeach
                    </tbody>
                    </table>
                </div>
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

    <div class="modal fade" id="categoryUpdateModel">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" id="modalContent">

            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        $('#expenseAccount').select2();
        $('input[name="is_subcat"]').on('change', function() {
            if ($(this).prop('checked')) {
                $('#subCatDiv').show();
            } else {
                $('#subCatDiv').hide();
            }
        });

        $("#category_form").submit(function(e) {
            e.preventDefault();
            $("#btn_category").html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding'
            );
            $("#btn_v").prop("disabled", true);
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
                        $("#btn_category").html('Add Category');
                        $("#btn_category").prop("disabled", false);
                    } else if (response.status == 200) {
                        $("#category_form")[0].reset();
                        removeErrors("#category_form");
                        $("#btn_category").html('Add Category');
                        $("#btn_category").prop("disabled", false);
                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);

                    }
                }
            });
        });

        //edit
        $(document).on('click', '#editExpense', function() {
            const $url = $(this).data('href')
            $.ajax({
                type: "get",
                url: $url,
                success: function(response) {
                    console.log(response)
                    $("#modalContent").html(response.html)
                    $("#categoryUpdateModel").modal("show")
                },
                error: function(xhr) {
                    console.log(xhr)
                    toastr.warning("Something went wrong")
                }
            });
        });
        //send updated data
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
                        $("#categoryUpdateModel").modal("hide")
                    } else if (response.status === 400) {
                        // Display validation errors
                        $.each(response.message, function(key, value) {
                            toastr.error(value);
                        });
                    } else {
                        toastr.error('Something went wrong!');
                    }
                },
                error: function(xhr) {
                    toastr.error('Something went wrong!');
                }
            });
        });
    </script>
@endsection
