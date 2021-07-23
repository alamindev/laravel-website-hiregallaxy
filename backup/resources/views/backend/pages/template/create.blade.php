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

  <h1 class="h3 mb-0 float-left">New Job Template</h1>

  <div class="breadcrumb-holder float-right">

    <ol class="breadcrumb float-right">

      <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>

      <li class="breadcrumb-item active">Add New Job Template</li>

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

            Add New Job Template

          </h6>

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

        <form action="{!! route('admin.templates.store') !!}" method="post" data-parsley-validate>

          @csrf

          <div class="form-row">

            {{-- <div class="col-md-6 form-group">

                <label for="discipline_id">Job Discipline</label>

                <select name="discipline_id" id="discipline_id" class="form-control" required>

                  <option value="">Select a job discipline</option>

                  @foreach ($disciplines as $discipline)

                  <option value="{{ $discipline->id }}">{{ $discipline->name }}</option>

                  @endforeach

                </select>

              </div> --}}

            <div class="col-md-6 form-group">

                <label for="discipline_id">Job Position</label>

              <div class="row">

                <div class="col-md-12">

                  <select name="category_id" id="category_id" class="form-control" required>

                    <option value="">Select a position</option>

                    @foreach ($categories as $cat)

                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>

                    @endforeach

                  </select>

                </div>

              </div>

            </div>

          </div>







          <div class="form-row">

            <div class="col-md-12 form-group">

              <div class="row">

                <div class="col-md-12 mt-2">

                  <strong>Job Summary</strong>

                  <textarea name="job_summery" id="job_summery" rows="3" class="template form-control"

                    placeholder="Job Summary"></textarea>
<div class="job-summery-error"></div>
                </div>

              </div>

            </div>

            <div class="col-md-12 form-group">

              <div class="row">

                <div class="col-md-12 mt-2">

                  <strong>Responsibilities & Duties</strong>

                  <textarea name="responsibilities" id="responsibilities" name="responsibilities" rows="3"

                    class="template form-control"></textarea>
<div class="responsibilities-error"></div>
                </div>

              </div>

            </div>

          </div>

          <div class="form-row">

            <div class="col-md-12 form-group">

              <div class="row">

                <div class="col-md-12 mt-2">

                  <strong>Qualification</strong>

                  <textarea name="qualification" id="qualification" name="qualification" rows="3"

                    class="template form-control"></textarea>
<div class="qualification-error"></div>
                </div>

              </div>

            </div>

            <div class="col-md-12 form-group">

              <div class="row">

                <div class="col-md-12 mt-2">

                  <strong>Certification</strong>

                  <textarea name="certification" id="certification" name="certification" rows="3"

                    class="template form-control"></textarea>
<div class="certification-error"></div>
                </div>

              </div>

            </div>

          </div>



          <div class="form-row">

            <div class="col-md-12 form-group">

              <div class="row">

                <div class="col-md-12 mt-2">

                  <strong>Experience</strong>

                  <textarea name="experience" id="experience" name="experience" rows="3"

                    class="template form-control"></textarea>
<div class="experience-error"></div>
                </div>

              </div>

            </div>

            <div class="col-md-12 form-group" style="margin-bottom: -9px;">

              <div class="row">

                <div class="col-md-12 mt-2">

                  <strong>About Company</strong>

                  <textarea name="about_company" id="about_company" name="about_company" rows="3"

                    class="template form-control"></textarea>
<div class="about-company-error"></div>
                </div>

              </div>

            </div>

          </div>





          <div class="mt-3">
            <a href="{{ route('admin.templates.index') }}" class="btn btn-danger float-right mt-1 ml-2 "><i class="fa fa-times"></i> Cancel</a>



            <button type="submit" class="btn btn-success float-right mt-1 saveTemplate">

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

@include('backend.pages.template.partials.scripts');

@endsection

