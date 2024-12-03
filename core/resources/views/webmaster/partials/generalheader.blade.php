<div class="az-dashboard-one-title">
    <div>
        @if(greeting()==='Good night')
        <h2 class="az-dashboard-title"> {{greeting().' '.ucfirst(strtolower(webmaster()->title)).' '.ucfirst(strtolower(webmaster()->fname))}} !</h2>
        @else
        <h2 class="az-dashboard-title">{{greeting().' '. ucfirst(strtolower(webmaster()->title)).' '.ucfirst(strtolower(webmaster()->fname))}},welcome back!</h2>
        @endif
        {{-- <p class="az-dashboard-text">Your web analytics dashboard template.</p> --}}
    </div>
    <div class="az-content-header-right">
        <div class="media">
            <div class="media-body">
                {{-- <label>Start Date</label>
                <h6>Oct 10, 2018</h6> --}}
            </div><!-- media-body -->
        </div><!-- media -->
        <div class="media">
            <div class="media-body">
                {{-- <label>End Date</label>
                <h6>Oct 23, 2018</h6> --}}
            </div><!-- media-body -->
        </div><!-- media -->
        <div class="media">
            <div class="media-body">
                {{-- <label>Event Category</label>
                <h6>All Categories</h6> --}}
            </div><!-- media-body -->
        </div><!-- media -->
        @can('add_loan_repayment')
        <a href="{{ route('webmaster.loanpayment.create') }}" class="btn btn-purple">Make Payments</a>
        @endcan
    </div>
</div><!-- az-dashboard-one-title -->

<div class="az-dashboard-nav">
    <nav class="nav">
      @can('view_main_dashboard')
        <a class="nav-link {{ request()->routeIs('webmaster.dashboard') ? 'active' : '' }}"  
           href="{{ route('webmaster.dashboard') }}">
          Dashboard
        </a>
      @endcan
      <a class="nav-link {{ request()->routeIs('webmaster.calendar.view') ? 'active' : '' }}" 
         href="{{ route('webmaster.calendar.view') }}">
        Calendar
      </a>
      <a class="nav-link {{ request()->routeIs('webmaster.overview') ? 'active' : '' }}" 
         href="{{ route('webmaster.overview') }}">
        Accounting
      </a>
      <a class="nav-link {{ request()->routeIs('webmaster.loan.create') ? 'active' : '' }}" 
         href="{{ route('webmaster.loan.create') }}">
        Loan Application
      </a>
      <a class="nav-link {{ request()->routeIs('webmaster.member.create') ? 'active' : '' }}" 
         href="{{ route('webmaster.member.create') }}">
        Members
      </a>
      <a class="nav-link {{ request()->routeIs('webmaster.investment.create') ? 'active' : '' }}" 
         href="{{ route('webmaster.investment.create') }}">
        Investments
      </a>
      <a class="nav-link {{ request()->routeIs('webmaster.saving.create') ? 'active' : '' }}" 
         href="{{ route('webmaster.saving.create') }}">
        Savings
      </a>
      <a class="nav-link" data-toggle="tab" href="#">More</a>
    </nav>
  </div>
  
