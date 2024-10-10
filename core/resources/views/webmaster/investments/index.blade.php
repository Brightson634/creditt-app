@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection
@section('content')
    <div class="page-heading ">
        <div class="page-heading__title">
            {{-- <h3>{{ $page_title }}</h3> --}}
        </div>
        <div class="az-dashboard-nav">
            <nav class="nav">

                <a class="nav-link active" data-toggle="tab" href="#memberinvestments" role='tab'
                    aria-controls="statements">Member</a>
                <a class="nav-link" data-toggle="tab" href="#nonmemberinvestments" role='tab' aria-controls="information"
                    aria-selected="false">Non Member</a>
                <a class="nav-link" href="{{ route('webmaster.investment.create') }}">New Investment</a>
                <a class="nav-link" data-toggle="tab" href="#">More</a>
            </nav>
        </div>
    </div>
    <!-- Tab content -->
    <div class="tab-content" id="myTabContent">
        <!--member-->
        <div class="tab-pane fade show active" id="memberinvestments" role="tabpanel"
            aria-labelledby="memberinvestments-tab">
            <div class="row">
                <div class="col-xl-12 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            @if ($data['memberinvestments']->count() > 0)
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
                                                @foreach ($data['memberinvestments'] as $row)
                                                    @php $i++; @endphp
                                                    <tr>
                                                        <th scope="row">{{ $i }}</th>
                                                        <td><a
                                                                href="{{ route('webmaster.investment.dashboard', $row->investment_no) }}">{{ $row->investment_no }}</a>
                                                        </td>
                                                        <td>{{ $row->member->fname }} {{ $row->member->lname }}</td>
                                                        <td>{!! showAmount($row->investment_amount) !!}</td>
                                                        <td>{!! showAmount($row->interest_amount) !!}</td>
                                                        <td>{!! showAmount($row->roi_amount) !!}</td>
                                                        <td>{{ formatDate($row->end_date) }}</td>
                                                        <td>
                                                            @can('edit_investments')
                                                                <a href="{{ route('webmaster.investment.edit', $row->id) }}"
                                                                    class="btn btn-xs btn-dark"> <i class="far fa-edit"></i></a>
                                                            @endcan
                                                            @can('delete_investments')
                                                            <form
                                                                action="{{ route('webmaster.investment.destroy', $row->id) }}"
                                                                method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-xs btn-dark">
                                                                    <i class="fas fa-trash"></i> Delete
                                                                </button>
                                                            </form>
                                                            @endcan
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
        <!--non member-->
        <div class="tab-pane fade" id="nonmemberinvestments" role="tabpanel" aria-labelledby="nonmemberinvestments-tab">
            <div class="row">
                <div class="col-xl-12 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <div class="clearfix mb-3">
                                <div class="float-left">
                                    <h3 class="card-title">{{ $page_title }}</h3>
                                </div>
                            </div>
                            @if ($data['nonmemberinvestments']->count() > 0)
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
                                                @foreach ($data['nonmemberinvestments'] as $row)
                                                    @php $i++; @endphp
                                                    <tr>
                                                        <th scope="row">{{ $i }}</th>
                                                        <td><a
                                                                href="{{ route('webmaster.investment.dashboard', $row->investment_no) }}">{{ $row->investment_no }}</a>
                                                        </td>
                                                        <td>{{ $row->investor->name }}</td>
                                                        <td>{!! showAmount($row->investment_amount) !!}</td>
                                                        <td>{!! showAmount($row->interest_amount) !!}</td>
                                                        <td>{!! showAmount($row->roi_amount) !!}</td>
                                                        <td>{{ formatDate($row->date) }}</td>
                                                        <td>
                                                            <a href="#{{ route('webmaster.investment.edit', $row->id) }}"
                                                                class="btn btn-xs btn-dark"> <i class="far fa-edit"></i></a>
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

        $('.nav-tabs a').on('shown.bs.tab', function(event) {
            var tab = $(event.target).attr("href");
            var url = "{{ route('webmaster.investments') }}";
            history.pushState({}, null, url + "?tab=" + tab.substring(1));
        });
        @if (isset($_GET['tab']))
            $('.nav-tabs a[href="#{{ $_GET['tab'] }}"]').tab('show');
        @endif
    </script>
@endsection
