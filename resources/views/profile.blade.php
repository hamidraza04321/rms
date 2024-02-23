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
              <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">{{ $data['menu'] }}</a></li>
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
                  <img class="profile-user-img img-fluid img-circle" src="{{ url(auth()->user()->image ? '/uploads/users/' . auth()->user()->image : '/assets/dist/img/avatar.jpg') }}" alt="User profile picture">
                </div>
                <h3 class="profile-username text-center">{{ auth()->user()->name }}</h3>
                <p class="text-muted text-center">{{ auth()->user()->designation }}</p>
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
                <p class="text-muted">
                  B.S. in Computer Science from the University of Tennessee at Knoxville
                </p>
                <hr>
                <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>
                <p class="text-muted">Malibu, California</p>
                <hr>
                <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>
                <p class="text-muted">
                  <span class="tag tag-danger">UI Design</span>
                  <span class="tag tag-success">Coding</span>
                  <span class="tag tag-info">Javascript</span>
                  <span class="tag tag-warning">PHP</span>
                  <span class="tag tag-primary">Node.js</span>
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
              		<button class="btn btn-primary"><i class="fas fa-edit"></i> Edit</button>
              	</div>
              </div><!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered table-bordered table-hover table-striped">
                  <tbody>
                    <tr>
                      <td><strong>User Name</strong></td>
                      <td>{{ auth()->user()->username }}</td>
                    </tr>
                    <tr>
                      <td><strong>Role</strong></td>
                      <td>{{ auth()->user()->roles()->first()->name ?? '--' }}</td>
                    </tr>
                    <tr>
                      <td><strong>Email</strong></td>
                      <td>{{ auth()->user()->email }}</td>
                    </tr>
                    <tr>
                      <td><strong>Phone No</strong></td>
                      <td>{{ auth()->user()->phone_no ?? '--' }}</td>
                    </tr>
                    <tr>
                      <td><strong>Age</strong></td>
                      <td>{{ auth()->user()->age ?? '--' }}</td>
                    </tr>
                    <tr>
                      <td><strong>Date of Birth</strong></td>
                      <td>{{ auth()->user()->age ?? '--' }}</td>
                    </tr>
                    <tr>
                      <td><strong>Address</strong></td>
                      <td>{{ auth()->user()->address ?? '--' }}</td>
                    </tr>
                    <tr>
                      <td><strong>Social Media links</strong></td>
                      <td>
                        <a href="#" target="_blank" class="text-black"><i class="fab fa-facebook"></i></a> &nbsp; | &nbsp;
                        <a href="#" target="_blank" class="text-black"><i class="fab fa-instagram"></i></a> &nbsp; | &nbsp;
                        <a href="#" target="_blank" class="text-black"><i class="fab fa-twitter"></i></a> &nbsp; | &nbsp;
                        <a href="#" target="_blank" class="text-black"><i class="fab fa-youtube"></i></a>
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
@endsection
