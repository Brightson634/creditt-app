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
                                                <!-- Gender filter -->
                                                <div class="form-group">
                                                    <label for="gender">Gender:</label>
                                                    <select id="gender" class="form-control">
                                                        <option value="">All</option>
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
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
                            <table class="table table-striped" id="membersTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Member No</th>
                                        <th>Member Name</th>
                                        <th>Gender</th>
                                        <th>Date Of Birth</th>
                                        <th>Telephone</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Occupation</th>
                                        <th>Joining Date</th>
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
    let table = $('#membersTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route('webmaster.member.report') }}',
            data: function(d) {
                // Pass gender filter
                d.gender = $('#gender').val();
                
                // Check if a date range is selected and pass the start/end dates
                let dateRange = $('#daterange').val();
                if (dateRange) {
                    let dates = dateRange.split(' - ');
                    d.start_date = dates[0]; // Start date
                    d.end_date = dates[1];   // End date
                } else {
                    d.start_date = ''; // Clear start date if not set
                    d.end_date = '';   // Clear end date if not set
                }
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'member_no', name: 'member_no' },
            { data: 'member_name', name: 'member_name' },
            { data: 'gender', name: 'gender', render: function(data) {
                return data ? (data == 0 ? 'Male' : 'Female') : 'N/A'; // Return Male, Female, or N/A
            }},
            { data: 'dob', name: 'dob', render: function(data) {
                return data ? new Date(data).toLocaleDateString('en-US', {
                    year: 'numeric', month: 'long', day: 'numeric'
                }) : 'N/A'; // Format DOB or return 'N/A'
            }},
            { data: 'telephone', name: 'telephone' },
            { data: 'email', name: 'email' },
            { data: 'current_address', name: 'current_address' },
            { data: 'occupation', name: 'occupation', render: function(data) {
                return data ? data : 'N/A'; // Return Occupation or N/A
            }},
            { data: 'created_at', name: 'created_at' }
        ],
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });

    // Re-draw the table when filters change
    $('#daterange, #gender').on('change', function() {
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
