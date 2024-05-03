<div class="header">
   <div class="container-fluid">
      <div class="row">
         <div class="col-xxl-12">
            <div class="header-content">
               <div class="header-left">
                  <div class="brand-logo">
                     <a href="index.html">
                        <img src="{{ asset('assets/uploads/generals/'. $gs->logo ) }}" alt="">
                     </a>
                  </div> 
               </div>
                <div class="header-right">
                  <div class="notification dropdown mr-3">
                      <a href="{{ route('member.notifications') }}">
                     <div class="notify-bell">
                        <span class="noti-icon">
                           <i class="bi bi-bell-fill text-white"></i>
                           <span class="badge badge-danger badge-pill">{{ $membernotifications->count() }}</span>
                        </span>
                     </div>
                     </a>
                  </div>

                  

                  <div class="profile_log dropdown">
                    <div class="user" data-toggle="dropdown">
                      <span class="thumb">
                           @if (member()->photo)
                           <img src="{{ asset('assets/uploads/members/'. member()->photo )}}" class="rounded-circle" alt="photo" />
                           @else
                           <img src="{{ asset('assets/uploads/defaults/member.PNG') }}" class="rounded-circle" alt="photo" />
                           @endif
                          </span>
                      <span class="arrow"
                        ><i class="icofont-angle-down"></i
                      ></span>
                    </div>
                    <div class="dropdown-menu dropdown-menu-right">
                      <div class="user-email">
                        <div class="user">
                          <span class="thumb">
                           @if (member()->photo)
                           <img src="{{ asset('assets/uploads/members/'. member()->photo )}}" alt="photo" />
                           @else
                           <img src="{{ asset('assets/uploads/defaults/member.PNG') }}" alt="photo" />
                           @endif
                          </span>
                          <div class="user-info">
                            <h5>{{ member()->member_no }}</h5>
                            <span>{{ member()->name }}</span>
                          </div>
                        </div>
                      </div>

                      <a href="{{ route('member.profile') }}" class="dropdown-item">
                        <i class="bi bi-person"></i>Profile
                      </a>
                      <a href="{{ route('member.account') }}" class="dropdown-item">
                        <i class="bi bi-person"></i> Account
                      </a>
                      <a href="{{ route('member.logout') }}" class="dropdown-item logout">
                        <i class="bi bi-power"></i> Logout
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>