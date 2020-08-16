@extends('backend.layouts.master')
@section('stylesheets')
<style>
#dataTable img {

width: 150px !important;
height: 150px !important;

}
</style>
@endsection
@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
<h1 class="h3 mb-0 float-left">Admin, {{ $view->username}} info</h1>
  <div class="breadcrumb-holder float-right">
    <ol class="breadcrumb float-right">
      <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
      <li class="breadcrumb-item active">Admin</li>
    </ol>
    <div class="clearfix"></div>
  </div>
</div>


<div class="main-body">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
    <div class="card mb-3">
      <div class="card-header py-3">
        <div class="float-left">
          <h6 class="m-0 font-weight-bold text-primary">Admin, {{ $view->username}} info</h6>
        </div>
        <div class="float-right">

          <a href="{{ route('admin.account.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-angle-left fa-sm text-white-50"></i> Back</a>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="dataTable" width="100%" cellspacing="0" class="table table-bordered">
            <tr>
                <td>First Name</td>
                <td>:</td>
                <td>{!! $view->first_name !!}</td>
            </tr>
            <tr>
                <td>Last Name</td>
                <td>:</td>
                <td>{!! $view->last_name !!}</td>
            </tr>
            <tr>
                <td>Username</td>
                <td>:</td>
                <td>{!! $view->username !!}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>:</td>
                <td>{!! $view->email !!}</td>
            </tr>
            <tr>
                <td>Phone Number</td>
                <td>:</td>
                <td>{!! $view->phone_no !!}</td>
            </tr>
            <tr>
                <td>Address</td>
                <td>:</td>
                <td>{!! $view->address !!}</td>
            </tr>
            <tr>
                <td>Role</td>
                <td>:</td>
                <td>     @foreach($view->role as $role) 
                  {{$role->name}}
           @endforeach </td>
            </tr>
            
          </table>
        </div>
      </div><!-- end card-->
    </div>
  </div>
</div>


@endsection
