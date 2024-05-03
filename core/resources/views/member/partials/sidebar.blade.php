<div class="sidebar">
        <div class="menu">
          <ul>
            <li>
              <a href="{{route('member.dashboard')}}">
                <span>
                  <span><i class="bi bi-house-fill"></i></span>
                  <span class="nav-text">Home</span>
                </span>
              </a>
            </li>
            @if(member()->is_agent == 1)
            <li>
              <a href="{{route('member.savings')}}">
                <span>
                  <span><i class="bi bi-patch-check-fill"></i></span>
                  <span>Agents</span>
                </span>
              </a>
            </li>
            @endif
            <li>
              <a href="{{route('member.mysavings')}}">
                <span>
                  <span><i class="bi bi-patch-check-fill"></i></span>
                  <span>Savings</span>
                </span>
              </a>
            </li>
            <li> 
              <a href="{{route('member.myloans')}}">
                <span>
                  <span><i class="bi bi-wallet-fill"></i></span>
                  <span class="nav-text">Loans</span>
                </span>
              </a>
            </li>
            <li>
              <a href="{{route('member.account')}}">
                <span>
                  <span><i class="bi bi-person-circle"></i></span>
                  <span class="nav-text">Account</span>
                </span>
              </a>
            </li>
            
          </ul>
        </div>
      </div>