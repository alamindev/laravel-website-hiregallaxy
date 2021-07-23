@extends('backend.layouts.master')



@section('title')

Settings | Joblrs

@endsection



@section('content')



<div class="d-sm-flex align-items-center justify-content-between mb-4">

    <h1 class="h3 mb-0 float-left">Edit Settings</h1>

    <div class="breadcrumb-holder float-right">

        <ol class="breadcrumb float-right">

            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>

            <li class="breadcrumb-item active">Settings</li>

        </ol>

        <div class="clearfix"></div>

    </div>

</div>





<div class="main-body">

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

        <div class="card mb-3">

            <div class="card-header py-3">

                <div class="">

                    <h6 class="m-0 font-weight-bold text-primary">Edit Settings</h6>

                </div>



            </div>

            <div class="card-body">

                @include('backend.partials.message')

                <form action="{!! route('admin.settings.update') !!}" data-parsley-validate method="post" enctype="multipart/form-data">

                    @method('PUT')

                    @csrf

                    <div class="row form-group">

                        <div class="col-md-12">

                            <label for="site_title">Site Title<span class="text-danger required">*</span></label>

                            <input type="text" name="site_title" id="site_title" class="form-control"

                                value="{{ $settings->site_title }}" required minlength="5">

                        </div>

                    </div>

                    <div class="row form-group">

                        <div class="col-md-6">

                            <label for="site_logo">Site Logo<span class="text-danger required">*</span></label>

                            {{--  <input type="file" name="site_title" id="site_title" class="form-control dropify" required>  --}}

                            <input type="file" name="site_logo" id="site_logo" class="dropify"

                                data-default-file="{{ asset('images/'.$settings->site_logo) }}"

                                data-height="80" >

                        </div>

                        <div class="col-md-6">

                            <label for="site_favicon">Site Favicon<span class="text-danger required">*</span></label>

                            {{--  <input type="file" name="site_title" id="site_title" class="form-control dropify" required>  --}}

                            <input type="file" name="site_favicon" id="site_favicon" class="dropify"

                                data-default-file="{{ asset('public/images/'.$settings->site_favicon) }}"

                                data-height="80"/>

                        </div>

                    </div>



                    <div class="form-row">

                        <div class="col-md-6 form-group">

                            <div class="row form-group">

                                <div class="col-md-12">

                                    <label for="name">Admin Theme  </label>

                                </div>

                                <div class="col-md-12">

                                    <select name="admin_theme" id="admin_theme" class="form-control">

                                        <option value="light" {{ $settings->admin_theme == 'light' ? 'selected' : '' }}>

                                            Light</option>

                                        <option value="dark" {{ $settings->admin_theme == 'dark' ? 'selected' : '' }}>

                                            Dark</option>

                                        <option value="primary"

                                            {{ $settings->admin_theme == 'primary' ? 'selected' : '' }}>Primary</option>

                                    </select>

                                </div>

                            </div>

                        </div>

                        <div class="col-md-6 form-group">

                            <div class="row form-group">

                                <div class="col-md-12">

                                    <label for="name">Enable Job Data Editing <span

                                            class="text-danger required">*</span></label>

                                </div>

                                <div class="col-md-12">

                                    <select name="enable_job_editing" id="enable_job_editing" class="form-control">

                                        <option value="1" {{ $settings->enable_job_editing  ? 'selected' : '' }}>

                                            Yes</option>

                                        <option value="0" {{  !$settings->enable_job_editing ? 'selected' : '' }}>

                                            No</option>



                                    </select>

                                </div>

                            </div>

                        </div>
                        <div class="col-md-12">

                            <label for="facebook">Facebook Link</label>

                            <input type="url" name="facebook_link" id="facebook" class="form-control"

                                value="{{ $settings->facebook_link }}">

                        </div>
                        <div class="col-md-12">

                            <label for="twitter">Twitter Link</label>

                            <input type="url" name="twitter_link" id="twitter" class="form-control"

                                value="{{ $settings->twitter_link }}">

                        </div>
                        <div class="col-md-12">

                            <label for="goggle">Goggle + Link</label>

                            <input type="url" name="google_plus_link" id="goggle" class="form-control"

                                value="{{ $settings->google_plus_link }}">

                        </div>
                        <div class="col-md-12">

                            <label for="linkedin">Linkedin</label>

                            <input type="url" name="linkedin_link" id="linkedin" class="form-control"

                                value="{{ $settings->linkedin_link }}">

                        </div>
                        {{-- <div class="col-md-12">

                            <label for="youtube">Youtube</label>

                            <input type="url" name="youtube_link" id="youtube" class="form-control"

                                value="{{ $settings->youtube_link }}">

                        </div>
                        <div class="col-md-12">

                            <label for="instragram">Instragram</label>

                            <input type="url" name="instragram_link" id="instragram" class="form-control"

                                value="{{ $settings->instragram_link }}">

                        </div> --}}


                        <div class="col-md-12 py-5">

                          <label for="terms_and_service">Terms and Service Page</label>



                          <textarea name="terms_and_service" id="terms_and_service" name="terms_and_service" rows="5" cols="80"

                                    class="tinymce form-control">{!! $settings->terms_and_service !!}</textarea>

                        </div>

                         <div class="col-md-12 mt-2 py-5">

                          <label for="privacy_policy">Privacy Policy Page</label>



                          <textarea name="privacy_policy" id="privacy_policy" name="privacy_policy" rows="5" cols="80"

                                    class="tinymce form-control">{!! $settings->privacy_policy !!}</textarea>

                        </div>
                         <div class="col-md-12 mt-2 py-5">

                          <label for="about_us">About us Page</label>



                          <textarea name="about_us" id="about_us" name="about_us" rows="5" cols="80"

                                    class="tinymce form-control">{!! $settings->about_us !!}</textarea>

                        </div>

                    </div>



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

<script>

    $('.dropify').dropify();

</script>

@endsection
