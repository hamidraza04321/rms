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
                  <a href="{{ route('group.create') }}" class="btn btn-sm btn-info"> <i class="fa fa-plus"></i> Create Group</a>
                  <a href="{{ route('group.trash') }}" class="btn btn-sm btn-primary"> <i class="fa fa-eye"></i> View Trash</a>
                </div>
              </div>
              <div class="card-body">
                <table id="group-table" class="table table-bordered table-hover datatable">
                  <thead>
                    <tr>
                      <th>S No.</th>
                      <th>Name</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($data['groups'] as $group)
                      <tr>
                        <td>{{ ++$loop->index }}</td>
                        <td>{{ $group->name }}</td>
                        <td>
                          @if($group->is_active)
                            <button data-url="{{ route('group.update.status', $group->id) }}" class="btn btn-sm btn-success btn-update-status">Active</button>
                          @else
                            <button data-url="{{ route('group.update.status', $group->id) }}" class="btn btn-sm btn-danger btn-update-status">Deactive</button>
                          @endif
                        </td>
                        <td>
                          <a href="{{ route('group.edit', $group->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Edit</a>
                          <button class="btn btn-sm btn-danger btn-destroy-group" data-url="{{ route('group.destroy', $group->id) }}"><i class="fa fa-trash"></i> Delete</button>
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
<script src="{{ url('/assets/js/group.js') }}"></script>
@endsection
