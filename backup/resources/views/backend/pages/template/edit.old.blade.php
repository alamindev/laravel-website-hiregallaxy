@extends('backend.layouts.master')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 float-left">Edit Job Template</h1>
  <div class="breadcrumb-holder float-right">
    <ol class="breadcrumb float-right">
      <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
      <li class="breadcrumb-item active">Edit Job Template</li>
    </ol>
    <div class="clearfix"></div>
  </div>
</div>


<div class="main-body">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
    <div class="card mb-3">
      <div class="card-header py-3">
        <div class="float-left">
          <h6 class="m-0 font-weight-bold text-primary">Edit Job Template</h6>
        </div>
        <div class="float-right">
          <a href="{{ route('admin.templates.index') }}"
            class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
              class="fas fa-arrow-left fa-sm text-white-50"></i> All Job template</a>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="card-body">
        @include('backend.partials.message')
        <form action="{!! route('admin.templates.update', $template->id) !!}" method="post">
          @method('PUT')
          @csrf
          <div class="form-row">
            <div class="col-md-12 form-group">
              <div class="row">
                <div class="col-md-3">
                  <label for="name">Template Name <span class="text-danger required">*</span></label>

                </div>
                <div class="col-md-9">
                  <input type="text" id="name" name="name" class="form-control" placeholder="eg. New Template Name"
                    required value="{{ $template->name }}" maxlength="150">
                </div>
              </div>
            </div>

            <div class="col-md-12 form-group">
              <div class="row">
                <div class="col-md-3">
                  <label for="category_id">Template Category <span class="text-danger required">*</span></label>
                </div>
                <div class="col-md-9">
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
                <div class="col-md-3">
                  <label for="job_summery">Job Summary @include('backend.pages.template.partials.text-rules')</label>
                </div>
                <div class="col-md-9">
                  <textarea name="job_summery" id="job_summery" name="job_summery" rows="3"
                    class="template form-control">{!! $template->job_summery !!}</textarea>
                </div>
              </div>
            </div>
            <div class="col-md-12 form-group">
              <div class="row">
                <div class="col-md-3">
                  <label for="responsibilities">Responsibilities & Duties
                    @include('backend.pages.template.partials.text-rules')</label>
                </div>
                <div class="col-md-9">
                  <textarea name="responsibilities" id="responsibilities" name="responsibilities" rows="3"
                    class="template form-control">{!! $template->responsibilities !!}</textarea>
                </div>
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-12 form-group">
              <div class="row">
                <div class="col-md-3">
                  <label for="qualification">Qualification
                    @include('backend.pages.template.partials.text-rules')</label>
                </div>
                <div class="col-md-9">
                  <textarea name="qualification" id="qualification" name="qualification" rows="3"
                    class="template form-control">{!! $template->qualification !!}</textarea>
                </div>
              </div>
            </div>
            <div class="col-md-12 form-group">
              <div class="row">
                <div class="col-md-3">
                  <label for="certification">Certification
                    @include('backend.pages.template.partials.text-rules')</label>
                </div>
                <div class="col-md-9">
                  <textarea name="certification" id="certification" name="certification" rows="3"
                    class="template form-control">{!! $template->certification !!}</textarea>
                </div>
              </div>
            </div>
          </div>

          <div class="form-row">
            <div class="col-md-12 form-group">
              <div class="row">
                <div class="col-md-3">
                  <label for="experience">Experience @include('backend.pages.template.partials.text-rules')</label>
                </div>
                <div class="col-md-9">
                  <textarea name="experience" id="experience" name="experience" rows="3"
                    class="template form-control">{!! $template->experience !!}</textarea>
                </div>
              </div>
            </div>
            <div class="col-md-12 form-group">
              <div class="row">
                <div class="col-md-3">
                  <label for="about_company">About Company
                    @include('backend.pages.template.partials.text-rules')</label>
                </div>
                <div class="col-md-9">
                  <textarea name="about_company" id="about_company" name="about_company" rows="3"
                    class="template form-control">{!! $template->about_company !!}</textarea>
                </div>
              </div>
            </div>
          </div>

          <a class="btn btn-danger float-right mt-1 ml-2 " href="{{ route('admin.templates.index') }}"><i
              class="fa fa-times"></i> Cancel</a>

          <button type="submit" class="btn btn-success float-right mt-1 ">
            <i class="fa fa-check"></i> Save Changes
          </button>

        </form>
      </div><!-- end card-->
    </div>
  </div>
</div>

@endsection

@section('scripts')
@include('backend.pages.template.partials.scripts');
@endsection