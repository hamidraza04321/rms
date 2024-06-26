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
                            <label>Status </label>
                            <select name="is_active" id="status" class="select2 form-control">
                              <option value="">Select</option>
                              <option value="active">Active</option>
                              <option value="deactive">Deactive</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <button id="btn-search-student" class="btn btn-primary mt-30"><i class="fa fa-search"></i> Search</button>
                            @can('export-student')
                              <button id="btn-export-student" data-url="{{ route('student.export') }}" class="btn btn-primary mt-30"><i class="fa fa-file-export"></i> Export</button>
                            @endcan
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
                <div class="card-title"><i class="fa fa-users"></i> {{ $data['page_title'] }}</div>
                <div class="card-tools">
                  @can('create-student')
                    <a href="{{ route('student.create') }}" class="btn btn-sm btn-info"> <i class="fa fa-plus"></i> Create Student</a>
                  @endcan
                  @can('view-student-trash')
                    <a href="{{ route('student.trash') }}" class="btn btn-sm btn-primary"> <i class="fa fa-eye"></i> View Trash</a>
                  @endcan
                </div>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table id="student-table" class="table table-bordered table-hover no-wrap">
                    <thead>
                      <tr>
                        <th>Session</th>
                        <th>Admission No.</th>
                        <th>Roll No.</th>
                        <th>Student Name</th>
                        <th>Father Name</th>
                        <th>Class</th>
                        <th>Group</th>
                        <th>Status</th>
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
                          <td>{{ $student_session->group->name ?? '-' }}</td>
                          <td>
                            @if($student_session->is_active)
                              <button data-url="{{ route('student.update.status', $student_session->id) }}" class="btn btn-sm btn-success btn-update-status">Active</button>
                            @else
                              <button data-url="{{ route('student.update.status', $student_session->id) }}" class="btn btn-sm btn-danger btn-update-status">Deactive</button>
                            @endif
                          </td>
                          <td>
                            @can('edit-student')
                              <a href="{{ route('student.edit', $student_session->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Edit</a>
                            @endcan
                            @can('delete-student')
                              <button class="btn btn-sm btn-danger btn-destroy-student" data-url="{{ route('student.destroy', $student_session->id) }}"><i class="fa fa-trash"> Delete</i></button>
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
  <input type="hidden" id="edit-permission" @can('edit-student') value="true" @endcan>
  <input type="hidden" id="delete-permission" @can('delete-student') value="true" @endcan>
  <input type="hidden" id="update-status-permission" @can('update-student-status') value="true" @endcan>
  <input type="hidden" id="can-any-action-permission" @canany(['edit-student', 'delete-student']) value="true" @endcan>
  <input type="hidden" id="update-status-permission" @can('update-student-status') value="true" @endcan>

@endsection
@section('scripts')
<script src="{{ url('/assets/js/student.js') }}"></script>
@endsection
