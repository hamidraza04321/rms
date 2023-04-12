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
                <div class="card-title">{{ $data['page_title'] }}</div>
                <div class="card-tools">
                  <a href="{{ route('role.create') }}" class="btn btn-sm btn-info"> <i class="fa fa-plus"></i> Create Role</a>
                </div>
              </div>
              <div class="card-body">
                <table id="role-table" class="table table-bordered table-hover datatable">
                  <thead>
                    <tr>
                      <th>S No.</th>
                      <th>Name</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($data['roles'] as $role)
                      <tr>
                        <td>{{ ++$loop->index }}</td>
                        <td>{{ $role->name }}</td>
                        <td>
                          @if($role->name != 'Super Admin')
                            <a href="{{ route('role.edit', $role->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-pen"></i></a>
                            <a class="btn btn-sm btn-danger btn-delete-role" data-url="{{ route('role.destroy', $role->id) }}"><i class="fa fa-trash"></i></a>
                          @endif
                        </td>
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
<script src="{{ url('/assets/js/role.js') }}"></script>
@endsection
