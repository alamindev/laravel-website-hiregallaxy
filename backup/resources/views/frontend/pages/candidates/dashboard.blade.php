@extends('frontend.layouts.master-two')



@section('title')

Candidate Dashboard | {{ App\Models\Setting::first()->site_title }}

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

						Welcome {{ $user->name }}

					</h5>

					<p>

						You can manage/see your informations from this section.

					</p>

					<hr>

					<div class="mt-2">





						<h5 class="text-theme p-2">Your Statistics</h5>

						<div class="row">

							<div class="col-md-4">

								<div class="single-dashboard-link card card-default p-3 text-center"

									onclick="location.href='{{ route('candidates.jobs.applied') }}'">

									<i class="fa fa-bell font30"></i>

									<h6>

										{{ count($user->jobApplications) }} Jobs

									</h6>

									<p>

										Applied

									</p>

								</div>

							</div>



							<div class="col-md-4">

								<div class="single-dashboard-link card card-default p-3 text-center"

									onclick="location.href='{{ route('candidates.jobs.favorite') }}'">

									<i class="fa fa-heart font30"></i>

									<h6>

										{{ count($user->favoriteJobs) }} Jobs

									</h6>

									<p>

										Favorite

									</p>

								</div>

							</div>



							<div class="col-md-4">

								<div class="single-dashboard-link card card-default p-3 text-center seen--message"

								 >

									<i class="fa fa-envelope font30"></i>

									<h6>

										@php

								$messages = count($user->unread());

							@endphp

							{{ $messages }} Message{{ $messages > 1 ? 's' : '' }}

									</h6>

									<p>

										Unread

									</p>

								</div>

							</div>

						</div>

					</div>



					<div class="mt-3">

						<div class="row">

							<div class="col-md-4">

								<h5 class="text-theme p-2">Your Profile</h5>

								<div class="single-dashboard-link card card-default p-3 text-center"

									onclick="location.href='{{ route('candidates.show', $user->username) }}'">

									<i class="fa fa-edit font30"></i>

									<h6>

										Profile

									</h6>

									<p>

										Edit

									</p>

								</div>

							</div>

							<div class="col-md-4">

								@if(!empty($personality))

									<h5 class="text-theme p-2">Personality Type</h5>

									<div class="single-dashboard-link card card-default p-3 text-center" >

										<i class="fa fa-male font30"></i>

										<h4 class="ml-2 text-success text-center  py-3">{{$personality->personality_result}}</h4>



									</div>

								@else

									<h5 class="text-theme p-2">Your Personality</h5>

									<div class="single-dashboard-link card card-default p-3 text-center"

										onclick="location.href='{{route('personality', $user->id)}}'">

										<i class="fa fa-male font30"></i>

										<h6>

											Personality

										</h6>

										<p>

											Test Now

										</p>

									</div>

								@endif

							</div>

							<div class="col-md-4">



								@if(!empty($aptitude))

								<h5 class="text-theme p-2">Aptitute Result</h5>

									<div class="single-dashboard-link card card-default p-3 text-center" >

										<i class="fa fa-male font30"></i>

										<h4 class="ml-2 text-success text-center  py-3">{{$aptitude->result}}</h4>



									</div>

								@else

								<h5 class="text-theme p-2">Aptitute Test</h5>

								<div class="single-dashboard-link card card-default p-3 text-center"

										onclick="location.href='{{route('aptitude', $user->id)}}'">

									<i class="fa  fa-smile-o  font30"></i>

									<h6>

										Aptitute

									</h6>

									<p>

										Test Now

									</p>

								</div>

								@endif

							</div>

						</div>

					</div>
                    <div class="clear"></div>
					@if(!empty($personality))

						<div class="mt-3">

							<div class="row">

								<div class="col-md-4">

									<h5 class="text-theme p-2">My Personality</h5>

										<div class="single-dashboard-link card card-default p-3 text-center"

										onclick="location.href='{{ route('candidates.personality') }}'">

											<i class="fa fa-male font30"></i>

											<h4 class="ml-2 text-success text-center  py-3">Show More</h4>

										</div>

								</div>

							</div>

						</div>

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
