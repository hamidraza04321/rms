@extends('layout.app')
@section('page-title', $data['page_title'])
@section('main-content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">{{ $data['page_title'] }}</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">{{ $data['menu'] }}</a></li>
              <li class="breadcrumb-item active">{{ $data['page_title'] }}</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            @if($data['role']->name != 'Super Admin')
              <div class="card card-primary card-outline">
                <div class="card-header">
                  <div class="card-title"><i class="fa fa-edit"></i> {{ $data['page_title'] }}</div>
                </div>
                <div class="card-body">
                  <form action="{{ route('role.update', $data['role']->id) }}" id="update-role-form">
                    <div class="form-group">
                      <label>Name <span class="error">*</span></label>
                      <input type="text" name="name" id="name" class="form-control" placeholder="Enter Role Name" value="{{ $data['role']->name }}">
                    </div>
                    <div class="form-group">
                      <div class="accordion" id="permissionAccordion">
                        <div class="card">
                          <div class="card-header" id="permission-heading">
                            <div class="d-flex">
                              <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#permissions-table" aria-expanded="true" aria-controls="permissions-table">Assign Permissions</button>
                              <div class="form-check float-right p-2">
                                <input class="form-check-input" id="check-all-permissions" @checked($data['has_all_permissions']) type="checkbox">
                                <label class="form-check-label" for="check-all-permissions">All</label>
                              </div>
                            </div>
                          </div>
                          <div id="permissions-table" class="collapse show" aria-labelledby="permission-heading" data-parent="#permissionAccordion">
                            <div class="card-body">
                              <table class="table table-bordered">
                                <thead>
                                  <tr>
                                    <th>Module</th>
                                    <th>Permissions</th>
                                  </tr>
                                  <tbody>
                                    @foreach($data['modules'] as $moduleKey => $module)
                                      <tr>
                                        <td>
                                          <div class="form-check">
                                            <input @checked($module->hasAnyPermission($data['role']->id)) class="form-check-input module" type="checkbox" id="module-{{ $moduleKey }}">
                                            <label class="form-check-label" for="module-{{ $moduleKey }}">{{ $module->name }}</label>
                                          </div>
                                        </td>
                                        <td>
                                          @foreach($module->menus as $menuKey => $menu)
                                            <div class="form-check">
                                              <input @checked(in_array($menu->permission, $data['permissions'])) name="permissions[]" class="form-check-input permission" type="checkbox" value="{{ $menu->permission }}" id="menu-{{ "{$moduleKey}-{$menuKey}" }}">
                                              <label class="form-check-label" for="menu-{{ "{$moduleKey}-{$menuKey}" }}">{{ $menu->name }}</label>
                                            </div>
                                          @endforeach
                                        </td>
                                      </tr>
                                    @endforeach
                                  </tbody>
                                </thead>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <button class="btn btn-success" id="btn-update-role">Update</button>
                    <a class="btn btn-danger" href="{{ route('role.index') }}">Back</a>
                  </form>
                </div>
                <!-- /.card-body -->
              </div>
            @else
              <div class="alert alert-warning w-100">
                <strong>Warning</strong> The Super Admin Role can not be Edit.
              </div>
            @endif
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
  </div>
@endsection
@section('scripts')
<script src="{{ url('/assets/js/role.js') }}"></script>
@endsection
