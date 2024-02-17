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
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{ $data['session']->name }}</h3>
                <p>Current Session</p>
              </div>
              <div class="icon">
                <i class="fas fa-calendar"></i>
              </div>
              <a href="{{ route('general.settings') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{ $data['total_users'] }}</h3>
                <p>Total Users</p>
              </div>
              <div class="icon">
                <i class="fas fa-users"></i>
              </div>
              <a href="{{ route('user.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{ $data['total_students'] }}</h3>
                <p>Total Students</p>
              </div>
              <div class="icon">
                <i class="fas fa-graduation-cap"></i>
              </div>
              <a href="{{ route('student.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{ $data['active_students'] }}</h3>
                <p>Active Students</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-friends"></i>
              </div>
              <a href="{{ route('student.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
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

    var options = {
        series: [{
        name: 'Total Students',
        data: @json($data['total_students_graph_data']['series'])
      }],
        chart: {
        height: 350,
        type: 'bar',
      },
      plotOptions: {
        bar: {
          borderRadius: 10,
          dataLabels: {
            position: 'top', // top, center, bottom
          },
        }
      },
      dataLabels: {
        enabled: true,
        formatter: function (val) {
          return val;
        },
        offsetY: -20,
        style: {
          fontSize: '12px',
          colors: ["#304758"]
        }
      },
      
      xaxis: {
        categories: @json($data['total_students_graph_data']['categories']),
        axisBorder: {
          show: false
        },
        axisTicks: {
          show: false
        },
        crosshairs: {
          fill: {
            type: 'gradient',
            gradient: {
              colorFrom: '#D8E3F0',
              colorTo: '#BED1E6',
              stops: [0, 100],
              opacityFrom: 0.4,
              opacityTo: 0.5,
            }
          }
        },
        tooltip: {
          enabled: true,
        }
      },
      yaxis: {
        axisBorder: {
          show: false
        },
        axisTicks: {
          show: false,
        },
        labels: {
          show: false,
          formatter: function (val) {
            return val;
          }
        }
      
      },
      title: {
        text: 'Total Students in Classes, {{ $data['session']->name }}',
        align: 'center',
        style: {
          color: '#444',
          fontWeight: 'normal'
        }
      }
      };

      var chart = new ApexCharts(document.querySelector("#total-students"), options);
      chart.render();
  });
</script>
@endsection