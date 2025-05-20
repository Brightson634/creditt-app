

<div>
    <div class="pd-10 bg-gray-800">
        <nav class="nav az-nav az-nav-dark az-nav-colored-bg flex-column flex-md-row">
          <a  @if(request()->segment(2) == 'superadmin' && request()->segment(3) == 'dashboard') class="nav-link active" @endif class="nav-link"  href="{{route('webmaster.superadmin.index')}}"><i class="fa fas fa-users-cog"></i>Superadmin</a>
          <a @if(request()->segment(2) == 'superadmin' && request()->segment(3) == 'tenants') class="nav-link active" @endif class="nav-link"  href="{{route('webmaster.superadmin.tenants')}}">Tenants</a>
          {{-- <a  @if(request()->segment(2) == 'superadmin' && request()->segment(3) == 'subscription') class="nav-link active" @endif class="nav-link" href="{{route('webmaster.superadmin.index')}}">Tenant Subscription</a> --}}
           <a  @if(request()->segment(2) == 'superadmin' && request()->segment(3) == 'package') class="nav-link active" @endif class="nav-link" href="{{route('webmaster.superadmin.package')}}">Packages</a>
        </nav>
      </div>
</div>