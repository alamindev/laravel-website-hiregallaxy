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

				<div class="employer-detail-main">

					<h5 class="text-theme">

						My Applied Jobs

					</h5>

					@foreach ($jobs as $single_job)

					@include('frontend.pages.partials.single-job-search')

					@endforeach



					<div>

						{{ $jobs->links() }}

					</div>



					@if (count($jobs) == 0)

					<p class="mt-4">

						<span class="alert alert-danger">

							Sorry !! No jobs has been applied yet by you !!

						</span>

					</p>

					@endif

				</div>



			</div>

			<div class="col-md-4">

				@include('frontend.pages.partials.candidates-sidebar')

			</div>

		</div>

</section>

@endsection





@section('scripts')



@endsection