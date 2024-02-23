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
          	<div class="card card-primary card-outline">
              <div class="card-body">
              	<div class="avatar-upload">
				          <div class="avatar-preview mt-4 mb-4" style="width: 200px; height: 200px;">
				            <div class="image-preview logo-image-preview" style="background-size: 100%; background-image: url({{ url($settings->school_logo) }});">
				            </div>
				          </div>
				        </div>
              </div>
              @can('general-settings-edit')
                <div class="card-footer text-center">
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit-logo-modal"><i class="fas fa-camera"></i> Edit Logo</button>
  						  </div>
              @endcan
            </div>
          </div>
          <div class="col-9">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <div class="card-title">
                  <i class="fa fa-cogs"></i> General Settings
                </div>
                <div class="card-tools">
                  @can('general-settings-edit')
                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#edit-settings-modal"><i class="fa fa-edit"></i> Edit</button>
                  @endcan
                </div>
              </div>
              <div class="card-body">
                <table class="table table-bordered table-bordered table-hover table-striped">
                  <tbody>
                    <tr>
                      <td><strong>School Name</strong></td>
                      <td class="school-name">{{ $settings->school_name }}</td>
                    </tr>
                    <tr>
                      <td><strong>School Name in Short</strong></td>
                      <td class="school-name-in-short">{{ $settings->school_name_in_short }}</td>
                    </tr>
                    <tr>
                      <td><strong>Email</strong></td>
                      <td class="email">{{ $settings->email }}</td>
                    </tr>
                    <tr>
                      <td><strong>Phone No</strong></td>
                      <td class="phone-no">{{ ($settings->phone_no == '') ? '--' : $settings->phone_no }}</td>
                    </tr>
                    <tr>
                      <td><strong>Current Session</strong></td>
                      <td class="current-session">{{ $settings->currentSessionName() }}</td>
                    </tr>
                    <tr>
                      <td><strong>Date Format</strong></td>
                      <td class="date-format">{{ $settings->date_format }}</td>
                    </tr>
                    <tr>
                      <td><strong>Date Format In JS</strong></td>
                      <td class="date-format-in-js">{{ $settings->date_format_in_js }}</td>
                    </tr>
                    <tr>
                      <td><strong>Address</strong></td>
                      <td class="school-address">{{ $settings->school_address }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  @can('general-settings-edit')
    <!-- EDIT LOGO MODAL -->
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

    <!-- EDIT SETTINGS MODAL -->
    <div class="modal fade" id="edit-settings-modal" style="display: none;" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"><i class="fa fa-cogs"></i> Edit Settings</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="{{ route('settings.update') }}" id="update-settings-form">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>School Name <span class="error">*</span></label>
                    <input type="text" name="school_name" id="school-name" class="form-control" placeholder="Enter School Name" value="{{ $settings->school_name }}">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>School Name In Short <span class="error">*</span></label>
                    <input type="text" name="school_name_in_short" id="school-name-in-short" class="form-control" placeholder="Enter School Name In Short" value="{{ $settings->school_name_in_short }}">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Email <span class="error">*</span></label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email" value="{{ $settings->email }}">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Phone No <span class="error">*</span></label>
                    <input type="text" name="phone_no" id="phone-no" class="form-control" placeholder="Enter Phone No" value="{{ $settings->phone_no }}">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Current Session <span class="error">*</span></label>
                    <select name="current_session_id" id="current-session-id" class="form-control select2">
                      <option value="">Select</option>
                      @foreach($data['sessions'] as $session)
                        <option @selected($session->id == $settings->current_session_id) value="{{ $session->id }}">{{ $session->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Date Format <span class="error">*</span></label>
                    <input type="text" name="date_format" id="date-format" class="form-control" value="{{ $settings->date_format }}">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Date Format In JS <span class="error">*</span></label>
                    <input type="text" name="date_format_in_js" id="date-format-in-js" class="form-control" value="{{ $settings->date_format_in_js }}">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Address</label>
                    <textarea class="form-control" name="school_address" id="school-address">{{ $settings->school_address }}</textarea>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-success" id="btn-update-settings">Update</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
  @endcan
@endsection
@section('scripts')
<script src="{{ url('/assets/js/settings.js') }}"></script>
@endsection
