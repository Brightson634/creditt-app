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
                     <a href="{{ route('webmaster.chartofaccount.create') }}" class="btn btn-sm btn-theme"> <i class="fa fa-plus"></i> Add Chart Of Account</a>
                  </div>
               </div>
               @if($chartofaccounts->count() > 0)
               <div class="table-responsive">
                  <table class="table table-sm mb-0">
                     <thead>
                        <tr>
                           <th>Code</th>
                           <th>Name</th>
                           <th>Account Type</th>
                           <th>Balance</th>
                           <th>Currency</th>
                           <th>Status</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($chartofaccounts as $row)
                        <tr>
                           <th>{{ $row->code }}</th>
                           <td>{{ $row->name }}</td>
                           <td>{{ $row->accountsubtype->name }}</td>
                           <td>{!! showAmount($row->opening_balance) !!}</td>
                           <td>{{ $row->currency->name}}</td>
                           <td>
                              @if($row->status == 1)
                              <div class="badge badge-success"> Active</div>
                              @endif
                              @if($row->status == 0)
                              <div class="badge badge-danger"> Not Active</div>
                              @endif
                           </td>
                           <td>
                             <a href="{{ route('webmaster.chartofaccount.accountbook', $row->id) }}" class="btn btn-xs btn-info"> <i class="far fa-eye"></i> Account Book</a>
                             <a href="#{{ route('webmaster.chartofaccount.edit', $row->id) }}" class="btn btn-xs btn-dark"> <i class="far fa-edit"></i> Edit</a>
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