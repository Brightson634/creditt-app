@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection
@section('content')

    <div class="page-heading__title">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tooltip-primary" href="#" title='Add Exchange Rate'><i class="far fa-user"></i>Exchange Rate</a>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link" href="{{ route('webmaster.logosetting') }}"> <i class="far fa-user"></i> Logo
                    Settings</a>
            </li> --}}
        </ul>
        <div class="tab-content">
            <div class="tab-pane show active" id="dashboard">

            </div>
            <div class="tab-pane" id="statement">

            </div>
            <div class="tab-pane" id="information">

            </div>
            <div class="tab-pane" id="group">

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Current Exchange Rates</h2>
                </div>
                <div class="card-body">

                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@endsection
