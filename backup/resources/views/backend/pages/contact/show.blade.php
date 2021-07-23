@extends('backend.layouts.master')

@section('stylesheets')
 

@endsection

@section('content')



<div class="d-sm-flex align-items-center justify-content-between mb-4">

  <h1 class="h3 mb-0 float-left">contact message</h1>

  <div class="breadcrumb-holder float-right">

    <ol class="breadcrumb float-right">

      <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>

      <li class="breadcrumb-item active">Contact message</li>

    </ol>

    <div class="clearfix"></div>

  </div>

</div>





<div class="main-body">

  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

    <div class="card mb-3">

      <div class="card-header py-3">

        <div class="float-left">

          <h6 class="m-0 font-weight-bold text-primary">Single contact Message showing</h6>

        </div>

        <div class="float-right">



          <a href="{{ route('admin.contact.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-angle-left fa-sm text-white-50"></i> Back</a>

        </div>

        <div class="clearfix"></div>

      </div>

      <div class="card-body">

        <div class="table-responsive">

          <table width="100%" cellspacing="0" class="table table-bordered">

            <tr>

                <td>Name</td>

                <td>:</td>

                <td>{!! $contact->name !!}</td>

            </tr>
            <tr>

                <td>Email</td>

                <td>:</td>

                <td>{!! $contact->email !!}</td>

            </tr>
            <tr>

                <td>Subject</td>

                <td>:</td>

                <td>{!! $contact->subject !!}</td>

            </tr>
            <tr>

                <td>Message</td>

                <td>:</td>

                <td>{!! $contact->message !!}</td>

            </tr> 

          </table>

        </div>

      </div><!-- end card-->

    </div>

  </div>

</div>





@endsection

