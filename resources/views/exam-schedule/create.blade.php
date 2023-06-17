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
            <div class="accordion" id="exam-schedule-filters">
              <div class="card card-primary card-outline">
                <div class="card-header" id="exam-schedule-filters-heading">
                  <div class="d-flex">
                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#search-exam-schedule" aria-expanded="true" aria-controls="search-exam-schedule">
                      <i class="fa fa-search"></i> Select Criteria
                    </button>
                  </div>
                </div>
                <div id="search-exam-schedule" class="collapse show" aria-labelledby="exam-schedule-filters-heading" data-parent="#exam-schedule-filters">
                  <div class="card-body">
                    <form action="{{ route('get.exam.schedule.table') }}" id="get-exam-schedule-form">
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
                            <label>Exam <span class="error">*</span></label>
                            <select name="exam_id" id="exam-id" class="select2 form-control">
                              <option value="">Select</option>
                              @foreach($data['exams'] as $exam)
                                <option value="{{ $exam->id }}">{{ $exam->name }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label>Class <span class="error">*</span></label>
                            <select name="class_id" id="class-id" disabled class="select2 form-control">
                              <option value="">Select</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label>Group</label>
                            <select name="group_id" id="group-id" disabled class="select2 form-control">
                              <option value="">Select</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12 text-right">
                          <button id="btn-search-exam-schedule" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div id="exam-schedule">
        </div>
      </div>
    </section>    
  </div>
@endsection
@section('scripts')
<script src="{{ url('/assets/js/exam-schedule.js') }}"></script>
@endsection
