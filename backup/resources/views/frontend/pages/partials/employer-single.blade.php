<!-- Candidate single item -->

<div class="single-job-short single-employer" onclick="location.href='{{ route('employers.show', $single_user->username) }}'">

	<div class="float-left">

		<img alt="image" src="{{ App\Helpers\ReturnPathHelper::getUserImage($single_user->id) }}">

	</div>

	<div class="float-left  ml-2 single-job-description">

		<h4>{{ $single_user->name }}</h4>

		<p class="text-theme mb-2"> 

		    @if(isset($single_user->company))

    		    @if(isset($single_user->company->category))

    		        <a href="{{ route('jobs.categories.show', $single_user->company->category->slug) }}">{{ $single_user->company->category->name }}</a>

    		    @endif

		    @endif

		    

		    @if (count($single_user->categories) > 0)

				@foreach ($single_user->categories as $category)

				,<a href="{{ route('jobs.categories.show', $category->category->slug) }}"

					target="_blank" class="">

					{{ $category->category->name }}

				</a>

				@endforeach

			@endif

			

		</p>

		<p class="mt-2">

			<span class="">

			    @if(isset($single_user->location))
				@php
				$country = \App\Models\City::where('id', $single_user->company->country_id)->first();
			@endphp
			        <i class="fa fa-map-marker location-icon"></i> {{ $single_user->location->street_address }},  {{ $single_user->location->street_address }}, 

    			         @if(isset($single_user->location->country))

    			            {{ $single_user->location->country->name }}

        			    @endif {{ $country ? ', '. $country->name : '' }} 

			    @endif

				

			</span>

		</p>

	</div>

	<div class="clearfix"></div>

</div> 