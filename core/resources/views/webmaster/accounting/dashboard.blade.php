@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection

@section('content')
    @include('webmaster.partials.nav')

    <section class="content">
        <div class="row">
            <div class="col-md-12">

                <div class="form-group pull-right">
                        <div class="input-group">
                        <button type="button" class="tw-dw-btn tw-dw-btn-primary tw-text-white tw-dw-btn-sm" id="dashboard_date_filter">
                            <span>
                            <i class="fa fa-calendar"></i>Date Filter
                            </span>
                            <i class="fa fa-caret-down"></i>
                        </button>
                        </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @component('webmaster.components.widget', ['class' => 'box-primary',
                'title' =>'Chart Of Accounts Overview'])
                    <div class="col-md-4">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Account Type</th>
                                    <th>Current Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($account_types as $k => $v)
                                    @php
                                        $bal = 0;
                                        foreach($coa_overview as $overview) {
                                            if($overview->account_primary_type==$k && !empty($overview->balance)) {
                                                $bal = (float)$overview->balance;
                                            }
                                        }
                                    @endphp

                                    <tr>
                                        <td>
                                            {{$v['label']}}

                                            {{-- Suffix CR/DR as per value --}}
                                            @if($bal < 0)
                                                {{ (in_array($v['label'], ['Asset', 'Expenses']) ? ' (CR)' : ' (DR)') }}
                                            @endif
                                        </td>
                                        <td>
                                            {{@number_format(abs($bal),2)}}
                                        </td>
                                    </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-8">
                        {!! $coa_overview_chart->container() !!}
                    </div>
                @endcomponent
            </div>
        </div>

        <div class="row">
            @foreach($all_charts as $key => $chart)
            <div class="col-md-6">
                @component('webmaster.components.widget', ['class' => 'box-primary',
                'title' => $key])
                {!! $chart->container() !!}
                @endcomponent
            </div>
            @endforeach
        </div>
    </section>
@stop

@section('scripts')
{!! $coa_overview_chart->script() !!}
@foreach($all_charts as $key => $chart)
{!! $chart->script() !!}
<script type="text/javascript">
    //   var dateRangeSettings = {
    //         locale: {
    //             format: 'YYYY-MM-DD',
    //             applyLabel: 'Apply',
    //             cancelLabel: 'Cancel',
    //             fromLabel: 'From',
    //             toLabel: 'To',
    //             customRangeLabel: 'Custom',
    //             weekLabel: 'W',
    //             daysOfWeek: moment.weekdaysMin(),
    //             monthNames: moment.monthsShort(),
    //             firstDay: 1
    //         },
    //         startDate: moment('{{$start_date}}', 'YYYY-MM-DD'),
    //         endDate: moment('{{$end_date}}', 'YYYY-MM-DD')
    //     };
    $(document).ready( function(){
        // const charts=@json($all_charts);
        // console.log(charts);

        dateRangeSettings.startDate = moment('{{$start_date}}', 'YYYY-MM-DD');
        dateRangeSettings.endDate = moment('{{$end_date}}', 'YYYY-MM-DD');
        $('#dashboard_date_filter').daterangepicker(dateRangeSettings, function(start, end) {
            $('#dashboard_date_filter span').html(
                start.format(moment_date_format) + ' ~ ' + end.format(moment_date_format)
            );

            var start = $('#dashboard_date_filter')
                    .data('daterangepicker')
                    .startDate.format('YYYY-MM-DD');

            var end = $('#dashboard_date_filter')
                    .data('daterangepicker')
                    .endDate.format('YYYY-MM-DD');
            var url = "{{action([\App\Http\Controllers\Webmaster\AccountingController::class, 'dashboard'])}}?start_date=" + start + '&end_date=' + end;

            window.location.href = url;
        });
    });
</script>
@endforeach

@stop
