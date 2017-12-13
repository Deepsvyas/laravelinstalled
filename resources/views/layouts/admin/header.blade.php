<header class="main-header">

    <!-- Logo -->
    <a href="{{ url("/") }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini" title="{{ ViewsHelper::getConfigKeyData("website_title") }}">{{ substr(ViewsHelper::getConfigKeyData("website_title"),0,2) }}</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>{{ ViewsHelper::getConfigKeyData("website_title") }}</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        @if(Auth::user()->role->role_slug == 'super_admin')
                        <span class="hidden-xs">{{ Auth::user()->full_name() }}</span>
                        @endif
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="{{ ViewsHelper::img('admin/user-profile.png') }}" class="img-circle" alt="User Image">
                            <p>
                                {{ Auth::user()->first_name." ".Auth::user()->last_name }}
                                <small>Member since: {{ CommonHelper::timestampToDate(Auth::user()->created_at,false) }}</small>
                                <small>Last login: {{ CommonHelper::timestampToDate(Auth::user()->last_login_date,true) }}</small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{{ url("admin/editprofile") }}" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ url("/logout") }}" class="btn btn-default btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

    </nav>
</header>