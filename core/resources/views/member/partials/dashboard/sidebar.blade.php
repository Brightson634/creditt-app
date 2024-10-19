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
      <a href="{{ route('member.dashboard', ['id' => member()->member_no]) }}" class="az-iconbar-logo" data-toggle="tooltip-primary"
          title="Dashboard"><i class="typcn typcn-chart-bar-outline"></i></a>
      <nav class="nav">
          {{-- <a href="#asideDashboard" class="nav-link active" data-toggle="tooltip-primary" title="Dashboard"><i class="typcn typcn-device-laptop"></i></a> --}}
          <a href="#loanManager" class="nav-link" data-toggle="tooltip-primary" title="Loans"><i
                  class="typcn typcn-credit-card"></i></a>
          <a href="#membersElement" class="nav-link" data-toggle="tooltip-primary" title="Calendar"><i
                  class="typcn typcn-calendar"></i></a>
          <a href="#investmentElement" class="nav-link" data-toggle="tooltip-primary" title="Investments"><i
                  class="typcn typcn-chart-line-outline"></i></a>
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
                  <li class="nav-item"><a href="{{ route('member.dashboard', ['id' => member()->member_no]) }}" class="nav-link">Home</a></li>
              </ul>
          </div>
          <div id="loanManager" class="az-iconbar-pane">
              <h6 class="az-iconbar-title">Loans</h6>
              <ul class="nav">
                  <li class="nav-item"><a href="{{ route('member.loan.create') }}" class="nav-link">Apply</a></li>
                  </li>
                  <li class="nav-item"><a href="#" class="nav-link">Loan Repayments</a></li>
              </ul>
          </div><!-- az-iconbar-pane -->
          <div id="membersElement" class="az-iconbar-pane">
              <h6 class="az-iconbar-title">Calendar</h6>
              <ul class="nav">
                  <li class="nav-item"><a href="#" class="nav-link">View Calendar</a></li>
              </ul>
          </div><!-- az-iconbar-pane -->
          <div id="settingElement" class="az-iconbar-pane">
              <h6 class="az-iconbar-title">Settings</h6>
              <ul class="nav">
                  <li class='nav-item'><a href="#" class="nav-link">General
                          Setting</a></li>
              </ul>
          </div><!-- az-iconbar-pane -->
      </div><!-- az-iconbar-body -->
  </div><!-- az-iconbar-aside -->
