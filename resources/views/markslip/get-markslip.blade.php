<div class="row">
  <div class="col-12">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <div class="card-title"><i class="fa fa-paste"></i> Mark Slip </div>
        <div class="card-tools">
          <button class="btn btn-success btn-save-markslip">Save</button>
        </div>
      </div>
      <div class="card-body">
        @foreach($markslips as $markslip)
          <div class="container">
            <div class="row">
              <div class="col-md-3 text-center">
                <div class="logo">
                  <img src="{{ url($settings->school_logo) }}" alt="">
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
                      <td>{{ $markslip->group ?? '-' }}</td>
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
                    <th>Roll No.</th>
                    <th>Student Name</th>
                    {{-- SWITCH EXAM SCHEDULE TYPE --}}
                    @switch($markslip->exam_schedule->type)
                      
                      {{-- GRADE --}}
                      @case('grade')
                        <th>Grade</th>
                      @break
                      
                      {{-- MAKRS --}}
                      @case('marks')
                        <th>Obtain Marks</th>
                        <th>Total Marks</th>
                      @break

                      {{-- CATEGORIES --}}
                      @case('categories')
                        @foreach($markslip->exam_schedule->categories as $category)
                          <th class="text-center">
                            {{ $category->name }}
                            @if(!$category->is_grade)
                              <br>
                              [ {{ $category->marks }} ]
                            @endif
                          </th>

                          {{-- CHECK IF ANY CATEGORY IS MARKS AND LOOP IS LAST --}}
                          @if($loop->last && $markslip->exam_schedule->categories->firstWhere('is_grade', 0))
                            <th>Total Marks</th>
                          @endif
                        @endforeach
                      @break

                    @endswitch
                  </tr>
                </thead>
                <tbody>
                  @foreach($markslip->students as $student)
                    <tr>
                      <td>{{ $student->roll_no }}</td>
                      <td>{{ $student->first_name }} {{ $student->last_name }}</td>

                      {{-- SWITCH EXAM SCHEDULE TYPE --}}
                      @switch($markslip->exam_schedule->type)

                        {{-- GRADE --}}
                        @case('grade')
                          <td>
                            <select class="form-control grade">
                              <option value="">Grade</option>
                              @foreach($markslip->grades as $grade)
                                <option value="{{ $grade->id }}">{{ $grade->grade }}</option>
                              @endforeach
                            </select>
                          </td>
                        @break
                        
                        {{-- MARKS --}}
                        @case('marks')
                          <td>
                            <input type="number" min="0" max="{{ $markslip->exam_schedule->marks }}" class="form-control" placeholder="Enter Obtain Marks">
                          </td>
                          <td>
                            0 / {{ $markslip->exam_schedule->marks }}
                          </td>
                        @break

                        {{-- CATEGORIES --}}
                        @case('categories')
                          @foreach($markslip->exam_schedule->categories as $category)
                            <td class="text-center">
                              @if($category->is_grade)
                                <select name="grade" class="form-control grade">
                                  <option value="">Grade</option>
                                  @foreach($markslip->grades as $grade)
                                    <option value="{{ $grade->id }}">{{ $grade->grade }}</option>
                                  @endforeach
                                </select>
                              @else
                                <input type="number" min="0" max="{{ $category->marks }}" class="form-control" placeholder="Enter Marks">
                              @endif

                              {{-- IF LOOP IS LAST FROM CATEGORIES. AND ALSO CHECK IF ANY MARKS CATEGORY IS EXISTS --}}
                              @if($loop->last && $markslip->exam_schedule->categories->firstWhere('is_grade', 0))
                                <td>
                                  <span>0</span> / {{ $markslip->exam_schedule->categories->sum('marks') }}
                                </td>
                              @endif
                            </td>
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
      </div>
      <div class="card-footer text-right">
        <button class="btn btn-success btn-save-exam-schedule">Save</button>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.col -->
</div>