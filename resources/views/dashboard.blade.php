@extends('layout.app')
@section('page-title', $data['page_title'])
@section('styles')
<style type="text/css">
  /* Media query for dark mode */
  @media (prefers-color-scheme: dark) {
    .dark-mode .apexcharts-text {
      fill: #fff;
    }
    .dark-mode .apexcharts-tooltip,
    .dark-mode .apexcharts-tooltip-title {
      background-color: #333 !important;
      color: #fff !important;
      border: 1px solid #555 !important;
    }
    .dark-mode .apexcharts-legend-text {
      color: #fff !important;
      border: 1px solid #555 !important;
    }
  }
</style>
<!-- Apexcharts -->
<link rel="stylesheet" href="{{ url('/assets/plugins/apexcharts/css/apexcharts.css') }}">
<!-- daterange picker -->
<link rel="stylesheet" href="{{ url('/assets/plugins/daterangepicker/daterangepicker.css') }}">
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

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-calendar"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Current Session</span>
                <span class="info-box-number">{{ $data['session']->name }}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Total Users</span>
                <span class="info-box-number">{{ $data['total_users'] }}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-graduation-cap"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Total Students</span>
                <span class="info-box-number">{{ $data['total_students'] }}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-user-friends"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Active Students</span>
                <span class="info-box-number">{{ $data['active_students'] }}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
        <div class="row">
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Attendance Graph</h3>
                </div>
              </div>
              <div class="card-body">
                <div class="position-relative mb-4">
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="far fa-calendar-alt"></i>
                        </span>
                      </div>
                      <input type="text" class="form-control float-right" id="attendance-date-range" style="margin-right: 10px;">
                      <button class="btn btn-primary" id="btn-load-attendance-graph" data-url="{{ route('dashboard.get.attendance.graph.data') }}">Load Graph</button>
                    </div>
                    <!-- /.input group -->
                  </div>
                  <div id="attendance-chart"></div>
                </div>
              </div>
            </div>
            <!-- /.card -->

            <div class="card">
              <div class="card-header border-0">
                <h3 class="card-title">New Users</h3>
              </div>
              <div class="card-body table-responsive p-0">
                <table class="table table-striped table-valign-middle">
                  <thead>
                  <tr>
                    <th>User Name</th>
                    <th>Login Id</th>
                    <th>Role</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td colspan="4" class="text-center">No record found!</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col-md-6 -->
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Total Students</h3>
                </div>
              </div>
              <div class="card-body">
                <div class="position-relative mb-4">
                  <div id="total-students"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection
@section('scripts')
<!-- Apexcarts -->
<script src="{{ url('/assets/plugins/apexcharts/js/apexcharts.min.js') }}"></script>
<!-- date-range-picker -->
<script src="{{ url('/assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Dashboard JS --> 
<script src="{{ url('/assets/js/dashboard.js') }}"></script>
<script>
  $(document).ready(function() {

    var attendances = @json($data['student_attendances']);
    var series = [];

    $.each(attendances.series, function(key, value) {
      series.push({
        name: key,
        data: value
      });       
    });

    var options = {
      series: series,
      chart: {
        type: 'bar',
        height: 350
      },
      plotOptions: {
        bar: {
          horizontal: false,
          columnWidth: '55%',
          endingShape: 'rounded'
        },
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
      },
      xaxis: {
        categories: attendances.categories,
      },
      yaxis: {
        title: {
          text: 'Percentage %'
        }
      },
      fill: {
        opacity: 1
      },
      tooltip: {
        y: {
          formatter: function (val) {
            return val + " %"
          }
        }
      }
    };

    var chart = new ApexCharts(document.querySelector("#attendance-chart"), options);
    chart.render();
  });
</script>
@endsection