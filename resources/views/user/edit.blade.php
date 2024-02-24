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
            <div class="card card-primary card-outline">
              <div class="card-header">
                <div class="card-title"><i class="fa fa-edit"></i> {{ $data['page_title'] }}</div>
              </div>
              <div class="card-body">
                <form action="{{ route('user.update', $data['user']->id) }}" id="update-user-form" enctype="multipart/form-data">
                  @method('PUT')
                  <div class="form-group">
                    <div class="accordion" id="userDetailsAccordion">
                      <div class="card">
                        <div class="card-header" id="permission-heading">
                          <div class="d-flex">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#user-details-table" aria-expanded="true" aria-controls="user-details-table">
                              User Details
                            </button>
                          </div>
                        </div>
                        <div id="user-details-table" class="collapse show" aria-labelledby="permission-heading" data-parent="#userDetailsAccordion">
                          <div class="card-body">
                            <div class="row">
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label>Name <span class="error">*</span></label>
                                  <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name" value="{{ $data['user']->name }}">
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label>User Name <span class="error">*</span></label>
                                  <input type="text" name="username" id="username" class="form-control" placeholder="Enter Username" value="{{ $data['user']->username }}">
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label>Email <span class="error">*</span></label>
                                  <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email" value="{{ $data['user']->email }}">
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label>Password</label>
                                  <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password">
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-3">
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
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label>Phone No</label>
                                  <input type="text" name="phone_no" id="phone-no" class="form-control" placeholder="Enter Phone No" value="{{ $data['user']->userDetail->phone_no }}">
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label>Designation</label>
                                  <input type="text" name="designation" id="designation" class="form-control" placeholder="Enter Designation" value="{{ $data['user']->userDetail->designation }}">
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label>User Image</label>
                                  <input type="file" name="image" id="image" class="form-control">
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label>Age</label>
                                  <input type="text" name="age" id="age" class="form-control" placeholder="Enter Age" value="{{ $data['user']->userDetail->age }}">
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label>Date of Birth</label>
                                  <input type="text" name="date_of_birth" id="date-of-birth" class="form-control date-picker" placeholder="Enter Date of Birth" value="{{ ($data['user']->userDetail->date_of_birth) ? date($settings->date_format, strtotime($data['user']->userDetail->date_of_birth)) : '' }}">
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label>Education</label>
                                  <input type="text" name="education" id="education" class="form-control" placeholder="Enter Education" value="{{ $data['user']->userDetail->education }}">
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label>Location</label>
                                  <input type="text" name="location" id="location" class="form-control" placeholder="Enter Location" value="{{ $data['user']->userDetail->location }}">
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label>Address</label>
                                  <textarea name="address" id="address" class="form-control" placeholder="Enter Address" rows="7">{{ $data['user']->userDetail->address }}</textarea>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label>Skills</label>
                                  <input type="text" name="skills" id="skills" class="form-control" placeholder="Enter Skills" value="{{ $data['user']->userDetail->skills }}">
                                </div>
                                <div class="form-group">
                                  <label>Social Media Links</label>
                                  <div class="row">
                                    <div class="col-md-6" style="margin-bottom: 10px;">
                                      <input type="text" name="facebook_link" id="facebook-link" class="form-control" placeholder="Facebook Link" value="{{ json_decode($data['user']->userDetail->social_media_links)?->facebook }}">
                                    </div>
                                    <div class="col-md-6" style="margin-bottom: 10px;">
                                      <input type="text" name="instagram_link" id="instagram-link" class="form-control" placeholder="Instagram Link" value="{{ json_decode($data['user']->userDetail->social_media_links)?->instagram }}">
                                    </div>
                                    <div class="col-md-6" style="margin-bottom: 10px;">
                                      <input type="text" name="twitter_link" id="twitter-link" class="form-control" placeholder="Twitter Link" value="{{ json_decode($data['user']->userDetail->social_media_links)?->twitter }}">
                                    </div>
                                    <div class="col-md-6" style="margin-bottom: 10px;">
                                      <input type="text" name="youtube_link" id="youtube-link" class="form-control" placeholder="Youtube Link" value="{{ json_decode($data['user']->userDetail->social_media_links)?->youtube }}">
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
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
                              <input @checked($data['has_all_permissions'] || $data['has_super_admin']) class="form-check-input" id="check-all-permissions" type="checkbox">
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
                                          <input @checked(in_array($class->id, $data['user_classes']) || $data['has_super_admin']) class="form-check-input class-permission" type="checkbox" name="class_id[{{ $class->id }}]" value="{{ $class->id }}" id="class-{{ $classKey }}">
                                          <label class="form-check-label" for="class-{{ $classKey }}">{{ $class->name }}</label>
                                        </div>
                                      </td>
                                      <td>
                                        @foreach($class->sections as $sectionKey => $section)
                                          <div class="form-check">
                                            <input @checked(in_array($section->id, $data['user_class_sections']) || $data['has_super_admin']) class="form-check-input permission" type="checkbox" name="class_section_id[]" value="{{ $section->id }}" id="class-section-{{ $section->id }}">
                                            <label class="form-check-label" for="class-section-{{ $section->id }}">{{ $section->section->name }}</label>
                                          </div>
                                        @endforeach
                                      </td>
                                      <td>
                                        @foreach($class->subjects as $subjectKey => $subject)
                                          <div class="form-check">
                                            <input @checked(in_array($subject->id, $data['user_class_subjects']) || $data['has_super_admin']) class="form-check-input permission" type="checkbox" name="class_subject_id[]" value="{{ $subject->id }}" id="class-subject-{{ $subject->id }}">
                                            <label class="form-check-label" for="class-subject-{{ $subject->id }}">{{ $subject->subject->name }}</label>
                                          </div>
                                        @endforeach
                                      </td>
                                      <td>
                                        @foreach($class->groups as $groupKey => $group)
                                          <div class="form-check">
                                            <input @checked(in_array($group->id, $data['user_class_groups']) || $data['has_super_admin']) class="form-check-input permission" type="checkbox" name="class_group_id[]" value="{{ $group->id }}" id="class-group-{{ $group->id }}">
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
                </form>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <button class="btn btn-success" id="btn-update-user">Update</button>
                <a class="btn btn-danger" href="{{ route('user.index') }}">Back</a>
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
<script src="{{ url('/assets/js/user.js') }}"></script>
@endsection
