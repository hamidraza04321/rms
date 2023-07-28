<div class="row">
  <div class="col-12">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <div class="card-title"><i class="fa fa-users"></i> Students Attendance Report</div>
        <div class="card-tools">
          <button id="btn-print-attendance-report" class="btn btn-primary"><i class="fa fa-print"></i> Print</button>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive" style="overflow-x: scroll;" id="attendance-report">
          <table id="attendance-report-table" class="table table-bordered table-hover no-wrap">
            <thead>
              <tr>
                <th>S No.</th>
                <th>Student Name</th>
                @foreach($data['dates'] as $date)
                  <th class="text-center">
                    {{ date('d', strtotime($date)) }}
                    <br>
                    {{ date('D', strtotime($date)) }}
                  </th>
                @endforeach
                @foreach($data['attendance_statuses'] as $attendance_status)
                  <th class="text-center">
                    % <br> {{ $attendance_status->short_code }}
                  </th>
                @endforeach
              </tr>
            </thead>
            <tbody>
              @forelse($data['student_session'] as $student_session)
                <tr>
                  <td>{{ ++$loop->index }}</td>
                  <td>{{ $student_session->student->fullName() }}</td>
                  @foreach($student_session->attendances as $attendance)
                    <td class="text-center font-italic">
                      <span @if($attendance->color) style="color: {{ $attendance->color; }}" @endif>{{ $attendance->short_code }}</span>
                    </td>
                  @endforeach
                  @foreach($student_session->attendance_percentage as $percentage)
                    <td class="text-center">{{ $percentage }}</td>
                  @endforeach
                </tr>
              @empty
                <tr>
                  <td class="text-center" colspan="{{ count($data['dates']) + count($data['attendance_statuses']) + 2 }}">No Record Found!</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.col -->
</div>