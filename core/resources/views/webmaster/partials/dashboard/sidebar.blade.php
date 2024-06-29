    <div class="az-iconbar" >
        <a href="{{ route('webmaster.dashboard') }}" class="az-iconbar-logo"><i
                class="typcn typcn-chart-bar-outline"></i></a>
        <nav class="nav">
            <a href="#asideDashboard" class="nav-link active"><i class="typcn typcn-device-laptop"></i></a>
            <a href="#loanManager" class="nav-link"><i class="typcn typcn-credit-card"></i></a>
            <a href="#membersElement" class="nav-link"><i class="typcn typcn-group"></i></a>
            <a href="#investmentElement" class="nav-link"><i class="typcn typcn-chart-line-outline"></i></a>
            <a href="#expenseElement" class="nav-link"><i class="typcn typcn-credit-card"></i></a>
            <a href="#savingElement" class="nav-link"><i class="typcn typcn-home"></i></a>
            <a href="#accountingElement" class="nav-link"><i class="typcn typcn-chart-bar-outline"></i></a>
            <a href="#assetElement" class="nav-link"><i class="typcn typcn-business-card"></i></a>
            <a href="#branchElement" class="nav-link"><i class="typcn typcn-location"></i></a>
            <a href="#userElement" class="nav-link"><i class="typcn typcn-user"></i></a>
            <a href="#settingElement" class="nav-link"><i class="typcn typcn-cog"></i></a>
        </nav>
        {{-- <div class="az-iconbar-bottom">
            <a href="" class="az-iconbar-help"><i class="far fa-question-circle"></i></a>
            <a href="" class="az-img-user online"><img src="https://via.placeholder.com/500" alt=""></a>
        </div><!-- az-iconbar-bottom --> --}}
    </div><!-- az-iconbar -->
    <div class="az-iconbar-aside" style="width:150px;">
        <div class="az-iconbar-header">
            <a href="{{ route('webmaster.dashboard') }}" class="az-logo"><img
                    src="{{ asset('assets/uploads/generals/' . $gs->logo) }}" width='100px'></a></a>
            <a href="" class="az-iconbar-toggle-menu">
                <i class="icon ion-md-arrow-back"></i>
                <i class="icon ion-md-close"></i>
            </a>
        </div><!-- az-iconbar-header -->
        <div class="az-iconbar-body">
            <div id="asideDashboard" class="az-iconbar-pane">
                <h6 class="az-iconbar-title">Dashboard</h6>

                <ul class="nav">
                    <li class="nav-item"><a href="{{ route('webmaster.dashboard') }}" class="nav-link">Home</a></li>
                </ul>
            </div>
            <div id="loanManager" class="az-iconbar-pane">
                <h6 class="az-iconbar-title">Loans</h6>
                <ul class="nav">
                    <li class="nav-item"><a href="{{ route('webmaster.loan.create') }}" class="nav-link">Create Loan</a>
                    </li>
                    <li class="nav-item"><a href="{{ route('webmaster.loans') }}" class="nav-link">Manage Loans</a></li>
                    <li class="nav-item"><a href="{{ route('webmaster.myloans') }}" class="nav-link">My Loans</a>
                    <li class="nav-item"><a href="{{ route('webmaster.loanproduct.create') }}" class="nav-link">New
                            Product</a></li>
                    <li class="nav-item"><a href="{{ route('webmaster.loanproducts') }}" class="nav-link">Loan
                            Products</a></li>
                    <li class="nav-item"><a href="{{ route('webmaster.loanpayment.create') }}" class="nav-link">New
                            Payment</a></li>
                    <li class="nav-item"><a href="{{ route('webmaster.loanpayments') }}" class="nav-link">Payments
                            List</a></li>
                </ul>
            </div><!-- az-iconbar-pane -->
            <div id="membersElement" class="az-iconbar-pane">
                <h6 class="az-iconbar-title">Members</h6>
                <ul class="nav">
                    <li class="nav-item"><a href="{{ route('webmaster.member.create') }}" class="nav-link">New
                            Member</a></li>
                    <li class="nav-item"><a href="{{ route('webmaster.members') }}" class="nav-link">Manage Members</a>
                    </li>
                    <li class="nav-item"><a href="{{ route('webmaster.memberaccount.create') }}"
                            class="nav-link">Create Account</a></li>
                    <li class="nav-item"><a href="{{ route('webmaster.memberaccounts') }}" class="nav-link">Member
                            Accounts</a></li>
                </ul>
            </div><!-- az-iconbar-pane -->
            <div id="investmentElement" class="az-iconbar-pane">
                <h6 class="az-iconbar-title">Investments</h6>
                <ul class="nav">
                    <li class='nav-item'><a href="{{ route('webmaster.investment.create') }}" class="nav-link">New
                            Investment</a></li>
                    <li class='nav-item'><a href="{{ route('webmaster.investments') }}" class="nav-link">Manage
                            Investments</a></li>
                    <li class='nav-item'><a href="{{ route('webmaster.investor.create') }}" class="nav-link">New
                            Investor</a></li>
                    <li class='nav-item'><a href="{{ route('webmaster.investors') }}" class="nav-link">Manage
                            Investors</a></li>
                    <li class='nav-item'><a href="{{ route('webmaster.investmentplan.create') }}"
                            class="nav-link">New Plan</a></li>
                    <li class='nav-item'><a href="{{ route('webmaster.investmentplans') }}" class="nav-link">Manage
                            Plans</a></li>
                    <li class='nav-item'><a href="{{ route('webmaster.share.create') }}" class="nav-link">Create
                            Shares</a></li>
                    <li class='nav-item'><a href="{{ route('webmaster.shares') }}" class="nav-link">Manage
                            Shares</a></li>
                </ul>
            </div><!-- az-iconbar-pane -->
            <div id="expenseElement" class="az-iconbar-pane">
                <h6 class="az-iconbar-title">Expenses</h6>
                <ul class="nav">
                    <li class='nav-item'><a href="{{ route('webmaster.expense.create') }}" class="nav-link">Create
                            Expense</a></li>
                    <li class='nav-item'><a href="{{ route('webmaster.expenses') }}" class="nav-link">Manage
                            Expenses</a></li>
                    <li class='nav-item'><a href="{{ route('webmaster.expensecategories') }}"
                            class="nav-link">Categories</a></li>
                </ul>
            </div><!-- az-iconbar-pane -->
            <div id="savingElement" class="az-iconbar-pane">
                <h6 class="az-iconbar-title">Savings</h6>
                <ul class="nav">
                    <li class='nav-item'><a href="{{ route('webmaster.saving.create') }}" class="nav-link">New
                            Saving</a></li>
                    <li class='nav-item'><a href="{{ route('webmaster.savings') }}" class="nav-link">Manage
                            Savings</a></li>
                </ul>
            </div><!-- az-iconbar-pane -->
            <div id="accountingElement" class="az-iconbar-pane">
                <h6 class="az-iconbar-title">Accounting</h6>
                <ul class="nav">
                    <li class='nav-item'><a href="{{ route('webmaster.chartofaccounts') }}" class="nav-link">Chart
                            Of Accounts</a></li>
                    <li class='nav-item'><a href="{{ route('webmaster.chartofaccount.create') }}"
                            class="nav-link">New Account</a></li>
                    <li class='nav-item'><a href="{{ route('webmaster.accounttypes') }}" class="nav-link">Account
                            Types</a></li>
                    <li class='nav-item'><a href="{{ route('webmaster.accounttransfers') }}"
                            class="nav-link">Account Transfers</a></li>
                    <li class='nav-item'><a href="{{ route('webmaster.accountdeposits') }}" class="nav-link">Account
                            Deposits</a></li>
                    <li class='nav-item'><a href="{{ route('webmaster.journalentry.create') }}" class="nav-link">New
                            Journal Entry</a></li>
                    <li class='nav-item'><a href="{{ route('webmaster.journalentries') }}" class="nav-link">Journal
                            Entries</a></li>
                </ul>
            </div><!-- az-iconbar-pane -->
            <div id="assetElement" class="az-iconbar-pane">
                <h6 class="az-iconbar-title">Assets</h6>
                <ul class="nav">
                    <li class='nav-item'><a href="{{ route('webmaster.asset.create') }}" class="nav-link">New
                            Asset</a></li>
                    <li class='nav-item'><a href="{{ route('webmaster.assets') }}" class="nav-link">Manage
                            Assets</a></li>
                    <li class='nav-item'><a href="{{ route('webmaster.assetgroup.create') }}"
                            class="nav-link">Create Asset Group</a></li>
                    <li class='nav-item'><a href="{{ route('webmaster.assetgroups') }}" class="nav-link">Asset Group
                            List</a></li>
                    <li class='nav-item'><a href="{{ route('webmaster.supplier.create') }}" class="nav-link">New
                            Supplier</a></li>
                    <li class='nav-item'><a href="{{ route('webmaster.suppliers') }}" class="nav-link">Manage
                            Suppliers</a></li>
                </ul>
            </div><!-- az-iconbar-pane -->
            <div id="branchElement" class="az-iconbar-pane">
                <h6 class="az-iconbar-title">Branches</h6>
                <ul class="nav">
                    <li class='nav-item'><a href="{{ route('webmaster.branch.create') }}" class="nav-link">New
                            Branch</a></li>
                    <li class='nav-item'><a href="{{ route('webmaster.branches') }}" class="nav-link">Manage
                            Branches</a></li>
                </ul>
            </div><!-- az-iconbar-pane -->
            <div id="userElement" class="az-iconbar-pane">
                <h6 class="az-iconbar-title">Users</h6>
                <ul class="nav">
                    <li class='nav-item'><a href="{{ route('webmaster.staff.create') }}" class="nav-link">New
                            Staff</a></li>
                    <li class='nav-item'><a href="{{ route('webmaster.staffs') }}" class="nav-link">Manage
                            Staffs</a></li>
                    <li class='nav-item'><a href="{{ route('webmaster.role.create') }}" class="nav-link">New
                            Role</a></li>
                    <li class='nav-item'><a href="{{ route('webmaster.roles') }}" class="nav-link">Manage Roles</a>
                    </li>
                    <li class='nav-item'><a href="{{ route('webmaster.branchpositions') }}"
                            class="nav-link">Designation</a></li>
                </ul>
            </div><!-- az-iconbar-pane -->
            <div id="settingElement" class="az-iconbar-pane">
                <h6 class="az-iconbar-title">Settings</h6>
                <ul class="nav">
                    <!-- <li><a href="{{ route('webmaster.logosetting') }}">Logo Setting</a></li>
                     <li><a href="{{ route('webmaster.emailsetting') }}">Email Setting</a></li> -->
                    <li class='nav-item'><a href="{{ route('webmaster.fee.create') }}" class="nav-link">New Fee</a>
                    </li>
                    <li class='nav-item'><a href="{{ route('webmaster.fees') }}" class="nav-link">Manage Fees</a>
                    </li>
                    <li class='nav-item'><a href="{{ route('webmaster.feerange.create') }}" class="nav-link">New
                            Range</a></li>
                    <li class='nav-item'><a href="{{ route('webmaster.feeranges') }}" class="nav-link">Manage
                            Ranges</a></li>
                    <li class='nav-item'><a href="{{ route('webmaster.dbbackups') }}" class="nav-link">System
                            Backups</a></li>
                </ul>
            </div><!-- az-iconbar-pane -->
        </div><!-- az-iconbar-body -->
    </div><!-- az-iconbar-aside -->
