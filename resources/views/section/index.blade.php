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
                <div class="card-title"><i class="fa fa-puzzle-piece"></i> {{ $data['page_title'] }}</div>
                <div class="card-tools">
                  @can('create-section')
                    <a href="{{ route('section.create') }}" class="btn btn-sm btn-info"> <i class="fa fa-plus"></i> Create Section</a>
                  @endcan
                  @can('view-section-trash')
                    <a href="{{ route('section.trash') }}" class="btn btn-sm btn-primary"> <i class="fa fa-eye"></i> View Trash</a>
                  @endcan
                </div>
              </div>
              <div class="card-body">
                <table id="section-table" class="table table-bordered table-hover datatable">
                  <thead>
                    <tr>
                      <th>S No.</th>
                      <th>Name</th>
                      @can('update-section-status')
                        <th>Status</th>
                      @endcan
                      @canany(['edit-section', 'delete-section'])
                        <th>Action</th>
                      @endcanany
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($data['sections'] as $section)
                      <tr>
                        <td>{{ ++$loop->index }}</td>
                        <td>{{ $section->name }}</td>
                        @can('update-section-status')
                          <td>
                            @if($section->is_active)
                              <button data-url="{{ route('section.update.status', $section->id) }}" class="btn btn-sm btn-success btn-update-status">Active</button>
                            @else
                              <button data-url="{{ route('section.update.status', $section->id) }}" class="btn btn-sm btn-danger btn-update-status">Deactive</button>
                            @endif
                          </td>
                        @endcan
                        @canany(['edit-section', 'delete-section'])
                          <td>
                            @can('edit-section')
                              <a href="{{ route('section.edit', $section->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Edit</a>
                            @endcan
                            @can('delete-section')
                              <button class="btn btn-sm btn-danger btn-destroy-section" data-url="{{ route('section.destroy', $section->id) }}"><i class="fa fa-trash"></i> Delete</button>
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
<script src="{{ url('/assets/js/section.js') }}"></script>
@endsection
