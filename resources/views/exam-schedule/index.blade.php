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
                <div class="card-title"><i class="fa fa-calendar-week"></i> {{ $data['page_title'] }}</div>
                <div class="card-tools">
                  @can('create-class')
                    <a href="{{ route('exam-schedule.create') }}" class="btn btn-sm btn-info"> <i class="fa fa-plus"></i> Create Exam Schedule</a>
                  @endcan
                </div>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table id="prepared-exam-schedule-table" class="table table-bordered table-hover datatable">
                    <thead>
                      <tr>
                        <th>Sesion</th>
                        <th>Exam</th>
                        <th>Class</th>
                        <th>Group</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($data['exam_schedules'] as $exam_schedule)
                        <tr>
                          <td>{{ $exam_schedule->exam->session->name }}</td>
                          <td>
                            <span class="exam-name">{{ $exam_schedule->exam->name }}</span>
                          </td>
                          <td>
                            <span class="class-name">{{ $exam_schedule->class->name }}</span>
                          </td>
                          <td>{{ $exam_schedule->group->name }}</td>
                          <td>
                            <button class="btn btn-sm btn-primary btn-edit-exam-schedule" session-id="{{ $exam_schedule->exam->session_id }}" exam-id="{{ $exam_schedule->exam_id }}" class-id="{{ $exam_schedule->class_id }}" group-id="{{ $exam_schedule->group_id }}"><i class="fa fa-edit"></i> Edit</button>
                            <button class="btn btn-sm btn-danger btn-destroy-exam-schedule" data-url="{{ route('exam-schedule.destroy', $exam_schedule->id) }}"><i class="fa fa-trash"></i> Delete</button>
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

  <!-- Modal edit exam schedule -->
  <div class="modal fade" id="edit-exam-schedule" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Exam Schedule ( <span class="exam-name"></span> ) <span class="class-name"></span></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-success btn-save-exam-schedule">Save</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
@endsection
@section('scripts')
<script src="{{ url('/assets/js/exam-schedule.js') }}"></script>
@endsection