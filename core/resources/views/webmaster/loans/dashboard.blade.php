@extends('webmaster.partials.main')
@section('title')
    {{ $page_title }}
@endsection
@section('content')

<div class="page-heading ">
   <div class="page-heading__title">
      <h3><i class="fa fa-home"></i> {{ $page_title }}</h3>
      <div>
         <a href="{{ route('webmaster.loan.create') }}" class="btn btn-sm btn-theme"> <i class="fa fa-plus"></i> New Loan</a>
         <a href="{{ route('webmaster.loans') }}" class="btn btn-sm btn-secondary"> <i class="fa fa-eye"></i> View Loans</a>
      </div>
   </div>

   <div class="page-heading__title">
      <ul class="nav nav-tabs">
         <li class="nav-item"> 
            <a class="nav-link active" href="#overview" data-toggle="tab" aria-expanded="false"><i class="fas fa-chart-line"></i> Overview</a>
         </li>
         <li class="nav-item"> 
            <a class="nav-link" href="#officers" data-toggle="tab" aria-expanded="false"><i class="far fa-user"></i> Officers</a>
         </li>
         <li class="nav-item"> 
            <a class="nav-link" href="#charges" data-toggle="tab" aria-expanded="false"><i class="far fa-user"></i> Charges</a>
         </li>
         <li class="nav-item"> 
            <a class="nav-link" href="#guarantors" data-toggle="tab" aria-expanded="false"><i class="far fa-user"></i> Guarantors</a>
         </li>
         <li class="nav-item"> 
            <a class="nav-link" href="#collaterals" data-toggle="tab" aria-expanded="false"><i class="far fa-user"></i> Collaterals</a>
         </li>
         <li class="nav-item"> 
            <a class="nav-link" href="#repayments" data-toggle="tab" aria-expanded="false"><i class="far fa-user"></i> Repayments</a>
         </li>
         <li class="nav-item"> 
            <a class="nav-link" href="#penalties" data-toggle="tab" aria-expanded="false"><i class="far fa-user"></i> Penalties</a>
         </li>
         <li class="nav-item"> 
            <a class="nav-link" href="#documents" data-toggle="tab" aria-expanded="false"><i class="far fa-user"></i> Documents</a>
         </li>
      </ul>
   </div>
</div>

<div class="tab-content">
   <div class="tab-pane show active" id="overview">
            <div class="row">
         <div class="col-md-8">
            
            <div class="row">
         <div class="col-md-12">
            <div class="card">
         <div class="card-body">
            <div class="clearfix">
                  <div class="float-left">
                     <h4 class="card-title">Statistics Overview</h4>
                  </div>
                  <div class="float-right">
                     <span  class="btn btn-xs btn-secondary">Loan Status: 
                        @if($loan->status == 0) PENDING  @endif
                        @if($loan->status == 1) UNDER REVIEW @endif
                        @if($loan->status == 2) APPROVED @endif
                        @if($loan->status == 3) REJECTED @endif
                     </span>
                     @if($loan->status == 0)
                     <button type="button" class="btn btn-xs btn-info mr-1" data-toggle="modal" data-target="#reviewModel"> <i class="fa fa-arrow-right"></i> Send For Review </button>
                              <div class="modal fade" id="reviewModel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content border-0">
            <div class="modal-body">
                <div class="alert alert-fwarning" role="alert">
                    <i class="fa fa-exclamation-triangle d-block display-4 mt-2 mb-3 text-warning text-center"></i>
                    <h5 class="text-center">Are you sure you want to submit the loan <strong>#{{ $loan->loan_no }}</strong> for Review?</h5>
                    <form action="#" method="POST" id="review_form">
                      @csrf
                      <input type="hidden" name="id" class="form-control" value="{{ $loan->id}}">
                    <div class="form-group text-center mt-3">
                        <button type="button" class="btn btn-sm btn-dark" data-dismiss="modal">No, Cancel</button>
                        <button type="submit" class="btn btn-sm btn-success" id="btn_review">Yes, Submit</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
 @endif
@if($loan->status == 1)
<button type="button" class="btn btn-xs btn-info mr-1" data-toggle="modal" data-target="#approveModel"> <i class="fa fa-plus"></i> Approve </button>
                              <div class="modal fade" id="approveModel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content border-0">
            <div class="modal-body">
                <div class="alert alert-fwarning" role="alert">
                    <i class="fa fa-exclamation-triangle d-block display-4 mt-2 mb-3 text-warning text-center"></i>
                    <h5 class="text-center">Are you sure you want to approve this loan?</h5>
                    <form action="#" method="POST" id="approve_form">
                      @csrf
                      <input type="hidden" name="loan_id" class="form-control" value="{{ $loan->id}}">
                    <div class="form-group text-center mt-3">
                        <button type="button" class="btn btn-sm btn-dark" data-dismiss="modal">No, Cancel</button>
                        <button type="submit" class="btn btn-sm btn-success" id="btn_payment">Yes, Approve</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

 <button type="button" class="btn btn-xs btn-danger mr-1" data-toggle="modal" data-target="#rejectModel"> <i class="fa fa-trash"></i> Reject </button>
                           <div class="modal fade" id="rejectModel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content border-0">
            <div class="modal-body">
                <div class="alert alert-fwarning" role="alert">
                    <i class="fa fa-exclamation-triangle d-block display-4 mt-2 mb-3 text-warning text-center"></i>
                    <h5 class="text-center">Are you sure you want to reject this loan?</h5>
                    <form action="#" method="POST" id="reject_form">
                      @csrf
                    <div class="form-group text-center mt-3">
                        <button type="button" class="btn btn-sm btn-dark" data-dismiss="modal">No, Cancel</button>
                        <button type="submit" class="btn btn-sm btn-danger" id="btn_payment">Yes, Reject</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
 @endif

<!-- <button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#discardModel"> <i class="fa fa-trash"></i> Discard </button>
                           <div class="modal fade" id="discardModel" tabindex="-1" role="dialog" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document">
                              <div class="modal-content">
                                 <div class="modal-body">
                                    <h4 class="card-title mb-4"> Discard Loan </h4>
                                    <form action="#" method="POST" id="discard_form">
                                      @csrf
                                      <input type="hidden" name="loan_id" class="form-control" value="{{ $loan->id}}">
                                      <div class="form-group mb-3">
                                            <label for="expense_item">Specify the reason(s) for discarding loan</label>
                                            <textarea name="borrower_statment" class="form-control" id="borrower_statment" rows="6"></textarea>
                                            <span class="invalid-feedback"></span>
                                        </div>
                                        <div class="form-group">
                                           <button type="button" class="btn btn-sm btn-dark" data-dismiss="modal">Cancel</button>
                                           <button type="submit" class="btn btn-sm btn-info" id="btn_payment">Discard Loan</button>
                                        </div>
                                    </form>
                                 </div>
                              </div>
                           </div>
                        </div> -->


                  </div>
               </div>


            <div class="row">
               <div class="col-md-4 col-xl-4">
                  <div class="card">
                     <div class="card-body">
                        <div class="mb-3">
                           <h6 class="text-muted mb-0">Principal Amount</h6>
                        </div>
                        <div class="align-items-center">
                           <h4 class="align-items-center mb-0">
                             {!! showAmount($loan->principal_amount) !!}
                           </h4>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-4 col-xl-4">
                  <div class="card">
                     <div class="card-body">
                        <div class="mb-3">
                           <h6 class="text-muted mb-0">Interest Amount</h6>
                        </div>
                        <div class="align-items-center">
                           <h4 class="d-flex align-items-center mb-0">
                             {!! showAmount($loan->interest_amount) !!}
                           </h4>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-4 col-xl-4">
                  <div class="card">
                     <div class="card-body">
                        <div class="mb-3">
                           <h6 class="text-muted mb-0">Loan Amount</h6>
                        </div>
                        <div class="align-items-center">
                           <h4 class="d-flex align-items-center mb-0">
                             {!! showAmount($loan->repayment_amount) !!}
                           </h4>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-6 col-xl-6">
                  <div class="card shadow-lg">
                     <div class="card-body">
                        @php
                          $collectedPercentage = round(($loan->repaid_amount / $loan->repayment_amount) * 100, 2);
                        @endphp
                        <div class="mb-4">
                           <span class="text-success float-right"><strong>{{ $collectedPercentage }}%</strong></span>
                           <p class="card-title mb-0">Repaid Amount</p>
                        </div>
                        <div class="align-items-center mb-4">
                           <h2 class="align-items-center mb-0">
                             {!! showAmount($loan->repaid_amount) !!}
                           </h2>
                        </div>
                        <div class="progress shadow-sm" style="height: 5px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $collectedPercentage }}%;"></div>
                </div>
                     </div>
                  </div>
               </div>
                
               <div class="col-md-6 col-xl-6">
                  <div class="card shadow-lg">
                     <div class="card-body">
                        @php
                          $balancePercentage = round(($loan->balance_amount / $loan->repayment_amount) * 100, 2);
                        @endphp

                        <div class="mb-4">
                           <span class="text-danger float-right"><strong>{{ $balancePercentage }}%</strong></span>
                           <h5 class="card-title mb-0">Balance Amount</h5>
                        </div>
                        <div class="align-items-center mb-4">
                           <h2 class="align-items-center mb-0">
                              {!! showAmount($loan->balance_amount) !!}
                           </h2>
                        </div>
                        <div class="progress shadow-sm" style="height: 5px;">
                    
                    <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $balancePercentage }}%;"></div>
                </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
         </div>
      </div>
      <div class="row">
               <div class="col-md-6">
                  <div class="card">
                     <div class="card-body">
                        <div class="mb-4">
                           <h5 class="card-title mb-0">Loan Expenses</h5>
                        </div>
                        <div class="row d-flex align-items-center mb-2">
                           <div class="col-8">
                              <h2 class="d-flex align-items-center mb-0">
                                {!! showAmount($loan->expense_amount) !!}
                              </h2>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="card">
                     <div class="card-body">
                        <div class="mb-4">
                           <h5 class="card-title mb-0">Penalty Amount</h5>
                        </div>
                        <div class="row d-flex align-items-center mb-2">
                           <div class="col-8">
                              <h2 class="d-flex align-items-center mb-0">
                                 {!! showAmount($loan->penalty_amount) !!}
                              </h2>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>               
            </div>


         </div>
         <div class="col-md-4">
            <div class="row">
               <div class="col-md-12">
             <div class="card card-contract">
         <div class="card-body">
                                 <h4 class="card-title">Information Overview</h4>
                                 <ul class="card-contract-features">
                                    <li>Loan ID: <span class="float-right">{{ $loan->loan_no }}</span></li>
                                    <li>Member: <span class="float-right">{{ $loan->member->fname }}</span></li>
                                    <li>Loan Product: <span class="float-right">{{ $loan->loanproduct->name }}</span></li>
                                    <li>Interest Rate: <span class="float-right">{{ $loan->loanproduct->interest_rate }}% / @if($loan->loanproduct->interest_term == 'day') DAY @endif @if($loan->loanproduct->interest_term == 'week') WEEK  @endif @if($loan->loanproduct->interest_term == 'month') MONTH  @endif</span></li>
                                    <li>Loan Period: <span class="float-right">{{ $loan->loan_period }} @if($loan->loanproduct->interest_term == 'day') days @endif @if($loan->loanproduct->interest_term == 'week') weeks  @endif @if($loan->loanproduct->interest_term == 'month') months  @endif</span></li>
                                    <li>Release Date: <span class="float-right">{{ dateFormat($loan->release_date) }}</span></li>
                                    <li>Repayment Date: <span class="float-right">{{ dateFormat($loan->repayment_date) }}</span></li>
                                    <li>Loan End Date: <span class="float-right">{{ dateFormat($loan->end_date) }}</span></li>
                                    <li>Status<span class="float-right">@if($loan->status == 2)
                                 <div class="badge badge-success">Disbursed</div>
                              @endif
                              @if($loan->status == 1)
                                 <div class="badge badge-warning">Running</div>
                              @endif
                              @if($loan->status == 0)
                              <div class="badge badge-danger">Pending</div>
                              @endif</span></li>
                                 </ul>
                              </div>
      </div>
         </div>
         
      </div>
            
         </div>
      </div>
   </div>

      <div class="tab-pane" id="officers">
      <div class="row">
         <div class="col-md-12">
            <div class="card">
               <div class="card-body">
                 <div class="clearfix mb-3">
                     <div class="float-left">
                        <h3 class="card-title">Approving Authority</h3>
                     </div>
                     <div class="float-right">
                        <button type="button" class="btn btn-sm btn-theme" data-toggle="modal" data-target="#officerModel"> <i class="fa fa-plus"></i> Assign Officer</button>
                     </div>
                     <div class="modal fade" id="officerModel" tabindex="-1">
                     <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">                          
                           <div class="modal-body">
                              <h4 class="card-title mb-4"> Loan Officer Form</h4>
                              <form action="#" method="POST" id="officer_form"> 
               @csrf
               <input type="hidden" name="loan_id" class="form-control" value="{{ $loan->id }}">
                     <div class="row">
                        <div class="col-md-12">
                           <div class="form-group">
                              <label for="role_id" class="form-label">Role</label>
                              <select class="form-control" name="role_id" id="role_id">
                                 <option value="">select role</option>
                                 @foreach($roles as $data)
                                 <option value="{{ $data->id }}">{{ $data->name }}</option>
                                 @endforeach
                              </select>
                               <span class="invalid-feedback"></span>
                           </div>
                              <div class="form-group">
                                 <label for="staff_id" class="form-label">Officer</label>
                                 <select name="staff_id" class="form-control" id="staff_id">
                                   <option value="">select staff member</option>
                                 </select>
                                 <span class="invalid-feedback"></span>
                              </div>
                        </div>
                     </div>

                  <div class="row mt-4">
                     <div class="col-md-12">
                        <div class="form-group">
                           <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
                           <button type="submit" class="btn btn-sm btn-theme" id="btn_officer">Assign Officer</button>
                        </div>
                     </div>
                  </div>

            </form>
             </div>
                                            </div>
                                        </div>
                                    </div>
                  </div>

                  @if($officers->count() > 0)
                  <div class="table-responsive">
                     <table class="table table-sm mb-0">
                        <thead>
                           <tr>
                              <th>#</th>
                              <th>Officer</th>
                              <th>Role</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           @php $i = 0; @endphp
                           @foreach($officers as $row)
                           @php $i++; @endphp
                           <tr>
                              <th scope="row">{{ $i }}</th>
                              <td>{{ $row->staff->fname}}</td>
                              <td>{{ $row->role->name }}</td>
                              <td></td>
                           </tr>
                           @endforeach
                        </tbody>
                     </table>
                  </div>
                  @else
                     <div class="d-flex flex-column align-items-center mt-5">
                        <img src="{{ asset('assets/uploads/defaults/nodata.png') }}" width="200">
                        <span class="mt-3">No Officers</span>
                     </div>
                  @endif

               </div>
            </div>
         </div>


         

     </div>
   </div>

   <div class="tab-pane" id="charges">
      <div class="row">
         <div class="col-xl-12">
            <div class="card">
               <div class="card-body">
               @if($loancharges->count() > 0)
               <h3 class="card-title">Loan Charges</h3>
               <div class="table-responsive">
                  <table class="table table-sm mb-0">
                     <thead>
                        <tr>
                           <th>#</th>
                           <th>Detail</th>
                           <th>Amount</th>
                           <th>Account No</th>
                        </tr>
                     </thead>
                     <tbody>
                        @php $i = 0; @endphp
                        @foreach($loancharges as $row)
                        @php  $i++;  @endphp
                        <tr>
                           <th scope="row">{{ $i }}</th>
                           <td>{{ $row->detail }}</td>
                           <td>
                              @if($row->status == 1)
                                 <span class="text-success">+ {!! showAmount($row->amount) !!}</span>
                              @endif

                              @if($row->status == 0)
                                 <span class="text-danger">- {!! showAmount($row->amount) !!}</span>
                              @endif
                           </td>
                           <td>@if($row->account_id != NULL) {{ $row->account->account_no }}  @else -  @endif </td>
                        <tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
               @else
                  <div class="d-flex flex-column align-items-center mt-5">
                     <img src="{{ asset('assets/uploads/defaults/nodata.png') }}" width="200">
                     <span class="mt-3">No Charges</span>
                  </div>
                  @endif
            </div>
            </div>
        </div>
     </div>
   </div>

   <div class="tab-pane" id="guarantors">
      <div class="row">
         <div class="col-md-12">
            <div class="card">
               <div class="card-body">
                 <div class="clearfix mb-3">
                     <div class="float-left">
                        <h3 class="card-title">Loan Guarantors</h3>
                     </div>
                     <div class="float-right">
                        <button type="button" class="btn btn-sm btn-theme" data-toggle="modal" data-target="#guarantorModel"> <i class="fa fa-plus"></i> Add Guarantor</button>
                     </div>
                     <div class="modal fade" id="guarantorModel" tabindex="-1">
                     <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                        <div class="modal-content">                          
                           <div class="modal-body">
                              <h4 class="card-title mb-4"> Loan Guarantor Form</h4>
                              <form action="#" method="POST" id="guarantor_form"> 
               @csrf
               <input type="hidden" name="loan_id" class="form-control" value="{{ $loan->id }}">
               <input type="hidden" name="member_id" class="form-control" value="{{ $loan->member_id }}">
                  <div class="form-group row">
                     <label for="is_member" class="col-sm-3 col-form-label">Is a Member</label>
                     <div class="col-sm-9  col-form-label">
                        <div class="custom-control custom-radio custom-control-inline">
                           <input type="radio" id="yes" name="is_member" class="custom-control-input" value="1" checked>
                            <label class="custom-control-label" for="yes">YES</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                           <input type="radio" id="no" name="is_member" class="custom-control-input" value="0">
                           <label class="custom-control-label" for="no">NO</label>
                        </div>
                     </div>
                  </div>
                  <div id="yesMember">
                     <div class="row">
                        <div class="col-md-12">
                           <div class="form-group">
                              <label for="member_id" class="form-label">Member</label>
                              <select class="form-control" name="member_id" id="member_id">
                                 <option value="">select member</option>
                                 @foreach($members as $data)
                                 @if($data->member_type == 'individual')
                                 <option value="{{ $data->id }}">{{ $data->fname }} - {{ $data->lname }}</option>
                                 @endif
                                 @if($data->member_type == 'group')
                                 <option value="{{ $data->id }}">{{ $data->fname }}</option>
                                 @endif
                                 @endforeach
                              </select>
                               <span class="invalid-feedback"></span>
                              </div>
                        </div>
                     </div>
                  </div>

                  <div  id="noMember" style="display:none;">
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group">
                              <label for="name" class="form-label">Names:</label>
                              <input type="text" name="name" id="name" class="form-control">
                              <span class="invalid-feedback"></span>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label for="email" class="form-label">Email</label>
                              <input type="email" name="email" id="email" class="form-control">
                              <span class="invalid-feedback"></span>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group">
                              <label for="telephone" class="form-label">Telephone</label>
                              <input type="text" name="telephone" id="telephone" class="form-control">
                              <span class="invalid-feedback"></span>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label for="occupation" class="form-label">Occupation</label>
                              <input type="text" name="occupation" id="occupation" class="form-control">
                              <span class="invalid-feedback"></span>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group">
                              <label for="address" class="form-label">Address</label>
                              <textarea name="address" class="form-control" id="address" rows="2"></textarea>
                              <span class="invalid-feedback"></span>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row mt-4">
                     <div class="col-md-12">
                        <div class="form-group">
                           <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
                           <button type="submit" class="btn btn-sm btn-theme" id="btn_guarantor">Add Guarantor</button>
                        </div>
                     </div>
                  </div>

            </form>
             </div>
                                            </div>
                                        </div>
                                    </div>
                  </div>

                  @if($guarantors->count() > 0)
                  <div class="table-responsive">
                     <table class="table table-sm mb-0">
                        <thead>
                           <tr>
                              <th>#</th>
                              <th>Names</th>
                              <th>Email</th>
                              <th>Telephone</th>
                              <th>Remark</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           @php $i = 0; @endphp
                           @foreach($guarantors as $row)
                           @php $i++; @endphp
                           <tr>
                              <th scope="row">{{ $i }}</th>
                              @if($row->is_member == 1)
                                 <td>
                                    @if($row->member->member_type == 'individual') {{ $row->member->title }} {{ $row->member->fname }} {{ $row->member->lname }} @endif
                                    @if($row->member->member_type == 'group') {{ $row->member->fname }} @endif
                                 </td>
                                 <td>{{ $row->member->email }}</td>
                                 <td>{{ $row->member->telephone }}</td>
                                 <td>Member</td>
                              @endif
                              @if($row->is_member == 0)
                                 <td>{{ $row->name }}</td>
                                 <td>{{ $row->email }}</td>
                                 <td>{{ $row->telephone }}</td>
                                 <td>Non Memeber</td>
                              @endif
                              <td>
                              @if($row->is_member == 1)
                              <a href="{{ route('webmaster.member.dashboard', $row->member->member_no) }}" class="btn btn-xs btn-theme"><i class="fa fa-eye"></i></a>
                              @endif
                              @if($row->is_member == 0)
                              <button type="button" class="btn btn-xs btn-theme" data-toggle="modal" data-target="#editGuarantorModel{{ $row->id }}"> <i class="far fa-edit"></i></button>

                              <div class="modal fade" id="editGuarantorModel{{ $row->id }}" tabindex="-1">
                     <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">                          
                           <div class="modal-body">
                              <h4 class="card-title mb-4"> Edit Loan Guarantor Information</h4>
                              <form action="#" method="POST" class="edit_guarantor_form"> 
                                 @csrf
                                  <input type="hidden" name="id" value="{{ $row->id }}">
                     <div class="form-group row">
                     <label for="name" class="col-sm-3 col-form-label">Names</label>
                     <div class="col-sm-9">
                        <input type="text" name="name" id="name" class="form-control" value="{{ $row->name }}">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="email" class="col-sm-3 col-form-label">Email</label>
                     <div class="col-sm-9">
                        <input type="email" name="email" id="email" class="form-control" value="{{ $row->email }}">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="telephone" class="col-sm-3 col-form-label">Telephone</label>
                     <div class="col-sm-9">
                        <input type="text" name="telephone" id="telephone" class="form-control" value="{{ $row->telephone }}">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="occupation" class="col-sm-3 col-form-label">Occupation</label>
                     <div class="col-sm-9">
                        <input type="text" name="occupation" id="occupation" class="form-control" value="{{ $row->occupation }}">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="address" class="col-sm-3 col-form-label">Address</label>
                     <div class="col-sm-9">
                        <textarea name="address" class="form-control" id="address" rows="2">{{ $row->address }}</textarea>
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
               
               <div class="form-group row">
                  <label class="col-sm-3 col-form-label"></label>
                  <div class="col-sm-9">
                     <div class="form-group">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-sm btn-theme edit_guarantor">Update Guarantor</button>
                     </div>
                  </div>
               </div>

            </form>
             </div>
                                            </div>
                                        </div>
                                    </div>

                              @endif
                              <button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#deleteGuarantorModel{{ $row->id }}"> <i class="fa fa-trash"></i></button>
                           <div class="modal fade" id="deleteGuarantorModel{{ $row->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                <div class="modal-content border-0">
                                    <div class="modal-body">
                                        <div class="alert alert-fwarning" role="alert">
                                            <i class="fa fa-exclamation-triangle d-block display-4 mt-2 mb-3 text-warning text-center"></i>
                                            <h3 class="text-center">Delete Guarantor {{ $row->name }}?</h3>
                                            <form action="#" method="POST" class="delete_guarantor_form">
                                              @csrf
                                               <input type="hidden" name="id"  value="{{ $row->id }}">
                                               <div class="form-group text-center mt-3">
                                                   <button type="button" class="btn btn-dark" data-dismiss="modal">No, Cancel</button>
                                                   <button type="submit" class="btn btn-danger delete_guarantor">Yes, Delete</button>
                                               </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                              </td>
                           <tr>
                           @endforeach
                        </tbody>
                     </table>
                  </div>
                  @else
                     <div class="d-flex flex-column align-items-center mt-5">
                        <img src="{{ asset('assets/uploads/defaults/nodata.png') }}" width="200">
                        <span class="mt-3">No Guarantors</span>
                     </div>
                  @endif

               </div>
            </div>
         </div>


         

     </div>
   </div>

   <div class="tab-pane" id="collaterals">
      <div class="row">
         <div class="col-xl-12">
            <div class="card">
               <div class="card-body">
                  <div class="clearfix mb-3">
                     <div class="float-left">
                        <h3 class="card-title">Loan Collaterals</h3>
                     </div>
                     <div class="float-right">
                        <button type="button" class="btn btn-sm btn-theme" data-toggle="modal" data-target="#collateralModel"><i class="fa fa-plus"></i> Add Collateral</button>
                     </div>
                     <div class="modal fade" id="collateralModel" tabindex="-1" role="dialog" aria-hidden="true">
                           <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                              <div class="modal-content">                          
                                 <div class="modal-body">
                                    <h4 class="card-title mb-4">Loan Collateral Information Form</h4>
                                    <form action="#" method="POST" id="collateral_form"> 
                                      @csrf
                                      <input type="hidden" name="loan_id" class="form-control" value="{{ $loan->id }}">
                                      <input type="hidden" name="loan_no" class="form-control" value="{{ $loan->loan_no }}">
                                      <input type="hidden" name="member_id" class="form-control" value="{{ $loan->member_id }}">

                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group"> 
                                       <label for="item_id">Collateral Item</label>
                                     <select class="form-control" name="item_id" id="item_id">
                                      <option value="">select item</option>
                                       @foreach($collateral_items as $data)
                                       <option value="{{ $data->id }}">{{ $data->name }}</option>
                                       @endforeach
                                    </select>
                                    <span class="invalid-feedback"></span>
                                  </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                            <label for="collateral_name">Collateral Name</label>
                                            <input type="text" name="collateral_name" id="collateral_name" class="form-control">
                                            <span class="invalid-feedback"></span>
                                        </div>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group">
                                            <label for="estimate_value">Estimate Cost Value</label>
                                            <input type="text" name="estimate_value" id="estimate_value" class="form-control">
                                            <span class="invalid-feedback"></span>
                                        </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                            <label for="remarks">Collateral Remarks</label>
                                            <input type="text" name="remarks" id="remarks" class="form-control">
                                            <span class="invalid-feedback"></span>
                                        </div>
                           </div>
                        </div>

                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group">
                  <label for="collateral_photo">Collateral Photo</label>
                     <div class="image-upload image-uploadx">
                        <div class="thumb thumbx">
                           <img alt="image" class="mr-3" id="collateral_preview" src="{{ asset('assets/uploads/defaults/author.png' )}}" width="60">
                           <div class="upload-file">
                              <input type="file" name="collateral_photo" class="form-control file-upload" id="collateral_photo">
                              <label for="collateral_photo" class="btn bg-secondary">upload photo </label>
                              <span class="invalid-feedback"></span>
                           </div>
                        </div>
                     </div>
                  
               </div>
                           </div>
                        </div>
                                        <div class="row mt-3">
                                           <div class="col-md-12">
                                              <div class="form-group">
                                           <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
                                           <button type="submit" class="btn btn-sm btn-theme" id="btn_collateral">Add Collateral</button>
                                        </div>
                                           </div>
                                        </div>
                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>




                  </div>
                  @if($collaterals->count() > 0)
                  <div class="table-responsive">
                     <table class="table table-sm mb-0">
                        <thead>
                           <tr>
                              <th>#</th>
                              <th>Item</th>
                              <th>Collateral Name</th>
                              <th>Collateral Photo</th>
                              <th>Estimate Value</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           @php $i = 0; @endphp
                           @foreach($collaterals as $row)
                           @php $i++; @endphp
                           <tr>
                              <th scope="row">{{ $i }}</th>
                              <td>{{ $row->item->name }}</td>
                              <td>{{ $row->name }}</td>
                              <td><img src="{{ asset('assets/uploads/loans/'. $row->photo ) }}" alt="" width="50"></td>
                              <td>{!! showAmount($row->estimate_value) !!}</td>
                              <td>
                              <button type="button" class="btn btn-xs btn-theme" data-toggle="modal" data-target="#editCollateralModel{{ $row->id }}"> <i class="far fa-edit"></i></button>

                              <div class="modal fade" id="editCollateralModel{{ $row->id }}" tabindex="-1">
                     <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">                          
                           <div class="modal-body">
                              <h4 class="card-title mb-4"> Edit Loan Collateral Information</h4>
                              <form action="#" method="POST" class="edit_collateral_form"> 
                                 @csrf
                                  <input type="hidden" name="id" value="{{ $row->id }}">
                     <div class="form-group"> 
                                       <label for="item_id">Collateral Item</label>
                                     <select class="form-control" name="item_id" id="item_id">
                                       @foreach($collateral_items as $data)
                                       <option  {{ $data->id == $row->item_id ? 'selected' : '' }} value="{{ $data->id }}">{{ $data->name }}</option>
                                       @endforeach
                                    </select>
                                    <span class="invalid-feedback"></span>
                                  </div>
                                        <div class="form-group">
                                            <label for="collateral_name">Collateral Name</label>
                                            <input type="text" name="collateral_name" id="collateral_name" class="form-control" value="{{ $row->name }}">
                                            <span class="invalid-feedback"></span>
                                        </div>

                                         <div class="form-group">
                  <label for="collateral_photo1">Collateral Photo</label>
                     <div class="image-upload image-uploadx">
                        <div class="thumb thumbx">
                           <img alt="image" class="mr-3 collateral_preview1" src="{{ asset('assets/uploads/loans/'. $row->photo ) }}" width="60">
                           <div class="upload-file">
                              <input type="file" name="collateral_photo" class="form-control file-upload collateral_photo1">
                              <label for="collateral_photo1" class="btn bg-secondary">upload photo </label>
                              <span class="invalid-feedback"></span>
                           </div>
                        </div>
                     </div>
                  
               </div>

                                        <div class="form-group">
                                            <label for="estimate_value">Estimate Cost Value</label>
                                            <input type="text" name="estimate_value" id="estimate_value" class="form-control" value="{{ $row->estimate_value }}">
                                            <span class="invalid-feedback"></span>
                                        </div>

                                        <div class="form-group">
                                            <label for="remarks">Collateral Remarks</label>
                                            <textarea name="remarks" class="form-control" id="remarks" rows="3">{{ $row->remarks }}</textarea>
                                            <span class="invalid-feedback"></span>
                                        </div> 
                    
               
               <div class="form-group">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-sm btn-theme edit_collateral">Update Collateral</button>
               </div>

            </form>
             </div>
                                            </div>
                                        </div>
                                    </div>

                               <button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#deleteCollateralModel{{ $row->id }}"> <i class="fa fa-trash"></i></button>
                           <div class="modal fade" id="deleteCollateralModel{{ $row->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                <div class="modal-content border-0">
                                    <div class="modal-body">
                                        <div class="alert alert-fwarning" role="alert">
                                            <i class="fa fa-exclamation-triangle d-block display-4 mt-2 mb-3 text-warning text-center"></i>
                                            <h3 class="text-center">Delete Collateral {{ $row->name }}?</h3>
                                            <form action="#" method="POST" class="delete_collateral_form">
                                              @csrf
                                               <input type="hidden" name="id"  value="{{ $row->id }}">
                                               <div class="form-group text-center mt-3">
                                                   <button type="button" class="btn btn-dark" data-dismiss="modal">No, Cancel</button>
                                                   <button type="submit" class="btn btn-danger delete_collateral">Yes, Delete</button>
                                               </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                              </td>
                           <tr>
                           @endforeach
                        </tbody>
                     </table>
                  </div>      
                  @else
                     <div class="d-flex flex-column align-items-center mt-5">
                        <img src="{{ asset('assets/uploads/defaults/nodata.png') }}" width="200">
                        <span class="mt-3">No Collaterals</span>
                     </div>
                  @endif
               </div>
            </div>
         </div>
     </div>
   </div>

   <div class="tab-pane" id="repayments">
      <div class="row">
         <div class="col-xl-12">
            <div class="card">
               <div class="card-body">
                  <div class="clearfix mb-3">
                     <div class="float-left">
                        <h3 class="card-title">Loan Repayments</h3>
                     </div>
                  </div>
                  @if($repayments->count() > 0)
                  <div class="table-responsive">
                     <table class="table table-sm mb-0">
                        <thead>
                           <tr>
                              <th>Payment Date</th>
                              <th>Loan Amount</th>
                              <th>Repaid Amount</th>
                              <th>Balance Amount</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach($repayments as $row)
                           <tr>
                              <td>{{ dateFormat($row->date) }}</td>
                              <td>{!! showAmount($row->loan_amount) !!}</td>
                              <td>{!! showAmount($row->repaid_amount) !!}</td>
                              <td>{!! showAmount($row->balance_amount) !!}</td>
                           </tr>
                           @endforeach
                        </tbody>
                     </table>
                  </div>
                  @else
                     <div class="d-flex flex-column align-items-center mt-5">
                        <img src="{{ asset('assets/uploads/defaults/nodata.png') }}" width="200">
                        <span class="mt-3">No Repayments</span>
                     </div>
                  @endif
               </div>
            </div>
        </div>
     </div>
   </div>

      <div class="tab-pane" id="penalties">
      <div class="row">
         <div class="col-xl-12">
            <div class="card">
               <div class="card-body">
                  <div class="clearfix mb-3">
                     <div class="float-left">
                        <h3 class="card-title">Loan Penalties</h3>
                     </div>
                  </div>
                  @if($repayments->count() > 0)
                  <div class="table-responsive">
                     <table class="table table-sm mb-0">
                        <thead>
                           <tr>
                              <th>Payment Date</th>
                              <th>Loan Amount</th>
                              <th>Repaid Amount</th>
                              <th>Balance Amount</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach($repayments as $row)
                           <tr>
                              <td>{{ dateFormat($row->date) }}</td>
                              <td>{!! showAmount($row->loan_amount) !!}</td>
                              <td>{!! showAmount($row->repaid_amount) !!}</td>
                              <td>{!! showAmount($row->balance_amount) !!}</td>
                           </tr>
                           @endforeach
                        </tbody>
                     </table>
                  </div>
                  @else
                     <div class="d-flex flex-column align-items-center mt-5">
                        <img src="{{ asset('assets/uploads/defaults/nodata.png') }}" width="200">
                        <span class="mt-3">No Repayments</span>
                     </div>
                  @endif
               </div>
            </div>
        </div>
     </div>
   </div>

   <div class="tab-pane" id="documents">
      <div class="mb-4">
                        <button type="button" class="btn btn-sm btn-theme" data-toggle="modal" data-target="#photoModel"> Upload Documents/ Photos</button>
                     
                     <div class="modal fade" id="photoModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                
                                                                                          
                                                <div class="modal-body">
                                                   <h3 class="card-title mb-4">Upload Loan Document/Photo</h3>
                                                    <form action="#" method="POST" id="photo_form"> 
                                      @csrf
                                       <input type="hidden" name="loan_id" class="form-control" value="{{ $loan->id }}">
                                      <input type="hidden" name="loan_no" class="form-control" value="{{ $loan->loan_no }}">
                                      <input type="hidden" name="member_id" class="form-control" value="{{ $loan->member_id }}">
                                                      
                                         <div class="form-group mb-5">
                     <div class="image-upload image-uploadx">
                        <div class="thumb thumbx">
                           <img alt="image"  class="mr-3" id="preview" src="{{ asset('assets/uploads/defaults/photo.jpg' )}}" width="200">
                           <div class="upload-file">
                              <input type="file" name="photo" class="form-control file-upload" id="photo">
                              <label for="photo" class="btn bg-secondary">upload</label>
                              <span class="invalid-feedback"></span>
                           </div>
                        </div>
                     </div>
                  </div>
                                        

                                        <div class="form-group">
                                           <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
                                           <button type="submit" class="btn btn-sm btn-theme" id="btn_photo">Upload Photo</button>
                                        </div>
                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                     </div>

                      <div class="row">
                        @if($documents->count() > 0)
                        @foreach($documents as $row)
                        <div class="col-md-4">
                            <div class="card">
                                <img class="card-img-top img-fluid" src="{{ asset('assets/uploads/loans/'. $row->photo ) }}" alt="contract photo">
                            </div>
                        </div>
                        @endforeach
                        @else
                     <div class="col-md-12">
                        <div class="d-flex flex-column align-items-center mt-5">
                        <img src="{{ asset('assets/uploads/defaults/nodata.png') }}" width="200">
                        <span class="mt-3">No Data</span>
                     </div>
                     </div>
                     @endif
                     </div>

   </div>


</div>

@endsection

@section('scripts')
   <script type="text/javascript">
      "use strict";

      $('.nav-tabs a').on('shown.bs.tab', function(event){
         var tab = $(event.target).attr("href");
         var url = "{{ route('webmaster.loan.dashboard', $loan->loan_no) }}";
          history.pushState({}, null, url + "?tab=" + tab.substring(1));
      });
      @if(isset($_GET['tab']))
         $('.nav-tabs a[href="#{{ $_GET['tab'] }}"]').tab('show');
      @endif


      $('[data-toggle="select2"]').select2();

      $('input[name="is_member"]').on('change', function() {
         let is_member = $('input[name="is_member"]:checked').val();
         if (is_member == 0) {
            $('#yesMember').hide();
            $('#noMember').show();
         } else if (is_member == 1) {
            $('#yesMember').show();
            $('#noMember').hide();
         } else {
            $('#yesMember').hide();
            $('#noMember').hide();
         } 
      });

   $("#review_form").submit(function(e) {
      e.preventDefault();
      $("#btn_review").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Submitting..');
      $("#btn_review").prop("disabled", true);
      $.ajax({
         url:'{{ route('webmaster.loan.review.update') }}',
         method: 'post',
         data: $(this).serialize(),
         dataType: 'json',
         success: function(response) {
            $("#btn_review").html('Yes, Submit');
            setTimeout(function(){
               $("#btn_review").prop("disabled", false);
               window.location.reload();
         }, 500);
         }
      });
   });

   $('#role_id').change(function() {
      var role_id = $(this).val();
      let url = `${baseurl}/webmaster/loan/getstaffs/${role_id}`;
      $.get(url, function(response){
         $("#staff_id").html(response);
      });
   });

   $("#officer_form").submit(function(e) {
      e.preventDefault();
      $("btn_officer").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Assigning');
      $("#btn_officer").prop("disabled", true);
      $.ajax({
         url:'{{ route('webmaster.loan.staff.assign') }}',
         method: 'post',
         data: $(this).serialize(),
         dataType: 'json',
         success: function(response){
            if(response.status == 400){
              $.each(response.message, function (key, value) {
                showError(key, value);
              });
              $("#btn_officer").html('Assign Officer');
              $("#btn_officer").prop("disabled", false);
            } else if(response.status == 200){
               $("#officer_form")[0].reset();
              removeErrors("#officer_form");
              $("#btn_officer").html('Assign Officer');
              setTimeout(function(){
                window.location.reload();
              }, 500);

            }
          }
        });
      });

      $("#payment_form").submit(function(e) {
         e.preventDefault();
         $("#btn_payment").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Paying');
         $("#btn_payment").prop("disabled", true);
         $.ajax({
            url:'{{ route('webmaster.loan.repayment.store') }}',
            method: 'post',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response){
               if(response.status == 400){
                  $.each(response.message, function (key, value) {
                     showError(key, value);
                  });
                  $("#btn_payment").html('Add Payments');
                  $("#btn_payment").prop("disabled", false);
               } else if(response.status == 200){
                  $("#payment_form")[0].reset();
                  removeErrors("#payment_form");
                  $("#btn_payment").html('Add Payments');
                  $("#btn_payment").prop("disabled", false);
                  setTimeout(function(){
                     window.location.reload();
                  }, 500);
               }
             }
           });
         });

   previewImage("collateral_photo", "collateral_preview");
    $("#collateral_form").submit(function(e) {
        e.preventDefault();
        $("#btn_collateral").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding');
        $("#btn_collateral").prop("disabled", true);
        var formData = new FormData(this);
        $.ajax({
            url:'{{ route('webmaster.loan.collateral.store') }}',
            method: 'post',
            data: formData, 
            processData: false,
            contentType: false,
            dataType: 'json',
          success: function(response){
            if(response.status == 400){
              $.each(response.message, function (key, value) {
                showError(key, value);
              });
              $("#btn_collateral").html('Add Collateral');
              $("#btn_collateral").prop("disabled", false);
            } else if(response.status == 200){
               $("#collateral_form")[0].reset();
              removeErrors("#collateral_form");
              $("#btn_collateral").html('Add Collateral');
              $("#btn_collateral").prop("disabled", false);
              setTimeout(function(){
                window.location.reload();
              }, 500);

            }
          }
        });
      });

    $(".edit_collateral_form").submit(function(e) {
        e.preventDefault();
        $(".edit_collateral").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Updating');
        $(".edit_collateral").prop("disabled", true);
        var formData = new FormData(this);
        $.ajax({
            url:'{{ route('webmaster.loan.collateral.update') }}',
            method: 'post',
            data: formData, 
            processData: false,
            contentType: false,
            dataType: 'json',
          success: function(response){
            if(response.status == 400){
              $.each(response.message, function (key, value) {
                showError(key, value);
              });
              $(".edit_collateral").html('Update Collateral');
              $(".edit_collateral").prop("disabled", false);
            } else if(response.status == 200){
               //$("#edit_collateral_form")[0].reset();
              removeErrors("#edit_collateral_form");
              $(".edit_collateral").html('Update Collateral');
              $(".edit_collateral").prop("disabled", false);
              setTimeout(function(){
                window.location.reload();
              }, 500);

            }
          }
        });
      });

    $(".delete_collateral_form").submit(function(e) {
        e.preventDefault();
        $(".delete_collateral").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Deleting..');
        $(".delete_collateral").prop("disabled", true);
        $.ajax({
          url:'{{ route('webmaster.loan.collateral.delete') }}',
          method: 'post',
          data: $(this).serialize(),
          dataType: 'json',
          success: function(response) {
            $(".delete_collateral").html('Yes, Delete');
            setTimeout(function(){
               $(".delete_collateral").prop("disabled", false);
               window.location.reload();
            }, 500);
          }
        });
      });

    $("#guarantor_form").submit(function(e) {
      e.preventDefault();
      $("#btn_guarantor").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding');
      $("#btn_guarantor").prop("disabled", true);
      $.ajax({
         url:'{{ route('webmaster.loan.guarantor.store') }}',
         method: 'post',
         data: $(this).serialize(),
         dataType: 'json',
         success: function(response){
            if(response.status == 400){
               $.each(response.message, function (key, value) {
                  showError(key, value);
               });
              $("#btn_guarantor").html('Add Guarantor');
              $("#btn_guarantor").prop("disabled", false);
            } else if(response.status == 200){
               removeErrors("#guarantor_form");
               $("#guarantor_form")[0].reset();
               $("#btn_guarantor").html('Add Guarantor');
                  setTimeout(function(){
                  $("#btn_guarantor").prop("disabled", false);
                  window.location.reload();
              }, 500);
            }
          }
        });
      });

      $(".edit_guarantor_form").submit(function(e) {
      e.preventDefault();
      $(".edit_guarantor").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Updating');
      $(".edit_guarantor").prop("disabled", true);
      $.ajax({
         url:'{{ route('webmaster.loan.guarantor.update') }}',
         method: 'post',
         data: $(this).serialize(),
         dataType: 'json',
         success: function(response){
            if(response.status == 400){
               $.each(response.message, function (key, value) {
                  showError(key, value);
               });
              $(".edit_guarantor").html('Update Guarantor');
              $(".edit_guarantor").prop("disabled", false);
            } else if(response.status == 200){
               removeErrors(".edit_guarantor_form");
               //$(".edit_guarantor_form")[0].reset();
               $(".edit_guarantor").html('Update Guarantor');
                  setTimeout(function(){
                  $(".edit_guarantor").prop("disabled", false);
                  window.location.reload();
              }, 500);
            }
          }
        });
      });

      $(".delete_guarantor_form").submit(function(e) {
        e.preventDefault();
        $(".delete_guarantor").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Deleting..');
        $(".delete_guarantor").prop("disabled", true);
        $.ajax({
          url:'{{ route('webmaster.loan.guarantor.delete') }}',
          method: 'post',
          data: $(this).serialize(),
          dataType: 'json',
          success: function(response) {
            $(".delete_guarantor").html('Yes, Delete');
            setTimeout(function(){
               $(".delete_guarantor").prop("disabled", false);
               window.location.reload();
            }, 500);
          }
        });
      });


    $("#expense_form").submit(function(e) {
      e.preventDefault();
      $("#btn_expense").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding');
      $("#btn_expense").prop("disabled", true);
      $.ajax({
         url:'{{ route('webmaster.loan.expense.store') }}',
         method: 'post',
         data: $(this).serialize(),
         dataType: 'json',
         success: function(response){
            if(response.status == 400){
               $.each(response.message, function (key, value) {
                  showError(key, value);
               });
              $("#btn_expense").html('Add Expense');
              $("#btn_expense").prop("disabled", false);
            } else if(response.status == 200){
               removeErrors("#expense_form");
               $("#expense_form")[0].reset();
               $("#btn_expense").html('Add Expense');
                  setTimeout(function(){
                  $("#btn_expense").prop("disabled", false);
                  window.location.reload();
              }, 500);
            }
          }
        });
      });

      $(".edit_expense_form").submit(function(e) {
      e.preventDefault();
      $(".edit_expense").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Updating');
      $("#edit_expense").prop("disabled", true);
      $.ajax({
         url:'{{ route('webmaster.loan.expense.update') }}',
         method: 'post',
         data: $(this).serialize(),
         dataType: 'json',
         success: function(response){
            if(response.status == 400){
               $.each(response.message, function (key, value) {
                  showError(key, value);
               });
              $("#edit_expense").html('Update Expense');
              $("#edit_expense").prop("disabled", false);
            } else if(response.status == 200){
               removeErrors("#edit_expense_form");
               //$("#edit_expense_form")[0].reset();
               $("#edit_expense").html('Update Expense');
                  setTimeout(function(){
                  $("#edit_expense").prop("disabled", false);
                  window.location.reload();
              }, 500);
            }
          }
        });
      });


      $(".delete_expense_form").submit(function(e) {
        e.preventDefault();
        $(".delete_expense").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Deleting..');
        $(".delete_expense").prop("disabled", true);
        $.ajax({
          url:'{{ route('webmaster.loan.expense.delete') }}',
          method: 'post',
          data: $(this).serialize(),
          dataType: 'json',
          success: function(response) {
            $(".delete_expense").html('Yes, Delete');
            setTimeout(function(){
               $(".delete_expense").prop("disabled", false);
               window.location.reload();
            }, 500);
          }
        });
      });

   previewImage("photo", "preview");
   $("#photo_form").submit(function(e) {
      e.preventDefault();
      $("#btn_photo").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Uploading');
      $("#btn_photo").prop("disabled", true);
      var formData = new FormData(this);
      $.ajax({
         url:'{{ route('webmaster.loan.document.store') }}',
         method: 'post',
         data: formData, 
         processData: false,
         contentType: false,
         dataType: 'json',
         success: function(response){
            if(response.status == 400){
               $.each(response.message, function (key, value) {
                  showError(key, value);
               });
              $("#btn_photo").html('Upload Photo');
              $("#btn_photo").prop("disabled", false);
            } else if(response.status == 200){
               removeErrors("#photo_form");
               $("#btn_photo").html('Upload Photo');
                  setTimeout(function(){
                  $("#btn_photo").prop("disabled", false);
                  window.location.reload();
              }, 500);
            }
          }
        });
      });

   </script>
@endsection
