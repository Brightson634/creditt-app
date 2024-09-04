<div class="az-dashboard-nav">
    <nav class="nav">
        <a class="nav-link {{ $activeNav == 'generalsetting' ? 'active' : '' }}" href="{{ route('webmaster.generalsetting') }}">Information Settings</a>
        <a class="nav-link {{ $activeNav == 'emailsetting' ? 'active' : '' }}" href="{{ route('webmaster.emailsetting') }}">Emailing Settings</a>
        <a class="nav-link {{ $activeNav == 'logosetting' ? 'active' : '' }}" href="{{ route('webmaster.logosetting') }}">Log Settings</a>
        <a class="nav-link {{ $activeNav == 'prefixsetting' ? 'active' : '' }}" href="{{ route('webmaster.prefixsetting') }}">Prefix Settings</a>
        <a class="nav-link {{ $activeNav == 'loanprocesssetting' ? 'active' : '' }}" href="{{ route('webmaster.loanprocesssetting') }}">Loan Settings</a>
        <a class="nav-link {{ $activeNav == 'accounttypes' ? 'active' : '' }}" href="{{ route('webmaster.accounttype') }}">Account Types</a>
        <a class="nav-link {{ $activeNav == 'collaterals' ? 'active' : '' }}" href="{{ route('webmaster.collaterals') }}">Collateral Items</a>
        <a class="nav-link" data-toggle="tab" href="#">More</a>
    </nav>    
  </div>
