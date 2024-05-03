<div class="vertical-menu">
   <div data-simplebar class="h-100">
      <div class="navbar-brand-box">
         <div class="logo">
            <img src="{{ asset('assets/uploads/generals/'. $gs->logo ) }}">
         </div>
      </div>
      <div id="sidebar-menu">
         <ul class="metismenu list-unstyled" id="side-menu">
            <li>
               <a href="{{ route('webmaster.dashboard') }}"><i class="mdi mdi-home-analytics"></i><span>Dashboard</span></a>
            </li>

            <li class="menu-title">Operations</li>

            <li class="">
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>Chart Of Accounts</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('webmaster.chartofaccount.create') }}">New Account</a></li>
                     <li><a href="{{ route('webmaster.chartofaccounts') }}">Manage Accounts</a></li>
                     <li><a href="{{ route('webmaster.accounttypes') }}">Account Types</a></li>
                     <li><a href="{{ route('webmaster.accounttransfers') }}">Account Transfers</a></li>
                     <li><a href="{{ route('webmaster.accountdeposits') }}">Account Deposits</a></li>
                  </ul>
            </li>

            <li class="">
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>Journal Entry</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('webmaster.journalentry.create') }}">New Journal Entry</a></li>
                     <li><a href="{{ route('webmaster.journalentries') }}">Manage Journal Entries</a></li>
                  </ul>
            </li>

            <li class="">
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>Expenses</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('webmaster.expense.create') }}">Add Expense</a></li>
                     <li><a href="{{ route('webmaster.expenses') }}">Manage Expenses</a></li>
                     <li><a href="{{ route('webmaster.expensecategories') }}">Expense Categories</a></li>
                  </ul>
            </li>

            <li class="">
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>Members</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('webmaster.member.create') }}">New Member</a></li>
                     <li><a href="{{ route('webmaster.members') }}">Manage Members</a></li>
                  </ul>
            </li>

            <li class="">
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>Savings</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('webmaster.saving.create') }}">New Saving</a></li>
                     <li><a href="{{ route('webmaster.savings') }}">Manage Savings</a></li>
                  </ul>
            </li>

            <li class="">
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>Loans</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('webmaster.loan.create') }}">New Loan</a></li>
                     <li><a href="{{ route('webmaster.loans') }}">Manage Loans</a></li>
                     <li><a href="{{ route('webmaster.myloans') }}">My Loans</a></li>
                  </ul>
            </li>

            <li class="">
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>Loan Payments</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('webmaster.loanpayment.create') }}">New Payment</a></li>
                     <li><a href="{{ route('webmaster.loanpayments') }}">Manage Payments</a></li>
                  </ul>
            </li>

            <li class="">
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>Assets</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('webmaster.asset.create') }}">New Asset</a></li>
                     <li><a href="{{ route('webmaster.assets') }}">Manage Assets</a></li>
                  </ul>
            </li>

            <li class="">
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>Asset Groups</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('webmaster.assetgroup.create') }}">New Group</a></li>
                     <li><a href="{{ route('webmaster.assetgroups') }}">Manage Groups</a></li>
                  </ul>
            </li>

            <li class="">
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>Suppliers</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('webmaster.supplier.create') }}">New Supplier</a></li>
                     <li><a href="{{ route('webmaster.suppliers') }}">Manage Suppliers</a></li>
                  </ul>
            </li>

            <li class="">
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>Subscription Plans</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('webmaster.subscriptionplan.create') }}">New Plan</a></li>
                     <li><a href="{{ route('webmaster.subscriptionplans') }}">Manage Plans</a></li>
                  </ul>
            </li>

            <li class="">
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>Investments</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('webmaster.investment.create') }}">New Investment</a></li>
                     <li><a href="{{ route('webmaster.investments') }}">Manage Investments</a></li>
                  </ul>
            </li>

            <li class="">
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>Investors</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('webmaster.investor.create') }}">New Investor</a></li>
                     <li><a href="{{ route('webmaster.investors') }}">Manage Investors</a></li>
                  </ul>
            </li>

             <li class="">
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>Investment Plans</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('webmaster.investmentplan.create') }}">New Plan</a></li>
                     <li><a href="{{ route('webmaster.investmentplans') }}">Manage Plans</a></li>
                  </ul>
            </li>

            <li class="">
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>Member Accounts</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('webmaster.memberaccount.create') }}">New Account</a></li>
                     <li><a href="{{ route('webmaster.memberaccounts') }}">Manage Accounts</a></li>
                  </ul>
            </li>

            <li class="">
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>Shares</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('webmaster.share.create') }}">New Share</a></li>
                     <li><a href="{{ route('webmaster.shares') }}">Manage Shares</a></li>
                  </ul>
            </li>

            <li class="">
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>Buy Shares</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('webmaster.buyshare.create') }}">New Share</a></li>
                     <li><a href="{{ route('webmaster.buyshares') }}">Manage Shares</a></li>
                  </ul>
            </li>

            <li class="">
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>Sell Shares</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('webmaster.sellshare.create') }}">New Share</a></li>
                     <li><a href="{{ route('webmaster.sellshares') }}">Manage Shares</a></li>
                  </ul>
            </li>

            <li class="">
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>Loan Products</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('webmaster.loanproduct.create') }}">New Product</a></li>
                     <li><a href="{{ route('webmaster.loanproducts') }}">Manage Product</a></li>
                  </ul>
            </li>

            <li class="">
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>Fees</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('webmaster.fee.create') }}">New Fee</a></li>
                     <li><a href="{{ route('webmaster.fees') }}">Manage Fees</a></li>
                  </ul>
            </li>

            <li class="">
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>Fee Ranges</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('webmaster.feerange.create') }}">New Range</a></li>
                     <li><a href="{{ route('webmaster.feeranges') }}">Manage Ranges</a></li>
                  </ul>
            </li>

               <li class="">
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>Branches</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('webmaster.branch.create') }}">New Branch</a></li>
                     <li><a href="{{ route('webmaster.branches') }}">Manage Branches</a></li>
                     <li><a href="{{ route('webmaster.branchpositions') }}">Branch Positions</a></li>
                  </ul>
            </li>

            <li class="">
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>Staffs</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('webmaster.staff.create') }}">New Staff</a></li>
                     <li><a href="{{ route('webmaster.staffs') }}">Manage Staffs</a></li>
                  </ul>
            </li>

            <li class="menu-title">Management</li>

            <li>
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>Settings</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('webmaster.generalsetting') }}">General Setting</a></li>
                     <li><a href="{{ route('webmaster.logosetting') }}">Logo Setting</a></li>
                     <li><a href="{{ route('webmaster.emailsetting') }}">Email Setting</a></li>
                  </ul>
            </li>

            <li>
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>Roles</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('webmaster.role.create') }}">New Role</a></li>
                     <li><a href="{{ route('webmaster.roles') }}">Manage Roles</a></li>
                  </ul>
            </li>

            <li>
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>System</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                      <li><a href="{{ route('webmaster.dbbackups') }}">DB Backups</a></li>
                  </ul>
            </li>
         </ul>
      </div>
   </div>
</div>