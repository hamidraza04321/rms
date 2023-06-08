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
                <form action="{{ route('attendance-status.update', $data['attendance_status']->id) }}" id="update-attendance-status-form">
                  <div class="form-group">
                    <label>Name <span class="error">*</span></label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name" value="{{ $data['attendance_status']->name }}">
                  </div>
                  <div class="form-group">
                    <label>Short Code <span class="error">*</span></label>
                    <input type="text" name="short_code" id="short-code" class="form-control" placeholder="Enter Short Code" value="{{ $data['attendance_status']->short_code }}">
                  </div>
                  <div class="form-group">
                    <p>The attendance mark in exam days status of the attendance will be show in result card.</p>
                    <div class="form-check">
                      <input name="show_in_result_card" @checked($data['attendance_status']->show_in_result_card) class="form-check-input" id="show-in-result-card" type="checkbox" value="1">
                      <label class="form-check-label" for="show-in-result-card">Show in result card</label>
                    </div>
                  </div>
                  <button class="btn btn-success" id="btn-update-attendance-status">Update</button>
                  <a class="btn btn-danger" href="{{ route('attendance-status.index') }}">Back</a>
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
<script src="{{ url('/assets/js/attendance-status.js') }}"></script>
@endsection
