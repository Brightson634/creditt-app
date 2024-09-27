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
                <a class="nav-link" data-toggle="tab" href="#rejectedloans" role='tab' aria-controls="rejectedloans"
                    aria-selected="false">Rejected Loans</a>
                <a class="nav-link" data-toggle="tab" href="#arrearloans" role='tab' aria-controls="arrearloans"
                    aria-selected="false">Loans in Arrear</a>
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
                    <div class="card">
                        <div class="card-body">
                            @if ($data['pendingloans']->count() > 0)
                                <div class="card card-dashboard-table-six">
                                    <h6 class="card-title">Pending Loans</h6>
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
                                                            <div class="badge bg-secondary text-white">Pending</div>
                                                        </td>
                                                        <td>
                                                            <a href="#{{ route('webmaster.loan.edit', $row->loan_no) }}"
                                                                class="btn btn-xs btn-dark"> <i class="far fa-edit"></i></a>
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
        <!--reviewed loans-->
        <div class="tab-pane fade" id="reviewloans" role="tabpanel" aria-labelledby="reviewloans-tab">
            <div class="row">
                <div class="col-xl-12 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            @if ($data['reviewloans']->count() > 0)
                                <div class="card card-dashboard-table-six">
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
                    <div class="card">
                        <div class="card-body">
                            @if ($data['approvedloans']->count() > 0)
                                <div class="card card-dashboard-table-six">
                                    <h6 class="card-title">Approved Loans</h6>
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
                                                        <td>{!! showAmount($row->fees_total) !!}</td>
                                                        <td>

                                                            <div class="badge badge-success">APPROVED</div>
                                                        </td>
                                                        <td>
                                                            <a href="javascript:void(0)" class="btn btn-xs btn-dark"
                                                                data-toggle="modal"
                                                                data-target="#approveModel{{ $row->id }}"> <i
                                                                    class="far fa-eye"></i></a>

                                                            <div class="modal fade" id="approveModel{{ $row->id }}"
                                                                tabindex="-1" role="dialog" aria-hidden="true">
                                                                <div class="modal-dialog modal-lg" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-body">

                                                                            <div class="card">
                                                                                <div class="card-body">
                                                                                    <div class="text-center mt-3">
                                                                                        <h4><strong>#{{ $row->loan_no }}</strong>
                                                                                        </h4>
                                                                                    </div>
                                                                                    <hr>
                                                                                    <div class="row mt-4">
                                                                                        <div class="col-6">
                                                                                            @if ($row->loan_type == 'individual')
                                                                                                <p class="mb-2">
                                                                                                    <strong>Member:
                                                                                                    </strong>{{ $row->member->title }}
                                                                                                    {{ $row->member->fname }}
                                                                                                    {{ $row->member->lname }}
                                                                                                    {{ $row->member->oname }}
                                                                                                </p>
                                                                                            @endif
                                                                                            @if ($row->loan_type == 'group')
                                                                                                <p class="mb-2">
                                                                                                    <strong>Group: </strong>
                                                                                                    {{ $row->member->fname }}
                                                                                                </p>
                                                                                            @endif

                                                                                            <p class="mb-2"><strong>Loan
                                                                                                    Product: </strong>
                                                                                                {{ $row->loanproduct->name }}
                                                                                            </p>

                                                                                            <p class="mb-2">
                                                                                                <strong>Interest
                                                                                                    Rate: </strong>
                                                                                                {{ $row->loanproduct->interest_rate }}%
                                                                                                / @if ($row->loanproduct->interest_term == 'day')
                                                                                                    DAY
                                                                                                    @endif @if ($row->loanproduct->interest_term == 'week')
                                                                                                        WEEK
                                                                                                        @endif @if ($row->loanproduct->interest_term == 'month')
                                                                                                            MONTH
                                                                                                        @endif
                                                                                            </p>
                                                                                            <p class="mb-2"><strong>Loan
                                                                                                    Period: </strong>
                                                                                                {{ $row->loan_term }}
                                                                                                @if ($row->loanproduct->interest_term == 'day')
                                                                                                    days
                                                                                                    @endif @if ($row->loanproduct->interest_term == 'week')
                                                                                                        weeks
                                                                                                        @endif @if ($row->loanproduct->interest_term == 'month')
                                                                                                            months
                                                                                                        @endif
                                                                                            </p>

                                                                                            <p class="mb-2">
                                                                                                <strong>Release
                                                                                                    Date: </strong>
                                                                                                {{ dateFormat($row->release_date) }}</span>
                                                                                            </p>
                                                                                            <p class="mb-2">
                                                                                                <strong>Repayment
                                                                                                    Date: </strong>
                                                                                                {{ dateFormat($row->repayment_date) }}</span>
                                                                                            </p>
                                                                                            <p class="mb-2"><strong>Loan
                                                                                                    End
                                                                                                    Date: </strong>
                                                                                                {{ dateFormat($row->end_date) }}</span>
                                                                                            </p>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="row">
                                                                                        <div
                                                                                            class="col-md-3 col-xl-3 col-6">
                                                                                            <div class="card">
                                                                                                <div class="card-body">
                                                                                                    <div class="mb-3">
                                                                                                        <h6
                                                                                                            class="text-muted mb-0">
                                                                                                            Principal Amount
                                                                                                        </h6>
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="align-items-center">
                                                                                                        <h4
                                                                                                            class="align-items-center mb-0">
                                                                                                            {!! showAmount($row->principal_amount) !!}
                                                                                                        </h4>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div
                                                                                            class="col-md-3 col-xl-3 col-6">
                                                                                            <div class="card">
                                                                                                <div class="card-body">
                                                                                                    <div class="mb-3">
                                                                                                        <h6
                                                                                                            class="text-muted mb-0">
                                                                                                            Interest Amount
                                                                                                        </h6>
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="align-items-center">
                                                                                                        <h4
                                                                                                            class="d-flex align-items-center mb-0">
                                                                                                            {!! showAmount($row->interest_amount) !!}
                                                                                                        </h4>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div
                                                                                            class="col-md-3 col-xl-3 col-6">
                                                                                            <div class="card">
                                                                                                <div class="card-body">
                                                                                                    <div class="mb-3">
                                                                                                        <h6
                                                                                                            class="text-muted mb-0">
                                                                                                            Loan Amount</h6>
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="align-items-center">
                                                                                                        <h4
                                                                                                            class="d-flex align-items-center mb-0">
                                                                                                            {!! showAmount($row->repayment_amount) !!}
                                                                                                        </h4>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div
                                                                                            class="col-md-3 col-xl-3 col-6">
                                                                                            <div class="card">
                                                                                                <div class="card-body">
                                                                                                    <div class="mb-3">
                                                                                                        <h6
                                                                                                            class="text-muted mb-0">
                                                                                                            Loan Charges
                                                                                                        </h6>
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="align-items-center">
                                                                                                        <h4
                                                                                                            class="d-flex align-items-center mb-0">
                                                                                                            {!! showAmount($row->fees_total) !!}
                                                                                                        </h4>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                                <div class="row mt-2">
                                                                                    <div class="col-md-12">
                                                                                        @php
                                                                                            $loancharges = \App\Models\LoanCharge::where(
                                                                                                'loan_id',
                                                                                                $row->id,
                                                                                            )->get();
                                                                                        @endphp
                                                                                        @if ($loancharges->count() > 0)
                                                                                            <h5 class="mb-3"><strong>Loan
                                                                                                    Charges</strong></h5>
                                                                                            <div class="table-responsive">
                                                                                                <table
                                                                                                    class="table table-sm">
                                                                                                    <thead>
                                                                                                        <tr>
                                                                                                            <th>#</th>
                                                                                                            <th>Detail</th>
                                                                                                            <th>Amount</th>
                                                                                                            <th>Account No
                                                                                                            </th>
                                                                                                        </tr>
                                                                                                    </thead>
                                                                                                    <tbody>
                                                                                                        @php $i = $total_charges = 0; @endphp
                                                                                                        @foreach ($loancharges as $charge)
                                                                                                            @php
                                                                                                                $total_charges +=
                                                                                                                    $charge->amount;
                                                                                                                $i++;
                                                                                                            @endphp
                                                                                                            <tr>
                                                                                                                <td>{{ $i }}
                                                                                                                </td>
                                                                                                                <td>{{ $charge->detail }}
                                                                                                                </td>
                                                                                                                <td> {!! showAmount($charge->amount) !!}
                                                                                                                </td>
                                                                                                                <td>
                                                                                                                    @if ($charge->account_id != null)
                                                                                                                        {{ $charge->account->account_no }}
                                                                                                                    @else
                                                                                                                        -
                                                                                                                    @endif
                                                                                                                </td>
                                                                                                            <tr>
                                                                                                        @endforeach
                                                                                                    </tbody>
                                                                                                    <tfoot>
                                                                                                        <tr>
                                                                                                            <td></td>
                                                                                                            <td><strong>Total</strong>
                                                                                                            </td>
                                                                                                            <td><strong>{!! showAmount($total_charges) !!}</strong>
                                                                                                            </td>
                                                                                                            <td></td>
                                                                                                        </tr>
                                                                                                    </tfoot>
                                                                                                </table>
                                                                                            </div>
                                                                                        @endif
                                                                                    </div>
                                                                                </div>

                                                                                <div class="row mt-2">
                                                                                    <div class="col-md-12">
                                                                                        @php
                                                                                            $guarantors = \App\Models\LoanGuarantor::where(
                                                                                                'loan_id',
                                                                                                $row->id,
                                                                                            )->get();
                                                                                        @endphp
                                                                                        @if ($guarantors->count() > 0)
                                                                                            <h5 class="mb-3"><strong>Loan
                                                                                                    Guarantors</strong></h5>
                                                                                            <div class="table-responsive">
                                                                                                <table
                                                                                                    class="table table-sm">
                                                                                                    <thead>
                                                                                                        <tr>
                                                                                                            <th>#</th>
                                                                                                            <th>Names</th>
                                                                                                            <th>Email</th>
                                                                                                            <th>Telephone
                                                                                                            </th>
                                                                                                            <th>Address</th>
                                                                                                            <th>Remark</th>
                                                                                                        </tr>
                                                                                                    </thead>
                                                                                                    <tbody>
                                                                                                        @php $i = 0; @endphp
                                                                                                        @foreach ($guarantors as $guarantor)
                                                                                                            @php $i++;  @endphp
                                                                                                            <tr>
                                                                                                                <td>{{ $i }}
                                                                                                                </td>
                                                                                                                @if ($guarantor->is_member == 1)
                                                                                                                    <td>
                                                                                                                        @if ($guarantor->member->member_type == 'individual')
                                                                                                                            {{ $guarantor->member->title }}
                                                                                                                            {{ $guarantor->member->fname }}
                                                                                                                            {{ $guarantor->member->lname }}
                                                                                                                        @endif
                                                                                                                        @if ($guarantor->member->member_type == 'group')
                                                                                                                            {{ $guarantor->member->fname }}
                                                                                                                        @endif
                                                                                                                    </td>
                                                                                                                    <td>{{ $guarantor->member->email }}
                                                                                                                    </td>
                                                                                                                    <td>{{ $guarantor->member->telephone }}
                                                                                                                    </td>
                                                                                                                    <td>{{ $guarantor->member->address }}
                                                                                                                    </td>
                                                                                                                    <td>Member
                                                                                                                    </td>
                                                                                                                @endif
                                                                                                                @if ($guarantor->is_member == 0)
                                                                                                                    <td>{{ $guarantor->name }}
                                                                                                                    </td>
                                                                                                                    <td>{{ $guarantor->email }}
                                                                                                                    </td>
                                                                                                                    <td>{{ $guarantor->telephone }}
                                                                                                                    </td>
                                                                                                                    <td>{{ $guarantor->address }}
                                                                                                                    </td>
                                                                                                                    <td>Non
                                                                                                                        Memeber
                                                                                                                    </td>
                                                                                                                @endif
                                                                                                            <tr>
                                                                                                        @endforeach
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </div>
                                                                                        @endif
                                                                                    </div>
                                                                                </div>

                                                                                <div class="row mt-2">
                                                                                    <div class="col-md-12">
                                                                                        @php
                                                                                            $collaterals = \App\Models\LoanCollateral::where(
                                                                                                'loan_id',
                                                                                                $row->id,
                                                                                            )->get();
                                                                                        @endphp
                                                                                        @if ($collaterals->count() > 0)
                                                                                            <h5 class="mb-3"><strong>Loan
                                                                                                    Collaterals</strong>
                                                                                            </h5>
                                                                                            <div class="table-responsive">
                                                                                                <table
                                                                                                    class="table table-sm">
                                                                                                    <thead>
                                                                                                        <tr>
                                                                                                            <th>#</th>
                                                                                                            <th>Item</th>
                                                                                                            <th>Collateral
                                                                                                                Name
                                                                                                            </th>
                                                                                                            <th>Estimate
                                                                                                                Value
                                                                                                            </th>
                                                                                                        </tr>
                                                                                                    </thead>
                                                                                                    <tbody>
                                                                                                        @php $i = $total_costs = 0; @endphp
                                                                                                        @foreach ($collaterals as $collateral)
                                                                                                            @php
                                                                                                                $i++;
                                                                                                                $total_costs +=
                                                                                                                    $collateral->estimate_value;
                                                                                                            @endphp
                                                                                                            <tr>
                                                                                                                <td>{{ $i }}
                                                                                                                </td>
                                                                                                                <td>{{ $collateral->item->name }}
                                                                                                                </td>
                                                                                                                <td>{{ $collateral->name }}
                                                                                                                </td>
                                                                                                                <td>{!! showAmount($collateral->estimate_value) !!}
                                                                                                                </td>
                                                                                                            <tr>
                                                                                                        @endforeach
                                                                                                    </tbody>
                                                                                                    <tfoot>
                                                                                                        <tr>
                                                                                                            <td></td>
                                                                                                            <td><strong>Total</strong>
                                                                                                            </td>
                                                                                                            <td></td>
                                                                                                            <td><strong>{!! showAmount($total_costs) !!}</strong>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    </tfoot>
                                                                                                </table>
                                                                                            </div>
                                                                                        @endif
                                                                                    </div>
                                                                                </div>

                                                                                <hr>
                                                                                @php
                                                                                    $officers = \App\Models\LoanOfficer::where(
                                                                                        'loan_id',
                                                                                        $row->id,
                                                                                    )->get();
                                                                                @endphp
                                                                                @if ($officers->count() > 0)
                                                                                    <div class="row">
                                                                                        <h4>Approving Notes</h4>
                                                                                        @foreach ($officers as $officer)
                                                                                            @if ($officer->date != null)
                                                                                                <div class="col-md-12 mb-2"
                                                                                                    style="background: #eceff4;padding: 0.5rem;">
                                                                                                    <div class="mb-3">
                                                                                                        <small>{{ $officer->comment }}</small>
                                                                                                    </div>

                                                                                                    <div class="">

                                                                                                        <img alt="image"
                                                                                                            src="{{ asset('assets/uploads/staffs/' . $officer->staff->signature) }}"
                                                                                                            width="130"
                                                                                                            alt="signature" />
                                                                                                        <h6>{{ $officer->staff->title }}
                                                                                                            {{ $officer->staff->fname }}
                                                                                                            {{ $officer->staff->lname }}
                                                                                                            {{ $officer->staff->oname }}
                                                                                                        </h6>
                                                                                                        <small>{{ dateFormat($officer->date) }}</small>
                                                                                                    </div>
                                                                                                </div>
                                                                                            @endif
                                                                                        @endforeach
                                                                                    </div>
                                                                                @endif
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>















                                                            <a href="{{ route('webmaster.loan.printpdf', $row->loan_no) }}"
                                                                target="_blank" class="btn btn-xs btn-secondary"> <i
                                                                    class="fa fa-download"></i></a>
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
        <!--rejected loans-->
        <div class="tab-pane fade" id="rejectedloans" role="tabpanel" aria-labelledby="rejectedloans-tab">
            <div class="row">
                <div class="col-xl-12 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            @if ($data['rejectloans']->count() > 0)
                                <div class="card card-dashboard-table-six">
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
                                    <td>{{$row->loan_no}}</td>
                                    <td>
                                        @if ($row->loan_type == 'individual')
                                            {{ ucfirst(strtolower($row->member->fname)). ' ' .ucfirst(strtolower($row->member->lname)) }}
                                        @else
                                            {{ ucfirst(strtolower($row->name))}}
                                        @endif
                                    </td>
                                    <td>
                                        {{$row->principal_amount}}
                                    </td>
                                    <td> {{$row->repayment_amount}}</td>
                                    <td> {{$row->loan_due_date}}</td>
                                    <td> {{$row->missed_payments}}</td>
                                    <td> {{$row->balance_amount}}</td>
                                    <td> {{$row->loanproduct->interest_rate}}</td>
                                    <td> {{$row->loan_due_date}}</td>
                                    {{-- <td> {{$row->loan_due_date}}</td> --}}
                                    <td> {{$row->last_payment_date}}</td>
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
@endsection
