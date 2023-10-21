<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $data['page_title'] }}</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ url('assets/css/markslip.css') }}">
  </head>
  <body onload="window.print()">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card card-primary card-outline">
            <div class="card-body">
              <div class="container">
                <div class="row">
                  <div class="col-md-3 text-center">
                    <div class="logo">
                      <img src="{{ url($settings->school_logo) }}">
                    </div>
                  </div>
                  <div class="col-md-9">
                    <h2 class="school-name text-center">{{ $settings->school_name }}</h2>
                    <h3 class="exam-name text-center">{{ $data['markslip']->exam }} ( {{ $data['markslip']->session }} )</h3>
                    <table class="markslip-details no-wrap">
                      <tbody>
                        <tr>
                          <td class="text-bold text-bottom">Class :</td>
                          <td style="width: 40%;" class="text-bottom">{{ $data['markslip']->class }}</td>
                          <td class="text-bold" class="text-bottom">Section :</td>
                          <td style="width: 40%;" class="text-bottom">{{ $data['markslip']->section }}</td>
                        </tr>
                        <tr>
                          <td class="text-bold pt-3 text-bottom">Group :</td>
                          <td class="text-bottom">{{ $data['markslip']->group }}</td>
                          <td class="text-bold text-bottom">Subject :</td>
                          <td class="text-bottom">{{ $data['markslip']->subject }}</td>
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
                        @switch($data['markslip']->exam_schedule->type)
                          @case('grade')
                            <th>Grade</th>
                          @break
                          @case('marks')
                            <th>Obtain Marks</th>
                            <th>Total Marks</th>
                          @break
                          @case('categories')
                            @foreach($data['markslip']->exam_schedule->categories as $category)
                              <th class="text-center">
                                {{ $category->name }}
                                @if(!$category->is_grade)
                                  <br>
                                  [ {{ $category->marks }} ]
                                @endif
                              </th>
                              @if($loop->last && $data['markslip']->exam_schedule->categories->firstWhere('is_grade', 0))
                                <th nowrap>Total Marks</th>
                              @endif
                            @endforeach
                          @break
                        @endswitch
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($data['markslip']->students as $student)
                        @php
                          $key = "{$student->section_id}-{$data['markslip']->exam_schedule->subject_id}";
                          $exam_date = date('Y-m-d', strtotime($data['markslip']->exam_schedule->date));
                          $attendance = $student->attendances?->firstWhere('attendance_date', $exam_date);
                        @endphp
                        <tr>
                          <td>{{ ++$loop->index }}</td>
                          <td>{{ $student->roll_no }}</td>
                          <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                          @switch($data['markslip']->exam_schedule->type)
                            @case('grade')
                              <td>
                                @if(!$attendance?->is_absent)
                                  <select name="student_remarks[{{ $key }}][{{ $student->student_session_id }}][grades][{{ $data['markslip']->exam_schedule->id }}]" class="form-control grade">
                                    <option value="">Grade</option>
                                    @foreach($data['markslip']->grades as $grade)
                                      <option @selected($grade->id == $data['markslip']->exam_schedule?->gradeRemarks?->firstWhere('student_session_id', $student->student_session_id)?->grade_id) value="{{ $grade->id }}">{{ $grade->grade }}</option>
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
                                  <input type="number" name="student_remarks[{{ $key }}][{{ $student->student_session_id }}][marks][{{ $data['markslip']->exam_schedule->id }}]" min="0" max="{{ $data['markslip']->exam_schedule->marks }}" class="form-control obtain-marks" placeholder="Enter Obtain Marks" value="{{ $data['markslip']->exam_schedule?->remarks?->firstWhere('student_session_id', $student->student_session_id)?->remarks }}">
                                @else
                                  <input class="form-control" style="color: {{ $attendance->color }};" value="{{ $attendance->name }}" readonly>
                                @endif
                              </td>
                              <td>
                                <span class="total-obtain-marks">
                                    {{ (!$attendance?->is_absent) ? ($data['markslip']->exam_schedule?->remarks?->firstWhere('student_session_id', $student->student_session_id)?->remarks ?? '0') : '0' }}
                                </span>
                                / {{ $data['markslip']->exam_schedule->marks }}
                              </td>
                            @break
                            @case('categories')
                              @foreach($data['markslip']->exam_schedule->categories as $category)
                                <td>
                                  @if(!$attendance?->is_absent)
                                    @if($category->is_grade)
                                      <select name="student_remarks[{{ $key }}][{{ $student->student_session_id }}][grading_categories][{{ $category->id }}]" class="form-control grade">
                                        <option value="">Grade</option>
                                        @foreach($data['markslip']->grades as $grade)
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
                                @if($loop->last && $data['markslip']->exam_schedule->categories->firstWhere('is_grade', 0))
                                  <td>
                                    <span class="total-obtain-marks">
                                      {{ (!$attendance?->is_absent) ? ($data['markslip']->exam_schedule->categories->pluck('remarks')->collapse()->where('student_session_id', $student->student_session_id)->sum('remarks') ?? '0') : '0' }}
                                    </span>
                                     / {{ $data['markslip']->exam_schedule->categories->sum('marks') }}
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
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
    </div>
  </body>
</html>