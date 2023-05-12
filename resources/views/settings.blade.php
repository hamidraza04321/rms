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
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-3">
          	<div class="card">
              <div class="card-body">
              	<div class="avatar-upload">
				          <div class="avatar-preview mt-4 mb-4" style="width: 200px; height: 200px;">
				            <div class="image-preview logo-image-preview" style="background-image: url({{ url($settings->school_logo) }});">
				            </div>
				          </div>
				        </div>
              </div>
              <div class="card-footer text-center">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit-logo-modal"><i class="fas fa-camera"></i> Edit Logo</button>
						  </div>
            </div>
          </div>
          <div class="col-8">
          </div>
        </div>
      </div>
    </section>
  </div>

  <div class="modal fade" id="edit-logo-modal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Logo</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ route('settings.update.logo') }}" id="update-logo-form">
            <div class="form-group">
              <div class="input-group">
                <div class="custom-file">
                  <input type="file" class="custom-file-input" name="app_logo" id="app-logo">
                  <label class="custom-file-label" for="app-logo">Choose file</label>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-success" id="btn-update-logo">Update</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
@endsection
@section('scripts')
<script src="{{ url('/assets/js/settings.js') }}"></script>
@endsection
