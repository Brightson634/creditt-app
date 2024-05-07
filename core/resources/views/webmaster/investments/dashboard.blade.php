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
         <div class="col-md-8">
            <div class="row">

         <div class="col-md-12">
            <div class="card">
         <div class="card-body">

            <div class="row">
               <div class="col-md-6">
                  <div class="card shadow-lg">
                     <div class="card-body">
                        <div class="mb-4">
                           <h5 class="card-title mb-0">Investment Amount</h5>
                        </div>
                        <div class="row d-flex align-items-center mb-4">
                           <div class="col-8">
                              <h2 class="d-flex align-items-center mb-0">
                                {!! showAmount($investment->investment_amount) !!}
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
               <div class="col-md-6">
                  <div class="card shadow-lg">
                     <div class="card-body">
                        <div class="mb-4">
                           <h5 class="card-title mb-0">Interest Amount</h5>
                        </div>
                        <div class="row d-flex align-items-center mb-4">
                           <div class="col-8">
                              <h2 class="d-flex align-items-center mb-0">
                                  {!! showAmount($investment->interest_amount) !!}
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
               <div class="col-md-6">
                  <div class="card shadow-lg">
                     <div class="card-body">
                        <div class="mb-4">
                           <h5 class="card-title mb-0">ROI Amount</h5>
                        </div>
                        <div class="row d-flex align-items-center mb-4">
                           <div class="col-8">
                              <h2 class="d-flex align-items-center mb-0">
                                  {!! showAmount($investment->roi_amount) !!}
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
         <div class="col-md-4">
            <div class="row">
         <div class="col-md-12">
            <div class="card card-contract">
         <div class="card-body">
            <h4 class="card-title">Information Overview</h4>
            <ul class="card-contract-features">
                                    <li>Investment ID: <span class="float-right">{{ $investment->investment_no }}</span></li>
                                    @if($investment->investor_type == 'member')
                                       <li>Member: <span class="float-right">{{ $investment->member->fname }} {{ $investment->member->lname }} {{ $investment->member->oname }}</span></li>
                                    @endif
                                    @if($investment->investor_type == 'nonmember')
                                       <li>Member: <span class="float-right">{{ $investment->investor->name }}</span></li>
                                    @endif
                                    <li>Investment Plan: <span class="float-right">{{ $investment->investmentplan->name }}</span></li>
                                    <li>Interest Rate: <span class="float-right">{{ $investment->investmentplan->interest_rate }}% / @if($investment->investmentplan->duration == 'day') DAY @endif @if($investment->investmentplan->duration == 'week') WEEK  @endif @if($investment->investmentplan->duration == 'month') MONTH  @endif</span></li>
                                    <li>Loan Period: <span class="float-right">{{ $investment->loan_term }} @if($investment->investmentplan->duration == 'day') days @endif @if($investment->investmentplan->duration == 'week') weeks  @endif @if($investment->investmentplan->duration == 'month') months  @endif</span></li>
                                    <li>Start Date: <span class="float-right">{{ dateFormat($investment->release_date) }}</span></li>
                                    
                                    <li>End Date: <span class="float-right">{{ dateFormat($investment->end_date) }}</span></li>
                                    <li>Status<span class="float-right">@if($investment->status == 2)
                                 <div class="badge badge-success">Settled</div>
                              @endif
                              @if($investment->status == 1)
                                 <div class="badge badge-warning">Running</div>
                              @endif
                              @if($investment->status == 0)
                              <div class="badge badge-danger">Pending</div>
                              @endif</span></li>
                                 </ul>
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
               <h3 class="card-title">Document</h3>
            </div>
            <div class="float-right">
               <button type="button" class="btn btn-sm btn-theme" data-toggle="modal" data-target="#documentModel"> <i class="fa fa-plus"></i> Add Document
               </button>
               <div class="modal fade" id="documentModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                     <div class="modal-content">                                                
                        <div class="modal-body">
                           <h4 class="card-title mb-4">Add Document</h4>
                           <form action="#" method="POST" id="investmentdocument_form"> 
                              @csrf
                              <input type="hidden" name="investment_id" value="{{ $investment->id }}">
                              <input type="hidden" name="investment_no" value="{{ $investment->investment_no }}">
                              <div class="form-group">
                                <label for="file_name">Document Name</label>
                                 <input type="text" name="file_name" id="file_name" class="form-control" autocomplete="off">
                                 <span class="invalid-feedback"></span>
                              </div>
                              <div class="form-group">
                                 <label for="file">Upload file</label>
                                 <input type="file" name="file" id="file" class="form-control">
                                 <span class="invalid-feedback"></span>
                              </div>
                              <div class="form-group mt-4">
                                 <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
                                 <button type="submit" class="btn btn-sm btn-theme" id="btn_investmentdocument">Upload Document</button>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         @if($documents->count() > 0)
         <div class="table-responsive">
            <table class="table table-sm mb-0">
               <thead>
                  <tr>
                     <th>#</th>
                     <th>File Name</th>
                     <th>File Type</th>
                     <th>Action</th>
                  </tr>
               </thead>
               <tbody>
                  @php $i = 0; @endphp
                  @foreach($documents as $row)
                  @php $i++; @endphp
                  <tr>
                     <th scope="row">{{ $i }}</th>
                     <td><a href="{{ asset('assets/uploads/investments/'. $row->file ) }}" target="_blank">{{ $row->file_name }}</a></td>
                     <td>{{ $row->file_type }}</td>
                     <td>
                        <button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#deleteDocumentModel{{ $row->id }}"> <i class="fa fa-trash"></i></button>
                         <div class="modal fade" id="deleteDocumentModel{{ $row->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                <div class="modal-content border-0">
                                    <div class="modal-body">
                                        <div class="alert alert-fwarning" role="alert">
                                            <i class="fa fa-exclamation-triangle d-block display-4 mt-2 mb-3 text-warning text-center"></i>
                                            <h3 class="text-center">Delete Document {{ $row->file_name }}?</h3>
                                            <form action="#" method="POST" class="delete_investmentdocument_form">
                                              @csrf
                                               <input type="hidden" name="id"  value="{{ $row->id }}">
                                               <div class="form-group text-center mt-3">
                                                   <button type="button" class="btn btn-dark" data-dismiss="modal">No, Cancel</button>
                                                   <button type="submit" class="btn btn-danger delete_investmentdocument">Yes, Delete</button>
                                               </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                     </td>
                  </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
         @else
            <div class="d-flex flex-column align-items-center mt-5">
               <img src="{{ asset('assets/uploads/defaults/nodata.png') }}" width="200">
               <span class="mt-3">No Documents</span>
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
         var url = "{{ route('webmaster.investment.dashboard', $investment->investment_no) }}";
         history.pushState({}, null, url + "?tab=" + tab.substring(1));
      });

      @if(isset($_GET['tab']))
         $('.nav-tabs a[href="#{{ $_GET['tab'] }}"]').tab('show');
      @endif


      $("#investmentdocument_form").submit(function(e) {
      e.preventDefault();
      $("#btn_investmentdocument").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding');
      $("#btn_investmentdocument").prop("disabled", true);
        var formData = new FormData(this);
      $.ajax({
            url:'{{ route('webmaster.investmentdocument.store') }}',
            method: 'post',
            data: formData, 
            processData: false,
            contentType: false,
            dataType: 'json',
          success: function(response){
            if(response.status == 400){
              $.each(response.message, function (key, value) {
                showError(key, value);
              });
              $("#btn_investmentdocument").html('Add Document');
              $("#btn_investmentdocument").prop("disabled", false);
            } else if(response.status == 200){
               $("#investmentdocument_form")[0].reset();
              removeErrors("#investmentdocument_form");
              $("#btn_investmentdocument").html('Add Document');
              $("#btn_investmentdocument").prop("disabled", false);
              setTimeout(function(){
                window.location.reload();
              }, 500);

            }
          }
        });
      });

      $(".delete_investmentdocument_form").submit(function(e) {
        e.preventDefault();
        $(".delete_investmentdocument").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Deleting..');
        $(".delete_investmentdocument").prop("disabled", true);
        $.ajax({
          url:'{{ route('webmaster.investmentdocument.delete') }}',
          method: 'post',
          data: $(this).serialize(),
          dataType: 'json',
          success: function(response) {
            $(".delete_investmentdocument").html('Yes, Delete');
            setTimeout(function(){
               $(".delete_investmentdocument").prop("disabled", false);
               window.location.reload();
            }, 500);
          }
        });
      });
</script>
@endsection
