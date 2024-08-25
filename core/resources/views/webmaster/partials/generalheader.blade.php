<div class="az-dashboard-one-title">
    <div>
        <h2 class="az-dashboard-title">Hi, welcome back!</h2>
        <p class="az-dashboard-text">Your web analytics dashboard template.</p>
    </div>
    <div class="az-content-header-right">
        <div class="media">
            <div class="media-body">
                <label>Start Date</label>
                <h6>Oct 10, 2018</h6>
            </div><!-- media-body -->
        </div><!-- media -->
        <div class="media">
            <div class="media-body">
                <label>End Date</label>
                <h6>Oct 23, 2018</h6>
            </div><!-- media-body -->
        </div><!-- media -->
        <div class="media">
            <div class="media-body">
                <label>Event Category</label>
                <h6>All Categories</h6>
            </div><!-- media-body -->
        </div><!-- media -->
        <a href="{{ route('webmaster.loanpayment.create') }}" class="btn btn-purple">Make Payments</a>
    </div>
</div><!-- az-dashboard-one-title -->

<div class="az-dashboard-nav">
  <nav class="nav">
    <a class="nav-link active"  href="{{route('webmaster.dashboard')}}">Dashboard</a>
    <a class="nav-link" href="{{route('webmaster.overview')}}">Accounting</a>
    <a class="nav-link"  href="{{ route('webmaster.loan.create') }}">Loan Application</a>
    <a class="nav-link"  href="{{ route('webmaster.member.create') }}">Members</a>
    <a class="nav-link"  href="{{ route('webmaster.investment.create') }}">Investments</a>
    <a class="nav-link"  href="{{ route('webmaster.saving.create') }}">Savings</a>
    <a class="nav-link" data-toggle="tab" href="#">More</a>
  </nav>
</div>
