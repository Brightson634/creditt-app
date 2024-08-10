@include('webmaster.members.membersinfo')
{{-- @extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection
@section('content')
<div class="page-heading">
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
                     <a href="{{ route('webmaster.memberaccount.create') }}" class="btn btn-dark btn-sm btn-theme"> <i class="fa fa-plus"></i> New Account</a>
                  </div>
               </div>
               @if($accounts->count() > 0)
               <div class="table-responsive">
                  <table class="table table-sm mb-0">
                     <thead>
                        <tr>
                           <th>#</th>
                           <th>Account No</th>
                           <th>Account Type</th>
                           <th>Member</th>
                           <th>Opening Balance</th>
                           <th>Current Balance</th>
                           <th>Available balance</th>
                           <th>Status</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @php $i = 0; @endphp
                        @foreach($accounts as $row)
                        @php $i++; @endphp
                        <tr>
                           <th scope="row">{{ $i }}</th>
                           <td>{{ $row->account_no }}</td>
                           <td>{{ $row->accounttype->name }}</td>
                           <td>{{ $row->member->fname }} {{ $row->member->lname }}</td>
                           <td>{!! showAmount($row->opening_balance) !!}</td>
                           <td>{!! showAmount($row->current_balance) !!}</td>
                           <td>{!! showAmount($row->available_balance) !!}</td>
                           <td>
                              @if($row->account_status == 1)
                                 <div class="badge badge-success">ACTIVE</div>
                              @endif
                              @if($row->account_status == 0)
                                 <div class="badge badge-warning">INACTIVE</div>
                              @endif
                           </td>
                           <td>
                             <a href="#{{ route('webmaster.memberaccount.edit', $row->account_no) }}" class="btn btn-xs btn-dark"> <i class="far fa-edit"></i></a>
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
@endsection --}}
