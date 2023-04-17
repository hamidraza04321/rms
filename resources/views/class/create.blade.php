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
              <div class="card-header">
                <div class="card-title">{{ $data['page_title'] }}</div>
              </div>
              <div class="card-body">
                <form action="{{ route('class.store') }}" id="create-class-form">
                  <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter Class Name">
                  </div>
                  <div class="form-group">
                    <label>Sections</label>
                    <select name="section_id[]" id="section-id" class="form-control select2" multiple>
                      @foreach($data['sections'] as $section)
                        <option value="{{ $section->id }}">{{ $section->name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Groups</label>
                    <select name="group_id[]" id="group-id" class="form-control select2" multiple>
                      @foreach($data['groups'] as $group)
                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Subjects</label>
                    <select name="subject_id[]" id="subject-id" class="form-control select2" multiple>
                      @foreach($data['subjects'] as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <button class="btn btn-success" id="btn-save-class">Save</button>
                  <a class="btn btn-danger" href="{{ route('class.index') }}">Back</a>
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
<script src="{{ url('/assets/js/class.js') }}"></script>
@endsection
