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
      <div class="col-xl-12 mx-auto">
         <div class="card">
            <div class="card-body">
               <div class="clearfix mb-3">
                  <div class="float-left">
                     <h3 class="card-title">{{ $page_title }}</h3>
                  </div>
                  <div class="float-right">
                     <a href="{{ route('webmaster.journalentry.create') }}" class="btn btn-sm btn-theme"> <i class="fa fa-plus"></i> Add Journal Entry</a>
                  </div>
               </div>
               @if($journalentries->count() > 0)
               <div class="table-responsive">
                  <table class="table table-sm mb-0">
                     <thead>
                        <tr>
                           <th>Journal No</th>
                           <th>Date</th>
                           <th>Debit Amount</th>
                           <th>Credit Amount</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($journalentries as $row)
                        <tr>
                           <td>{{ $row->journal_no }}</td>
                           <td>{{ dateFormat($row->date) }}</td>
                           <td>{!! showAmount($row->total_debit) !!}</td>
                           <td>{!! showAmount($row->total_credit) !!}</td>
                           <td> 
                             <a href="javascript:void(0)" class="btn btn-xs btn-dark" data-toggle="modal" data-target="#viewModel{{ $row->id }}"> <i class="far fa-eye"></i> View</a>
                             <div class="modal fade" id="viewModel{{ $row->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                 <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">                          
                                       <div class="modal-body">
                                          <h4 class="card-title mb-4"> Journal Entry Information </h4>
                                          <div class="mb-4">
                                             <p class="mb-2"><strong>Journal No: </strong> {{ $row->journal_no }}</p>
                                             <p class="mb-2"><strong>Transaction Date: </strong> {{ dateFormat($row->date) }}</p>
                                             <p class="mb-2"><strong>Description: </strong> {{ $row->description }}</p>
                                          </div>

                                          <div class="row">
                                             <div class="col-md-12">
                                                @php 
                                                   $journalitems = \App\Models\JournalItem::where('journal_id',  $row->id)->get();
                                                @endphp
                                                @if($journalitems->count() > 0)
                                                <h6 class="mb-3"><strong>Journal Entries</strong></h6>
                                                <div class="table-responsive">
                                                   <table class="table table-sm">
                                                      <thead>
                                                         <tr>
                                                            <th>Account</th>
                                                            <th>Debit Amount</th>
                                                            <th>Credit Amount</th>
                                                         </tr>
                                                      </thead>
                                                      <tbody>
                                                         @php $total_debit =  $total_credit = 0; @endphp
                                                         @foreach($journalitems as $item)
                                                         @php 
                                                         $total_debit += $item->debit_amount;
                                                         $total_credit += $item->credit_amount;
                                                         @endphp
                                                         <tr>
                                                            <td>{{ $item->account }}</td>
                                                            <td>{!! $item->debit_amount == 0 ? '-' : showAmount($item->debit_amount) !!}</td>
                                                            <td>{!! $item->credit_amount == 0 ? '-' : showAmount($item->credit_amount) !!}</td>
                                                         <tr>
                                                         @endforeach
                                                      </tbody>
                                                      <tfoot>
                                                         <tr>
                                                            <td><strong>Total</strong></td>
                                                            <td><strong>{!! showAmount($total_debit) !!}</strong></td>
                                                            <td><strong>{!! showAmount($total_credit) !!}</strong></td>
                                                         </tr>
                                                      </tfoot>
                                                   </table>
                                                </div>
                                                @endif
                                             </div>
                                          </div>
                                          <div class="float-right">
                                           <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
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
                  <span class="mt-3">No Data</span>
               </div>
               @endif
            </div>
         </div>
      </div>
   </div>
@endsection