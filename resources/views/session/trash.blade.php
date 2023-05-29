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
            <div class="card">
              <div class="card-header">
                <div class="card-title"><i class="fa fa-trash"></i> {{ $data['page_title'] }}</div>
              </div>
              <div class="card-body">
                <table id="session-trash-table" class="table table-bordered table-hover datatable">
                  <thead>
                    <tr>
                      <th>S No.</th>
                      <th>Name</th>
                      <th>Deleted At</th>
                      @canany(['restore-session', 'permanent-delete-session'])
                        <th>Action</th>
                      @endcanany
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($data['sessions'] as $session)
                      <tr>
                        <td>{{ ++$loop->index }}</td>
                        <td>{{ $session->name }}</td>
                        <td>{{ $session->deleted_at->diffForHumans() }}</td>
                        @canany(['restore-session', 'permanent-delete-session'])
                          <td>
                            @can('restore-session')
                              <button class="btn btn-sm btn-success btn-restore-session" data-url="{{ route('session.restore', $session->id) }}"><i class="fa fa-trash-restore"> Restore</i></button>
                            @endcan
                            @can('permanent-delete-session')
                              <button class="btn btn-sm btn-danger btn-delete-session" data-url="{{ route('session.delete', $session->id) }}"><i class="fa fa-trash"></i> Permanent Delete</button>
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
<script src="{{ url('/assets/js/session.js') }}"></script>
@endsection
