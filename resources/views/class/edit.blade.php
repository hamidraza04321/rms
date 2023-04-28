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
                <form action="{{ route('class.update', $data['class']->id) }}" id="update-class-form">
                  <div class="form-group">
                    <label>Name <span class="error">*</span></label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter Class Name" value="{{ $data['class']->name }}">
                  </div>
                  <div class="form-group">
                    <label>Sections <span class="error">*</span></label>
                    <select name="section_id[]" id="section-id" class="form-control select2" multiple>
                      @foreach($data['sections'] as $section)
                        <option @selected(in_array($section->id, $data['section_ids'])) value="{{ $section->id }}">{{ $section->name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Groups</label>
                    <select name="group_id[]" id="group-id" class="form-control select2" multiple>
                      @foreach($data['groups'] as $group)
                        <option @selected(in_array($group->id, $data['group_ids'])) value="{{ $group->id }}">{{ $group->name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Subjects <span class="error">*</span></label>
                    <select name="subject_id[]" id="subject-id" class="form-control select2" multiple>
                      @foreach($data['subjects'] as $subject)
                        <option @selected(in_array($subject->id, $data['subject_ids'])) value="{{ $subject->id }}">{{ $subject->name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <button class="btn btn-success" id="btn-update-class">Update</button>
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
