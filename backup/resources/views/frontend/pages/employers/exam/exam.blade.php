@extends('frontend.layouts.master')

@section('title')
Employer Exam | {{ App\Models\Setting::first()->site_title }}
@endsection

@section('stylesheets') 
@endsection

@section('content')

<section class="employer-page sec-pad pt-0" id="hiregalaxy">
	<div class="container">
        <div class="row">
            <div class="col-lg-12">
            <exam-component url="{{route('jobs')}}" id="{{$id}}" ></exam-component> 
            </div>
        </div>
    </div>
</section>
@endsection


@section('scripts')
 
@endsection