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
                <div class="card-title"><i class="fa fa-edit"></i> {{ $data['page_title'] }}</div>
              </div>
              <div class="card-body">
                <form action="{{ route('session.update', $data['session']->id) }}" id="update-session-form">
                  <div class="form-group">
                    <label>Name <span class="error">*</span></label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter Session Name" value="{{ $data['session']->name }}">
                  </div>
                  <div class="form-group">
                    <label>Start Date <span class="error">*</span></label>
                    <input type="date" name="start_date" id="start-date" class="form-control" value="{{ date('Y-m-d', strtotime($data['session']->start_date)) }}">
                  </div>
                  <div class="form-group">
                    <label>End Date <span class="error">*</span></label>
                    <input type="date" name="end_date" id="end-date" class="form-control" value="{{ date('Y-m-d', strtotime($data['session']->end_date)) }}">
                  </div>
                  <button class="btn btn-success" id="btn-update-session">Update</button>
                  <a class="btn btn-danger" href="{{ route('session.index') }}">Back</a>
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
@endsection
@section('scripts')
<script src="{{ url('/assets/js/session.js') }}"></script>
@endsection
