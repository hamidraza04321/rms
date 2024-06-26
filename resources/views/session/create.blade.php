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
                <div class="card-title"><i class="fa fa-calendar-plus"></i>&nbsp; {{ $data['page_title'] }}</div>
              </div>
              <div class="card-body">
                <form action="{{ route('session.store') }}" id="create-session-form">
                  <div class="form-group">
                    <label>Name <span class="error">*</span></label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter Section Name">
                  </div>
                  <div class="form-group">
                    <label>Start Date <span class="error">*</span></label>
                    <input type="text" name="start_date" id="start-date" class="form-control date-picker" placeholder="Enter Date">
                  </div>
                  <div class="form-group">
                    <label>End Date <span class="error">*</span></label>
                    <input type="text" name="end_date" id="end-date" class="form-control date-picker" placeholder="Enter Date">
                  </div>
                </form>
              </div>
              <div class="card-footer">
                <button class="btn btn-success" id="btn-save-session">Save</button>
                <a class="btn btn-danger" href="{{ route('session.index') }}">Back</a>
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
