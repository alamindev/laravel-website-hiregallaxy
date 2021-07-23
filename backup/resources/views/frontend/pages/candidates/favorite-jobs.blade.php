@extends('frontend.layouts.master-two')



@section('title')

Favorite Jobs | {{ App\Models\Setting::first()->site_title }}

@endsection



@section('stylesheets')



@endsection



@section('content')

<section class="employer-page sec-pad pt-0">

	<div class="container">

		<div class="row mt-4">

			<div class="col-md-8">

				@include('frontend.pages.partials.favorite-section')

			</div>

			<div class="col-md-4">

				@include('frontend.pages.partials.candidates-sidebar')

			</div>

		</div>

</section>

@endsection





@section('scripts')



@endsection