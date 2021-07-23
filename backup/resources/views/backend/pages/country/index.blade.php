@extends('backend.layouts.master')



@section('content')



<div class="d-sm-flex align-items-center justify-content-between mb-4">

  <h1 class="h3 mb-0 float-left">All Country List</h1>

  <div class="breadcrumb-holder float-right">

    <ol class="breadcrumb float-right">

      <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>

      <li class="breadcrumb-item active">All Country List</li>

    </ol>

    <div class="clearfix"></div>

  </div>

</div>





<div class="main-body">

  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

    <div class="card mb-3">

      <div class="card-header py-3">

        <div class="float-left">

          <h6 class="m-0 font-weight-bold text-primary">All Countries</h6>

        </div>

        <div class="float-right">

          <a href="" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal"

            data-target="#addModal"><i class="fas fa-plus-circle fa-sm text-white-50"></i> Add New Country</a>

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

                <th width="30%">Country Name</th>

                <th width="15%" class="sortoff">Manage</th>

              </tr>

            </thead>

            <tbody>

              @if(count($countries) > 0)

              @foreach($countries as $country)

              <tr>

                <td>{{ $loop->index+1 }}</td>

                <td>

                  {{ $country->name }}

                </td>


                <td>

                  <a href="#editModal{{ $country->id }}" class="btn btn-circle btn-outline-success" title="Edit country"

                    data-toggle="modal"><i class="fa fa-edit"></i></a>



                  <button class="btn btn-circle btn-outline-danger" data-toggle="modal"

                    data-target="#deleteModal{{ $country->id }}" title="Delete country"><i

                      class="fa fa-fw fa-trash"></i></button>



                  <!-- Delete Modal-->

                  <div class="modal fade" id="deleteModal{{ $country->id }}" tabindex="-1" role="dialog"

                    aria-labelledby="exampleModalLabel" aria-hidden="true">

                    <div class="modal-dialog" role="document">

                      <div class="modal-content">

                        <div class="modal-header">

                          <h5 class="modal-title" id="exampleModalLabel">Are you sure want to delete this country ?</h5>

                          <button class="close" type="button" data-dismiss="modal" aria-label="Close">

                            <span aria-hidden="true">×</span>

                          </button>

                        </div>

                        <div class="modal-body">Please confirm if you want to delete</div>

                        <div class="modal-footer">

                          <button class="btn btn-outline-secondary btn-sm" type="button"

                            data-dismiss="modal">Cancel</button>

                          <form class="" action="{{ route('admin.country.destroy', $country->id) }}" method="post">

                            @method('delete')

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

              <div class="modal" id="editModal{{ $country->id }}">

                <div class="modal-dialog modal-dialog-centered">

                  <div class="modal-content">



                    <!-- Modal Header -->

                    <div class="modal-header">

                      <h4 class="modal-title">Edit Country</h4>

                      <button type="button" class="close" data-dismiss="modal">&times;</button>

                    </div>



                    <!-- Modal body -->

                    <div class="modal-body">

                      <form action="{!! route('admin.country.update', $country->id) !!}" method="post"

                        enctype="multipart/form-data">

                        @method('put')

                        @csrf

                        <div class="form-row">

                          <div class="col-md-12 form-group">

                            <label for="name{{$country->id}}">Country Name <span class="text-danger required">*</span></label>

                            <input type="text" minlength="3" id="name{{$country->id}}" name="name" class="form-control" placeholder="eg. Country Name"

                              required value="{{ $country->name }}">

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

  <div class="modal-dialog modal-dialog-centered">

    <div class="modal-content">



      <!-- Modal Header -->

      <div class="modal-header">

        <h4 class="modal-title">Add New Country</h4>

        <button type="button" class="close" data-dismiss="modal">&times;</button>

      </div>



      <!-- Modal body -->

      <div class="modal-body">

        <form action="{!! route('admin.country.store') !!}" method="post" data-parsley-validate enctype="multipart/form-data">

          @csrf

          <div class="form-row">

            <div class="col-md-12 form-group">

              <label for="name">Country Name <span class="text-danger required">*</span></label>

              <input type="text" id="name" minlength="3" name="name" class="form-control" placeholder="country name" required>

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



