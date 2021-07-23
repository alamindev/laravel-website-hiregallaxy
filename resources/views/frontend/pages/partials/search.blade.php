<form action="{{ $route }}" method="get" class="search__form">

		<div class="d-flex">
			<div class="job-searchbox">  
				<div class="input__search">
					<input type="text" name="job" class="form-control" placeholder="Find Job: title, keyword" value="{{ request()->has('job') ? request()->get('job') : '' }}">
				</div>

				<div class="input__city">
					<input type="text" name="location" class="form-control" placeholder="Location:{{ request()->has('location') ? request()->get('location') : 'all' }} ">
				</div> 
				<div class="custom__search_bar">
					<div class="dropdown" style="display:none;">
						<button class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
							<a class="dropdown-item" data-id="jobs" href="javascript:void(0)">Jobs</a> 
							<a class="dropdown-item" data-id="company" href="javascript:void(0)">Company</a> 
							<a class="dropdown-item" data-id="candidate" href="javascript:void(0)">Candidate</a> 
							<a class="dropdown-item" data-id="job_description" href="javascript:void(0)">Job description</a> 
						</div>
					</div>
					<div class="input__submit">
						<button type="submit"><i class="fa fa-search"></i></button>
					</div>
					<div class="advanced__search_mobile">
						<button class="advanced__search_btn" type="button"><i class="fa fa-ellipsis-v" aria-hidden="true"></i>
						</button>
					</div>
				</div>
			</div> <!-- End Searchbox -->
			<div class="advanced__search">
				<button class="advanced__search_btn" type="button"><i class="fa fa-ellipsis-v" aria-hidden="true"></i>
				</button>
			</div>
		</div>
		<div class="advanced__seach_show">
			<div class="job_search">
				<select name="category" id="category" class="selectpicker" data-live-search="true">

					<option data-icon="fa fa-navicon" value="all">All Postions</option>
	
					@foreach (App\Models\Category::orderBy('name', 'asc')->get() as $category)
	
					<option value="{{ $category->slug }}">{{ $category->name }}</option>
	
					@endforeach
	
				</select>
				<select name="experience" id="experience" class="selectpicker ml-0 ml-md-4 mt-4 mt-md-0" data-live-search="true">
	
					<option data-icon="fa fa-star" value="all">All Experience</option>
	
					@foreach (App\Models\Experience::orderBy('sort', 'asc')->where('status',1)->get() as $exp)
	
					<option value="{{ $exp->slug }}">{{ $exp->name }}</option>
	
					@endforeach
	
				</select>
				<select name="type" id="type" class="selectpicker ml-0 ml-md-4 mt-4 mt-md-0" data-live-search="true">
	
					<option value="all">Select Type</option>
	
					@foreach (App\Models\JobType::orderBy('name', 'asc')->get() as $exp)
	
					<option value="{{ $exp->name }}">{{ $exp->name }}</option>
	
					@endforeach
	
				</select>
				<div class="datepicker">
					<input type="text" name="date" id="datepicker" placeholder="Posted Date">
				</div>
			</div>
			<div class="job_search_candidate">
				<select name="category" disabled id="category" class="selectpicker" data-live-search="true">

					<option data-icon="fa fa-navicon" value="all">All Postions</option>
	
					@foreach (App\Models\Category::orderBy('name', 'asc')->get() as $category)
	
					<option value="{{ $category->slug }}">{{ $category->name }}</option>
	
					@endforeach
	
				</select> 
				<select name="experience"  disabled id="experience" class="selectpicker ml-0 ml-md-4 mt-4 mt-md-0" data-live-search="true">
	
					<option data-icon="fa fa-star" value="all">All Experience</option>
	
					@foreach (App\Models\Experience::orderBy('sort', 'asc')->where('status',1)->get() as $exp)
	
					<option value="{{ $exp->slug }}">{{ $exp->name }}</option>
	
					@endforeach
	
				</select>
			</div>
			<div class="job_search_company">
				<select name="sector[]" disabled id="sector" class="selectpicker" data-live-search="true" multiple>

					<option data-icon="fa fa-navicon" value="all">All Sectors</option>
	
					@foreach (App\Models\Sector::orderBy('name', 'asc')->get() as $sector)
	
					<option value="{{ $sector->id }}">{{ $sector->name }}</option>
	
					@endforeach
	
				</select> 
			</div>
		</div>
	</form> 