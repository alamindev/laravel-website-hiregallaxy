<form action="{{ $route }}" method="get" id="cadidateSearchForm">
	<input type="hidden" name="candidate" >
	<div class="sidebar-widget"> 
		<div class="sidebar-list-item">
	
			<h3>

				Candidate  By Country

			</h3>

			<hr class="sidebar-border">

			<div class="clearfix"></div>



			<select name="country" onchange="submitSearch()" id="country" class="selectpicker country__select" data-live-search="true">

				<option data-icon="fa fa-map-marker" value="all">All Countries</option> 

				@foreach (App\Models\City::orderBy('name', 'asc')->get() as $country)

				<option value="{{ $country->name }}"

					{{ isset($_GET['country']) && ($_GET['country'] == $country->name) ? 'selected' : '' }}>

					&nbsp;&nbsp; {{ $country->name }}
 
				</option>

				@endforeach 

			</select>

		</div>
	</div> 
	<div class="sidebar-widget "> 
		<div class="sidebar-list-item">
	
			<h3>

				Candidate  By City

			</h3>

			<hr class="sidebar-border">

			<div class="clearfix"></div>

			<div class="load__select_country">

			<select name="cities" onchange="submitSearch()" id="cities" class="selectpicker city__showing" data-live-search="true">

				<option data-icon="fa fa-map-marker" value="all">All Locations</option>

				@foreach (App\Models\State::orderBy('name', 'asc')->get() as $state)

				<option value="" disabled style="font-weight: bolder;font-size: 16px;">

					{{ $state->name }}

				</option>

				@foreach ($state->cities()->orderBy('name', 'asc')->get() as $countrySingle)

				<option value="{{ $countrySingle->name }}"

					{{ isset($_GET['cities']) && ($_GET['cities'] == $countrySingle->name) ? 'selected' : '' }}>

					&nbsp;&nbsp; {{ $countrySingle->name }}

					 
				</option>

				@endforeach

				@endforeach

			</select>

		</div>
		</div>
	</div> 
	<div class="sidebar-widget">
	 
	
		<div class="sidebar-list-item">

			<h3>

				Candidate By Positions

			</h3>

			<hr class="sidebar-border">
			<div class="load__select_position">
			<div class="my-4">
					<select name="category" onchange="submitSearch()"  id="cate" class="selectpicker" data-live-search="true" >
 
					<option data-icon="fa fa-navicon" value="all">All Positions</option>
	
					@foreach (App\Models\Category::orderBy('name', 'asc')->get() as $cat)
	
					<option  value="{{ $cat->slug }}" {{ isset($_GET['category']) && ($_GET['category'] == $cat->slug) ? 'checked' : '' }}>	 	{{ $cat->name }}</option>
	
					@endforeach
	
				</select> 
		</div>
		</div>
		  

		</div>

	</div>



	<!-- Location -->




	{{-- 	<div class="sidebar-widget">

		<div class="sidebar-list-item">

			<h3>

				Job Type

			</h3>

			<hr class="sidebar-border">

			<div class="clearfix"></div>



			@foreach (App\Models\JobType::orderBy('name', 'asc')->get() as $jobTypeSingle)

			<div class="squaredFour">

				<input type="checkbox" value="{{ $jobTypeSingle->name }}" id="type{{ $jobTypeSingle->id }}" name="type"

	onchange="submitSearch()" {{ isset($_GET['type']) && ($_GET['type'] == $jobTypeSingle->name) ? 'checked' : '' }}/>

	<label for="type{{ $jobTypeSingle->id }}"></label>

	{{ $jobTypeSingle->name }}

	({{ count(App\Models\Job::where('status_id', 1)->where('type_id', $jobTypeSingle->id)->get()) }})

	</div>

	@endforeach



	</div>

	</div> --}}





	<!-- Experience Level -->

	{{--  <div class="sidebar-widget">

		<div class="sidebar-list-item">

			<h3>

				Experience Level

			</h3>

			<hr class="sidebar-border">

			<div class="clearfix"></div>



		

			@foreach (App\Models\Experience::orderBy('name', 'asc')->get() as $experienceSingle)

			<div class="squaredFour">

				<input type="checkbox" value="{{ $experienceSingle->slug }}" id="experience{{ $experienceSingle->id }}"

	name="experience" onchange="submitSearch()"

	{{ isset($_GET['experience']) && ($_GET['experience'] == $experienceSingle->slug) ? 'checked' : '' }}/>

	<label for="experience{{ $experienceSingle->id }}"></label>

	{{ $experienceSingle->name }}

	({{ count(App\Models\CandidateProfile::where('experience_id', $experienceSingle->id)->get()) }})

	</div>

	@endforeach



	</div>

	</div>



	<div class="sidebar-widget">

		<div class="sidebar-list-item">

			<h3>

				Gender

			</h3>

			<hr class="sidebar-border">

			<div class="clearfix"></div>



			<div class="squaredFour">

				<input type="checkbox" value="Male" id="gender1" name="gender" onchange="submitSearch()"

					{{ isset($_GET['gender']) && ($_GET['gender'] == 'Male') ? 'checked' : '' }} />

				<label for="gender1"></label>

				Male ({{ count(App\Models\CandidateProfile::where('gender', 'Male')->get()) }})

			</div>



			<div class="squaredFour">

				<input type="checkbox" value="Female" id="gender2" name="gender" onchange="submitSearch()"

					{{ isset($_GET['gender']) && ($_GET['gender'] == 'Female') ? 'checked' : '' }} />

				<label for="gender2"></label>

				Female ({{ count(App\Models\CandidateProfile::where('gender', 'Female')->get()) }})

			</div>



			<div class="squaredFour">

				<input type="checkbox" value="Both" id="gender3" name="gender" onchange="submitSearch()"

					{{ isset($_GET['gender']) && ($_GET['gender'] == 'Both') ? 'checked' : '' }} />

				<label for="gender3"></label>

				Both ({{ count(App\Models\CandidateProfile::where('gender', 'Both')->get()) }})

			</div>



			<div class="squaredFour">

				<input type="checkbox" value="Other" id="gender4" name="gender" onchange="submitSearch()"

					{{ isset($_GET['gender']) && ($_GET['gender'] == 'Other') ? 'checked' : '' }} />

				<label for="gender4"></label>

				Other ({{ count(App\Models\CandidateProfile::where('gender', 'Other')->get()) }})

			</div>



		</div>

	</div> --}}



</form>