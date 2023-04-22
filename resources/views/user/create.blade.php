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
                <form action="{{ route('user.store') }}" id="create-user-form">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email">
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
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
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
                              <label class="form-check-label" for="check-all-permissions">All</label>
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
                                  @foreach($data['classes'] as $class)
                                    <tr>
                                      <td>
                                        <div class="form-check">
                                          <input class="form-check-input class-permission" type="checkbox" name="class_id[{{ $class->id }}]" value="{{ $class->id }}" id="class-{{ $class->id }}">
                                          <label class="form-check-label" for="class-{{ $class->id }}">{{ $class->name }}</label>
                                        </div>
                                      </td>
                                      <td>
                                        @foreach($class->sections as $section)
                                          <div class="form-check">
                                            <input class="form-check-input permission" type="checkbox" name="class_section_id[]" value="{{ $section->id }}" id="class-section-{{ $section->id }}">
                                            <label class="form-check-label" for="class-section-{{ $section->id }}">{{ $section->section->name }}</label>
                                          </div>
                                        @endforeach
                                      </td>
                                      <td>
                                        @foreach($class->subjects as $subject)
                                          <div class="form-check">
                                            <input class="form-check-input permission" type="checkbox" name="class_subject_id[]" value="{{ $subject->id }}" id="class-subject-{{ $subject->id }}">
                                            <label class="form-check-label" for="class-subject-{{ $subject->id }}">{{ $subject->subject->name }}</label>
                                          </div>
                                        @endforeach
                                      </td>
                                      <td>
                                        @foreach($class->groups as $group)
                                          <div class="form-check">
                                            <input class="form-check-input permission" type="checkbox" name="class_group_id[]" value="{{ $group->id }}" id="class-group-{{ $group->id }}">
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
                  <button class="btn btn-success" id="btn-save-user">Save</button>
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
