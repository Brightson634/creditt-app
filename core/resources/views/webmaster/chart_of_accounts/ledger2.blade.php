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
                <div class="box2">
                    <div class="box-body3">
                        <div class="">
                            <!-- Header -->
                            <div class="text-center mb-4">
                                <h1 class="h3">{{ $settings->company_name }}</h1>
                                <p> {{ $settings->address }}</p>
                                <p><strong>Statement Period: May 1, 2024 - May 21, 2024</strong></p>
                            </div>

                            <!-- Account Information -->
                            <div class="row mb-4 p-3 bg-light rounded">
                                <div class="col-md-6">
                                    <p><strong>Account Number:</strong> {{ $account->name }}</p>
                                    <p>{{ isset($memberAccount->member) ? $memberAccount->member->fname . ' ' . $memberAccount->member->lname : 'No member information available' }}

                                    </p>
                                    <p>{{isset($memberAccount->member)? $memberAccount->member->current_address:" "}}</p>
                                </div>
                                <div class="col-md-6 text-md-right">
                                    <p><strong>Statement Period:</strong></p>
                                    <p>May 1, 2024 - May 21, 2024</p>
                                </div>
                            </div>

                            <!-- Checking Summary -->
                            <div class="mb-4">
                                <h3>Checking Summary</h3>
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th>Beginning Balance</th>
                                            <td>$3,000.00</td>
                                        </tr>
                                        <tr>
                                            <th>Deposits & Additions</th>
                                            <td>$2,535.00</td>
                                        </tr>
                                        <tr>
                                            <th>ATM & Debit Card Withdrawals</th>
                                            <td>$212.40</td>
                                        </tr>
                                        <tr>
                                            <th>Electronic Withdrawals</th>
                                            <td>$145.74</td>
                                        </tr>
                                        <tr>
                                            <th>Other Withdrawals</th>
                                            <td>$575.00</td>
                                        </tr>
                                        <tr>
                                            <th>Fees</th>
                                            <td>$10.00</td>
                                        </tr>
                                        <tr>
                                            <th>Ending Balance</th>
                                            <td>$4,083.56</td>
                                        </tr>
                                    </tbody>
                                </table>
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
                                        <tr class="bg-gray font-17 footer-total text-center">
                                            <td colspan="4">Total:</strong></td>
                                            <td class="footer_total_debit"></td>
                                            <td class="footer_total_credit"></td>
                                            <td></td>
                                        </tr>
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
            $('#account_filter').change(function() {

                account_id = $(this).val();
                url = base_path + '/webmaster/ledger/' + account_id;
                window.location = url;
            })

            function cb(start, end) {
                $('#transaction_date_range').val(start.format('MM/DD/YYYY') + ' ~ ' + end.format('MM/DD/YYYY'));
            }

            // Initialize the Date Range Picker with predefined options
            $('#transaction_date_range').daterangepicker(dateRangeSettings, cb);

            // Initialize the input with the initial date range
            cb(dateRangeSettings.startDate, dateRangeSettings.endDate);

            // Custom handling for "Custom Range"
            $('#transaction_date_range').on('apply.daterangepicker', function(ev, picker) {
                if (picker.chosenLabel === 'Custom Range') {
                    $('#transaction_date_range').val(picker.startDate.format('MM/DD/YYYY') + ' ~ ' + picker
                        .endDate.format('MM/DD/YYYY'));
                }
                ledger.ajax.reload();
            });

            // Reload table when date range is cleared
            $('#transaction_date_range').on('cancel.daterangepicker', function(ev, picker) {
                $('#transaction_date_range').val('');
                ledger.ajax.reload();
            });
        });

        // Account Book DataTable Initialization
        ledger = $('#ledger').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ action([App\Http\Controllers\Webmaster\CoaController::class, 'ledger'], [$account->id]) }}',
                data: function(d) {
                    var start = '';
                    var end = '';
                    if ($('#transaction_date_range').val()) {
                        start = $('input#transaction_date_range').data('daterangepicker').startDate.format(
                            'YYYY-MM-DD');
                        end = $('input#transaction_date_range').data('daterangepicker').endDate.format(
                            'YYYY-MM-DD');
                    }
                    var transaction_type = $('select#transaction_type').val();
                    d.start_date = start;
                    d.end_date = end;
                    d.type = transaction_type;
                }
            },
            "ordering": false,
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
                    data: 'ref_no',
                    name: 'ATM.ref_no'
                },
            ],
            "fnDrawCallback": function(oSettings) {
                // No additional formatting or function calls
            },
            "footerCallback": function(row, data, start, end, display) {
                var footer_total_debit = 0;
                var footer_total_credit = 0;

                for (var r in data) {
                    footer_total_debit += $(data[r].debit).data('orig-value') ? parseFloat($(data[r].debit)
                        .data('orig-value')) : 0;
                    footer_total_credit += $(data[r].credit).data('orig-value') ? parseFloat($(data[r].credit)
                        .data('orig-value')) : 0;
                }

                $('.footer_total_debit').html(footer_total_debit.toFixed(2)); // Directly setting the value
                $('.footer_total_credit').html(footer_total_credit.toFixed(2)); // Directly setting the value
            }
        });
    </script>
@stop