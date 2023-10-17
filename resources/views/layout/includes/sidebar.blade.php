<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{ route('dashboard.index') }}" class="brand-link">
    <img src="{{ url($settings->school_logo) }}" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light school-name-in-short">{{ $settings->school_name_in_short }}</span>
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
        @canany(['view-student', 'create-student', 'import-student'])
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
              @can('view-student')
                <li class="nav-item">
                  <a href="{{ route('student.index') }}" class="nav-link @if(Route::currentRouteName() == 'student.index') active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Manage</p>
                  </a>
                </li>
              @endcan
              @can('create-student')
                <li class="nav-item">
                  <a href="{{ route('student.create') }}" class="nav-link @if(Route::currentRouteName() == 'student.create') active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Create</p>
                  </a>
                </li>
              @endcan
              @can('import-student')
                <li class="nav-item">
                  <a href="{{ route('student.import') }}" class="nav-link @if(Route::currentRouteName() == 'student.import') active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Import</p>
                  </a>
                </li>
              @endcan
            </ul>
          </li>
        @endcanany
        @canany(['view-attendance-status', 'create-attendance-status', 'mark-attendance', 'attendance-report'])
          <li class="nav-item @if((in_array(Route::currentRouteName(), [ 'attendance-status.index', 'attendance-status.create', 'mark-attendance.index', 'attendance-status.trash', 'mark-attendance.index', 'attendance-report.index' ]))) menu-open @endif">
            <a href="#" class="nav-link @if((in_array(Route::currentRouteName(), [ 'attendance-status.index', 'attendance-status.create', 'attendance-status.edit', 'attendance-status.trash', 'mark-attendance.index', 'attendance-report.index' ]))) active @endif">
              <i class="nav-icon fas fa-user-check"></i>
              <p>
                Student Attendance
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @canany(['view-attendance-status', 'create-attendance-status'])
                <li class="nav-item @if((in_array(Route::currentRouteName(), [ 'attendance-status.index', 'attendance-status.create' ]))) menu-open @endif">
                  <a href="#" class="nav-link @if((in_array(Route::currentRouteName(), [ 'attendance-status.index', 'attendance-status.create', 'attendance-status.edit', 'attendance-status.trash' ]))) active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>
                      Attendance Status
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    @can('view-attendance-status')
                      <li class="nav-item">
                        <a href="{{ route('attendance-status.index') }}" class="nav-link @if(Route::currentRouteName() == 'attendance-status.index') active @endif">
                          <i class="far fa-dot-circle nav-icon"></i>
                          <p>Manage</p>
                        </a>
                      </li>
                    @endcan
                    @can('create-attendance-status')
                      <li class="nav-item">
                        <a href="{{ route('attendance-status.create') }}" class="nav-link @if(Route::currentRouteName() == 'attendance-status.create') active @endif">
                          <i class="far fa-dot-circle nav-icon"></i>
                          <p>Create</p>
                        </a>
                      </li>
                    @endcan
                  </ul>
                </li>
              @endcanany
              @can('mark-attendance')
                <li class="nav-item @if((in_array(Route::currentRouteName(), [ 'mark-attendance.index' ]))) menu-open @endif">
                  <a href="{{ route('mark-attendance.index') }}" class="nav-link @if((in_array(Route::currentRouteName(), [ 'mark-attendance.index' ]))) active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Mark Attendance</p>
                  </a>
                </li>
              @endcan
              @can('attendance-report')
                <li class="nav-item @if((in_array(Route::currentRouteName(), [ 'attendance-report.index' ]))) menu-open @endif">
                  <a href="{{ route('attendance-report.index') }}" class="nav-link @if((in_array(Route::currentRouteName(), [ 'attendance-report.index' ]))) active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Attendance Report</p>
                  </a>
                </li>
              @endcan
            </ul>
          </li>
        @endcanany
        @canany(['view-exam', 'create-exam', 'view-exam-schedule', 'create-exam-schedule'])
          <li class="nav-header">Examination</li>
        @endcanany
        @canany(['view-exam', 'create-exam'])
          <li class="nav-item @if((in_array(Route::currentRouteName(), [ 'exam.index', 'exam.create' ]))) menu-open @endif">
            <a href="#" class="nav-link @if((in_array(Route::currentRouteName(), [ 'exam.index', 'exam.create', 'exam.edit', 'exam.trash' ]))) active @endif">
              <i class="nav-icon fas fa-file-signature"></i>
              <p>
                Exams
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @can('view-exam')
                <li class="nav-item">
                  <a href="{{ route('exam.index') }}" class="nav-link @if(Route::currentRouteName() == 'exam.index') active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Manage</p>
                  </a>
                </li>
              @endcan
              @can('create-exam')
                <li class="nav-item">
                  <a href="{{ route('exam.create') }}" class="nav-link @if(Route::currentRouteName() == 'exam.create') active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Create</p>
                  </a>
                </li>
              @endcan
            </ul>
          </li>
        @endcanany
        @canany(['view-exam-schedule', 'create-exam-schedule'])
          <li class="nav-item @if((in_array(Route::currentRouteName(), [ 'exam-schedule.index', 'exam-schedule.create' ]))) menu-open @endif">
            <a href="#" class="nav-link @if((in_array(Route::currentRouteName(), [ 'exam-schedule.index', 'exam-schedule.create' ]))) active @endif">
              <i class="nav-icon fas fa-calendar-week"></i>
              <p>
                Exam Schedule
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @can('view-exam-schedule')
                <li class="nav-item">
                  <a href="{{ route('exam-schedule.index') }}" class="nav-link @if(Route::currentRouteName() == 'exam-schedule.index') active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Manage</p>
                  </a>
                </li>
              @endcan
              @can('create-exam-schedule')
                <li class="nav-item">
                  <a href="{{ route('exam-schedule.create') }}" class="nav-link @if(Route::currentRouteName() == 'exam-schedule.create') active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Create</p>
                  </a>
                </li>
              @endcan
            </ul>
          </li>
        @endcanany
        @canany(['view-grade', 'create-grade'])
          <li class="nav-item @if((in_array(Route::currentRouteName(), [ 'grade.index', 'grade.create' ]))) menu-open @endif">
            <a href="#" class="nav-link @if((in_array(Route::currentRouteName(), [ 'grade.index', 'grade.create', 'grade.edit', 'grade.trash' ]))) active @endif">
              <i class="nav-icon fas fa-medal"></i>
              <p>
                Grade
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @can('view-grade')
                <li class="nav-item">
                  <a href="{{ route('grade.index') }}" class="nav-link @if(Route::currentRouteName() == 'grade.index') active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Manage</p>
                  </a>
                </li>
              @endcan
              @can('create-session')
                <li class="nav-item">
                  <a href="{{ route('grade.create') }}" class="nav-link @if(Route::currentRouteName() == 'grade.create') active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Create</p>
                  </a>
                </li>
              @endcan
            </ul>
          </li>
        @endcanany
        @canany(['view-mark-slip', 'create-mark-slip', 'tabulation-sheet'])
          <li class="nav-item @if((in_array(Route::currentRouteName(), [ 'markslip.index', 'markslip.create', 'markslip.tabulation' ]))) menu-open @endif">
            <a href="#" class="nav-link @if((in_array(Route::currentRouteName(), [ 'markslip.index', 'markslip.create', 'markslip.edit', 'markslip.tabulation' ]))) active @endif">
              <i class="nav-icon fas fa-paste"></i>
              <p>
                Mark Slip
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @can('view-mark-slip')
                <li class="nav-item">
                  <a href="{{ route('markslip.index') }}" class="nav-link @if(Route::currentRouteName() == 'markslip.index') active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Manage</p>
                  </a>
                </li>
              @endcan
              @can('create-mark-slip')
                <li class="nav-item">
                  <a href="{{ route('markslip.create') }}" class="nav-link @if(Route::currentRouteName() == 'markslip.create') active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Create</p>
                  </a>
                </li>
              @endcan
              @can('tabulation-sheet')
                <li class="nav-item">
                  <a href="{{ route('markslip.tabulation') }}" class="nav-link @if(Route::currentRouteName() == 'markslip.tabulation') active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Tabulation Sheet</p>
                  </a>
                </li>
              @endcanany
            </ul>
          </li>
        @endcanany
        @canany(['view-class', 'create-class', 'view-section', 'create-section', 'view-group', 'create-group', 'view-subject', 'create-subject'])
          <li class="nav-header">Academics</li>
        @endcanany
        @canany(['view-session', 'create-session'])
          <li class="nav-item @if((in_array(Route::currentRouteName(), [ 'session.index', 'session.create' ]))) menu-open @endif">
            <a href="#" class="nav-link @if((in_array(Route::currentRouteName(), [ 'session.index', 'session.create', 'session.edit', 'session.trash' ]))) active @endif">
              <i class="nav-icon fas fa-calendar"></i>
              <p>
                Session
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @can('view-session')
                <li class="nav-item">
                  <a href="{{ route('session.index') }}" class="nav-link @if(Route::currentRouteName() == 'session.index') active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Manage</p>
                  </a>
                </li>
              @endcan
              @can('create-session')
                <li class="nav-item">
                  <a href="{{ route('session.create') }}" class="nav-link @if(Route::currentRouteName() == 'session.create') active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Create</p>
                  </a>
                </li>
              @endcan
            </ul>
          </li>
        @endcanany
        @canany(['view-class', 'create-class'])
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
          <li class="nav-item @if((in_array(Route::currentRouteName(), [ 'general.settings' ]))) menu-open @endif">
            <a href="#" class="nav-link @if((in_array(Route::currentRouteName(), [ 'general.settings' ]))) active @endif">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Settings
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('general.settings') }}" class="nav-link @if(Route::currentRouteName() == 'general.settings') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>General Settings</p>
                </a>
              </li>
            </ul>
          </li>
        @endrole
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>