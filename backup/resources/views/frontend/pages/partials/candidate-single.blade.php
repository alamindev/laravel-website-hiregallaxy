<!-- Candidate single item -->

<div class="single-job-short single-employer">

	<div class="float-left" onclick="location.href='{{ route('candidates.show', $single_user->username) }}'">

		<img alt="image" src="{{ App\Helpers\ReturnPathHelper::getUserImage($single_user->id) }}">

	</div>

	<div class="float-left  ml-2 single-job-description">

		<h4 onclick="location.href='{{ route('candidates.show', $single_user->username) }}'">{{ $single_user->name }}

		</h4>

		@if($single_user->categories)

		<p class="text-theme mb-2">

			@foreach ($single_user->categories as $catSingleUser)

			@if(!empty($catSingleUser->category->slug))

			<a

				href="{{ route('jobs.categories.show', $catSingleUser->category->slug) }}">{{ $catSingleUser->category->name }}</a>

			 

				@endif



			@endforeach

		</p>

		@endif

		<p class="mt-2">

			<span class="">
				@php
				$country = \App\Models\City::where('id', $single_user->candidate->country_id)->first();
			@endphp
				<i class="fa fa-map-marker location-icon"></i> {{ $single_user->location->street_address }},

				{{ $single_user->location->country->name }}{{ $country ? ', '. $country->name : '' }} 

			</span>

		</p>

		<p>

			@foreach ($single_user->skills as $sk)

			<span class="mr-2 expertise-tag"

				onclick="location.href='{{ route('jobs.skills.show', $sk->skill->slug) }}'">

				<i class="fa fa-tags mr-2"></i> {{ $sk->skill->name }}

			</span>

			@endforeach

		</p>

	</div>

	<div class="float-right">

		<a href="{{ route('candidates.showResume', $single_user->username) }}" class="btn apply-now-button"

			target="_blank">

			Print Resume

		</a>

	</div>

	<div class="clearfix"></div>

</div>