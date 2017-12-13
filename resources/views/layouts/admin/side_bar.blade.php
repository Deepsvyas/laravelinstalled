<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
            <li class="{{ ViewsHelper::isActiveNav('dashboard') }}">
                <a href="{{ url("admin/dashboard") }}">
                   <i class="fa fa-dashboard"></i> 
                    <span>Dashboard</span> 
                </a>
            </li>
            <li class="{{ ViewsHelper::isActiveNav('admin/user') }}">
                
                <a href="{{url('admin/users')}}"><i class="fa fa-fw fa-users"></i> <span>Users</span></a>
                
            </li>
            <li class="{{ ViewsHelper::isActiveNav('admin/stylist') }}">
                
                <a href="{{url('admin/stylist')}}"><i class="fa fa-fw fa-users"></i> <span>Stylist</span></a>
                
            </li>
            <li class="treeview {{ ViewsHelper::isActiveNav('posts/new_post') }} {{ ViewsHelper::isActiveNav('admin/posts') }} {{ ViewsHelper::isActiveNav('admin/menus') }} {{ ViewsHelper::isActiveNav('admin/pages') }}">
                <a href="#">
                    <i class="fa fa-fw fa-th-list"></i> <span> Posts </span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ ViewsHelper::isActiveNav('admin/posts/new_post') }}">
                        <a href="{{url('admin/posts/new_post')}}"><i class="fa fa-fw fa-plus"></i> <span>Add New Post</span></a>
                    </li>
                    <li class="{{ ViewsHelper::isActiveNav('admin/posts') }}">
                        <a href="{{url('admin/posts')}}"><i class="fa fa-fw fa-th-list"></i> <span>List Posts</span></a>
                    </li>
                </ul>
            </li>
            <li class="treeview {{ ViewsHelper::isActiveNav('banners/new_post') }} {{ ViewsHelper::isActiveNav('admin/banners') }} {{ ViewsHelper::isActiveNav('admin/menus') }} {{ ViewsHelper::isActiveNav('admin/pages') }}">
                <a href="#">
                    <i class="fa fa-fw fa-th-list"></i> <span> Banners </span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ ViewsHelper::isActiveNav('admin/banners/new_post') }}">
                        <a href="{{url('admin/banners/new_post')}}"><i class="fa fa-fw fa-plus"></i> <span>Add New Banner</span></a>
                    </li>
                    <li class="{{ ViewsHelper::isActiveNav('admin/banners') }}">
                        <a href="{{url('admin/banners')}}"><i class="fa fa-fw fa-th-list"></i> <span>List Banners</span></a>
                    </li>
                </ul>
            </li>
            <li class="treeview {{ ViewsHelper::isActiveNav('faqs/new_faq') }} {{ ViewsHelper::isActiveNav('admin/faqs') }} {{ ViewsHelper::isActiveNav('admin/menus') }} {{ ViewsHelper::isActiveNav('admin/pages') }}">
                <a href="#">
                    <i class="fa fa-fw fa-th-list"></i> <span> FAQ's </span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ ViewsHelper::isActiveNav('admin/faqs/new_faq') }}">
                        <a href="{{url('admin/faqs/new_faq')}}"><i class="fa fa-fw fa-plus"></i> <span>Add New FAQ</span></a>
                    </li>
                    <li class="{{ ViewsHelper::isActiveNav('admin/faqs') }}">
                        <a href="{{url('admin/faqs')}}"><i class="fa fa-fw fa-th-list"></i> <span>List FAQ's</span></a>
                    </li>
                </ul>
            </li>

            <li class="treeview {{ ViewsHelper::isActiveNav('product-category/new_category') }} {{ ViewsHelper::isActiveNav('admin/product-category') }} {{ ViewsHelper::isActiveNav('admin/menus') }} {{ ViewsHelper::isActiveNav('admin/pages') }}">
                <a href="#">
                    <i class="fa fa-fw fa-th-list"></i> <span> Product Categories </span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ ViewsHelper::isActiveNav('admin/product-category/new_category') }}">
                        <a href="{{url('admin/product-category/new_category')}}"><i class="fa fa-fw fa-plus"></i> <span>Add New Category</span></a>
                    </li>
                    <li class="{{ ViewsHelper::isActiveNav('admin/product-category') }}">
                        <a href="{{url('admin/product-category')}}"><i class="fa fa-fw fa-th-list"></i> <span>List Product Categories</span></a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="{{ url('/logout') }}"><i class="fa fa-sign-out text-red"></i> 
                    <span>Logout</span>
                </a>
            </li>


        </ul>
    </section>
</aside>