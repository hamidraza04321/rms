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
            <div class="accordion" id="student-filters">
              <div class="card card-primary card-outline">
                <div class="card-header" id="student-filter-heading">
                  <div class="d-flex">
                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#student-filters-table" aria-expanded="true" aria-controls="student-filters-table">
                      <i class="fa fa-filter"></i> Filters
                    </button>
                  </div>
                </div>
                <div id="student-filters-table" class="collapse show" aria-labelledby="student-filter-heading" data-parent="#student-filters">
                  <div class="card-body">
                    <form action="{{ route('student.search') }}" id="search-student-form">
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
                            <label>Section</label>
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
                            <label>Gender </label>
                            <select name="gender" id="gender" class="select2 form-control">
                              <option value="">Select</option>
                              <option value="male">Male</option>
                              <option value="female">Female</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <button id="btn-search-student-from-trash" class="btn btn-primary mt-30" data-action="from_trash"><i class="fa fa-search"></i> Search</button>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <div class="card-title"><i class="fa fa-trash"></i> {{ $data['page_title'] }}</div>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table id="student-trash-table" class="table table-bordered table-hover no-wrap">
                    <thead>
                      <tr>
                        <th>Session</th>
                        <th>Admission No.</th>
                        <th>Roll No.</th>
                        <th>Student Name</th>
                        <th>Father Name</th>
                        <th>Class</th>
                        <th>Group</th>
                        <th>Deleted At</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($data['student_session'] as $student_session)
                        <tr>
                          <td>{{ $student_session->session->name }}</td>
                          <td>{{ $student_session->student->admission_no }}</td>
                          <td>{{ $student_session->student->roll_no }}</td>
                          <td>{{ $student_session->student->fullName() }}</td>
                          <td>{{ $student_session->student->father_name }}</td>
                          <td>{{ $student_session->class->name }} ( {{ $student_session->section->name }} )</td>
                          <td>{{ $student_session->group->name ?? null }}</td>
                          <td>{{ $student_session->deleted_at->diffForHumans() }}</td>
                          <td>
                            @can('restore-student')
                              <button class="btn btn-sm btn-success btn-restore-student" data-url="{{ route('student.restore', $student_session->id) }}"><i class="fa fa-trash-restore"> Restore</i></button>
                            @endcan
                            @can('permanent-delete-student')
                              <button class="btn btn-sm btn-danger btn-delete-student" data-url="{{ route('student.delete', $student_session->id) }}"><i class="fa fa-trash"></i> Permanent Delete</button>
                            @endcan
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
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

  <!-- Permissions -->
  <input type="hidden" id="restore-permission" @can('restore-student') value="true" @endcan>
  <input type="hidden" id="permenant-delete-permission" @can('permanent-delete-student') value="true" @endcan>
  <input type="hidden" id="can-any-action-permission-from-trash" @canany(['restore-student', 'permanent-delete-student']) value="true" @endcanany>

@endsection
@section('scripts')
<script src="{{ url('/assets/js/student.js') }}"></script>
@endsection
