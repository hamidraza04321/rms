@extends('layout.app')
@section('page-title', $data['page_title'])
@section('styles')
<style>
  .bg-selected {
    background: #d2d2d2 !important;
  }
  .dark-mode .bg-selected {
    background: #707070 !important;
  }
</style>
@endsection
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
                      <i class="fa fa-filter"></i> Search Students
                    </button>
                  </div>
                </div>
                <div id="student-filters-table" class="collapse show" aria-labelledby="student-filter-heading" data-parent="#student-filters">
                  <div class="card-body">
                    <form action="{{ route('result.card.search.student') }}" id="search-student-form">
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
                        <div class="col-md-12 text-right">
                          <button id="btn-search-student" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div id="search-students">
        </div>
      </div>
    </section>
	</div>
@endsection
@section('scripts')
<script src="{{ url('/assets/js/result-card.js') }}"></script>
@endsection