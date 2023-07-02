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
                <div class="card-title"><i class="fa fa-users-cog"></i> {{ $data['page_title'] }}</div>
                <div class="card-tools">
                  @can('create-class')
                    <a href="{{ route('exam-schedule.create') }}" class="btn btn-sm btn-info"> <i class="fa fa-plus"></i> Create Exam Schedule</a>
                  @endcan
                </div>
              </div>
              <div class="card-body">
                <table class="table table-bordered table-hover datatable">
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
                        <td>{{ $exam_schedule->exam->name }}</td>
                        <td>{{ $exam_schedule->class->name }}</td>
                        <td>{{ $exam_schedule->group->name }}</td>
                        <td>
                          <button class="btn btn-sm btn-danger" data-id="{{ $exam_schedule->id }}"><i class="fa fa-trash"></i> Delete</button>
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
<script src="{{ url('/assets/js/exam-schedule.js') }}"></script>
@endsection