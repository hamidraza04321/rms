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
                <div class="card-title"><i class="fa fa-book"></i> {{ $data['page_title'] }}</div>
                <div class="card-tools">
                  @can('create-subject')
                    <a href="{{ route('subject.create') }}" class="btn btn-sm btn-info"> <i class="fa fa-plus"></i> Create Subject</a>
                  @endcan
                  @can('view-subject-trash')
                    <a href="{{ route('subject.trash') }}" class="btn btn-sm btn-primary"> <i class="fa fa-eye"></i> View Trash</a>
                  @endcan
                </div>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table id="subject-table" class="table table-bordered table-hover datatable">
                    <thead>
                      <tr>
                        <th>S No.</th>
                        <th>Name</th>
                        @can('update-subject-status')
                          <th>Status</th>
                        @endcan
                        @canany(['edit-subject', 'delete-subject'])
                          <th>Action</th>
                        @endcanany
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($data['subjects'] as $subject)
                        <tr>
                          <td>{{ ++$loop->index }}</td>
                          <td>{{ $subject->name }}</td>
                          @can('update-subject-status')
                            <td>
                              @if($subject->is_active)
                                <button data-url="{{ route('subject.update.status', $subject->id) }}" class="btn btn-sm btn-success btn-update-status">Active</button>
                              @else
                                <button data-url="{{ route('subject.update.status', $subject->id) }}" class="btn btn-sm btn-danger btn-update-status">Deactive</button>
                              @endif
                            </td>
                          @endcan
                          @canany(['edit-subject', 'delete-subject'])
                            <td>
                              @can('edit-subject')
                                <a href="{{ route('subject.edit', $subject->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Edit</a>
                              @endcan
                              @can('delete-subject')
                                <button class="btn btn-sm btn-danger btn-destroy-subject" data-url="{{ route('subject.destroy', $subject->id) }}"><i class="fa fa-trash"></i> Delete</button>
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
<script src="{{ url('/assets/js/subject.js') }}"></script>
@endsection
