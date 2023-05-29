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
                <div class="card-title"><i class="fa fa-file-import"></i>&nbsp; {{ $data['page_title'] }}</div>
                <div class="card-tools">
                  <a href="{{ route('student.import.download.sample') }}" class="btn btn-sm btn-info"> <i class="fa fa-download"></i> Download Sample</a>
                </div>
              </div>
              <div class="row mt-4">
                <div class="col-md-12">
                  <ol>
                    <li>The import file must be in CSV, Xlsx, Xls format.</li>
                    <li>The All fields(<span class="error"> * </span>) has required.</li>
                    <li>For Student Gender use (<strong>Male, Female</strong>) value.</li>
                    <li>For Student Guardian Is use (<strong>Father, Mother, other</strong>) value.</li>
                    <li>The Roll No must be unique for every class in session.</li>
                  </ol>
                </div>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered no-wrap">
                    <thead>
                      <tr>
                        <th>Admission No <span class="error">*</span></th>
                        <th>Roll No <span class="error">*</span></th>
                        <th>First Name <span class="error">*</span></th>
                        <th>Last Name</th>
                        <th>Gender <span class="error">*</span></th>
                        <th>Date of Birth</th>
                        <th>Religion</th>
                        <th>Caste</th>
                        <th>Mobile No</th>
                        <th>Email</th>
                        <th>Admission Date</th>
                        <th>Father Name</th>
                        <th>Father Email</th>
                        <th>Father CNIC</th>
                        <th>Father Phone</th>
                        <th>Father Occupation</th>
                        <th>Mother Name</th>
                        <th>Mother Email</th>
                        <th>Mother CNIC</th>
                        <th>Mother Phone</th>
                        <th>Mother Occupation</th>
                        <th>Guardian Is <span class="error">*</span></th>
                        <th>Guardian Name <span class="error">*</span></th>
                        <th>Guardian Email</th>
                        <th>Guardian CNIC</th>
                        <th>Guardian Phone <span class="error">*</span></th>
                        <th>Guardian Relation</th>
                        <th>Guardian Occupation</th>
                        <th>Current Address</th>
                        <th>Permenant Address</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Data</td>
                        <td>Data</td>
                        <td>Data</td>
                        <td>Data</td>
                        <td>Data</td>
                        <td>Data</td>
                        <td>Data</td>
                        <td>Data</td>
                        <td>Data</td>
                        <td>Data</td>
                        <td>Data</td>
                        <td>Data</td>
                        <td>Data</td>
                        <td>Data</td>
                        <td>Data</td>
                        <td>Data</td>
                        <td>Data</td>
                        <td>Data</td>
                        <td>Data</td>
                        <td>Data</td>
                        <td>Data</td>
                        <td>Data</td>
                        <td>Data</td>
                        <td>Data</td>
                        <td>Data</td>
                        <td>Data</td>
                        <td>Data</td>
                        <td>Data</td>
                        <td>Data</td>
                        <td>Data</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <hr>
                <form action="{{ route('student.import') }}" id="import-student-form" enctype="multipart/form-data">
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Session</label>
                        <select name="session_id" id="session-id" class="select2 form-control">
                          <option value="">Select</option>
                          @foreach($data['sessions'] as $session)
                            <option @selected($session->id == $settings->current_session_id) value="{{ $session->id }}">{{ $session->name }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Class</label>
                        <select name="class_id" id="class-id" class="select2 form-control">
                          <option value="">Select</option>
                          @foreach($data['classes'] as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Section <span class="error">*</span></label>
                        <select name="section_id" id="section-id" disabled class="select2 form-control">
                          <option value="">Select</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Group </label>
                        <select name="group_id" id="group-id" disabled class="select2 form-control">
                          <option value="">Select</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Import File</label>
                        <div class="input-group">
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" name="import_file" id="import-file">
                            <label class="custom-file-label" for="import-file">Choose file</label>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3" style="margin-top: 32px;">
                      <button class="btn btn-primary" id="btn-import-student"><i class="fa fa-file-import"></i> Import</button>
                    </div>
                  </div>
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

  <div class="modal fade-in-center" id="import-progress-modal" style="display: none;" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body">
          <div class="d-flex">
            <p class="loading-dots w-50">Importing</p>
            <p class="text-right w-50">Complete <span class="import-percentage"></span>%</p>
          </div>
          <div class="progress">
            <div class="impor-progress-bar progress-bar bg-primary progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade-in-center" id="import-errors-modal" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" style="color: red;"><i class="fa fa-exclamation-triangle"></i> Error </h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body" id="import-errors-modal-body">
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade-in-center" id="import-success-modal" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" style="color: green;"><i class="fa fa-check"></i> Success </h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body" id="import-success-modal-body">
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" style="float: right;" data-dismiss="modal">Ok</button>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
<script src="{{ url('/assets/js/student.js') }}"></script>
@endsection
