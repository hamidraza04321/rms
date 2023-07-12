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
                <form action="{{ route('grade.update', $data['grade']->id) }}" id="update-grade-form">
                  <div class="form-group">
                    <label>Class <span class="error">*</span></label>
                    <select name="class_id" id="class-id" class="form-control select2">
                      <option value="">Select</option>
                      @foreach($data['classes'] as $class)
                        <option @selected($data['grade']->class_id == $class->id) value="{{ $class->id }}">{{ $class->name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Grade <span class="error">*</span></label>
                    <input type="text" name="grade" id="grade" class="form-control" placeholder="Enter Grade" value="{{ $data['grade']->grade }}">
                  </div>
                  <div class="form-group">
                    <label>Percentage From <span class="error">*</span></label>
                    <input type="number" name="percentage_from" id="percentage-from" class="form-control" placeholder="Enter Percentage From" value="{{ $data['grade']->percentage_from }}">
                  </div>
                  <div class="form-group">
                    <label>Percentage To <span class="error">*</span></label>
                    <input type="number" name="percentage_to" id="percentage-to" class="form-control" placeholder="Enter Percentage To" value="{{ $data['grade']->percentage_to }}">
                  </div>
                  <div class="form-group">
                    <label>Color <span class="error">*</span></label>
                    <input type="color" name="color" id="color" class="form-control" value="{{ $data['grade']->color }}">
                  </div>
                  <div class="form-group">
                    <label>Pass / Fail <span class="error">*</span></label>
                    <select name="is_fail" id="is-fail" class="form-control select2">
                      <option value="">Select</option>
                      <option @selected(!$data['grade']->is_fail) value="0">Pass</option>
                      <option @selected($data['grade']->is_fail) value="1">Fail</option>
                    </select>
                  </div>
                  <button class="btn btn-success" id="btn-update-grade">Update</button>
                  <a class="btn btn-danger" href="{{ route('grade.index') }}">Back</a>
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
<script src="{{ url('/assets/js/grade.js') }}"></script>
@endsection
