@extends('backend.layouts.master')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 float-left">Personality type</h1>
  <div class="breadcrumb-holder float-right">
    <ol class="breadcrumb float-right">
      <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
      <li class="breadcrumb-item active">Personality Type</li>
    </ol>
    <div class="clearfix"></div>
  </div>
</div>


<div class="main-body">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
    <div class="card mb-3">
      <div class="card-header py-3">
        <div class="float-left">
          <h6 class="m-0 font-weight-bold text-primary">Single Personality</h6>
        </div>
        <div class="float-right">

          <a href="{{ route('admin.personality.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-angle-left fa-sm text-white-50"></i> Back</a>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="dataTable" width="100%" cellspacing="0" class="table table-bordered">
            <tr>
                <td>Personality Title</td>
                <td>:</td>
                <td>{{$personality->title}}</td>
            </tr>
            <tr>
                <td>Personality Sub Title</td>
                <td>:</td>
                <td>{{$personality->sub_title}}</td>
            </tr>
            <tr>
                <td>Personality Description</td>
                <td>:</td>
                <td>{{$personality->description}}</td>
            </tr>
            <tr>
                <td>Personality Strengths</td>
                <td>:</td>
                <td>{!! $personality->strengths !!}</td>
            </tr>
            <tr>
                <td>Personality Weaknesses</td>
                <td>:</td>
                <td>{!! $personality->weaknesses !!}</td>
            </tr>

          </table>
        </div>
      </div><!-- end card-->
    </div>
  </div>
</div>


@endsection
