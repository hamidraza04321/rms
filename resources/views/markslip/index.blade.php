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

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="accordion" id="markslip-filters">
              <div class="card card-primary card-outline">
                <div class="card-header" id="markslip-filter-heading">
                  <div class="d-flex">
                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#markslip-filters-table" aria-expanded="true" aria-controls="markslip-filters-table">
                      <i class="fa fa-filter"></i> Filters
                    </button>
                  </div>
                </div>
                <div id="markslip-filters-table" class="collapse show" aria-labelledby="markslip-filter-heading" data-parent="#student-filters">
                  <div class="card-body">
                    <form action="{{ route('search.markslip') }}" id="search-markslip-form">
                      <div class="row">
                        <div class="col-md-4">
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
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Exam</label>
                            <select name="exam_id" id="exam-id" class="select2 form-control">
                              <option value="">Select</option>
                              @foreach($data['exams'] as $exam)
                                <option value="{{ $exam->id }}">{{ $exam->name }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Class</label>
                            <select name="class_id" id="class-id" disabled class="select2 form-control">
                              <option value="">Select</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Section</label>
                            <select name="section_id" id="section-id" disabled class="select2 form-control">
                              <option value="">Select</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Group </label>
                            <select name="group_id" id="group-id" disabled class="select2 form-control">
                              <option value="">Select</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Subject </label>
                            <select name="subject_id" id="subject-id" disabled class="select2 form-control">
                              <option value="">Select</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12 text-right">
                          <button id="btn-search-markslip" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
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
                <div class="card-title"><i class="fas fa-paste"></i> {{ $data['page_title'] }}</div>
                <div class="card-tools">
                  @can('create-markslip')
                    <a href="{{ route('markslip.create') }}" class="btn btn-sm btn-info"> <i class="fa fa-plus"></i> Create Markslip</a>
                  @endcan
                </div>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table id="markslip-table" class="table table-bordered table-hover no-wrap datatable">
                    <thead>
                      <tr>
                        <th>Session</th>
                        <th>Exam</th>
                        <th>Class</th>
                        <th>Section</th>
                        <th>Group</th>
                        <th>Subject</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($data['markslips'] as $markslip)
                        <tr>
                          <td>{{ $markslip->examClass->exam->session->name }}</td>
                          <td>{{ $markslip->examClass->exam->name }}</td>
                          <td>{{ $markslip->examClass->class->name }}</td>
                          <td>{{ $markslip->section->name }}</td>
                          <td>{{ $markslip->examClass->group->name ?? '-' }}</td>
                          <td>{{ $markslip->subject->name }}</td>
                          <td>
                            @can('edit-markslip')
                              <a href="{{ route('markslip.edit', $markslip->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Edit</a>
                            @endcan
                            @can('print-markslip')
                              <a target="_blank" href="{{ route('markslip.print', $markslip->id) }}" class="btn btn-sm btn-warning text-white"><i class="fa fa-print"></i> Print</a>
                            @endcan
                            @can('delete-markslip')
                              <button class="btn btn-sm btn-danger btn-destroy-markslip" data-url="{{ route('markslip.destroy', $markslip->id) }}"><i class="fa fa-trash"> Delete</i></button>
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
    <!-- /.content-header -->
   </div>
  <!-- Permissions -->
  <input type="hidden" id="edit-permission" @can('edit-markslip') value="true" @endcan>
  <input type="hidden" id="delete-permission" @can('delete-markslip') value="true" @endcan>
@endsection
@section('scripts')
<script src="{{ url('/assets/js/markslip.js') }}"></script>
@endsection