@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12 mx-auto">
            <div class="container">
                <ul class="nav nav-tabs" id="myTab" role="tablist" style="display:block;">
                    <li class="nav-item">
                        <a class="nav-link active" id="default-currency-tab" data-toggle="tab" href="#default-currency"
                            role="tab" aria-controls="default-currency" aria-selected="true">Default Currency</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="exchange-rates-tab" data-toggle="tab" href="#exchange-rates" role="tab"
                            aria-controls="exchange-rates" aria-selected="false">Exchange Rates</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="default-currency" role="tabpanel"
                        aria-labelledby="default-currency-tab">
                        <p class="mt-3">Content for Default Currency goes here.</p>
                    </div>
                    <div class="tab-pane fade" id="exchange-rates" role="tabpanel" aria-labelledby="exchange-rates-tab">
                        <p class="mt-3">Content for Exchange Rates goes here.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@endsection
