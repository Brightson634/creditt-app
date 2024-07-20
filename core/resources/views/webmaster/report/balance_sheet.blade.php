@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection

@section('content')

@include('webmaster.partials.nav')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black">Balance Sheet</h1>
</section>

<section class="content">

    <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('date_range_filter', 'Date Range' . ':') !!}
            {!! Form::text('date_range_filter', null,
                ['placeholder' =>'Select Date Range',
                'class' => 'form-control', 'readonly', 'id' => 'date_range_filter']);!!}
        </div>
    </div>

    <div class="col-md-10 col-md-offset-1">
        <div class="box box-warning">
            <div class="box-header with-border text-center">
                <h2 class="box-title">Balance Sheet</h2>
                {{-- <p>{{@format_date($start_date)}} ~ {{@format_date($end_date)}}</p> --}}
                 <p>{{$start_date}} ~ {{$end_date}}</p>
            </div>

            <div class="box-body">

                @php
                    $total_assets = 0;
                    $total_liab_owners = 0;
                @endphp

                    <table class="table table-stripped table-bordered" style="min-height: 300px">
                        <thead>
                            <tr>
                                <th class="success">Assets</th>
                                <th class="warning">Liabilities & Owners Capital</th>
                            </tr>
                        </thead>

                        <tr>
                            <td class="col-md-6">
                                <table class="table">
                                    @foreach($assets as $asset)
                                        @php
                                            $total_assets += $asset->balance
                                        @endphp

                                        <tr>
                                            <th>{{$asset->name}}</th>
                                            {{-- <td>@format_currency($asset->balance)</td> --}}
                                            <td>{{$asset->balance}}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </td>

                            <td class="col-md-6">
                                <table class="table">
                                    @foreach($liabilities as $liability)

                                        @php
                                            $total_liab_owners += $liability->balance
                                        @endphp

                                        <tr>
                                            <th>{{$liability->name}}</th>
                                            {{-- <td>@format_currency($liability->balance)</td> --}}
                                            <td>{{$liability->balance}}</td>
                                        </tr>
                                    @endforeach

                                    @foreach($equities as $equity)
                                        @php
                                            $total_liab_owners += $equity->balance
                                        @endphp

                                        <tr>
                                            <th>{{$equity->name}}</th>
                                            {{-- <td>@format_currency($equity->balance)</td> --}}
                                            <td>{{$equity->balance}}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </td>
                        </tr>

                        <tr>
                            <td class="col-md-6">
                                <span>
                                    <strong>Total Assets: </strong>
                                </span>

                                {{-- <span>@format_currency($total_assets)</span> --}}
                                <span>{{$total_assets}}</span>
                            </td>

                            <td class="col-md-6">
                                <span>
                                    <strong>Total Liabilities & Owners Capital: </strong>
                                </span>

                                {{-- <span>@format_currency($total_liab_owners)</span> --}}
                                 <span>{{$total_liab_owners}}</span>
                            </td>
                        </tr>

                    </table>

            </div>

        </div>
    </div>

</section>

@stop

@section('scripts')

<script type="text/javascript">
    $(document).ready(function(){

        dateRangeSettings.startDate = moment('{{$start_date}}');
        dateRangeSettings.endDate = moment('{{$end_date}}');

        $('#date_range_filter').daterangepicker(
            dateRangeSettings,
            function (start, end) {
                $('#date_range_filter').val(start.format(moment_date_format) + ' ~ ' + end.format(moment_date_format));
                apply_filter();
            }
        );
        $('#date_range_filter').on('cancel.daterangepicker', function(ev, picker) {
            $('#date_range_filter').val('');
            apply_filter();
        });

        function apply_filter(){
            var start = '';
            var end = '';

            if ($('#date_range_filter').val()) {
                start = $('input#date_range_filter')
                    .data('daterangepicker')
                    .startDate.format('YYYY-MM-DD');
                end = $('input#date_range_filter')
                    .data('daterangepicker')
                    .endDate.format('YYYY-MM-DD');
            }

            const urlParams = new URLSearchParams(window.location.search);
            urlParams.set('start_date', start);
            urlParams.set('end_date', end);
            window.location.search = urlParams;
        }
    });

</script>

@stop
