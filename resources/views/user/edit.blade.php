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
            <div class="card">
              <div class="card-header">
                <div class="card-title">{{ $data['page_title'] }}</div>
              </div>
              <div class="card-body">
                <form action="{{ route('user.update', $data['user']->id) }}" id="update-user-form">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name" value="{{ $data['user']->name }}">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email" value="{{ $data['user']->email }}">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Role</label>
                        <select name="role_id" id="role-id" class="form-control select2">
                          <option value="">Select</option>
                          @foreach($data['roles'] as $role)
                            <option @selected($data['role_id'] == $role->id) value="{{ $role->id }}">{{ $role->name }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="accordion" id="permissionAccordion">
                      <div class="card">
                        <div class="card-header" id="permission-heading">
                          <div class="d-flex">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#permissions-table" aria-expanded="true" aria-controls="permissions-table">
                              Class Permissions
                            </button>
                            <div class="form-check float-right p-2">
                              <input class="form-check-input" id="check-all-permissions" type="checkbox">
                              <label class="form-check-label">All</label>
                            </div>
                          </div>
                        </div>
                        <div id="permissions-table" class="collapse show" aria-labelledby="permission-heading" data-parent="#permissionAccordion">
                          <div class="card-body">
                            <table class="table table-bordered">
                              <thead>
                                <tr>
                                  <th>Class</th>
                                  <th>Section</th>
                                  <th>Subject</th>
                                  <th>Group</th>
                                </tr>
                                <tbody>
                                  @foreach($data['classes'] as $classKey => $class)
                                    <tr>
                                      <td>
                                        <div class="form-check">
                                          <input @checked($class->hasClassPermission($data['user']->id)) class="form-check-input class-permission" type="checkbox" name="permissions[{{ $class->id }}]" value="{{ $class->id }}" id="class-{{ $classKey }}">
                                          <label class="form-check-label" for="class-{{ $classKey }}">{{ $class->name }}</label>
                                        </div>
                                      </td>
                                      <td>
                                        @foreach($class->sections as $sectionKey => $section)
                                          <div class="form-check">
                                            <input @checked($section->hasSectionPermission($data['user']->id)) class="form-check-input permission" type="checkbox" name="permissions[{{ $class->id }}][section_id][]" value="{{ $section->section->id }}" id="section-{{ "{$classKey}-{$sectionKey}" }}">
                                            <label class="form-check-label" for="section-{{ "{$classKey}-{$sectionKey}" }}">{{ $section->section->name }}</label>
                                          </div>
                                        @endforeach
                                      </td>
                                      <td>
                                        @foreach($class->subjects as $subjectKey => $subject)
                                          <div class="form-check">
                                            <input @checked($subject->hasSubjectPermission($data['user']->id)) class="form-check-input permission" type="checkbox" name="permissions[{{ $class->id }}][subject_id][]" value="{{ $subject->subject->id }}" id="subject-{{ "{$classKey}-{$subjectKey}" }}">
                                            <label class="form-check-label" for="subject-{{ "{$classKey}-{$subjectKey}" }}">{{ $subject->subject->name }}</label>
                                          </div>
                                        @endforeach
                                      </td>
                                      <td>
                                        @foreach($class->groups as $groupKey => $group)
                                          <div class="form-check">
                                            <input @checked($group->hasGroupPermission($data['user']->id)) class="form-check-input permission" type="checkbox" name="permissions[{{ $class->id }}][group_id][]" value="{{ $group->group->id }}" id="group-{{ "{$classKey}-{$groupKey}" }}">
                                            <label class="form-check-label" for="group-{{ "{$classKey}-{$groupKey}" }}">{{ $group->group->name }}</label>
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
                  <button class="btn btn-success" id="btn-update-user">Update</button>
                  <a class="btn btn-danger" href="{{ route('user.index') }}">Back</a>
                </form>
              </div>
              <!-- /.card-body -->
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
<script src="{{ url('/assets/js/user.js') }}"></script>
@endsection
