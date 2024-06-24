@extends('webmaster.partials.dashboard.main')
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
      <div class="col-xl-12 mx-auto">
         <div class="card">
            <div class="card-body">
               <div class="mb-4">
                  <h5 class="mb-2"><strong>Account Name: </strong>{{ $account->code }} - {{ $account->name }}</h5>
                  <h5 class="mb-2"><strong>Account Type: </strong> {{ $account->accounttype->name }} / {{ $account->accountsubtype->name }}</h5>
                  <h5 class="mb-2"><strong>Account Number: </strong> uy</h5>
                  <h5 class="mb-2"><strong>Balance: </strong> {!! showAmount($account->opening_balance) !!}</h5>
               </div>

               <div class="clearfix mb-3">
                  <div class="float-left">
                     <h3 class="card-title">Account Transactions</h3>
                  </div>
               </div>
               @if($transactions->count() > 0)
               <div class="table-responsive">
                  <table class="table table-sm mb-0">
                     <thead>
                        <tr>
                           <th></th>
                           <th>Date</th>
                           <th>Debit</th>
                           <th>Credit</th>
                           <th>Balance</th>
                           <th>Description</th>
                        </tr>
                     </thead>
                     <tbody>
                        @php $i = 0 @endphp
                        @foreach($transactions as $row)
                        @php $i++ @endphp
                        <tr>
                           <th>{{ $i }}</th>
                           <td>{{ dateFormat($row->date) }}</td>
                           <td>
                              @if($row->type == 'DEBIT') {!! showAmount($row->amount) !!}  @else -  @endif
                           </td>
                           <td>
                              @if($row->type == 'CREDIT') {!! showAmount($row->amount) !!}  @else -  @endif
                           </td>
                           <td>{!! showAmount($row->cuurent_amount) !!}</td>
                           <td>{{ $row->description }}</td>
                        <tr>
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
@endsection
