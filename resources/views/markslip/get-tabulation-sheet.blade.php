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
                      <button class="btn btn-sm mb-1" style="background: {{ $grade->color }}; width: 35px;" data-toggle="tooltip" data-placement="top" title="{{ $grade->percentage_from }}% to {{ $grade->percentage_to }}%">{{ $grade->grade }}</button>
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
              </tr>
              <tr>
                <th></th>
                <th></th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @forelse($data['students'] as $student)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $student->roll_no }}</td>
                  <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                </tr>
              @empty
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