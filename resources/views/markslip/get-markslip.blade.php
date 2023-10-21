@if(count($data['markslips']))
  <div class="row">
    <div class="col-12">
      <div class="card card-primary card-outline">
        <div class="card-header">
          <div class="card-title"><i class="fa fa-paste"></i> Mark Slip </div>
          @if(!$data['has_all_students_absent'])
            <div class="card-tools">
              <button class="btn btn-success btn-save-markslip">Save</button>
            </div>
          @endif
        </div>
        <div class="card-body">
          <form action="{{ route('save.markslip') }}" id="save-markslip-form">
            <input type="hidden" name="exam_class_id" value="{{ $data['markslips'][0]->exam_schedule->exam_class_id }}">
            @foreach($data['markslips'] as $markslip)
              <div class="container">
                <div class="row">
                  <div class="col-md-3 text-center">
                    <div class="logo">
                      <img src="{{ url($settings->school_logo) }}">
                    </div>
                  </div>
                  <div class="col-md-9">
                    <h2 class="school-name text-center">{{ $settings->school_name }}</h2>
                    <h3 class="exam-name text-center">{{ $markslip->exam }} ( {{ $markslip->session }} )</h3>
                    <table class="markslip-details">
                      <tbody>
                        <tr>
                          <td class="text-bold">Class :</td>
                          <td style="width: 40%;">{{ $markslip->class }}</td>
                          <td class="text-bold">Section :</td>
                          <td style="width: 40%;">{{ $markslip->section }}</td>
                        </tr>
                        <tr>
                          <td class="text-bold pt-3">Group :</td>
                          <td>{{ $markslip->group }}</td>
                          <td class="text-bold">Subject :</td>
                          <td>{{ $markslip->subject }}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <br>
                <div class="row">
                  <table class="table table-bordered">
                    <thead>
                      <tr class="bg-light-blue">
                        <th nowrap>S No.</th>
                        <th nowrap>Roll No.</th>
                        <th nowrap>Student Name</th>
                        @switch($markslip->exam_schedule->type)
                          @case('grade')
                            <th>Grade</th>
                          @break
                          @case('marks')
                            <th>Obtain Marks</th>
                            <th>Total Marks</th>
                          @break
                          @case('categories')
                            @foreach($markslip->exam_schedule->categories as $category)
                              <th class="text-center">
                                {{ $category->name }}
                                @if(!$category->is_grade)
                                  <br>
                                  [ {{ $category->marks }} ]
                                @endif
                              </th>
                              @if($loop->last && $markslip->exam_schedule->categories->firstWhere('is_grade', 0))
                                <th nowrap>Total Marks</th>
                              @endif
                            @endforeach
                          @break
                        @endswitch
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($markslip->students as $student)
                        @php
                          $key = "{$student->section_id}-{$markslip->exam_schedule->subject_id}";
                          $exam_date = date('Y-m-d', strtotime($markslip->exam_schedule->date));
                          $attendance = $student->attendances?->firstWhere('attendance_date', $exam_date);
                        @endphp
                        <tr>
                          <td>{{ ++$loop->index }}</td>
                          <td>{{ $student->roll_no }}</td>
                          <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                          @switch($markslip->exam_schedule->type)
                            @case('grade')
                              <td>
                                @if(!$attendance?->is_absent)
                                  <select name="student_remarks[{{ $key }}][{{ $student->student_session_id }}][grades][{{ $markslip->exam_schedule->id }}]" class="form-control grade">
                                    <option value="">Grade</option>
                                    @foreach($markslip->grades as $grade)
                                      <option @selected($grade->id == $markslip->exam_schedule?->gradeRemarks?->firstWhere('student_session_id', $student->student_session_id)?->grade_id) value="{{ $grade->id }}">{{ $grade->grade }}</option>
                                    @endforeach
                                  </select>
                                @else
                                  <input class="form-control" style="color: {{ $attendance->color }};" value="{{ $attendance->name }}" readonly>
                                @endif
                              </td>
                            @break
                            @case('marks')
                              <td>
                                @if(!$attendance?->is_absent)
                                  <input type="number" name="student_remarks[{{ $key }}][{{ $student->student_session_id }}][marks][{{ $markslip->exam_schedule->id }}]" min="0" max="{{ $markslip->exam_schedule->marks }}" class="form-control obtain-marks" placeholder="Enter Obtain Marks" value="{{ $markslip->exam_schedule?->remarks?->firstWhere('student_session_id', $student->student_session_id)?->remarks }}">
                                @else
                                  <input class="form-control" style="color: {{ $attendance->color }};" value="{{ $attendance->name }}" readonly>
                                @endif
                              </td>
                              <td>
                                <span class="total-obtain-marks">
                                    {{ (!$attendance?->is_absent) ? ($markslip->exam_schedule?->remarks?->firstWhere('student_session_id', $student->student_session_id)?->remarks ?? '0') : '0' }}
                                </span>
                                / {{ $markslip->exam_schedule->marks }}
                              </td>
                            @break
                            @case('categories')
                              @foreach($markslip->exam_schedule->categories as $category)
                                <td>
                                  @if(!$attendance?->is_absent)
                                    @if($category->is_grade)
                                      <select name="student_remarks[{{ $key }}][{{ $student->student_session_id }}][grading_categories][{{ $category->id }}]" class="form-control grade">
                                        <option value="">Grade</option>
                                        @foreach($markslip->grades as $grade)
                                          <option @selected($grade->id == $category->gradeRemarks?->firstWhere('student_session_id', $student->student_session_id)?->grade_id) value="{{ $grade->id }}">{{ $grade->grade }}</option>
                                        @endforeach
                                      </select>
                                    @else
                                      <input type="number" name="student_remarks[{{ $key }}][{{ $student->student_session_id }}][categories][{{ $category->id }}]" min="0" max="{{ $category->marks }}" class="form-control obtain-marks" placeholder="Enter Marks" value="{{ $category->remarks?->firstWhere('student_session_id', $student->student_session_id)?->remarks }}">
                                    @endif
                                  @else
                                    <input class="form-control" style="color: {{ $attendance->color }};" value="{{ $attendance->name }}" readonly>
                                  @endif
                                </td>
                                @if($loop->last && $markslip->exam_schedule->categories->firstWhere('is_grade', 0))
                                  <td>
                                    <span class="total-obtain-marks">
                                      {{ (!$attendance?->is_absent) ? ($markslip->exam_schedule->categories->pluck('remarks')->collapse()->where('student_session_id', $student->student_session_id)->sum('remarks') ?? '0') : '0' }}
                                    </span>
                                     / {{ $markslip->exam_schedule->categories->sum('marks') }}
                                  </td>
                                @endif
                              @endforeach
                            @break
                          @endswitch
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
              @if(!$loop->last)<br><hr><br>@endif
            @endforeach
          </form>
        </div>
        @if(!$data['has_all_students_absent'])
          <div class="card-footer text-right">
            <button class="btn btn-success btn-save-markslip">Save</button>
          </div>
        @endif
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->
  </div>
@else
  <div class="alert alert-danger w-100">
    The exam schedule for class ( {{ $data['class']->name }} ) is not prepared !
  </div>
@endif