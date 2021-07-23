@extends('backend.layouts.master')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 float-left">Personality Questions</h1>
  <div class="breadcrumb-holder float-right">
    <ol class="breadcrumb float-right">
      <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
      <li class="breadcrumb-item active">Personality Questions</li>
    </ol>
    <div class="clearfix"></div>
  </div>
</div>


<div class="main-body">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
    <div class="card mb-3">
      <div class="card-header py-3">
        <div class="float-left">
          <h6 class="m-0 font-weight-bold text-primary">Single Personality Questions</h6>
        </div>
        <div class="float-right">

          <a href="{{ route('admin.personality.question.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-angle-left fa-sm text-white-50"></i> Back</a>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="dataTable" width="100%" cellspacing="0" class="table table-bordered">
            <tr>
                <td>Quetion</td>
                <td>:</td>
                <td>{!!$question->question!!}</td>
            </tr>
            <tr>
                <td>Answer One</td>
                <td>:</td>
                <td>{!!$question->answer_1!!}</td>
            </tr>
            <tr>
                <td>Answer Two</td>
                <td>:</td>
                <td>{!!$question->answer_2!!}</td>
            </tr>
          </table>
        </div>
      </div><!-- end card-->
    </div>
  </div>
</div>


@endsection
