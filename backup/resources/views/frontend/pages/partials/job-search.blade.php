<form action="{{ $route }}" method="get" id="jobSearchForm">
	<input type="hidden" name="job">
	<div class="sidebar-widget"> 
		<div class="sidebar-list-item">
	
			<h3>

				Jobs  By Country

			</h3>

			<hr class="sidebar-border">

			<div class="clearfix"></div>



			<select name="country" onchange="submitSearch()" id="country" class="selectpicker" data-live-search="true">

				<option data-icon="fa fa-map-marker" value="all">All Countries</option> 

				@foreach (App\Models\City::orderBy('name', 'asc')->get() as $country)

				<option value="{{ $country->name }}"

					{{ isset($_GET['country']) && ($_GET['country'] == $country->name) ? 'selected' : '' }}>

					&nbsp;&nbsp; {{ $country->name }}

					({{ count(App\Models\Job::where('city_id', $country->id)->get()) }})

				</option>

				@endforeach 

			</select>

		</div>
	</div> 
	<div class="sidebar-widget"> 
		<div class="sidebar-list-item">
	
			<h3>

				Jobs  By City

			</h3>

			<hr class="sidebar-border">

			<div class="clearfix"></div>

			<div class="load__select_country">

			<select name="cities" onchange="submitSearch()" id="cities" class="selectpicker" data-live-search="true">

				<option data-icon="fa fa-map-marker" value="all">All Locations</option>

				@foreach (App\Models\State::orderBy('name', 'asc')->get() as $state)

				<option value="" disabled style="font-weight: bolder;font-size: 16px;">

					{{ $state->name }}

				</option>

				@foreach ($state->cities()->orderBy('name', 'asc')->get() as $countrySingle)

				<option value="{{ $countrySingle->name }}"

					{{ isset($_GET['cities']) && ($_GET['cities'] == $countrySingle->name) ? 'selected' : '' }}>

					&nbsp;&nbsp; {{ $countrySingle->name }}

					({{ count(App\Models\Job::where('status_id', 1)->where('country_id', $countrySingle->id)->get()) }})

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

				Jobs By Positions

			</h3>

			<hr class="sidebar-border"> 
			<div class="load__select_position">
			<div class="my-4">	
				<select name="category" onchange="submitSearch()"  id="category" class="selectpicker" data-live-search="true" >
 
					<option data-icon="fa fa-navicon" value="all">All Positions</option>
	
					@php
						
						$job_category_id =App\Models\Job::select('category_id')->get();

					@endphp
					@foreach (App\Models\Category::whereIn('id', $job_category_id)->orderBy('name', 'asc')->get() as $cat) 
								<option  value="{{ $cat->slug }}" {{ isset($_GET['category']) && ($_GET['category'] == $cat->slug) ? 'checked' : '' }}>	 	{{ $cat->name }}</option>
							 
					@endforeach
	
				</select> 
			</div>
			</div>
			<div class="clearfix"></div> 
		</div>

	</div>






	<!-- Team Size -->

	<div class="sidebar-widget">

		<div class="sidebar-list-item">

			<h3>

				Salary

			</h3>

			<hr class="sidebar-border">

			<div class="clearfix"></div>



			<div class="squaredFour">

				<input type="checkbox" value="0-500" id="salary1" name="salary"

					{{ isset($_GET['salary']) && ($_GET['salary'] == '0-500') ? 'checked' : '' }}

					onchange="submitSearch()" />

				<label for="salary1"></label>

				$0 - $500

			</div>

			<div class="squaredFour">

				<input type="checkbox" value="500-1000" id="salary2" name="salary"

					{{ isset($_GET['salary']) && ($_GET['salary'] == '500-1000') ? 'checked' : '' }}

					onchange="submitSearch()" />

				<label for="salary2"></label>

				$0.5K - $1K

			</div>

			<div class="squaredFour">

				<input type="checkbox" value="1000-2000" id="salary3" name="salary"

					{{ isset($_GET['salary']) && ($_GET['salary'] == '1000-2000') ? 'checked' : '' }}

					onchange="submitSearch()" />

				<label for="salary3"></label>

				$1K - $2K

			</div>

			<div class="squaredFour">

				<input type="checkbox" value="2000-3000" id="salary4" name="salary"

					{{ isset($_GET['salary']) && ($_GET['salary'] == '2000-3000') ? 'checked' : '' }}

					onchange="submitSearch()" />

				<label for="salary4"></label>

				$2K - $3K

			</div>

			<div class="squaredFour">

				<input type="checkbox" value="3000-5000" id="salary5" name="salary"

					{{ isset($_GET['salary']) && ($_GET['salary'] == '3000-5000') ? 'checked' : '' }}

					onchange="submitSearch()" />

				<label for="salary5"></label>

				$3K - $5K

			</div>

			<div class="squaredFour">

				<input type="checkbox" value="5000" id="salary6" name="salary"

					{{ isset($_GET['salary']) && ($_GET['salary'] == '5000') ? 'checked' : '' }}

					onchange="submitSearch()" />

				<label for="salary6"></label>

				$5K+

			</div>



		</div>

	</div>



	<div class="sidebar-widget">

		<div class="sidebar-list-item">

			<h3>

				Job Type

			</h3>

			<hr class="sidebar-border">

			<div class="clearfix"></div>



			@foreach (App\Models\JobType::orderBy('name', 'asc')->get() as $jobTypeSingle)

			<div class="squaredFour">

				<input type="checkbox" value="{{ $jobTypeSingle->name }}" id="type{{ $jobTypeSingle->id }}" name="type"

					onchange="submitSearch()"

					{{ isset($_GET['type']) && ($_GET['type'] == $jobTypeSingle->name) ? 'checked' : '' }} />

				<label for="type{{ $jobTypeSingle->id }}"></label>

				{{ $jobTypeSingle->name }}

				({{ count(App\Models\Job::where('status_id', 1)->where('type_id', $jobTypeSingle->id)->get()) }})

			</div>

			@endforeach



		</div>

	</div>





	<!-- Date Posted -->

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

	({{ count(App\Models\Job::where('status_id', 1)->where('experience_id', $experienceSingle->id)->get()) }})

	</div>

	@endforeach



	</div>

	</div> --}}

</form>