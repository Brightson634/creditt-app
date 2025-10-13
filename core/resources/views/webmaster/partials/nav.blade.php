  @inject('request', 'Illuminate\Http\Request')
  @if ($request->segment(1) == 'webmaster' && $request->segment(2) == 'transactions')
      @php
          $trans_pag = true;
      @endphp
  @else
      @php
          $trans_pag = false;
      @endphp
  @endif

  @if (!$trans_pag)
      <link href="{{ asset('assets/backend/css/vendor.css') }}" rel="stylesheet" type="text/css" />
      <style>
          .modal-backdrop {
              position: relative !important;
          }
      </style>
  @endif
  <div class="pd-10 bg-gray-200">
      <nav class="nav az-nav flex-column flex-md-row">
          {{-- Dashboard / Main link --}}
          <a class="nav-link {{ request()->segment(2) == 'accounting' && request()->segment(3) == 'overview' ? 'active' : '' }}"
              href="{{ action([\App\Http\Controllers\Webmaster\AccountingController::class, 'dashboard']) }}">
              <i class="fas fa-broadcast-tower mr-1"></i> Accounting Overview
          </a>

          <a class="nav-link {{ request()->segment(2) == 'accounting' && request()->segment(3) == 'chart-of-accounts' ? 'active' : '' }}"
              href="{{ action([\App\Http\Controllers\Webmaster\CoaController::class, 'index']) }}">
              <i class="fas fa-sitemap mr-1"></i> Chart Of Accounts
          </a>
          <a class="nav-link {{ request()->segment(2) == 'accounting' && request()->segment(3) == 'journal-entry' ? 'active' : '' }}"
              href="{{ action([\App\Http\Controllers\Webmaster\JournalEntryController::class, 'index']) }}">
              <i class="fas fa-book-open mr-1"></i> Journal Entry
          </a>
          <a class="nav-link {{ request()->segment(2) == 'transfer' ? 'active' : '' }}"
              href="{{ action([\App\Http\Controllers\Webmaster\TransferController::class, 'index']) }}">
              <i class="fas fa-exchange-alt mr-1"></i> Transfer
          </a>
          <a class="nav-link {{ request()->segment(2) == 'transactions' ? 'active' : '' }}"
              href="{{ action([\App\Http\Controllers\Webmaster\TransactionController::class, 'index']) }}">
              <i class="fas fa-money-bill-wave mr-1"></i> Transactions
          </a>
          <a class="nav-link {{ request()->segment(2) == 'budget' ? 'active' : '' }}"
              href="{{ action([\App\Http\Controllers\Webmaster\BudgetController::class, 'index']) }}">
              <i class="fas fa-chart-pie mr-1"></i> Budgets
          </a>

          <a class="nav-link {{ request()->segment(2) == 'reports' ? 'active' : '' }}"
              href="{{ action([\App\Http\Controllers\Webmaster\ReportController::class, 'index']) }}">
              <i class="fas fa-file-alt mr-1"></i> Reports
          </a>
          <a class="nav-link {{ request()->segment(2) == 'settings' ? 'active' : '' }}"
              href="{{ action([\App\Http\Controllers\Webmaster\SettingsAccController::class, 'index']) }}">
              <i class="fas fa-cog mr-1"></i> Settings
          </a>
      </nav>
  </div>
