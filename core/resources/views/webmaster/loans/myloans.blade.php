@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection
@section('content')
   <div class="row">
      <div class="col-xl-12 mx-auto">
         <div class="card">
            <div class="card-body">
               @if($loans->count() > 0)
                  <div class="card card-dashboard-table-six">
                     <h6 class="card-title">{{ $page_title }}</h6>
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
                              @foreach($loans as $row)
                              @php $i++; @endphp
                              <tr>
                                 <th scope="row">{{ $i }}</th>
                                 <td>{{ $row->loan_no }}</td>
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
@endsection
