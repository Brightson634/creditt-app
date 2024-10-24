@extends('webmaster.partials.main')
@section('title')
    {{ $page_title }}
@endsection
@section('content')
<div class="page-heading ">
   <div class="page-heading__title">
      <h3>{{ $page_title }}</h3>
      <div>
         <a href="{{ route('webmaster.loan.create') }}" class="btn btn-sm btn-theme"> <i class="fa fa-plus"></i> New Loan</a>
      </div>
   </div>

   <div class="page-heading__title">
      <ul class="nav nav-tabs">
         <li class="nav-item"> 
            <a class="nav-link active" href="#pendingloans" data-toggle="tab" aria-expanded="false"><i class="fas fa-chart-line"></i> Pending Loans</a>
         </li>
         <li class="nav-item"> 
            <a class="nav-link" href="#reviewloans" data-toggle="tab" aria-expanded="false"><i class="far fa-user"></i> Review Loans</a>
         </li>
         <li class="nav-item"> 
            <a class="nav-link" href="#approvedloans" data-toggle="tab" aria-expanded="false"><i class="far fa-user"></i> Approved Loans</a>
         </li>
         <li class="nav-item"> 
            <a class="nav-link" href="#rejectedloans" data-toggle="tab" aria-expanded="false"><i class="far fa-user"></i> Rejected Loans</a>
         </li>
      </ul>
   </div>
</div>

<div class="tab-content">
   <div class="tab-pane show active" id="pendingloans">
      <div class="row">
         <div class="col-xl-12 mx-auto">
            <div class="card">
               <div class="card-body">
                  <div class="clearfix mb-3">
                     <div class="float-left">
                        <h3 class="card-title">Pending</h3>
                     </div>
                  </div>
                  @if($data['pendingloans']->count() > 0)
                  <div class="table-responsive">
                     <table class="table table-sm mb-0">
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
                           @foreach($data['pendingloans'] as $row)
                           @php $i++; @endphp
                           <tr>
                              <th scope="row">{{ $i }}</th>
                              <td><a href="{{ route('webmaster.loan.dashboard', $row->loan_no) }}">{{ $row->loan_no }}</a></td>
                              <td>
                                 @if($row->loan_type == 'individual') {{ $row->member->fname }} - {{ $row->member->lname }} @endif
                                 @if($row->loan_type == 'group') {{ $row->member->fname }} @endif
                              </td>
                             <!--  <td>
                                 @if($row->loan_type == 'individual') INDIVIDUAL LOAN @endif
                                 @if($row->loan_type == 'group') GROUP LOAN @endif
                              </td> -->
                              <td>{{ $row->loanproduct->name }}</td>
                              <td>{!! showAmount($row->principal_amount) !!}</td>
                              <td>{!! showAmount($row->repayment_amount) !!}</td>
                              <!-- <td>{!! showAmount($row->fees_total) !!}</td> -->
                              <td>
                                 @if($row->status == 0)
                                    <div class="badge badge-info">PENDING</div>
                                 @endif
                                 @if($row->status == 1)
                                    <div class="badge badge-warning">UNDER REVIEW</div>
                                 @endif
                                 @if($row->status == 2)
                                    <div class="badge badge-success">APPROVED</div>
                                 @endif
                                 @if($row->status == 3)
                                    <div class="badge badge-danger">REJECTED</div>
                                 @endif
                              </td>
                              <td>  
                                <a href="#{{ route('webmaster.loan.edit', $row->loan_no) }}" class="btn btn-xs btn-dark"> <i class="far fa-edit"></i></a>
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
      </div>
   </div>

   <div class="tab-pane" id="reviewloans">
      <div class="row">
         <div class="col-xl-12 mx-auto">
            <div class="card">
               <div class="card-body">
                  <div class="clearfix mb-3">
                     <div class="float-left">
                        <h3 class="card-title">Review Loans</h3>
                     </div>
                  </div>
                  @if($data['reviewloans']->count() > 0)
                  <div class="table-responsive">
                     <table class="table table-sm mb-0">
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
                           @foreach($data['reviewloans'] as $row)
                           @php $i++; @endphp
                           <tr>
                              <th scope="row">{{ $i }}</th>
                              <td><a href="{{ route('webmaster.loan.dashboard', $row->loan_no) }}">{{ $row->loan_no }}</a></td>
                              <td>
                                 @if($row->loan_type == 'individual') {{ $row->member->fname }} - {{ $row->member->lname }} @endif
                                 @if($row->loan_type == 'group') {{ $row->member->fname }} @endif
                              </td>
                             <!--  <td>
                                 @if($row->loan_type == 'individual') INDIVIDUAL LOAN @endif
                                 @if($row->loan_type == 'group') GROUP LOAN @endif
                              </td> -->
                              <td>{{ $row->loanproduct->name }}</td>
                              <td>{!! showAmount($row->principal_amount) !!}</td>
                              <td>{!! showAmount($row->repayment_amount) !!}</td>
                              <!-- <td>{!! showAmount($row->fees_total) !!}</td> -->
                              <td>
                                 @if($row->status == 0)
                                    <div class="badge badge-info">PENDING</div>
                                 @endif
                                 @if($row->status == 1)
                                    <div class="badge badge-warning">UNDER REVIEW</div>
                                 @endif
                                 @if($row->status == 2)
                                    <div class="badge badge-success">APPROVED</div>
                                 @endif
                                 @if($row->status == 3)
                                    <div class="badge badge-danger">REJECTED</div>
                                 @endif
                              </td>
                              <td>  
                                <a href="{{ route('webmaster.loan.review', $row->loan_no) }}" class="btn btn-xs btn-dark"> <i class="far fa-eye"></i></a>
                                <a href="{{ route('webmaster.loan.preview', $row->loan_no) }}" class="btn btn-xs btn-dark"> <i class="far fa-eye"></i></a>
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
      </div>
   </div>
   <div class="tab-pane" id="approvedloans">
      <div class="row">
         <div class="col-xl-12 mx-auto">
            <div class="card">
               <div class="card-body">
                  <div class="clearfix mb-3">
                     <div class="float-left">
                        <h3 class="card-title">Approved Loans</h3>
                     </div>
                  </div>
                  @if($data['approvedloans']->count() > 0)
                  <div class="table-responsive">
                     <table class="table table-sm mb-0">
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
                           @foreach($data['approvedloans'] as $row)
                           @php $i++; @endphp
                           <tr>
                              <th scope="row">{{ $i }}</th>
                              <td><a href="{{ route('webmaster.loan.dashboard', $row->loan_no) }}">{{ $row->loan_no }}</a></td>
                              <td>
                                 @if($row->loan_type == 'individual') {{ $row->member->fname }} - {{ $row->member->lname }} @endif
                                 @if($row->loan_type == 'group') {{ $row->member->fname }} @endif
                              </td>
                             <!--  <td>
                                 @if($row->loan_type == 'individual') INDIVIDUAL LOAN @endif
                                 @if($row->loan_type == 'group') GROUP LOAN @endif
                              </td> -->
                              <td>{{ $row->loanproduct->name }}</td>
                              <td>{!! showAmount($row->principal_amount) !!}</td>
                              <td>{!! showAmount($row->repayment_amount) !!}</td>
                              <td>{!! showAmount($row->fees_total) !!}</td>
                              <td>
                                 @if($row->status == 0)
                                    <div class="badge badge-info">PENDING</div>
                                 @endif
                                 @if($row->status == 1)
                                    <div class="badge badge-warning">UNDER REVIEW</div>
                                 @endif
                                 @if($row->status == 2)
                                    <div class="badge badge-success">APPROVED</div>
                                 @endif
                                 @if($row->status == 3)
                                    <div class="badge badge-danger">REJECTED</div>
                                 @endif
                              </td>
                              <td>  
                                <a href="javascript:void(0)" class="btn btn-xs btn-dark" data-toggle="modal" data-target="#approveModel{{ $row->id }}"> <i class="far fa-eye"></i></a>

 <div class="modal fade" id="approveModel{{ $row->id }}" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">                          
         <div class="modal-body">

            <div class="card">
         <div class="card-body">
            <div class="text-center mt-3">
               <h4><strong>#{{ $row->loan_no }}</strong></h4>
            </div>
            <hr>
                        <div class="row mt-4">
               <div class="col-6">
                  @if($row->loan_type == 'individual')
                  <p class="mb-2"><strong>Member: </strong>{{ $row->member->title }} {{ $row->member->fname }} {{ $row->member->lname }} {{ $row->member->oname }}</p>
                  @endif
                  @if($row->loan_type == 'group')
                  <p class="mb-2"><strong>Group: </strong> {{ $row->member->fname }}</p>
                  @endif

                  <p class="mb-2"><strong>Loan Product: </strong> {{ $row->loanproduct->name }}</p>

                  <p class="mb-2"><strong>Interest Rate: </strong> {{ $row->loanproduct->interest_rate }}% / @if($row->loanproduct->interest_term == 'day') DAY @endif @if($row->loanproduct->interest_term == 'week') WEEK  @endif @if($row->loanproduct->interest_term == 'month') MONTH  @endif</p>

                  <p class="mb-2"><strong>Loan Period: </strong> {{ $row->loan_term }} @if($row->loanproduct->interest_term == 'day') days @endif @if($row->loanproduct->interest_term == 'week') weeks  @endif @if($row->loanproduct->interest_term == 'month') months  @endif</p>

                  <p class="mb-2"><strong>Release Date: </strong> {{ dateFormat($row->release_date) }}</span></p>
                  <p class="mb-2"><strong>Repayment Date: </strong> {{ dateFormat($row->repayment_date) }}</span></p>
                  <p class="mb-2"><strong>Loan End Date: </strong> {{ dateFormat($row->end_date) }}</span></p>
               </div>
            </div>

            <div class="row">
               <div class="col-md-3 col-xl-3 col-6">
                  <div class="card">
                     <div class="card-body">
                        <div class="mb-3">
                           <h6 class="text-muted mb-0">Principal Amount</h6>
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
                           <h6 class="text-muted mb-0">Interest Amount</h6>
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
                           <h6 class="text-muted mb-0">Loan Amount</h6>
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
                           <h6 class="text-muted mb-0">Loan Charges</h6>
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
                     $loancharges = \App\Models\LoanCharge::where('loan_id',  $row->id)->get();
                  @endphp
                  @if($loancharges->count() > 0)
                  <h5 class="mb-3"><strong>Loan Charges</strong></h5>
                  <div class="table-responsive">
                     <table class="table table-sm">
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
                           @foreach($loancharges as $charge)
                           @php 
                           $total_charges += $charge->amount;
                           $i++; 
                           @endphp
                           <tr>
                              <td>{{ $i }}</td>
                              <td>{{ $charge->detail }}</td>
                              <td> {!! showAmount($charge->amount) !!}</td>
                              <td>@if($charge->account_id != NULL) {{ $charge->account->account_no }}  @else -  @endif </td>
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
                  @php 
                     $guarantors = \App\Models\LoanGuarantor::where('loan_id',  $row->id)->get();
                  @endphp
                  @if($guarantors->count() > 0)
                  <h5 class="mb-3"><strong>Loan Guarantors</strong></h5>
                  <div class="table-responsive">
                     <table class="table table-sm">
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
                           @foreach($guarantors as $guarantor)
                           @php $i++;  @endphp
                           <tr>
                              <td>{{ $i }}</td>
                              @if($guarantor->is_member == 1)
                                 <td>
                                    @if($guarantor->member->member_type == 'individual') {{ $guarantor->member->title }} {{ $guarantor->member->fname }} {{ $guarantor->member->lname }} @endif
                                    @if($guarantor->member->member_type == 'group') {{ $guarantor->member->fname }} @endif
                                 </td>
                                 <td>{{ $guarantor->member->email }}</td>
                                 <td>{{ $guarantor->member->telephone }}</td>
                                 <td>{{ $guarantor->member->address }}</td>
                                 <td>Member</td>
                              @endif
                              @if($guarantor->is_member == 0)
                                 <td>{{ $guarantor->name }}</td>
                                 <td>{{ $guarantor->email }}</td>
                                 <td>{{ $guarantor->telephone }}</td>
                                 <td>{{ $guarantor->address }}</td>
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
                     $collaterals = \App\Models\LoanCollateral::where('loan_id',  $row->id)->get();
                  @endphp
                  @if($collaterals->count() > 0)
                  <h5 class="mb-3"><strong>Loan Collaterals</strong></h5>
                  <div class="table-responsive">
                     <table class="table table-sm">
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
                           @foreach($collaterals as $collateral)
                           @php 
                           $i++;
                           $total_costs += $collateral->estimate_value;
                           @endphp
                           <tr>
                              <td>{{ $i }}</td>
                              <td>{{ $collateral->item->name }}</td>
                              <td>{{ $collateral->name }}</td>
                              <td>{!! showAmount($collateral->estimate_value) !!}</td>
                           <tr>
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
                  @endif
               </div>
            </div>

             <hr>
            @php
            $officers = \App\Models\LoanOfficer::where('loan_id', $row->id)->get();
            @endphp
            @if($officers->count() > 0)
            <div class="row">
               <h4>Approving Notes</h4>
               @foreach($officers as $officer)
               @if($officer->date != NULL)
               <div class="col-md-12 mb-2" style="background: #eceff4;padding: 0.5rem;">
                  <div class="mb-3">
                     <small>{{ $officer->comment }}</small>
                  </div>

                  <div class="">
                     
                     <img alt="image" src="{{ asset('assets/uploads/staffs/'. $officer->staff->signature )}}" width="130" alt="signature" />
                     <h6>{{ $officer->staff->title }} {{ $officer->staff->fname }} {{ $officer->staff->lname }} {{ $officer->staff->oname }}</h6>
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















                           <a href="{{ route('webmaster.loan.printpdf', $row->loan_no) }}" target="_blank" class="btn btn-xs btn-secondary"> <i class="fa fa-download"></i></a>
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
      </div>
   </div>
   <div class="tab-pane" id="rejectedloans">
      <div class="row">
         <div class="col-xl-12 mx-auto">
            <div class="card">
               <div class="card-body">
                  <div class="clearfix mb-3">
                     <div class="float-left">
                        <h3 class="card-title">Rejected Loans</h3>
                     </div>
                  </div>
                  @if($data['rejectloans']->count() > 0)
                  <div class="table-responsive">
                     <table class="table table-sm mb-0">
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
                           @foreach($data['rejectloans'] as $row)
                           @php $i++; @endphp
                           <tr>
                              <th scope="row">{{ $i }}</th>
                              <td><a href="{{ route('webmaster.loan.dashboard', $row->loan_no) }}">{{ $row->loan_no }}</a></td>
                              <td>
                                 @if($row->loan_type == 'individual') {{ $row->member->fname }} - {{ $row->member->lname }} @endif
                                 @if($row->loan_type == 'group') {{ $row->member->fname }} @endif
                              </td>
                             <!--  <td>
                                 @if($row->loan_type == 'individual') INDIVIDUAL LOAN @endif
                                 @if($row->loan_type == 'group') GROUP LOAN @endif
                              </td> -->
                              <td>{{ $row->loanproduct->name }}</td>
                              <td>{!! showAmount($row->principal_amount) !!}</td>
                              <td>{!! showAmount($row->repayment_amount) !!}</td>
                              <!-- <td>{!! showAmount($row->fees_total) !!}</td> -->
                              <td>
                                 @if($row->status == 0)
                                    <div class="badge badge-info">PENDING</div>
                                 @endif
                                 @if($row->status == 1)
                                    <div class="badge badge-warning">UNDER REVIEW</div>
                                 @endif
                                 @if($row->status == 2)
                                    <div class="badge badge-success">APPROVED</div>
                                 @endif
                                 @if($row->status == 3)
                                    <div class="badge badge-danger">REJECTED</div>
                                 @endif
                              </td>
                              <td>  
                                <a href="#{{ route('webmaster.loan.edit', $row->loan_no) }}" class="btn btn-xs btn-dark"> <i class="far fa-edit"></i></a>
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
      </div>
   </div>
</div>
@endsection

@section('scripts')
   <script type="text/javascript">
      "use strict";
      $('.nav-tabs a').on('shown.bs.tab', function(event){
         var tab = $(event.target).attr("href");
         var url = "{{ route('webmaster.loans',) }}";
          history.pushState({}, null, url + "?tab=" + tab.substring(1));
      });

      @if(isset($_GET['tab']))
         $('.nav-tabs a[href="#{{ $_GET['tab'] }}"]').tab('show');
      @endif


   </script>
@endsection