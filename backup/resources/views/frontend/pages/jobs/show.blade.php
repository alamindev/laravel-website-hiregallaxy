@extends('frontend.layouts.master')



@section('title')

{{ $job->title }} - Job Details | {{ App\Models\Setting::first()->site_title }}

@endsection





@section('stylesheets')



@endsection





@section('content')

<section class="employer-page job-detail-page">

	<div class="container">

		<div class="header-company-profile">

			<div class="row justify-content-center">

				<div class="col-md-11">

					<div class="row">

						<div class="col-sm-2 text-center mb-4 pt-5 pt-md-0">

							<img src="{{ App\Helpers\ReturnPathHelper::getUserImage( $job->user->id) }}"

								class="img img-fluid" class="img img-fluid">

						</div>

						<div class="col-sm-8">

							<div class="pl-0 pl-md-5">

								<div class="single-job-description">

									<h3>{{ $job->title }}</h3>

									<p>

										<span class="mr-2">

											<i class="fa fa-user category-icon"></i> {{ $job->user->name }}

										</span>
									@if($job->category)
										<span class="mr-2">

											Posted: <span

												class="text-yellow">{{ $job->created_at->diffForHumans() }}</span> in

											<a

												href="{{ route('jobs.categories.show', $job->category->slug) }}">{{ $job->category->name }}</a>

										</span>
									@endif
									</p>

									<p>

										<span class="mr-2">

											<i class="fa fa-calendar category-icon text-info"></i>

											Deadline: <span

												class="text-muted">{{ date("d M Y", strtotime($job->deadline)) }}</span>

										</span>

									</p>

									<p>

										<span class="mr-2">

											<i class="fa fa-clock-o text-yellow"></i> <span

												class="text-yellow">{{ $job->type->name }}</span>

										</span>



										<span class="mr-2">

											<i class="fa fa-map-marker location-icon"></i> {{ $job->location }}

										</span>

										<span class="mr-2">

											<a href="www.joblrs.com" target="_blank" class="text-link"><i

													class="fa fa-globe"></i> {{ $job->user->website }}</a>

										</span>

									</p>

									{{--  <p>

										<span class="text-muted">Skills: </span>

										@foreach ($job->skills as $sk)

										<span class="badge badge-warning text-white">

											{{ $sk->skill->name }}

									</span>

									@endforeach

									</p> --}}

									@if (!is_null($job->sector) || !is_null($job->segment) ||

									!is_null($job->discipline))

									<div class="row">

										@if (!is_null($job->segment))

										<div class="col-12">

											<strong>Employer Type: </strong>

											{{ !is_null($job->segment) ? $job->segment->name : '--' }}

										</div>

										@endif



										@if (!is_null($job->sector))

										<div class="col-12">

											<strong>Sector: </strong>

											{{ !is_null($job->sector) ? $job->sector->name : '--' }}

										</div>

										@endif



										@if (!is_null($job->discipline))

										<div class="col-12">

											<strong>Discipline: </strong>

											{{ !is_null($job->discipline) ? $job->discipline->name : '--' }}

										</div>

										@endif

									</div>

									@endif



									<div class="mt-3">

										<div class="footer-social">

											<span class="mr-3">Share </span>

											<a href=""><i class="fa fa-facebook facebook-icon"></i></a>

											<a href=""><i class="fa fa-twitter twitter-icon"></i></a>

											<a href=""><i class="fa fa-google-plus google-plus-icon"></i></a>

											<a href=""><i class="fa fa-linkedin linkedin-icon"></i></a>

										</div>

									</div>
									@if(auth()->check())
									@if(auth()->user()->is_company == 0)
									<div class="mt-3 d-flex align-items-center">



										@if (Auth::check())

											@if (Auth::user()->hasAppliedJob($job->id))

											<a href="#update-apply-job-modal" data-toggle="modal"

												class="btn btn-outline-success applyUpdateJobData"
												data-auth-id="{{ Auth::id() }}" data-user-profile-cv="{{ Auth::user()->candidate ? Auth::user()->candidate->cv : '' }}"
												data-job-id="{{ $job->id }}" data-currency="{{ $job->getCurrencyName() }}" data-company-id="{{ $job->user->id }}" data-monthly-salary="{{$job->monthly_salary}}">

												<span class="text-success"><i class="fa fa-check"></i> Already

													Applied</span>

											</a>

											@else

												@if (Auth::id() != $job->user_id)

												@if($result || !count($job->skills) > 0)

														<a href="#apply-job-modal" data-toggle="modal" class="btn apply-now-button m-0  mb-2 mr-3 applyJobData"

														data-job-id="{{ $job->id }}" data-currency="{{ $job->getCurrencyName() }}" data-company-id="{{ $job->user->id }}" data-monthly-salary="{{$job->monthly_salary}}">

															Apply Now

														</a>

													@else

														<a href="{{route('exam', $job->id)}}" class="btn apply-now-button m-0  mb-2  mr-3" >

															Apply Now

														</a>

													@endif

												@endif



											@endif

										@else

										<a href="#apply-job-modal" data-toggle="modal" class="btn apply-now-button m-0 mb-2 applyJobData"

										data-job-id="{{ $job->id }}" data-currency="{{ $job->getCurrencyName() }}" data-company-id="{{ $job->user->id }}" data-monthly-salary="{{$job->monthly_salary}}">

											Apply Now

										</a>

										@endif





										@if (Auth::check())

										<favorite-component url="{{ url('/') }}" id="{{ $job->id }}"

											api_token="{{ Auth::user()->api_token }}"></favorite-component>

										@else

										<favorite-component url="{{ url('/') }}" id="{{ $job->id }}" api_token="0">

										</favorite-component>

										@endif

									</div>
									@endif
									@else
									<div class="mt-3 d-flex align-items-center">

										<a href="#apply-job-modal" data-toggle="modal" class="btn apply-now-button m-0 mb-2 applyJobData"

										data-job-id="{{ $job->id }}" data-currency="{{ $job->getCurrencyName() }}" data-company-id="{{ $job->user->id }}" data-monthly-salary="{{$job->monthly_salary}}">

											Apply Now

										</a>
									</div>
									@endif

								</div>

							</div>

						</div>

						<div class="col-sm-2">

							<div class="salary-div card card-default card-body pt-4 pb-4 text-center">

								<h5 class="text-theme bold font22">Salary</h5>

								<p class="text-theme">

									@if ($job->is_salary_negotiable)

									Negotiable

									@else

									{{ $job->monthly_salary }}

									{{ $job->currency->symbol }}

									@endif</p>

							</div>

						</div>

					</div>

				</div>

			</div>



		</div>



		<div class="row mt-5">

					<div class="col-md-8 pb-5">

						<div class="employer-detail-main">

						<div id="job__id" style="

						display: flex;

						padding: 6px 12px;

						border: 1px solid #ececec;

						margin-left: 7px;

			">

				<div class="job__label">

					Job ID:

				</div>

				<div class="job__number" style="font-weight: bold; margin-left: 5px">{{$job->job_id ? $job->job_id :''}}</div>

			</div>





					{{--  {!! $job->description !!}  --}}



					@if ($job->job_summery != null)

					<div class="single-details p-2 mb-3 mt-4">

						<h5>Job Summary</h5>

						<div>

							{!! $job->job_summery !!}

						</div>

					</div>

					@endif



					@if ($job->responsibilities != null)

					<div class="single-details p-2 mb-3">

						<h5>Responsibilities & Duties</h5>

						<div>

							{!! $job->responsibilities !!}

						</div>

					</div>

					@endif



					@if ($job->qualification != null)

					<div class="single-details p-2 mb-3">

						<h5>Qualification</h5>

						<div>

							{!! $job->qualification !!}

						</div>

					</div>

					@endif



					@if ($job->certification != null)

					<div class="single-details p-2 mb-3">

						<h5>Certification</h5>

						<div>

							{!! $job->certification !!}

						</div>

					</div>

					@endif



					@if ($job->experience != null)

					<div class="single-details p-2 mb-3">

						<h5>Experience</h5>

						<div>

							{!! $job->experience !!}

						</div>

					</div>

					@endif

					@if ($job->skills)

					<div class="single-details p-2 mb-3">

						<h5>Skills</h5>

						<div>

							@foreach($job->skills as $skill)

								<div class="badge badge-info">{{$skill->name}}</div>

							@endforeach

						</div>

					</div>

					@endif

					@if ($job->about_company != null)

					<div class="single-details p-2 mb-3">

						<h5>About Company</h5>

						<div>

							{!! $job->about_company !!}

						</div>

					</div>

					@endif







				</div>



				<!--



				<div class="mt-2">

					<h3 class="text-center text-theme apply-count-text">

						<span class="job-apply-total">

							<span class="fa fa-check"></span> {{ count($job->activities) }}

						</span>

						Candidate{{ count($job->activities) > 1 ? 's' : '' }} Applied

						<a href="#jobApplications" class="btn btn-outline-yellow" data-toggle="collapse" role="button"

							aria-expanded="false" aria-controls="jobApplications"><span

								class="fa fa-chevron-down"></span></a>

					</h3>

				</div>



				<div class="job-applications collapse" id="jobApplications">

					@foreach ($job->activities as $activity)

					@php

					$single_user = $activity->user;

					@endphp

					<div class="single-job-short single-employer"

						onclick="location.href='{{ route('candidates.show', $single_user->username) }}'">

						<div class="float-left">

							<img src="{{ App\Helpers\ReturnPathHelper::getUserImage($single_user->id) }}">

						</div>

						<div class="float-left  ml-2 single-job-description">

							<h4>{{ $single_user->name }}</h4>

							<p class="text-theme mb-2">

								@foreach ($single_user->categories as $catSingleUser)
	@if($catSingleUser->category)
								<a

									href="{{ route('jobs.categories.show', $catSingleUser->category->slug) }}">{{ $catSingleUser->category->name }}</a>
@endif
								@endforeach

							</p>

							<p class="text-muted">

								{{ $activity->created_at->diffForHumans() }}

							</p>

						</div>

						<div class="float-right">

							<span class="expected-salary-text">

								@if ($activity->is_salary_negotiable)

								Negotiable

								@else

								{{ round($activity->expected_salary, 0) }}



								{{ !is_null($job->currency) ? $job->currency->name : 'USD' }}

								@endif

							</span>

						</div>

						<div class="clearfix"></div>

					</div>

					@endforeach

				</div>



                -->



				@if (count($similar_jobs) > 0)

				<div class="mt-5">

					<div class="more-jobs">

						<h5 class="text-theme bold">Jobs You may also like</h5>



						@foreach ($similar_jobs as $job)

						@include('frontend.pages.partials.single-job-short')

						@endforeach

					</div>

				</div>

				@endif



			</div>

			<div class="col-md-4">

				@if (!Auth::check() && $job->user_id != Auth::id())

				<div class="employer-detail-sidebar">

					<h5 class="text-theme">

						Contact with the Employer

					</h5>

					<form action="" class="mt-3">



						<div class="form-group">

							<label for="name">User Name</label>

							<div class="input-group mb-3">

								<input type="text" class="form-control" placeholder="Write your name" id="name">

								<div class="input-group-append">

									<span class="input-group-text"><i class="fa fa-user"></i></span>

								</div>

							</div>

						</div>



						<div class="form-group">

							<label for="email">Email Address</label>

							<div class="input-group mb-3">

								<input type="text" class="form-control" placeholder="Write your email address"

									id="email">

								<div class="input-group-append">

									<span class="input-group-text"><i class="fa fa-envelope"></i></span>

								</div>

							</div>

						</div>



						<div class="form-group">

							<label for="message">Your Message</label>

							<textarea name="message" id="message" rows="4" class="form-control"

								placeholder="Write your message here"></textarea>

						</div>



						<div class="form-group">

							<div class="form-check">

								<input class="form-check-input" type="checkbox" id="gridCheck">

								<label class="form-check-label ml-2" for="gridCheck">

									Accept our <a href="" class="text-yellow">Terms and Condition</a> and <a href=""

										class="text-yellow">Privacy Policy</a>

								</label>

							</div>

						</div>



						<div class="form-group text-center">

							<input type="submit" value="Send Message" class="btn apply-now-button">

						</div>



					</form>

				</div>

				@endif

			</div>

		</div>

	</div>

</section>

@endsection





@section('scripts')

<script>
	$.urlParam = function (name) {
    var results = new RegExp('[\?&]' + name + '=([^&#]*)')
                      .exec(window.location.search);
    return (results !== null) ? results[1] || 0 : false;
}
if($.urlParam('modal') == 'true'){
	$("#apply-job-modal").modal('show');
	applyJobDataSet({{ $job->id }}, '{{ $job->getCurrencyName() }}','{{ $job->user->id }}');
}
</script>

@endsection

