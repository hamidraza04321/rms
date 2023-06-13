<div class="row">
  <div class="col-12">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <div class="card-title"><i class="fa fa-users"></i> Students List</div>
        <div class="card-tools">
          <button class="btn btn-success btn-save-attendance">Save Attendance</button>
        </div>
      </div>
      <div class="card-body">
        <form action="{{ route('save.student.attendance') }}" id="save-attendance-form">
          <input type="hidden" name="attendance_date" value="{{ $data['attendance_date'] }}">
          <table id="mark-attendance-table" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>S No.</th>
                <th>Student Name</th>
                @foreach($data['attendance_statuses'] as $attendance_status)
                  <th>
                    <div class="form-check">
                      <input 
                        type="radio" 
                        class="form-check-input check-all-attendance" 
                        id="attendance-{{ $attendance_status->id }}"
                        data-id="{{ $attendance_status->id }}" 
                        style="accent-color: {{ $attendance_status->color; }};"
                        @checked($data['student_session']->count() != 0 && $data['student_session']->count() == $data['student_session']->where('attendance_status_id', $attendance_status->id)->count())
                      >
                      <label class="form-check-label mr-3 cursor-pointer" for="attendance-{{ $attendance_status->id }}">{{ $attendance_status->name }}</label>
                    </div>
                  </th>
                @endforeach
              </tr>
            </thead>
            <tbody>
              @forelse($data['student_session'] as $student_session)
                <tr>
                  <td>{{ ++$loop->index }}</td>
                  <td>{{ $student_session->student->fullName() }}</td>
                  @foreach($data['attendance_statuses'] as $attendance_status)
                    <td>
                      <div class="form-check">
                        <input
                          type="radio"
                          name="attendances[{{ $student_session->id }}]"
                          id="attendance-{{ "{$student_session->id}-{$attendance_status->id}" }}"
                          class="form-check-input attendance"
                          value="{{ $attendance_status->id }}"
                          data-id="{{ $attendance_status->id }}"
                          style="accent-color: {{ $attendance_status->color; }};"
                          @checked($student_session->attendance_status_id == $attendance_status->id)
                        >
                        <label class="form-check-label mr-3 cursor-pointer" for="attendance-{{ "{$student_session->id}-{$attendance_status->id}" }}">{{ $attendance_status->name }}</label>
                      </div>
                    </td>
                  @endforeach
                </tr>
              @empty
                <tr>
                  <td class="text-center" colspan="{{ count($data['attendance_statuses']) + 2 }}">No Record Found!</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </form>
      </div>
      <div class="card-footer text-right">
        <button class="btn btn-success btn-save-attendance">Save Attendance</button>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.col -->
</div>