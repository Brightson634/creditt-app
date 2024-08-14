@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection

@section('content')

@include('webmaster.partials.nav')

<!-- Content Header (Page header) -->
<section class="content">
    <div class="row">
        <div class="col-md-3 col-md-offset-1">
            <div class="form-group">
                {!! Form::label('location_id','Branch' . ':') !!}
                {!! Form::select('location_id', $business_locations, request()->input('location_id'),
                    ['class' => 'form-control select2', 'style' => 'width:100%'])!!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="box box-warning">
                <div class="box-header with-border text-center">
                    <h2 class="box-title">Account Receivable Ageing Report (Summary)</h2>
                </div>
                <div class="box-body">
                    <table class="table table-stripped table-bordered">
                        <thead>
                            <tr>
                                <th>Customer Name</th>
                                <th style="color: #2dce89 !important;">Current</th>
                                <th style="color: #ffd026 !important;">
                                   1 to 30 days
                                </th>
                                <th style="color: #ffa100 !important;">
                                     31 to 60 days
                                </th>
                                <th style="color: #f5365c !important;">
                                    61 to 90 days
                                </th>
                                <th style="color: #FF0000 !important;">
                                     91 days and over
                                </th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total_current = 0;
                                $total_1_30 = 0;
                                $total_31_60 = 0;
                                $total_61_90 = 0;
                                $total_greater_than_90 = 0;
                                $grand_total = 0;
                            @endphp
                            @foreach($report_details as $report)
                                <tr>
                                    @php
                                        $total_current += $report['<1'];
                                        $total_1_30 += $report['1_30'];
                                        $total_31_60 += $report['31_60'];
                                        $total_61_90 += $report['61_90'];
                                        $total_greater_than_90 += $report['>90'];
                                        $grand_total += $report['total_due'];
                                    @endphp
                                    <td>
                                        {{$report['name']}}
                                    </td>
                                    <td>
                                        {{-- @format_currency($report['<1']) --}}
                                        {{$report['<1']}}
                                    </td>
                                    <td>
                                        {{-- @format_currency($report['1_30']) --}}
                                        {{$report['1_30']}}
                                    </td>
                                    <td>
                                        {{-- @format_currency($report['31_60']) --}}
                                        {{$report['31_60']}}
                                    </td>
                                    <td>
                                        {{-- @format_currency($report['61_90']) --}}
                                        {{$report['61_90']}}
                                    </td>
                                    <td>
                                        {{-- @format_currency($report['>90']) --}}
                                        {{$report['>90']}}
                                    </td>
                                    <td>
                                        {{-- @format_currency($report['total_due']) --}}
                                        {{$report['total_due']}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>
                                    Total
                                </th>
                                <td>
                                    {{-- @format_currency($total_current) --}}
                                    {{$total_current}}
                                </td>
                                <td>
                                    {{-- @format_currency($total_1_30) --}}
                                    {{$total_1_30}}
                                </td>
                                <td>
                                    {{-- @format_currency($total_31_60) --}}
                                    {{$total_31_60}}
                                </td>
                                <td>
                                    {{-- @format_currency($total_61_90) --}}
                                    {{$total_61_90}}
                                </td>
                                <td>
                                    {{-- @format_currency($total_greater_than_90) --}}
                                    {{$total_greater_than_90}}
                                </td>
                                <td>
                                    {{-- @format_currency($grand_total) --}}
                                    {{$grand_total}}
                                </td>
                            </tr>
                        </tfoot>
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
        $('#location_id').change( function(){
            if($(this).val()) {
                window.location.href = "{{route('webmaster.accounting.account_receivable_ageing_report')}}?location_id=" + $(this).val();
            } else {
                window.location.href = "{{route('webmaster.accounting.account_receivable_ageing_report')}}";
            }

        });
    });
</script>

@stop
