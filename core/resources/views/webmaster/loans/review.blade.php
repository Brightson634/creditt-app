@extends('webmaster.partials.main')
@section('title')
    {{ $page_title }}
@endsection
@section('content')
<div class="page-heading">
   <div class="page-heading__title">
      <h3>{{ $page_title }}</h3>
   </div>
</div>

<div class="row">
   <div class="col-md-10 mx-auto">
      <div class="card">
         <div class="card-body">
            <div class="text-center mt-3">
               <h4><strong>#{{ $loan->loan_no }}</strong></h4>
            </div>
            <!-- <div class="float-right">
                     <a href="{{ route('webmaster.loan.reviewpdf', $loan->loan_no) }}" class="btn btn-sm btn-secondary" target="_blank"> <i class="fa fa-download"></i> Download PDF </a>
                  </div> -->

            <hr>            
            <div class="row mt-4">
               <div class="col-6">
                  @if($loan->loan_type == 'individual')
                  <p class="mb-2"><strong>Member: </strong>{{ $loan->member->title }} {{ $loan->member->fname }} {{ $loan->member->lname }} {{ $loan->member->oname }}</p>
                  @endif
                  @if($loan->loan_type == 'group')
                  <p class="mb-2"><strong>Group: </strong> {{ $loan->member->fname }}</p>
                  @endif

                  <p class="mb-2"><strong>Loan Product: </strong> {{ $loan->loanproduct->name }}</p>

                  <p class="mb-2"><strong>Interest Rate: </strong> {{ $loan->loanproduct->interest_rate }}% / @if($loan->loanproduct->duration == 'day') DAY @endif @if($loan->loanproduct->duration == 'week') WEEK  @endif @if($loan->loanproduct->duration == 'month') MONTH  @endif</p>

                  <p class="mb-2"><strong>Loan Period: </strong> {{ $loan->loan_period }} @if($loan->loanproduct->duration == 'day') days @endif @if($loan->loanproduct->duration == 'week') weeks  @endif @if($loan->loanproduct->duration == 'month') months  @endif</p>

                  <p class="mb-2"><strong>Release Date: </strong> {{ dateFormat($loan->release_date) }}</span></p>
                  <p class="mb-2"><strong>Repayment Date: </strong> {{ dateFormat($loan->repayment_date) }}</span></p>
                  <p class="mb-2"><strong>Loan End Date: </strong> {{ dateFormat($loan->end_date) }}</span></p>
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
                             {!! showAmount($loan->principal_amount) !!}
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
                             {!! showAmount($loan->interest_amount) !!}
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
                             {!! showAmount($loan->repayment_amount) !!}
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
                             {!! showAmount($loan->fees_total) !!}
                           </h4>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

            <div class="row mt-2">
               <div class="col-md-12">
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
                           @foreach($loancharges as $row)
                           @php 
                           $total_charges += $row->amount;
                           $i++; 
                           @endphp
                           <tr>
                              <td>{{ $i }}</td>
                              <td>{{ $row->detail }}</td>
                              <td> {!! showAmount($row->amount) !!}</td>
                              <td>@if($row->account_id != NULL) {{ $row->account->account_no }}  @else -  @endif </td>
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
                           @foreach($guarantors as $row)
                           @php $i++;  @endphp
                           <tr>
                              <td>{{ $i }}</td>
                              @if($row->is_member == 1)
                                 <td>
                                    @if($row->member->member_type == 'individual') {{ $row->member->title }} {{ $row->member->fname }} {{ $row->member->lname }} @endif
                                    @if($row->member->member_type == 'group') {{ $row->member->fname }} @endif
                                 </td>
                                 <td>{{ $row->member->email }}</td>
                                 <td>{{ $row->member->telephone }}</td>
                                 <td>{{ $row->member->address }}</td>
                                 <td>Member</td>
                              @endif
                              @if($row->is_member == 0)
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
                           @foreach($collaterals as $row)
                           @php 
                           $i++;
                           $total_costs += $row->estimate_value;
                           @endphp
                           <tr>
                              <td>{{ $i }}</td>
                              <td>{{ $row->item->name }}</td>
                              <td>{{ $row->name }}</td>
                              <td>{!! showAmount($row->estimate_value) !!}</td>
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
            $officers = \App\Models\LoanOfficer::where('loan_id', $loan->id)->get();
            @endphp
            @if($officers->count() > 0)
            <div class="row">
               @foreach($officers as $row)
               @if($row->date != NULL)
               <div class="col-md-12 mb-2" style="background: #eceff4;padding: 0.5rem;">
                  <div class="mb-3">
                     <!-- <h6 class="text-muted">Notes:</h6> -->
                     <small>{{ $row->comment }}</small>
                  </div>

                  <div class="">
                     <h6>{{ $row->staff->title }} {{ $row->staff->fname }} {{ $row->staff->lname }} {{ $row->staff->oname }}</h6>
                     <img alt="image" src="{{ asset('assets/uploads/staffs/'. $row->staff->signature )}}" width="30" alt="signature" /> <br/>
                     <small>{{ dateFormat($row->date) }}</small>
                  </div>
               </div>
               @endif
               @endforeach
            </div>
            @endif
            <hr>

            <div class="row mt-4">
               <div class="col-md-12">
                  <h5 class="mb-3"><strong>Approving Notes</strong></h5>
                  <form action="#" method="POST" id="review_form"> 
                     @csrf
                     <input type="hidden" name="loan_id" class="form-control" value="{{ $loan->id }}">
                     <div class="row">
                        <div class="col-md-12">
                           <div class="form-group">
                              <label for="notes" class="form-label">Notes</label>
                              <textarea name="notes" class="form-control" id="notes" rows="4" placeholder="writer your notes about the loan"></textarea>
                              <span class="invalid-feedback"></span>
                           </div>
                        </div>
                     </div>
                     <div class="row mb-2">
                        <div class="col-md-12">
                           <div class="form-group">
                              <div class="mt-2">
                                 <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="approve" name="status" class="custom-control-input" value="2" checked>
                                    <label class="custom-control-label" for="approve">APPROVE LOAN</label>
                                 </div>
                                 <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="reject" name="status" class="custom-control-input" value="3">
                                    <label class="custom-control-label" for="reject">REJECT LOAN</label>
                                 </div>
                              </div>
                           </div>
                        </div>
                  </div>
                     <div class="row">
                        <div class="col-sm-9">
                           <button type="submit" class="btn btn-theme" id="btn_review">Update Review</button>
                        </div>
                     </div>
                  </form>
               </div>
         </div>
      </div>
   </div>
</div>


@endsection

 
@section('scripts')
<script type="text/javascript">
   "use strict";

   $("#review_form").submit(function(e) {
        e.preventDefault();
        $("#btn_review").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Updating');
        $("#btn_review").prop("disabled", true);
        $.ajax({
          url:'{{ route('webmaster.loan.review.store') }}',
          method: 'post',
          data: $(this).serialize(),
          dataType: 'json',
          success: function(response){
            if(response.status == 400){
              $.each(response.message, function (key, value) {
                showError(key, value);
              });
              $("#btn_review").html('Update Review');
              $("#btn_review").prop("disabled", false);
            } else if(response.status == 200){
               $("#review_form")[0].reset();
              removeErrors("#review_form");
              $("#btn_review").html('Update Review');
              $("#btn_review").prop("disabled", false);
              setTimeout(function(){
                window.location.href = response.url;
              }, 1000);

            }
          }
        });
      });
</script>
@endsection