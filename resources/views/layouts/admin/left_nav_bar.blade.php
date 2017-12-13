<div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav side-nav">
        <li class="active">
            <a href="{{url('admin/dashboard')}}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
        </li>
        <?php  if (Auth::user()->role->role_slug == 'super_admin' || Auth::user()->role->role_slug == 'admin'){ ?>
        <li>
            <a href="{{url('admin/users')}}"><i class="fa fa-fw fa-users"></i> Users</a>
        </li>
        <?php } ?>
        <li>
            <?php if (Auth::user()->role->role_slug == 'super_admin' || Auth::user()->role->role_slug == 'admin') { ?>
                <a href="{{url('admin/website')}}"><i class="fa fa-fw fa-users"></i>User Websites</a>
            <?php } else if (Auth::user()->role->role_slug == 'customer') { ?>
                <a href="{{url('customer/website')}}"><i class="fa fa-fw"></i>My Websites</a>
            <?php } ?>
        </li>
        <li>

        </li>
        <li>
            <a href="{{url('admin/customfieldtypes')}}"><i class="fa fa-fw fa-users"></i>Custom Field Types</a>
        </li>
        <li>
            <a href="{{url('logout')}}"><i class="fa fa-fw fa-sign-out"></i> Logout</a>
        </li>
        <?php if (Auth::user()->role->role_slug == 'super_admin' || Auth::user()->role->role_slug == 'admin') { ?>
        <li>
            <a href="#" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-arrows-v"></i> Acl <i class="fa fa-fw fa-caret-down"></i></a>
            <ul id="demo" class="collapse">
                <li>
                    <a href="{{ url('admin/permission') }}">Permissions</a>
                </li>
                <li>
                    <a href="{{ url('admin/role') }}">Role</a>
                </li>
                <li>
                    <a href="{{ url('admin/role/relation') }}">Relation</a>
                </li>
            </ul>
        </li>
        <?php } ?>

    </ul>
</div>