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
        <div class="container">
          <div class="row">
            <div class="col-md-3 text-center">
              <div class="logo">
                <img src="{{ url($settings->school_logo) }}" alt="">
              </div>
            </div>
            <div class="col-md-9">
              <h2 class="school-name text-center">{{ $settings->school_name }}</h2>
              <h3 class="exam-name text-center">{{ $data['exam']->name }} ( {{ $data['exam']->session->name }} )</h3>
              <table class="markslip-details">
                <tbody>
                  <tr>
                    <td class="text-bold">Class :</td>
                    <td>{{ $data['class']->name }}</td>
                    <td class="text-bold">Section :</td>
                    <td>A</td>
                  </tr>
                  <tr>
                    <td class="text-bold pt-3">Group :</td>
                    <td>Computer</td>
                    <td class="text-bold">Subject :</td>
                    <td>English</td>
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
                <tr>
                  <td>1</td>
                  <td>Student Name</td>
                  <td>
                    <input type="number" name="obtain_marks" class="form-control">
                  </td>
                  <td>10/10</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
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