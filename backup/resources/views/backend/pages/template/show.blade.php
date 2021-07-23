@extends('backend.layouts.master')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 float-left">View Job Template</h1>
  <div class="breadcrumb-holder float-right">
    <ol class="breadcrumb float-right">
      <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
      <li class="breadcrumb-item active">View Job Template</li>
    </ol>
    <div class="clearfix"></div>
  </div>
</div>


<div class="main-body">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
    <div class="card mb-3">
      <div class="card-header py-3">
        <div class="float-left">
          <h6 class="m-0 font-weight-bold text-primary">View Job Template - <strong>{{ $template->name }}</strong> </h6>
        </div>
        <div class="float-right">
          <a class="btn btn-success float-right mt-1 btn-sm " href="{{ route('admin.templates.edit', $template->id) }}">
            <i class="fa fa-edit"></i> Edit Template
          </a>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="card-body">
        @include('backend.partials.message')
        <div class="form-row">
          <div class="col-md-6 form-group">
            <div class="row">
              <div class="col-md-5">
                <label for="name">Position <span class="text-danger required">*</span></label>
              </div>
              <div class="col-md-7">
                <div class="border p-1">
                  {{ isset($template->category) ? $template->category->name : '' }}
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-12 form-group">
            <div class="row">
              <div class="col-md-3">
                <label for="name">Discipline <span class="text-danger required">*</span></label>
              </div>
              <div class="col-md-9">
                <div class="border p-1">
                  {{ isset($template->discipline) ? $template->discipline->name : '' }}
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-12 form-group">
            <div class="row">
              <div class="col-md-12">
                <strong>Job Summary</strong>
                <div class="border p-3">
                  {!! $template->job_summery !!}
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12 form-group">
            <div class="row">
              <div class="col-md-12">
                <strong>Responsibilities & Duties</strong>
                <div class="border p-3">
                  {!! $template->responsibilities !!}
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="form-row">
          <div class="col-md-12 form-group">
            <div class="row">
              <div class="col-md-12">
                <strong>Qualification</strong>
                <div class="border p-3">
                  {!! $template->qualification !!}
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12 form-group">
            <div class="row">
              <div class="col-md-12">
                <strong>Certification</strong>
                <div class="border p-3">
                  {!! $template->certification !!}
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-12 form-group">
            <div class="row">
              <div class="col-md-12">
                <strong>Experience</strong>
                <div class="border p-3">
                  {!! $template->experience !!}
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12 form-group">
            <div class="row">
              {{--  <div class="col-md-3">
                <label for="about_company">About Company</label>
              </div>  --}}
              <div class="col-md-12">
                <strong>About Company</strong>
                <div class="border p-3">
                  {!! $template->about_company !!}
                </div>
              </div>
            </div>
          </div>
        </div>



      </div><!-- end card-->
    </div>
  </div>
</div>

@endsection

@section('scripts')
@include('backend.pages.template.partials.scripts');
@endsection
