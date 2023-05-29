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
            @if(!$data['user']->hasRole('Super Admin'))
              <div class="card card-primary card-outline">
                <div class="card-header">
                  <div class="card-title"><i class="fa fa-edit"></i> {{ $data['page_title'] }}</div>
                </div>
                <div class="card-body">
                  <form action="{{ route('user.update', $data['user']->id) }}" id="update-user-form">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Name <span class="error">*</span></label>
                          <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name" value="{{ $data['user']->name }}">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Email <span class="error">*</span></label>
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
                          <label>Role <span class="error">*</span></label>
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
                                <input @checked($data['has_all_permissions']) class="form-check-input" id="check-all-permissions" type="checkbox">
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
                                            <input @checked(in_array($class->id, $data['user_classes'])) class="form-check-input class-permission" type="checkbox" name="class_id[{{ $class->id }}]" value="{{ $class->id }}" id="class-{{ $classKey }}">
                                            <label class="form-check-label" for="class-{{ $classKey }}">{{ $class->name }}</label>
                                          </div>
                                        </td>
                                        <td>
                                          @foreach($class->sections as $sectionKey => $section)
                                            <div class="form-check">
                                              <input @checked(in_array($section->id, $data['user_class_sections'])) class="form-check-input permission" type="checkbox" name="class_section_id[]" value="{{ $section->id }}" id="class-section-{{ $section->id }}">
                                              <label class="form-check-label" for="class-section-{{ $section->id }}">{{ $section->section->name }}</label>
                                            </div>
                                          @endforeach
                                        </td>
                                        <td>
                                          @foreach($class->subjects as $subjectKey => $subject)
                                            <div class="form-check">
                                              <input @checked(in_array($subject->id, $data['user_class_subjects'])) class="form-check-input permission" type="checkbox" name="class_subject_id[]" value="{{ $subject->id }}" id="class-subject-{{ $subject->id }}">
                                              <label class="form-check-label" for="class-subject-{{ $subject->id }}">{{ $subject->subject->name }}</label>
                                            </div>
                                          @endforeach
                                        </td>
                                        <td>
                                          @foreach($class->groups as $groupKey => $group)
                                            <div class="form-check">
                                              <input @checked(in_array($group->id, $data['user_class_groups'])) class="form-check-input permission" type="checkbox" name="class_group_id[]" value="{{ $group->id }}" id="class-group-{{ $group->id }}">
                                              <label class="form-check-label" for="class-group-{{ $group->id }}">{{ $group->group->name }}</label>
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
            @else
              <div class="alert alert-warning w-100">
                <strong>Warning !</strong> The Super Admin User they have default all permission if you want to change their name, password etc. go to <a href="#">profile</a>
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
<script src="{{ url('/assets/js/user.js') }}"></script>
@endsection
