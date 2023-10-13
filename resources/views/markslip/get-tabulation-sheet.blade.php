@if($data['examSchedules'])
  <div class="row">
    <div class="col-md-12">
      <div class="card card-primary card-outline">
        <div class="card-header">
          <h3 class="card-title"><i class="fas fa-paste"></i> Tabulation Sheet</h3>
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
                        <button class="btn btn-sm mb-1" style="background: {{ $grade->color }}; width: 35px; color: #fff;" data-toggle="tooltip" data-placement="top" title="{{ $grade->percentage_from }}% to {{ $grade->percentage_to }}%">{{ $grade->grade }}</button>
                      @endforeach
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <br>
          <div class="row overflow-scroll">
            <table class="table table-bordered nowrap">
              <thead>
                <tr>
                  <th>S No.</th>
                  <th>Roll No.</th>
                  <th>Student Name</th>
                  @foreach($data['examSchedules'] as $examSchedule)
                    <th class="text-center" @if($examSchedule->has_colspan) colspan="{{ $examSchedule->colspan }}" @endif>{{ $examSchedule->subject->name }}</th>
                  @endforeach
                  @if(!$data['hasAllGradings'])
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                  @else
                    <th>Result</th>
                  @endif
                </tr>
                @if(!$data['hasAllGradings'])
                  <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    @foreach($data['examSchedules'] as $examSchedule)
                      @switch($examSchedule->type)
                        @case('grade')
                          <th class="rotate text-center">Grade</th>
                        @break
                        @case('marks')
                         <th class="rotate text-center">Obtain</th>
                         <th class="rotate text-center">Total</th>
                        @break
                        @case('categories')
                          @foreach($examSchedule->categories as $category)
                            <th class="rotate text-center">{{ $category->name }}</th>
                            @if($loop->last && !$examSchedule->has_all_category_gradings)
                              <th class="rotate text-center">Total</th>
                            @endif
                          @endforeach
                        @break
                      @endswitch
                    @endforeach
                    <th class="rotate text-center">Grand Total</th>
                    <th class="rotate text-center">Result</th>
                    <th class="rotate text-center">Grade</th>
                    <th class="rotate text-center">Percentage %</th>
                    <th class="rotate text-center">Rank</th>
                  </tr>
                  @if(!$data['hasAllCategoryGradings'])
                    <tr>
                      <th></th>
                      <th></th>
                      <th></th>
                      @foreach($data['examSchedules'] as $examSchedule)
                        @switch($examSchedule->type)
                          @case('grade')
                            <th></th>
                          @break
                          @case('marks')
                            <th class="text-center">{{ $examSchedule->marks }}</th>
                            <th class="text-center">{{ $examSchedule->marks }}</th>
                          @break
                          @case('categories')
                            @foreach($examSchedule->categories as $category)
                              <th class="text-center">{{ ($category->is_grade) ? '' : $category->marks }}</th>
                              @if($loop->last && !$examSchedule->has_all_category_gradings)
                                <th class="text-center">{{ $category->sum('marks') }}</th>
                              @endif
                            @endforeach
                          @break
                        @endswitch
                      @endforeach
                      <th>{{ $data['examSchedules']->sum('total_marks') }}</th>
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
                            <select name="" class="grade-wrap {{ ($remarks->grade?->is_fail) ? 'border-red' : '' }}">
                              <option value="">Grade</option>
                              @foreach($data['gradings'] as $grade)
                                <option @selected($remarks->grade?->id == $grade->id) value="{{ $grade->id }}">{{ $grade->grade }}</option>
                              @endforeach
                            </select>
                          </td>
                        @break
                        @case('marks')
                          <td>
                            <input type="number" name="" min="0" max="{{ $remarks->total_marks }}" class="marks-wrap" value="{{ $remarks->obtain_marks }}">
                          </td>
                          <td class="text-center total-marks text-white" style="background: {{ $remarks->grade?->color }};">
                            <span>{{ $remarks->obtain_marks }}</span>
                          </td>
                        @break
                        @case('category_grade')
                          <td>
                            <select name="" class="grade-wrap">
                              <option value="">Grade</option>
                              @foreach($data['gradings'] as $grade)
                                <option @selected($remarks->grade?->id == $grade->id) value="{{ $grade->id }}">{{ $grade->grade }}</option>
                              @endforeach
                            </select>
                          </td>
                        @break
                        @case('category_marks')
                          <td>
                            <input type="number" name="" min="0" max="{{ $remarks->total_marks }}" class="marks-wrap" value="{{ $remarks->obtain_marks }}">
                          </td>
                        @break
                        @case('category_total')
                          <td class="text-center text-adjust text-white" style="background: {{ $remarks->grade?->color }};">
                            <span>{{ $remarks->obtain_marks }}</span>
                          </td>
                        @break
                        @case('grand_total')
                          @if(!$data['hasAllGradings'] && !$data['hasAllCategoryGradings'])
                            <td class="text-center text-adjust">
                              <span>{{ $remarks->grand_obtain }}</span>
                            </td>
                          @endif
                          <td class="text-center text-adjust">
                            <span style="color: {{ ($remarks->result == 'Pass') ? 'green' : 'red';  }}">{{ $remarks->result }}</span>
                          </td>
                          @if(!$data['hasAllGradings'] && !$data['hasAllCategoryGradings'])
                            <td class="text-center text-adjust text-white" style="background: {{ $remarks->grade?->color }};">
                              <span>{{ $remarks->grade?->grade }}</span>
                            </td>
                            <td class="text-center text-adjust">
                              <span>{{ $remarks->percentage }} %</span>
                            </td>
                            <td class="text-center text-adjust">
                              <span>{{ ($remarks->result != 'Fail') ? $student->rank : '--' }}</span>
                            </td>
                          @endif
                        @break
                      @endswitch
                    @endforeach
                  </tr>
                @empty
                  <tr>
                    <td class="text-center" colspan="">Students not found !</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
        <!-- /.card -->
      </div>
    </div>
    <!-- /.col -->
  </div>
@else
  <div class="alert alert-danger text-center">
    The exam schedules for class ( {{ $data['class']->name }} ) is not prepared !
  </div>
@endif