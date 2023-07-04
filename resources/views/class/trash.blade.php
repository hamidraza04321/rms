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
                  <table id="class-trash-table" class="table table-bordered table-hover datatable">
                    <thead>
                      <tr>
                        <th>S No.</th>
                        <th>Name</th>
                        <th>Deleted At</th>
                        @canany(['restore-class', 'permanent-delete-class'])
                          <th>Action</th>
                        @endcanany
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($data['classes'] as $class)
                        <tr>
                          <td>{{ ++$loop->index }}</td>
                          <td>{{ $class->name }}</td>
                          <td>{{ $class->deleted_at->diffForHumans() }}</td>
                          @canany(['restore-class', 'permanent-delete-class'])
                            <td>
                              @can('restore-class')
                                <button class="btn btn-sm btn-success btn-restore-class" data-url="{{ route('class.restore', $class->id) }}"><i class="fa fa-trash-restore"> Restore</i></button>
                              @endcanany
                              @can('permanent-delete-class')
                                <button class="btn btn-sm btn-danger btn-delete-class" data-url="{{ route('class.delete', $class->id) }}"><i class="fa fa-trash"></i> Permanent Delete</button>
                              @endcanany
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
<script src="{{ url('/assets/js/class.js') }}"></script>
@endsection
