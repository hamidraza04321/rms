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
                <div class="card-title"><i class="fa fa-trash"></i> {{ $data['page_title'] }}</div>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table id="grade-trash-table" class="table table-bordered table-hover datatable">
                    <thead>
                      <tr>
                        <th>Class</th>
                        <th>Grade</th>
                        <th>Percentage</th>
                        <th>Color</th>
                        <th>Pass / Fail</th>
                        <th>Default</th>
                        <th>Deleted At</th>
                        @canany(['restore-subject', 'permanent-delete-subject'])
                          <th>Action</th>
                        @endcanany
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($data['grades'] as $grade)
                        <tr>
                          <td>{{ $grade->class->name ?? '--' }}</td>
                          <td>{{ $grade->grade }}</td>
                          <td>{{ $grade->percentage_from }} % to {{ $grade->percentage_to }} %</td>
                          <td>
                            <button class="btn btn-sm btn-grade-color" style="background: {{ $grade->color }}; widows: 40px;"></button>
                          </td>
                          <td>
                            @if($grade->is_fail)
                              <button class="btn btn-sm btn-danger">Fail</button>
                            @else
                              <button class="btn btn-sm btn-success">Pass</button>
                            @endif
                          </td>
                          <td>
                            @if($grade->is_default)
                              <button class="btn btn-sm btn-success">Yes</button>
                            @else
                              <button class="btn btn-sm btn-danger">No</button>
                            @endif
                          </td>
                          <td>{{ $grade->deleted_at->diffForHumans() }}</td>
                          @canany(['restore-grade', 'permanent-delete-grade'])
                            <td>
                              @can('restore-grade')
                                <button class="btn btn-sm btn-success btn-restore-grade" data-url="{{ route('grade.restore', $grade->id) }}"><i class="fa fa-trash-restore"> Restore</i></button>
                              @endcan
                              @can('permanent-delete-grade')
                                <button class="btn btn-sm btn-danger btn-delete-grade" data-url="{{ route('grade.delete', $grade->id) }}"><i class="fa fa-trash"></i> Permanent Delete</button>
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
<script src="{{ url('/assets/js/grade.js') }}"></script>
@endsection
