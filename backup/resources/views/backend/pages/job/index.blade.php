@extends('backend.layouts.master')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 float-left">Jobs</h1>
  <div class="breadcrumb-holder float-right">
    <ol class="breadcrumb float-right">
      <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
      <li class="breadcrumb-item active">Jobs</li>
    </ol>
    <div class="clearfix"></div>
  </div>
</div>


<div class="main-body">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
    <div class="card mb-3">
      <div class="card-header py-3">
        <div class="float-left">
          <h6 class="m-0 font-weight-bold text-primary">All Jobs</h6>
        </div>
        <div class="float-right">
         @if (Route::is('admin.job.index'))
            <a href="{{ route('admin.job.trash') }}" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"><i class="fas fa-trash fa-sm text-white-50"></i> Trash List</a>
          @elseif(Route::is('admin.job.trash'))
            <a href="{{ route('admin.job.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fas fa-check fa-sm text-white-50"></i> Active List</a>
         @endif
{{--
          <a href="" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#addModal"><i class="fas fa-plus-circle fa-sm text-white-50"></i> Add New job</a> --}}
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="card-body">
        @include('backend.partials.message')

        <div class="table-responsive">
          <table id="dataTable" width="100%" cellspacing="0" class="table table-bordered">
            <thead>
              <tr>
                <th width="5%">Sl</th>
                <th width="20%">Title</th>
                <th width="20%">Employer</th>
                <th width="15%" class="sortoff">Manage</th>
              </tr>
            </thead>
            <tbody>
              @if(count($jobs) > 0)
              @foreach($jobs as $job)
              <tr>
                <td>{{ $loop->index+1 }}</td>
                <td>
                  {{ $job->title }}
                  <br>
                  <a href="{{ route('jobs.show', $job->slug) }}" target="_blank"><i class="fa fa-link"></i> {{ route('jobs.show', $job->slug) }}</a>
                </td>
                <td>
                  <a href="{{ route('employers.show', $job->user->username) }}" target="_blank">{{ $job->user->name }}</a>
                </td>
                <td>
                  {{-- @if ($job->is_confirmed == 1)
                    <a href="#editModal{{ $job->id }}" class="btn btn-circle btn-outline-success" title="Edit job" data-toggle="modal" ><i class="fa fa-edit"></i></a>
                  @endif --}}

                  @if ($job->is_confirmed == 0)
                    <a href="#activeModal{{ $job->id }}" class="btn btn-circle btn-outline-success" title="Active job" data-toggle="modal" ><i class="fa fa-check"></i></a>
                  @else
                  <button class="btn btn-circle btn-outline-danger" data-toggle="modal" data-target="#deleteModal{{ $job->id }}" title="Delete job"><i class="fa fa-fw fa-trash"></i></button>
                  @endif


                  <!-- Delete Modal-->
                  <div class="modal fade" id="deleteModal{{ $job->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Are you sure want to delete this job ?</h5>
                          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                          </button>
                        </div>
                        <div class="modal-body">Please confirm if you want to delete</div>
                        <div class="modal-footer">
                          <button class="btn btn-outline-secondary btn-sm" type="button" data-dismiss="modal">Cancel</button>
                          <form class="" action="{{ route('admin.job.delete', $job->id) }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i> Confirm</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Activate Modal -->
                  <div class="modal fade" id="activeModal{{ $job->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Are you sure want to activate this job ?</h5>
                          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                          </button>
                        </div>
                        <div class="modal-body">Please confirm if you want to activate</div>
                        <div class="modal-footer">
                          <button class="btn btn-outline-secondary btn-sm" type="button" data-dismiss="modal">Cancel</button>
                          <form class="" action="{{ route('admin.job.active', $job->id) }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i> Confirm</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>

                </td>
              </tr>

              @endforeach
              @endif
            </tbody>
          </table>
        </div>
      </div><!-- end card-->
    </div>
  </div>
</div>

@endsection
