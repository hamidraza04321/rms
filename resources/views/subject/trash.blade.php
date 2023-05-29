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
                <table id="subject-trash-table" class="table table-bordered table-hover datatable">
                  <thead>
                    <tr>
                      <th>S No.</th>
                      <th>Name</th>
                      <th>Deleted At</th>
                      @canany(['restore-subject', 'permanent-delete-subject'])
                        <th>Action</th>
                      @endcanany
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($data['subjects'] as $subject)
                      <tr>
                        <td>{{ ++$loop->index }}</td>
                        <td>{{ $subject->name }}</td>
                        <td>{{ $subject->deleted_at->diffForHumans() }}</td>
                        @canany(['restore-subject', 'permanent-delete-subject'])
                          <td>
                            @can('restore-subject')
                              <button class="btn btn-sm btn-success btn-restore-subject" data-url="{{ route('subject.restore', $subject->id) }}"><i class="fa fa-trash-restore"> Restore</i></button>
                            @endcan
                            @can('permanent-delete-subject')
                              <button class="btn btn-sm btn-danger btn-delete-subject" data-url="{{ route('subject.delete', $subject->id) }}"><i class="fa fa-trash"></i> Permanent Delete</button>
                            @endcan
                          </td>
                        @endcanany
                      </tr>
                    @endforeach
                  </tbody>
                </table>
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
<script src="{{ url('/assets/js/subject.js') }}"></script>
@endsection
