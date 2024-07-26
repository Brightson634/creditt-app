@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection

@section('content')

    @include('webmaster.partials.nav')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black">Settings</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#account_setting" data-toggle="tab" aria-expanded="true">
                                Accounting Settings / Map Transactions
                            </a>
                        </li>

                        <li>
                            <a href="#sub_type_tab" data-toggle="tab" aria-expanded="true">
                                Account Sub Type
                            </a>
                        </li>
                        <li>
                            <a href="#detail_type_tab" data-toggle="tab" aria-expanded="true">
                                Detail Type
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">

                        <div class="tab-pane active" id="account_setting">
                            {!! Form::open([
                                'action' => '\App\Http\Controllers\Webmaster\SettingsAccController@saveSettings',
                                'method' => 'post',
                            ]) !!}
                            <div class="row mb-12">
                                <div class="col-md-4">
                                    <button type="button"
                                        class="tw-dw-btn tw-dw-btn-error tw-text-white tw-dw-btn-sm accounting_reset_data"
                                        data-href="{{ action([\App\Http\Controllers\Webmaster\SettingsAccController::class, 'resetData']) }}">
                                        Reset Data
                                    </button>
                                </div>
                            </div>
                            <br>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('journal_entry_prefix', 'Journal Entry Prefix' . ':') !!}
                                        {!! Form::text(
                                            'journal_entry_prefix',
                                            !empty($accounting_settings['journal_entry_prefix']) ? $accounting_settings['journal_entry_prefix'] : '',
                                            ['class' => 'form-control ', 'id' => 'journal_entry_prefix'],
                                        ) !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('transfer_prefix', 'Transfer Prefix' . ':') !!}
                                        {!! Form::text(
                                            'transfer_prefix',
                                            !empty($accounting_settings['transfer_prefix']) ? $accounting_settings['transfer_prefix'] : '',
                                            ['class' => 'form-control ', 'id' => 'transfer_prefix'],
                                        ) !!}
                                    </div>
                                </div>
                            </div>

                            <hr />

                            <h3 data-toggle="tooltip-primary"
                                title='Set Default Accounts to which transactions will be automatically mapped'
                                style="cursor: pointer;width:270px">Map Transactions</h3>

                            @foreach ($business_locations as $business_location)
                                @component('webmaster.components.widget', ['title' => $business_location->name])
                                    @php
                                        $default_map = json_decode($business_location->accounting_default_map, true);
                                        //print_r($default_map);exit;

                                        $sale_payment_account = isset($default_map['sale']['payment_account'])
                                            ? \App\Entities\AccountingAccount::find(
                                                $default_map['sale']['payment_account'],
                                            )
                                            : null;

                                        $sale_deposit_to = isset($default_map['sale']['deposit_to'])
                                            ? \App\Entities\AccountingAccount::find($default_map['sale']['deposit_to'])
                                            : null;

                                        $sales_payments_payment_account = isset(
                                            $default_map['sell_payment']['payment_account'],
                                        )
                                            ? \App\Entities\AccountingAccount::find(
                                                $default_map['sell_payment']['payment_account'],
                                            )
                                            : null;

                                        $sales_payments_deposit_to = isset($default_map['sell_payment']['deposit_to'])
                                            ? \App\Entities\AccountingAccount::find(
                                                $default_map['sell_payment']['deposit_to'],
                                            )
                                            : null;

                                        $purchases_payment_account = isset($default_map['purchases']['payment_account'])
                                            ? \App\Entities\AccountingAccount::find(
                                                $default_map['purchases']['payment_account'],
                                            )
                                            : null;

                                        $purchases_deposit_to = isset($default_map['purchases']['deposit_to'])
                                            ? \App\Entities\AccountingAccount::find(
                                                $default_map['purchases']['deposit_to'],
                                            )
                                            : null;

                                        $purchase_payments_payment_account = isset(
                                            $default_map['purchase_payment']['payment_account'],
                                        )
                                            ? \App\Entities\AccountingAccount::find(
                                                $default_map['purchase_payment']['payment_account'],
                                            )
                                            : null;

                                        $purchase_payments_deposit_to = isset(
                                            $default_map['purchase_payment']['deposit_to'],
                                        )
                                            ? \App\Entities\AccountingAccount::find(
                                                $default_map['purchase_payment']['deposit_to'],
                                            )
                                            : null;

                                        $expense_payment_account = isset($default_map['expense']['payment_account'])
                                            ? \App\Entities\AccountingAccount::find(
                                                $default_map['expense']['payment_account'],
                                            )
                                            : null;

                                        $expense_deposit_to = isset($default_map['expense']['deposit_to'])
                                            ? \App\Entities\AccountingAccount::find(
                                                $default_map['expense']['deposit_to'],
                                            )
                                            : null;

                                    @endphp

                                    <strong>Sell</strong>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('payment_account', 'Payment Account' . ':') !!}
                                                {!! Form::select(
                                                    'payment_account',
                                                    !is_null($sale_payment_account) ? [$sale_payment_account->id => $sale_payment_account->name] : [],
                                                    $sale_payment_account->id ?? null,
                                                    [
                                                        'class' => 'form-control accounts-dropdown width-100',
                                                        'placeholder' => 'Payment Account',
                                                        'name' => "accounting_default_map[$business_location->id][sale][payment_account]",
                                                        'id' => $business_location->id . 'sale_payment_account',
                                                    ],
                                                ) !!}
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('deposit_to', 'Deposit to' . ':') !!}
                                                {!! Form::select(
                                                    'deposit_to',
                                                    !is_null($sale_deposit_to) ? [$sale_deposit_to->id => $sale_deposit_to->name] : [],
                                                    $sale_deposit_to->id ?? null,
                                                    [
                                                        'class' => 'form-control accounts-dropdown width-100',
                                                        'placeholder' => 'Deposit to',
                                                        'name' => "accounting_default_map[$business_location->id][sale][deposit_to]",
                                                        'id' => $business_location->id . '_sale_deposit_to',
                                                    ],
                                                ) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <strong>Sales Payments</strong>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('payment_account', 'Payment account' . ':') !!}
                                                {!! Form::select(
                                                    'payment_account',
                                                    !is_null($sales_payments_payment_account)
                                                        ? [$sales_payments_payment_account->id => $sales_payments_payment_account->name]
                                                        : [],
                                                    $sales_payments_payment_account->id ?? null,
                                                    [
                                                        'class' => 'form-control accounts-dropdown width-100',
                                                        'placeholder' => 'Payment account',
                                                        'name' => "accounting_default_map[$business_location->id][sell_payment][payment_account]",
                                                        'id' => $business_location->id . 'sales_payments_payment_account',
                                                    ],
                                                ) !!}
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('deposit_to', 'Deposit to' . ':') !!}
                                                {!! Form::select(
                                                    'deposit_to',
                                                    !is_null($sales_payments_deposit_to) ? [$sales_payments_deposit_to->id => $sales_payments_deposit_to->name] : [],
                                                    $sales_payments_deposit_to->id ?? null,
                                                    [
                                                        'class' => 'form-control accounts-dropdown width-100',
                                                        'placeholder' => 'Deposit to',
                                                        'name' => "accounting_default_map[$business_location->id][sell_payment][deposit_to]",
                                                        'id' => $business_location->id . 'sales_payments_deposit_to',
                                                    ],
                                                ) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <hr>
                                    <strong>Purchases</strong>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('payment_account', 'Payment account' . ':') !!}
                                                {!! Form::select(
                                                    'payment_account',
                                                    !is_null($purchases_payment_account) ? [$purchases_payment_account->id => $purchases_payment_account->name] : [],
                                                    $purchases_payment_account->id ?? null,
                                                    [
                                                        'class' => 'form-control accounts-dropdown width-100',
                                                        'placeholder' => 'Payment Account',
                                                        'name' => "accounting_default_map[$business_location->id][purchases][payment_account]",
                                                        'id' => $business_location->id . 'purchases_payment_account',
                                                    ],
                                                ) !!}
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('deposit_to', 'Deposit to' . ':') !!}
                                                {!! Form::select(
                                                    'deposit_to',
                                                    !is_null($purchases_deposit_to) ? [$purchases_deposit_to->id => $purchases_deposit_to->name] : [],
                                                    $purchases_deposit_to->id ?? null,
                                                    [
                                                        'class' => 'form-control accounts-dropdown width-100',
                                                        'placeholder' => 'Deposit to',
                                                        'name' => "accounting_default_map[$business_location->id][purchases][deposit_to]",
                                                        'id' => $business_location->id . '_purchases_deposit_to',
                                                    ],
                                                ) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <hr>
                                    <strong>Purchase Payments</strong>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('payment_account', 'Payment account' . ':') !!}
                                                {!! Form::select(
                                                    'payment_account',
                                                    !is_null($purchase_payments_payment_account)
                                                        ? [$purchase_payments_payment_account->id => $purchase_payments_payment_account->name]
                                                        : [],
                                                    $purchase_payments_payment_account->id ?? null,
                                                    [
                                                        'class' => 'form-control accounts-dropdown width-100',
                                                        'placeholder' => 'Payment Account',
                                                        'name' => "accounting_default_map[$business_location->id][purchase_payment][payment_account]",
                                                        'id' => $business_location->id . 'purchase_payments_payment_account',
                                                    ],
                                                ) !!}
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('deposit_to', 'Deposit to' . ':') !!}
                                                {!! Form::select(
                                                    'deposit_to',
                                                    !is_null($purchase_payments_deposit_to)
                                                        ? [$purchase_payments_deposit_to->id => $purchase_payments_deposit_to->name]
                                                        : [],
                                                    $purchase_payments_deposit_to->id ?? null,
                                                    [
                                                        'class' => 'form-control accounts-dropdown width-100',
                                                        'placeholder' => 'Deposit to',
                                                        'name' => "accounting_default_map[$business_location->id][purchase_payment][deposit_to]",
                                                        'id' => $business_location->id . '_purchase_payments_deposit_to',
                                                    ],
                                                ) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div style="background-color: #2dce89 !important; padding:10px">
                                        <strong>Expenses</strong>
                                        <div class="row m-2">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {!! Form::label('payment_account', 'Payment account' . ':') !!}
                                                    {!! Form::select(
                                                        'payment_account',
                                                        !is_null($expense_payment_account) ? [$expense_payment_account->id => $expense_payment_account->name] : [],
                                                        $expense_payment_account->id ?? null,
                                                        [
                                                            'class' => 'form-control accounts-dropdown width-100',
                                                            'placeholder' => 'Payment account',
                                                            'name' => "accounting_default_map[$business_location->id][expense][payment_account]",
                                                            'id' => $business_location->id . 'expense_payment_account',
                                                        ],
                                                    ) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {!! Form::label('deposit_to', 'Deposit to' . ':') !!}
                                                    {!! Form::select(
                                                        'deposit_to',
                                                        !is_null($expense_deposit_to) ? [$expense_deposit_to->id => $expense_deposit_to->name] : [],
                                                        $expense_deposit_to->id ?? null,
                                                        [
                                                            'class' => 'form-control accounts-dropdown width-100',
                                                            'placeholder' => 'Deposit to',
                                                            'name' => "accounting_default_map[$business_location->id][expense][deposit_to]",
                                                            'id' => $business_location->id . '_expense_deposit_to',
                                                        ],
                                                    ) !!}
                                                </div>
                                            </div>
                                        </div>

                                        @foreach ($expence_categories as $expence_category)
                                            @php
                                                $dynamic_variable_payment_account = isset(
                                                    $default_map['expense_' . $expence_category->id]['payment_account'],
                                                )
                                                    ? \App\Entities\AccountingAccount::find(
                                                        $default_map['expense_' . $expence_category->id][
                                                            'payment_account'
                                                        ],
                                                    )
                                                    : null;
                                            @endphp
                                            <strong>Expenses {{ $expence_category->name }}</strong>
                                            <div class="row m-2">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        {!! Form::label('payment_account', 'Payment account' . ':') !!}
                                                        {!! Form::select(
                                                            'payment_account',
                                                            !is_null($dynamic_variable_payment_account)
                                                                ? [$dynamic_variable_payment_account->id => $dynamic_variable_payment_account->name]
                                                                : [],
                                                            $dynamic_variable_payment_account->id ?? null,
                                                            [
                                                                'class' => 'form-control accounts-dropdown width-100',
                                                                'placeholder' => 'Payment Account',
                                                                'name' => "accounting_default_map[$business_location->id][expense_$expence_category->id][payment_account]",
                                                                'id' => $business_location->id . 'expense_' . $expence_category->id . '_payment_account',
                                                            ],
                                                        ) !!}
                                                    </div>
                                                </div>
                                                @php
                                                    $dynamic_variable_deposit_to = isset(
                                                        $default_map['expense_' . $expence_category->id]['deposit_to'],
                                                    )
                                                        ? \App\Entities\AccountingAccount::find(
                                                            $default_map['expense_' . $expence_category->id][
                                                                'deposit_to'
                                                            ],
                                                        )
                                                        : null;
                                                @endphp
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        {!! Form::label('deposit_to', 'Deposit to' . ':') !!}
                                                        {!! Form::select(
                                                            'deposit_to',
                                                            !is_null($dynamic_variable_deposit_to)
                                                                ? [$dynamic_variable_deposit_to->id => $dynamic_variable_deposit_to->name]
                                                                : [],
                                                            $dynamic_variable_deposit_to->id ?? null,
                                                            [
                                                                'class' => 'form-control accounts-dropdown width-100',
                                                                'placeholder' => 'Deposit to',
                                                                'name' => "accounting_default_map[$business_location->id][expense_$expence_category->id][deposit_to]",
                                                                'id' => $business_location->id . '_expense_deposit_to',
                                                            ],
                                                        ) !!}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endcomponent
                            @endforeach

                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <div class="form-group">
                                        {{ Form::submit('Update', ['class' => 'tw-dw-btn tw-dw-btn-primary tw-text-white tw-dw-btn-lg']) }}
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>



                        <div class="tab-pane" id="sub_type_tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <button
                                        class="tw-dw-btn tw-bg-gradient-to-r tw-from-indigo-600 tw-to-blue-500 tw-font-bold tw-text-white tw-border-none tw-rounded-full pull-right"id="add_account_sub_type">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M12 5l0 14" />
                                            <path d="M5 12l14 0" />
                                        </svg>Add
                                    </button>
                                </div>
                                <div class="col-md-12">
                                    <br>
                                    <table class="table table-bordered table-striped" id="account_sub_type_table">
                                        <thead>
                                            <tr>
                                                <th>
                                                    Account Sub Type
                                                </th>
                                                <th>
                                                    Account Type
                                                </th>
                                                <th>
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="detail_type_tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <button
                                        class="tw-dw-btn tw-bg-gradient-to-r tw-from-indigo-600 tw-to-blue-500 tw-font-bold tw-text-white tw-border-none tw-rounded-full pull-right"id="add_detail_type">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M12 5l0 14" />
                                            <path d="M5 12l14 0" />
                                        </svg> Add
                                    </button>
                                </div>
                                <div class="col-md-12">
                                    <br>
                                    <table class="table table-striped" id="detail_type_table" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>
                                                    Detail Type
                                                </th>
                                                <th>
                                                    Parent Type
                                                </th>
                                                <th>
                                                    Description
                                                </th>
                                                <th>
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('webmaster.account_type.create')
    {{-- @include('webmaster.account_type.edit') --}}
    <div id="edit_account_type_modal" class="modal">
        <div class="modal-dialog modal-dialog-centered" role="document" id='modalCont'>
        </div><!-- modal-dialog -->
    </div><!-- modal -->
@stop

@section('scripts')

    @include('webmaster.accounting.common_js')

    <script type="text/javascript">
        $(document).ready(function() {
            account_sub_type_table = $('#account_sub_type_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ action([\App\Http\Controllers\Webmaster\AccountTypeController::class, 'index']) }}?account_type=sub_type",
                columnDefs: [{
                    targets: [2],
                    orderable: false,
                    searchable: false,
                }, ],
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'account_primary_type',
                        name: 'account_primary_type'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ],
            });

            detail_type_table = $('#detail_type_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ action([\App\Http\Controllers\Webmaster\AccountTypeController::class, 'index']) }}?account_type=detail_type",
                columnDefs: [{
                    targets: 3,
                    orderable: false,
                    searchable: false,
                }, ],
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'parent_type',
                        name: 'parent_type'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ],
            });

            $('#add_account_sub_type').click(function() {
                $('#account_type').val('sub_type')
                $('#account_type_title').text("Account Sub Type");
                $('#description_div').addClass('hide');
                $('#parent_id_div').addClass('hide');
                $('#account_type_div').removeClass('hide');
                $('#create_account_type_modal').modal('show');
            });

            $('#add_detail_type').click(function() {
                alert('Hi')
                $('#account_type').val('detail_type')
                $('#account_type_title').text("Add Detail Type");
                $('#description_div').removeClass('hide');
                $('#parent_id_div').removeClass('hide');
                $('#account_type_div').addClass('hide');
                $('#create_account_type_modal').modal('show');
            })
        });
        $(document).on('hidden.bs.modal', '#create_account_type_modal', function(e) {
            $('#create_account_type_form')[0].reset();
        })
        $(document).on('submit', 'form#create_account_type_form', function(e) {
            e.preventDefault();
            var form = $(this);
            var data = form.serialize();

            $.ajax({
                method: 'POST',
                url: $(this).attr('action'),
                dataType: 'json',
                data: data,
                success: function(result) {
                    if (result.success == true) {
                        $('#create_account_type_modal').modal('hide');
                        toastr.success(result.msg);
                        if (result.data.account_type == 'sub_type') {
                            account_sub_type_table.ajax.reload();
                        } else {
                            detail_type_table.ajax.reload();
                        }
                        $('#create_account_type_form').find('button[type="submit"]').attr('disabled',
                            false);
                    } else {
                        toastr.error(result.msg);
                    }
                },
            });
        });

        //update account type or details
        $(document).on('click', '#updateAccType', function() {
            const updateUrl = $(this).data('href')
            $.ajax({
                url: updateUrl,
                type: 'GET',
                success: function(response) {
                    console.log(response)
                    $('#modalCont').html(response.html);
                    $('#edit_account_type_modal').modal('show');
                },
                error: function(xhr) {
                    console.log('Error:', xhr);
                    toastr.error('Sorry Unexpected error has occured!')
                }
            });
        })

        $(document).on('submit', 'form#edit_account_type_form', function(e) {
            e.preventDefault();
            var form = $(this);
            var data = form.serialize();

            $.ajax({
                method: 'PUT',
                url: $(this).attr('action'),
                dataType: 'json',
                data: data,
                success: function(result) {
                    if (result.success == true) {
                        $('#edit_account_type_modal').modal('hide');
                        toastr.success(result.msg);
                        if (result.data.account_type == 'sub_type') {
                            account_sub_type_table.ajax.reload();
                        } else {
                            detail_type_table.ajax.reload();
                        }

                    } else {
                        toastr.error(result.msg);
                    }
                },
                error:function(xhr,status,error)
                {
                    console.log('Error',xhr)
                    toastr.error('Sorry, somethind went werong!')
                }
            });
        });

        //deleting
       $(document).on('click', 'button.delete_account_type_button', function() {
            Swal.fire({
                title: 'Are you sure of this operation?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                dangerMode: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    var href = $(this).data('href');
                    var data = $(this).serialize();
                    $.ajax({
                        method: 'DELETE',
                        url: href,
                        dataType: 'json',
                        data: {
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                        success: function(result) {
                            if (result.success) {
                                toastr.success(result.msg);
                                account_sub_type_table.ajax.reload();
                                detail_type_table.ajax.reload();
                            } else {
                                toastr.error(result.msg);
                            }
                        },
                        error: function(xhr) {
                            toastr.error('An error occurred while deleting the account type.');
                        }
                    });
                }
            });
        });

        $(document).on('click', 'button.accounting_reset_data', function() {
             Swal.fire({
                title: 'Are you sure of this operation?',
                icon: 'warning',
                text: "All the accounting data will be lost and never be recovered!",
                showCancelButton: true,
                confirmButtonText: 'Yes, reset it!',
                cancelButtonText: 'No, cancel!',
                dangerMode: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        var href = $(this).data('href');
                        window.location.href = href;
                    }
                });
        });
    </script>
@endsection
