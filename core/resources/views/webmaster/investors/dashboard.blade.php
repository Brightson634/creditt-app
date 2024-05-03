@extends('webmaster.partials.main')
@section('title')
   {{ $page_title }}
@endsection
@section('content')
<div class="page-heading ">
   <div class="page-heading__title">
      <h3>{{ $page_title }}</h3>
      <div>
         <a href="{{ route('webmaster.investment.create') }}" class="btn btn-sm btn-theme"> <i class="fa fa-plus"></i> New Investment</a>
      </div>
   </div>
   <div class="page-heading__title">
      <ul class="nav nav-tabs">
         <li class="nav-item"> 
            <a class="nav-link active" href="#dashboard" data-toggle="tab" aria-expanded="false"><i class="fas fa-chart-line"></i> Overview</a>
         </li>
         <li class="nav-item"> 
            <a class="nav-link" href="#documents" data-toggle="tab" aria-expanded="false"> <i class="far fa-user"></i> Documents</a>
         </li>
      </ul>
   </div>
</div>
<div class="tab-content">
   <div class="tab-pane show active" id="dashboard">
      <div class="row">

         <div class="col-md-12">
            <div class="card">
         <div class="card-body">

            <div class="row">
               <div class="col-md-4">
                  <div class="card shadow-lg">
                     <div class="card-body">
                        <div class="mb-4">
                           <h5 class="card-title mb-0">Investment Amount</h5>
                        </div>
                        <div class="row d-flex align-items-center mb-4">
                           <div class="col-8">
                              <h2 class="d-flex align-items-center mb-0">
                                {!! isset($investmentdata->investment_amount) ? showAmount($investmentdata->investment_amount) : 0 !!}
                              </h2>
                           </div>
                           <div class="col-4 text-right text-success">
                              <strong><span>100% <i class="mdi mdi-arrow-up text-success"></i></span></strong>
                           </div>
                        </div>
                        <div class="progress shadow-sm" style="height: 5px;">
                           <div class="progress-bar bg-success" role="progressbar" style="width: 100%;"></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="card shadow-lg">
                     <div class="card-body">
                        <div class="mb-4">
                           <h5 class="card-title mb-0">Interests Amount</h5>
                        </div>
                        <div class="row d-flex align-items-center mb-4">
                           <div class="col-8">
                              <h2 class="d-flex align-items-center mb-0">
                                 {!! isset($investmentdata->interest_amount) ? showAmount($investmentdata->interest_amount) : 0 !!}
                              </h2>
                           </div>
                           <div class="col-4 text-right text-warning">
                              <strong><span>100% <i class="mdi mdi-arrow-down text-warning"></i></span></strong>
                           </div>
                        </div>
                        <div class="progress shadow-sm" style="height: 5px;">
                           <div class="progress-bar bg-warning" role="progressbar" style="width: 100%;"></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="card shadow-lg">
                     <div class="card-body">
                        <div class="mb-4">
                           <h5 class="card-title mb-0">ROI Amount</h5>
                        </div>
                        <div class="row d-flex align-items-center mb-4">
                           <div class="col-8">
                              <h2 class="d-flex align-items-center mb-0">
                                 {!! isset($investmentdata->roi_amount) ? showAmount($investmentdata->roi_amount) : 0 !!}
                              </h2>
                           </div>
                           <div class="col-4 text-right text-info">
                              <strong><span>100% <i class="mdi mdi-arrow-down text-info"></i></span></strong>
                           </div>
                        </div>
                        <div class="progress shadow-sm" style="height: 5px;">
                           <div class="progress-bar bg-info" role="progressbar" style="width: 100%;"></div>
                        </div>
                     </div>
                  </div>
               </div>               
            </div>
         </div>
      </div>
         </div>
      
         
      </div>
   </div>


   <div class="tab-pane" id="documents">

      <div class="row">
         <div class="col-md-12">         
            <div class="card">
            <div class="card-body">
               <div class="clearfix mb-3">
                  <div class="float-left">
                     <h3 class="card-title">{{ $page_title }}</h3>
                  </div>
               </div>
               @if($investments->count() > 0)
               <div class="table-responsive">
                  <table class="table table-sm mb-0">
                     <thead>
                        <tr>
                           <th>#</th>
                           <th>Investment No</th>
                           <th>Member</th>
                           <th>Investment Amount</th>
                           <th>Interest Amount</th>
                           <th>ROI Amount</th>
                           <th>End Date</th>
                        </tr>
                     </thead>
                     <tbody>
                        @php $i = 0; @endphp
                        @foreach($investments as $row)
                        @php $i++; @endphp
                        <tr>
                           <th scope="row">{{ $i }}</th>
                           <td><a href="{{ route('webmaster.investment.dashboard', $row->investment_no) }}">{{ $row->investment_no }}</a></td>
                           <td>{{ $row->investor->name }}</td>
                           <td>{!! showAmount($row->investment_amount) !!}</td>
                           <td>{!! showAmount($row->interest_amount) !!}</td>
                           <td>{!! showAmount($row->roi_amount) !!}</td>
                           <td>{{ formatDate($row->date) }}</td>
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
   </div>

</div>
@endsection

@section('scripts')
<script type="text/javascript">
   $('.nav-tabs a').on('shown.bs.tab', function(event){
         var tab = $(event.target).attr("href");
         var url = "{{ route('webmaster.investor.dashboard', $investor->id) }}";
         history.pushState({}, null, url + "?tab=" + tab.substring(1));
      });

      @if(isset($_GET['tab']))
         $('.nav-tabs a[href="#{{ $_GET['tab'] }}"]').tab('show');
      @endif
</script>
@endsection
