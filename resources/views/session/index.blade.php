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
                <div class="card-title"><i class="fa fa-calendar"></i>&nbsp; {{ $data['page_title'] }}</div>
                <div class="card-tools">
                  @can('create-session')
                    <a href="{{ route('session.create') }}" class="btn btn-sm btn-info"> <i class="fa fa-plus"></i> Create Session</a>
                  @endcan
                  @can('view-session-trash')
                    <a href="{{ route('session.trash') }}" class="btn btn-sm btn-primary"> <i class="fa fa-eye"></i> View Trash</a>
                  @endcan
                </div>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table id="session-table" class="table table-bordered table-hover datatable">
                    <thead>
                      <tr>
                        <th>S No.</th>
                        <th>Name</th>
                        @can('update-session-status')
                          <th>Status</th>
                        @endcan
                        @canany(['edit-session', 'delete-session'])
                          <th>Action</th>
                        @endcanany
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($data['sessions'] as $session)
                        <tr>
                          <td>{{ ++$loop->index }}</td>
                          <td>{{ $session->name }}</td>
                          @can('update-session-status')
                            <td>
                              @if($session->is_active)
                                <button data-url="{{ route('session.update.status', $session->id) }}" class="btn btn-sm btn-success btn-update-status">Active</button>
                              @else
                                <button data-url="{{ route('session.update.status', $session->id) }}" class="btn btn-sm btn-danger btn-update-status">Deactive</button>
                              @endif
                            </td>
                          @endcan
                          @canany(['edit-session', 'delete-session'])
                            <td>
                              @can('edit-session')
                                <a href="{{ route('session.edit', $session->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Edit</a>
                              @endcan
                              @can('delete-session')
                                <button class="btn btn-sm btn-danger btn-destroy-session" data-url="{{ route('session.destroy', $session->id) }}"><i class="fa fa-trash"></i> Delete</button>
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
<script src="{{ url('/assets/js/session.js') }}"></script>
@endsection
