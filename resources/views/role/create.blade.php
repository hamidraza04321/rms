@extends('layout.app')
@section('page-title', $data['page_title'])
@section('styles')
<style>
  .form-check-label {
    font-size: 12px;
  }
</style>
@endsection
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
            <div class="card card-primary card-outline">
              <div class="card-header">
                <div class="card-title"><i class="fa fa-plus-square"></i>&nbsp; {{ $data['page_title'] }}</div>
              </div>
              <div class="card-body">
                <form action="{{ route('role.store') }}" id="create-role-form">
                  <div class="form-group">
                    <label>Name <span class="error">*</span></label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter Role Name">
                  </div>
                  <div class="form-group">
                    <div class="accordion" id="permissionAccordion">
                      <div class="card">
                        <div class="card-header" id="permission-heading">
                          <div class="d-flex">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#permissions-table" aria-expanded="true" aria-controls="permissions-table">
                              Assign Permissions
                            </button>
                            <div class="form-check float-right p-2">
                              <input class="form-check-input" id="check-all-permissions" type="checkbox">
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
                                          <input class="form-check-input module" type="checkbox" id="module-{{ $moduleKey }}">
                                          <label class="form-check-label" for="module-{{ $moduleKey }}">{{ $module->name }}</label>
                                        </div>
                                      </td>
                                      <td class="d-flex">
                                        @foreach($module->menus as $menuKey => $menu)
                                          <div class="form-check">
                                            <input name="permissions[]" class="form-check-input permission" type="checkbox" value="{{ $menu->permission }}" id="menu-{{ "{$moduleKey}-{$menuKey}" }}">
                                            <label class="form-check-label mr-3" for="menu-{{ "{$moduleKey}-{$menuKey}" }}">{{ $menu->name }}</label>
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
                </form>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <button class="btn btn-success" id="btn-save-role">Save</button>
                <a class="btn btn-danger" href="{{ route('role.index') }}">Back</a>
              </div>
            </div>
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
