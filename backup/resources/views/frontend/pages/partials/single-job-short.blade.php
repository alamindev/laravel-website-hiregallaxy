<div class="single-job-short single-employer">

	<div class="float-left">

		@if (!is_null($job->user->profile_picture))

		<img src="{{ asset('images/users/'.$job->user->profile_picture) }}" alt="image">

		@else

		<i class="{{ $job->category->icon }} job-category-icon"></i>

		@endif

	</div>

	<div class="float-left  ml-2 single-job-description">

		<h4 class="pointer" onclick="location.href='{{ route('jobs.show', $job->slug) }}'">{{ $job->title }}</h4>

		<p><i class="fa fa-shopping-bag category-icon"></i> {{ $job->category->name }}</p>

		<p><i class="fa fa-map-marker location-icon"></i> {{ $job->location }}</p>

		<p><i class="fa fa-clock-o time-icon"></i> {{ $job->type->name }} </p>

		@if (Route::is('index'))

		<p class="mt-2">



			@if (Auth::check())

				@if (Auth::user()->hasAppliedJob($job->id))

					<a href="#update-apply-job-modal" data-toggle="modal" class="btn btn-outline-success applyUpdateJobData" data-job-id="{{ $job->id }}" data-company-id="{{ $job->user->id }}" data-auth-id="{{ Auth::id() }}" data-user-profile-cv="{{ Auth::user()->candidate ? Auth::user()->candidate->cv : '' }}" data-job-id="{{ $job->id }}" data-currency="{{ $job->getCurrencyName() }}">

						<span class="text-success"><i class="fa fa-check"></i> Already Applied</span>

					</a>

				@else

				<a href="#apply-job-modal" data-toggle="modal"   class="btn apply-now-button applyJobData"  data-job-id="{{ $job->id }}"  data-company-id="{{ $job->user->id }}" data-currency="{{ $job->getCurrencyName() }}">

				Apply Now

			</a>

				@endif

			@else

			<a href="#apply-job-modal" data-toggle="modal"  class="btn apply-now-button applyJobData" data-job-id="{{ $job->id }}"  data-company-id="{{ $job->user->id }}" data-currency="{{ $job->getCurrencyName() }}">

				Apply Now

			</a>

			@endif

		</p>

		@endif

	</div>



	<div class="float-right text-right mb-3 ">

		@if (Auth::check())

		<favorite-component url="{{ url('/') }}" id="{{ $job->id }}" api_token="{{ Auth::user()->api_token }}"></favorite-component>

		@else

		<favorite-component url="{{ url('/') }}" id="{{ $job->id }}" api_token="0"></favorite-component>

		@endif

		<br>

		@if (!Route::is('index'))

		@if (Auth::check())

			@if (Auth::user()->hasAppliedJob($job->id))

				<a href="#update-apply-job-modal" data-toggle="modal" class="btn btn-outline-success applyUpdateJobData"  data-auth-id="{{ Auth::id() }}" data-user-profile-cv="{{ Auth::user()->candidate ? Auth::user()->candidate->cv : '' }}"  data-job-id="{{ $job->id }}" data-company-id="{{ $job->user->id }}" data-currency="{{ $job->getCurrencyName() }}">

					<span class="text-success"><i class="fa fa-check"></i> Already Applied</span>

				</a>

			@else

			<a href="#apply-job-modal" data-toggle="modal" class="btn btn-outline-yellow applyJobData"  data-job-id="{{ $job->id }}" data-currency="{{ $job->getCurrencyName() }}">

				Apply Now

			</a>

			@endif

		@else

		<a href="#apply-job-modal" data-toggle="modal" class="btn btn-outline-yellow applyJobData"  data-company-id="{{ $job->user->id }}" data-job-id="{{ $job->id }}" data-currency="{{ $job->getCurrencyName() }}">

			Apply Now

		</a>

		@endif



		@endif

	</div>

	<div class="clearfix"></div>

</div>
