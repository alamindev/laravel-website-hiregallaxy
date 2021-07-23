@extends('backend.layouts.master')



@section('content')



<div class="d-sm-flex align-items-center justify-content-between mb-4">

  <h1 class="h3 mb-0 float-left">Contacts</h1>

  <div class="breadcrumb-holder float-right">

    <ol class="breadcrumb float-right">

      <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>

      <li class="breadcrumb-item active">Contacts</li>

    </ol>

    <div class="clearfix"></div>

  </div>

</div>





<div class="main-body">

  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

    <div class="card mb-3">

      <div class="card-header py-3">

        <div class="float-left">

          <h6 class="m-0 font-weight-bold text-primary">All Contacts Messages</h6>

        </div>

        <div class="clearfix"></div>

      </div>

      <div class="card-body">

        @include('backend.partials.message')



        <div class="table-responsive">

          <table id="dataTable" width="100%" cellspacing="0" class="table table-bordered">

            <thead>

              <tr>

                <th>Sl</th>
                <th>Name</th>
                <th>Email</th>
                <th>Subject</th>
                <th style="width: 200px">Date</th>
                <th class="sortoff">Manage</th>

              </tr>

            </thead>

            <tbody>

              @foreach($contacts as $key=>$contact)

                  <tr>

                    <td>{{$key+1}}</td>

                    <td> {!! $contact->name !!}</td>
                    <td> {!! $contact->email !!}</td>
                    <td> {!! $contact->subject !!}</td>
                    <td> {!! Carbon\Carbon::parse($contact->created_at)->format('d-m-Y') !!}</td>


                    <td>

                        <a href="{{route('admin.contact.view', $contact->id)}}" title="View contact messages" class="btn btn-outline-success">

                          <i class="fa fa-eye"></i>

                        </a>


                        <a href="{{route('admin.contact.destroy',$contact->id)}}" title="Destroy contact message" class="btn btn-outline-danger" onclick="return confirm('Are you sure!')">

                          <i class="fa fa fa-fw fa-trash"></i>

                        </a>

                    </td>

                  </tr>

                @endforeach

            </tbody>

          </table>

        </div>

      </div><!-- end card-->

    </div>

  </div>

</div>





@endsection

