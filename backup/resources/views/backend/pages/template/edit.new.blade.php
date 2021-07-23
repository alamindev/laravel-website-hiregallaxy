@extends('backend.layouts.master')

@section('stylesheets')
<style>
  textarea {
    border: none;
  }

  .cke_editable {
    padding: 5px;
    border: 0px !important;
    border-bottom: 1px solid #dfdfdf !important;
    margin-top: 0px;
  }
</style>
@endsection

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 float-left">Edit Job Template</h1>
  <div class="breadcrumb-holder float-right">
    <ol class="breadcrumb float-right">
      <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
      <li class="breadcrumb-item active"> Edit Job Template</li>
    </ol>
    <div class="clearfix"></div>
  </div>
</div>


<div class="main-body">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
    <div class="card mb-3">
      <div class="card-header py-3">
        <div class="float-left">
          <h6 class="m-0 font-weight-bold text-primary">
            Edit Job Template
          </h6>
        </div>
        <div class="float-right">
          <a href="{{ route('admin.templates.index') }}"
            class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
              class="fas fa-arrow-left fa-sm text-white-50"></i> All Job templates</a>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="card-body">
        @include('backend.partials.message')
        <form action="{!! route('admin.templates.update', $template->id) !!}" method="post">
          @method('PUT')
          @csrf
          <div class="form-row">
            <div class="col-md-6 form-group">
              <div class="row">
                <div class="col-md-12">
                  <input type="text" id="name" name="name" class="form-control" placeholder="eg. New Template Name"
                    required value="{{ $template->name }}">
                </div>
              </div>
            </div>
            <div class="col-md-6 form-group">
              <div class="row">
                <div class="col-md-12">
                  <select name="category_id" id="category_id" class="form-control" required>
                    <option value="">Select a category</option>
                    @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}"
                      {{ isset($template->category)? ($template->category->id == $cat->id) ? 'selected' : '' : '' }}>
                      {{ $cat->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
          </div>

          <div class="form-row">
            <div class="col-md-12 form-group">
              <div class="row">
                <div class="col-md-12">
                  <strong>Job Summary</strong>
                  <textarea name="job_summery" id="job_summery" rows="3" class="form-control"
                    placeholder="Job Summary">{!! $template->job_summery !!}</textarea>

                </div>
              </div>
            </div>
            <div class="col-md-12 form-group">
              <div class="row">
                <div class="col-md-12">
                  <strong>Responsibilities & Duties</strong>
                  <textarea name="responsibilities" id="responsibilities" name="responsibilities" rows="3"
                    class="template form-control">{!! $template->responsibilities !!}</textarea>
                </div>
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-12 form-group">
              <div class="row">
                <div class="col-md-12">
                  <strong>Qualification</strong>
                  <textarea name="qualification" id="qualification" name="qualification" rows="3"
                    class="template form-control">{!! $template->qualification !!}</textarea>
                </div>
              </div>
            </div>
            <div class="col-md-12 form-group">
              <div class="row">
                <div class="col-md-12">
                  <strong>Certification</strong>
                  <textarea name="certification" id="certification" name="certification" rows="3"
                    class="template form-control">{!! $template->certification !!}</textarea>
                </div>
              </div>
            </div>
          </div>

          <div class="form-row">
            <div class="col-md-12 form-group">
              <div class="row">
                <div class="col-md-12">
                  <strong>Experience</strong>
                  <textarea name="experience" id="experience" name="experience" rows="3"
                    class="template form-control">{!! $template->experience !!}</textarea>
                </div>
              </div>
            </div>
            <div class="col-md-12 form-group" style="margin-bottom: -9px;">
              <div class="row">
                <div class="col-md-12">
                  <strong>About Company</strong>
                  <textarea name="about_company" id="about_company" name="about_company" rows="3"
                    class="template form-control">{!! $template->about_company !!}</textarea>
                </div>
              </div>
            </div>
          </div>


          <div class="mt-3">
            <button type="button" class="btn btn-danger float-right mt-1 ml-2 " data-dismiss="modal"><i
                class="fa fa-times"></i> Cancel</button>

            <button type="submit" class="btn btn-success float-right mt-1 ">
              <i class="fa fa-check"></i> Save Template
            </button>

          </div>
        </form>
      </div><!-- end card-->
    </div>
  </div>
</div>

@endsection

@section('scripts')
{{--  @include('backend.pages.template.partials.scripts');  --}}

@include('backend.pages.template.partials.post-job-script');
@endsection