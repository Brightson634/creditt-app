@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection
@section('content')
    <div class="page-heading">
        <div class="az-dashboard-nav">
            <nav class="nav">
                <a class="nav-link active" data-toggle="tab" href="#overview">Overview</a>
                <a class="nav-link" data-toggle="tab" href="#guarantors" role="tab" aria-controls="guarantors"
                    aria-selected="false">Guarantors</a>
                <a class="nav-link" data-toggle="tab" href="#collaterals" role="tab" aria-controls="collaterals"
                    aria-selected="false">Collaterals</a>
                <a class="nav-link" data-toggle="tab"href="#repayments" role="tab" aria-controls="repayments"
                    aria-selected="false">Repayments</a>
                <a class="nav-link" data-toggle="tab" href="#repaymentschedule" role='tab'
                    aria-controls="repaymentschedule" aria-selected="false">Repayment Schedule</a>
                <a class="nav-link" data-toggle="tab" href="#documents" role='tab' aria-controls="documents"
                    aria-selected="false">Documents</a>
            </nav>
            <a class=" btn btn-indigo btn-sm float-right" href="{{ route('webmaster.loan.create') }}">New Loan</a>
        </div>
        <div class="az-content-header d-block d-md-flex">
            <div>
                <h2 class="az-content-title tx-24 mg-b-5 mg-b-lg-8">Hi, welcome back!</h2>
                {{-- <p class="mg-b-0">Your sales monitoring dashboard template.</p> --}}
            </div>
            <div class="az-dashboard-header-right">
                <div>
                    <label class="tx-13">Customer Ratings</label>
                    <div class="az-star">
                        <i class="typcn typcn-star active"></i>
                        <i class="typcn typcn-star active"></i>
                        <i class="typcn typcn-star active"></i>
                        <i class="typcn typcn-star active"></i>
                        <i class="typcn typcn-star"></i>
                        <span>(12,775)</span>
                    </div>
                </div>
                <div>
                    <label class="tx-13">Transactions (Online)</label>
                    <h5>0</h5>
                </div>
                <div>
                    <label class="tx-13">Transactions (Offline)</label>
                    <h5>0</h5>
                </div>
            </div><!-- az-dashboard-header-right -->
        </div><!-- az-content-header -->
    </div>
    <!-- Tab content -->
    <div class="tab-content" id="myTabContent">
        <!--over view-->
        <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
            <div class="az-content-body">
                <div class="card card-dashboard-seven" style="border-radius: 12px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">
                    <div class="card-header" style="background-color: #f8f9fa; border-bottom: none; border-radius: 12px 12px 0 0;">
                        <div class="row row-sm">
                            <div class="col-6 col-md-4 col-xl">
                                <div class="media">
                                    <div><i class="icon ion-ios-calendar"></i></div>
                                    <div class="media-body">
                                        <label>Loan Application Date</label>
                                        <div class="date">
                                            <span>{{ shortendDateFormat($loan->created_at) }}</span> 
                                            <a href="#"><i class="icon ion-md-arrow-dropdown"></i></a>
                                        </div>
                                    </div>
                                </div><!-- media -->
                            </div>
                            <div class="col-6 col-md-4 col-xl">
                                <div class="media">
                                    <div><i class="icon ion-ios-calendar"></i></div>
                                    <div class="media-body">
                                        <label>Loan Disbursement Date</label>
                                        <div class="date">
                                            <span>{{ shortendDateFormat($loan->disbursement_date) }}</span> 
                                            <a href="#"><i class="icon ion-md-arrow-dropdown"></i></a>
                                        </div>
                                    </div>
                                </div><!-- media -->
                            </div>
                            <div class="col-6 col-md-4 col-xl">
                                <div class="media">
                                    <div><i class="icon ion-ios-calendar"></i></div>
                                    <div class="media-body">
                                        <label>Loan End Date</label>
                                        <div class="date">
                                            <span>{{ shortendDateFormat($loan->end_date) }}</span> 
                                            <a href="#"><i class="icon ion-md-arrow-dropdown"></i></a>
                                        </div>
                                    </div>
                                </div><!-- media -->
                            </div>
                            <div class="col-6 col-md-4 col-xl mg-t-15 mg-xl-t-0">
                                <div class="media">
                                    <div><i class="icon ion-md-person"></i></div>
                                    <div class="media-body">
                                        <label>Loan Type</label>
                                        <div class="date">
                                            <span>{{ ucwords($loan->loan_type) }}</span> 
                                            <a href="#"><i class="icon ion-md-arrow-dropdown"></i></a>
                                        </div>
                                    </div>
                                </div><!-- media -->
                            </div>
                            <div class="col-md-4 col-xl mg-t-15 mg-xl-t-0">
                                <div class="media">
                                    <div><i class="icon ion-md-stats"></i></div>
                                    <div class="media-body">
                                        <label>Loan Number</label>
                                        <div class="date">
                                            <span>{{ $loan->loan_no }}</span> 
                                            <a href="#"><i class="icon ion-md-arrow-dropdown"></i></a>
                                        </div>
                                    </div>
                                </div><!-- media -->
                            </div>
                        </div><!-- row -->
                    </div><!-- card-header -->
                    <div class="card-body" style="border-radius: 0 0 12px 12px;">
                        <div class="row row-sm">
                            <div class="col-6 col-lg-3">
                                <label class="az-content-label">Principal Amount</label>
                                <h2><span>{{ $gs->currency_symbol }}</span>{!! isset($loan->principal_amount) ? formattedAmount($loan->principal_amount) : 0 !!}</h2>
                                <div class="desc up">
                                    <i class="icon ion-md-stats"></i>
                                    <span><strong>12.09%</strong> (30 days)</span>
                                </div>
                            </div><!-- col -->
                            <div class="col-6 col-lg-3">
                                <label class="az-content-label">Interest Amount</label>
                                <h2><span>{{ $gs->currency_symbol }}</span>{!! isset($loan->interest_amount) ? formattedAmount($loan->interest_amount) : 0 !!}</h2>
                                <div class="desc up">
                                    <i class="icon ion-md-stats"></i>
                                    <span><strong>12.09%</strong> (30 days)</span>
                                </div>
                            </div><!-- col -->
                            <div class="col-6 col-lg-3 mg-t-20 mg-lg-t-0">
                                <label class="az-content-label">Repayment Amount</label>
                                <h2><span>{{ $gs->currency_symbol }}</span>{!! isset($loan->repayment_amount) ? formattedAmount($loan->repayment_amount) : 0 !!}</h2>
                                <div class="desc down">
                                    <i class="icon ion-md-stats"></i>
                                    <span><strong>0.51%</strong> (30 days)</span>
                                </div>
                            </div><!-- col -->
                            <div class="col-6 col-lg-3 mg-t-20 mg-lg-t-0">
                                <label class="az-content-label">Repaid Amount</label>
                                <h2><span>{{ $gs->currency_symbol }}</span>{!! isset($loan->repaid_amount) ? formattedAmount($loan->repaid_amount) : 0 !!}</h2>
                                <div class="desc up">
                                    <i class="icon ion-md-stats"></i>
                                    @php
                                    $collectedPercentage = $loan->repaid_amount != 0
                                        ? round(($loan->repaid_amount / $loan->loan_amount) * 100, 2)
                                        : 0;
                                @endphp
                                    <span><strong>{{ $collectedPercentage }}%</strong> (Paid)</span>
                                </div>
                            </div><!-- col -->
                        </div><!-- row -->
                    </div><!-- card-body -->
                </div><!-- card -->
            </div><!-- az-content-body -->
            <!--dummy review-->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="clearfix">
                                <div class="float-left">
                                    <h4 class="card-title">Statistics Overview</h4>
                                </div>
                                <div class="float-right">
                                    <span class="btn btn-xs btn-secondary">Loan Status:
                                        @if ($loan->status == 0)
                                            SUBMITTED
                                        @endif
                                        @if ($loan->status == 1)
                                            UNDER REVIEW
                                        @endif
                                        @if ($loan->status == 2)
                                            REVIEWED
                                        @endif
                                        @if ($loan->status == 3)
                                            APPROVED
                                        @endif
                                        @if ($loan->status == 4)
                                            REJECTED
                                        @endif
                                        @if ($loan->status == 5)
                                            Disbursed
                                        @endif
                                    </span>
                                    @if ($loan->status == 0)
                                        <button type="button" class="btn btn-xs btn-info mr-1" data-toggle="modal"
                                            data-target="#reviewModel"> <i class="fa fa-arrow-right"></i> Send For
                                            Review </button>
                                        <div class="modal fade" id="reviewModel" tabindex="-1" role="dialog"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-sm modal-dialog-centered"
                                                role="document">
                                                <div class="modal-content border-0">
                                                    <div class="modal-body">
                                                        <div class="alert alert-fwarning" role="alert">
                                                            <i
                                                                class="fa fa-exclamation-triangle d-block display-4 mt-2 mb-3 text-warning text-center"></i>
                                                            <h5 class="text-center">Are you sure you want to submit
                                                                the loan <strong>#{{ $loan->loan_no }}</strong> for
                                                                Review?</h5>
                                                            <form action="#" method="POST" id="review_form">
                                                                @csrf
                                                                <input type="hidden" name="id"
                                                                    class="form-control"
                                                                    value="{{ $loan->id }}">
                                                                <div class="form-group text-center mt-3">
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-dark"
                                                                        data-dismiss="modal">No, Cancel</button>
                                                                    <button type="submit"
                                                                        class="btn btn-sm btn-success"
                                                                        id="btn_review">Yes, Submit</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($loan->status == 2)
                                        <button type="button" class="btn btn-xs btn-info mr-1"
                                            data-toggle="modal" data-target="#approveModel"> <i
                                                class="fa fa-plus"></i> Approve </button>
                                        <div class="modal fade" id="approveModel" tabindex="-1" role="dialog"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-sm modal-dialog-centered"
                                                role="document">
                                                <div class="modal-content border-0">
                                                    <div class="modal-body">
                                                        <div class="alert alert-fwarning" role="alert">
                                                            <i
                                                                class="fa fa-exclamation-triangle d-block display-4 mt-2 mb-3 text-warning text-center"></i>
                                                            <h5 class="text-center">Are you sure you want to
                                                                approve this loan?</h5>
                                                            <form action="#" method="POST"
                                                                id="approve_form">
                                                                @csrf
                                                                <input type="hidden" name="loan_id"
                                                                    class="form-control"
                                                                    value="{{ $loan->id }}">
                                                                <div class="form-group text-center mt-3">
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-dark"
                                                                        data-dismiss="modal">No, Cancel</button>
                                                                    <button type="submit"
                                                                        class="btn btn-sm btn-success"
                                                                        id="btn_payment">Yes, Approve</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="button" class="btn btn-xs btn-danger mr-1"
                                            data-toggle="modal" data-target="#rejectModel"> <i
                                                class="fa fa-trash"></i> Reject </button>
                                        <div class="modal fade" id="rejectModel" tabindex="-1" role="dialog"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-sm modal-dialog-centered"
                                                role="document">
                                                <div class="modal-content border-0">
                                                    <div class="modal-body">
                                                        <div class="alert alert-fwarning" role="alert">
                                                            <i
                                                                class="fa fa-exclamation-triangle d-block display-4 mt-2 mb-3 text-warning text-center"></i>
                                                            <h5 class="text-center">Are you sure you want to reject
                                                                this loan?</h5>
                                                            <form action="#" method="POST" id="reject_form">
                                                                @csrf
                                                                <div class="form-group text-center mt-3">
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-dark"
                                                                        data-dismiss="modal">No, Cancel</button>
                                                                    <button type="submit"
                                                                        class="btn btn-sm btn-danger"
                                                                        id="btn_payment">Yes, Reject</button>
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
                                  <input type="hidden" name="loan_id" class="form-control" value="{{ $loan->id }}">
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
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- Loan Amount Distribution -->
                <div class="col-md-4">
                    <div class="card mb-4" style="border-radius: 10px; border: none; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
                        <div class="card-header" style="background-color: #f8f9fa; color: #333; font-weight: 600; border-radius: 10px 10px 0 0; border-bottom: none;">
                            Loan Amount Distribution
                        </div>
                        <div class="card-body">
                            <div id="loanAmountDistribution"></div>
                        </div>
                    </div>
                </div>
            
                <!-- Loan Data Summary -->
                <div class="col-md-4">
                    <div class="card mb-4" style="border-radius: 10px; border: none; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
                        <div class="card-header" style="background-color: #f8f9fa; color: #333; font-weight: 600; border-radius: 10px 10px 0 0; border-bottom: none;">
                            Loan Data Summary
                        </div>
                        <div class="card-body">
                            <div id="loanInfo"></div>
                        </div>
                    </div>
                </div>
            
                <!-- Loan Overview -->
                <div class="col-md-4">
                    <div class="card mb-4" style="border-radius: 10px; border: none; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
                        <div class="card-header" style="background-color: #f8f9fa; color: #333; font-weight: 600; border-radius: 10px 10px 0 0; border-bottom: none;">
                            Loan Overview
                        </div>
                        <div class="card-body">
                            <label class="text-gray-600">Information Overview</label>
                            <p class="invoice-info-row"><span>Loan ID:</span><span>{{ $loan->loan_no }}</span></p>
                            <p class="invoice-info-row">
                                <span>Member:</span><span>{{ ucwords(strtolower($loan->member->fname)) }}</span>
                            </p>
                            <p class="invoice-info-row"><span>Loan Product:</span><span>{{ $loan->loanproduct->name }}</span></p>
                            <p class="invoice-info-row"><span>Interest Rate:</span>
                                <span>{{ $loan->loanproduct->interest_rate }}% per {{ ucfirst($loan->loanproduct->duration) }}</span>
                            </p>
                            <p class="invoice-info-row"><span>Loan Period:</span>
                                <span>{{ $loan->loan_period }}
                                    @if ($loan->loanproduct->duration == 'day')
                                        Days
                                    @elseif ($loan->loanproduct->duration == 'week')
                                        Weeks
                                    @elseif ($loan->loanproduct->duration == 'month')
                                        Months
                                    @endif
                                </span>
                            </p>
                            <p class="invoice-info-row"><span>Release Date:</span><span>{{ dateFormat($loan->release_date) }}</span></p>
                            <p class="invoice-info-row"><span>Repayment Date:</span><span>{{ dateFormat($loan->repayment_date) }}</span></p>
                            <p class="invoice-info-row"><span>Loan End Date:</span><span>{{ dateFormat($loan->end_date) }}</span></p>
                            <p class="invoice-info-row"><span>Loan Status:</span>
                                @if ($loan->status == 2)
                                    <span class="badge badge-success">Disbursed</span>
                                @elseif ($loan->status == 1)
                                    <span class="badge badge-warning">Running</span>
                                @elseif ($loan->status == 0)
                                    <span class="badge badge-danger">Pending</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <!--guarantors-->
        <div class="tab-pane fade" id="guarantors" role="tabpanel" aria-labelledby="guarantors-tab">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="modal fade" id="guarantorModel" tabindex="-1">
                                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <h4 class="card-title mb-4"> Loan Guarantor Form</h4>
                                            <form action="#" method="POST" id="guarantor_form">
                                                @csrf
                                                <input type="hidden" name="loan_id" class="form-control"
                                                    value="{{ $loan->id }}">
                                                <input type="hidden" name="member_id" class="form-control"
                                                    value="{{ $loan->member_id }}">
                                                <div class="form-group row">
                                                    <label for="is_member" class="col-sm-3 col-form-label">Is a
                                                        Member</label>
                                                    <div class="col-sm-9  col-form-label">
                                                        <div class="custom-control custom-radio custom-control-inline">
                                                            <input type="radio" id="yes" name="is_member"
                                                                class="custom-control-input" value="1" checked>
                                                            <label class="custom-control-label" for="yes">YES</label>
                                                        </div>
                                                        <div class="custom-control custom-radio custom-control-inline">
                                                            <input type="radio" id="no" name="is_member"
                                                                class="custom-control-input" value="0">
                                                            <label class="custom-control-label" for="no">NO</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="yesMember">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="member_id" class="form-label">Member</label>
                                                                <select class="form-control" name="member_id"
                                                                    id="member_id">
                                                                    <option value="">select member</option>
                                                                    @foreach ($members as $data)
                                                                        @if ($data->member_type == 'individual')
                                                                            <option value="{{ $data->id }}">
                                                                                {{ $data->fname }} -
                                                                                {{ $data->lname }}</option>
                                                                        @endif
                                                                        @if ($data->member_type == 'group')
                                                                            <option value="{{ $data->id }}">
                                                                                {{ $data->fname }}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                                <span class="invalid-feedback"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="noMember" style="display:none;">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="name" class="form-label">Names:</label>
                                                                <input type="text" name="name" id="name"
                                                                    class="form-control">
                                                                <span class="invalid-feedback"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="email" class="form-label">Email</label>
                                                                <input type="email" name="email" id="email"
                                                                    class="form-control">
                                                                <span class="invalid-feedback"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="telephone"
                                                                    class="form-label">Telephone</label>
                                                                <input type="text" name="telephone" id="telephone"
                                                                    class="form-control">
                                                                <span class="invalid-feedback"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="occupation"
                                                                    class="form-label">Occupation</label>
                                                                <input type="text" name="occupation" id="occupation"
                                                                    class="form-control">
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
                                                            <button type="button" class="btn btn-sm btn-secondary"
                                                                data-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-sm btn-theme"
                                                                id="btn_guarantor">Add Guarantor</button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-dashboard-table-six">
                                <h6 class="card-title">Loan Guarantors <div class="float-right">
                                        <button type="button" class="btn btn-dark btn-sm btn-theme" data-toggle="modal"
                                            data-target="#guarantorModel"> <i class="fa fa-plus"></i> Add
                                            Guarantor</button>
                                    </div>
                                </h6>
                                @if ($guarantors->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-striped">
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
                                                @foreach ($guarantors as $row)
                                                    @php $i++; @endphp
                                                    <tr>
                                                        <th scope="row">{{ $i }}</th>
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
                                                            <td>Member</td>
                                                        @endif
                                                        @if ($row->is_member == 0)
                                                            <td>{{ $row->name }}</td>
                                                            <td>{{ $row->email }}</td>
                                                            <td>{{ $row->telephone }}</td>
                                                            <td>Non Memeber</td>
                                                        @endif
                                                        <td>
                                                            @if ($row->is_member == 1)
                                                                <a href="{{ route('webmaster.member.dashboard', $row->member->member_no) }}"
                                                                    class="btn btn-xs btn-theme"><i
                                                                        class="fa fa-eye"></i></a>
                                                            @endif
                                                            @if ($row->is_member == 0)
                                                                <button type="button" class="btn btn-xs btn-theme"
                                                                    data-toggle="modal"
                                                                    data-target="#editGuarantorModel{{ $row->id }}">
                                                                    <i class="far fa-edit"></i></button>

                                                                <div class="modal fade"
                                                                    id="editGuarantorModel{{ $row->id }}"
                                                                    tabindex="-1">
                                                                    <div class="modal-dialog modal-dialog-centered"
                                                                        role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-body">
                                                                                <h4 class="card-title mb-4"> Edit Loan
                                                                                    Guarantor Information</h4>
                                                                                <form action="#" method="POST"
                                                                                    class="edit_guarantor_form">
                                                                                    @csrf
                                                                                    <input type="hidden" name="id"
                                                                                        value="{{ $row->id }}">
                                                                                    <div class="form-group row">
                                                                                        <label for="name"
                                                                                            class="col-sm-3 col-form-label">Names</label>
                                                                                        <div class="col-sm-9">
                                                                                            <input type="text"
                                                                                                name="name"
                                                                                                id="name"
                                                                                                class="form-control"
                                                                                                value="{{ $row->name }}">
                                                                                            <span
                                                                                                class="invalid-feedback"></span>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group row">
                                                                                        <label for="email"
                                                                                            class="col-sm-3 col-form-label">Email</label>
                                                                                        <div class="col-sm-9">
                                                                                            <input type="email"
                                                                                                name="email"
                                                                                                id="email"
                                                                                                class="form-control"
                                                                                                value="{{ $row->email }}">
                                                                                            <span
                                                                                                class="invalid-feedback"></span>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group row">
                                                                                        <label for="telephone"
                                                                                            class="col-sm-3 col-form-label">Telephone</label>
                                                                                        <div class="col-sm-9">
                                                                                            <input type="text"
                                                                                                name="telephone"
                                                                                                id="telephone"
                                                                                                class="form-control"
                                                                                                value="{{ $row->telephone }}">
                                                                                            <span
                                                                                                class="invalid-feedback"></span>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group row">
                                                                                        <label for="occupation"
                                                                                            class="col-sm-3 col-form-label">Occupation</label>
                                                                                        <div class="col-sm-9">
                                                                                            <input type="text"
                                                                                                name="occupation"
                                                                                                id="occupation"
                                                                                                class="form-control"
                                                                                                value="{{ $row->occupation }}">
                                                                                            <span
                                                                                                class="invalid-feedback"></span>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group row">
                                                                                        <label for="address"
                                                                                            class="col-sm-3 col-form-label">Address</label>
                                                                                        <div class="col-sm-9">
                                                                                            <textarea name="address" class="form-control" id="address" rows="2">{{ $row->address }}</textarea>
                                                                                            <span
                                                                                                class="invalid-feedback"></span>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="form-group row">
                                                                                        <label
                                                                                            class="col-sm-3 col-form-label"></label>
                                                                                        <div class="col-sm-9">
                                                                                            <div class="form-group">
                                                                                                <button type="button"
                                                                                                    class="btn btn-sm btn-secondary"
                                                                                                    data-dismiss="modal">Cancel</button>
                                                                                                <button type="submit"
                                                                                                    class="btn btn-sm btn-theme edit_guarantor">Update
                                                                                                    Guarantor</button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            <button type="button" class="btn btn-xs btn-danger"
                                                                data-toggle="modal"
                                                                data-target="#deleteGuarantorModel{{ $row->id }}"> <i
                                                                    class="fa fa-trash"></i></button>
                                                            <div class="modal fade"
                                                                id="deleteGuarantorModel{{ $row->id }}"
                                                                tabindex="-1" role="dialog" aria-hidden="true">
                                                                <div class="modal-dialog modal-sm modal-dialog-centered"
                                                                    role="document">
                                                                    <div class="modal-content border-0">
                                                                        <div class="modal-body">
                                                                            <div class="alert alert-fwarning"
                                                                                role="alert">
                                                                                <i
                                                                                    class="fa fa-exclamation-triangle d-block display-4 mt-2 mb-3 text-warning text-center"></i>
                                                                                <h3 class="text-center">Delete Guarantor
                                                                                    {{ $row->name }}?</h3>
                                                                                <form action="#" method="POST"
                                                                                    class="delete_guarantor_form">
                                                                                    @csrf
                                                                                    <input type="hidden" name="id"
                                                                                        value="{{ $row->id }}">
                                                                                    <div
                                                                                        class="form-group text-center mt-3">
                                                                                        <button type="button"
                                                                                            class="btn btn-dark"
                                                                                            data-dismiss="modal">No,
                                                                                            Cancel</button>
                                                                                        <button type="submit"
                                                                                            class="btn btn-danger delete_guarantor">Yes,
                                                                                            Delete</button>
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
        </div>
        <!--collaterals-->
        <div class="tab-pane fade" id="collaterals" role="tabpanel" aria-labelledby="collaterals-tab">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="modal fade" id="collateralModel" tabindex="-1" role="dialog"
                                aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <h4 class="card-title mb-4">Loan Collateral Information Form</h4>
                                            <form action="#" method="POST" id="collateral_form">
                                                @csrf
                                                <input type="hidden" name="loan_id" class="form-control"
                                                    value="{{ $loan->id }}">
                                                <input type="hidden" name="loan_no" class="form-control"
                                                    value="{{ $loan->loan_no }}">
                                                <input type="hidden" name="member_id" class="form-control"
                                                    value="{{ $loan->member_id }}">

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="item_id">Collateral Item</label>
                                                            <select class="form-control" name="item_id" id="item_id">
                                                                <option value="">select item</option>
                                                                @foreach ($collateral_items as $data)
                                                                    <option value="{{ $data->id }}">
                                                                        {{ $data->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            <span class="invalid-feedback"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="collateral_name">Collateral Name</label>
                                                            <input type="text" name="collateral_name"
                                                                id="collateral_name" class="form-control">
                                                            <span class="invalid-feedback"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="estimate_value">Estimate Cost Value</label>
                                                            <input type="text" name="estimate_value"
                                                                id="estimate_value" class="form-control">
                                                            <span class="invalid-feedback"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="remarks">Collateral Remarks</label>
                                                            <input type="text" name="remarks" id="remarks"
                                                                class="form-control">
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
                                                                    <img alt="image" class="mr-3"
                                                                        id="collateral_preview"
                                                                        src="{{ asset('assets/uploads/defaults/author.png') }}"
                                                                        width="60">
                                                                    <div class="upload-file">
                                                                        <input type="file" name="collateral_photo"
                                                                            class="form-control file-upload"
                                                                            id="collateral_photo">
                                                                        <label for="collateral_photo"
                                                                            class="btn bg-secondary">upload photo
                                                                        </label>
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
                                                            <button type="button" class="btn btn-sm btn-secondary"
                                                                data-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-sm btn-theme"
                                                                id="btn_collateral">Add Collateral</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-dashboard-table-six">
                                <h6 class="card-title">Loan Collaterals <div class="float-right">
                                        <button type="button" class="btn btn-dark btn-sm btn-theme" data-toggle="modal"
                                            data-target="#collateralModel"><i class="fa fa-plus"></i> Add
                                            Collateral</button>
                                    </div>
                                </h6>
                                @if ($collaterals->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-striped">
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
                                                @foreach ($collaterals as $row)
                                                    @php $i++; @endphp
                                                    <tr>
                                                        <th scope="row">{{ $i }}</th>
                                                        <td>{{ $row->item->name }}</td>
                                                        <td>{{ $row->name }}</td>
                                                        <td><img src="{{ asset('assets/uploads/loans/' . $row->photo) }}"
                                                                alt="" width="50"></td>
                                                        <td>{!! showAmount($row->estimate_value) !!}</td>
                                                        <td>
                                                            <button type="button" class="btn btn-xs btn-theme"
                                                                data-toggle="modal"
                                                                data-target="#editCollateralModel{{ $row->id }}"> <i
                                                                    class="far fa-edit"></i></button>

                                                            <div class="modal fade"
                                                                id="editCollateralModel{{ $row->id }}"
                                                                tabindex="-1">
                                                                <div class="modal-dialog modal-dialog-centered"
                                                                    role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-body">
                                                                            <h4 class="card-title mb-4"> Edit Loan
                                                                                Collateral
                                                                                Information</h4>
                                                                            <form action="#" method="POST"
                                                                                class="edit_collateral_form">
                                                                                @csrf
                                                                                <input type="hidden" name="id"
                                                                                    value="{{ $row->id }}">
                                                                                <div class="form-group">
                                                                                    <label for="item_id">Collateral
                                                                                        Item</label>
                                                                                    <select class="form-control"
                                                                                        name="item_id" id="item_id">
                                                                                        @foreach ($collateral_items as $data)
                                                                                            <option
                                                                                                {{ $data->id == $row->item_id ? 'selected' : '' }}
                                                                                                value="{{ $data->id }}">
                                                                                                {{ $data->name }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                    <span class="invalid-feedback"></span>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="collateral_name">Collateral
                                                                                        Name</label>
                                                                                    <input type="text"
                                                                                        name="collateral_name"
                                                                                        id="collateral_name"
                                                                                        class="form-control"
                                                                                        value="{{ $row->name }}">
                                                                                    <span class="invalid-feedback"></span>
                                                                                </div>

                                                                                <div class="form-group">
                                                                                    <label
                                                                                        for="collateral_photo1">Collateral
                                                                                        Photo</label>
                                                                                    <div
                                                                                        class="image-upload image-uploadx">
                                                                                        <div class="thumb thumbx">
                                                                                            <img alt="image"
                                                                                                class="mr-3 collateral_preview1"
                                                                                                src="{{ asset('assets/uploads/loans/' . $row->photo) }}"
                                                                                                width="60">
                                                                                            <div class="upload-file">
                                                                                                <input type="file"
                                                                                                    name="collateral_photo"
                                                                                                    class="form-control file-upload collateral_photo1">
                                                                                                <label
                                                                                                    for="collateral_photo1"
                                                                                                    class="btn bg-secondary">upload
                                                                                                    photo </label>
                                                                                                <span
                                                                                                    class="invalid-feedback"></span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>

                                                                                <div class="form-group">
                                                                                    <label for="estimate_value">Estimate
                                                                                        Cost
                                                                                        Value</label>
                                                                                    <input type="text"
                                                                                        name="estimate_value"
                                                                                        id="estimate_value"
                                                                                        class="form-control"
                                                                                        value="{{ $row->estimate_value }}">
                                                                                    <span class="invalid-feedback"></span>
                                                                                </div>

                                                                                <div class="form-group">
                                                                                    <label for="remarks">Collateral
                                                                                        Remarks</label>
                                                                                    <textarea name="remarks" class="form-control" id="remarks" rows="3">{{ $row->remarks }}</textarea>
                                                                                    <span class="invalid-feedback"></span>
                                                                                </div>


                                                                                <div class="form-group">
                                                                                    <button type="button"
                                                                                        class="btn btn-sm btn-secondary"
                                                                                        data-dismiss="modal">Cancel</button>
                                                                                    <button type="submit"
                                                                                        class="btn btn-sm btn-theme edit_collateral">Update
                                                                                        Collateral</button>
                                                                                </div>

                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <button type="button" class="btn btn-xs btn-danger"
                                                                data-toggle="modal"
                                                                data-target="#deleteCollateralModel{{ $row->id }}">
                                                                <i class="fa fa-trash"></i></button>
                                                            <div class="modal fade"
                                                                id="deleteCollateralModel{{ $row->id }}"
                                                                tabindex="-1" role="dialog" aria-hidden="true">
                                                                <div class="modal-dialog modal-sm modal-dialog-centered"
                                                                    role="document">
                                                                    <div class="modal-content border-0">
                                                                        <div class="modal-body">
                                                                            <div class="alert alert-fwarning"
                                                                                role="alert">
                                                                                <i
                                                                                    class="fa fa-exclamation-triangle d-block display-4 mt-2 mb-3 text-warning text-center"></i>
                                                                                <h3 class="text-center">Delete Collateral
                                                                                    {{ $row->name }}?</h3>
                                                                                <form action="#" method="POST"
                                                                                    class="delete_collateral_form">
                                                                                    @csrf
                                                                                    <input type="hidden" name="id"
                                                                                        value="{{ $row->id }}">
                                                                                    <div
                                                                                        class="form-group text-center mt-3">
                                                                                        <button type="button"
                                                                                            class="btn btn-dark"
                                                                                            data-dismiss="modal">No,
                                                                                            Cancel</button>
                                                                                        <button type="submit"
                                                                                            class="btn btn-danger delete_collateral">Yes,
                                                                                            Delete</button>
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
        </div>
        <!--repayments-->
        <div class="tab-pane fade" id="repayments" role="tabpanel" aria-labelledby="repayments-tab">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            @if ($repayments->count() > 0)
                                <div class="card card-dashboard-table-six">
                                    <h6 class="card-title">Loan Repayments</h6>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Payment Date</th>
                                                    <th>Loan Amount</th>
                                                    <th>Repaid Amount</th>
                                                    <th>Balance Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($repayments as $row)
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
        <!-- repayment schedule-->
        <div class="tab-pane fade" id="repaymentschedule" role="tabpanel" aria-labelledby="repaymentschedule-tab">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center">{{ ucwords(strtolower($loan->member->title)) }}.
                                {{ ucwords(strtolower($loan->member->fname)) }}
                                {{ ucwords(strtolower($loan->member->lname)) }}'s Loan Repayment Schedule</h5>
                            <div class=" repaymentContainer ">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--documents-->
        <div class="tab-pane fade" id="documents" role="tabpanel" aria-labelledby="documents-tab">
            <div class="mb-4">
                <button type="button" class="btn btn-sm btn-theme" data-toggle="modal" data-target="#photoModel">
                    Upload Documents/ Photos</button>
                <div class="modal fade" id="photoModel" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">


                            <div class="modal-body">
                                <h3 class="card-title mb-4">Upload Loan Document/Photo</h3>
                                <form action="#" method="POST" id="photo_form">
                                    @csrf
                                    <input type="hidden" name="loan_id" class="form-control"
                                        value="{{ $loan->id }}">
                                    <input type="hidden" name="loan_no" class="form-control"
                                        value="{{ $loan->loan_no }}">
                                    <input type="hidden" name="member_id" class="form-control"
                                        value="{{ $loan->member_id }}">

                                    <div class="form-group mb-5">
                                        <div class="image-upload image-uploadx">
                                            <div class="thumb thumbx">
                                                <img alt="image" class="mr-3" id="preview"
                                                    src="{{ asset('assets/uploads/defaults/photo.jpg') }}"
                                                    width="200">
                                                <div class="upload-file">
                                                    <input type="file" name="photo" class="form-control file-upload"
                                                        id="photo">
                                                    <label for="photo" class="btn bg-secondary">upload</label>
                                                    <span class="invalid-feedback"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <button type="button" class="btn btn-sm btn-secondary"
                                            data-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-sm btn-theme" id="btn_photo">Upload
                                            Photo</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                @if ($documents->count() > 0)
                    @foreach ($documents as $row)
                        <div class="col-md-4">
                            <div class="card">
                                <img class="card-img-top img-fluid"
                                    src="{{ asset('assets/uploads/loans/' . $row->photo) }}" alt="contract photo">
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
        $('.nav-tabs a').on('shown.bs.tab', function(event) {
            var tab = $(event.target).attr("href");
            var url = "{{ route('webmaster.loan.dashboard', $loan->loan_no) }}";
            history.pushState({}, null, url + "?tab=" + tab.substring(1));
        });
        @if (isset($_GET['tab']))
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
            $("#btn_review").html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Submitting..'
            );
            $("#btn_review").prop("disabled", true);
            $.ajax({
                url: '{{ route('webmaster.loan.review.update') }}',
                method: 'post',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    $("#btn_review").html('Yes, Submit');
                    setTimeout(function() {
                        $("#btn_review").prop("disabled", false);
                        window.location.reload();
                    }, 500);
                }
            });
        });

        $('#role_id').change(function() {
            var role_id = $(this).val();
            let url = `${baseurl}/webmaster/loan/getstaffs/${role_id}`;
            $.get(url, function(response) {
                $("#staff_id").html(response);
            });
        });

        $("#officer_form").submit(function(e) {
            e.preventDefault();
            $("btn_officer").html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Assigning'
            );
            $("#btn_officer").prop("disabled", true);
            $.ajax({
                url: '{{ route('webmaster.loan.staff.assign') }}',
                method: 'post',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == 400) {
                        $.each(response.message, function(key, value) {
                            showError(key, value);
                        });
                        $("#btn_officer").html('Assign Officer');
                        $("#btn_officer").prop("disabled", false);
                    } else if (response.status == 200) {
                        $("#officer_form")[0].reset();
                        removeErrors("#officer_form");
                        $("#btn_officer").html('Assign Officer');
                        setTimeout(function() {
                            window.location.reload();
                        }, 500);

                    }
                }
            });
        });

        $("#payment_form").submit(function(e) {
            e.preventDefault();
            $("#btn_payment").html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Paying'
            );
            $("#btn_payment").prop("disabled", true);
            $.ajax({
                url: '{{ route('webmaster.loan.repayment.store') }}',
                method: 'post',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == 400) {
                        $.each(response.message, function(key, value) {
                            showError(key, value);
                        });
                        $("#btn_payment").html('Add Payments');
                        $("#btn_payment").prop("disabled", false);
                    } else if (response.status == 200) {
                        $("#payment_form")[0].reset();
                        removeErrors("#payment_form");
                        $("#btn_payment").html('Add Payments');
                        $("#btn_payment").prop("disabled", false);
                        setTimeout(function() {
                            window.location.reload();
                        }, 500);
                    }
                }
            });
        });

        previewImage("collateral_photo", "collateral_preview");
        $("#collateral_form").submit(function(e) {
            e.preventDefault();
            $("#btn_collateral").html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding'
            );
            $("#btn_collateral").prop("disabled", true);
            var formData = new FormData(this);
            $.ajax({
                url: '{{ route('webmaster.loan.collateral.store') }}',
                method: 'post',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 400) {
                        $.each(response.message, function(key, value) {
                            showError(key, value);
                        });
                        $("#btn_collateral").html('Add Collateral');
                        $("#btn_collateral").prop("disabled", false);
                    } else if (response.status == 200) {
                        $("#collateral_form")[0].reset();
                        removeErrors("#collateral_form");
                        $("#btn_collateral").html('Add Collateral');
                        $("#btn_collateral").prop("disabled", false);
                        setTimeout(function() {
                            window.location.reload();
                        }, 500);

                    }
                }
            });
        });

        $(".edit_collateral_form").submit(function(e) {
            e.preventDefault();
            $(".edit_collateral").html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Updating'
            );
            $(".edit_collateral").prop("disabled", true);
            var formData = new FormData(this);
            $.ajax({
                url: '{{ route('webmaster.loan.collateral.update') }}',
                method: 'post',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 400) {
                        $.each(response.message, function(key, value) {
                            showError(key, value);
                        });
                        $(".edit_collateral").html('Update Collateral');
                        $(".edit_collateral").prop("disabled", false);
                    } else if (response.status == 200) {
                        //$("#edit_collateral_form")[0].reset();
                        removeErrors("#edit_collateral_form");
                        $(".edit_collateral").html('Update Collateral');
                        $(".edit_collateral").prop("disabled", false);
                        setTimeout(function() {
                            window.location.reload();
                        }, 500);

                    }
                }
            });
        });

        $(".delete_collateral_form").submit(function(e) {
            e.preventDefault();
            $(".delete_collateral").html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Deleting..'
            );
            $(".delete_collateral").prop("disabled", true);
            $.ajax({
                url: '{{ route('webmaster.loan.collateral.delete') }}',
                method: 'post',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    $(".delete_collateral").html('Yes, Delete');
                    setTimeout(function() {
                        $(".delete_collateral").prop("disabled", false);
                        window.location.reload();
                    }, 500);
                }
            });
        });

        $("#guarantor_form").submit(function(e) {
            e.preventDefault();
            $("#btn_guarantor").html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding'
            );
            $("#btn_guarantor").prop("disabled", true);
            $.ajax({
                url: '{{ route('webmaster.loan.guarantor.store') }}',
                method: 'post',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == 400) {
                        $.each(response.message, function(key, value) {
                            showError(key, value);
                        });
                        $("#btn_guarantor").html('Add Guarantor');
                        $("#btn_guarantor").prop("disabled", false);
                    } else if (response.status == 200) {
                        removeErrors("#guarantor_form");
                        $("#guarantor_form")[0].reset();
                        $("#btn_guarantor").html('Add Guarantor');
                        setTimeout(function() {
                            $("#btn_guarantor").prop("disabled", false);
                            window.location.reload();
                        }, 500);
                    }
                }
            });
        });

        $(".edit_guarantor_form").submit(function(e) {
            e.preventDefault();
            $(".edit_guarantor").html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Updating'
            );
            $(".edit_guarantor").prop("disabled", true);
            $.ajax({
                url: '{{ route('webmaster.loan.guarantor.update') }}',
                method: 'post',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == 400) {
                        $.each(response.message, function(key, value) {
                            showError(key, value);
                        });
                        $(".edit_guarantor").html('Update Guarantor');
                        $(".edit_guarantor").prop("disabled", false);
                    } else if (response.status == 200) {
                        removeErrors(".edit_guarantor_form");
                        //$(".edit_guarantor_form")[0].reset();
                        $(".edit_guarantor").html('Update Guarantor');
                        setTimeout(function() {
                            $(".edit_guarantor").prop("disabled", false);
                            window.location.reload();
                        }, 500);
                    }
                }
            });
        });

        $(".delete_guarantor_form").submit(function(e) {
            e.preventDefault();
            $(".delete_guarantor").html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Deleting..'
            );
            $(".delete_guarantor").prop("disabled", true);
            $.ajax({
                url: '{{ route('webmaster.loan.guarantor.delete') }}',
                method: 'post',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    $(".delete_guarantor").html('Yes, Delete');
                    setTimeout(function() {
                        $(".delete_guarantor").prop("disabled", false);
                        window.location.reload();
                    }, 500);
                }
            });
        });


        $("#expense_form").submit(function(e) {
            e.preventDefault();
            $("#btn_expense").html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding'
            );
            $("#btn_expense").prop("disabled", true);
            $.ajax({
                url: '{{ route('webmaster.loan.expense.store') }}',
                method: 'post',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == 400) {
                        $.each(response.message, function(key, value) {
                            showError(key, value);
                        });
                        $("#btn_expense").html('Add Expense');
                        $("#btn_expense").prop("disabled", false);
                    } else if (response.status == 200) {
                        removeErrors("#expense_form");
                        $("#expense_form")[0].reset();
                        $("#btn_expense").html('Add Expense');
                        setTimeout(function() {
                            $("#btn_expense").prop("disabled", false);
                            window.location.reload();
                        }, 500);
                    }
                }
            });
        });

        $(".edit_expense_form").submit(function(e) {
            e.preventDefault();
            $(".edit_expense").html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Updating'
            );
            $("#edit_expense").prop("disabled", true);
            $.ajax({
                url: '{{ route('webmaster.loan.expense.update') }}',
                method: 'post',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == 400) {
                        $.each(response.message, function(key, value) {
                            showError(key, value);
                        });
                        $("#edit_expense").html('Update Expense');
                        $("#edit_expense").prop("disabled", false);
                    } else if (response.status == 200) {
                        removeErrors("#edit_expense_form");
                        //$("#edit_expense_form")[0].reset();
                        $("#edit_expense").html('Update Expense');
                        setTimeout(function() {
                            $("#edit_expense").prop("disabled", false);
                            window.location.reload();
                        }, 500);
                    }
                }
            });
        });


        $(".delete_expense_form").submit(function(e) {
            e.preventDefault();
            $(".delete_expense").html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Deleting..'
            );
            $(".delete_expense").prop("disabled", true);
            $.ajax({
                url: '{{ route('webmaster.loan.expense.delete') }}',
                method: 'post',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    $(".delete_expense").html('Yes, Delete');
                    setTimeout(function() {
                        $(".delete_expense").prop("disabled", false);
                        window.location.reload();
                    }, 500);
                }
            });
        });

        previewImage("photo", "preview");
        $("#photo_form").submit(function(e) {
            e.preventDefault();
            $("#btn_photo").html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Uploading'
            );
            $("#btn_photo").prop("disabled", true);
            var formData = new FormData(this);
            $.ajax({
                url: '{{ route('webmaster.loan.document.store') }}',
                method: 'post',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 400) {
                        $.each(response.message, function(key, value) {
                            showError(key, value);
                        });
                        $("#btn_photo").html('Upload Photo');
                        $("#btn_photo").prop("disabled", false);
                    } else if (response.status == 200) {
                        removeErrors("#photo_form");
                        $("#btn_photo").html('Upload Photo');
                        setTimeout(function() {
                            $("#btn_photo").prop("disabled", false);
                            window.location.reload();
                        }, 500);
                    }
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            //loan data
            var loanData = @json($loan);
            // console.log(loanData);
            const loanDistributionGraph = () => {
                var principalAmount = loanData.principal_amount
                var repaymentAmount = loanData.repayment_amount
                var interestAmount = loanData.interest_amount

                var data = [{
                    values: [principalAmount, interestAmount, repaymentAmount],
                    labels: ['Principal', 'Interest', 'Repayment Amount'],
                    type: 'pie',
                    hoverinfo: 'label+value', // Show label and percentage on hover
                    // textinfo: 'label+value', // Display label and value on slices
                    // textposition: 'outside', // Position text outside the pie slices
                    automargin: true,
                    // marker: {
                    // colors: ['#1f77b4', '#ff7f0e'] // Custom colors for the slices
                    // }
                }];

                // Layout settings
                var layout = {
                    // title: 'Loan Amount Distribution',
                    height: 300,
                    showlegend: true, // Display legend
                    legend: {
                        x: 1,
                        y: 0.5,
                        orientation: 'v' // Vertical legend
                    },
                    margin: {
                        l: 10,
                        r: 10,
                        b: 10,
                        t: 10,
                        pad: 4
                    },
                    autosize: true,
                    responsive: true
                };

                // Configuration settings
                var config = {
                    responsive: true, // Make chart responsive
                    displayModeBar: true, // Show mode bar with zoom/pan options
                    displaylogo: false, // Remove Plotly logo
                    scrollZoom: true // Enable scroll zooming
                };

                Plotly.newPlot('loanAmountDistribution', data, layout, config);

                // Resize chart on window resize
                window.onresize = function() {
                    Plotly.Plots.resize('loanAmountDistribution');
                };

            }

            const loanInfo = () => {
                const loanPaid = loanData.repaid_amount;
                const loanRemaining = loanData.repayment_amount - loanPaid;
                const loanPenalty = loanData.penalty_amount;
                const loanFees = loanData.fees_total;
                // Custom titles for the x-axis
                var categories = ['Loan Paid', 'Loan Remaining', 'Loan Penalty', 'Loan Fees'];

                var values = [loanPaid, loanRemaining, loanPenalty, loanFees];
                var data = [{
                    x: categories,
                    y: values,
                    type: 'bar',
                    marker: {
                        color: ['#1f77b4', '#ff7f0e', '#2ca02c',
                            '#d62728'
                        ] // Custom colors for each bar
                    }
                }];

                // Layout settings
                var layout = {
                    title: {
                        // text: 'Loan Data Summary',
                        x: 0.5, // Center the title
                        y: 0.95, // Position title below the mode bar
                        xanchor: 'center',
                        yanchor: 'top'
                    },
                    height: 300,
                    xaxis: {
                        // title: 'Category',
                        automargin: true,
                        tickangle: -45 // Tilt the x-axis labels if needed
                    },
                    yaxis: {
                        title: 'Amount',
                        automargin: true
                    },
                    autosize: true,
                    responsive: true,
                    margin: {
                        l: 20,
                        r: 20,
                        b: 50,
                        t: 40,
                        pad: 4 // Adjust bottom margin for tilted labels
                    }
                };

                // Configuration settings
                var config = {
                    responsive: true,
                    displayModeBar: true,
                    displaylogo: false,
                    scrollZoom: true
                };

                // Render the chart
                Plotly.newPlot('loanInfo', data, layout, config);

                // Resize chart on window resize
                window.onresize = function() {
                    Plotly.Plots.resize('loanInfo');
                };
            }

            loanDistributionGraph()
            loanInfo()

            //function to get detailed loan info for repayment schedule
            const getDetailedLoanInfo = () => {
                const loanProductInfo = loanData.loanproduct
                var repaymentMode = loanProductInfo.duration;
                var loanDuration = Number(loanData.loan_period);
                var periodicPaymentsPerYear;
                var loanDurationInYears;
                var numberOfRecoveryInstallments;
                var interestRate = Number(loanProductInfo.interest_rate);
                var loan_amount = Number(loanData.principal_amount);

                switch (repaymentMode) {
                    case 'day':
                        // alert('daily')
                        periodicPaymentsPerYear = 365
                        loanDurationInYears = (loanDuration / periodicPaymentsPerYear)
                        break;
                    case 'week':
                        // alert('weekly')
                        periodicPaymentsPerYear = 52
                        loanDurationInYears = (loanDuration / periodicPaymentsPerYear)
                        break;
                    case 'month':
                        // alert('monthly')
                        periodicPaymentsPerYear = 12
                        loanDurationInYears = (loanDuration / periodicPaymentsPerYear)
                        break;
                    case 'quarter':
                        // alert('quarterly')
                        periodicPaymentsPerYear = 4
                        loanDurationInYears = (loanDuration / periodicPaymentsPerYear)
                        break;
                    case 'semi_year':
                        // alert('semi-annually')
                        periodicPaymentsPerYear = 2
                        loanDurationInYears = (loanDuration / periodicPaymentsPerYear)
                        break;
                    case 'year':
                        // alert('annually')
                        periodicPaymentsPerYear = 1
                        loanDurationInYears = (loanDuration / periodicPaymentsPerYear)
                        break;
                }

                numberOfRecoveryInstallments = (loanDurationInYears * periodicPaymentsPerYear).toFixed();

                var data = {
                    numberOfInstallments: numberOfRecoveryInstallments,
                    numberOfPaymentsInAyear: periodicPaymentsPerYear,
                    principalAmount: loan_amount,
                    repaymentMode: repaymentMode,
                    interestRate: interestRate,
                    loanNumber: loanData.loan_no,
                    _token: "{{ csrf_token() }}"
                }
                //getting repayment schedule info
                $.ajax({
                    type: "post",
                    url: "{{ route('webmaster.loan.repayment') }}",
                    data: data,
                    success: function(response) {
                        $('.repaymentContainer').html(response.html);
                    },
                    error: function(xhr, status, error) {
                        console.log(error)
                    }
                });
            }
            getDetailedLoanInfo()
        })
    </script>
    <script>
        $(document).ready(function() {

            $('#compositeline').sparkline('html', {
                lineColor: '#cecece',
                lineWidth: 2,
                spotColor: false,
                minSpotColor: false,
                maxSpotColor: false,
                highlightSpotColor: null,
                highlightLineColor: null,
                fillColor: '#f9f9f9',
                chartRangeMin: 0,
                chartRangeMax: 10,
                width: '100%',
                height: 20,
                disableTooltips: true
            });

            $('#compositeline2').sparkline('html', {
                lineColor: '#cecece',
                lineWidth: 2,
                spotColor: false,
                minSpotColor: false,
                maxSpotColor: false,
                highlightSpotColor: null,
                highlightLineColor: null,
                fillColor: '#f9f9f9',
                chartRangeMin: 0,
                chartRangeMax: 10,
                width: '100%',
                height: 20,
                disableTooltips: true
            });

            $('#compositeline3').sparkline('html', {
                lineColor: '#cecece',
                lineWidth: 2,
                spotColor: false,
                minSpotColor: false,
                maxSpotColor: false,
                highlightSpotColor: null,
                highlightLineColor: null,
                fillColor: '#f9f9f9',
                chartRangeMin: 0,
                chartRangeMax: 10,
                width: '100%',
                height: 20,
                disableTooltips: true
            });

            $('#compositeline4').sparkline('html', {
                lineColor: '#cecece',
                lineWidth: 2,
                spotColor: false,
                minSpotColor: false,
                maxSpotColor: false,
                highlightSpotColor: null,
                highlightLineColor: null,
                fillColor: '#f9f9f9',
                chartRangeMin: 0,
                chartRangeMax: 10,
                width: '100%',
                height: 20,
                disableTooltips: true
            });

        });
    </script>
@endsection
