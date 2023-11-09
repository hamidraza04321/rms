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
          <div class="col-md-4">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <div class="card-title"><i class="fa fa-check"></i> Select Preset</div>
              </div>
              <div class="card-body">
                
              </div>
            </div>
          </div>
          <div class="col-md-8">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <div class="card-title">Preset</div>
              </div>
              <div class="card-body">
                
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
	</div>
@endsection