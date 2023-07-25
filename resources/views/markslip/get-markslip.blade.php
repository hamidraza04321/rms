<div class="row">
  <div class="col-12">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <div class="card-title"><i class="fa fa-file"></i> Mark Slip </div>
        <div class="card-tools">
          <button class="btn btn-success btn-save-markslip">Save</button>
        </div>
      </div>
      <div class="card-body">
        @foreach($data['markslips'] as $markslip)
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
                    <th>Obtain Marks</th>
                    <th>Total Marks</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($markslip->students as $student)
                    <tr>
                      <td>{{ $student->roll_no }}</td>
                      <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                      <td>
                        <input type="number" name="obtain_marks" class="form-control">
                      </td>
                      <td>10/10</td>
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