@extends('layout.app')
@section('page-title', $data['page_title'])
@section('styles')
<link rel="stylesheet" href="{{ url('/assets/css/result-card.css') }}">
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
        <div class="row">
          <div class="col-12">
            <div class="accordion" id="student-filters">
              <div class="card card-primary card-outline">
                <div class="card-header" id="student-filter-heading">
                  <div class="d-flex">
                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#student-filters-table" aria-expanded="true" aria-controls="student-filters-table">
                      <i class="fa fa-filter"></i> Search Results
                    </button>
                  </div>
                </div>
                <div id="student-filters-table" class="collapse show" aria-labelledby="student-filter-heading" data-parent="#student-filters">
                  <div class="card-body">
                    <form action="{{ route('get.result.cards') }}" id="get-result-cards-form">
                      <div class="row">
                        <div class="col-md-3">
                          <div class="form-group">
                            <label>Session</label>
                            <select name="session_id" id="session-id" class="select2 form-control">
                              <option value="">Select</option>
                              @foreach($data['sessions'] as $session)
                                <option @selected($session->id == $settings->current_session_id) value="{{ $session->id }}">{{ $session->name }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label>Class</label>
                            <select name="class_id" id="class-id" class="select2 form-control">
                              <option value="">Select</option>
                              @foreach($data['classes'] as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label>Section</label>
                            <select name="section_id" id="section-id" disabled class="select2 form-control">
                              <option value="">Select</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label>Group </label>
                            <select name="group_id" id="group-id" disabled class="select2 form-control">
                              <option value="">Select</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12 text-right">
                          <button id="btn-search-result-cards" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div id="result-cards">
          <div class="row">
            <div class="col-12">
              <div class="card card-primary card-outline">
                <div class="card-header">
                  <div class="card-title"><i class="fa fa-file"></i> Result Cards</div>
                  <div class="card-tools">
                    <button class="btn btn-success" id="btn-print-result-card"><i class="fa fa-print"></i> Print Result Cards</button>
                  </div>
                </div>
                <div class="card-body" style="width: 100%; overflow: auto;">
                  <div class="row result-card m-auto">
                    <div class="header">
                      <div class="header-bg d-flex">
                        <div class="col-3">
                          <img src="{{ url('/assets/dist/img/logo.png') }}">
                        </div>
                        <div class="col-9 text-center">
                          <h1 class="school-name">{{ $settings->school_name }}</h1>
                          <p class="result-card-text">Student Result Card</p>
                          <p class="exam-name">First Mid Term Examination ( 2022-2023 )</p>
                          <p class="student-details">
                            <span class="definition">Name:</span>
                            <span class="underline">Hamid Raza Muhammad Altaf</span><br>
                            <span class="definition">Gr No: </span> 
                            <span class="underline mr-15">11234</span>
                            <span class="definition">Class:</span> 
                            <span class="underline mr-15">I</span>
                            <span class="definition">Section:</span> 
                            <span class="underline">A</span><br>
                            <span class="definition">Attendance:</span> 
                            <span class="underline">100 Days Out Of 100 Days</span> 
                          </p>
                        </div>
                      </div>
                    </div>
                    <div class="result-card-content">
                      <table class="table table-bordered result-card-table">
                        <thead>
                          <tr>
                            <th width="100%" colspan="2">Subjects</th>
                            <th class="rotate">Dictation</th>
                            <th class="rotate">Oral</th>
                            <th class="rotate">Writing</th>
                            <th class="rotate">Listning</th>
                            <th class="rotate">Reading</th>
                            <th class="rotate">Grade</th>
                            <th class="rotate">Total</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td width="100%" rowspan="2" class="subject-name">English</td>
                            <td class="max-marks">Max Marks</td>
                            <td><strong>--</strong></td>
                            <td><strong>--</strong></td>
                            <td><strong>--</strong></td>
                            <td><strong>--</strong></td>
                            <td><strong>--</strong></td>
                            <td><strong>--</strong></td>
                            <td><strong>--</strong></td>
                          </tr>
                          <tr>
                            <td class="obt-marks">Obt. Marks</td>
                            <td>--</td>
                            <td>--</td>
                            <td>--</td>
                            <td>--</td>
                            <td>--</td>
                            <td>--</td>
                            <td>--</td>
                          </tr>
                          <tr>
                            <td width="100%" rowspan="2" class="subject-name">Urdu</td>
                            <td class="max-marks">Max Marks</td>
                            <td><strong>--</strong></td>
                            <td><strong>--</strong></td>
                            <td><strong>--</strong></td>
                            <td><strong>--</strong></td>
                            <td><strong>--</strong></td>
                            <td><strong>--</strong></td>
                            <td><strong>--</strong></td>
                          </tr>
                          <tr>
                            <td class="obt-marks">Obt. Marks</td>
                            <td>--</td>
                            <td>--</td>
                            <td>--</td>
                            <td>--</td>
                            <td>--</td>
                            <td>--</td>
                            <td>--</td>
                          </tr>
                          <tr>
                            <td width="100%" rowspan="2" class="subject-name">Mathematics</td>
                            <td class="max-marks">Max Marks</td>
                            <td><strong>--</strong></td>
                            <td><strong>--</strong></td>
                            <td><strong>--</strong></td>
                            <td><strong>--</strong></td>
                            <td><strong>--</strong></td>
                            <td><strong>--</strong></td>
                            <td><strong>--</strong></td>
                          </tr>
                          <tr>
                            <td class="obt-marks">Obt. Marks</td>
                            <td>--</td>
                            <td>--</td>
                            <td>--</td>
                            <td>--</td>
                            <td>--</td>
                            <td>--</td>
                            <td>--</td>
                          </tr>
                          <tr>
                            <td width="100%" rowspan="2" class="subject-name">Islamiat</td>
                            <td class="max-marks"><strong>Max Marks</strong></td>
                            <td>--</td>
                            <td>--</td>
                            <td>--</td>
                            <td>--</td>
                            <td>--</td>
                            <td>--</td>
                            <td>--</td>
                          </tr>
                          <tr>
                            <td class="obt-marks">Obt. Marks</td>
                            <td>--</td>
                            <td>--</td>
                            <td>--</td>
                            <td>--</td>
                            <td>--</td>
                            <td>--</td>
                            <td>--</td>
                          </tr>
                          <tr>
                            <td width="100%" rowspan="2" class="subject-name">Social Studies</td>
                            <td class="max-marks">Max Marks</td>
                            <td><strong>--</strong></td>
                            <td><strong>--</strong></td>
                            <td><strong>--</strong></td>
                            <td><strong>--</strong></td>
                            <td><strong>--</strong></td>
                            <td><strong>--</strong></td>
                            <td><strong>--</strong></td>
                          </tr>
                          <tr>
                            <td class="obt-marks">Obt. Marks</td>
                            <td>--</td>
                            <td>--</td>
                            <td>--</td>
                            <td>--</td>
                            <td>--</td>
                            <td>--</td>
                            <td>--</td>
                          </tr>
                          <tr>
                            <td width="100%" rowspan="2" class="subject-name">General Science</td>
                            <td class="max-marks">Max Marks</td>
                            <td><strong>--</strong></td>
                            <td><strong>--</strong></td>
                            <td><strong>--</strong></td>
                            <td><strong>--</strong></td>
                            <td><strong>--</strong></td>
                            <td><strong>--</strong></td>
                            <td><strong>--</strong></td>
                          </tr>
                          <tr>
                            <td class="obt-marks">Obt. Marks</td>
                            <td>--</td>
                            <td>--</td>
                            <td>--</td>
                            <td>--</td>
                            <td>--</td>
                            <td>--</td>
                            <td>--</td>
                          </tr>
                        </tbody>
                      </table>
                      <table class="table table-bordered grand-total-table">
                        <thead>
                          <tr>
                            <th>Grand Total</th>
                            <th><strong>Maximum Marks</strong></th>
                            <th><strong>370</strong></th>
                            <th><strong>Marks Obtained</strong></th>
                            <th><strong>0</strong></th>
                          </tr>
                        </thead>
                      </table>
                      <div class="row">
                        <div class="col-md-8">
                          <table class="table table-bordered result-info-table">
                            <thead>
                              <tr>
                                <th>Percentage</th>
                                <th>Grade</th>
                                <th>Overall Result</th>
                                <th>Rank</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>0%</td>
                                <td>--</td>
                                <td>Failed</td>
                                <td>--</td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <div class="col-md-4">
                          <table class="table table-bordered grades-table">
                            <thead>
                              <tr>
                                <th>Subject</th>
                                <th>Grade</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>Art</td>
                                <td>--</td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <table class="table table-bordered remarks-table">
                            <tbody>
                              <tr>
                                <td class="th-bold"><strong>Remarks</strong></td>
                                <td>Has shown unsatisfacotory progress</td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
        </div>
      </div>
    </section>
	</div>
@endsection
@section('scripts')
<script src="{{ url('/assets/js/result-card.js') }}"></script>
@endsection