@inject('request', 'Illuminate\Http\Request')

<header>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="{{ url('/') }}">dEPOTS</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                @can('users_manage')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-users"></i>
                            @lang('global.user-management.title')
                        </a>
                        
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('admin.abilities.index') }}">
                                <i class="fa fa-briefcase"></i>
                                <span class="title">
                                    @lang('global.abilities.title')
                                </span>
                            </a>
                            
                            <a class="dropdown-item" href="{{ route('admin.roles.index') }}">
                                <i class="fa fa-briefcase"></i>
                                <span class="title">
                                    @lang('global.roles.title')
                                </span>
                            </a>
                            
                            <div class="dropdown-divider"></div>
                            
                            <a class="dropdown-item" href="{{ route('admin.users.index') }}">
                                <i class="fa fa-user"></i>
                                <span class="title">
                                    @lang('global.users.title')
                                </span>
                            </a>

                            <a class="dropdown-item" href="{{ route('admin.groups.index') }}">
                                <i class="fa fa-user"></i>
                                <span class="title">
                                    @lang('global.groups.title')
                                </span>
                            </a>
                        </div>
                    </li>
                @endcan
                <li class="nav-item {{ $request->segment(1) == 'depots' ? 'active' : '' }}">
                    <a class='nav-link' href="{{ route('depots.index') }}">
                        <i class="fa fa-building"></i>
                        <span class="title">Depots</span>
                    </a>
                </li>
                @can('items_manage')
                    <li class="nav-item {{ $request->segment(1) == 'items' ? 'active' : '' }}">
                        <a class='nav-link' href="{{ route('items.index') }}">
                            <i class="fa fa-bookmark"></i>
                            <span class="title">Items</span>
                        </a>
                    </li>
                @endcan
                
        </ul>
        
        
        <div class="mt-2 mt-md-0">
            <ul class="navbar-nav">
                 <li class="nav-item dropdown">
                     <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                         <i class="fa fa-user"></i>
                         {{ Auth::user()->name }}
                     </a>
                        
                     <div class="dropdown-menu dropdown-menu-right">
                         <a class="dropdown-item" href="{{ route('auth.change_password') }}">
                            <i class="fa fa-key"></i>
                                <span class="title">Change password</span>
                         </a>
                     
                         <a class="dropdown-item" href="#logout" onclick="$('#logout').submit();">
                             <i class="fa fa-arrow-left"></i>
                             <span class="title">@lang('global.app_logout')</span>
                         </a>
                     </div>
                 </li>
           
            </ul>
            </div>
        </div>
      </nav>
</header>
