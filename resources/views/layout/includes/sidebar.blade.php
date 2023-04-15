<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{ route('dashboard.index') }}" class="brand-link">
    <img src="{{ url('/assets/dist/img/AdminLTELogo.png') }}" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">RMS</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{ url('/assets/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">{{ auth()->user()->name }}</a>
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
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item @if((in_array(Route::currentRouteName(), [ 'dashboard.index' ]))) menu-open @endif">
          <a href="{{ route('dashboard.index') }}" class="nav-link @if(Route::currentRouteName() == 'dashboard.index') active @endif">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>
        <li class="nav-item @if((in_array(Route::currentRouteName(), [ 'class.index', 'class.create', 'class.edit' ]))) menu-open @endif">
          <a href="#" class="nav-link @if((in_array(Route::currentRouteName(), [ 'class.index', 'class.create', 'class.edit', 'class.trash' ]))) active @endif">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Class
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('class.index') }}" class="nav-link @if(Route::currentRouteName() == 'class.index') active @endif">
                <i class="far fa-circle nav-icon"></i>
                <p>Manage</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('class.create') }}" class="nav-link @if(Route::currentRouteName() == 'class.create') active @endif">
                <i class="far fa-circle nav-icon"></i>
                <p>Create</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item @if((in_array(Route::currentRouteName(), [ 'section.index', 'section.create', 'section.edit' ]))) menu-open @endif">
          <a href="#" class="nav-link @if((in_array(Route::currentRouteName(), [ 'section.index', 'section.create', 'section.edit', 'section.trash' ]))) active @endif">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Section
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('section.index') }}" class="nav-link @if(Route::currentRouteName() == 'section.index') active @endif">
                <i class="far fa-circle nav-icon"></i>
                <p>Manage</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('section.create') }}" class="nav-link @if(Route::currentRouteName() == 'section.create') active @endif">
                <i class="far fa-circle nav-icon"></i>
                <p>Create</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item @if((in_array(Route::currentRouteName(), [ 'group.index', 'group.create', 'group.edit' ]))) menu-open @endif">
          <a href="#" class="nav-link @if((in_array(Route::currentRouteName(), [ 'group.index', 'group.create', 'group.edit', 'group.trash' ]))) active @endif">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Group
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('group.index') }}" class="nav-link @if(Route::currentRouteName() == 'group.index') active @endif">
                <i class="far fa-circle nav-icon"></i>
                <p>Manage</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('group.create') }}" class="nav-link @if(Route::currentRouteName() == 'group.create') active @endif">
                <i class="far fa-circle nav-icon"></i>
                <p>Create</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-header">User Management</li>
        <li class="nav-item @if((in_array(Route::currentRouteName(), [ 'role.index', 'role.create', 'role.edit' ]))) menu-open @endif">
          <a href="#" class="nav-link @if((in_array(Route::currentRouteName(), [ 'role.index', 'role.create', 'role.edit' ]))) active @endif">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Role
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('role.index') }}" class="nav-link @if(Route::currentRouteName() == 'role.index') active @endif">
                <i class="far fa-circle nav-icon"></i>
                <p>Manage</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('role.create') }}" class="nav-link @if(Route::currentRouteName() == 'role.create') active @endif">
                <i class="far fa-circle nav-icon"></i>
                <p>Create</p>
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