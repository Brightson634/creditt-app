
<style>
    table thead tr th {
        color:white !important;
    }
</style>
<div>
    <div class="page-heading__title">
        <ul class="nav nav-tabs" style="background-color:#e3e7ed">
            <li class="nav-item">
                <a class="nav-link active" href="#monthly" data-toggle="tab" title="Monthly Budget" aria-expanded="false"><i
                        class="fas fa-wallet"></i>Monthly Budget</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#quarterly" data-toggle="tab" title="Quarterly Budget" aria-expanded="false"> <i
                        class="fas fa-wallet"></i>Quarterly Budget</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#yearly" data-toggle="tab" title="Yearly Budget" aria-expanded="false"> <i
                        class="fas fa-wallet"></i>Yearly Budget</a>
            </li>
        </ul>
    </div>

    <div class="tab-content">
        <!--monthly-->
        <div class="tab-pane show active" id="monthly">
            <div class="az-content-body">
                <div class="text-right mb-12">
                    <a class="btn btn-sm btn-default"
                        href="{{ route('webmaster.budget.index') }}?financial_year={{ $fy_year }}&format=pdf&view_type=monthly">
                        <i class="fas fa-file-pdf"></i>Export to pdf
                    </a>
                    <a class="btn btn-sm btn-default"
                        href="{{ route('webmaster.budget.index') }}?financial_year={{ $fy_year }}&format=csv&view_type=monthly">
                        <i class="fas fa-file-csv"></i>Export to csv
                    </a>
                    <a class="btn btn-sm btn-default"
                        href="{{ route('webmaster.budget.index') }}?financial_year={{ $fy_year }}&format=excel&view_type=monthly">
                        <i class="fas fa-file-excel"></i>Export to Excel
                    </a>
                </div>
                <div class="table-responsive" style="height: 500px;">
                    <table class="table table-striped table-sticky">
                        <thead>
                            <tr class="bg-green">
                                <th>Account</th>
                                @foreach($months as $k => $m)
                                    <th>{{ \Carbon\Carbon::createFromFormat('m', $k)->format('M') }}</th>
                                @endforeach
                                <th>Total</th>
                            </tr>
                        </thead>
                        @foreach($account_types as $account_type => $account_type_detail)
                        <tbody class="collapsed">
                            <tr class="toggle-tr bg-gray" style="cursor: pointer;">
                                <th colspan="14">
                                    <span class="collapse-icon">
                                        <i class="fas fa-arrow-circle-right"></i>
                                    </span>
                                    {{ $account_type_detail['label'] }}
                                </th>
                            </tr>
                            @php
                                $account_ids = [];
                            @endphp
                            @foreach($accounts->where('account_primary_type', $account_type)->sortBy('name') as $account)
                                @php
                                    $total = 0;
                                    $account_ids[] = $account->id;
                                @endphp
                                <tr class="collapse-tr">
                                    <th>{{ $account->name }}</th>
                                    @foreach($months as $k => $m)
                                        @php
                                            $account_budget = $budget->where('accounting_account_id', $account->id)->first();
                                            $value = !is_null($account_budget) && !is_null($account_budget->$m) ? $account_budget->$m : null;
                                        @endphp
                                        <td>
                                            @if(!is_null($value))
                                                {{ number_format($value, 2) }}
                                                @php $total += $value; @endphp
                                            @endif
                                        </td>
                                    @endforeach
                                    <td>
                                        {{ number_format($total, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                            <tr class="collapse-tr bg-gray">
                                <th>@lang('sale.total')</th>
                                @foreach($months as $k => $m)
                                    <td>{{ number_format($budget->whereIn('accounting_account_id', $account_ids)->sum($m), 2) }}</td>
                                @endforeach
                                <td></td>
                            </tr>
                        </tbody>
                        @endforeach
                        <tfoot class="bg-green">
                            <tr class="table-footer">
                                <th>Grand Total</th>
                                @foreach($months as $k => $m)
                                    <td>{{ number_format($budget->sum($m), 2) }}</td>
                                @endforeach
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <!--quarterly-->
        <div class="tab-pane " id="quarterly">
            <div class="az-content-body">
                <div class="text-right mb-12">
                    <a class="btn btn-sm btn-default"
                        href="{{ route('webmaster.budget.index') }}?financial_year={{ $fy_year }}&format=pdf&view_type=quarterly">
                        <i class="fas fa-file-pdf"></i>Export to pdf
                    </a>
                    <a class="btn btn-sm btn-default"
                        href="{{ route('webmaster.budget.index') }}?financial_year={{ $fy_year }}&format=csv&view_type=quarterly">
                        <i class="fas fa-file-csv"></i>Export to csv
                    </a>
                    <a class="btn btn-sm btn-default"
                        href="{{ route('webmaster.budget.index') }}?financial_year={{ $fy_year }}&format=excel&view_type=quarterly">
                        <i class="fas fa-file-excel"></i>Export to excel
                    </a>
                </div>
                <div class="table-responsive" style="height: 500px; width:100%">
                    <table class="table table-striped table-sticky">
                        <thead>
                            <tr class="bg-green">
                                <th>Account</th>
                                <th>1st Quarter</th>
                                <th>2nd Quarter</th>
                                <th>3rd Quarter</th>
                                <th>4th Quarter</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        @foreach($account_types as $account_type => $account_type_detail)
                        <tbody class="collapsed">
                            <tr class="toggle-tr bg-gray" style="cursor: pointer;">
                                <th colspan="6">
                                    <span class="collapse-icon">
                                        <i class="fas fa-arrow-circle-right"></i>
                                    </span>
                                    {{ $account_type_detail['label'] }}
                                </th>
                            </tr>
                            @php
                                $account_ids = [];
                            @endphp
                            @foreach($accounts->where('account_primary_type', $account_type)->sortBy('name') as $account)
                                @php
                                    $total = 0;
                                    $account_ids[] = $account->id;
                                    $account_budget = $budget->where('accounting_account_id', $account->id)->first();
                                @endphp
                                <tr class="collapse-tr">
                                    <th>{{ $account->name }}</th>
                                    <td>
                                        @if(!is_null($account_budget) && !is_null($account_budget->quarter_1))
                                            @php $total += $account_budget->quarter_1; @endphp
                                            {{ number_format($account_budget->quarter_1, 2) }}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td>
                                        @if(!is_null($account_budget) && !is_null($account_budget->quarter_2))
                                            @php $total += $account_budget->quarter_2; @endphp
                                            {{ number_format($account_budget->quarter_2, 2) }}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td>
                                        @if(!is_null($account_budget) && !is_null($account_budget->quarter_3))
                                            @php $total += $account_budget->quarter_3; @endphp
                                            {{ number_format($account_budget->quarter_3, 2) }}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td>
                                        @if(!is_null($account_budget) && !is_null($account_budget->quarter_4))
                                            @php $total += $account_budget->quarter_4; @endphp
                                            {{ number_format($account_budget->quarter_4, 2) }}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td>
                                        {{ number_format($total, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                            <tr class="collapse-tr bg-gray">
                                <th>Total</th>
                                <td>{{ number_format($budget->whereIn('accounting_account_id', $account_ids)->sum('quarter_1'), 2) }}</td>
                                <td>{{ number_format($budget->whereIn('accounting_account_id', $account_ids)->sum('quarter_2'), 2) }}</td>
                                <td>{{ number_format($budget->whereIn('accounting_account_id', $account_ids)->sum('quarter_3'), 2) }}</td>
                                <td>{{ number_format($budget->whereIn('accounting_account_id', $account_ids)->sum('quarter_4'), 2) }}</td>
                                <td></td>
                            </tr>
                        </tbody>
                        @endforeach
                        <tfoot class="bg-green">
                            <tr class="table-footer">
                                <th>Grand Total</th>
                                <td>{{ number_format($budget->sum('quarter_1'), 2) }}</td>
                                <td>{{ number_format($budget->sum('quarter_2'), 2) }}</td>
                                <td>{{ number_format($budget->sum('quarter_3'), 2) }}</td>
                                <td>{{ number_format($budget->sum('quarter_4'), 2) }}</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <!--yearlyly-->
        <div class="tab-pane " id="yearly">
            <div class="az-content-body">
                <div class="text-right mb-12">
                    <a class="btn btn-sm btn-default"
                        href="{{ route('webmaster.budget.index') }}?financial_year={{ $fy_year }}&format=pdf&view_type=yearly">
                        <i class="fas fa-file-pdf"></i>Export to pdf
                    </a>
                    <a class="btn btn-sm btn-default"
                        href="{{ route('webmaster.budget.index') }}?financial_year={{ $fy_year }}&format=csv&view_type=yearly">
                        <i class="fas fa-file-csv"></i>Export to csv
                    </a>
                    <a class="btn btn-sm btn-default"
                        href="{{ route('webmaster.budget.index') }}?financial_year={{ $fy_year }}&format=excel&view_type=yearly">
                        <i class="fas fa-file-excel"></i>Export to Excel
                    </a>
                </div>
                <div class="table-responsive" style="height: 500px; width:100%;">
                    <table class="table table-striped table-sticky" style="width:100%;">
                        <thead>
                            <tr class="bg-green">
                                <th>
                                    Account
                                </th>
                                <th class="text-center">
                                {{$fy_year}}
                                </th>
                            </tr>
                        </thead>
                        @foreach($account_types as $account_type => $account_type_detail )
                        <tbody class="collapsed">
                            <tr class="toggle-tr bg-gray" style="cursor: pointer;">
                                <th colspan="2">
                                    <span class="collapse-icon">
                                        <i class="fas fa-arrow-circle-right"></i>
                                    </span>
                                    {{$account_type_detail['label']}}
                                </th>
                            </tr>
                            @php
                                $account_ids=[];
                            @endphp
                            @foreach($accounts->where('account_primary_type', $account_type)->sortBy('name')->all() as $account)
                                @php
                                    $account_ids[]=$account->id;
                                    $account_budget = $budget->where('accounting_account_id', $account->id)->first();
                                @endphp
                                <tr class="collapse-tr">
                                    <th>{{$account->name}}</th>
                                    <td>
                                        @if(!is_null($account_budget) && !is_null($account_budget->yearly)) 
                                            {{number_format($account_budget->yearly)}}
                                        @else 
                                            0
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            <tr class="bg-gray collapse-tr">
                                <th>
                                    Total
                                </th>
                                <td>{{number_format($budget->whereIn('accounting_account_id', $account_ids)->sum('yearly'))}}</td>
                            </tr>
                        </tbody>
                        @endforeach
                        <tfoot>
                            <tr class="bg-green">
                                <th>
                                    Grand Total
                                </th>
                                <td>{{number_format($budget->sum('yearly'))}}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
