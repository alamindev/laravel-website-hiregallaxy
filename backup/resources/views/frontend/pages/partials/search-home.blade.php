<div class="row">
	<div class="col-lg-11">
		<form action="{{ $route }}" method="get" class="search__form">
			<div class="form--search">
				<div class="row align-items-center">
					<div class="col-12 col-lg-4">
						<div class="custom-form-group">
							<label for="keyword">Search keywords</label>
							<input type="text" name="job" id="main--search-name"  class="custom-from-control" placeholder="Search keywords">
						</div>
					</div>
					<div class="col-12 col-lg-3">
						<div class="custom-form-group">
							<label for="keyword">Select Categories</label>
							 <select id="category--form" class="custom-from-control">
							 	<option value="job">Jobs</option>
							 	<option value="company">Company</option>
							 	<option value="candidate">Candidate</option>
							 	<option value="job_description">Job description</option>
							 </select>
						</div> 
					</div>
					<div class="col-12 col-lg-3">
						<div class="custom-form-group">
							<label for="keyword">All Location</label>
							 <select name="location" id="location--custom" class="custom-from-control">
							 		<option value="all">All Locations</option> 
							 </select>
						</div> 
					</div>
					<div class="col-12 col-lg-2">
						<button type="submit" class="custom-form-btn">Search <img src="{{ asset('images/new-img/search.png') }}" alt="search image"></button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>