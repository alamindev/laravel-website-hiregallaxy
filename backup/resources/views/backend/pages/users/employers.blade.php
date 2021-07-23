@extends('backend.layouts.master')



@section('content')



<div class="d-sm-flex align-items-center justify-content-between mb-4">

  <h1 class="h3 mb-0 float-left">Manage Employers</h1>

  <div class="breadcrumb-holder float-right">

    <ol class="breadcrumb float-right">

      <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>

      <li class="breadcrumb-item active">Employers</li>

    </ol>

    <div class="clearfix"></div>

  </div>

</div>





<div class="main-body">

  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

    <div class="card mb-3">

      <div class="card-header py-3">

        <div class="float-left">

          <h6 class="m-0 font-weight-bold text-primary">All Employers</h6>

        </div>

      </div>

      <div class="card-body">

        {{-- @include('backend.partials.messsages') --}}



        <div class="table-responsive">

          <table id="dataTable" width="100%" cellspacing="0" class="table table-bordered">

            <thead>

              <tr>

                <th width="5%">Sl</th>

                <th width="30%">Name</th>

                <th width="10%" class="sortoff">Image</th>

                <th width="20%">Email</th>

                <th width="15%">Status</th>

                <th width="15%" class="sortoff">Manage</th>

              </tr>

            </thead>

            <tbody>

              @if(count($users) > 0)

              @foreach($users as $user)

              <tr>

                <td>{{ $loop->index+1 }}</td>

                <td>

                  {{ $user->name }}

                  <br>

                  <a href="{{ route('employers.show', $user->username) }}" target="_blank"><i class="fa fa-link"></i> {{ route('employers.show', $user->username) }}</a>

                </td>

                <td>

                  <a href="{!! asset('public/images/users/'.$user->image) !!}" target="_blank">

                    <img src="{!! asset('public/images/users/'.$user->image) !!}" alt="image" width="50" height="50">

                  </a>

                </td>

                <td>

                  <a href="mailto:{!! $user->email !!}">{!! $user->email !!}</a>

                  <br>

                  <a href="tel:{!! $user->phone_no !!}">{!! $user->phone_no !!}</a>

                </td>

                <td>

                  @if ($user->status == 0)

                    <span class="badge badge-info">

                      <i class="fa fa-times"></i> Not verified

                    </span>

                  @elseif($user->status == 1)

                    <span class="badge badge-success">

                      <i class="fa fa-check"></i> Active

                    </span>

                  @elseif($user->status == 2)

                    <span class="badge badge-danger">

                      <i class="fa fa-bann"></i> Banned

                    </span>

                  @elseif($user->status == 3)

                    <span class="badge badge-danger">

                      <i class="fa fa-times"></i> Deleted

                    </span>

                  @endif

                </td>

                <td>

                  @if ($user->status == 2 || $user->status == 0)

                     <button class="btn btn-circle btn-outline-success" data-toggle="modal" data-target="#deleteModal{{ $user->id }}" title="Active Employer"><i class="fa fa-fw fa-check"></i></button>

                  @endif

                 @if ($user->status == 1)

                     <button class="btn btn-circle btn-outline-danger" data-toggle="modal" data-target="#deleteModal{{ $user->id }}" title="Ban Employer"><i class="fa fa-fw fa-ban"></i></button>

                  @endif



                  <!-- Delete Modal-->

                  <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

                    <div class="modal-dialog" role="document">

                      <div class="modal-content">

                        <div class="modal-header">

                          <h5 class="modal-title" id="exampleModalLabel">Are you sure want to {{ ($user->status == 2 || $user->status == 0) ? 'active' : 'ban' }} this Employer ?</h5>

                          <button class="close" type="button" data-dismiss="modal" aria-label="Close">

                            <span aria-hidden="true">×</span>

                          </button>

                        </div>

                        <div class="modal-body">Please confirm if you want to {{ ($user->status == 2 || $user->status == 0) ? 'active' : 'ban' }} the Employer</div>



                        <div class="modal-footer">

                          <button class="btn btn-outline-secondary btn-sm" type="button" data-dismiss="modal">Cancel</button>

                          <form class="" action="{{ route('admin.users.change_status', $user->id) }}" method="post">

                            @csrf

                            <button type="submit" class="btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i> Confirm</button>

                          </form>

                        </div>

                      </div>

                    </div>

                  </div>

                  <!-- End Delete Modal-->



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

