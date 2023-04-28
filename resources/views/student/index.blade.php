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
                <div class="card-title">Filters</div>
              </div>
              <div class="card-body">
                <form action="{{ route('student.search') }}" id="search-student-form">
                  <div class="row">
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
                  </div>
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Status </label>
                        <select name="status" id="status" class="select2 form-control">
                          <option value="">Select</option>
                          <option value="1">Active</option>
                          <option value="2">Deactive</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <button id="btn-search-student" class="btn btn-primary" style="margin-top: 30px;"><i class="fa fa-search"></i> Search</button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div class="card-title">{{ $data['page_title'] }}</div>
                <div class="card-tools">
                  <a href="{{ route('student.create') }}" class="btn btn-sm btn-info"> <i class="fa fa-plus"></i> Create Student</a>
                </div>
              </div>
              <div class="card-body">
                <table id="student-table" class="table table-bordered table-hover datatable">
                  <thead>
                    <tr>
                      <th>S No.</th>
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
                    @foreach($data['students'] as $student)
                      <tr>
                        <td>{{ ++$loop->index }}</td>
                        <td>{{ $student->admission_no }}</td>
                        <td>{{ $student->roll_no }}</td>
                        <td>{{ $student->fullName() }}</td>
                        <td>{{ $student->father_name }}</td>
                        <td>{{ $student->class->name }} ( {{ $student->section->name }} )</td>
                        <td>{{ $student->group->name ?? '-' }}</td>
                        <td>
                          @if($student->is_active)
                            <button data-url="{{ route('student.update.status', $student->id) }}" class="btn btn-sm btn-success btn-update-status">Active</button>
                          @else
                            <button data-url="{{ route('student.update.status', $student->id) }}" class="btn btn-sm btn-danger btn-update-status">Deactive</button>
                          @endif
                        </td>
                        <td>
                          <a href="{{ route('student.edit', $student->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Edit</a>
                          <button class="btn btn-sm btn-danger btn-destroy-student" data-url="{{ route('student.destroy', $student->id) }}"><i class="fa fa-trash"> Delete</i></button>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
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
