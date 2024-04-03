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
                <input type="hidden" id="image-preview" data-src="{{ url('/assets/dist/img/avatar.jpg') }}">
                <form action="{{ route('student.update', $data['student_session']->id) }}" id="update-student-form" enctype="multipart/form-data">
                  @method('PUT')
                  <div class="form-group">
                    <div class="accordion" id="student-details">
                      <div class="card">
                        <div class="card-header" id="student-detail-heading">
                          <div class="d-flex">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#student-details-table" aria-expanded="true" aria-controls="student-details-table">
                              Student Details
                            </button>
                          </div>
                        </div>
                        <div id="student-details-table" class="collapse show" aria-labelledby="student-detail-heading" data-parent="#student-details">
                          <div class="card-body">
                            <div class="row">
                              <div class="col-md-3">
                                <label>Student Image</label>
                                <div class="avatar-upload">
                                  <div class="avatar-edit">
                                    <input type="file" name="student_image" id="student-image" accept=".png, .jpg, .jpeg" />
                                    <label for="student-image"><i class="fas fa-camera"></i></label>
                                  </div>
                                  <div class="avatar-preview">
                                    @if($data['student_session']->student->student_image)
                                      <div class="image-preview" style="background-image: url({{ url('/uploads/student/' . $data['student_session']->student->student_image) }});">
                                      </div>
                                    @else
                                      <div class="image-preview" style="background-image: url({{ url('/assets/dist/img/avatar.jpg') }});">
                                      </div>
                                    @endif
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label>Admission No <span class="error">*</span></label>
                                  <input type="text" name="admission_no" id="admission-no" class="form-control" placeholder="Enter Admission No" value="{{ $data['student_session']->student->admission_no }}">
                                </div>
                                <div class="form-group">
                                  <label>Class <span class="error">*</span></label>
                                  <select name="class_id" id="class-id" class="select2 form-control">
                                    <option value="">Select</option>
                                    @foreach($data['classes'] as $class)
                                      <option @selected($data['student_session']->class_id == $class->id) value="{{ $class->id }}">{{ $class->name }}</option>
                                    @endforeach
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label>Roll No <span class="error">*</span></label>
                                  <input type="text" name="roll_no" id="roll-no" class="form-control" placeholder="Enter Roll No"  value="{{ $data['student_session']->student->roll_no }}">
                                </div>
                                <div class="form-group">
                                  <label>Section <span class="error">*</span></label>
                                  <select name="section_id" id="section-id" class="select2 form-control">
                                    <option value="">Select</option>
                                    @foreach($data['sections'] as $section)
                                      <option @selected($data['student_session']->section_id == $section->id) value="{{ $section->id }}">{{ $section->name }}</option>
                                    @endforeach
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label>Session <span class="error">*</span></label>
                                  <select name="session_id" id="session-id" class="select2 form-control">
                                    <option value="">Select</option>
                                    @foreach($data['sessions'] as $session)
                                      <option @selected($data['student_session']->session_id == $session->id) value="{{ $session->id }}">{{ $session->name }}</option>
                                    @endforeach
                                  </select>
                                </div>
                                <div class="form-group">
                                  <label>Group </label>
                                  <select name="group_id" id="group-id" @disabled(!count($data['groups'])) class="select2 form-control">
                                    <option value="">Select</option>
                                    @foreach($data['groups'] as $group)
                                      <option @selected($data['student_session']->group_id == $group->id) value="{{ $group->id }}">{{ $group->name }}</option>
                                    @endforeach
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label>First Name <span class="error">*</span></label>
                                  <input type="text" name="first_name" id="first-name" class="form-control" placeholder="Enter First Name" value="{{ $data['student_session']->student->first_name }}">
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label>Last Name</label>
                                  <input type="text" name="last_name" id="last-name" class="form-control" placeholder="Enter Last Name" value="{{ $data['student_session']->student->last_name }}">
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label>Gender <span class="error">*</span></label>
                                  <select name="gender" id="gender" class="select2 form-control">
                                    <option value="">Select</option>
                                    <option @selected($data['student_session']->student->gender == 'male') value="male">Male</option>
                                    <option @selected($data['student_session']->student->gender == 'female') value="female">Female</option>
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label>Date of Birth <span class="error">*</span></label>
                                  <input type="text" name="dob" id="dob" class="form-control date-picker" placeholder="Enter Date of Birth"  value="{{ $data['student_session']->student->dob->format($settings->date_format) }}">
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-2">
                                <div class="form-group">
                                  <label>Religion</label>
                                  <input type="text" name="religion" id="religion" class="form-control" value="{{ $data['student_session']->student->religion }}">
                                </div>
                              </div>
                              <div class="col-md-2">
                                <div class="form-group">
                                  <label>Caste</label>
                                  <input type="text" name="caste" id="caste" class="form-control" value="{{ $data['student_session']->student->caste }}">
                                </div>
                              </div>
                              <div class="col-md-2">
                                <div class="form-group">
                                  <label>Mobile No</label>
                                  <input type="text" name="mobile_no" id="mobile-no" class="form-control" value="{{ $data['student_session']->student->mobile_no }}">
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label>Email</label>
                                  <input type="email" name="email" id="email" class="form-control" value="{{ $data['student_session']->student->email }}">
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label>Admission Date</label>
                                  <input type="text" name="admission_date" id="admission-date" class="form-control" value="{{ $data['student_session']->student->admission_date->format($settings->date_format) }}">
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="accordion" id="parent-details">
                      <div class="card">
                        <div class="card-header" id="parent-detail-heading">
                          <div class="d-flex">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#parent-details-table" aria-expanded="true" aria-controls="parent-details-table">
                              Parents / Guardian Details
                            </button>
                          </div>
                        </div>
                        <div id="parent-details-table" class="collapse show" aria-labelledby="parent-detail-heading" data-parent="#parent-details">
                          <div class="card-body">
                            <div class="row">
                              <div class="col-md-3">
                                <label>Father Image</label>
                                <div class="avatar-upload">
                                  <div class="avatar-edit">
                                    <input type="file" name="father_image" id="father-image" accept=".png, .jpg, .jpeg" />
                                    <label for="father-image"><i class="fas fa-camera"></i></label>
                                  </div>
                                  <div class="avatar-preview">
                                    @if($data['student_session']->student->father_image)
                                      <div class="image-preview" style="background-image: url({{ url('/uploads/student/' . $data['student_session']->student->father_image) }});">
                                      </div>
                                    @else
                                      <div class="image-preview" style="background-image: url({{ url('/assets/dist/img/avatar.jpg') }});">
                                      </div>
                                    @endif
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label>Father Name</label>
                                  <input type="text" name="father_name" id="father-name" class="form-control" placeholder="Enter Father Name" value="{{ $data['student_session']->student->father_name }}">
                                </div>
                                <div class="form-group">
                                  <label>Father Phone </label>
                                  <input type="text" name="father_phone" id="father-phone" class="form-control" placeholder="Enter Father Phone" value="{{ $data['student_session']->student->father_phone }}">
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label>Father Email</label>
                                  <input type="email" name="father_email" id="father-email" class="form-control" placeholder="Enter Father Email" value="{{ $data['student_session']->student->father_email }}">
                                </div>
                                <div class="form-group">
                                  <label>Father Occupation </label>
                                  <input type="text" name="father_occupation" id="father-occupation" class="form-control" placeholder="Enter Father Occupation" value="{{ $data['student_session']->student->father_occupation }}">
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label>Father CNIC Number</label>
                                  <input type="email" name="father_cnic" id="father-cnic" class="form-control" placeholder="Enter Father CNIC Number" value="{{ $data['student_session']->student->father_cnic }}">
                                </div>
                              </div>
                            </div>
                            <hr>
                            <div class="row">
                              <div class="col-md-3">
                                <label>Mother Image</label>
                                <div class="avatar-upload">
                                  <div class="avatar-edit">
                                    <input type="file" name="mother_image" id="mother-image" accept=".png, .jpg, .jpeg" />
                                    <label for="mother-image"><i class="fas fa-camera"></i></label>
                                  </div>
                                  <div class="avatar-preview">
                                    @if($data['student_session']->student->mother_image)
                                      <div class="image-preview" style="background-image: url({{ url('/uploads/student/' . $data['student_session']->student->mother_image) }});">
                                      </div>
                                    @else
                                      <div class="image-preview" style="background-image: url({{ url('/assets/dist/img/avatar.jpg') }});">
                                      </div>
                                    @endif
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label>Mother Name</label>
                                  <input type="text" name="mother_name" id="mother-name" class="form-control" placeholder="Enter Mother Name" value="{{ $data['student_session']->student->mother_name }}">
                                </div>
                                <div class="form-group">
                                  <label>Mother Phone </label>
                                  <input type="text" name="mother_phone" id="mother-phone" class="form-control" placeholder="Enter Mother Phone" value="{{ $data['student_session']->student->mother_phone }}">
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label>Mother Email</label>
                                  <input type="email" name="mother_email" id="mother-email" class="form-control" placeholder="Enter Mother Email" value="{{ $data['student_session']->student->mother_email }}">
                                </div>
                                <div class="form-group">
                                  <label>Mother Occupation </label>
                                  <input type="text" name="mother_occupation" id="mother-occupation" class="form-control" placeholder="Enter Mother Occupation" value="{{ $data['student_session']->student->mother_occupation }}">
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label>Mother CNIC Number</label>
                                  <input type="text" name="mother_cnic" id="mother-cnic" class="form-control" placeholder="Enter Mother CNIC Number" value="{{ $data['student_session']->student->mother_cnic }}">
                                </div>
                              </div>
                            </div>
                            <hr>
                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group d-flex mb-0">
                                  <label>Guardian Is <span class="error">*</span></label>
                                  <div class="custom-control custom-radio ml-3">
                                    <input class="custom-control-input" type="radio" value="father" id="guardian-is-father" @checked($data['student_session']->student->guardian_is == 'father') name="guardian_is">
                                    <label for="guardian-is-father" class="custom-control-label">Father</label>
                                  </div>
                                  <div class="custom-control custom-radio ml-3">
                                    <input class="custom-control-input" type="radio" value="mother" id="guardian-is-mother" @checked($data['student_session']->student->guardian_is == 'mother') name="guardian_is">
                                    <label for="guardian-is-mother" class="custom-control-label">Mother</label>
                                  </div>
                                  <div class="custom-control custom-radio ml-3">
                                    <input class="custom-control-input" type="radio" value="other" id="guardian-is-other" @checked($data['student_session']->student->guardian_is == 'other') name="guardian_is">
                                    <label for="guardian-is-other" class="custom-control-label">Other</label>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <hr>
                            <div class="row">
                              <div class="col-md-3">
                                <label>Guardian Image</label>
                                <div class="avatar-upload">
                                  <div class="avatar-edit">
                                    <input type="file" id="guardian-image" name="guardian_image" accept=".png, .jpg, .jpeg" />
                                    <label for="guardian-image"><i class="fas fa-camera"></i></label>
                                  </div>
                                  <div class="avatar-preview">
                                    @if($data['student_session']->student->guardian_image)
                                      <div class="image-preview" style="background-image: url({{ url('/uploads/student/' . $data['student_session']->student->guardian_image) }});">
                                      </div>
                                    @else
                                      <div class="image-preview" style="background-image: url({{ url('/assets/dist/img/avatar.jpg') }});">
                                      </div>
                                    @endif
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label>Guardian Name <span class="error">*</span></label>
                                  <input type="text" name="guardian_name" id="guardian-name" class="form-control" placeholder="Enter Guardian Name" value="{{ $data['student_session']->student->guardian_name }}">
                                </div>
                                <div class="form-group">
                                  <label>Guardian Phone <span class="error">*</span></label>
                                  <input type="text" name="guardian_phone" id="guardian-phone" class="form-control" placeholder="Enter Guardian Phone" value="{{ $data['student_session']->student->guardian_phone }}">
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label>Guardian Email</label>
                                  <input type="email" name="guardian_email" id="guardian-email" class="form-control" placeholder="Enter Guardian Email" value="{{ $data['student_session']->student->guardian_email }}">
                                </div>
                                <div class="form-group">
                                  <label>Guardian Relation </label>
                                  <input type="text" name="guardian_relation" id="guardian-relation" class="form-control" placeholder="Enter Guardian Relation" value="{{ $data['student_session']->student->guardian_relation }}">
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label>Guardian CNIC Number </label>
                                  <input type="text" name="guardian_cnic" id="guardian-cnic" class="form-control" placeholder="Enter Guardian CNIC Number" value="{{ $data['student_session']->student->guardian_cnic }}">
                                </div>
                                <div class="form-group">
                                  <label>Guardian Occupation </label>
                                  <input type="text" name="guardian_occupation" id="guardian-occupation" class="form-control" placeholder="Enter Guardian Occupation" value="{{ $data['student_session']->student->guardian_occupation }}">
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="accordion" id="address-details">
                      <div class="card">
                        <div class="card-header" id="address-detail-heading">
                          <div class="d-flex">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#address-details-table" aria-expanded="true" aria-controls="address-details-table">
                              Address Details
                            </button>
                          </div>
                        </div>
                        <div id="address-details-table" class="collapse show" aria-labelledby="address-detail-heading" data-parent="#address-details">
                          <div class="card-body">
                            <div class="row">
                              <div class="col-md-6">
                                <label>Current Address</label>
                                <textarea name="current_address" id="current-address" class="form-control">{{ $data['student_session']->student->current_address }}</textarea>
                              </div>
                              <div class="col-md-6">
                                <label>Permenant Address</label>
                                <textarea name="permenant_address" id="permenant-address" class="form-control">{{ $data['student_session']->student->permenant_address }}</textarea>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <button class="btn btn-success" id="btn-update-student">Update</button>
                  <a class="btn btn-danger" href="{{ route('student.index') }}">Back</a>
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
  <script src="{{ url('/assets/js/student.js') }}"></script>
@endsection
