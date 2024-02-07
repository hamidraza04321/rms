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
                <form action="{{ route('grade.store') }}" id="create-grade-form">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Default Grade <span class="error">*</span></label>
                        <select name="is_default" id="is-default" class="form-control select2">
                          <option value="">Select</option>
                          <option value="1">Yes</option>
                          <option value="0">No</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Class <span class="error">*</span></label>
                        <select name="class_id" id="class-id" class="form-control select2">
                          <option value="">Select</option>
                          @foreach($data['classes'] as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Grade <span class="error">*</span></label>
                        <input type="text" name="grade" id="grade" class="form-control" placeholder="Enter Grade">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Color <span class="error">*</span></label>
                        <input type="color" name="color" id="color" class="form-control" value="#007BFF">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Percentage From <span class="error">*</span></label>
                        <input type="number" name="percentage_from" id="percentage-from" class="form-control" placeholder="Enter Percentage From" min="0">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Percentage To <span class="error">*</span></label>
                        <input type="number" name="percentage_to" id="percentage-to" class="form-control" placeholder="Enter Percentage To" max="100">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Remarks <span class="error">*</span></label>
                        <input type="text" name="remarks" id="remarks" class="form-control" placeholder="Enter Remarks">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Pass / Fail <span class="error">*</span></label>
                        <select name="is_fail" id="is-fail" class="form-control select2">
                          <option value="">Select</option>
                          <option value="0">Pass</option>
                          <option value="1">Fail</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <button class="btn btn-success" id="btn-save-grade">Save</button>
                <a class="btn btn-danger" href="{{ route('grade.index') }}">Back</a>
              </div>
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
<script src="{{ url('/assets/js/grade.js') }}"></script>
@endsection
