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
                        {{-- @can('account.access') --}}
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="ledger">
                                <thead>
                                    <tr>
                                        <th>Note</th>
                                        <th>Description</th>
                                        <th>Note</th>
                                        <th>Added By</th>
                                        <th>Debit</th>
                                        <th>Credit</th>
                                        <!-- <th>@lang('lang_v1.balance')</th> -->
                                        <th>Action</th>
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
                        {{-- @endcan --}}
                    </div>
                </div>
            </div>
        </div>
    </section>

@stop

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
                    data: 'added_by',
                    name: 'added_by'
                },
                {
                    data: 'debit',
                    name: 'amount',
                    searchable: false
                },
                {
                    data: 'credit',
                    name: 'amount',
                    searchable: false
                },
                {
                    data: 'action',
                    name: 'action',
                    searchable: false
                }
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
