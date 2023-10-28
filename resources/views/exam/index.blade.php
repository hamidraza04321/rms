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
                <div class="card-title"><i class="fa fa-file-signature"></i> {{ $data['page_title'] }}</div>
                <div class="card-tools">
                  @can('create-exam')
                    <a href="{{ route('exam.create') }}" class="btn btn-sm btn-info"> <i class="fa fa-plus"></i> Create Exam</a>
                  @endcan
                  @can('view-exam-trash')
                    <a href="{{ route('exam.trash') }}" class="btn btn-sm btn-primary"> <i class="fa fa-eye"></i> View Trash</a>
                  @endcan
                </div>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table id="exam-table" class="table table-bordered table-hover datatable">
                    <thead>
                      <tr>
                        <th>S No.</th>
                        <th>Session</th>
                        <th>Name</th>
                        @can('update-exam-status')
                          <th>Status</th>
                        @endcan
                        @canany(['print-datesheet', 'edit-exam', 'delete-exam'])
                          <th>Action</th>
                        @endcanany
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($data['exams'] as $exam)
                        <tr>
                          <td>{{ ++$loop->index }}</td>
                          <td>{{ $exam->session->name }}</td>
                          <td>{{ $exam->name }}</td>
                          @can('update-exam-status')
                            <td>
                              @if($exam->is_active)
                                <button data-url="{{ route('exam.update.status', $exam->id) }}" class="btn btn-sm btn-success btn-update-status">Active</button>
                              @else
                                <button data-url="{{ route('exam.update.status', $exam->id) }}" class="btn btn-sm btn-danger btn-update-status">Deactive</button>
                              @endif
                            </td>
                          @endcan
                          @canany(['print-datesheet', 'edit-exam', 'delete-exam'])
                            <td>
                              @can('print-datesheet')
                                <a href="{{ route('exam.datesheet', $exam->id) }}" class="btn btn-sm btn-warning text-white" target="_blank"><i class="fa fa-print"></i> Print Datesheet</a>
                              @endcan
                              @can('edit-exam')
                                <a href="{{ route('exam.edit', $exam->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Edit</a>
                              @endcan
                              @can('delete-exam')
                                <button class="btn btn-sm btn-danger btn-destroy-exam" data-url="{{ route('exam.destroy', $exam->id) }}"><i class="fa fa-trash"></i> Delete</button>
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
<script src="{{ url('/assets/js/exam.js') }}"></script>
@endsection
