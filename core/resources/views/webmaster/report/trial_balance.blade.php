@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection

@section('content')
    @include('webmaster.partials.nav')

<section class="content">
<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('date_range_filter', 'Date Filter' . ':') !!}
            {!! Form::text('date_range_filter', null,
                ['placeholder' =>"Select Date Range",
                'class' => 'form-control', 'readonly', 'id' => 'date_range_filter'])!!}
        </div>
    </div>
</div>
    <div class="row">
        <div class="col-md-12">

            <div class="box box-warning">
                <div class="box-header with-border text-center">
                    <h2 class="box-title">Trial Balance</h2>
                    {{-- <p>{{@format_date($start_date)}} ~ {{@format_date($end_date)}}</p> --}}
                    <p>{{$start_date}} ~ {{$end_date}}</p>
                </div>
    
                <div class="box-body">
                    <table class="table table-stripped w-100">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Debit</th>
                                <th>Credit</th>
                            </tr>
                        </thead>
    
                        @php
                            $total_debit = 0;
                            $total_credit = 0;
                        @endphp
    
                        <tbody>
                            @foreach($accounts as $account)
    
                            @php
                                $total_debit += $account->debit_balance;
                                $total_credit += $account->credit_balance;
                            @endphp
    
                                <tr>
                                    <td>{{$account->name}}</td>
                                    <td>
                                        @if($account->debit_balance != 0)
                                            {{-- @format_currency($account->debit_balance) --}}
                                        @endif
                                    </td>
                                    <td>
                                        {{-- @if($account->credit_balance != 0)
                                            @format_currency($account->credit_balance)
                                        @endif --}}
                                        {{$account->credit_balance}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
    
                        <tfooter>
                            <tr>
                                <th>Total</th>
                                {{-- <th class="total_debit">@format_currency($total_debit)</th>
                                <th class="total_credit">@format_currency($total_credit)</th> --}}
                                 <th class="total_debit">{{$total_debit}}</th>
                                <th class="total_credit">{{$total_credit}}</th>
                            </tr>
                        </tfooter>
                    </table>
                </div>
    
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
                $('#date_range_filter').val(start.format('MM/DD/YYYY') + ' ~ ' + end.format('MM/DD/YYYY'));
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
