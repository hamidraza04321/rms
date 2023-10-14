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
                    <label>Color <span class="error">*</span></label>
                    <input type="color" name="color" id="color" class="form-control" value="#2ea4ff">
                  </div>
                  <div class="form-group">
                    <div class="form-check">
                      <input class="form-check-input" name="is_absent" id="is-absent" type="checkbox" value="1">
                      <label class="form-check-label" for="is-absent">Absent Status</label>
                    </div>
                  </div>
                  <button class="btn btn-success" id="btn-save-attendance-status">Save</button>
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
