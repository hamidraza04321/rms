<div class="row">
  <div class="col-12">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <div class="card-title"><i class="fa fa-users"></i> Exam Schedule </div>
        <div class="card-tools">
          <button class="btn btn-success btn-save-exam-schedule">Save</button>
        </div>
      </div>
      <div class="card-body">
        <form action="{{ route('exam-schedule.save') }}" id="save-exam-schedule-form">
          <input type="hidden" name="exam_id" value="{{ $data['exam_id'] }}">
          <input type="hidden" name="session_id" value="{{ $data['session_id'] }}">
          <input type="hidden" name="class_id" value="{{ $data['class_id'] }}">
          <input type="hidden" name="group_id" value="{{ $data['group_id'] }}">
          <div class="row exam-schedule-table-row" style="overflow-x: auto;">
            <table id="exam-schedule-table" class="table table-bordered table-hover no-wrap">
              <thead>
                <tr>
                  <th>Subjects</th>
                  <th>Date</th>
                  <th>Type</th>
                  <th>Marks</th>
                  <th class="mw-40">Categories</th>
                </tr>
              </thead>
              <tbody>
                @forelse($data['subjects'] as $subject)
                  <tr>
                    <td>{{ $subject->name }}</td>
                    <td>
                      <input type="date" name="exam_schedule[{{ $subject->id }}][date]" class="form-control exam-date" value="{{ $subject->exam_schedule?->date ? date('Y-m-d', strtotime($subject->exam_schedule->date)) : '' }}">
                    </td>
                    <td>
                      <select name="exam_schedule[{{ $subject->id }}][type]" class="form-control subject-type mw-120">
                        <option value="">Select</option>
                        <option @selected($subject->exam_schedule?->type == 'grade') value="grade">Grade</option>
                        <option @selected($subject->exam_schedule?->type == 'marks') value="marks">Marks</option>
                        <option @selected($subject->exam_schedule?->type == 'categories') value="categories">Categories</option>
                      </select>
                    </td>
                    <td class="marks {{ $subject->exam_schedule?->type == 'marks' ?: 'bg-disabled' }}">
                      <input type="number" name="exam_schedule[{{ $subject->id }}][marks]" class="form-control mw-120" placeholder="Enter Marks" value="{{ $subject->exam_schedule?->marks }}" @disabled($subject->exam_schedule?->type != 'marks')>
                    </td>
                    <td class="categories {{ $subject->exam_schedule?->type == 'categories' ?: 'bg-disabled' }}">
                      @forelse($subject->exam_schedule?->categories ?? [] as $categoryKey => $category)
                        <div class="row category-row">
                          <div class="col-5 pr-0">
                            <input type="hidden" name="exam_schedule[{{ $subject->id }}][categories][{{ $categoryKey }}][category_id]" value="{{ $category->id }}" class="category-id">
                            <input type="text" name="exam_schedule[{{ $subject->id }}][categories][{{ $categoryKey }}][name]" class="form-control mr-1 mw-120 category-name {{ ($loop->first) ?: 'mt-1' }}" placeholder="Enter Name" value="{{ $category->name }}">
                          </div>
                          <div class="col-5 pr-0">
                            <input type="number" name="exam_schedule[{{ $subject->id }}][categories][{{ $categoryKey }}][marks]" class="form-control mr-1 mw-120 category-marks {{ ($loop->first) ?: 'mt-1' }}" placeholder="Enter Marks" value="{{ $category->marks }}" @disabled($category->is_grade)>
                          </div>
                          <div class="col-1 pr-0">
                            <div class="chk-box {{ ($loop->first) ?: 'mt-1' }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Apply Gradings">
                              <input type="checkbox" name="exam_schedule[{{ $subject->id }}][categories][{{ $categoryKey }}][is_grade]" class="grade-category" @checked($category->is_grade)>
                            </div>
                          </div>
                          <div class="col-1 pr-0">
                            @if($loop->first)
                              <button class="btn btn-primary btn-add-more-category" data-id="{{ $subject->id }}"><i class="fa fa-plus"></i></button>
                            @else
                              <button class="btn btn-danger btn-remove-category mt-1" data-id="{{ $subject->id }}"><i class="fa fa-minus"></i></button>
                            @endif
                          </div>
                        </div>
                      @empty
                        <div class="row category-row">
                          <div class="col-5 pr-0">
                            <input type="text" name="exam_schedule[{{ $subject->id }}][categories][0][name]" class="form-control mr-1 category-name mw-120" placeholder="Enter Name" disabled>
                          </div>
                          <div class="col-5 pr-0">
                            <input type="number" name="exam_schedule[{{ $subject->id }}][categories][0][marks]" class="form-control mr-1 category-marks mw-120" placeholder="Enter Marks" disabled>
                          </div>
                          <div class="col-1 pr-0">
                            <div class="chk-box" data-bs-toggle="tooltip" data-bs-placement="top" title="Apply Gradings">
                              <input type="checkbox" name="exam_schedule[{{ $subject->id }}][categories][0][is_grade]" class="grade-category" disabled>
                            </div>
                          </div>
                          <div class="col-1 pr-0">
                            <button class="btn btn-primary btn-add-more-category" data-id="{{ $subject->id }}" disabled><i class="fa fa-plus"></i></button>
                          </div>
                        </div>
                      @endforelse
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="5" class="text-center">No Record Found !</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </form>
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