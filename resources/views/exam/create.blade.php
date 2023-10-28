@extends('layout.app')
@section('page-title', $data['page_title'])
@section('styles')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
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
            <div class="card">
              <div class="card-header card-primary card-outline">
                <div class="card-title"><i class="fa fa-plus-square"></i> {{ $data['page_title'] }}</div>
              </div>
              <div class="card-body">
                <form action="{{ route('exam.store') }}" id="create-exam-form">
                  <div class="form-group">
                    <label>Session <span class="error">*</span></label>
                    <select name="session_id" id="session-id" class="select2 form-control">
                      <option value="">Select</option>
                      @foreach($data['sessions'] as $session)
                        <option @selected($settings->current_session_id == $session->id) value="{{ $session->id }}">{{ $session->name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Name <span class="error">*</span></label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter Exam Name">
                  </div>
                  <div class="form-group">
                    <label>Classes <span class="error">*</span></label>
                    <select name="class_id[]" id="class-id" class="form-control select2" multiple>
                      @foreach($data['classes'] as $class)
                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Datesheet Note</label>
                    <textarea name="datesheet_note" id="datesheet-note" class="form-control"></textarea>
                  </div>
                  <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" id="description" rows="3" class="form-control" placeholder="Enter Description"></textarea>
                  </div>
                  <button class="btn btn-success" id="btn-save-exam">Save</button>
                  <a class="btn btn-danger" href="{{ route('exam.index') }}">Back</a>
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
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script src="{{ url('/assets/js/exam.js') }}"></script>
<script>
  $('#datesheet-note').summernote({
    placeholder: 'Enter exam datesheet note',
    height: 150
  });
</script>
@endsection
