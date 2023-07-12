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
                <div class="card-title"><i class="fa fa-medal"></i> {{ $data['page_title'] }}</div>
                <div class="card-tools">
                  @can('create-grade')
                    <a href="{{ route('grade.create') }}" class="btn btn-sm btn-info"> <i class="fa fa-plus"></i> Create Grade</a>
                  @endcan
                  @can('view-grade-trash')
                    <a href="{{ route('grade.trash') }}" class="btn btn-sm btn-primary"> <i class="fa fa-eye"></i> View Trash</a>
                  @endcan
                </div>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table id="grade-table" class="table table-bordered table-hover datatable">
                    <thead>
                      <tr>
                        <th>Class</th>
                        <th>Grade</th>
                        <th>Percentage</th>
                        <th>Color</th>
                        <th>Pass / Fail</th>
                        @can('update-grade-status')
                          <th>Status</th>
                        @endcan
                        @canany(['edit-grade', 'delete-grade'])
                          <th>Action</th>
                        @endcanany
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($data['grades'] as $grade)
                        <tr>
                          <td>{{ $grade->class->name }}</td>
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
                          @can('update-grade-status')
                            <td>
                              @if($grade->is_active)
                                <button data-url="{{ route('grade.update.status', $grade->id) }}" class="btn btn-sm btn-success btn-update-status">Active</button>
                              @else
                                <button data-url="{{ route('grade.update.status', $grade->id) }}" class="btn btn-sm btn-danger btn-update-status">Deactive</button>
                              @endif
                            </td>
                          @endcan
                          @canany(['edit-grade', 'delete-grade'])
                            <td>
                              @can('edit-grade')
                                <a href="{{ route('grade.edit', $grade->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Edit</a>
                              @endcan
                              @can('delete-grade')
                                <button class="btn btn-sm btn-danger btn-destroy-grade" data-url="{{ route('grade.destroy', $grade->id) }}"><i class="fa fa-trash"></i> Delete</button>
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
