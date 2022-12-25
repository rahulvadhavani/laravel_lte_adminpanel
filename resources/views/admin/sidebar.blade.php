<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{url('/')}}" class="brand-link">
        <img src="{{getSettings('logo_image')}}" alt="{{config('app.name')}}" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{config('app.name')}}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{auth()->user()->image}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="{{route('admin.profile')}}" class="d-block">{{auth()->user()->name}}</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
               <li class="nav-item">
                    <a href="{{route('home')}}" class="nav-link {{ request()->route()->getName() == 'home' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.profile')}}" class="nav-link {{ request()->route()->getName() == 'admin.profile' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user"></i>
                        <p>Profile</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('users.index')}}" class="nav-link {{ request()->route()->getName() == 'users.index' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Users</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link {{ isset($parent_id) && $parent_id == 'static-page' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-copy"></i>
                    <p>
                        Static Pages
                        <i class="fas fa-angle-left right"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">
                    <li class="nav-item">
                        <a href="{{url('admin/static-page/about-us')}}" class="nav-link {{ request()->is('admin/static-page/about-us') ? 'active' : '' }}">
                        <i class="nav-icon far fa-circle text-indigo"></i>
                        <p>About Us</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{url('admin/static-page/terms-condition')}}" class="nav-link {{ request()->is('admin/static-page/terms-condition') ? 'active' : '' }}">
                        <i class="nav-icon far fa-circle text-indigo"></i>
                        <p>Terms & Condition</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{url('admin/static-page/privacy-policy')}}" class="nav-link {{ request()->is('admin/static-page/privacy-policy') ? 'active' : '' }}">
                        <i class="nav-icon far fa-circle text-indigo"></i>
                        <p>Privacy policy</p>
                        </a>
                    </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>