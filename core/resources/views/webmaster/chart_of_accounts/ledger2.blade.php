@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection

@section('content')
    @include('webmaster.partials.nav')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black">Ledger - {{ $account->name }}</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-5">
                <div class="box box-solid">
                    <div class="box-body">
                        <table class="table table-condensed">
                            <tr>
                                <th>Name:</th>
                                <td>
                                    {{ $account->name }}

                                    @if (!empty($account->gl_code))
                                        ({{ $account->gl_code }})
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th>Account Type:</th>
                                <td>
                                    @if (!empty($account->account_primary_type))
                                        {{ $account->account_primary_type }}
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th>Account Sub Type:</th>
                                <td>
                                    @if (!empty($account->account_sub_type))
                                        {{ $account->account_sub_type->name }}
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th>Detail Type:</th>
                                <td>
                                    @if (!empty($account->detail_type))
                                        {{ $account->detail_type->name }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Balance:</th>
                                {{-- <td>@format_currency($current_bal)</td> --}}
                                <td>{{ $current_bal }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-7">

                <div class="box box-solid">
                    <div class="box-header">
                        <h3 class="box-title"> <i class="fa fa-filter" aria-hidden="true"></i>Filters:</h3>
                    </div>
                    <div class="box-body">
                        <div class="col-sm-6">
                            <div class="form-group">
                                {!! Form::label('transaction_date_range', 'Date Range' . ':') !!}
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    {!! Form::text('transaction_date_range', null, [
                                        'class' => 'form-control',
                                        'readonly',
                                        'placeholder' => 'Date Range',
                                    ]) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                {!! Form::label('all_accounts', 'Account' . ':') !!}
                                {!! Form::select('account_filter', [$account->id => $account->name], $account->id, [
                                    'class' => 'form-control accounts-dropdown',
                                    'style' => 'width:100%',
                                    'id' => 'account_filter',
                                    'data-default' => $account->id,
                                ]) !!}
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-sm-12">
                <div class="box">
                    <div class="box-body">
                        <div>

                            <div>
                                <!-- Header -->
                                <div class="mb-4">
                                    <h1 class="h3">{{ $settings->company_name }}</h1>
                                    <p>{{ $settings->post_office }}</p>
                                    <p>{{ $settings->physical_location }}</p>
                                    <p>{{ $settings->phone_contact_one . ' | ' . $settings->phone_contact_two }}</p>
                                    <p>{{ $settings->email_address_one . ' | ' . $settings->email_address_two }}</p>
                                </div>

                                <!-- Main Row: Checking Summary and Account Information -->
                                <div class="row mb-4">
                                    <!-- Account Information and Statement Period -->
                                    <div class="col-md-6">
                                        <!-- Account Information -->
                                        <div class="p-3 bg-light rounded">
                                            <p><strong>Account Number:</strong> {{ $account->name }}</p>

                                            <!-- Member Information -->
                                            <p>{{ isset($memberAccount->member) ? $memberAccount->member->fname . ' ' . $memberAccount->member->lname : 'No member information available' }}
                                            </p>

                                            <p>{{ isset($memberAccount->member) ? $memberAccount->member->current_address : '' }}
                                            </p>

                                            <!-- Statement Period -->
                                            <p><strong>Statement Period:</strong></p>
                                            <p id="statement_period">All Dates</p>
                                        </div>

                                    </div>
                                    <!-- Checking Summary -->
                                    <div class="col-md-6">
                                        <h3>Checking Summary</h3>
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <th>Beginning Balance</th>
                                                    <td>{{ $beginning_bal }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Deposits & Additions</th>
                                                    <td>{{ $totalDeposits }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Transfers Made</th>
                                                    <td>{{ $transfersMade }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Transfers Received</th>
                                                    <td>{{ $transfersReceived }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Withdrawals</th>
                                                    <td>{{ $totalWithdraws }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Fees</th>
                                                    <td>{{$totalFees}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Ending Balance</th>
                                                    <td>{{ $current_bal }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>


                            <!-- Transactions Table -->
                            <h3>Transaction History</h3>
                            {{-- <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="ledger">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Transaction Date</th>
                                            <th>Posting Date</th>
                                            <th>Description</th>
                                            <th>Transaction Type</th>
                                            <th>Amount</th>
                                            <th>Reference Number</th>
                                        </tr>
                                    </thead>
                                
                                    <tfoot>
                                        <tr class="bg-gray font-17 footer-total text-center">
                                            <td colspan="4">Total:</strong></td>
                                            <td class="footer_total_debit"></td>
                                            <td class="footer_total_credit"></td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div> --}}
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="ledger">
                                    <thead>
                                        <tr>
                                            <th>Transaction Date</th>
                                            <th>Description</th>
                                            <th>Note</th>
                                            <th>Transaction Type</th>
                                            <th>Amount</th>
                                            <th>Reference Number</th>
                                        </tr>
                                    </thead>



                                    <tfoot>
                                        {{-- <tr class="bg-gray font-17 footer-total text-center">
                                            <td colspan="4">Total:</strong></td>
                                            <td class="footer_total_debit"></td>
                                            <td class="footer_total_credit"></td>
                                            <td></td>
                                        </tr> --}}
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    @include('webmaster.accounting.common_js')
    <script>
        $(document).ready(function() {
            // Account filter redirect
            $('#account_filter').change(function() {
                account_id = $(this).val();
                url = base_path + '/webmaster/ledger/' + account_id;
                window.location = url;
            });

            function cb(start, end) {
                const formatted = start.format('MM/DD/YYYY') + ' ~ ' + end.format('MM/DD/YYYY');
                $('#transaction_date_range').val(formatted);
                $('#statement_period').text(formatted); // Update the HTML dynamically
            }

            // Initialize Date Range Picker
            $('#transaction_date_range').daterangepicker(dateRangeSettings, cb);
            cb(dateRangeSettings.startDate, dateRangeSettings.endDate);

            // Apply range reload
            $('#transaction_date_range').on('apply.daterangepicker', function(ev, picker) {
                let formatted = picker.startDate.format('MM/DD/YYYY') + ' ~ ' + picker.endDate.format(
                    'MM/DD/YYYY');
                $('#transaction_date_range').val(formatted);
                $('#statement_period').text(formatted); // Update HTML again
                ledger.ajax.reload();
            });

            // Clear range reload
            $('#transaction_date_range').on('cancel.daterangepicker', function(ev, picker) {
                $('#transaction_date_range').val('');
                $('#statement_period').text('All Dates'); // Reset to default
                ledger.ajax.reload();
            });


            // Initialize Ledger DataTable
            ledger = $('#ledger').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ action([App\Http\Controllers\Webmaster\CoaController::class, 'ledger'], [$account->id]) }}',
                    data: function(d) {
                        var start = '';
                        var end = '';
                        if ($('#transaction_date_range').val()) {
                            start = $('input#transaction_date_range').data('daterangepicker').startDate
                                .format('YYYY-MM-DD');
                            end = $('input#transaction_date_range').data('daterangepicker').endDate
                                .format('YYYY-MM-DD');
                        }
                        var transaction_type = $('select#transaction_type').val();
                        d.start_date = start;
                        d.end_date = end;
                        d.type = transaction_type;
                    }
                },
                ordering: false,
                columns: [{
                        data: 'operation_date',
                        name: 'operation_date'
                    },
                    {
                        data: 'ref_no',
                        name: 'ATM.ref_no'
                    },
                    {
                        data: 'note',
                        name: 'ATM.note'
                    },
                    {
                        data: 'type',
                        name: 'ATM.type'
                    },
                    {
                        data: 'amount',
                        name: 'amount',
                        searchable: false
                    },
                    {
                        data: 'reference_number',
                        name: 'reference_number'
                    },
                ],

                dom: '<"d-flex justify-content-between align-items-center mb-3"Bf>rtip',
                buttons: [{
                        extend: 'copyHtml5',
                        text: '<i class="fas fa-copy"></i> Copy',
                        className: 'btn btn-sm btn-secondary'
                    },
                    {
                        extend: 'csvHtml5',
                        text: '<i class="fas fa-file-csv"></i> CSV',
                        className: 'btn btn-sm btn-success'
                    },
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fas fa-file-excel"></i> Excel',
                        className: 'btn btn-sm btn-success',
                        title: function() {
                            const range = $('#transaction_date_range').val() || 'All Dates';
                            return 'Ledger Report - {{ $account->name ?? 'Account' }} (' + range +
                                ')';
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        className: 'btn btn-sm btn-danger',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        title: function() {
                            const range = $('#transaction_date_range').val() || 'All Dates';
                            return 'Ledger Report - {{ $account->name ?? 'Account' }}\nStatement Period: ' +
                                range;
                        },
                        customize: function(doc) {
                            doc.content.splice(0, 0, {
                                text: 'Statement Period: ' + ($('#transaction_date_range')
                                    .val() || 'All Dates'),
                                fontSize: 10,
                                margin: [0, 0, 0, 10]
                            });
                        },
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"></i> Print',
                        className: 'btn btn-sm btn-primary',
                        title: function() {
                            const range = $('#transaction_date_range').val() || 'All Dates';
                            return 'Ledger - {{ $account->name ?? 'Account' }}';
                        },
                        messageTop: function() {
                            const range = $('#transaction_date_range').val() || 'All Dates';
                            return '<strong>Statement Period:</strong> ' + range;
                        }
                    }
                ],

                fnDrawCallback: function(oSettings) {
                    // Optional custom logic after draw
                },
            });
        });
    </script>

@stop
