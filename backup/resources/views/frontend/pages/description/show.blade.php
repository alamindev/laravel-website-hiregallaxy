@extends('frontend.layouts.master')



@section('title')

Job Description - {{ $template->name }} | {{ App\Models\Setting::first()->site_title }}

@endsection



@section('stylesheets')



@endsection



@section('content')

<section class="employer-page sec-pad">

	<div class="container"> 
        <div class="single-job-short single-template  px-4"> 
                <div class="job__header mb-3">
                   <h3><strong>Job:</strong> {{ $template->name }}</h3>
                    <br> 
                </div>
                <div class="job__body">
                    <h3>Job summery</h3>
                    <p>{!! $template->job_summery  !!}</p>
                </div>
                <div class="job__body">
                    <h3>Responsibilities</h3>
                    <p>{!! $template->responsibilities  !!}</p>
                </div>
                <div class="job__body">
                    <h3>Qualification</h3>
                    <p>{!! $template->qualification  !!}</p>
                </div>
                <div class="job__body">
                    <h3>Certification</h3>
                    <p>{!! $template->certification  !!}</p>
                </div> 
        </div> 
	</div>

</section>

@endsection



 