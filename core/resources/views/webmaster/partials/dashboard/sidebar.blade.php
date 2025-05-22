<div class="az-sidebar">
    <div class="az-sidebar-header">
        <a href="{{ route('webmaster.dashboard') }}" class="az-logo" style="text-transform: uppercase;font-size:15px">
            {{ Session::get('tenant')?->company_name ?? 'Creditt' }}
        </a>
    </div><!-- az-sidebar-header -->
    <div class="az-sidebar-body">
        <ul class="nav">
            <li class="nav-label">Main Menu</li>
            <!-- Superadmin -->
            @if (Auth::guard('webmaster')->user()->hasRole('Superadmin'))
                <li class="nav-item">
                    <a href="{{ route('webmaster.superadmin.index') }}" class="nav-link">
                        <i class="typcn typcn-lock-closed"></i>Superadmin
                    </a>
                </li>
            @endif
            <!-- Home Dashboard -->
            <li class="nav-item">
                <a href="{{ route('webmaster.dashboard') }}" class="nav-link"><i class="typcn typcn-home"></i>Home</a>
            </li>

            <!-- Loan Manager -->
            @if (in_array('loans', $subscribed_modules))
                <li class="nav-item">
                    <a href="" class="nav-link with-sub"><i class="typcn typcn-credit-card"></i>Loan Manager</a>
                    <ul class="nav-sub">
                        <li class="nav-sub-item">
                            <a href="{{ route('webmaster.loan.create') }}" class="nav-sub-link">Create Loan</a>
                        </li>
                        <li class="nav-sub-item">
                            <a href="{{ route('webmaster.loans') }}" class="nav-sub-link">Manage Loans</a>
                        </li>
                        <li class="nav-sub-item">
                            <a href="{{ route('webmaster.myloans') }}" class="nav-sub-link">My Loans</a>
                        </li>
                        <li class="nav-sub-item">
                            <a href="{{ route('webmaster.loanproduct.create') }}" class="nav-sub-link">New Product</a>
                        </li>
                        <li class="nav-sub-item">
                            <a href="{{ route('webmaster.loanproducts') }}" class="nav-sub-link">Loan Products</a>
                        </li>
                        <li class="nav-sub-item">
                            <a href="{{ route('webmaster.loan.calculator') }}" class="nav-sub-link">Loan Calculator</a>
                        </li>
                        <li class="nav-sub-item">
                            <a href="{{ route('webmaster.loanpayment.create') }}" class="nav-sub-link">New Payment</a>
                        </li>
                        <li class="nav-sub-item">
                            <a href="{{ route('webmaster.loanpayments') }}" class="nav-sub-link">Payments List</a>
                        </li>
                    </ul>
                </li><!-- nav-item -->
            @endif

            <!-- Members -->
            <li class="nav-item">
                <a href="" class="nav-link with-sub"><i class="typcn typcn-group"></i>Members</a>
                <ul class="nav-sub">
                    <li class="nav-sub-item">
                        <a href="{{ route('webmaster.member.create') }}" class="nav-sub-link">New Member</a>
                    </li>
                    <li class="nav-sub-item">
                        <a href="{{ route('webmaster.members') }}" class="nav-sub-link">Manage Members</a>
                    </li>
                    <li class="nav-sub-item">
                        <a href="{{ route('webmaster.memberaccount.create') }}" class="nav-sub-link">Create Account</a>
                    </li>
                    <li class="nav-sub-item">
                        <a href="{{ route('webmaster.memberaccounts') }}" class="nav-sub-link">Member Accounts</a>
                    </li>
                </ul>
            </li><!-- nav-item -->

            <!-- Investments -->
            @if (in_array('investments', $subscribed_modules))
                <li class="nav-item">
                    <a href="" class="nav-link with-sub"><i
                            class="typcn typcn-chart-line-outline"></i>Investments</a>
                    <ul class="nav-sub">
                        <li class="nav-sub-item">
                            <a href="{{ route('webmaster.investment.create') }}" class="nav-sub-link">New
                                Investment</a>
                        </li>
                        <li class="nav-sub-item">
                            <a href="{{ route('webmaster.investments') }}" class="nav-sub-link">Manage Investments</a>
                        </li>
                        <li class="nav-sub-item">
                            <a href="{{ route('webmaster.investor.create') }}" class="nav-sub-link">New Investor</a>
                        </li>
                        <li class="nav-sub-item">
                            <a href="{{ route('webmaster.investors') }}" class="nav-sub-link">Manage Investors</a>
                        </li>
                        <li class="nav-sub-item">
                            <a href="{{ route('webmaster.investmentplan.create') }}" class="nav-sub-link">New Plan</a>
                        </li>
                        <li class="nav-sub-item">
                            <a href="{{ route('webmaster.investmentplans') }}" class="nav-sub-link">Manage Plans</a>
                        </li>
                        <li class="nav-sub-item">
                            <a href="{{ route('webmaster.share.create') }}" class="nav-sub-link">Create Shares</a>
                        </li>
                        <li class="nav-sub-item">
                            <a href="{{ route('webmaster.shares') }}" class="nav-sub-link">Manage Shares</a>
                        </li>
                    </ul>
                </li><!-- nav-item -->
            @endif
            <!-- Expenses -->
            <li class="nav-item">
                <a href="" class="nav-link with-sub"><i class="typcn typcn-credit-card"></i>Expenses</a>
                <ul class="nav-sub">
                    <li class="nav-sub-item">
                        <a href="{{ route('webmaster.expense.create') }}" class="nav-sub-link">Create Expense</a>
                    </li>
                    <li class="nav-sub-item">
                        <a href="{{ route('webmaster.expenses') }}" class="nav-sub-link">Manage Expenses</a>
                    </li>
                    <li class="nav-sub-item">
                        <a href="{{ route('webmaster.expensecategories') }}" class="nav-sub-link">Categories</a>
                    </li>
                </ul>
            </li><!-- nav-item -->

            <!-- Funds Manager -->
            @if (in_array('savings', $subscribed_modules))
                <li class="nav-item">
                    <a href="" class="nav-link with-sub"><i class="typcn typcn-credit-card"></i>Funds
                        Manager</a>
                    <ul class="nav-sub">
                        <li class="nav-sub-item">
                            <a href="{{ route('webmaster.saving.create') }}" class="nav-sub-link">New Saving</a>
                        </li>
                        <li class="nav-sub-item">
                            <a href="{{ route('webmaster.savings') }}" class="nav-sub-link">Manage Savings</a>
                        </li>
                        <li class="nav-sub-item">
                            <a href="{{ route('webmaster.accountdeposits') }}" class="nav-sub-link">Deposits</a>
                        </li>
                        <li class="nav-sub-item">
                            <a href="{{ route('webmaster.account.withdraw') }}" class="nav-sub-link">Withdraws</a>
                        </li>
                        <li class="nav-sub-item">
                            <a href="{{ route('webmaster.accounttransfers') }}" class="nav-sub-link">Transfers</a>
                        </li>
                    </ul>
                </li><!-- nav-item -->
            @endif

            <!-- Accounting -->
            @if (in_array('accounting', $subscribed_modules))
                <li class="nav-item">
                    <a href="" class="nav-link with-sub"><i
                            class="typcn typcn-chart-bar-outline"></i>Accounting</a>
                    <ul class="nav-sub">
                        <li class="nav-sub-item">
                            <a href="{{ action([\App\Http\Controllers\Webmaster\AccountingController::class, 'dashboard']) }}"
                                class="nav-sub-link">Over View</a>
                        </li>
                        <li class="nav-sub-item">
                            <a href="{{ action([\App\Http\Controllers\Webmaster\CoaController::class, 'index']) }}"
                                class="nav-sub-link">Chart Of Accounts</a>
                        </li>
                        <li class="nav-sub-item">
                            <a href="{{ action([\App\Http\Controllers\Webmaster\JournalEntryController::class, 'index']) }}"
                                class="nav-sub-link">Journal Entry</a>
                        </li>
                        <li class="nav-sub-item">
                            <a href="{{ action([\App\Http\Controllers\Webmaster\TransferController::class, 'index']) }}"
                                class="nav-sub-link">Transfers</a>
                        </li>
                        <li class="nav-sub-item">
                            <a href="{{ action([\App\Http\Controllers\Webmaster\TransactionController::class, 'index']) }}"
                                class="nav-sub-link">Transactions</a>
                        </li>
                        <li class="nav-sub-item">
                            <a href="{{ action([\App\Http\Controllers\Webmaster\BudgetController::class, 'index']) }}"
                                class="nav-sub-link">Budget</a>
                        </li>
                        <li class="nav-sub-item">
                            <a href="{{ action([\App\Http\Controllers\Webmaster\ReportController::class, 'index']) }}"
                                class="nav-sub-link">Reports</a>
                        </li>
                        <li class="nav-sub-item">
                            <a href="{{ action([\App\Http\Controllers\Webmaster\SettingsAccController::class, 'index']) }}"
                                class="nav-sub-link">Settings</a>
                        </li>
                    </ul>
                </li><!-- nav-item -->
            @endif

            <!-- Assets -->
            @if (in_array('assets', $subscribed_modules))
                <li class="nav-item">
                    <a href="" class="nav-link with-sub"><i class="typcn typcn-business-card"></i>Assets</a>
                    <ul class="nav-sub">
                        <li class="nav-sub-item">
                            <a href="{{ route('webmaster.asset.create') }}" class="nav-sub-link">New Asset</a>
                        </li>
                        <li class="nav-sub-item">
                            <a href="{{ route('webmaster.assets') }}" class="nav-sub-link">Manage Assets</a>
                        </li>
                        <li class="nav-sub-item">
                            <a href="{{ route('webmaster.assetgroup.create') }}" class="nav-sub-link">Create Asset
                                Group</a>
                        </li>
                        <li class="nav-sub-item">
                            <a href="{{ route('webmaster.assetgroups') }}" class="nav-sub-link">Asset Group List</a>
                        </li>
                        <li class="nav-sub-item">
                            <a href="{{ route('webmaster.supplier.create') }}" class="nav-sub-link">New Supplier</a>
                        </li>
                        <li class="nav-sub-item">
                            <a href="{{ route('webmaster.suppliers') }}" class="nav-sub-link">Manage Suppliers</a>
                        </li>
                    </ul>
                </li><!-- nav-item -->
            @endif
            <!-- Branches -->
            <li class="nav-item">
                <a href="" class="nav-link with-sub"><i class="typcn typcn-location"></i>Branches</a>
                <ul class="nav-sub">
                    <li class="nav-sub-item">
                        <a href="{{ route('webmaster.branch.create') }}" class="nav-sub-link">New Branch</a>
                    </li>
                    <li class="nav-sub-item">
                        <a href="{{ route('webmaster.branches') }}" class="nav-sub-link">Manage Branches</a>
                    </li>
                </ul>
            </li><!-- nav-item -->

            <!-- Users -->
            <li class="nav-item">
                <a href="" class="nav-link with-sub"><i class="typcn typcn-user"></i>Users</a>
                <ul class="nav-sub">
                    <li class="nav-sub-item">
                        <a href="{{ route('webmaster.staff.create') }}" class="nav-sub-link">New Staff</a>
                    </li>
                    <li class="nav-sub-item">
                        <a href="{{ route('webmaster.staffs') }}" class="nav-sub-link">Manage Staffs</a>
                    </li>
                    <li class="nav-sub-item">
                        <a href="{{ route('webmaster.branchpositions') }}" class="nav-sub-link">Designation</a>
                    </li>
                </ul>
            </li><!-- nav-item -->

            <!-- Help Desk -->
            <li class="nav-item">
                <a href="" class="nav-link with-sub"><i class="typcn typcn-phone-outline"></i>Help Desk</a>
                <ul class="nav-sub">
                    <li class="nav-sub-item">
                        <a href="{{ route('webmaster.desk.help') }}" class="nav-sub-link">Help</a>
                    </li>
                </ul>
            </li><!-- nav-item -->

            <!-- Reports -->
            <li class="nav-item">
                <a href="" class="nav-link with-sub"><i class="typcn typcn-document"></i>Reports</a>
                <ul class="nav-sub">
                    <li class="nav-sub-item">
                        <a href="{{ route('webmaster.loans.report') }}" class="nav-sub-link">General Loans
                            Report</a>
                    </li>
                    <li class="nav-sub-item">
                        <a href="{{ route('webmaster.loans.report.pending') }}" class="nav-sub-link">Loans
                            Pending</a>
                    </li>
                    <li class="nav-sub-item">
                        <a href="{{ route('webmaster.loans.report.disbursed') }}" class="nav-sub-link">Loans
                            Disbursed</a>
                    </li>
                    <li class="nav-sub-item">
                        <a href="{{ route('webmaster.loans.report.reviewed') }}" class="nav-sub-link">Loans
                            Reviewed</a>
                    </li>
                    <li class="nav-sub-item">
                        <a href="{{ route('webmaster.loans.report.approved') }}" class="nav-sub-link">Loans
                            Approved</a>
                    </li>
                    <li class="nav-sub-item">
                        <a href="{{ route('webmaster.loans.report.rejected') }}" class="nav-sub-link">Loans
                            Rejected</a>
                    </li>
                    <li class="nav-sub-item">
                        <a href="{{ route('webmaster.loans.report.arrear') }}" class="nav-sub-link">Loans in
                            Arrears</a>
                    </li>
                    <li class="nav-sub-item">
                        <a href="{{ route('webmaster.member.report') }}" class="nav-sub-link">Members</a>
                    </li>
                    <li class="nav-sub-item">
                        <a href="{{ route('webmaster.investments.report') }}" class="nav-sub-link">Investments</a>
                    </li>
                    <li class="nav-sub-item">
                        <a href="{{ route('webmaster.expense.report') }}" class="nav-sub-link">Expenses</a>
                    </li>
                    <li class="nav-sub-item">
                        <a href="#" class="nav-sub-link">Savings</a>
                    </li>
                    <li class="nav-sub-item">
                        <a href="{{ action([\App\Http\Controllers\Webmaster\ReportController::class, 'index']) }}"
                            class="nav-sub-link">Accounting</a>
                    </li>
                </ul>
            </li><!-- nav-item -->

            <!-- Settings -->
            <li class="nav-item">
                <a href="" class="nav-link with-sub"><i class="typcn typcn-cog"></i>Settings</a>
                <ul class="nav-sub">
                    <li class="nav-sub-item">
                        <a href="{{ route('webmaster.generalsetting') }}" class="nav-sub-link">General Setting</a>
                    </li>
                    <li class="nav-sub-item">
                        <a href="{{ route('webmaster.fee.create') }}" class="nav-sub-link">New Fee</a>
                    </li>
                    <li class="nav-sub-item">
                        <a href="{{ route('webmaster.fees') }}" class="nav-sub-link">Manage Fees</a>
                    </li>
                    <li class="nav-sub-item">
                        <a href="{{ route('webmaster.role.create') }}" class="nav-sub-link">Roles Management</a>
                    </li>
                    <li class="nav-sub-item">
                        <a href="{{ route('webmaster.roles') }}" class="nav-sub-link">View Roles</a>
                    </li>
                    <li class="nav-sub-item">
                        <a href="{{ route('webmaster.feerange.create') }}" class="nav-sub-link">New Range</a>
                    </li>
                    <li class="nav-sub-item">
                        <a href="{{ route('webmaster.feeranges') }}" class="nav-sub-link">Manage Ranges</a>
                    </li>
                    <li class="nav-sub-item">
                        <a href="{{ route('webmaster.dbbackups') }}" class="nav-sub-link">System Backups</a>
                    </li>
                    <li class="nav-sub-item">
                        <a href="{{ route('webmaster.exchangerates') }}" class="nav-sub-link">Exchange Rates</a>
                    </li>
                </ul>
            </li><!-- nav-item -->
        </ul><!-- nav -->
    </div><!-- az-sidebar-body -->
</div><!-- az-sidebar -->
