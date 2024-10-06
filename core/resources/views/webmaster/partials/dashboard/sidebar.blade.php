  <style>
      /* Styles for the loan report dropdown menu */
      .dropdown-menu {
          padding: 0;
          margin: 0;
          background-color: #f8f9fa;
          border: 1px solid #dee2e6;
          border-radius: 4px;
          box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      }

      /* Default styles for dropdown items */
      .dropdown-menu .dropdown-item {
          padding: 10px 15px;
          margin: 0;
          color: #333;
          text-decoration: none;
          transition: background-color 0.3s ease;
          position: relative;
          padding-left: 25px;
          /* Increased padding for larger bullet space */
      }

      /* Styles for dropdown items on hover */
      .dropdown-menu .dropdown-item:hover {
          background-color: #0d6efd;
          /* Changed to mild purple on hover */
          color: white;
      }

      /* Optional: Reduce padding on the anchor link inside the list item */
      .dropdown-menu a {
          padding: 5px 10px;
          display: block;
      }

      /* Adjust spacing between items */
      .dropdown-menu .dropdown-item+.dropdown-item {
          margin-top: 5px;
          /* Adjusted margin to control spacing */
      }

      /* Create the bullet using a pseudo-element */
      .dropdown-menu .dropdown-item::before {
          content: "•";
          position: absolute;
          left: 10px;
          /* Adjusted left position */
          color: #007bff;
          font-weight: bold;
          font-size: 1.5em;
          /* Increased bullet size */
      }
  </style>

  <div class="az-iconbar">
      <a href="{{ route('webmaster.dashboard') }}" class="az-iconbar-logo" data-toggle="tooltip-primary"
          title="Dashboard"><i class="typcn typcn-chart-bar-outline"></i></a>
      <nav class="nav">
          {{-- <a href="#asideDashboard" class="nav-link active" data-toggle="tooltip-primary" title="Dashboard"><i class="typcn typcn-device-laptop"></i></a> --}}
          <a href="#loanManager" class="nav-link" data-toggle="tooltip-primary" title="Loan Manager"><i
                  class="typcn typcn-credit-card"></i></a>
          <a href="#membersElement" class="nav-link" data-toggle="tooltip-primary" title="Members"><i
                  class="typcn typcn-group"></i></a>
          <a href="#investmentElement" class="nav-link" data-toggle="tooltip-primary" title="Investments"><i
                  class="typcn typcn-chart-line-outline"></i></a>
          <a href="#expenseElement" class="nav-link" data-toggle="tooltip-primary" title="Expenses"><i
                  class="typcn typcn-credit-card"></i></a>
          <a href="#savingElement" class="nav-link" data-toggle="tooltip-primary" title="Funds Manager"><i
                  class="typcn typcn-credit-card"></i></a>
          <a href="#accountingElement" class="nav-link" data-toggle="tooltip-primary" title="Accounting"><i
                  class="typcn typcn-chart-bar-outline"></i></a>
          {{-- <a href="#fundsElement" class="nav-link" data-toggle="tooltip-primary" title="Finance Operations">
                        <i class="typcn typcn-credit-card"></i>
                    </a> --}}

          <a href="#assetElement" class="nav-link" data-toggle="tooltip-primary" title="Assets"><i
                  class="typcn typcn-business-card"></i></a>
          <a href="#branchElement" class="nav-link" data-toggle="tooltip-primary" title="Branches"><i
                  class="typcn typcn-location"></i></a>
          <a href="#userElement" class="nav-link" data-toggle="tooltip-primary" title="Users"><i
                  class="typcn typcn-user"></i></a>
          <a href="#deskElement" class="nav-link" data-toggle="tooltip-primary" title="Help Desk"><i
                  class="typcn typcn-phone-outline"></i></a>
          <a href="#reports" class="nav-link" data-toggle="tooltip-primary" title="Reports"><i
                  class="typcn typcn-document"></i></a>
          <a href="#settingElement" class="nav-link" data-toggle="tooltip-primary" title="Settings"><i
                  class="typcn typcn-cog"></i></a>
      </nav>
  </div><!-- az-iconbar -->
  <div class="az-iconbar-aside">
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
                  <li class="nav-item"><a href="{{ route('webmaster.loan.calculator') }}" class="nav-link">Loan
                          Calculator</a></li>
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
                  <li class="nav-item"><a href="{{ route('webmaster.members') }}" class="nav-link">Manage
                          Members</a>
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
                  <li class='nav-item'><a href="{{ route('webmaster.investmentplan.create') }}" class="nav-link">New
                          Plan</a></li>
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
              <h6 class="az-iconbar-title">Funds Manager</h6>
              <ul class="nav">
                  <li class='nav-item'><a href="{{ route('webmaster.saving.create') }}" class="nav-link">New
                          Saving</a></li>
                  <li class='nav-item'><a href="{{ route('webmaster.savings') }}" class="nav-link">Manage
                          Savings</a></li>
                  <li class='nav-item'><a href="{{ route('webmaster.accountdeposits') }}"
                          class="nav-link">Deposits</a></li>
                  <li class='nav-item'><a href="{{ route('webmaster.account.withdraw') }}"
                          class="nav-link">Withdraws</a></li>
                  <li class='nav-item'><a href="{{ route('webmaster.accounttransfers') }}"
                          class="nav-link">Transfers</a></li>

              </ul>
          </div><!-- az-iconbar-pane -->
          <div id="accountingElement" class="az-iconbar-pane">
              <h6 class="az-iconbar-title">Accounting</h6>
              <ul class="nav">
                  <li class='nav-item'><a
                          href="{{ action([\App\Http\Controllers\Webmaster\AccountingController::class, 'dashboard']) }}"
                          class="nav-link">Over View</a></li>
                  <li class='nav-item'><a
                          href="{{ action([\App\Http\Controllers\Webmaster\CoaController::class, 'index']) }}"
                          class="nav-link">Chart
                          Of Accounts</a></li>
                  {{-- <li class='nav-item'><a href="{{ route('webmaster.chartofaccount.create') }}"
                            class="nav-link">New Account</a></li> --}}
                  <li class='nav-item'><a
                          href="{{ action([\App\Http\Controllers\Webmaster\JournalEntryController::class, 'index']) }}"
                          class="nav-link">Journal Entry</a></li>
                  <li class='nav-item'><a
                          href="{{ action([\App\Http\Controllers\Webmaster\TransferController::class, 'index']) }}"
                          class="nav-link"> Transfers</a></li>
                  <li class='nav-item'><a
                          href="{{ action([\App\Http\Controllers\Webmaster\TransactionController::class, 'index']) }}"
                          class="nav-link">Transactions</a></li>
                  <li class='nav-item'><a
                          href="{{ action([\App\Http\Controllers\Webmaster\BudgetController::class, 'index']) }}"
                          class="nav-link">Budget</a></li>
                  <li class='nav-item'><a
                          href="{{ action([\App\Http\Controllers\Webmaster\ReportController::class, 'index']) }}"
                          class="nav-link">Reports</a></li>
                  <li class='nav-item'><a
                          href="{{ action([\App\Http\Controllers\Webmaster\SettingsAccController::class, 'index']) }}"
                          class="nav-link">Settings</a></li>
              </ul>
          </div><!-- az-iconbar-pane -->
          <div id="assetElement" class="az-iconbar-pane">
              <h6 class="az-iconbar-title">Assets</h6>
              <ul class="nav">
                  <li class='nav-item'><a href="{{ route('webmaster.asset.create') }}" class="nav-link">New
                          Asset</a></li>
                  <li class='nav-item'><a href="{{ route('webmaster.assets') }}" class="nav-link">Manage
                          Assets</a></li>
                  <li class='nav-item'><a href="{{ route('webmaster.assetgroup.create') }}" class="nav-link">Create
                          Asset Group</a></li>
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
                  <li class='nav-item'><a href="{{ route('webmaster.branchpositions') }}"
                          class="nav-link">Designation</a></li>
              </ul>
          </div><!-- az-iconbar-pane -->
          <div id="deskElement" class="az-iconbar-pane">
              <h6 class="az-iconbar-title">Help Desk</h6>
              <ul class="nav">
                  <li class='nav-item'><a href="{{ route('webmaster.desk.help') }}" class="nav-link">
                          Help</a>
                  </li>
              </ul>
          </div><!-- az-iconbar-pane -->
          <div id="reports" class="az-iconbar-pane">
              <h6 class="az-iconbar-title">Reports</h6>
              <ul class="nav">
                  <li class='nav-item'>
                      <a href="#" class="nav-link" data-toggle="dropdown">Loans Reports <i
                              class="typcn typcn-arrow-sorted-down"></i></a>
                      <ul class="dropdown-menu">
                          <li><a href="{{ route('webmaster.loans.report') }}" class="dropdown-item">General
                                  Loans Report</a></li>
                          <li><a href="{{ route('webmaster.loans.report.pending') }}" class="dropdown-item">Loans
                                  Pending</a></li>
                          <li><a href="{{ route('webmaster.loans.report.disbursed') }}" class="dropdown-item">Loans
                                  Disbursed</a></li>
                          <li><a href="{{ route('webmaster.loans.report.reviewed') }}" class="dropdown-item">Loans
                                  Reviewed</a></li>
                          <li><a href="{{ route('webmaster.loans.report.approved') }}" class="dropdown-item">Loans
                                  Approved</a></li>
                          <li><a href="{{ route('webmaster.loans.report.rejected') }}" class="dropdown-item">Loans
                                  Rejected</a></li>
                          <li><a href="{{ route('webmaster.loans.report.arrear') }}" class="dropdown-item">Loans in
                                  Arrears</a></li>
                          {{-- <li><a href="{{ route('webmaster.loandefaulters.report') }}" class="dropdown-item">Loan Defaulters</a></li> --}}
                      </ul>
                  </li>
                  <li class='nav-item'><a href="{{ route('webmaster.member.report') }}" class="nav-link">
                          Members</a></li>
                  <li class='nav-item'><a href="{{ route('webmaster.investments.report') }}" class="nav-link">
                          Investments</a></li>
                  <li class='nav-item'><a href="{{ route('webmaster.expense.report') }}"
                          class="nav-link">Expenses</a>
                  </li>
                  <li class='nav-item'><a href="#" class="nav-link">Savings</a></li>
                  <li class='nav-item'><a
                          href="{{ action([\App\Http\Controllers\Webmaster\ReportController::class, 'index']) }}"
                          class="nav-link">Accounting</a></li>
              </ul>
          </div><!-- az-iconbar-pane -->
          <div id="settingElement" class="az-iconbar-pane">
              <h6 class="az-iconbar-title">Settings</h6>
              <ul class="nav">
                  <li class='nav-item'><a href="{{ route('webmaster.generalsetting') }}" class="nav-link">General
                          Setting</a></li>
                  {{-- <li class='nav-item'><a href="{{ route('webmaster.prefixsetting') }}" class="nav-link">Prefix
                          Setting</a></li> --}}
                  <li class='nav-item'><a href="{{ route('webmaster.fee.create') }}" class="nav-link">New Fee</a>
                  <li class='nav-item'><a href="{{ route('webmaster.fees') }}" class="nav-link">Manage Fees</a>
                  </li>
                  <li class='nav-item'><a href="{{ route('webmaster.role.create') }}" class="nav-link">Roles
                          Management</a></li>
                  <li class='nav-item'><a href="{{ route('webmaster.roles') }}" class="nav-link">View Roles</a></li>
                  </li>
                  <li class='nav-item'><a href="{{ route('webmaster.feerange.create') }}" class="nav-link">New
                          Range</a></li>
                  <li class='nav-item'><a href="{{ route('webmaster.feeranges') }}" class="nav-link">Manage
                          Ranges</a></li>
                  <li class='nav-item'><a href="{{ route('webmaster.dbbackups') }}" class="nav-link">System
                          Backups</a></li>
                  <li class='nav-item'><a href="{{ route('webmaster.exchangerates') }}" class="nav-link">Exchange
                          Rates</a></li>
              </ul>
          </div><!-- az-iconbar-pane -->
      </div><!-- az-iconbar-body -->
  </div><!-- az-iconbar-aside -->
