@extends('layout.app')
@section('page-title', $data['page_title'])
@section('styles')
<style>
  .text-black {
    color: #000 !important;
  }
  .fab {
    font-size: 20px;
    vertical-align: middle;
    cursor: pointer;
    transition: .5s;
  }
  .fa-facebook:hover {
    color: #007bff;
  }
  .fa-instagram:hover {
    color: #fccc63;
  }
  .fa-twitter:hover {
    color: #1DA1F2;
  }
  .fa-youtube:hover {
    color: red;
  }
</style>
@endsection
@section('main-content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ $data['page_title'] }}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">{{ $data['menu'] }}</a></li>
              <li class="breadcrumb-item active">{{ $data['page_title'] }}</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle" src="{{ ($data['user']->userDetail->image) ? url('/uploads/users/' . $data['user']->userDetail->image) : url('/assets/dist/img/avatar.jpg') }}" alt="User profile picture">
                </div>
                <h3 class="profile-name text-center">{{ $data['user']->name }}</h3>
                <p class="profile-designation text-muted text-center">{{ $data['user']->userDetail->designation }}</p>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">About Me</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong><i class="fas fa-book mr-1"></i> Education</strong>
                <p class="text-muted profile-education">
                  {{ $data['user']->userDetail->education ?? '--' }}
                </p>
                <hr>
                <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>
                <p class="text-muted profile-location">{{ $data['user']->userDetail->location ?? '--' }}</p>
                <hr>
                <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>
                <p class="text-muted profile-skills">
                  {{ $data['user']->userDetail->skills ?? '--' }}
                </p>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <div class="card-title">
                  <i class="fas fa-user"></i> User Profile
                </div>
                <div class="card-tools">
                  <button class="btn btn-warning" data-toggle="modal" data-target="#change-password-modal"><i class="fa fa-key"></i> Change Password</button>
                  <button class="btn btn-primary" data-toggle="modal" data-target="#edit-profile-modal"><i class="fa fa-edit"></i> Edit</button>
                </div>
              </div><!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered table-bordered table-hover table-striped">
                  <tbody>
                    <tr>
                      <td><strong>User Name</strong></td>
                      <td class="profile-user-name">{{ $data['user']->username }}</td>
                    </tr>
                    <tr>
                      <td><strong>Role</strong></td>
                      <td>{{ $data['user']->roles()->first()->name ?? '--' }}</td>
                    </tr>
                    <tr>
                      <td><strong>Email</strong></td>
                      <td class="profile-email">{{ $data['user']->email }}</td>
                    </tr>
                    <tr>
                      <td><strong>Phone No</strong></td>
                      <td class="profile-phone-no">{{ $data['user']->userDetail->phone_no ?? '--' }}</td>
                    </tr>
                    <tr>
                      <td><strong>Age</strong></td>
                      <td class="profile-age">{{ $data['user']->userDetail->age ?? '--' }}</td>
                    </tr>
                    <tr>
                      <td><strong>Date of Birth</strong></td>
                      <td class="profile-date-of-birth">{{ date($settings->date_format, strtotime($data['user']->userDetail->date_of_birth)) ?? '--' }}</td>
                    </tr>
                    <tr>
                      <td><strong>Address</strong></td>
                      <td class="profile-address">{{ $data['user']->userDetail->address ?? '--' }}</td>
                    </tr>
                    <tr>
                      <td><strong>Social Media links</strong></td>
                      <td>
                        <a href="{{ json_decode($data['user']->userDetail->social_media_links)?->facebook ?? '#' }}" target="_blank" class="text-black profile-facebook-link"><i class="fab fa-facebook"></i></a> &nbsp; | &nbsp;
                        <a href="{{ json_decode($data['user']->userDetail->social_media_links)?->instagram ?? '#' }}" target="_blank" class="text-black profile-instagram-link"><i class="fab fa-instagram"></i></a> &nbsp; | &nbsp;
                        <a href="{{ json_decode($data['user']->userDetail->social_media_links)?->twitter ?? '#' }}" target="_blank" class="text-black profile-twitter-link"><i class="fab fa-twitter"></i></a> &nbsp; | &nbsp;
                        <a href="{{ json_decode($data['user']->userDetail->social_media_links)?->youtube ?? '#' }}" target="_blank" class="text-black profile-youtube-link"><i class="fab fa-youtube"></i></a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

  <!-- CHANGE PASSWORD MODAL -->
  <div class="modal fade" id="change-password-modal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"><i class="fa fa-key"></i> Change Password</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ route('dashboard.profile.change.password') }}" id="change-password-form">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Old Password</label>
                  <input type="password" name="old_password" id="old-password" class="form-control" placeholder="Enter Old Password">
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label>New Password</label>
                  <input type="password" name="new_password" id="new-password" class="form-control" placeholder="Enter New Password">
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label>Retype Password</label>
                  <input type="password" name="retype_password" id="retype-password" class="form-control" placeholder="Retype Password">
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-success" id="btn-change-password">Change Password</button>
        </div>
      </div>
    </div>
  </div>
  <!-- EDIT PROFILE MODAL -->
  <div class="modal fade" id="edit-profile-modal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"><i class="fa fa-user-edit"></i> Edit Profile</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ route('dashboard.profile.update') }}" id="update-profile-form" enctype="multipart/form-data">
            <div class="row">
              <div class="col-md-4">
                <label>User Image</label>
                <div class="avatar-upload">
                  <div class="avatar-edit">
                    <input type="file" name="image" id="user-image" accept=".png, .jpg, .jpeg" />
                    <label for="user-image"><i class="fas fa-camera"></i></label>
                  </div>
                  <div class="avatar-preview">
                    <div class="image-preview" style="background-image: url({{ ($data['user']->userDetail->image) ? url('/uploads/users/' . $data['user']->userDetail->image) : url('/assets/dist/img/avatar.jpg') }});">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Name <span class="error">*</span></label>
                  <input type="text" name="name" id="name" class="form-control" placeholder="Enter Your Name" value="{{ $data['user']->name }}">
                </div>
                <div class="form-group">
                  <label>Email <span class="error">*</span></label>
                  <input type="email" name="email" id="email" class="form-control" placeholder="Enter Your Email" value="{{ $data['user']->email }}">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>User Name <span class="error">*</span></label>
                  <input type="text" name="username" id="username" class="form-control" placeholder="Enter Username" value="{{ $data['user']->username }}">
                </div>
                <div class="form-group">
                  <label>Designation</label>
                  <input type="text" name="designation" id="designation" class="form-control" placeholder="Enter Designation" value="{{ $data['user']->userDetail->designation }}">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Phone No</label>
                  <input type="text" name="phone_no" id="phone-no" class="form-control" placeholder="Enter Phone No" value="{{ $data['user']->userDetail->phone_no }}">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Age</label>
                  <input type="text" name="age" id="age" class="form-control" placeholder="Enter Age" value="{{ $data['user']->userDetail->age }}">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Date of Birth</label>
                  <input type="text" name="date_of_birth" id="date-of-birth" class="form-control date-picker" placeholder="Enter Date of Birth" value="{{ ($data['user']->userDetail->date_of_birth) ? date($settings->date_format, strtotime($data['user']->userDetail->date_of_birth)) : '' }}">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Education</label>
                  <input type="text" name="education" id="education" class="form-control" placeholder="Enter Education" value="{{ $data['user']->userDetail->education }}">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Location</label>
                  <input type="text" name="location" id="location" class="form-control" placeholder="Enter Location" value="{{ $data['user']->userDetail->location }}">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Skills</label>
                  <input type="text" name="skills" id="skills" class="form-control" placeholder="Enter Skills" value="{{ $data['user']->userDetail->skills }}">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Address</label>
                  <textarea class="form-control" name="address" id="address" rows="7">{{ $data['user']->userDetail->address }}</textarea>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Social Media Links</label>
                  <input type="text" name="facebook_link" id="facebook-link" class="form-control" placeholder="Facebook Link" value="{{ json_decode($data['user']->userDetail->social_media_links)?->facebook }}" style="margin-bottom: 10px;">
                  <input type="text" name="instagram_link" id="instagram-link" class="form-control" placeholder="Instagram Link" value="{{ json_decode($data['user']->userDetail->social_media_links)?->instagram }}" style="margin-bottom: 10px;">
                  <input type="text" name="twitter_link" id="twitter-link" class="form-control" placeholder="Twitter Link" value="{{ json_decode($data['user']->userDetail->social_media_links)?->twitter }}" style="margin-bottom: 10px;">
                  <input type="text" name="youtube_link" id="youtube-link" class="form-control" placeholder="Youtube Link" value="{{ json_decode($data['user']->userDetail->social_media_links)?->youtube }}" style="margin-bottom: 10px;">
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-success" id="btn-update-profile">Update</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
@endsection
@section('scripts')
<script src="{{ url('/assets/js/dashboard.js') }}"></script>
@endsection
