@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection
@section('content')
<div class="page-heading">
 
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
                              @if($loan->loan_type == 'individual')
                              {{ $loan->member->title }} {{ $loan->member->fname }} {{ $loan->member->lname }} {{ $loan->member->oname }}
                              @elseif($loan->loan_type == 'group')
                              {{ $loan->member->fname }}
                              @endif
                           </td>
                           <!-- Loan Product -->
                           <td>{{ $loan->loanproduct->name }}</td>
                           <!-- Interest Rate -->
                           <td>{{ $loan->loanproduct->interest_rate }}% / 
                              @if($loan->loanproduct->duration == 'day') DAY @endif 
                              @if($loan->loanproduct->duration == 'week') WEEK @endif 
                              @if($loan->loanproduct->duration == 'month') MONTH @endif
                           </td>
                           <!-- Loan Period -->
                           <td>{{ $loan->loan_period }} 
                              @if($loan->loanproduct->duration == 'day') days @endif 
                              @if($loan->loanproduct->duration == 'week') weeks @endif 
                              @if($loan->loanproduct->duration == 'month') months @endif
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
                  @if($loancharges->count() > 0)
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
                  <h5 class="mb-3"><strong>Reviewing Notes</strong></h5>
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
                  </div>
                     <div class="row">
                        <div class="col-sm-9">
                           <button type="submit" class="btn btn-indigo btn-theme" id="btn_review">Update Review</button>
                        </div>
                     </div>
                  </form>
               </div>
         </div>
      </div>
   </div>
</div>


@endsection

{{-- @php
$officers = \App\Models\LoanOfficer::where('loan_id', $loan->id)->get();
@endphp --}}
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
