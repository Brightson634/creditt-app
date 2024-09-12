@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection
@section('content')
    <div class="page-heading ">
    </div>
    <div class="row">
        <div class="col-xl-12 mx-auto">
            <div class="card">
                <div class="card-body">
                    <div>
                        <!-- Filter Accordion -->
                        <div class="filter">
                            <div class="accordion" id="filterAccordion">
                                <div class="card">
                                    <div class="card-header" id="headingFilter">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link" type="button" data-toggle="collapse"
                                                data-target="#collapseFilter" aria-expanded="true"
                                                aria-controls="collapseFilter">
                                                <i class="typcn typcn-filter"></i> Filter Options
                                            </button>
                                        </h5>
                                    </div>

                                    <div id="collapseFilter" class="collapse show" aria-labelledby="headingFilter"
                                        data-parent="#filterAccordion">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <!-- Date range filter -->
                                                    <div class="form-group">
                                                        <label for="daterange">Date Range:</label>
                                                        <input type="text" id="daterange" class="form-control" />
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Transactions Table -->
                        <div class="row">
                            <div class="col-md-6">
                                <h1 class="display-4">{{ $settings->company_name }}</h1>
                                <p>
                                    {{ $settings->address }}
                                </p>
                            </div>
                            <div class="col-md-6 text-right">
                                <div class="row bg-light p-2 my-3">
                                    <div class="col-md-12">
                                        <p><strong>{{ $memberAccount->member->fname . ' ' . $memberAccount->member->lname }}&#39;S
                                                ACCOUNT STATEMENT</strong></p>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Statement Period</th>
                                                    <th>Account No.</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td id="statementPeriod">
                                                        {{ \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d') }} to
                                                        {{ \Carbon\Carbon::now()->endOfMonth()->format('Y-m-d') }}
                                                    </td>
                                                    <td class="text-right">
                                                        {{ $memberAccount->account_no }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                            </div>
                        </div>

                        <div class="mt-4">
                            <div><strong>{{ $memberAccount->member->fname . ' ' . $memberAccount->member->lname }}</strong>
                            </div>
                            <div>{{ $memberAccount->member->current_address }}</div>
                            <div>{{ $memberAccount->member->email }}</div>
                        </div>

                        <div class='mt-4'>
                            <table class="table table-striped" id="accountStatement">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Date</th>
                                        <th>Description</th>
                                        <th>Transfers</th>
                                        <th>Withdrawals</th>
                                        <th>Deposits</th>
                                        <th>Balance</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th colspan="3">Total</th>
                                        <th id="withdrawalsTotal">0.00</th>
                                        <th id="depositsTotal">0.00</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var currentMonthStart = "{{ \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d') }}";
        var currentMonthEnd = "{{ \Carbon\Carbon::now()->endOfMonth()->format('Y-m-d') }}";
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            // Get the current month start and end dates from script variables
            var currentMonthStart = moment(currentMonthStart);
            var currentMonthEnd = moment(currentMonthEnd);

            // Initialize date range picker with the current month's range
            $('#daterange').daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD'
                },
                autoUpdateInput: false,
                drops: 'down',
                startDate: currentMonthStart,
                endDate: currentMonthEnd
            }, function(start, end) {
                $('#daterange').val(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
                updateStatementPeriod(start, end);
                table.draw(); // Trigger table redraw on date range change
            });

            // Set the initial value of the date range input
            $('#daterange').val(currentMonthStart.format('YYYY-MM-DD') + ' - ' + currentMonthEnd.format(
                'YYYY-MM-DD'));

            // Function to update the statement period text
            function updateStatementPeriod(startDate, endDate) {
                var periodText = 'Statement Period: ' + startDate.format('YYYY-MM-DD') + ' to ' + endDate.format(
                    'YYYY-MM-DD');
                $('#statementPeriod').text(periodText);
            }

            // Initial update of the statement period
            updateStatementPeriod(currentMonthStart, currentMonthEnd);

            $('#daterange').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format(
                    'YYYY-MM-DD'));
                updateStatementPeriod(picker.startDate, picker.endDate);
                table.draw(); // Trigger table redraw on date range change
            });

            $('#daterange').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                updateStatementPeriod(currentMonthStart, currentMonthEnd);
                table.draw(); // Trigger table redraw on date range clear
            });

            // Initialize DataTable
            var table = $('#accountStatement').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('webmaster.memberaccount.statement', $id) }}",
                    data: function(d) {
                        var dateRange = $('#daterange').val().split(' - ');
                        d.start_date = dateRange[0] || currentMonthStart.format(
                            'YYYY-MM-DD'); // Get start date
                        d.end_date = dateRange[1] || currentMonthEnd.format(
                            'YYYY-MM-DD'); // Get end date
                    }
                },
                columns: [{
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'transfer_amount',
                        name: 'transfer_amount'
                    },
                    {
                        data: 'withdraw_amount',
                        name: 'withdraw_amount'
                    },
                    {
                        data: 'deposit_amount',
                        name: 'deposit_amount'
                    },
                    {
                        data: 'current_amount',
                        name: 'current_amount'
                    }
                ],
                searching: false,
                lengthChange: false,
                paging: false,
                info: false,
                footerCallback: function(row, data, start, end, display) {
                    var api = this.api();

                    // Calculate the total of deposits and withdrawals
                    var totalWithdrawals = api.column(3, {
                        page: 'all'
                    }).data().reduce(function(a, b) {
                        return parseFloat(a) + parseFloat(b) || 0;
                    }, 0);

                    var totalDeposits = api.column(4, {
                        page: 'all'
                    }).data().reduce(function(a, b) {
                        return parseFloat(a) + parseFloat(b) || 0;
                    }, 0);

                    // Update the totals in the footer
                    $('#withdrawalsTotal').text(totalWithdrawals.toFixed(2));
                    $('#depositsTotal').text(totalDeposits.toFixed(2));
                }
            });

            // Redraw DataTable on filter change
            $('#search').on('click', function() {
                table.draw();
            });
        });
    </script>
@endsection
