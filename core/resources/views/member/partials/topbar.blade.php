<header id="page-topbar">
  <div class="navbar-header">
    <div class="d-flex align-items-left">
      <button type="button" class="btn py-0 btn-sm mr-2 d-lg-none px-3 font-size-16 header-item" id="vertical-menu-btn"> <i
          class="fa fa-fw fa-bars"></i>
      </button>
      <div class="dropdown d-sm-inline-block">
        @if(!(request()->routeIs('webmaster.dashboard')))
        <div class="section">
          <a href="javascript:void(0);" onclick="goBack()" class="btn btn-sm btn-theme"> <i
              class="fa fa-arrow-left"></i> Back</a>
        </div>
        @endif
      </div>
    </div>

    <div class="d-flex align-items-center">
      <!-- <div class="dropdown d-none d-sm-inline-block ml-2"> -->
        <div class="mode-switch mb-2">
          <input type="checkbox" name="mode" id="dark_mode">
          <label for="dark_mode"></label>
        </div>
      <!-- </div> -->


      <div class="dropdown d-none d-sm-inline-block ml-2">
        <a href="{{ route('home')}}" target="_blank" class="header-item noti-icon ">
          <i class="fab fas fa-globe"></i>
        </a>
      </div>

      <div class="dropdown d-inline-block">
        <button type="button" class="btn header-item noti-icon" id="page-header-notifications-dropdown"
          data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="mdi mdi-bell"></i>
          <span class="badge-danger badge-pill">{{ $notifications->count() }}</span>
        </button>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0"
          aria-labelledby="page-header-notifications-dropdown">
          @if($notifications->count() > 0)
          <div class="p-3">
            <div class="row align-items-center">
              <div class="col">
                <h6 class="m-0"> {{ $notifications->count() }} Unread Notifications </h6>
              </div>
            </div>
          </div>
          <div data-simplebar style="max-height: 230px;">
            @foreach($notifications as $notification)
            <a href="{{ $notification->url }}" class="text-reset notification-item">
              <div class="media">
                <img src="assets/images/users/avatar-2.jpg" class="mr-3 rounded-circle avatar-xs" alt="user-pic">
                <div class="media-body">
                  <h6 class="mt-0 mb-1">Notification Type</h6>
                  <p class="font-size-12 mb-1">{{ $notification->title }}</p>
                  <p class="font-size-12 mb-0 text-muted"><i class="mdi mdi-clock-outline"></i>
                    {{ $notification->created_at->diffForHumans() }}</p>
                </div>
              </div>
            </a>
            @endforeach
          </div>
          <div class="p-2 border-top">
            <a class="btn btn-sm btn-info btn-block text-center" href="{{ route('webmaster.notifications') }}">
              View All
            </a>
          </div>

          @else
          <div class="p-3">
            <div class="row align-items-center">
              <div class="col">
                <h6 class="m-0"> No Unread Notifications </h6>
              </div>
            </div>
          </div>
          @endif


        </div>
      </div>

      <div class="dropdown d-inline-block ml-2">
        <button type="button" class="btn py-0 header-item" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          @if (webmaster()->photo)
          <img class="rounded-circle header-profile-user"
            src="{{ asset('assets/uploads/staffs/'. webmaster()->photo )}}" alt="Header Avatar">
          @else
          <img class="rounded-circle header-profile-user" src="{{ asset('assets/uploads/defaults/author.png') }}"
            alt="Header Avatar">
          @endif
        </button>
        <div class="dropdown-menu dropdown-menu-right">
          <div class="be-profile">
            <h4>{{ webmaster()->staff_no }}</h4>
            <span>{{ webmaster()->role->name }}</span>
          </div>

          <a class="dropdown-item d-flex align-items-center" href="{{ route('webmaster.profile') }}">
            <i class="far fa-user"></i> <span class="be-topnav">My Profile</span>
          </a>
          <a class="dropdown-item d-flex align-items-center" href="{{ route('webmaster.generalsetting') }}">
            <i class="far fa-sun"></i> <span class="be-topnav">My Settings</span>
          </a>
          <div class="be-logout mt-1">
            <a class="btn btn-sm btn-theme btn-block" href="{{ route('webmaster.logout') }}">
              Log Out
            </a>
          </div>
        </div>
      </div>

    </div>
  </div>
</header>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
  
<script>

// Enable pusher logging - don't include this in production
Pusher.logToConsole = true;

var pusher = new Pusher('87202ee38ddc4b942d3d', {
  cluster: 'ap2'
});

var channel = pusher.subscribe('loan-application');
channel.bind('loan-application-review', function(data) {
  alert(JSON.stringify(data));
});
</script>
