<div class="row">
  <div class="col-12">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <div class="card-title"><i class="fa fa-users"></i> Students</div>
        <div class="card-tools">
          <button class="btn btn-success" id="btn-print-result-cards"><i class="fa fa-print"></i> Print Result Cards</button>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="student-table" class="table table-bordered table-hover table-striped no-wrap">
            <thead>
              <tr>
                <th>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="select-all-students">
                    <label class="form-check-label" for="select-all-students">All</label>
                  </div>
                </th>
                <th>Session</th>
                <th>Admission No.</th>
                <th>Roll No.</th>
                <th>Student Name</th>
                <th>Father Name</th>
                <th>Class</th>
                <th>Section</th>
                @if($data['group'])
                  <th>Group</th>
                @endif
              </tr>
            </thead>
            <tbody>
              @foreach($data['students'] as $student)
                <tr>
                  <td>
                    <div class="form-check">
                      <input class="form-check-input select-student" name="student_session_id[]" value="{{ $student->student_session_id }}" type="checkbox">
                    </div>
                  </td>
                  <td>{{ $data['session']->name }}</td>
                  <td>{{ $student->admission_no }}</td>
                  <td>{{ $student->roll_no }}</td>
                  <td>{{ $student->fullName() }}</td>
                  <td>{{ $student->father_name }}</td>
                  <td>{{ $data['class']->name }}</td>
                  <td>{{ $data['section']->name }}</td>
                  @if($data['group'])
                    <td>{{ $data['group']->name }}</td>
                  @endif
                </tr>
              @endforeach
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