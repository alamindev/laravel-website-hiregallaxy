@extends('backend.layouts.master')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 float-left">All Subscribers</h1>
  <div class="breadcrumb-holder float-right">
    <ol class="breadcrumb float-right">
      <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
      <li class="breadcrumb-item active">Subscribers</li>
    </ol>
    <div class="clearfix"></div>
  </div>
</div>


<div class="main-body">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
    <div class="card mb-3">
      <div class="card-header py-3">
        <div class="float-left">
          <h6 class="m-0 font-weight-bold text-primary">All Subscribers</h6>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="card-body">
        @include('backend.partials.message')

        <div class="table-responsive">
          <table id="dataTable" width="100%" cellspacing="0" class="table table-bordered">
            <thead>
              <tr>
                <th width="10%">Sl</th>
                <th width="35%">Email</th>
                <th width="35%">Joining Date</th>
                <th width="20%" class="sortoff">Manage</th>
              </tr>
            </thead>
            <tbody>
              @if(count($subscribers) > 0)
              @foreach($subscribers as $subscriber)
              <tr>
                <td>{{ $loop->index+1 }}</td>
                <td>{{ $subscriber->email }}</td>
                <td>{{ date('F j, Y',strtotime($subscriber->created_at)) }}</td>
                <td>
                  <button class="btn btn-circle btn-outline-danger" data-toggle="modal"
                    data-target="#deleteModal{{ $subscriber->id }}" title="Delete Subscriber"><i
                      class="fa fa-fw fa-trash"></i></button>

                  <!-- Delete Modal-->
                  <div class="modal fade" id="deleteModal{{ $subscriber->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Are you sure want to delete this Subscriber ?
                          </h5>
                          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                          </button>
                        </div>
                        <div class="modal-body">Please confirm if you want to delete</div>
                        <div class="modal-footer">
                          <button class="btn btn-outline-secondary btn-sm" type="button"
                            data-dismiss="modal">Cancel</button>
                          <form class="" action="{{ route('admin.subscriber.delete', $subscriber->id) }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i>
                              Confirm</button>
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
