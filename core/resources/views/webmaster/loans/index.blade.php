@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection
@section('content')
    <div class="page-heading ">
        <div class="az-dashboard-nav">
            <nav class="nav">
                <a class="nav-link active" data-toggle="tab" href="#pending">Pending Loans</a>
                <a class="nav-link" data-toggle="tab" href="#reviewloans" role="tab" aria-controls="reviewloans"
                    aria-selected="false">Reviewed Loans</a>
                <a class="nav-link" data-toggle="tab"href="#approvedloans" role="tab" aria-controls="approvedloans"
                    aria-selected="false">Approved Loans</a>
                <a class="nav-link" data-toggle="tab"href="#disbursedloans" role="tab" aria-controls="disbursedloans"
                    aria-selected="false">Disbursed Loans</a>
                <a class="nav-link" data-toggle="tab" href="#rejectedloans" role='tab' aria-controls="rejectedloans"
                    aria-selected="false">Rejected Loans</a>
                <a class="nav-link" data-toggle="tab" href="#memberApploans" role='tab' aria-controls="memberApploans"
                    aria-selected="false">Loan Applications From Members</a>
                <a class="nav-link" data-toggle="tab" href="#arrearloans" role='tab' aria-controls="arrearloans"
                    aria-selected="false">Loans Arrears</a>
            </nav>
            <a class=" btn btn-indigo btn-sm float-right" href="{{ route('webmaster.loan.create') }}">New Loan</a>
        </div>
    </div>
    <!-- Tab content -->
    <div class="tab-content" id="myTabContent">
        <!--pending loans-->
        <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
            <div class="row">
                <div class="col-xl-12 mx-auto">
                    @if ($data['pendingloans']->count() > 0)
                        <h6 class="card-title">Pending Loans</h6>
                        <div class="table-responsive">
                            <table class="table table-striped data_div">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Loan No</th>
                                        <th>Member / Group</th>
                                        <!-- <th>Loan Type</th> -->
                                        <th>Loan Product</th>
                                        <th>Principal Amount</th>
                                        <th>Repayment Amount</th>
                                        <!-- <th>Fees Total</th> -->
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 0; @endphp
                                    @foreach ($data['pendingloans'] as $row)
                                        @php $i++; @endphp
                                        <tr>
                                            <th scope="row">{{ $i }}</th>
                                            <td><a
                                                    href="{{ route('webmaster.loan.dashboard', $row->loan_no) }}">{{ $row->loan_no }}</a>
                                            </td>
                                            <td>
                                                @if ($row->loan_type == 'individual')
                                                    {{ optional($row->member)->fname ?? '' }} -
                                                    {{ optional($row->member)->lname ?? '' }}
                                                @endif
                                                @if ($row->loan_type == 'group')
                                                    {{ optional($row->member)->fname ?? '' }}
                                                @endif
                                            </td>
                                            <td>{{ optional(optional($row)->loanproduct)->name }}</td>
                                            <td>{!! showAmount($row->principal_amount) !!}</td>
                                            <td>{!! showAmount($row->repayment_amount) !!}</td>
                                            <!-- <td>{!! showAmount($row->fees_total) !!}</td> -->
                                            <td>
                                                <div class="badge bg-secondary text-white">Pending</div>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-primary dropdown-toggle" type="button"
                                                        data-toggle="dropdown">
                                                        Actions
                                                    </button>
                                                    <div class="dropdown-menu shadow animated--fade-in">
                                                        @can('edit_loans')
                                                            <a class="dropdown-item"
                                                                href="{{ route('webmaster.loan.edit', $row->id) }}">
                                                                <i class="far fa-edit text-primary"></i> Edit
                                                            </a>
                                                        @endcan

                                                        @can('delete_loans')
                                                            <form action="{{ route('webmaster.loan.destroy', $row->id) }}"
                                                                method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item text-danger">
                                                                    <i class="fas fa-trash"></i> Delete
                                                                </button>
                                                            </form>
                                                        @endcan
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="d-flex flex-column align-items-center mt-5">
                            <img src="{{ asset('assets/uploads/defaults/nodata.png') }}" width="200">
                            <span class="mt-3">No Data</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <!--reviewed loans-->
        <div class="tab-pane fade" id="reviewloans" role="tabpanel" aria-labelledby="reviewloans-tab">
            <div class="row">
                <div class="col-xl-12 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            @if ($data['reviewloans']->count() > 0)
                                <div class="card ">
                                    <h6 class="card-title">Reviewed Loans</h6>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Loan No</th>
                                                    <th>Member / Group</th>
                                                    <!-- <th>Loan Type</th> -->
                                                    <th>Loan Product</th>
                                                    <th>Principal Amount</th>
                                                    <th>Repayment Amount</th>
                                                    <!-- <th>Fees Total</th> -->
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $i = 0; @endphp
                                                @foreach ($data['reviewloans'] as $row)
                                                    @php $i++; @endphp
                                                    <tr>
                                                        <th scope="row">{{ $i }}</th>
                                                        <td><a
                                                                href="{{ route('webmaster.loan.dashboard', $row->loan_no) }}">{{ $row->loan_no }}</a>
                                                        </td>
                                                        <td>
                                                            @if ($row->loan_type == 'individual')
                                                                {{ $row->member->fname }} - {{ $row->member->lname }}
                                                            @endif
                                                            @if ($row->loan_type == 'group')
                                                                {{ $row->member->fname }}
                                                            @endif
                                                        </td>
                                                        <!--  <td>
                                                                                                                    @if ($row->loan_type == 'individual')
    INDIVIDUAL LOAN
    @endif
                                                                                                                                                                                        @if ($row->loan_type == 'group')
    GROUP LOAN
    @endif
                                                                                                                </td> -->
                                                        <td>{{ $row->loanproduct->name }}</td>
                                                        <td>{!! showAmount($row->principal_amount) !!}</td>
                                                        <td>{!! showAmount($row->repayment_amount) !!}</td>
                                                        <!-- <td>{!! showAmount($row->fees_total) !!}</td> -->
                                                        <td>
                                                            <div class="badge badge-info">Reviewed</div>
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('webmaster.loan.review', $row->loan_no) }}"
                                                                class="btn btn-xs btn-dark"> <i class="far fa-eye"></i></a>
                                                            <a href="{{ route('webmaster.loan.preview', $row->loan_no) }}"
                                                                class="btn btn-xs btn-dark"> <i class="far fa-eye"></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @else
                                <div class="d-flex flex-column align-items-center mt-5">
                                    <img src="{{ asset('assets/uploads/defaults/nodata.png') }}" width="200">
                                    <span class="mt-3">No Data</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--approved loans-->
        <div class="tab-pane fade" id="approvedloans" role="tabpanel" aria-labelledby="approvedloans-tab">
            <div class="row">
                <div class="col-xl-12 mx-auto">
                    @if ($data['approvedloans']->count() > 0)
                        <h6 class="card-title">Approved Loans</h6>
                        <div class="table-responsive">
                            <table class="table table-striped data_div">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Loan No</th>
                                        <th>Member / Group</th>
                                        <!-- <th>Loan Type</th> -->
                                        <th>Loan Product</th>
                                        <th>Principal Amount</th>
                                        <th>Repayment Amount</th>
                                        <th>Fees Total</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 0; @endphp
                                    @foreach ($data['approvedloans'] as $row)
                                        @php $i++; @endphp
                                        <tr>
                                            <th scope="row">{{ $i }}</th>
                                            <td><a
                                                    href="{{ route('webmaster.loan.dashboard', $row->loan_no) }}">{{ $row->loan_no }}</a>
                                            </td>
                                            <td>
                                                @if ($row->loan_type == 'individual')
                                                    {{ ucwords(strtolower($row->member->fname)) }} -
                                                    {{ ucwords(strtolower($row->member->lname)) }}
                                                @endif
                                                @if ($row->loan_type == 'group')
                                                    {{ ucwords(strtolower($row->member->fname)) }}
                                                @endif
                                            </td>
                                            <td>{{ $row->loanproduct->name }}</td>
                                            <td>{!! showAmount($row->principal_amount) !!}</td>
                                            <td>{!! showAmount($row->repayment_amount) !!}</td>
                                            <td>{!! showAmount($row->fees_total) !!}</td>
                                            <td>

                                                <div class="badge badge-success">APPROVED</div>
                                            </td>
                                            <td>
                                                @include('webmaster.loans.approve_view')
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-primary dropdown-toggle" type="button"
                                                        data-toggle="dropdown">
                                                        Actions
                                                    </button>
                                                    <div class="dropdown-menu shadow animated--fade-in">
                                                        <a class="dropdown-item" href="javascript:void(0)"
                                                            data-toggle="modal"
                                                            data-target="#approveModel{{ $row->id }}">
                                                            <i class="far fa-eye text-info"></i> View
                                                        </a>

                                                        <a class="dropdown-item"
                                                            href="{{ route('webmaster.loan.printpdf', $row->loan_no) }}"
                                                            target="_blank">
                                                            <i class="fa fa-download text-secondary"></i> Download
                                                        </a>
                                                    </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="d-flex flex-column align-items-center mt-5">
                            <img src="{{ asset('assets/uploads/defaults/nodata.png') }}" width="200">
                            <span class="mt-3">No Data</span>
                        </div>
                    @endif

                </div>
            </div>
        </div>
        <!--approved loans-->
        <div class="tab-pane fade" id="disbursedloans" role="tabpanel" aria-labelledby="disbursedloans-tab">
            <div class="row">
                <div class="col-xl-12 mx-auto">
                    @if ($data['disbursedloans']->count() > 0)
                        <h6 class="card-title">Disbursed Loans</h6>
                        <div class="table-responsive">
                            <table class="table table-striped data_div">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Loan No</th>
                                        <th>Member / Group</th>
                                        <!-- <th>Loan Type</th> -->
                                        <th>Loan Product</th>
                                        <th>Principal Amount</th>
                                        <th>Repayment Amount</th>
                                        <th>Fees Total</th>
                                        {{-- <th>Status</th> --}}
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 0; @endphp
                                    @foreach ($data['disbursedloans'] as $row)
                                        @php $i++; @endphp
                                        <tr>
                                            <th scope="row">{{ $i }}</th>
                                            <td><a
                                                    href="{{ route('webmaster.loan.dashboard', $row->loan_no) }}">{{ $row->loan_no }}</a>
                                            </td>
                                            <td>
                                                @if ($row->loan_type == 'individual')
                                                    {{ ucwords(strtolower($row->member->fname)) }} -
                                                    {{ ucwords(strtolower($row->member->lname)) }}
                                                @endif
                                                @if ($row->loan_type == 'group')
                                                    {{ ucwords(strtolower($row->member->fname)) }}
                                                @endif
                                            </td>

                                            <td>{{ optional($row->loanproduct)->name }}</td>
                                            <td>{!! showAmount($row->principal_amount) !!}</td>
                                            <td>{!! showAmount($row->repayment_amount) !!}</td>
                                            <td>{!! showAmount($row->fees_total) !!}</td>
                                            <td>
                                                <a href="{{ route('webmaster.loan.printpdf', $row->loan_no) }}"
                                                    target="_blank" class="btn btn-xs btn-secondary"> <i
                                                        class="fa fa-download"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="d-flex flex-column align-items-center mt-5">
                            <img src="{{ asset('assets/uploads/defaults/nodata.png') }}" width="200">
                            <span class="mt-3">No Data</span>
                        </div>
                    @endif

                </div>
            </div>
        </div>
        <!--rejected loans-->
        <div class="tab-pane fade" id="rejectedloans" role="tabpanel" aria-labelledby="rejectedloans-tab">
            <div class="row">
                <div class="col-xl-12 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            @if ($data['rejectloans']->count() > 0)
                                <div class="card ">
                                    <h6 class="card-title">Rejected Loans</h6>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Loan No</th>
                                                    <th>Member / Group</th>
                                                    <!-- <th>Loan Type</th> -->
                                                    <th>Loan Product</th>
                                                    <th>Principal Amount</th>
                                                    <th>Repayment Amount</th>
                                                    <!-- <th>Fees Total</th> -->
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $i = 0; @endphp
                                                @foreach ($data['rejectloans'] as $row)
                                                    @php $i++; @endphp
                                                    <tr>
                                                        <th scope="row">{{ $i }}</th>
                                                        <td><a
                                                                href="{{ route('webmaster.loan.dashboard', $row->loan_no) }}">{{ $row->loan_no }}</a>
                                                        </td>
                                                        <td>
                                                            @if ($row->loan_type == 'individual')
                                                                {{ $row->member->fname }} - {{ $row->member->lname }}
                                                            @endif
                                                            @if ($row->loan_type == 'group')
                                                                {{ $row->member->fname }}
                                                            @endif
                                                        </td>
                                                        <!--  <td>
                                                                                                         @if ($row->loan_type == 'individual')
    INDIVIDUAL LOAN
    @endif
                                                                                                                                                                                                @if ($row->loan_type == 'group')
    GROUP LOAN
    @endif
                                                                                                      </td> -->
                                                        <td>{{ $row->loanproduct->name }}</td>
                                                        <td>{!! showAmount($row->principal_amount) !!}</td>
                                                        <td>{!! showAmount($row->repayment_amount) !!}</td>
                                                        <!-- <td>{!! showAmount($row->fees_total) !!}</td> -->
                                                        <td>
                                                            @if ($row->status == 0)
                                                                <div class="badge badge-info">PENDING</div>
                                                            @endif
                                                            @if ($row->status == 1)
                                                                <div class="badge badge-warning">UNDER REVIEW</div>
                                                            @endif
                                                            @if ($row->status == 2)
                                                                <div class="badge badge-success">APPROVED</div>
                                                            @endif
                                                            @if ($row->status == 3)
                                                                <div class="badge badge-danger">REJECTED</div>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a href="#{{ route('webmaster.loan.edit', $row->loan_no) }}"
                                                                class="btn btn-xs btn-dark"> <i
                                                                    class="far fa-edit"></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @else
                                <div class="d-flex flex-column align-items-center mt-5">
                                    <img src="{{ asset('assets/uploads/defaults/nodata.png') }}" width="200">
                                    <span class="mt-3">No Data</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--member loan application-->
        <div class="tab-pane fade" id="memberApploans" role="tabpanel" aria-labelledby="memberApploans-tab">
            <div class="row">
                <div class="col-xl-12 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            @if ($data['loansByMember']->count() > 0)
                                <div class="card ">
                                    <h6 class="card-title">Applications From Members</h6>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Loan No</th>
                                                    <th>Member / Group</th>
                                                    <!-- <th>Loan Type</th> -->
                                                    <th>Loan Product</th>
                                                    <th>Principal Amount</th>
                                                    <th>Repayment Amount</th>
                                                    <!-- <th>Fees Total</th> -->
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $i = 0; @endphp
                                                @foreach ($data['loansByMember'] as $row)
                                                    @php $i++; @endphp
                                                    <tr>
                                                        <th scope="row">{{ $i }}</th>
                                                        <td><a
                                                                href="{{ route('webmaster.loan.dashboard', $row->loan_no) }}">{{ $row->loan_no }}</a>
                                                        </td>
                                                        <td>
                                                            @if ($row->loan_type == 'individual')
                                                                {{ $row->member->fname }} - {{ $row->member->lname }}
                                                            @endif
                                                            @if ($row->loan_type == 'group')
                                                                {{ $row->member->fname }}
                                                            @endif
                                                        </td>
                                                        <!--  <td>
                                                                                                         @if ($row->loan_type == 'individual')
    INDIVIDUAL LOAN
    @endif
                                                                                                                                                                                                @if ($row->loan_type == 'group')
    GROUP LOAN
    @endif
                                                                                                      </td> -->
                                                        <td>{{ $row->loanproduct->name }}</td>
                                                        <td>{!! showAmount($row->principal_amount) !!}</td>
                                                        <td>{!! showAmount($row->repayment_amount) !!}</td>
                                                        <!-- <td>{!! showAmount($row->fees_total) !!}</td> -->
                                                        <td>
                                                            <div class="badge badge-warning">WAITING FOR REVIEW</div>
                                                        </td>
                                                        <td>
                                                            @can('edit_loans')
                                                                <a href="{{ route('webmaster.loan.edit', $row->id) }}"
                                                                    class="btn btn-xs btn-dark"> <i
                                                                        class="far fa-edit"></i>Edit</a>
                                                            @endcan
                                                            @can('delete_loans')
                                                                <form action="{{ route('webmaster.loan.destroy', $row->id) }}"
                                                                    method="POST" style="display:inline;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-xs btn-dark">
                                                                        <i class="fas fa-trash"></i> Delete
                                                                    </button>
                                                                </form>
                                                            @endcan
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @else
                                <div class="d-flex flex-column align-items-center mt-5">
                                    <img src="{{ asset('assets/uploads/defaults/nodata.png') }}" width="200">
                                    <span class="mt-3">No Data</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--loans in arrear-->
        <div class="tab-pane fade" id="arrearloans" role="tabpanel" aria-labelledby="arrearloans-tab">
            <div class="row">
                <div class="col-xl-12 mx-auto">
                    <div class="table-responsive">
                        <table class='table table-striped table-bordered'>
                            <thead>
                                <tr>
                                    <th>Loan Number</th>
                                    <th>Borrower's Name</th>
                                    <th>Loan Amount</th>
                                    <th>Outstanding Balance</th>
                                    <th>Due Date</th>
                                    <th>Missed Payments</th>
                                    <th>Total Amount Due</th>
                                    <th>Interest Rate(%)</th>
                                    {{-- <th>Loan Status</th> --}}
                                    <th>Next Payment Date</th>
                                    <th>Last Payment Date</th>
                                </tr>
                            </thead>
                            @if ($data['arrearloans']->count() > 0)
                                <tbody>
                                    @foreach ($data['arrearloans'] as $row)
                                        <tr>
                                            <td>{{ $row->loan_no }}</td>
                                            <td>
                                                @if ($row->loan_type == 'individual')
                                                    {{ ucfirst(strtolower($row->member->fname)) . ' ' . ucfirst(strtolower($row->member->lname)) }}
                                                @else
                                                    {{ ucfirst(strtolower($row->name)) }}
                                                @endif
                                            </td>
                                            <td>
                                                {{ $row->principal_amount }}
                                            </td>
                                            <td> {{ $row->repayment_amount }}</td>
                                            <td> {{ $row->loan_due_date }}</td>
                                            <td> {{ $row->missed_payments }}</td>
                                            <td> {{ $row->balance_amount }}</td>
                                            <td> {{ $row->loanproduct->interest_rate }}</td>
                                            <td> {{ $row->loan_due_date }}</td>
                                            {{-- <td> {{$row->loan_due_date}}</td> --}}
                                            <td> {{ $row->last_payment_date }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        "use strict";
        $('.nav-tabs a').on('shown.bs.tab', function(event) {
            var tab = $(event.target).attr("href");
            var url = "{{ route('webmaster.loans') }}";
            history.pushState({}, null, url + "?tab=" + tab.substring(1));
        });

        @if (isset($_GET['tab']))
            $('.nav-tabs a[href="#{{ $_GET['tab'] }}"]').tab('show');
        @endif
    </script>
    <script>
        $(document).ready(function() {
            $('.data_div').DataTable({
                responsive: true,
                dom: 'Bfrtip',
                buttons: ['copy', 'excel', 'csv', 'pdf', 'print'],
                pageLength: 15,
                order: [
                    [1, 'desc']
                ],
                language: {
                    emptyTable: "No loans found."
                }
            });
        });
    </script>
@endsection
