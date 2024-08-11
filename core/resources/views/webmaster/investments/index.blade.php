@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection
@section('content')
<div class="page-heading ">
   <div class="page-heading__title">
      {{-- <h3>{{ $page_title }}</h3> --}}
   </div>

   <div class="page-heading__title">
      <ul class="nav nav-tabs" style="background-color:#e3e7ed">
         <li class="nav-item">
            <a class="nav-link active" href="#memberinvestments" data-toggle="tab" title="Member Investments" aria-expanded="false"><i class="fas fa-chart-line"></i></a>
         </li>
         <li class="nav-item">
            <a class="nav-link" href="#nonmemberinvestments" data-toggle="tab" title="Non Member Investments" aria-expanded="false"><i class="fas fa-chart-line"></i>
            </a>
         </li>
         <li class="nav-item">
            <a class="nav-link" href="{{ route('webmaster.investment.create') }}" title="New Investment"> <i class="fas fa-plus"></i>
            </a>
         </li>
      </ul>
   </div>
</div>
<div class="tab-content">
   <div class="tab-pane show active" id="memberinvestments">
   <div class="row">
      <div class="col-xl-12 mx-auto">
         <div class="card">
            <div class="card-body">
               @if($data['memberinvestments']->count() > 0)
               <div class="card card-dashboard-table-six">
                  <h6 class="card-title">{{ $page_title }}</h6>
                  <div class="table-responsive">
                     <table class="table table-striped">
                        <thead>
                           <tr>
                              <th>#</th>
                              <th>Investment No</th>
                              <th>Member</th>
                              <th>Investment Amount</th>
                              <th>Interest Amount</th>
                              <th>ROI Amount</th>
                              <th>End Date</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           @php $i = 0; @endphp
                           @foreach($data['memberinvestments'] as $row)
                           @php $i++; @endphp
                           <tr>
                              <th scope="row">{{ $i }}</th>
                              <td><a href="{{ route('webmaster.investment.dashboard', $row->investment_no) }}">{{ $row->investment_no }}</a></td>
                              <td>{{ $row->member->fname }} {{ $row->member->lname }}</td>
                              <td>{!! showAmount($row->investment_amount) !!}</td>
                              <td>{!! showAmount($row->interest_amount) !!}</td>
                              <td>{!! showAmount($row->roi_amount) !!}</td>
                              <td>{{ formatDate($row->end_date) }}</td>
                              <td>
                              <a href="#{{ route('webmaster.investment.edit', $row->id) }}" class="btn btn-xs btn-dark"> <i class="far fa-edit"></i></a>
                              </td>
                           <tr>
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
   </div>

   <div class="tab-pane" id="nonmemberinvestments">
      <div class="row">
      <div class="col-xl-12 mx-auto">
         <div class="card">
            <div class="card-body">
               <div class="clearfix mb-3">
                  <div class="float-left">
                     <h3 class="card-title">{{ $page_title }}</h3>
                  </div>
               </div>
               @if($data['nonmemberinvestments']->count() > 0)
               <div class="card card-dashboard-table-six">
                  <h6 class="card-title">{{ $page_title }}</h6>
                  <div class="table-responsive">
                     <table class="table table-striped">
                        <thead>
                           <tr>
                              <th>#</th>
                              <th>Investment No</th>
                              <th>Member</th>
                              <th>Investment Amount</th>
                              <th>Interest Amount</th>
                              <th>ROI Amount</th>
                              <th>End Date</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           @php $i = 0; @endphp
                           @foreach($data['nonmemberinvestments'] as $row)
                           @php $i++; @endphp
                           <tr>
                              <th scope="row">{{ $i }}</th>
                              <td><a href="{{ route('webmaster.investment.dashboard', $row->investment_no) }}">{{ $row->investment_no }}</a></td>
                              <td>{{ $row->investor->name }}</td>
                              <td>{!! showAmount($row->investment_amount) !!}</td>
                              <td>{!! showAmount($row->interest_amount) !!}</td>
                              <td>{!! showAmount($row->roi_amount) !!}</td>
                              <td>{{ formatDate($row->date) }}</td>
                              <td>
                              <a href="#{{ route('webmaster.investment.edit', $row->id) }}" class="btn btn-xs btn-dark"> <i class="far fa-edit"></i></a>
                              </td>
                           <tr>
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
  </div>

</div>



@endsection
@section('scripts')
   <script type="text/javascript">
      "use strict";

      $('.nav-tabs a').on('shown.bs.tab', function(event){
         var tab = $(event.target).attr("href");
         var url = "{{ route('webmaster.investments') }}";
          history.pushState({}, null, url + "?tab=" + tab.substring(1));
      });
      @if(isset($_GET['tab']))
         $('.nav-tabs a[href="#{{ $_GET['tab'] }}"]').tab('show');
      @endif
   </script>
@endsection
