<div class="vertical-menu" >
   <div data-simplebar class="h-100">
      <div class="navbar-brand-box">
         <div class="logo">
            <img src="{{ asset('assets/uploads/generals/'. $gs->logo ) }}">
         </div>
         <!-- style="background-color:#393A3E;color:#000" -->
      </div>
      <div id="sidebar-menu">
         <ul class="metismenu list-unstyled" id="side-menu">
            <li>
               <a href="{{ route('webmaster.dashboard') }}"><i class="mdi mdi-home-analytics"></i><span>Dashboard</span></a>
            </li>

            <!-- <li class="menu-title">Operations</li> -->
            <li class="">
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>Loan Manager</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('webmaster.loan.create') }}">Create Loan</a></li>
                     <li><a href="{{ route('webmaster.loans') }}">Manage Loans</a></li>
                     <li><a href="{{ route('webmaster.myloans') }}">My Loans</a></li>
                     <li><a href="{{ route('webmaster.loanproduct.create') }}">New Product</a></li>
                     <li><a href="{{ route('webmaster.loanproducts') }}">Loan Products</a></li>
                     <li><a href="{{ route('webmaster.loanpayment.create') }}">New Payment</a></li>
                     <li><a href="{{ route('webmaster.loanpayments') }}">Payments List</a></li>
                  </ul>
            </li>
            <li class="">
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>Members</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('webmaster.member.create') }}">New Member</a></li>
                     <li><a href="{{ route('webmaster.members') }}">Manage Members</a></li>
                     <li><a href="{{ route('webmaster.memberaccount.create') }}">Create Account</a></li>
                     <li><a href="{{ route('webmaster.memberaccounts') }}">Member Accounts</a></li>
                   
                  </ul>
            </li>
            <li class="">
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>Investments</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('webmaster.investment.create') }}">New Investment</a></li>
                     <li><a href="{{ route('webmaster.investments') }}">Manage Investments</a></li>
                     <li><a href="{{ route('webmaster.investor.create') }}">New Investor</a></li>
                     <li><a href="{{ route('webmaster.investors') }}">Manage Investors</a></li>
                     <li><a href="{{ route('webmaster.investmentplan.create') }}">New Plan</a></li>
                     <li><a href="{{ route('webmaster.investmentplans') }}">Manage Plans</a></li>
                     <li><a href="{{ route('webmaster.share.create') }}">Create Shares</a></li>
                     <li><a href="{{ route('webmaster.shares') }}">Manage Shares</a></li>
                  </ul>
            </li>
                      <li class="">
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>Expenses</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('webmaster.expense.create') }}">Create Expense</a></li>
                     <li><a href="{{ route('webmaster.expenses') }}">Manage Expenses</a></li>
                     <li><a href="{{ route('webmaster.expensecategories') }}">Categories</a></li>
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
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>Accounting</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('webmaster.chartofaccounts') }}">Chart Of Accounts</a></li>
                     <li><a href="{{ route('webmaster.chartofaccount.create') }}">New Account</a></li>
                     <li><a href="{{ route('webmaster.accounttypes') }}">Account Types</a></li>
                     <li><a href="{{ route('webmaster.accounttransfers') }}">Account Transfers</a></li>
                     <li><a href="{{ route('webmaster.accountdeposits') }}">Account Deposits</a></li>
                     <li><a href="{{ route('webmaster.journalentry.create') }}">New Journal Entry</a></li>
                     <li><a href="{{ route('webmaster.journalentries') }}">Journal Entries</a></li>
                  </ul>
            </li>
                       <li class="">
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>Assets</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('webmaster.asset.create') }}">New Asset</a></li>
                     <li><a href="{{ route('webmaster.assets') }}">Manage Assets</a></li>
                     <li><a href="{{ route('webmaster.assetgroup.create') }}">Create Asset Group</a></li>
                     <li><a href="{{ route('webmaster.assetgroups') }}">Asset Group List</a></li>
                     <li><a href="{{ route('webmaster.supplier.create') }}">New Supplier</a></li>
                     <li><a href="{{ route('webmaster.suppliers') }}">Manage Suppliers</a></li>
                  </ul>
            </li>

         

                          <li class="">
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>Branches</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('webmaster.branch.create') }}">New Branch</a></li>
                     <li><a href="{{ route('webmaster.branches') }}">Manage Branches</a></li>
                    
                  </ul>
            </li>

            <li class="">
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>Users</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('webmaster.staff.create') }}">New Staff</a></li>
                     <li><a href="{{ route('webmaster.staffs') }}">Manage Staffs</a></li>
                     <li><a href="{{ route('webmaster.role.create') }}">New Role</a></li>
                     <li><a href="{{ route('webmaster.roles') }}">Manage Roles</a></li>
                     <li><a href="{{ route('webmaster.branchpositions') }}">Designation</a></li>
                  </ul>
            </li>

          

         

            <li>
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>System</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                  <li>
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>Settings</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('webmaster.generalsetting') }}">General Setting</a></li>
                     <!-- <li><a href="{{ route('webmaster.logosetting') }}">Logo Setting</a></li>
                     <li><a href="{{ route('webmaster.emailsetting') }}">Email Setting</a></li> -->
                     <li><a href="{{ route('webmaster.fee.create') }}">New Fee</a></li>
                     <li><a href="{{ route('webmaster.fees') }}">Manage Fees</a></li>
                     <li><a href="{{ route('webmaster.feerange.create') }}">New Range</a></li>
                     <li><a href="{{ route('webmaster.feeranges') }}">Manage Ranges</a></li>
                     </li><i class="mdi mdi-format-page-break"></i>
                      <li><a href="{{ route('webmaster.dbbackups') }}">System Backups</a></li>

                  </ul>
                  </ul>
            </li>
         </ul>
      </div>
   </div>
</div>