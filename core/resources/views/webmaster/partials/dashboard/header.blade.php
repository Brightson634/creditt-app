<div class="az-header">
    <div class="container">
        <div class="az-header-left">
        <div class="logo" style='background-color:black'>
            <a href="{{ route('webmaster.dashboard') }}" class="az-logo"><span></span><img
                    src="{{ asset('assets/uploads/generals/' . $gs->logo) }}"></a>
            <a href="" id="azMenuShow" class="az-header-menu-icon d-lg-none"><span></span></a>
         </div>
        </div><!-- az-header-left -->
        <div class="az-header-menu"style='margin-left:10px'>
            <div class="az-header-menu-header">
                <a href="{{ route('webmaster.dashboard') }}" class="az-logo"><span></span> CREDITT</a>
                <a href="" class="close">&times;</a>
            </div><!-- az-header-menu-header -->
            <ul class="nav">
                <li class="nav-item active show">
                    <a href="" class="nav-link"><i class="typcn typcn-chart-area-outline"></i>
                        Dashboard</a>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link with-sub"><i class="typcn typcn-folder"></i> Loan Manager</a>
                    <nav class="az-menu-sub">
                        <a href="{{ route('webmaster.loan.create') }}" class="nav-link">Create Loan</a>
                        <a href="{{ route('webmaster.loans') }}" class="nav-link">Manage Loans</a>
                        <a href="{{ route('webmaster.myloans') }}" class="nav-link">My Loans</a>
                        <a href="{{ route('webmaster.loanproduct.create') }}" class="nav-link">New Product</a>
                        <a href="{{ route('webmaster.loanproducts') }}" class="nav-link">Loan Products</a>
                        <a href="{{ route('webmaster.loanpayment.create') }}" class="nav-link">New Payment</a>
                        <a href="{{ route('webmaster.loanpayments') }}" class="nav-link">Payments List</a>
                    </nav>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link with-sub"><i class="typcn typcn-group"></i>Members</a>
                    <nav class="az-menu-sub">
                        <a href="{{ route('webmaster.member.create') }}" class="nav-link">New Member</a>
                        <a href="{{ route('webmaster.members') }}" class="nav-link">Manage Members</a>
                        <a href="{{ route('webmaster.memberaccount.create') }}" class="nav-link">Create Account</a>
                        <a href="{{ route('webmaster.memberaccounts') }}" class="nav-link">Member Accounts</a>
                    </nav>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link with-sub"><i class="typcn typcn-tabs-outline"></i>
                        Investments</a>
                    <nav class="az-menu-sub">
                        <a href="{{ route('webmaster.investment.create') }}" class="nav-link">New Investment</a>
                        <a href="{{ route('webmaster.investments') }}" class="nav-link">Manage Investments</a>
                        <a href="{{ route('webmaster.investor.create') }}" class="nav-link">New Investor</a>
                        <a href="{{ route('webmaster.investors') }}" class="nav-link">Manage Investors</a>
                        <a href="{{ route('webmaster.investmentplan.create') }}" class="nav-link">New Plan</a>
                        <a href="{{ route('webmaster.investmentplans') }}" class="nav-link">Manage Plans</a>
                        <a href="{{ route('webmaster.share.create') }}" class="nav-link">Create Shares</a>
                        <a href="{{ route('webmaster.shares') }}" class="nav-link">Manage Shares</a>
                    </nav>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link with-sub"><i class="typcn typcn-tabs-outline"></i>
                        Expenses</a>
                    <nav class="az-menu-sub">
                        <a href="{{ route('webmaster.expense.create') }}" class="nav-link">Create Expense</a>
                        <a href="{{ route('webmaster.expenses') }}" class="nav-link">Manage Expenses</a>
                        <a href="{{ route('webmaster.expensecategories') }}" class="nav-link">Categories</a>
                    </nav>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link with-sub"><i class="typcn typcn-tabs-outline"></i>
                        Savings</a>
                    <nav class="az-menu-sub">
                        <a href="{{ route('webmaster.saving.create') }}" class="nav-link">New Saving</a>
                        <a href="{{ route('webmaster.savings') }}" class="nav-link">Manage Savings</a>
                    </nav>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link with-sub"><i class="typcn typcn-tabs-outline"></i>
                        Accounting</a>
                    <nav class="az-menu-sub">
                        <a href="{{ route('webmaster.chartofaccounts') }}" class="nav-link">Chart Of Accounts</a>
                        <a href="{{ route('webmaster.chartofaccount.create') }}" class="nav-link">New Account</a>
                        <a href="{{ route('webmaster.accounttypes') }}" class="nav-link">Account Types</a>
                        <a href="{{ route('webmaster.accounttransfers') }}" class="nav-link">Account Transfers</a>
                        <a href="{{ route('webmaster.accountdeposits') }}" class="nav-link">Account Deposits</a>
                        <a href="{{ route('webmaster.journalentry.create') }}" class="nav-link">New Journal Entry</a>
                        <a href="{{ route('webmaster.journalentries') }}" class="nav-link">Journal Entries</a>
                    </nav>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link with-sub"><i class="typcn typcn-tabs-outline"></i>
                        Assets</a>
                    <nav class="az-menu-sub">
                        <a href="{{ route('webmaster.asset.create') }}" class="nav-link">New Asset</a>
                        <a href="{{ route('webmaster.assets') }}" class="nav-link">Manage Assets</a>
                        <a href="{{ route('webmaster.assetgroup.create') }}" class="nav-link">Create Asset Group</a>
                        <a href="{{ route('webmaster.assetgroups') }}" class="nav-link">Asset Group List</a>
                        <a href="{{ route('webmaster.supplier.create') }}" class="nav-link">New Supplier</a>
                        <a href="{{ route('webmaster.suppliers') }}" class="nav-link">Manage Suppliers</a>
                    </nav>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link with-sub"><i class="typcn typcn-tabs-outline"></i>
                        Branches</a>
                    <nav class="az-menu-sub">
                        <a href="{{ route('webmaster.branch.create') }}" class="nav-link">New Branch</a>
                        <a href="{{ route('webmaster.branches') }}" class="nav-link">Manage Branches</a>
                    </nav>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link with-sub"><i class="typcn typcn-tabs-outline"></i>
                        Users</a>
                    <nav class="az-menu-sub">
                        <a href="{{ route('webmaster.staff.create') }}" class="nav-link">New Staff</a>
                        <a href="{{ route('webmaster.staffs') }}" class="nav-link">Manage Staffs</a>
                        <a href="{{ route('webmaster.role.create') }}" class="nav-link">New Role</a>
                        <a href="{{ route('webmaster.roles') }}" class="nav-link">Manage Roles</a>
                        <a href="{{ route('webmaster.branchpositions') }}" class="nav-link">Designation</a>
                    </nav>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link with-sub"><i class="typcn typcn-tabs-outline"></i>
                        System</a>
                    <nav class="az-menu-sub">
                        <a href="{{ route('webmaster.generalsetting') }}" class="nav-link">General Setting</a>
                        <!-- <li><a href="{{ route('webmaster.logosetting') }}">Logo Setting</a></li>
                     <li><a href="{{ route('webmaster.emailsetting') }}">Email Setting</a></li> -->
                        <a href="{{ route('webmaster.fee.create') }}" class="nav-link">New Fee</a>
                        <a href="{{ route('webmaster.fees') }}" class="nav-link">Manage Fees</a>
                        <a href="{{ route('webmaster.feerange.create') }}" class="nav-link">New Range</a>
                        <a href="{{ route('webmaster.feeranges') }}" class="nav-link">Manage Ranges</a>
                        <a href="{{ route('webmaster.dbbackups') }}" class="nav-link">System Backups</a>
                    </nav>
                </li>
            </ul>
        </div><!-- az-header-menu -->
        <div class="az-header-right">
            <a href="" class="az-header-search-link"><i class="fas fa-search"></i></a>
            <div class="az-header-message">
                <a href="app-chat.html"><i class="typcn typcn-messages"></i></a>
            </div><!-- az-header-message -->
            <div class="dropdown az-header-notification">
                <a href="" class="new"><i class="typcn typcn-bell"></i></a>
                <div class="dropdown-menu">
                    <div class="az-dropdown-header mg-b-20 d-sm-none">
                        <a href="" class="az-header-arrow"><i class="icon ion-md-arrow-back"></i></a>
                    </div>
                    <h6 class="az-notification-title">Notifications</h6>
                    <p class="az-notification-text">You have 2 unread notification</p>
                    <div class="az-notification-list">
                        <div class="media new">
                            <div class="az-img-user"><img src="https://via.placeholder.com/500" alt=""></div>
                            <div class="media-body">
                                <p>Congratulate <strong>Socrates Itumay</strong> for work anniversaries</p>
                                <span>Mar 15 12:32pm</span>
                            </div><!-- media-body -->
                        </div><!-- media -->
                        <div class="media new">
                            <div class="az-img-user online"><img src="https://via.placeholder.com/500"
                                    alt=""></div>
                            <div class="media-body">
                                <p><strong>Joyce Chua</strong> just created a new blog post</p>
                                <span>Mar 13 04:16am</span>
                            </div><!-- media-body -->
                        </div><!-- media -->
                        <div class="media">
                            <div class="az-img-user"><img src="https://via.placeholder.com/500" alt=""></div>
                            <div class="media-body">
                                <p><strong>Althea Cabardo</strong> just created a new blog post</p>
                                <span>Mar 13 02:56am</span>
                            </div><!-- media-body -->
                        </div><!-- media -->
                        <div class="media">
                            <div class="az-img-user"><img src="https://via.placeholder.com/500" alt=""></div>
                            <div class="media-body">
                                <p><strong>Adrian Monino</strong> added new comment on your photo</p>
                                <span>Mar 12 10:40pm</span>
                            </div><!-- media-body -->
                        </div><!-- media -->
                    </div><!-- az-notification-list -->
                    <div class="dropdown-footer"><a href="">View All Notifications</a></div>
                </div><!-- dropdown-menu -->
            </div><!-- az-header-notification -->
            <div class="dropdown az-profile-menu">
                <a href="" class="az-img-user"><img src="https://via.placeholder.com/500" alt=""></a>
                <div class="dropdown-menu">
                    <div class="az-dropdown-header d-sm-none">
                        <a href="" class="az-header-arrow"><i class="icon ion-md-arrow-back"></i></a>
                    </div>
                    <div class="az-header-profile">
                        <div class="az-img-user">
                            @if (webmaster()->photo)
                                <img class="rounded-circle header-profile-user"
                                    src="{{ asset('assets/uploads/staffs/' . webmaster()->photo) }}"
                                    alt="Header Avatar">
                            @else
                                <img class="rounded-circle header-profile-user"
                                    src="{{ asset('assets/uploads/defaults/author.png') }}" alt="Header Avatar">
                            @endif
                        </div><!-- az-img-user -->
                        <h6> {{ webmaster()->staff_no }}</h6>
                        <span>{{ webmaster()->role->name }}</span>
                    </div><!-- az-header-profile -->
                    <a href="{{ route('webmaster.profile') }}" class="dropdown-item"><i class="typcn typcn-user-outline"></i> My Profile</a>
                    {{-- <a href="" class="dropdown-item"><i class="typcn typcn-edit"></i> Edit Profile</a> --}}
                    {{-- <a href="" class="dropdown-item"><i class="typcn typcn-time"></i> Activity Logs</a> --}}
                    <a href="{{ route('webmaster.generalsetting') }}" class="dropdown-item"><i class="typcn typcn-cog-outline"></i> Account
                        Settings</a>
                    <a href="{{ route('webmaster.logout') }}" class="dropdown-item"><i
                            class="typcn typcn-power-outline"></i> Sign Out</a>
                </div><!-- dropdown-menu -->
            </div>
        </div><!-- az-header-right -->
    </div><!-- container -->
</div>
