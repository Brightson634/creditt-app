@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection

@section('css')
<style>
.table-sticky thead,
.table-sticky tfoot {
  position: sticky;
}
.table-sticky thead {
  inset-block-start: 0; /* "top" */
}
.table-sticky tfoot {
  inset-block-end: 0; /* "bottom" */
}
.collapsed .collapse-tr {
    display: none;
}
</style>
@endsection

@section('content')

@include('webmaster.partials.nav')

<!-- Content Header (Page header) -->
<section class="content">
    <div class="row">
        <div class="col-md-3 col-md-offset-1">
            <div class="form-group">
                {!! Form::label('location_id', 'Branch' . ':') !!}
                {!! Form::select('location_id', $business_locations, request()->input('location_id'),
                    ['class' => 'form-control select2', 'style' => 'width:100%'])!!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="box box-warning">
                <div class="box-header with-border text-center">
                    <h2 class="box-title">Account Payable Ageing Details (Details)</h2>
                </div>
                <div class="box-body">
                    <table class="table table-stripped table-bordered">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Transaction Type</th>
                                <th>Reference No</th>
                                <th>Suppliers</th>
                                <th>Due Date</th>
                                <th>Due</th>
                            </tr>
                        </thead>
                        @foreach($report_details as $key => $value)
                        <tbody @if($loop->index != 0) class="collapsed" @endif>
                            <tr class="toggle-tr" style="cursor: pointer;">
                                <th colspan="6">
                                    <span class="collapse-icon">
                                        <i class="fas fa-arrow-circle-right"></i>
                                    </span>
                                    @if($key == 'current')
                                       <span style="color: #2dce89 !important;">Current </span>
                                    @elseif($key == '1_30')
                                        <span style="color: #ffd026 !important;">
                                        1-30 days past due
                                        </span>
                                    @elseif($key == '31_60')
                                        <span style="color: #ffa100 !important;">
                                            31-60 days past due
                                        </span>
                                    @elseif($key == '61_90')
                                        <span style="color: #f5365c !important;">
                                            61-90 days past due
                                        </span>
                                    @elseif($key == '>90')
                                        <span style="color: #FF0000 !important;">
                                            91 days and over past due
                                        </span>
                                    @endif
                                </th>
                            </tr>
                            @php
                                $total=0;
                            @endphp
                            @foreach($value as $details)
                                @php
                                    $total += $details['due'];
                                @endphp
                                <tr class="collapse-tr">
                                    <td>
                                        {{$details['transaction_date']}}
                                    </td>
                                    <td>
                                        @lang( 'lang_v1.purchase' )
                                    </td>
                                    <td>
                                        {{$details['ref_no']}}
                                    </td>
                                    <td>
                                        {{$details['contact_name']}}
                                    </td>
                                    <td>
                                        {{$details['due_date']}}
                                    </td>
                                    <td>
                                        {{-- @format_currency($details['due']) --}}
                                        {{$details['due']}}
                                    </td>
                                </tr>
                            @endforeach
                            <tr class="collapse-tr bg-gray">
                                <th>
                                    @if($key == 'current')
                                        Total for Current
                                    @elseif($key == '1_30')
                                        1-30 total for days past due
                                    @elseif($key == '31_60')
                                        31-60 total for days past due
                                    @elseif($key == '61_90')
                                       61-90 total for days past due
                                    @elseif($key == '>90')
                                         91 total for days and over
                                    @endif
                                </th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                {{-- <th>@format_currency($total)</th> --}}
                                <th>{{$total}}</th>
                            </tr>
                        </tbody>
                        @endforeach
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
                window.location.href = "{{route('webmaster.accounting.account_payable_ageing_details')}}?location_id=" + $(this).val();
            } else {
                window.location.href = "{{route('webmaster.accounting.account_payable_ageing_details')}}";
            }
        });
    });
    $(document).on('click', '.toggle-tr', function(){
        $(this).closest('tbody').toggleClass('collapsed');
        var html = $(this).closest('tbody').hasClass('collapsed') ?
        '<i class="fas fa-arrow-circle-right"></i>' : '<i class="fas fa-arrow-circle-down"></i>';
        $(this).find('.collapse-icon').html(html);
    })
</script>

@stop
