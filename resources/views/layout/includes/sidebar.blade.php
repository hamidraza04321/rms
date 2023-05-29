<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{ route('dashboard.index') }}" class="brand-link">
    <img src="{{ url($settings->school_logo) }}" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">{{ $settings->school_name }}</span>
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
        <li class="nav-header">Student Management</li>
        <li class="nav-item @if((in_array(Route::currentRouteName(), [ 'student.index', 'student.create', 'student.import' ]))) menu-open @endif">
          <a href="#" class="nav-link @if((in_array(Route::currentRouteName(), [ 'student.index', 'student.create', 'student.edit', 'student.import', 'student.trash' ]))) active @endif">
            <i class="nav-icon fas fa-graduation-cap"></i>
            <p>
              Student
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('student.index') }}" class="nav-link @if(Route::currentRouteName() == 'student.index') active @endif">
                <i class="far fa-circle nav-icon"></i>
                <p>Manage</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('student.create') }}" class="nav-link @if(Route::currentRouteName() == 'student.create') active @endif">
                <i class="far fa-circle nav-icon"></i>
                <p>Create</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('student.import') }}" class="nav-link @if(Route::currentRouteName() == 'student.import') active @endif">
                <i class="far fa-circle nav-icon"></i>
                <p>Import</p>
              </a>
            </li>
          </ul>
        </li>
        @canany(['view-class', 'create-class', 'view-section', 'create-section', 'view-group', 'create-group', 'view-subject', 'create-subject'])
          <li class="nav-header">Academics</li>
        @endcanany
        @canany(['view-class', 'create-class'])
          <li class="nav-item @if((in_array(Route::currentRouteName(), [ 'session.index', 'session.create' ]))) menu-open @endif">
            <a href="#" class="nav-link @if((in_array(Route::currentRouteName(), [ 'session.index', 'session.create', 'session.edit', 'session.trash' ]))) active @endif">
              <i class="nav-icon fas fa-calendar"></i>
              <p>
                Session
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @can('view-class')
                <li class="nav-item">
                  <a href="{{ route('session.index') }}" class="nav-link @if(Route::currentRouteName() == 'session.index') active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Manage</p>
                  </a>
                </li>
              @endcan
              @can('create-class')
                <li class="nav-item">
                  <a href="{{ route('session.create') }}" class="nav-link @if(Route::currentRouteName() == 'session.create') active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Create</p>
                  </a>
                </li>
              @endcan
            </ul>
          </li>
          <li class="nav-item @if((in_array(Route::currentRouteName(), [ 'class.index', 'class.create' ]))) menu-open @endif">
            <a href="#" class="nav-link @if((in_array(Route::currentRouteName(), [ 'class.index', 'class.create', 'class.edit', 'class.trash' ]))) active @endif">
              <i class="nav-icon fas fa-users-cog"></i>
              <p>
                Class
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @can('view-class')
                <li class="nav-item">
                  <a href="{{ route('class.index') }}" class="nav-link @if(Route::currentRouteName() == 'class.index') active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Manage</p>
                  </a>
                </li>
              @endcan
              @can('create-class')
                <li class="nav-item">
                  <a href="{{ route('class.create') }}" class="nav-link @if(Route::currentRouteName() == 'class.create') active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Create</p>
                  </a>
                </li>
              @endcan
            </ul>
          </li>
        @endcanany
        @canany(['view-section', 'create-section'])
          <li class="nav-item @if((in_array(Route::currentRouteName(), [ 'section.index', 'section.create' ]))) menu-open @endif">
            <a href="#" class="nav-link @if((in_array(Route::currentRouteName(), [ 'section.index', 'section.create', 'section.edit', 'section.trash' ]))) active @endif">
              <i class="nav-icon fas fa-puzzle-piece"></i>
              <p>
                Section
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @can('view-section')
                <li class="nav-item">
                  <a href="{{ route('section.index') }}" class="nav-link @if(Route::currentRouteName() == 'section.index') active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Manage</p>
                  </a>
                </li>
              @endcan
              @can('create-section')
                <li class="nav-item">
                  <a href="{{ route('section.create') }}" class="nav-link @if(Route::currentRouteName() == 'section.create') active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Create</p>
                  </a>
                </li>
              @endcan
            </ul>
          </li>
        @endcanany
        @canany(['view-group', 'create-group'])
          <li class="nav-item @if((in_array(Route::currentRouteName(), [ 'group.index', 'group.create' ]))) menu-open @endif">
            <a href="#" class="nav-link @if((in_array(Route::currentRouteName(), [ 'group.index', 'group.create', 'group.edit', 'group.trash' ]))) active @endif">
              <i class="nav-icon fas fa-layer-group"></i>
              <p>
                Group
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @can('view-group')
                <li class="nav-item">
                  <a href="{{ route('group.index') }}" class="nav-link @if(Route::currentRouteName() == 'group.index') active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Manage</p>
                  </a>
                </li>
              @endcan
              @can('create-group')
                <li class="nav-item">
                  <a href="{{ route('group.create') }}" class="nav-link @if(Route::currentRouteName() == 'group.create') active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Create</p>
                  </a>
                </li>
              @endcan
            </ul>
          </li>
        @endcan
        @canany(['view-subject', 'create-subject'])
          <li class="nav-item @if((in_array(Route::currentRouteName(), [ 'subject.index', 'subject.create' ]))) menu-open @endif">
            <a href="#" class="nav-link @if((in_array(Route::currentRouteName(), [ 'subject.index', 'subject.create', 'subject.edit', 'subject.trash' ]))) active @endif">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Subject
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @can('view-subject')
                <li class="nav-item">
                  <a href="{{ route('subject.index') }}" class="nav-link @if(Route::currentRouteName() == 'subject.index') active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Manage</p>
                  </a>
                </li>
              @endcan
              @can('create-subject')
                <li class="nav-item">
                  <a href="{{ route('subject.create') }}" class="nav-link @if(Route::currentRouteName() == 'subject.create') active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Create</p>
                  </a>
                </li>
              @endcan
            </ul>
          </li>
        @endcan
        @role('Super Admin')
          <li class="nav-header">User Management</li>
          <li class="nav-item @if((in_array(Route::currentRouteName(), [ 'role.index', 'role.create' ]))) menu-open @endif">
            <a href="#" class="nav-link @if((in_array(Route::currentRouteName(), [ 'role.index', 'role.create', 'role.edit' ]))) active @endif">
              <i class="nav-icon fas fa-user-shield"></i>
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
          <li class="nav-item @if((in_array(Route::currentRouteName(), [ 'user.index', 'user.create' ]))) menu-open @endif">
            <a href="#" class="nav-link @if((in_array(Route::currentRouteName(), [ 'user.index', 'user.create', 'user.edit', 'user.trash' ]))) active @endif">
              <i class="nav-icon fas fa-users"></i>
              <p>
                User
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('user.index') }}" class="nav-link @if(Route::currentRouteName() == 'user.index') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Manage</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('user.create') }}" class="nav-link @if(Route::currentRouteName() == 'user.create') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-header">System Settings</li>
          <li class="nav-item @if(Route::currentRouteName() == 'settings.index') menu-open @endif">
            <a href="{{ route('settings.index') }}" class="nav-link @if(Route::currentRouteName() == 'settings.index') active @endif">
              <i class="nav-icon ion-gear-a"></i>
              <p>Settings</p>
            </a>
          </li>
        @endrole
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>