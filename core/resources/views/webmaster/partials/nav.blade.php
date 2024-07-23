   <link href="{{ asset('assets/backend/css/vendor.css') }}" rel="stylesheet" type="text/css" />
 <style>
        .modal-backdrop {
            position: relative !important;
        }
    </style>
<section class="no-print">
    <nav class="navbar-default tw-transition-all tw-duration-5000 tw-shrink-0 tw-rounded-2xl tw-m-[16px] tw-border-2 !tw-bg-white">
        <div class="container-fluid" style="padding-left:15px;padding-right:15px;margin-left:auto;margin-right:auto; display:block;">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false" style="margin-top: 3px; margin-right: 3px;">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{action([\App\Http\Controllers\Webmaster\AccountingController::class, 'dashboard'])}}"><i class="fas fa fa-broadcast-tower"></i>Accounting</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav" style='display:block;'>
                    {{-- @if(auth()->user()->can('accounting.manage_accounts')) --}}
                        <li @if(request()->segment(2) == 'chart-of-accounts') class="active" @endif><a href="{{action([\App\Http\Controllers\Webmaster\CoaController::class, 'index'])}}">Chart Of Accounts</a></li>
                    {{-- @endif --}}

                    {{-- @if(auth()->user()->can('accounting.view_journal')) --}}
                        <li @if(request()->segment(2) == 'journal-entry') class="active" @endif><a href="{{action([\App\Http\Controllers\Webmaster\JournalEntryController::class, 'index'])}}">Journal Entry</a></li>
                    {{-- @endif --}}

                    @if(auth()->user()->can('accounting.view_transfer'))
                        <li @if(request()->segment(2) == 'transfer') class="active" @endif>
                            <a href="{{action([\App\Http\Controllers\Webmaster\TransferController::class, 'index'])}}">
                                Transfer
                            </a>
                        </li>
                    @endif

                    <li @if(request()->segment(2) == 'transactions') class="active" @endif><a href="{{action([\App\Http\Controllers\Webmaster\TransactionController::class, 'index'])}}">Transactions</a></li>

                    {{-- @if(auth()->user()->can('accounting.manage_budget')) --}}
                        <li @if(request()->segment(2) == 'budget') class="active" @endif>
                            <a href="{{action([\App\Http\Controllers\Webmaster\BudgetController::class, 'index'])}}">
                                Budgets
                            </a>
                        </li>
                    {{-- @endif --}}
                    {{-- @if(auth()->user()->can('accounting.view_reports')) --}}
                    <li @if(request()->segment(2) == 'reports') class="active" @endif><a href="{{action([\App\Http\Controllers\Webmaster\ReportController::class, 'index'])}}">
                        Reports
                    </a></li>
                    {{-- @endif --}}

                    <li @if(request()->segment(2) == 'settings') class="active" @endif><a href="{{action([\App\Http\Controllers\Webmaster\SettingsAccController::class, 'index'])}}">Settings</a></li>
                </ul>

            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</section>
