@php
    $activeTab = 'null';
@endphp
@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection

@section('content')
    @include('webmaster.partials.nav')
    <div class="row">
        <!-- Vertical nav -->
        <div class="col-md-2 mb-3">
            <div class="bg-white rounded shadow-sm p-3">
                <nav class="nav az-nav-column flex-column" role="tablist">
                    <!-- Loan Repayments -->
                    <a class="nav-link active" data-toggle="tab" href="#loan_repayments" role="tab">
                        <i class="typcn typcn-credit-card mr-2"></i>
                        Loans
                    </a>
                    <!--Fees-->
                    <a class="nav-link" data-toggle="tab" href="#fees" role="tab">
                        <i class="typcn typcn-credit-card mr-2"></i>
                        Fees
                    </a>

                    <a class="nav-link" data-toggle="tab" href="#expenses" role="tab">
                        <i class="typcn typcn-calculator mr-2"></i>
                        Expenses
                    </a>
                </nav>
            </div>
        </div>

        <!-- Tab content -->
        <div class="col-md-10 col-lg-10">
            <div class="tab-content pd-20 bg-white">
                <div class="tab-pane fade show active" id="loan_repayments" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="loan_payments">
                            <thead class="thead-light">
                                <tr>
                                    <th>Action</th>
                                    <th>Member</th>
                                    <th>Loan Number</th>
                                    <th>Loan Due Date</th>
                                    <th>Loan Amount Due</th>
                                    <th>Amount Paid</th>
                                    <th>Payment Status</th>
                                    <th>Paid On</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="fees" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="fees_payments">
                            <thead class="thead-light">
                                <tr>
                                    <th>Action</th>
                                    <th>Fee</th>
                                    <th>Amount Paid</th>
                                    <th>Paid By</th>
                                    <th>Paid On</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="expenses" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="expenses_table" style="width:100%">
                            <thead class="thead-light">
                                <tr>
                                    <th>Action</th>
                                    <th>Expense</th>
                                    <th>Category</th>
                                    <th>Amount</th>
                                    <th>Created On</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--map modal--->
    <div id="map_modal" class="modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">

            </div>
        </div><!-- modal-dialog -->
    </div><!-- modal -->
@stop

@section('scripts')
    @include('webmaster.accounting.common_js')
    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on('submit', "form#save_accounting_map", function(e) {
                e.preventDefault();
                var form = $(this);
                var data = form.serialize();
                transaction_type = $('#transaction_type').val();

                $.ajax({
                    method: 'POST',
                    url: $(this).attr('action'),
                    dataType: 'json',
                    data: data,
                    success: function(result) {
                        if (result.success == true) {
                            $('#map_modal').modal('hide');
                            toastr.success(result.msg);
                            loan_payments.ajax.reload();
                             expense.ajax.reload();
                        } else {
                            toastr.error(result.msg);
                        }
                    },
                });


            });

            // expense_table/expense/report
             expense = $('#expenses_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('webmaster.expense.report') }}",
                    type: 'GET',
                    data:{
                        action:true,
                    }
                },
                columns: [{
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'category_name',
                        name: 'category_name'
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                ],
                order: [
                    [2, 'asc']
                ],
                responsive: true,
                language: {
                    processing: '<i class="fas fa-spinner fa-spin"></i> Loading...'
                }
            });

            //loan repayments
            loan_payments = $('#loan_payments').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('webmaster.loan.repayments.index') }}",
                    type: 'GET',
                },
                columns: [{
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'member',
                        name: 'member'
                    },
                    {
                        data: 'loan_number',
                        name: 'loan_number'
                    },
                    {
                        data: 'loan_due_date',
                        name: 'loan_due_date'
                    },
                    {
                        data: 'loan_amount_due',
                        name: 'loan_amount_due'
                    },
                    {
                        data: 'amount_paid',
                        name: 'amount_paid'
                    },
                    {
                        data: 'payment_status',
                        name: 'payment_status'
                    },
                    {
                        data: 'paid_on',
                        name: 'paid_on'
                    },
                ],
                order: [
                    [2, 'asc']
                ],
                responsive: true,
                language: {
                    processing: '<i class="fas fa-spinner fa-spin"></i> Loading...'
                }
            });

            //transaction mapping
            $(document).on('click', '.map_transaction', function(event) {
                event.preventDefault()
                const route = $(this).data('href')
                const acc = $(this).data('acc')
                $.ajax({
                    type: "GET",
                    url: route,
                    data: {
                        payment_date: $(this).data('date'),
                        acc: acc,
                    },
                    dataType: "html",
                    success: function(response) {
                        $(".modal-content").html(response)
                        $("#map_modal").modal('show')
                    }
                });
            });
        });
    </script>
@stop
