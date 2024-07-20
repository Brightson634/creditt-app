@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection

@section('content')
    @include('webmaster.partials.nav')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black">Reports</h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Trial Balance</h3>
                </div>

                <div class="box-body">
                   <p>A trial balance displays summary of all ledger balances, and helps in checking whether the transactions are correct and balanced.</p>
                    <br/>
                    <a href="{{route('webmaster.accounting.trialBalance')}}" class="tw-dw-btn tw-dw-btn-primary tw-text-white tw-dw-btn-sm pt-2">View Report</a>
                </div>

            </div>
        </div>

        <div class="col-md-6">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Ledger Report</h3>
                </div>

                <div class="box-body">
                <p>The ledger report contains the classified and detailed information of all the individual accounts including the debit and credit aspects.</p>
                    <br/>
                    <a @if($ledger_url) href="{{$ledger_url}}" @else onclick="alert(' @lang( 'accounting::lang.ledger_add_account') ')" @endif class="tw-dw-btn tw-dw-btn-primary tw-text-white tw-dw-btn-sm pt-2">View Report</a>
                </div>

            </div>
        </div>

        <div class="col-md-6">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Balance Sheet</h3>
                </div>

                <div class="box-body">
                   <p>This report gives you an immediate status of your accounts at a specified date. You can call it a "Snapshot" view of the current position (day) of the financial year.</p>
                    <br/>
                    <a href="{{route('webmaster.accounting.balanceSheet')}}" class="tw-dw-btn tw-dw-btn-primary tw-text-white tw-dw-btn-sm pt-2">View Report</a>
                </div>

            </div>
        </div>

        <div class="col-md-6">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Account Receivable Ageing Report(Summary)</h3>
                </div>
                <div class="box-body">
                    <p>This report shows details of all the sales pending invoices in mentioned days range as per the due date.</p>
                    <br/>
                    <a href="{{route('webmaster.accounting.account_receivable_ageing_report')}}"
                    class="tw-dw-btn tw-dw-btn-primary tw-text-white tw-dw-btn-sm pt-2">View Report</a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Account Payable Ageing Report(Summary)</h3>
                </div>
                <div class="box-body">
                   <p>This report shows summary of all the purchase pending invoices in mentioned days range as per the due date.</p>
                    <br/>
                    <a href="{{route('webmaster.accounting.account_payable_ageing_report')}}"
                    class="tw-dw-btn tw-dw-btn-primary tw-text-white tw-dw-btn-sm pt-2">View Report</a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Account Receivable Ageing Details (Details)</h3>
                </div>
                <div class="box-body">
                <p>This report shows details of all the sales pending invoices in mentioned days range as per the due date.</p>
                    <a href="{{route('webmaster.accounting.account_receivable_ageing_details')}}"
                    class="tw-dw-btn tw-dw-btn-primary tw-text-white tw-dw-btn-sm pt-2">View Report</a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Account Payable Ageing Details (Details)</h3>
                </div>
                <div class="box-body">
                    <p>This report shows details of all the purchase pending invoices in mentioned days range as per the due date.</p>
                    <br/>
                    <a href="{{route('webmaster.accounting.account_payable_ageing_details')}}"
                    class="tw-dw-btn tw-dw-btn-primary tw-text-white tw-dw-btn-sm pt-2">View Report</a>
                </div>
            </div>
        </div>

    </div>
</section>

@stop
