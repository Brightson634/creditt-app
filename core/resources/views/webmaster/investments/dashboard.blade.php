@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection
@section('content')
    <div class="page-heading ">
        <div class="page-heading__title">
            {{-- <h3>{{ $page_title }}</h3> --}}
            <div class="az-content-header d-block d-md-flex">
                <div>
                    <h2 class="az-content-title tx-24 mg-b-5 mg-b-lg-8">Hi, welcome back!</h2>
                    {{-- <p class="mg-b-0">Your sales monitoring dashboard template.</p> --}}
                </div>
                <div class="az-dashboard-header-right">
                    <div>
                        <label class="tx-13">Customer Ratings</label>
                        <div class="az-star">
                            <i class="typcn typcn-star active"></i>
                            <i class="typcn typcn-star active"></i>
                            <i class="typcn typcn-star active"></i>
                            <i class="typcn typcn-star active"></i>
                            <i class="typcn typcn-star"></i>
                            <span>(12,775)</span>
                        </div>
                    </div>
                    {{-- <div>
                 <label class="tx-13">Transactions (Online)</label>
                 <h5>0</h5>
             </div>
             <div>
                 <label class="tx-13">Transactions (Offline)</label>
                 <h5>0</h5>
             </div> --}}
                </div><!-- az-dashboard-header-right -->
            </div><!-- az-content-header -->
        </div>
        <div class="page-heading__title">
            <ul class="nav nav-tabs" style="background-color:#e3e7ed">
                <li class="nav-item">
                    <a class="nav-link active" href="#dashboard" data-toggle="tab" title="Overview" aria-expanded="false"><i
                            class="fas fa-chart-line"></i> Overview</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#documents" data-toggle="tab" title="Documents" aria-expanded="false"> <i
                            class="fas fa-file"></i>Documents</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('webmaster.investment.create') }}" title="New Investment"> <i
                            class="fas fa-plus"></i>New Investment
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="tab-content">
        <div class="tab-pane show active" id="dashboard">
            <div class="az-content-body">
                <div class="card card-dashboard-seven">
                    <div class="card-header">
                        <div class="row row-sm">
                            <div class="col-6 col-md-4 col-xl">
                                <div class="media">
                                    <div><i class="icon ion-ios-calendar"></i></div>
                                    <div class="media-body">
                                        <label>Investment Start Date</label>
                                        <div class="date">
                                            <span>{{ shortendDateFormat($investment->release_date) }}</span> <a
                                                href=""><i class="icon ion-md-arrow-dropdown"></i></a>
                                        </div>
                                    </div>
                                </div><!-- media -->
                            </div>
                            <div class="col-6 col-md-4 col-xl">
                                <div class="media">
                                    <div><i class="icon ion-ios-calendar"></i></div>
                                    <div class="media-body">
                                        <label>Investment End Date</label>
                                        <div class="date">
                                            <span>{{ shortendDateFormat($investment->end_date) }}</span> <a
                                                href=""><i class="icon ion-md-arrow-dropdown"></i></a>
                                        </div>
                                    </div>
                                </div><!-- media -->
                            </div>
                            <div class="col-6 col-md-4 col-xl mg-t-15 mg-xl-t-0">
                                <div class="media">
                                    <div><i class="icon ion-md-person"></i></div>
                                    <div class="media-body">
                                        <label>Investment Type</label>
                                        <div class="date">
                                            <span>{{ ucwords($investment->investor_type) }}</span> <a href=""><i
                                                    class="icon ion-md-arrow-dropdown"></i></a>
                                        </div>
                                    </div>
                                </div><!-- media -->
                            </div>
                            <div class="col-md-4 col-xl mg-t-15 mg-xl-t-0">
                                <div class="media">
                                    <div><i class="icon ion-md-stats"></i></div>
                                    <div class="media-body">
                                        <label>Investment Number</label>
                                        <div class="date">
                                            <span>{{ $investment->investment_no }}</span> <a href=""><i
                                                    class="icon ion-md-arrow-dropdown"></i></a>
                                        </div>
                                    </div>
                                </div><!-- media -->
                            </div>
                        </div><!-- row -->
                    </div><!-- card-header -->
                    <div class="card-body">
                        <div class="row row-sm">
                            <div class="col-6 col-lg-4">
                                <label class="az-content-label">Investment Amount</label>
                                <h2><span>{{ $gs->currency_symbol }}</span>{!! isset($investment->investment_amount) ? formattedAmount($investment->investment_amount) : 0 !!}</h2>
                                <div class="desc up">
                                    <i class="icon ion-md-stats"></i>
                                    <span><strong></strong></span>
                                </div>
                                <span id="compositeline">3,2,4,6,12,14,8,7,14,16,12,7,8,4,3,2,2,5,6,7</span>
                            </div><!-- col -->
                            <div class="col-6 col-lg-4 mg-t-20 mg-lg-t-0">
                                <label class="az-content-label">Interest Amount</label>
                                <h2>
                                    <span>{{ $gs->currency_symbol }}</span>{!! isset($investment->interest_amount) ? formattedAmount($investment->interest_amount) : 0 !!}
                                </h2>
                                <div class="desc down">
                                    <i class="icon ion-md-stats"></i>
                                    <span><strong></strong></span>
                                </div>
                                <span id="compositeline4">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
                            </div><!-- col -->
                            <div class="col-6 col-lg-4 mg-t-20 mg-lg-t-0">
                                <label class="az-content-label">Return On Investment </label>
                                <h2><span>{{ $gs->currency_symbol }}</span>{!! isset($investment->roi_amount) ? formattedAmount($investment->roi_amount) : 0 !!}</h2>
                                <div class="desc down">
                                 <i class="icon ion-md-stats"></i>
                                 <span><strong></strong></span>
                             </div>
                                <span id="compositeline3">5,10,5,20,22,12,15,18,20,15,8,12,22,5,10,12,22,15,16,10</span>
                            </div><!-- col -->
                        </div><!-- row -->
                    </div><!-- card-body -->
                </div>
            </div><!-- az-content-body -->
            <div class="row">
               <div class="col-md-6">
                  <div class="card bd-0">
                     <div class="card-header tx-medium bd-0 tx-white bg-gray-800">
                         INVESTMENT OVERVIEW
                     </div>
                     <div class="card-body bd bd-t-0">
                         <div id='investmentOverview'>

                         </div>
                     </div>
                 </div>
               </div>
               <div class="col-md-6">
                  <div class="card bd-0">
                     <div class="card-header tx-medium bd-0 tx-white bg-gray-800">
                         INVESTMENT INFO OVERVIEW
                     </div><!-- card-header -->
                     <div class="card-body bd bd-t-0">
                         <div class="col-md">
                             <label class="tx-gray-600"> Information Overview</label>
                             <p class="invoice-info-row">
                                 <span>Investment ID:</span>
                                 <span>{{ $investment->investment_no }}</span>
                             </p>
                             <p class="invoice-info-row">
                                 <span>Member:</span>
                                 <span>
                                 @if ($investment->investor_type == 'member')
                                 {{ ucwords(strtolower($investment->member->fname . ' ' . $investment->member->lname . ' ' . $investment->member->oname)) }}
                                 @else
                                 {{ $investment->investor->name }}
                                 @endif
                                 </span>  
                             </p>
                             <p class="invoice-info-row">
                                 <span>Investment Plan:</span>
                                 <span>{{ $investment->investmentplan->name }}</span>
                             </p>
                             <p class="invoice-info-row">
                                 <span>Interest Rate:</span>
                                 <span>{{ $investment->investmentplan->interest_rate }}% per
                                     @if ($investment->investmentplan->duration == 'day')
                                         Day
                                         @endif @if ($investment->investmentplan->duration == 'week')
                                             Week
                                             @endif @if ($investment->investmentplan->duration == 'month')
                                                 Month
                                             @endif
                                 </span>
                             </p>
                             <p class="invoice-info-row">
                                 <span>Investment Period:</span>
                                 <span>{{ $investment->investment_period }} @if ($investment->investmentplan->duration  == 'day')
                                         Days
                                         @endif @if ($investment->investmentplan->duration  == 'week')
                                             Weeks
                                             @endif @if ($investment->investmentplan->duration  == 'month')
                                                 Months
                                             @endif
                                 </span>
                             </p>
                             <p class="invoice-info-row">
                                 <span>Start Date:</span>
                                 <span>{{ dateFormat($investment->release_date) }}</span>
                             </p>
                             <p class="invoice-info-row">
                                 <span>End Date:</span>
                                 <span>{{ dateFormat($investment->end_date) }}</span>
                             </p>
                             <p class="invoice-info-row">
                                 <span>Investment Status:</span>
                                 @if ($investment->status == 2)
                                     <span class="badge badge-success">Disbursed</span>
                                 @endif
                                 @if ($investment->status == 1)
                                     <span class="badge badge-warning">Running</span>
                                 @endif
                                 @if ($investment->status == 0)
                                     <span class="badge badge-danger">Pending</span>
                                 @endif
                             </p>
                         </div><!-- col -->
                     </div><!-- card-body -->
                 </div><!-- card -->
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
                                    <button type="button" class="btn btn-sm btn-theme" data-toggle="modal"
                                        data-target="#documentModel"> <i class="fa fa-plus"></i> Add Document
                                    </button>
                                    <div class="modal fade" id="documentModel" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <h4 class="card-title mb-4">Add Document</h4>
                                                    <form action="#" method="POST" id="investmentdocument_form">
                                                        @csrf
                                                        <input type="hidden" name="investment_id"
                                                            value="{{ $investment->id }}">
                                                        <input type="hidden" name="investment_no"
                                                            value="{{ $investment->investment_no }}">
                                                        <div class="form-group">
                                                            <label for="file_name">Document Name</label>
                                                            <input type="text" name="file_name" id="file_name"
                                                                class="form-control" autocomplete="off">
                                                            <span class="invalid-feedback"></span>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="file">Upload file</label>
                                                            <input type="file" name="file" id="file"
                                                                class="form-control">
                                                            <span class="invalid-feedback"></span>
                                                        </div>
                                                        <div class="form-group mt-4">
                                                            <button type="button" class="btn btn-sm btn-secondary"
                                                                data-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-sm btn-theme"
                                                                id="btn_investmentdocument">Upload Document</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if ($documents->count() > 0)
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
                                            @foreach ($documents as $row)
                                                @php $i++; @endphp
                                                <tr>
                                                    <th scope="row">{{ $i }}</th>
                                                    <td><a href="{{ asset('assets/uploads/investments/' . $row->file) }}"
                                                            target="_blank">{{ $row->file_name }}</a></td>
                                                    <td>{{ $row->file_type }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-xs btn-danger"
                                                            data-toggle="modal"
                                                            data-target="#deleteDocumentModel{{ $row->id }}"> <i
                                                                class="fa fa-trash"></i></button>
                                                        <div class="modal fade"
                                                            id="deleteDocumentModel{{ $row->id }}" tabindex="-1"
                                                            role="dialog" aria-hidden="true">
                                                            <div class="modal-dialog modal-sm modal-dialog-centered"
                                                                role="document">
                                                                <div class="modal-content border-0">
                                                                    <div class="modal-body">
                                                                        <div class="alert alert-fwarning" role="alert">
                                                                            <i
                                                                                class="fa fa-exclamation-triangle d-block display-4 mt-2 mb-3 text-warning text-center"></i>
                                                                            <h3 class="text-center">Delete Document
                                                                                {{ $row->file_name }}?</h3>
                                                                            <form action="#" method="POST"
                                                                                class="delete_investmentdocument_form">
                                                                                @csrf
                                                                                <input type="hidden" name="id"
                                                                                    value="{{ $row->id }}">
                                                                                <div class="form-group text-center mt-3">
                                                                                    <button type="button"
                                                                                        class="btn btn-dark"
                                                                                        data-dismiss="modal">No,
                                                                                        Cancel</button>
                                                                                    <button type="submit"
                                                                                        class="btn btn-danger delete_investmentdocument">Yes,
                                                                                        Delete</button>
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
        $('.nav-tabs a').on('shown.bs.tab', function(event) {
            var tab = $(event.target).attr("href");
            var url = "{{ route('webmaster.investment.dashboard', $investment->investment_no) }}";
            history.pushState({}, null, url + "?tab=" + tab.substring(1));
        });

        @if (isset($_GET['tab']))
            $('.nav-tabs a[href="#{{ $_GET['tab'] }}"]').tab('show');
        @endif


        $("#investmentdocument_form").submit(function(e) {
            e.preventDefault();
            $("#btn_investmentdocument").html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding'
            );
            $("#btn_investmentdocument").prop("disabled", true);
            var formData = new FormData(this);
            $.ajax({
                url: '{{ route('webmaster.investmentdocument.store') }}',
                method: 'post',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 400) {
                        $.each(response.message, function(key, value) {
                            showError(key, value);
                        });
                        $("#btn_investmentdocument").html('Add Document');
                        $("#btn_investmentdocument").prop("disabled", false);
                    } else if (response.status == 200) {
                        $("#investmentdocument_form")[0].reset();
                        removeErrors("#investmentdocument_form");
                        $("#btn_investmentdocument").html('Add Document');
                        $("#btn_investmentdocument").prop("disabled", false);
                        setTimeout(function() {
                            window.location.reload();
                        }, 500);

                    }
                }
            });
        });

        $(".delete_investmentdocument_form").submit(function(e) {
            e.preventDefault();
            $(".delete_investmentdocument").html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Deleting..'
            );
            $(".delete_investmentdocument").prop("disabled", true);
            $.ajax({
                url: '{{ route('webmaster.investmentdocument.delete') }}',
                method: 'post',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    $(".delete_investmentdocument").html('Yes, Delete');
                    setTimeout(function() {
                        $(".delete_investmentdocument").prop("disabled", false);
                        window.location.reload();
                    }, 500);
                }
            });
        });

        //
        $('#compositeline').sparkline('html', {
            lineColor: '#cecece',
            lineWidth: 2,
            spotColor: false,
            minSpotColor: false,
            maxSpotColor: false,
            highlightSpotColor: null,
            highlightLineColor: null,
            fillColor: '#f9f9f9',
            chartRangeMin: 0,
            chartRangeMax: 10,
            width: '100%',
            height: 20,
            disableTooltips: true
        });

        $('#compositeline2').sparkline('html', {
            lineColor: '#cecece',
            lineWidth: 2,
            spotColor: false,
            minSpotColor: false,
            maxSpotColor: false,
            highlightSpotColor: null,
            highlightLineColor: null,
            fillColor: '#f9f9f9',
            chartRangeMin: 0,
            chartRangeMax: 10,
            width: '100%',
            height: 20,
            disableTooltips: true
        });

        $('#compositeline3').sparkline('html', {
            lineColor: '#cecece',
            lineWidth: 2,
            spotColor: false,
            minSpotColor: false,
            maxSpotColor: false,
            highlightSpotColor: null,
            highlightLineColor: null,
            fillColor: '#f9f9f9',
            chartRangeMin: 0,
            chartRangeMax: 10,
            width: '100%',
            height: 20,
            disableTooltips: true
        });

        $('#compositeline4').sparkline('html', {
            lineColor: '#cecece',
            lineWidth: 2,
            spotColor: false,
            minSpotColor: false,
            maxSpotColor: false,
            highlightSpotColor: null,
            highlightLineColor: null,
            fillColor: '#f9f9f9',
            chartRangeMin: 0,
            chartRangeMax: 10,
            width: '100%',
            height: 20,
            disableTooltips: true
        });
        const investmentData = @json($investment);
      //   console.log(investmentData);
        const investmentGraph = () => {
                var investmentAmount = investmentData.investment_amount
                var roiAmount = investmentData.roi_amount
                var interestAmount = investmentData.interest_amount

                var data = [{
                    values: [investmentAmount, interestAmount, roiAmount],
                    labels: ['Investment Amount', 'Interest Amount', 'Return On Investment'],
                    type: 'pie',
                    hoverinfo: 'label+value', // Show label and percentage on hover
                    // textinfo: 'label+value', // Display label and value on slices
                    // textposition: 'outside', // Position text outside the pie slices
                    automargin: true,
                    // marker: {
                    // colors: ['#1f77b4', '#ff7f0e'] // Custom colors for the slices
                    // }
                }];

                // Layout settings
                var layout = {
                    // title: 'Loan Amount Distribution',
                    height: 300,
                    showlegend: true, // Display legend
                    legend: {
                        x: 1,
                        y: 0.5,
                        orientation: 'v' // Vertical legend
                    },
                    margin: {
                        l: 10,
                        r: 10,
                        b: 10,
                        t: 10,
                        pad: 4
                    },
                    autosize: true,
                    responsive: true
                };

                // Configuration settings
                var config = {
                    responsive: true, // Make chart responsive
                    displayModeBar: true, // Show mode bar with zoom/pan options
                    displaylogo: false, // Remove Plotly logo
                    scrollZoom: true // Enable scroll zooming
                };

                Plotly.newPlot('investmentOverview', data, layout, config);

                // Resize chart on window resize
                window.onresize = function() {
                    Plotly.Plots.resize('investmentOverview');
                };

            }
            investmentGraph()
    </script>
 
@endsection
