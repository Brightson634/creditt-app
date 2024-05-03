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

            <li>
                  <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-share-variant"></i><span>Members</span></a>
                  <ul class="sub-menu" aria-expanded="true">
                     <li><a href="javascript: void(0);" class="has-arrow">Individuals</a>
                        <ul class="sub-menu" aria-expanded="true">
                           <li><a href="{{ route('webmaster.member.create') }}">New Member</a></li>
                     <li><a href="{{ route('webmaster.members') }}">Manag Members</a></li>
                        </ul>
                     </li>

                     <li><a href="javascript: void(0);" class="has-arrow">Groups</a>
                        <ul class="sub-menu" aria-expanded="true">
                           <li><a href="{{ route('webmaster.group.create') }}">New Group</a></li>
                     <li><a href="{{ route('webmaster.groups') }}">Manage Groups</a></li>
                        </ul>
                     </li>
                     
                  </ul>
               </li>

            <!-- <li class="">
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>Money Lenders</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('webmaster.lender.create') }}">New Lender</a></li>
                     <li><a href="{{ route('webmaster.lenders') }}">Manage Lenders</a></li>
                  </ul>
            </li> -->

            <li class="">
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>Loans</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('webmaster.memberloan.create') }}">New Loan</a></li>
                     <li><a href="{{ route('webmaster.memberloans') }}">Manage Loans</a></li>
                  </ul>
            </li>

            <!-- <li class="">
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>Social Fund</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('webmaster.socialfund.create') }}">New Fund</a></li>
                     <li><a href="{{ route('webmaster.socialfunds') }}">Manage Funds</a></li>
                  </ul>
            </li> -->

            <!-- <li class="">
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>Tnxtion Channels</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('webmaster.transactionchannel.create') }}">New Channel</a></li>
                     <li><a href="{{ route('webmaster.transactionchannels') }}">Manage Channels</a></li>
                  </ul>
            </li> -->

            <!-- <li class="">
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>Companies</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('webmaster.company.create') }}">New Company</a></li>
                     <li><a href="{{ route('webmaster.companies') }}">Manage Companies</a></li>
                  </ul>
            </li> -->


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
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>Investments</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('webmaster.investment.create') }}">New Investment</a></li>
                     <li><a href="{{ route('webmaster.investments') }}">Manage Investments</a></li>
                  </ul>
            </li>

            <li class="">
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>Saving Accounts</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('webmaster.savingaccount.create') }}">New Account</a></li>
                     <li><a href="{{ route('webmaster.savingaccounts') }}">Manage Accounts</a></li>
                  </ul>
            </li>

            <li class="">
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>Shares</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('webmaster.shareaccount.create') }}">New Account</a></li>
                     <li><a href="{{ route('webmaster.shareaccounts') }}">Manage Accounts</a></li>
                  </ul>
            </li>

           <!--  <li class="">
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>Saving Products</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('webmaster.savingproduct.create') }}">New Product</a></li>
                     <li><a href="{{ route('webmaster.savingproducts') }}">Manage products</a></li>
                  </ul>
            </li> -->

            <li class="">
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>Loan Products</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('webmaster.loanproduct.create') }}">New Product</a></li>
                     <li><a href="{{ route('webmaster.loanproducts') }}">Manage Product</a></li>
                  </ul>
            </li>

            <!-- <li class="">
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>Brorrow Products</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('webmaster.borrowproduct.create') }}">New Product</a></li>
                     <li><a href="{{ route('webmaster.borrowproducts') }}">Manage Product</a></li>
                  </ul>
            </li> -->

             <li class="">
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>Saving Fees</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('webmaster.savingfee.create') }}">New Fee</a></li>
                     <li><a href="{{ route('webmaster.savingfees') }}">Manage Fees</a></li>
                  </ul>
            </li>

            <li class="">
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>Loan Fees</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('webmaster.loanfee.create') }}">New Fee</a></li>
                     <li><a href="{{ route('webmaster.loanfees') }}">Manage Fees</a></li>
                  </ul>
            </li>

            <!-- <li class="">
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>Payroll Settings</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('webmaster.payrollsetting.create') }}">New Setting</a></li>
                     <li><a href="{{ route('webmaster.payrollsettings') }}">Manage Settings</a></li>
                  </ul>
            </li> -->

           <!--  <li class="">
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>Loan Settings</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('webmaster.loansetting.create') }}">New Setting</a></li>
                     <li><a href="{{ route('webmaster.loansettings') }}">Manage Settings</a></li>
                  </ul>
            </li>

            <li class="">
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>Organizations</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('webmaster.organization.create') }}">New Organization</a></li>
                     <li><a href="{{ route('webmaster.organizations') }}">Manage Organizations</a></li>
                  </ul>
            </li>

            <li class="">
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>Payment Methods</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('webmaster.paymentmethod.create') }}">New Method</a></li>
                     <li><a href="{{ route('webmaster.paymentmethods') }}">Manage Methods</a></li>
                  </ul>
            </li> -->

        <!--     <li class="">
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>Payment Accounts</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('webmaster.paymentaccount.create') }}">New Account</a></li>
                     <li><a href="{{ route('webmaster.paymentaccounts') }}">Manage Accounts</a></li>
                  </ul>
            </li>

            <li class="">
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>Journal Accounts</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('webmaster.journalaccount.create') }}">New Account</a></li>
                     <li><a href="{{ route('webmaster.journalaccounts') }}">Manage Accounts</a></li>
                  </ul>
            </li> -->

<!--             <li class="">
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>Journal Entries</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('webmaster.journalentry.create') }}">New Entry</a></li>
                     <li><a href="{{ route('webmaster.journalentries') }}">Manage Entries</a></li>
                  </ul>
            </li>

            <li>
               <a href="{{ route('webmaster.bankaccounts') }}"><i class="mdi mdi-home-analytics"></i><span>Bank Accounts</span></a>
            </li>

            <li>
               <a href="{{ route('webmaster.sharecategories') }}"><i class="mdi mdi-home-analytics"></i><span>Share Categories</span></a>
            </li>

            <li>
               <a href="{{ route('webmaster.taxrates') }}"><i class="mdi mdi-home-analytics"></i><span>Tax Rates</span></a>
            </li>

            <li>
               <a href="{{ route('webmaster.membertypes') }}"><i class="mdi mdi-home-analytics"></i><span>Member Types</span></a>
            </li>

            <li>
               <a href="{{ route('webmaster.paymentmodes') }}"><i class="mdi mdi-home-analytics"></i><span>Payment Modes</span></a>
            </li>

            <li>
               <a href="{{ route('webmaster.itemforsales') }}"><i class="mdi mdi-home-analytics"></i><span>Item For Sales</span></a>
            </li>

            <li>
               <a href="{{ route('webmaster.userdocuments') }}"><i class="mdi mdi-home-analytics"></i><span>User Documents</span></a>
            </li>

            <li>
               <a href="{{ route('webmaster.loandocuments') }}"><i class="mdi mdi-home-analytics"></i><span>Loan Documents</span></a>
            </li>

            <li>
               <a href="{{ route('webmaster.userexpenses') }}"><i class="mdi mdi-home-analytics"></i><span>User Expenses</span></a>
            </li>

            <li>
               <a href="{{ route('webmaster.userincomes') }}"><i class="mdi mdi-home-analytics"></i><span>User Incomes</span></a>
            </li>

            <li>
               <a href="{{ route('webmaster.collateraltypes') }}"><i class="mdi mdi-home-analytics"></i><span>Collateral Types</span></a>
            </li>

            <li>
               <a href="{{ route('webmaster.approvalsettings') }}"><i class="mdi mdi-home-analytics"></i><span>Approval Settings</span></a>
            </li>

            <li>
               <a href="{{ route('webmaster.approvalpins') }}"><i class="mdi mdi-home-analytics"></i><span>Approval Pins</span></a>
            </li>

             <li>
               <a href="{{ route('webmaster.paysliptypes') }}"><i class="mdi mdi-home-analytics"></i><span>Payslip Types</span></a>
            </li>

            <li>
               <a href="{{ route('webmaster.allowanceoptions') }}"><i class="mdi mdi-home-analytics"></i><span>Allowance Options</span></a>
            </li>

            <li>
               <a href="{{ route('webmaster.deductionoptions') }}"><i class="mdi mdi-home-analytics"></i><span>Deductions Options</span></a>
            </li>

              <li>
                  <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-share-variant"></i><span>Human Resource</span></a>
                  <ul class="sub-menu" aria-expanded="true">
                     <li><a href="javascript: void(0);" class="has-arrow">Staffs</a>
                        <ul class="sub-menu" aria-expanded="true">
                           <li><a href="{{ route('webmaster.staff.create') }}">New Staff</a></li>
                           <li><a href="{{ route('webmaster.staffs') }}">Manage Staffs</a></li>
                        </ul>
                     </li>
                     <li><a href="javascript: void(0);">Payroll</a></li>
                     
                  </ul>
               </li> -->

               <li class="">
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>Branches</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('webmaster.branch.create') }}">New Branch</a></li>
                     <li><a href="{{ route('webmaster.branches') }}">Manage Branches</a></li>
                     <li><a href="{{ route('webmaster.branchpositions') }}">Branch Positions</a></li>
                  </ul>
            </li>


            <li class="menu-title">Management</li>

            <li>
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>Settings</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{ route('webmaster.generalsetting') }}">General Setting</a></li>
                     <li><a href="{{ route('webmaster.logosetting') }}">Logo Setting</a></li>
                     <li><a href="{{ route('webmaster.emailsetting') }}">Email Setting</a></li>
                      <li><a href="{{ route('webmaster.emailsetting') }}">Database Backup</a></li>
                  </ul>
            </li>

            <li>
               <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-format-page-break"></i><span>System</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                      <li><a href="{{ route('webmaster.emailsetting') }}">Database Backup</a></li>
                  </ul>
            </li>
         </ul>
      </div>
   </div>
</div>