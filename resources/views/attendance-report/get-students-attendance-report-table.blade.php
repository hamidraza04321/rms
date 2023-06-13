<div class="row">
  <div class="col-12">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <div class="card-title"><i class="fa fa-users"></i> Students Attendance Report</div>
      </div>
      <div class="card-body" style="overflow-x: scroll;">
        <div class="row">
          <div class="col-md-12 text-right">
            @foreach($data['attendance_statuses'] as $attendance_status)
              <button class="btn mb-1" style="color: #fff; background-color: {{ $attendance_status->color }};">{{ $attendance_status->short_code }}</button>
            @endforeach
          </div>
        </div>
        <table id="attendance-report-table" class="table table-bordered table-hover no-wrap">
          <thead>
            <tr>
              <th>S No.</th>
              <th>Student Name</th>
              @foreach($data['dates'] as $date)
                <th>
                  {{ date('d', strtotime($date)) }}
                  <br>
                  {{ date('D', strtotime($date)) }}
                </th>
              @endforeach
            </tr>
          </thead>
          <tbody>
            @forelse($data['student_session'] as $student_session)
              <tr>
                <td>{{ ++$loop->index }}</td>
                <td>{{ $student_session->student->fullName() }}</td>
                @foreach($data['dates'] as $date)
                  <td>
                    {{ $student_session->attendances->where('attendance_date', $date)->first()->attendanceStatus->short_code ?? '' }}
                  </td>
                @endforeach
              </tr>
            @empty
            @endforelse
          </tbody>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.col -->
</div>