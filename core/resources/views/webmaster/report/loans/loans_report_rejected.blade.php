@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection
@section('content')
    <div class="row" id='cont'>
        <div class="col-xl-12 mx-auto">
            <div class="card">
                <div class="card-body">
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
                                            <div class="col-md-6">
                                                <!-- Status filter -->
                                                <div class="form-group">
                                                    {{-- <label for="status">Status:</label>
                                                    <select id="status" class="form-control">
                                                        <option value="">All Statuses</option>
                                                        <option value="0">Pending</option>
                                                        <option value="2">Reviewed</option>
                                                        <option value="3">Approved</option>
                                                        <option value="4">Rejected</option>
                                                        <option value="5">Disbursed</option>
                                                        <option value="6">Canceled</option>
                                                    </select> --}}
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        <!-- Datatables for Loans Report -->
                        <div class='mt-4'>
                            <table class="table table-striped" id="loansRejectedTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Loan No</th>
                                        <th>Borrower's Name</th>
                                        <th>Principal Amount</th>
                                        <th>Repayment Amount</th>
                                        <th>Interest Rate(%)</th>
                                        <th>Loan Product</th>
                                        <th>Created At</th>
                                        <th>Rejected Date</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
    @section('scripts')
        <script>
            $(document).ready(function() {
                // Initialize date range picker
                $('#daterange').daterangepicker({
                    locale: {
                        format: 'YYYY-MM-DD'
                    },
                    autoUpdateInput: false,
                    drops: 'down',
                    // parentEl: ''
                });

                $('#daterange').on('apply.daterangepicker', function(ev, picker) {
                    $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format(
                        'YYYY-MM-DD'));
                    table.draw(); // Trigger table redraw on date range change
                });

                $('#daterange').on('cancel.daterangepicker', function(ev, picker) {
                    $(this).val('');
                    table.draw(); // Trigger table redraw on date range clear
                });

                // Initialize DataTable
                var table = $('#loansRejectedTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('webmaster.loans.report.rejected') }}",
                        data: function(d) {
                            var dateRange = $('#daterange').val().split(' - ');
                            d.start_date = dateRange[0] || ''; // Get start date
                            d.end_date = dateRange[1] || ''; // Get end date
                            d.status = $('#status').val(); // Get selected status
                        }
                    },
                    dom: 'Blfrtip',
                    buttons: [{
                            extend: 'excel',
                            text: '<i class="typcn typcn-document-text-outline"></i> Export to Excel'
                        },
                        {
                            extend: 'pdf',
                            text: '<i class="typcn typcn-document-text-outline"></i> Export to PDF'
                        }
                    ],
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'loan_no',
                            name: 'loan_no'
                        },
                        {
                            data: 'member_name',
                            name: 'member_name'
                        },
                        {
                            data: 'principal_amount',
                            name: 'principal_amount'
                        },
                        {
                            data: 'repayment_amount',
                            name: 'repayment_amount'
                        },
                        {
                            data:'interest_rate',
                            name:'interest_rate',
                        },
                        {
                            data:'name',
                            name:'name'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            data: 'rejected_date',
                            name: 'rejected_date'
                        },
                    ]
                });

                // Trigger table redraw on status change
                $('#status').on('change', function() {
                    table.draw();
                });
            });
        </script>
    @endsection
