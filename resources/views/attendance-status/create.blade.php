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
              <div class="card-header card-primary card-outline">
                <div class="card-title"><i class="fa fa-plus-square"></i> {{ $data['page_title'] }}</div>
              </div>
              <div class="card-body">
                <form action="{{ route('attendance-status.store') }}" id="create-attendance-status-form">
                  <div class="form-group">
                    <label>Name <span class="error">*</span></label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name">
                  </div>
                  <div class="form-group">
                    <label>Short Code <span class="error">*</span></label>
                    <input type="text" name="short_code" id="short-code" class="form-control" placeholder="Enter Short Code">
                  </div>
                  <div class="form-group">
                    <label>Attendance Type <span class="error">*</span></label>
                    <select name="type" id="type" class="form-control select2">
                      <option value="">Select</option>
                      <option value="present">Present</option>
                      <option value="absent">Absent</option>
                      <option value="leave">Leave</option>
                      <option value="holiday">Holiday</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Color <span class="error">*</span></label>
                    <input type="color" name="color" id="color" class="form-control" value="#2ea4ff">
                  </div>
                </form>
              </div>
              <div class="card-footer">
                <button class="btn btn-success" id="btn-save-attendance-status">Save</button>
                <a class="btn btn-danger" href="{{ route('attendance-status.index') }}">Back</a>
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
