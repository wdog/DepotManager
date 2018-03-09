<header class="main-header">
    <!-- Logo -->
    <a href="{{ url('/admin/home') }}" class="logo"
       style="font-size: 16px;">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">
           @lang('global.global_title')</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">
           @lang('global.global_title')</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        
    <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- Messages: style can be found in dropdown.less-->


                        <li class="dropdown user user-menu">
                            <!-- Menu Toggle Button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <!-- The user image in the navbar-->
                                <i class="fa fa-user"></i>
                                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                <span class="hidden-xs">{{ Auth::user()->name }}</span>
                                <span class="hidden-xs">({{ Auth::user()->group->group_name }})</span>
                            </a>
                            <ul class="dropdown-menu">

                                <!-- The user image in the menu -->
                                <li class="user-header bg-white">
                                    <p>
                                        {{ Auth::user()->name }}
                                        <br>
                                        <strong>{{ Auth::user()->group->group_name }}</strong>
                                        <small>{{ Auth::user()->email }}</small>
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                   
                                    <div class="pull-right">
                                        <a href="#logout"
                                           onclick="$('#logout').submit();"
                                           class="btn btn-danger btn-flat"> <i
                                                class="fa fa-sign-out"></i>
                                            Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>

    </nav>
</header>


