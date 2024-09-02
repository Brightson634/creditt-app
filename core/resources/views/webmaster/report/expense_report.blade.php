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
                                                <!-- category filter -->
                                                <div class="form-group">
                                                    <label for="category">Category:</label>
                                                    <select id="category" class="form-control">
                                                        <option value="">All</option>
                                                        @foreach ($categories as $data)
                                                            <option value="{{ $data->id }}">{{ $data->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Datatables for Members Report -->
                        <div class='mt-4'>
                            <table class="table table-striped" id="expenseTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Expense</th>
                                        <th>Category</th>
                                        <th>Subcategory</th>
                                        <th>Amount</th>
                                        <th>Description</th>
                                        <th>Payment Type</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>
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
        $(document).ready(function() {
            let table = $('#expenseTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('webmaster.expense.report') }}',
                    data: function(d) {
                        // Pass category filter
                        d.category = $('#category').val();

                        // Check if a date range is selected and pass the start/end dates
                        let dateRange = $('#daterange').val();
                        if (dateRange) {
                            let dates = dateRange.split(' - ');
                            d.start_date = dates[0];
                            d.end_date = dates[1];
                        } else {
                            d.start_date = '';
                            d.end_date = ''; 
                        }
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'category_name',
                        name: 'category_id'
                    },
                    {
                        data: 'subcategory_name',
                        name: 'subcategory_id'
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'payment_type_name',
                        name: 'paymenttype_id'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    }
                ],
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });

            // Re-draw the table when filters change
            $('#daterange, #category').on('change', function() {
                table.draw();
            });

            // Initialize the date range picker with no initial value
            $('#daterange').daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD'
                },
                autoUpdateInput: false, // Do not auto fill the input with a default value
                opens: 'left',
            });

            // Trigger table redraw on date range change when the user applies a new range
            $('#daterange').on('apply.daterangepicker', function(ev, picker) {
                let startDate = picker.startDate.format('YYYY-MM-DD');
                let endDate = picker.endDate.format('YYYY-MM-DD');
                $('#daterange').val(startDate + ' - ' + endDate); // Manually set the value to the input
                table.draw(); // Redraw the table with the date range filter
            });

            // Clear the date range on cancel
            $('#daterange').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val(''); // Clear the input
                table.draw(); // Redraw the table without the date filter
            });
        });
    </script>
@endsection
