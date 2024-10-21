<div class="text-center mt-3">
    <h4><strong>#{{ $loan->loan_no }}</strong></h4>
</div>
<!-- <div class="float-right">
         <a href="{{ route('webmaster.loan.reviewpdf', $loan->loan_no) }}" class="btn btn-sm btn-secondary" target="_blank"> <i class="fa fa-download"></i> Download PDF </a>
      </div> -->
<hr>
<div class="row mt-4">
    <div class="col-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Member / Group</th>
                    <th>Loan Product</th>
                    <th>Interest Rate</th>
                    <th>Loan Period</th>
                    <th>Release Date</th>
                    <th>Repayment Date</th>
                    <th>Loan End Date</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <!-- Member / Group -->
                    <td>
                        @if ($loan->loan_type == 'individual')
                            {{ $loan->member->title }} {{ $loan->member->fname }}
                            {{ $loan->member->lname }} {{ $loan->member->oname }}
                        @elseif($loan->loan_type == 'group')
                            {{ $loan->member->fname }}
                        @endif
                    </td>
                    <!-- Loan Product -->
                    <td>{{ $loan->loanproduct->name }}</td>
                    <!-- Interest Rate -->
                    <td>{{ $loan->loanproduct->interest_rate }}% /
                        @if ($loan->loanproduct->duration == 'day')
                            DAY
                        @endif
                        @if ($loan->loanproduct->duration == 'week')
                            WEEK
                        @endif
                        @if ($loan->loanproduct->duration == 'month')
                            MONTH
                        @endif
                    </td>
                    <!-- Loan Period -->
                    <td>{{ $loan->loan_period }}
                        @if ($loan->loanproduct->duration == 'day')
                            days
                        @endif
                        @if ($loan->loanproduct->duration == 'week')
                            weeks
                        @endif
                        @if ($loan->loanproduct->duration == 'month')
                            months
                        @endif
                    </td>
                    <!-- Release Date -->
                    <td>{{ dateFormat($loan->release_date) }}</td>
                    <!-- Repayment Date -->
                    <td>{{ dateFormat($loan->repayment_date) }}</td>
                    <!-- Loan End Date -->
                    <td>{{ dateFormat($loan->end_date) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="row">
    <div class="col-md-3 col-xl-3 col-6">
        <div class="mb-3">
            <h6 class="text-muted mb-0">Principal Amount</h6>
        </div>
        <div class="align-items-center">
            <h4 class="align-items-center mb-0" style="border-bottom: 2px solid #000;">
                {!! showAmount($loan->principal_amount) !!}
            </h4>
        </div>
    </div>

    <div class="col-md-3 col-xl-3 col-6">
        <div class="mb-3">
            <h6 class="text-muted mb-0">Interest Amount</h6>
        </div>
        <div class="align-items-center">
            <h4 class="d-flex align-items-center mb-0" style="border-bottom: 2px solid #000;">
                {!! showAmount($loan->interest_amount) !!}
            </h4>
        </div>
    </div>

    <div class="col-md-3 col-xl-3 col-6">
        <div class="mb-3">
            <h6 class="text-muted mb-0">Loan Amount</h6>
        </div>
        <div class="align-items-center">
            <h4 class="d-flex align-items-center mb-0" style="border-bottom: 2px solid #000;">
                {!! showAmount($loan->repayment_amount) !!}
            </h4>
        </div>
    </div>

    <div class="col-md-3 col-xl-3 col-6">
        <div class="mb-3">
            <h6 class="text-muted mb-0">Loan Charges</h6>
        </div>
        <div class="align-items-center">
            <h4 class="d-flex align-items-center mb-0" style="border-bottom: 2px solid #000;">
                {!! showAmount($loan->fees_total) !!}
            </h4>
        </div>
    </div>
</div>


<div class="row mt-2">
    <div class="col-md-12">
        @if ($loancharges->count() > 0)
            <h5 class="mb-3"><strong>Loan Charges</strong></h5>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Detail</th>
                            <th>Amount</th>
                            <th>Account No</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = $total_charges = 0; @endphp
                        @foreach ($loancharges as $row)
                            @php
                                $total_charges += $row->amount;
                                $i++;
                            @endphp
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $row->detail }}</td>
                                <td> {!! showAmount($row->amount) !!}</td>
                                <td>
                                    @if ($row->account_id != null)
                                        {{ $row->account->account_no }}
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
                            <td><strong>Total</strong></td>
                            <td><strong>{!! showAmount($total_charges) !!}</strong></td>
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
        @if ($guarantors->count() > 0)
            <h5 class="mb-3"><strong>Loan Guarantors</strong></h5>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Names</th>
                            <th>Email</th>
                            <th>Telephone</th>
                            <th>Address</th>
                            <th>Remark</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 0; @endphp
                        @foreach ($guarantors as $row)
                            @php $i++;  @endphp
                            <tr>
                                <td>{{ $i }}</td>
                                @if ($row->is_member == 1)
                                    <td>
                                        @if ($row->member->member_type == 'individual')
                                            {{ $row->member->title }} {{ $row->member->fname }}
                                            {{ $row->member->lname }}
                                        @endif
                                        @if ($row->member->member_type == 'group')
                                            {{ $row->member->fname }}
                                        @endif
                                    </td>
                                    <td>{{ $row->member->email }}</td>
                                    <td>{{ $row->member->telephone }}</td>
                                    <td>{{ $row->member->address }}</td>
                                    <td>Member</td>
                                @endif
                                @if ($row->is_member == 0)
                                    <td>{{ $row->name }}</td>
                                    <td>{{ $row->email }}</td>
                                    <td>{{ $row->telephone }}</td>
                                    <td>{{ $row->address }}</td>
                                    <td>Non Memeber</td>
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
             $officers = \App\Models\LoanOfficer::where('loan_id', $loan->id)->where('comment',null)->get();
        @endphp
            <h5 class="mb-3"><strong>Loan Officers</strong></h5>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Telephone</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($officers as $officer)
                        <tr>
                         <td>{{$loop->iteration}}</td>
                         <td>{{ ucwords($officer->staff->title.'.' . ' ' . $officer->staff->fname . ' ' . $officer->staff->lname) }}</td>
                         <td>{{$officer->staff->email}}</td>
                         <td>{{$officer->staff->telephone}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
    </div>
</div>

<div class="row mt-2">
    <div class="col-md-12">
        @if ($collaterals->count() > 0)
            <h5 class="mb-3"><strong>Loan Collaterals</strong></h5>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Item</th>
                            <th>Collateral Name</th>
                            <th>Estimate Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = $total_costs = 0; @endphp
                        @foreach ($collaterals as $row)
                            @php
                                $i++;
                                $total_costs += $row->estimate_value;
                            @endphp
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $row->item->name }}</td>
                                <td>{{ $row->name }}</td>
                                <td>{!! showAmount($row->estimate_value) !!}</td>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td><strong>Total</strong></td>
                            <td></td>
                            <td><strong>{!! showAmount($total_costs) !!}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- Download Button for Collateral Images -->
            <div class="mt-3">
                <a href="{{ route('webmaster.loan.collateral.download', ['id' => $row->loan_id]) }}"
                    class="btn btn-primary" title="Download Collateral attachments" target="_blank">
                    <i class="fas fa-download"></i> Download Collateral Attachments
                </a>
            </div>
        @endif
    </div>
</div>
<tr>
    <hr>
    @php
        $officers = \App\Models\LoanOfficer::where('loan_id', $loan->id)->whereNotNull('comment')->get();
    @endphp
    @if ($officers->count() > 0)
        <div class="row">
            @foreach ($officers as $row)
                @if ($row->date != null)
                    <div class="col-md-12 mb-2" style="background: #eceff4; padding: 1rem; border-radius: 5px;">
                        <div class="d-flex justify-content-between align-items-center">
                            <!-- Officer Details -->
                            <div class="d-flex flex-column">
                                <strong class="text-primary">
                                    @if($row->status == 2)
                                    Reviewed By:
                                    @elseif($row->status == 3)
                                    Approved By:
                                    @elseif($row->status == 4)
                                    Rejected By:
                                    @elseif($row->status == 5)
                                    Disbursed By:
                                    @else
                                    Canceled By:
                                    @endif
                                </strong>
                                <h6>{{ $row->staff->title }} {{ ucwords(strtolower($row->staff->fname)) }} {{ ucwords(strtolower($row->staff->lname)) }}
                                    {{ $row->staff->oname }}</h6>
                            </div>

                            <!-- Date Section -->
                            <div class="text-center">
                                <strong class="text-primary">Date:</strong>
                                <p class="mb-1">{{ dateFormat($row->date) }}</p>
                            </div>

                            <!-- Signature Section -->
                            <div class="text-center">
                                <strong class="text-primary">Signature:</strong>
                                <img alt="image"
                                    src="{{ asset('assets/uploads/staffs/' . $row->staff->signature) }}" width="60"
                                    alt="signature" />
                            </div>
                             <!-- Comment Section -->
                             <div class="text-center">
                                <strong class="text-primary">Comment:</strong>
                                <p class="mb-1">{{ $row->comment }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

    @endif
