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
                <div class="card-title"><i class="fa fa-users"></i> {{ $data['page_title'] }}</div>
                <div class="card-tools">
                  <a href="{{ route('user.create') }}" class="btn btn-sm btn-info"> <i class="fa fa-plus"></i> Create User</a>
                  <a href="{{ route('user.trash') }}" class="btn btn-sm btn-primary"> <i class="fa fa-eye"></i> View Trash</a>
                </div>
              </div>
              <div class="card-body">
                <table id="user-table" class="table table-bordered table-hover datatable">
                  <thead>
                    <tr>
                      <th>S No.</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($data['users'] as $user)
                      <tr>
                        <td>{{ ++$loop->index }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                          @if(!$user->hasRole('Super Admin'))
                            @if($user->is_active)
                              <button data-url="{{ route('user.update.status', $user->id) }}" class="btn btn-sm btn-success btn-update-status">Active</button>
                            @else
                              <button data-url="{{ route('user.update.status', $user->id) }}" class="btn btn-sm btn-danger btn-update-status">Deactive</button>
                            @endif
                          @endif
                        </td>
                        <td>
                          @if(!$user->hasRole('Super Admin'))
                            <a href="{{ route('user.edit', $user->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Edit</a>
                            <button class="btn btn-sm btn-danger btn-destroy-user" data-url="{{ route('user.destroy', $user->id) }}"><i class="fa fa-trash"></i> Delete</button>
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
<script src="{{ url('/assets/js/user.js') }}"></script>
@endsection
