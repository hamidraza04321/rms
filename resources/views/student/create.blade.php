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
                <div class="card-title"><i class="fa fa-user-plus"></i>&nbsp; {{ $data['page_title'] }}</div>
              </div>
              <div class="card-body">
                <input type="hidden" id="image-preview" data-src="{{ url('/assets/dist/img/avatar.jpg') }}">
                <form action="{{ route('student.store') }}" id="create-student-form" enctype="multipart/form-data">
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
                                    <div class="image-preview" style="background-image: url({{ url('/assets/dist/img/avatar.jpg') }});">
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label>Admission No <span class="error">*</span></label>
                                  <input type="text" name="admission_no" id="admission-no" class="form-control" placeholder="Enter Admission No">
                                </div>
                                <div class="form-group">
                                  <label>Section <span class="error">*</span></label>
                                  <select name="section_id" id="section-id" disabled class="select2 form-control">
                                    <option value="">Select</option>
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label>Roll No <span class="error">*</span></label>
                                  <input type="text" name="roll_no" id="roll-no" class="form-control" placeholder="Enter Roll No">
                                </div>
                                <div class="form-group">
                                  <label>Group </label>
                                  <select name="group_id" id="group-id" disabled class="select2 form-control">
                                    <option value="">Select</option>
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label>Class <span class="error">*</span></label>
                                  <select name="class_id" id="class-id" class="select2 form-control">
                                    <option value="">Select</option>
                                    @foreach($data['classes'] as $class)
                                      <option value="{{ $class->id }}">{{ $class->name }}</option>
                                    @endforeach
                                  </select>
                                </div>
                                <div class="form-group">
                                  <label>First Name <span class="error">*</span></label>
                                  <input type="text" name="first_name" id="first-name" class="form-control" placeholder="Enter First Name">
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label>Last Name</label>
                                  <input type="text" name="last_name" id="last-name" class="form-control" placeholder="Enter Last Name">
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label>Gender <span class="error">*</span></label>
                                  <select name="gender" id="gender" class="select2 form-control">
                                    <option value="">Select</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label>Date of Birth</label>
                                  <input type="text" name="dob" id="dob" class="form-control date-picker" placeholder="Enter Date of Birth" />
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label>Religion</label>
                                  <input type="text" name="religion" id="religion" class="form-control" placeholder="Enter Religion">
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label>Caste</label>
                                  <input type="text" name="caste" id="caste" class="form-control"  placeholder="Enter Caste">
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label>Mobile No</label>
                                  <input type="text" name="mobile_no" id="mobile-no" class="form-control" placeholder="Enter Mobile No">
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label>Email</label>
                                  <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email">
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label>Admission Date</label>
                                  <input type="text" name="admission_date" id="admission-date" class="form-control date-picker" placeholder="Enter Date of Admission">
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
                                    <div class="image-preview" style="background-image: url({{ url('/assets/dist/img/avatar.jpg') }});">
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label>Father Name</label>
                                  <input type="text" name="father_name" id="father-name" class="form-control" placeholder="Enter Father Name">
                                </div>
                                <div class="form-group">
                                  <label>Father Phone </label>
                                  <input type="text" name="father_phone" id="father-phone" class="form-control" placeholder="Enter Father Phone">
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label>Father Email</label>
                                  <input type="email" name="father_email" id="father-email" class="form-control" placeholder="Enter Father Email">
                                </div>
                                <div class="form-group">
                                  <label>Father Occupation </label>
                                  <input type="text" name="father_occupation" id="father-occupation" class="form-control" placeholder="Enter Father Occupation">
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label>Father CNIC Number</label>
                                  <input type="email" name="father_cnic" id="father-cnic" class="form-control" placeholder="Enter Father CNIC Number">
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
                                    <div class="image-preview" style="background-image: url({{ url('/assets/dist/img/avatar.jpg') }});">
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label>Mother Name</label>
                                  <input type="text" name="mother_name" id="mother-name" class="form-control" placeholder="Enter Mother Name">
                                </div>
                                <div class="form-group">
                                  <label>Mother Phone </label>
                                  <input type="text" name="mother_phone" id="mother-phone" class="form-control" placeholder="Enter Mother Phone">
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label>Mother Email</label>
                                  <input type="email" name="mother_email" id="mother-email" class="form-control" placeholder="Enter Mother Email">
                                </div>
                                <div class="form-group">
                                  <label>Mother Occupation </label>
                                  <input type="text" name="mother_occupation" id="mother-occupation" class="form-control" placeholder="Enter Mother Occupation">
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label>Mother CNIC Number</label>
                                  <input type="text" name="mother_cnic" id="mother-cnic" class="form-control" placeholder="Enter Mother CNIC Number">
                                </div>
                              </div>
                            </div>
                            <hr>
                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group d-flex mb-0">
                                  <label>Guardian Is <span class="error">*</span></label>
                                  <div class="custom-control custom-radio ml-3">
                                    <input class="custom-control-input" type="radio" value="father" id="guardian-is-father" checked name="guardian_is">
                                    <label for="guardian-is-father" class="custom-control-label">Father</label>
                                  </div>
                                  <div class="custom-control custom-radio ml-3">
                                    <input class="custom-control-input" type="radio" value="mother" id="guardian-is-mother" name="guardian_is">
                                    <label for="guardian-is-mother" class="custom-control-label">Mother</label>
                                  </div>
                                  <div class="custom-control custom-radio ml-3">
                                    <input class="custom-control-input" type="radio" value="other" id="guardian-is-other" name="guardian_is">
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
                                    <div class="image-preview" style="background-image: url({{ url('/assets/dist/img/avatar.jpg') }});">
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label>Guardian Name <span class="error">*</span></label>
                                  <input type="text" name="guardian_name" id="guardian-name" class="form-control" placeholder="Enter Guardian Name">
                                </div>
                                <div class="form-group">
                                  <label>Guardian Phone <span class="error">*</span></label>
                                  <input type="text" name="guardian_phone" id="guardian-phone" class="form-control" placeholder="Enter Guardian Phone">
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label>Guardian Email</label>
                                  <input type="email" name="guardian_email" id="guardian-email" class="form-control" placeholder="Enter Guardian Email">
                                </div>
                                <div class="form-group">
                                  <label>Guardian Relation </label>
                                  <input type="text" name="guardian_relation" id="guardian-relation" class="form-control" placeholder="Enter Guardian Relation">
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label>Guardian CNIC Number </label>
                                  <input type="text" name="guardian_cnic" id="guardian-cnic" class="form-control" placeholder="Enter Guardian CNIC Number">
                                </div>
                                <div class="form-group">
                                  <label>Guardian Occupation </label>
                                  <input type="text" name="guardian_occupation" id="guardian-occupation" class="form-control" placeholder="Enter Guardian Occupation">
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
                                <textarea name="current_address" id="current-address" class="form-control" placeholder="Enter Current Address"></textarea>
                              </div>
                              <div class="col-md-6">
                                <label>Permenant Address</label>
                                <textarea name="permenant_address" id="permenant-address" class="form-control" placeholder="Enter Permenant Address"></textarea>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <button class="btn btn-success" id="btn-save-student">Save</button>
                <a class="btn btn-danger" href="{{ route('student.index') }}">Back</a>
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
  <script src="{{ url('/assets/js/student.js') }}"></script>
@endsection
