<div class="row">
  <div class="col-12">
    @if(!isset($alert))
      <div class="card card-primary card-outline">
        <div class="card-header">
          <div class="card-title"><i class="fa fa-file"></i> Result Cards</div>
          <div class="card-tools">
            <button class="btn btn-success btn-print-result-card"><i class="fa fa-print"></i> Print Result Cards</button>
          </div>
        </div>
        <div class="card-body" style="width: 100%; overflow: auto;">
          @foreach($data['result_cards'] as $result_card)
            <div class="row result-card m-auto">
              <div class="header">
                <div class="header-bg d-flex">
                  <div class="col-3">
                    <div class="disk">
                      <img src="{{ url('/assets/dist/img/logo.png') }}">
                    </div>
                  </div>
                  <div class="col-9 text-center">
                    <h1 class="school-name">{{ $settings->school_name }}</h1>
                    <p class="result-card-text">Student Result Card</p>
                    <p class="exam-name">{{ $data['exam']->name }} ( {{ $data['exam']->session->name }} )</p>
                    <p class="student-details">
                      <span class="definition">Name:</span>
                      <span class="underline">{{ $result_card->student_name }}</span><br>
                      <span class="definition">Gr No: </span> 
                      <span class="underline mr-15">{{ $result_card->gr_no }}</span>
                      <span class="definition">Class:</span> 
                      <span class="underline mr-15">{{ $data['class']->name }}</span>
                      <span class="definition">Section:</span> 
                      <span class="underline">{{ $data['section']->name }}</span><br>
                      <span class="definition">Attendance:</span> 
                      <span class="underline"> &nbsp; {{ $result_card->total_present_attendances }} &nbsp; {{ ($result_card->total_present_attendances == 1) ? 'Day' : 'Days' }} Out Of &nbsp; {{ $result_card->total_attendances }} &nbsp; {{ ($result_card->total_attendances == 1) ? 'Day' : 'Days' }}</span> 
                    </p>
                  </div>
                </div>
              </div>
              <div class="result-card-content">
                @if(!empty($result_card->result->marks_subjects))
                  <table class="table table-bordered result-card-table">
                    <thead>
                      <tr>
                        <th width="100%" colspan="2">Subjects</th>
                        @foreach($data['exam_schedule_categories'] as $category)
                          <th class="rotate">{{ $category }}</th>
                        @endforeach
                        @if(!$data['has_all_sub_categories_gradings'])
                          <th class="rotate">Grade</th>
                          <th class="rotate">Total</th>
                        @endif
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($result_card->result->marks_subjects as $marks_subject)
                        @if($data['has_all_sub_categories_gradings'])
                          <tr>
                            <td width="100%" class="subject-name">{{ $marks_subject->subject }}</td>
                            <td class="obt-marks text-bold">Obt. Marks</td>
                            @foreach($marks_subject->sub_categories as $remarks)
                              <td>{{ $remarks }}</td>
                            @endforeach
                            @if(!$data['has_all_sub_categories_gradings'])
                              <td>--</td>
                              <td>{{ $marks_subject->obtain_marks }}</td>
                            @endif
                          </tr>
                        @else
                          <tr>
                            <td width="100%" rowspan="2" class="subject-name">{{ $marks_subject->subject }}</td>
                            <td class="max-marks">Max Marks</td>
                            @foreach($marks_subject->max_marks as $max_marks)
                              <td><strong>{{ $max_marks }}</strong></td>
                            @endforeach
                            <td><strong>--</strong></td>
                            <td><strong>{{ $marks_subject->total_marks }}</strong></td>
                          </tr>
                          <tr>
                            <td class="obt-marks">Obt. Marks</td>
                            @foreach($marks_subject->sub_categories as $remarks)
                              <td>{{ $remarks }}</td>
                            @endforeach
                            <td>{{ $marks_subject->grade }}</td>
                            <td>{{ $marks_subject->obtain_marks }}</td>
                          </tr>
                        @endif
                      @endforeach
                    </tbody>
                  </table>
                  @if(!$data['has_all_sub_categories_gradings'])
                    <table class="table table-bordered grand-total-table">
                      <thead>
                        <tr>
                          <th>Grand Total</th>
                          <th><strong>Maximum Marks</strong></th>
                          <th><strong>{{ $result_card->result->grand_total }}</strong></th>
                          <th><strong>Marks Obtained</strong></th>
                          <th><strong>{{ $result_card->result->obtain_grand_total }}</strong></th>
                        </tr>
                      </thead>
                    </table>
                  @endif
                @endif
                <div class="row">
                  @if(!$data['has_all_sub_categories_gradings'] && !empty($result_card->result->marks_subjects))
                    <div class="{{ !empty($result_card->result->grading_subjects) ? 'col-md-8' : 'col-md-12' }}">
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
                            <td>{{ $result_card->result->percentage }}%</td>
                            <td>{{ $result_card->result->grade }}</td>
                            <td>{{ ($result_card->result->is_fail) ? 'Failed' : 'Passed' }}</td>
                            <td>{{ $result_card->result->rank }}</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  @endif
                  @if(!empty($result_card->result->grading_subjects))
                    <div class="{{ ($data['has_all_sub_categories_gradings'] || empty($result_card->result->marks_subjects)) ? 'col-md-12 mt-10' : 'col-md-4' }}">
                      <table class="table table-bordered grades-table">
                        <thead>
                          <tr>
                            <th>Subject</th>
                            <th>Grade</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($result_card->result->grading_subjects as $grading_subject)
                            <tr>
                              <td>{{ $grading_subject->subject }}</td>
                              <td>{{ $grading_subject->obtain_grade }}</td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  @endif
                </div>
                @if(!$data['has_all_sub_categories_gradings'] && !empty($result_card->result->marks_subjects))
                  <div class="row">
                    <div class="col-md-12">
                      <table class="table table-bordered remarks-table">
                        <tbody>
                          <tr>
                            <td style="width: 25%;"><strong>Remarks</strong></td>
                            <td>{{ $result_card->result->grade_remarks }}</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                @endif
                <div class="footer row">
                  <div class="col-md-4">
                    <div class="border-dash">__________________________</div>
                    <h5 class="heading">Class Teacher's Signature</h5>
                  </div>
                  <div class="col-md-4">
                    <div class="border-dash">__________________________</div>
                    <h5 class="heading">Principal's Signature</h5>
                  </div>
                  <div class="col-md-4">
                    <div class="border-dash">&nbsp;</div>
                    <h5 class="heading">School Seal</h5>
                  </div>
                </div>
              </div>
            </div>
            @if(!$loop->last)
              <hr>
            @endif
          @endforeach
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <button style="float: right;" class="btn btn-success btn-print-result-card"><i class="fa fa-print"></i> Print Result Cards</button>
        </div>
      </div>
    @else
      <div class="alert alert-danger text-center">
        {{ $alert }}
      </div>
    @endif
    <!-- /.card -->
  </div>
  <!-- /.col -->
</div>