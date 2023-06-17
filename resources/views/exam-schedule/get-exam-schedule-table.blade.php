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
          <div class="row" style="overflow-x: auto;">
            <table id="exam-schedule-table" class="table table-bordered table-hover no-wrap">
              <thead>
                <tr>
                  <th>Subjects</th>
                  <th>Date</th>
                  <th>Type</th>
                  <th>Marks</th>
                  <th>Categories</th>
                </tr>
              </thead>
              <tbody>
                @forelse($data['subjects'] as $subject)
                  <tr>
                    <td>{{ $subject->name }}</td>
                    <td>
                      <input type="date" name="exam_schedule[{{ $subject->id }}][date]" class="form-control exam-date">
                    </td>
                    <td>
                      <select name="exam_schedule[{{ $subject->id }}][type]" class="form-control subject-type">
                        <option value="">Select</option>
                        <option value="grade">Grade</option>
                        <option value="marks">Marks</option>
                        <option value="categories">Categories</option>
                      </select>
                    </td>
                    <td class="marks bg-disabled">
                      <input type="number" name="exam_schedule[{{ $subject->id }}][marks]" placeholder="Enter Marks" class="form-control" disabled>
                    </td>
                    <td class="categories bg-disabled">
                      <div class="d-flex">
                        <input type="text" name="exam_schedule[{{ $subject->id }}][categories][1][name]" placeholder="Enter Name" class="form-control mr-1" disabled>
                        <input type="number" name="exam_schedule[{{ $subject->id }}][categories][1][marks]" class="form-control mr-1" placeholder="Enter Marks" disabled>
                        <button class="btn btn-primary btn-add-more-category" data-id="{{ $subject->id }}" disabled><i class="fa fa-plus"></i></button>
                      </div>
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