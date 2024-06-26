@extends('layout.app')
@section('page-title', $data['page_title'])
@section('main-content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">{{ $data['page_title'] }}</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">{{ $data['menu'] }}</a></li>
              <li class="breadcrumb-item active">{{ $data['page_title'] }}</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <div class="card-title"><i class="fa fa-book"></i> {{ $data['page_title'] }}</div>
                <div class="card-tools">
                  @can('create-attendance-status')
                    <a href="{{ route('attendance-status.create') }}" class="btn btn-sm btn-info"> <i class="fa fa-plus"></i> Create Status</a>
                  @endcan
                  @can('view-attendance-status-trash')
                    <a href="{{ route('attendance-status.trash') }}" class="btn btn-sm btn-primary"> <i class="fa fa-eye"></i> View Trash</a>
                  @endcan
                </div>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table id="attendance-status-table" class="table table-bordered table-hover datatable">
                    <thead>
                      <tr>
                        <th>S No.</th>
                        <th>Name</th>
                        <th>Short Code</th>
                        <th>Type</th>
                        <th>Color</th>
                        @can('update-attendance-status')
                          <th>Status</th>
                        @endcan
                        @canany(['edit-attendance-status', 'delete-attendance-status'])
                          <th>Action</th>
                        @endcanany
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($data['attendance_statuses'] as $attendance_status)
                        <tr>
                          <td>{{ ++$loop->index }}</td>
                          <td>{{ $attendance_status->name }}</td>
                          <td>{{ $attendance_status->short_code }}</td>
                          <td>{{ ucwords($attendance_status->type) }}</td>
                          <td>
                            <button class="btn-color" style="background-color: {{ $attendance_status->color }};"></button>
                          </td>
                          @can('update-attendance-status')
                            <td>
                              @if($attendance_status->is_active)
                                <button data-url="{{ route('attendance-status.update.status', $attendance_status->id) }}" class="btn btn-sm btn-success btn-update-status">Active</button>
                              @else
                                <button data-url="{{ route('attendance-status.update.status', $attendance_status->id) }}" class="btn btn-sm btn-danger btn-update-status">Deactive</button>
                              @endif
                            </td>
                          @endcan
                          @canany(['edit-attendance-status', 'delete-attendance-status'])
                            <td>
                              @can('edit-attendance-status')
                                <a href="{{ route('attendance-status.edit', $attendance_status->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Edit</a>
                              @endcan
                              @can('delete-attendance-status')
                                <button class="btn btn-sm btn-danger btn-destroy-attendance-status" data-url="{{ route('attendance-status.destroy', $attendance_status->id) }}"><i class="fa fa-trash"></i> Delete</button>
                              @endcan
                            </td>
                          @endcanany
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
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
  </div>
@endsection
@section('scripts')
<script src="{{ url('/assets/js/attendance-status.js') }}"></script>
@endsection
