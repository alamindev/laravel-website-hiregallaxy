@extends('backend.layouts.master')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 float-left">All Sponsors</h1>
  <div class="breadcrumb-holder float-right">
    <ol class="breadcrumb float-right">
      <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
      <li class="breadcrumb-item active">Sponsors</li>
    </ol>
    <div class="clearfix"></div>
  </div>
</div>


<div class="main-body">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
    <div class="card mb-3">
      <div class="card-header py-3">
        <div class="float-left">
          <h6 class="m-0 font-weight-bold text-primary">All Sponsors</h6>
        </div>
        <div class="float-right">
          <a href="" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal"
            data-target="#addModal"><i class="fas fa-plus-circle fa-sm text-white-50"></i> Add New Sponsor</a>
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
                <th width="25%">Name</th>
                <th width="30%">URL</th>
                <th width="25%">Image</th>
                <th width="15%" class="sortoff">Manage</th>
              </tr>
            </thead>
            <tbody>
              @if(count($sponsors) > 0)
              @foreach($sponsors as $sponsor)
              <tr>
                <td>{{ $loop->index+1 }}</td>
                <td>{{ $sponsor->name }}</td>
                <td>{{ $sponsor->link }}</td>
                <td>
                  <a href="{!! asset('images/sponsors/'.$sponsor->image) !!}" target="_blank">
                    <img src="{!! asset('images/sponsors/'.$sponsor->image) !!}" alt="" width="50"
                      height="50">
                  </a>
                </td>
                <td>

                  <a href="#editModal{{ $sponsor->id }}" class="btn btn-circle btn-outline-success"
                    title="Edit Sponsor" data-toggle="modal"><i class="fa fa-edit"></i></a>


                  <button class="btn btn-circle btn-outline-danger" data-toggle="modal"
                    data-target="#deleteModal{{ $sponsor->id }}" title="Delete Sponsor"><i
                      class="fa fa-fw fa-trash"></i></button>

                  <!-- Delete Modal-->
                  <div class="modal fade" id="deleteModal{{ $sponsor->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Are you sure want to delete this sponsor ?
                          </h5>
                          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                          </button>
                        </div>
                        <div class="modal-body">Please confirm if you want to delete</div>
                        <div class="modal-footer">
                          <button class="btn btn-outline-secondary btn-sm" type="button"
                            data-dismiss="modal">Cancel</button>
                          <form class="" action="{{ route('admin.sponsor.delete', $sponsor->id) }}" method="post">
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

              <!-- Edit Modal -->
              <div class="modal" id="editModal{{ $sponsor->id }}">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                  <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                      <h4 class="modal-title">Edit Position</h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                      <form action="{!! route('admin.sponsor.update', $sponsor->id) !!}"  method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                          <div class="col-md-6 form-group">
                            <label for="name{{$sponsor->id}}">Sponsor Title <span class="text-danger required">*</span></label>
                            <input type="text" id="name{{$sponsor->id}}" name="name" class="form-control"
                              placeholder="eg. Lotto" required value="{{ $sponsor->name }}">
                          </div>
                          <div class="col-md-6 form-group">
                            <label for="link{{$sponsor->id}}">Sponsor Link <span class="text-danger required">*</span></label>
                            <input type="url" id="link{{$sponsor->id}}" name="link" class="form-control"
                              placeholder="eg. Lotto" required value="{{ $sponsor->link }}">
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="col-md-6 form-group">
                            <label for="image">
                              Sponsor Logo (Size: 200*200)
                              @if ($sponsor->image != NULL)
                              <a href="{!! asset('images/sponsors/'.$sponsor->image) !!}">Previous Image</a>
                              @endif
                            </label>
                            <input type="file" id="image" name="image" class="form-control">
                          </div>
                        </div>

                        <button type="button" class="btn btn-danger float-right mt-1 ml-2 " data-dismiss="modal"><i
                            class="fa fa-times"></i> Cancel</button>

                        <button type="submit" class="btn btn-success float-right mt-1 ">
                          <i class="fa fa-check"></i> Update
                        </button>

                      </form>
                    </div>

                  </div>
                </div>
              </div>
              <!-- Edit Modal -->

              @endforeach
              @endif
            </tbody>
          </table>
        </div>
      </div><!-- end card-->
    </div>
  </div>
</div>


<!-- Add Modal -->
<div class="modal" id="addModal">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add New Sponsor</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form action="{!! route('admin.sponsor.submit') !!}" data-parsley-validate method="post" enctype="multipart/form-data">
          @csrf
          <div class="form-row">
            <div class="col-md-6 form-group">
              <label for="name">Sponsor Title <span class="text-danger required">*</span></label>
              <input type="text" id="name" name="name" class="form-control" placeholder="eg. Lotto" required>
            </div>
            <div class="col-md-6 form-group">
              <label for="link">Sponsor URL <span class="text-danger required">*</span></label>
              <input type="url" id="link" name="link" class="form-control" placeholder="eg. https://www.lotto.it" required>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 form-group">
              <label for="image">Sponsor Logo  (Size: 200*200)</label>
              <input type="file" id="image" name="image" class="form-control"  required="required">
            </div>
          </div>

          <button type="button" class="btn btn-danger float-right mt-1 ml-2 " data-dismiss="modal"><i
              class="fa fa-times"></i> Cancel</button>

          <button type="submit" class="btn btn-success float-right mt-1 ">
            <i class="fa fa-check"></i> Add
          </button>

        </form>
      </div>

    </div>
  </div>
</div>

@endsection
