@if($data['exam_schedules'])
  <div class="row">
    <div class="col-md-12">
      <div class="card card-primary card-outline">
        <div class="card-header">
          <h3 class="card-title"><i class="fas fa-paste"></i> Tabulation Sheet</h3>
          <div class="card-tools">
            <button class="btn btn-success btn-save-markslip"><i class="fa fa-save"></i> Save Marks</button>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-2 text-center">
              <div class="logo">
                <img src="{{ url($settings->school_logo) }}">
              </div>
            </div>
            <div class="col-md-8">
              <h2 class="school-name text-center">{{ $settings->school_name }}</h2>
              <h3 class="exam-name text-center">{{ $data['exam']->name }} ( {{ $data['exam']->session->name }} )</h3>
              <table class="tabulation-details">
                <tbody>
                  <tr>
                    <td class="text-bold">Class :</td>
                    <td style="width: 40%;">{{ $data['class']->name }}</td>
                    <td class="text-bold">Section :</td>
                    <td style="width: 40%;">{{ $data['section']->name }}</td>
                  </tr>
                  <tr>
                    <td class="text-bold pt-3">Group :</td>
                    <td colspan="3">{{ $data['group']?->name ?? '---' }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="col-md-2">
              <table class="table table-bordered">
                <thead>
                  <th class="text-center">Grading Keys</th>
                </thead>
                <tbody>
                  <tr>
                    <td class="text-center">
                      @foreach($data['gradings'] as $grade)
                        <button class="btn btn-sm mb-1" style="background: {{ $grade->color }}; width: 40px; color: #fff;" data-toggle="tooltip" data-placement="top" title="{{ $grade->percentage_from }}% to {{ $grade->percentage_to }}%">{{ $grade->grade }}</button>
                      @endforeach
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <br>
          <form action="{{ route('save.markslip') }}" id="save-markslip-form">
            <input type="hidden" name="exam_class_id" value="{{ $data['exam_class']->id }}">
            <div class="row overflow-scroll">
              <table class="table table-bordered nowrap" id="tabulation-sheet-table">
                <thead>
                  <tr>
                    <th>S No.</th>
                    <th>Roll No.</th>
                    <th>Student Name</th>
                    @foreach($data['exam_schedules'] as $exam_schedule)
                      <th class="text-center" @if($exam_schedule->has_colspan) colspan="{{ $exam_schedule->colspan }}" @endif>{{ $exam_schedule->subject->name }}</th>
                    @endforeach
                    @if(!$data['has_all_gradings'] && !$data['has_all_category_gradings'])
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                    @else
                      <th>{{ ($data['has_all_gradings']) ? 'Result' : '' }}</th>
                    @endif
                  </tr>
                  @if(!$data['has_all_gradings'])
                    <tr>
                      <th></th>
                      <th></th>
                      <th></th>
                      @foreach($data['exam_schedules'] as $exam_schedule)
                        @switch($exam_schedule->type)
                          @case('grade')
                            <th class="rotate text-center">Grade</th>
                          @break
                          @case('marks')
                           <th class="rotate text-center">Obtain</th>
                           <th class="rotate text-center">Total</th>
                          @break
                          @case('categories')
                            @foreach($exam_schedule->categories as $category)
                              <th class="rotate text-center">{{ $category->name }}</th>
                              @if($loop->last && !$exam_schedule->has_all_category_gradings)
                                <th class="rotate text-center">Total</th>
                              @endif
                            @endforeach
                          @break
                        @endswitch
                      @endforeach
                      @if(!$data['has_all_gradings'] && !$data['has_all_category_gradings'])
                        <th class="rotate text-center">Grand Total</th>
                      @endif
                      <th class="rotate text-center">Result</th>
                      @if(!$data['has_all_gradings'] && !$data['has_all_category_gradings'])
                        <th class="rotate text-center">Grade</th>
                        <th class="rotate text-center">Percentage %</th>
                        <th class="rotate text-center">Rank</th>
                      @endif
                    </tr>
                    @if(!$data['has_all_category_gradings'])
                      <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        @foreach($data['exam_schedules'] as $exam_schedule)
                          @switch($exam_schedule->type)
                            @case('grade')
                              <th></th>
                            @break
                            @case('marks')
                              <th class="text-center">{{ $exam_schedule->marks }}</th>
                              <th class="text-center" exam-schedule-id="{{ $exam_schedule->id }}">
                                {{ $exam_schedule->marks }}
                              </th>
                            @break
                            @case('categories')
                              @foreach($exam_schedule->categories as $category)
                                <th class="text-center">{{ ($category->is_grade) ? '' : $category->marks }}</th>
                                @if($loop->last && !$exam_schedule->has_all_category_gradings)
                                  <th class="text-center" exam-schedule-id="{{ $exam_schedule->id }}">
                                    {{ $exam_schedule->total_marks }}
                                  </th>
                                @endif
                              @endforeach
                            @break
                          @endswitch
                        @endforeach
                        <th class="grand-total">{{ $data['exam_schedules']->sum('total_marks') }}</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                      </tr>
                    @endif
                  @endif
                </thead>
                <tbody>
                  @forelse($data['students'] as $student)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $student->roll_no }}</td>
                      <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                      @foreach($student->remarks as $remarks)
                        @switch($remarks->type)
                          @case('grade')
                            <td>
                              @if(!$remarks->is_absent)
                                <select
                                  name="student_remarks[{{ "{$student->section_id}-{$remarks->subject_id}" }}][{{ $student->student_session_id }}][grades][{{ $remarks->exam_schedule_id }}]"
                                  class="grade-wrap {{ ($remarks->grade?->is_fail) ? 'border-red' : '' }}"
                                  failure-check="true"
                                  student-id="{{ $student->id }}"
                                  is-fail="{{ (empty($remarks->grade) || $remarks->grade->is_fail) ? 'true' : 'false' }}">
                                  <option is-fail="true" value="">Grade</option>
                                  @foreach($data['gradings'] as $grade)
                                    <option 
                                      @selected($remarks->grade?->id == $grade->id)
                                      value="{{ $grade->id }}"
                                      is-fail="{{ ($grade->is_fail) ? 'true' : 'false' }}">
                                      {{ $grade->grade }}
                                    </option>
                                  @endforeach
                                </select>
                              @else
                                <span
                                  class="absent-wrap"
                                  style="color: {{ $remarks->attendance_status->color }};">
                                  {{ $remarks->attendance_status->name }}
                                </span>
                              @endif
                            </td>
                          @break
                          @case('marks')
                            <td>
                              @if(!$remarks->is_absent)
                                <input 
                                  type="number"
                                  name="student_remarks[{{ "{$student->section_id}-{$remarks->subject_id}" }}][{{ $student->student_session_id }}][marks][{{ $remarks->exam_schedule_id }}]"
                                  min="0"
                                  max="{{ $remarks->total_marks }}"
                                  class="marks-wrap"
                                  value="{{ $remarks->obtain_marks }}"
                                  student-id="{{ $student->id }}"
                                  exam-schedule-id="{{ $remarks->exam_schedule_id }}">
                              @else
                                <span 
                                  class="absent-wrap"
                                  style="color: {{ $remarks->attendance_status->color }};">
                                  {{ $remarks->attendance_status->name }}
                                </span>
                              @endif
                            </td>
                            <td
                              class="text-center text-adjust text-white"
                              style="background: {{ $remarks->grade?->color }};">
                              <span
                                class="total-marks"
                                is-fail="{{ ($remarks->grade?->is_fail) ? 'true' : 'false' }}"
                                student-id="{{ $student->id }}"
                                exam-schedule-id="{{ $remarks->exam_schedule_id }}">
                                {{ $remarks->obtain_marks }}
                              </span>
                            </td>
                          @break
                          @case('category_grade')
                            <td>
                              @if(!$remarks->is_absent)
                                <select
                                  name="student_remarks[{{ "{$student->section_id}-{$remarks->subject_id}" }}][{{ $student->student_session_id }}][grading_categories][{{ $remarks->category_id }}]"
                                  class="grade-wrap"
                                  failure-check="false">
                                  <option value="">Grade</option>
                                  @foreach($data['gradings'] as $grade)
                                    <option 
                                      @selected($remarks->grade?->id == $grade->id) 
                                      value="{{ $grade->id }}">
                                      {{ $grade->grade }}
                                    </option>
                                  @endforeach
                                </select>
                              @else
                                <span 
                                  class="absent-wrap" 
                                  style="color: {{ $remarks->attendance_status->color }};">
                                  {{ $remarks->attendance_status->name }}
                                </span>
                              @endif
                            </td>
                          @break
                          @case('category_marks')
                            <td>
                              @if(!$remarks->is_absent)
                                <input
                                  type="number"
                                  name="student_remarks[{{ "{$student->section_id}-{$remarks->subject_id}" }}][{{ $student->student_session_id }}][categories][{{ $remarks->category_id }}]"
                                  min="0"
                                  max="{{ $remarks->total_marks }}"
                                  class="marks-wrap"
                                  value="{{ $remarks->obtain_marks }}"
                                  student-id="{{ $student->id }}"
                                  exam-schedule-id="{{ $remarks->exam_schedule_id }}">
                              @else
                                <span
                                  class="absent-wrap"
                                  style="color: {{ $remarks->attendance_status->color }};">
                                  {{ $remarks->attendance_status->name }}
                                </span>
                              @endif
                            </td>
                          @break
                          @case('category_total')
                            <td
                              class="text-center text-adjust text-white"
                              style="background: {{ $remarks->grade?->color }};">
                              <span
                                class="total-marks"
                                student-id="{{ $student->id }}"
                                is-fail="{{ ($remarks->grade?->is_fail) ? 'true' : 'false' }}"
                                exam-schedule-id="{{ $remarks->exam_schedule_id }}">
                                {{ $remarks->obtain_marks }}
                              </span>
                            </td>
                          @break
                          @case('grand_total')
                            @if(!$data['has_all_gradings'] && !$data['has_all_category_gradings'])
                              <td class="text-center text-adjust">
                                <span class="grand-obtain" student-id="{{ $student->id }}">{{ $remarks->grand_obtain }}</span>
                              </td>
                            @endif
                            <td class="text-center text-adjust">
                              <span class="result" student-id="{{ $student->id }}" style="color: {{ ($remarks->result == 'Pass') ? 'green' : 'red';  }}">{{ $remarks->result }}</span>
                            </td>
                            @if(!$data['has_all_gradings'] && !$data['has_all_category_gradings'])
                              <td class="text-center text-adjust text-white" style="background: {{ $remarks->grade?->color }};">
                                <span class="grand-grade" student-id="{{ $student->id }}">{{ $remarks->grade?->grade }}</span>
                              </td>
                              <td class="text-center text-adjust">
                                <span class="grand-percentage" student-id="{{ $student->id }}">{{ $remarks->percentage }} %</span>
                              </td>
                              <td class="text-center text-adjust">
                                <span class="rank" student-id="{{ $student->id }}">{{ ($remarks->result != 'Fail') ? $student->rank : '--' }}</span>
                              </td>
                            @endif
                          @break
                        @endswitch
                      @endforeach
                    </tr>
                  @empty
                    <tr>
                      <td class="text-center" colspan="100%">Students not found !</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </form>
        </div>
        <div class="card-footer text-right">
          <button class="btn btn-success btn-save-markslip"><i class="fa fa-save"></i> Save Marks</button>
        </div>
        <!-- /.card -->
      </div>
    </div>
    <!-- /.col -->
  </div>
  <script>
    var gradings = {!! json_encode($data['gradings']) !!};
  </script>
@else
  <div class="alert alert-danger text-center">
    The exam schedules for class ( {{ $data['class']->name }} ) is not prepared !
  </div>
@endif