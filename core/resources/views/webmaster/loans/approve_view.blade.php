
 <div id="approveModel{{ $row->id }}" class="modal">
     <div class="modal-dialog modal-lg" role="document">
         <div class="modal-content modal-content-demo">
             <div class="modal-header">
                 <h6 class="modal-title">View</h6>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
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
                             <div class="col-md-3 col-xl-3 col-6">
                                 <div class="card">
                                     <div class="card-body">
                                         <div class="mb-3">
                                             <h6 class="text-muted mb-0">
                                                 Principal Amount
                                             </h6>
                                         </div>
                                         <div class="align-items-center">
                                             <h4 class="align-items-center mb-0">
                                                 {!! showAmount($row->principal_amount) !!}
                                             </h4>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             <div class="col-md-3 col-xl-3 col-6">
                                 <div class="card">
                                     <div class="card-body">
                                         <div class="mb-3">
                                             <h6 class="text-muted mb-0">
                                                 Interest Amount
                                             </h6>
                                         </div>
                                         <div class="align-items-center">
                                             <h4 class="d-flex align-items-center mb-0">
                                                 {!! showAmount($row->interest_amount) !!}
                                             </h4>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             <div class="col-md-3 col-xl-3 col-6">
                                 <div class="card">
                                     <div class="card-body">
                                         <div class="mb-3">
                                             <h6 class="text-muted mb-0">
                                                 Loan Amount</h6>
                                         </div>
                                         <div class="align-items-center">
                                             <h4 class="d-flex align-items-center mb-0">
                                                 {!! showAmount($row->repayment_amount) !!}
                                             </h4>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             <div class="col-md-3 col-xl-3 col-6">
                                 <div class="card">
                                     <div class="card-body">
                                         <div class="mb-3">
                                             <h6 class="text-muted mb-0">
                                                 Loan Charges
                                             </h6>
                                         </div>
                                         <div class="align-items-center">
                                             <h4 class="d-flex align-items-center mb-0">
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
                                 $loancharges = \App\Models\LoanCharge::where('loan_id', $row->id)->get();
                             @endphp
                             @if ($loancharges->count() > 0)
                                 <h5 class="mb-3"><strong>Loan
                                         Charges</strong></h5>
                                 <div class="table-responsive">
                                     <table class="table table-sm">
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
                                                     $total_charges += $charge->amount;
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
                                 $guarantors = \App\Models\LoanGuarantor::where('loan_id', $row->id)->get();
                             @endphp
                             @if ($guarantors->count() > 0)
                                 <h5 class="mb-3"><strong>Loan
                                         Guarantors</strong></h5>
                                 <div class="table-responsive">
                                     <table class="table table-sm">
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
                                 $collaterals = \App\Models\LoanCollateral::where('loan_id', $row->id)->get();
                             @endphp
                             @if ($collaterals->count() > 0)
                                 <h5 class="mb-3"><strong>Loan
                                         Collaterals</strong>
                                 </h5>
                                 <div class="table-responsive">
                                     <table class="table table-sm">
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
                                                     $total_costs += $collateral->estimate_value;
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
                         $officers = \App\Models\LoanOfficer::where('loan_id', $row->id)->get();
                     @endphp
                     @if ($officers->count() > 0)
                         <div class="row">
                             <h4>Approving Notes</h4>
                             @foreach ($officers as $officer)
                                 @if ($officer->date != null)
                                     <div class="col-md-12 mb-2" style="background: #eceff4;padding: 0.5rem;">
                                         <div class="mb-3">
                                             <small>{{ $officer->comment }}</small>
                                         </div>

                                         <div class="">

                                             <img alt="image"
                                                 src="{{ asset('assets/uploads/staffs/' . $officer->staff->signature) }}"
                                                 width="130" alt="signature" />
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
             </div><!-- modal-body -->
             <div class="modal-footer">
                 <button type="button" class="btn btn-indigo">Save changes</button>
                 <button type="button" data-dismiss="modal" class="btn btn-outline-light">Close</button>
             </div>
         </div>
     </div><!-- modal-dialog -->
 </div><!-- modal -->
