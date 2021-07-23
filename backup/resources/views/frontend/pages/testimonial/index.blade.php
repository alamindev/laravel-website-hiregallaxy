@extends('frontend.layouts.master')
@section('title')
{{ App\Models\Setting::first()->site_title }} | Testimonails
@endsection
@section('stylesheets')
@endsection
@section('content')
 

<!-- Popular Positions Area -->
 
<section class="client-review sec-pad">

	<div class="container">

		<h1 class="client-review-title">Great Words From Happy Clients</h1>

		@if (Auth::check())

		<div class="float-right">

			<add-review-component url="{{ url('/') }}" api_token="{{ Auth::user()->api_token }}"

				is_company="{{ Auth::user()->is_company }}"></add-review-component>

		</div>

		@endif



		<p class="client-review-description mb-5">Lets See what’s our valuable candidates and employers saying about us

		</p>



		<div class="owl-carousel owl-theme">



			@foreach ($reviews as $review)

			<div class="wow fadeInLeft single-carousel-item item mt-3">

				<div class="float-left">

					<img alt="image" src="{{ asset('images/users/'.$review->profile_picture) }}" class="client-image">

				</div>

				<div class="client-detail float-left ml-3 mb-2 ">

					<h4>{{ $review->name }}</h4>

					<p>{{ $review->position }}</p>

					<p>

						<a href="{{ $review->facebook_link }}" class="ml-2 text-white">

							<i class="fa fa-facebook"></i>

						</a>

						<a href="{{ $review->twitter_link }}" class="ml-2 text-white">

							<i class="fa fa-twitter"></i>

						</a>

						<a href="{{ $review->linkedin_link }}" class="ml-2 text-white">

							<i class="fa fa-linkedin"></i>

						</a>

					</p>

				</div>

				<div class="clearfix"></div>



				<div class="arrow-up"></div>

				<div class="speech">

					<blockquote cite="">

						{{ $review->review }}

					</blockquote>

				</div>

			</div> <!-- End Single Item -->

			@endforeach



		</div>

	</div>

</section>

 
@endsection 

 