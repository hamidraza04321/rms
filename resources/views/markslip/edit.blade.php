@extends('layout.app')
@section('page-title', $data['page_title'])
@section('styles')
<link rel="stylesheet" href="{{ url('assets/css/markslip.css') }}">
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
        <!-- /.row -->
        {!! $data['markslip'] !!}
      </div>
      <!-- /.container-fluid -->
    </section>
   </div>
@endsection
@section('scripts')
  <script src="{{ url('/assets/js/markslip.js') }}"></script>
  <script>
    $('.grade').select2({
      width: '100%',
      placeholder: "Grade",
      allowClear: true
    });
  </script>
@endsection