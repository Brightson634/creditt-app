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
                                                    <label for="status">Status:</label>
                                                    <select id="status" class="form-control">
                                                        <option value="">All Statuses</option>
                                                        <option value="1">Active</option>
                                                        <option value="0">Inactive</option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Datatables for Investment Report -->
                        <div class='mt-4'>
                        <table class="table table-striped" id="investmentTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Investment No</th>
                                    <th>Member/Group</th>
                                    <th>Investment Amount</th>
                                    <th>Investment Plan</th>
                                    <th>Interest Rate(%)</th>
                                    <th>Rate Duration(Per)</th>
                                    <th>Interest Amount</th>
                                    <th>ROI Amount</th>
                                    <th>Created At</th>
                                    <th>End Date</th>
                                    <th>Status</th>
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
                var table = $('#investmentTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('webmaster.investments.report') }}",
                        data: function(d) {
                            var dateRange = $('#daterange').val().split(' - ');
                            d.start_date = dateRange[0] || '';
                            d.end_date = dateRange[1] || ''; 
                            d.status = $('#status').val(); 
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
                            data: 'investment_no',
                            name: 'investment_no'
                        },
                        {
                            data: 'member_name',
                            name: 'member_name'
                        },
                        {
                            data: 'investment_amount',
                            name: 'investment_amount'
                        },
                        {
                            data: 'investment_plan_name',
                            name: 'investment_plan_name'
                        },
                        {
                            data: 'interest_rate',
                            name: 'interest_rate'
                        },
                        {
                            data: 'duration',
                            name: 'duration'
                        },
                        {
                            data: 'interest_amount',
                            name: 'interest_amount'
                        },
                        {
                            data: 'roi_amount',
                            name: 'roi_amount'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            data: 'end_date',
                            name: 'end_date'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        }
                    ]
                });

                // Trigger table redraw on status change
                $('#status').on('change', function() {
                    table.draw();
                });
            });
        </script>
    @endsection
