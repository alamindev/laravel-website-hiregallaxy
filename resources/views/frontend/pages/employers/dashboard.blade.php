@extends('frontend.layouts.master-two')



@section('title')

Employer Dashboard | {{ App\Models\Setting::first()->site_title }}

@endsection



@section('stylesheets')



@endsection



@section('content')

<section class="employer-page sec-pad pt-0" id="wrapper">

	<div class="container">

		<div class="row">

			<div class="col-md-6">
				<div class="employer-detail-main">

					<div class="mt-2 mr-0 mr-sm-2">

						<h5 class="text-theme p-2">Your Statistics</h5>

						<div class="row">

							<div class="col-sm-6 col-md-6 col-lg-4 mb-2 px-1">

								<div class="single-dashboard-link card card-default p-3 text-center"

									onclick="location.href='{{ route('employers.jobs.posted') }}'">

									<i class="fa fa-bell font30"></i>

									<h6>
										{{ count($user->jobs) + $team_job_count}} Jobs

									</h6>

									<p>

										Posted

									</p>

								</div>

							</div>

							<div class="col-sm-6 col-md-6 col-lg-4 mb-2 px-1">

								<div class="single-dashboard-link card card-default p-3 text-center"

									onclick="location.href='{{ route('companies') }}'">

									<i class="fa fa-briefcase font30"></i>

									<h6>

										{{ $user->companies()->count() }} Total

									</h6>

									<p>

										Companies

									</p>

								</div>

							</div>

							<div class="col-sm-6 col-md-6 col-lg-4 mb-2 px-1">

								<div class="single-dashboard-link card card-default p-3 text-center"

									onclick="location.href='{{ route('employers.total')}}'">

									<i class="fa fa-file-text font30"></i>

									<h6>

										{{ \App\Models\JobActivity::where('company_id', auth()->user()->id)->get()->count() + $applicant_count }} Total

									</h6>

									<p>

										Applications

									</p>

								</div>

							</div>

							<div class="col-sm-6 col-md-6 col-lg-4 mb-2 px-1">

								<div class="single-dashboard-link card card-default p-3 text-center"

									onclick="location.href='{{ route('employers.candidate', 'New')}}'">

									<i class="fa fa-file-text font30"></i>

									<h6>

										@php

										$new = \App\Models\JobActivity::where('company_id', $user->id)->where('status', 'New')->get();

										@endphp

										{{ $new->count() + $new_count }} Total

									</h6>

									<p>

										New Applications

									</p>

								</div>

							</div>

							<div class="col-sm-6 col-md-6 col-lg-4 mb-2 px-1">

								<div class="single-dashboard-link card card-default p-3 text-center"

									onclick="location.href='{{ route('employers.candidate', 'Shortlisted')}}'">

									<i class="fa  fa-user-secret font30"></i>

									<h6>

										@php

										$shortlist = \App\Models\JobActivity::where('company_id', $user->id)->where('status', 'Shortlisted')->get();

										@endphp

										{{ $shortlist->count() + $short_count }} Total

									</h6>

									<p>

										Shortlisted Candidates

									</p>

								</div>

							</div>

							<div class="col-sm-6 col-md-6 col-lg-4 mb-2 px-1">

								<div class="single-dashboard-link card card-default p-3 text-center"

									onclick="location.href='{{ route('employers.candidate', 'Interview')}}'">

									<i class="fa fa-user-secret  font30"></i>

									<h6>
										@php

										$interview = \App\Models\JobActivity::where('company_id', $user->id)->where('status', 'Interview')->get();

										@endphp

										{{ $interview->count() + $interview_count}} Total

									</h6>

									<p>

										Interviews

									</p>

								</div>

							</div>

							<div class="col-sm-6 col-md-6 col-lg-4 mb-2 px-1">

								<div class="single-dashboard-link card card-default p-3 text-center"

									onclick="location.href='{{ route('employers.candidate', 'Offered')}}'">

									<i class="fa fa-bullhorn font30"></i>

									<h6>

										@php

										$offered = \App\Models\JobActivity::where('company_id', $user->id)->where('status', 'Offered')->get();

										@endphp

										{{ $offered->count() + $offered_count}} Total

									</h6>

									<p>

										Offered

									</p>

								</div>

							</div>

							<div class="col-sm-6 col-md-6 col-lg-4 mb-2 px-1">

								<div class="single-dashboard-link card card-default p-3 text-center"

									onclick="location.href='{{ route('employers.candidate', 'Hired')}}'">

									<i class="fa fa-user-plus font30"></i>

									<h6>

										@php

										$hired = \App\Models\JobActivity::where('company_id', $user->id)->where('status', 'Hired')->get();

										@endphp

										{{ $hired->count() + $hired_count }} Total

									</h6>

									<p>

										Hired

									</p>

								</div>

							</div>

							<div class="col-sm-6 col-md-6 col-lg-4 mb-2 px-1">

								<div class="single-dashboard-link card card-default p-3 text-center"

									onclick="location.href='{{ route('employers.candidate', 'Rejected')}}'">

									<i class="fa fa-user-times font30"></i>

									<h6>

										@php

										$reject = \App\Models\JobActivity::where('company_id', $user->id)->where('status', 'Rejected')->get();

										@endphp

										{{ $reject->count() + $reject_count }} Total

									</h6>

									<p>

										Rejected

									</p>

								</div>

							</div>

						</div>

					</div>

				</div>
				<filter-component :assign="false"  team_id="" ></filter-component>
			</div>


			<div class="col-md-6">

				<div class="mt-2 ml-0 ml-sm-3">

					<h5 class="text-theme p-2">Your Profile</h5>

					<div class="row">

						<div class="col-sm-6 col-md-6 col-lg-4 mb-2 px-1">

							<div class="single-dashboard-link card card-default p-3 text-center"

								onclick="location.href='{{ route('employers.show', $user->username) }}'">

								<i class="fa fa-edit font30"></i>

								<h6>

									Profile

								</h6>

								<p>

									Edit

								</p>

							</div>

						</div>

						<div class="col-sm-6 col-md-6 col-lg-4 mb-2 px-1">

							<div class="single-dashboard-link card card-default p-3 text-center"

								onclick="location.href='{{ route('jobs.post') }}'">

								<i class="fa fa-plus-circle font30"></i>

								<h6>

									Post

								</h6>

								<p>

									New Job

								</p>

							</div>

						</div>

						<div class="col-sm-6 col-md-6 col-lg-4 mb-2 px-1">

								<div class="single-dashboard-link card card-default p-3 text-center"

									onclick="location.href='{{ route('employers.search.candidates') }}'">

									<i class="fa fa-search font30"></i>

									<h6>

									 Search Candidates

									</h6>

								</div>

						</div>
						<div class="col-sm-6 col-md-6 col-lg-4 mb-2 px-1">

							<div class="single-dashboard-link card card-default p-3 text-center seen--message"

							  >

								<i class="fa fa-envelope font30"></i>

								<h6>

									@php

										$messages = count($user->unread());

									@endphp

									{{ $messages }} Message{{ $messages > 1 ? 's' : '' }}

								</h6>

							</div>

						</div>
						<div class="col-sm-6 col-md-6 col-lg-4 mb-2 px-1">

							<div class="single-dashboard-link card card-default p-3 text-center"

								onclick="location.href='{{ route('teams') }}'">
								<i class="fa fa-users font30"></i>
								<h6>{{ count($user->teams) }}  Team</h6>
							</div>

						</div>
						<div class="col-sm-6 col-md-6 col-lg-4 mb-2 px-1">

							<div class="single-dashboard-link card card-default p-3 text-center"

								onclick="location.href='{{ route('employers.change-password') }}'">
								<i class="fa fa-edit font30"></i>
								<h6>Change password</h6>
							</div>

						</div>
					</div>

				</div>

				<div class="mt-4">

					@include('frontend.pages.todo._component')

				</div>

			</div>

		</div>

	</div>


</section>

@endsection





@section('scripts')



@endsection
