@if (Route::is('index'))
<div class="home-top header-index">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 px-2">
				<h1 class="top-title  wow fadeInUp custom__title">
				Simplify your search & hiring process,<br>
				Get prescreened candidates to your ATS Dashboard.
				</h1>
				<h2 class="top-description  wow fadeInLeft custom__description text-uppercase">
					Discover
				</h2>
				@include('frontend.pages.partials.search-home', ['route' => route('searches') ])
				<div class="companies-more">
					<div class="row align-items-center">
						<div class="col-lg-7">
							<div class="row">
								<div class="wow slideInLeft col-4 custom__back ">
									<div class=" d-flex align-items-start">
										<span class="icon pr-2">
											<img src="{{ asset('images/new-img/location.png') }}" alt="location">
										</span>
										<span class="counts-more">

												<span class="company-more-name text-uppercase">
												Cities
											</span>
											<span class="count-thing">
												{{ count(App\Models\Country::select('id')->get()) }}
											</span>
										</span>
									</div>
								</div>
								<div class="wow slideInDown col-4 custom__back">
									<div class="d-flex align-items-start">
										<span class="icon pr-2">
										<img src="{{ asset('images/new-img/busket.png') }}" alt="busket">
										</span>
										<span class="counts-more">
											@php
												$companies_count = count(App\User::where('is_company',
												1)->where('status',
												1)->get());
												@endphp
											<span class="company-more-name  text-uppercase">
												{{ $companies_count > 1 ? 'Companies':'Company' }}
											</span>
											<span class="count-thing">
												{{ $companies_count }}
											</span>
										</span>
									</div>
								</div>
								<div class="wow slideInRight col-4  custom__back">
									<div class="d-flex align-items-start">
										<span class="icon pr-2">
										<img src="{{ asset('images/new-img/people.png') }}" alt="people">
										</span>
										<span class="counts-more">
											@php
												$candidate_counts = count(App\User::where('is_company',
												0)->where('status',
												1)->get());
												@endphp
											<span class="company-more-name  text-uppercase">
												{{ $candidate_counts > 1 ? 'Candidates':'Candidate' }}
											</span>
											<span class="count-thing">
												{{ $candidate_counts }}
											</span>

										</span>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-5">
							<img class="img-fluid custom-img-setting" src="{{ asset('images/new-img/banner.png') }}" alt="banners">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>



@elseif(Route::is('searches'))

<div class="home-top">

	<div class="container">

		<div class="row justify-content-center">

			<div class="col-md-10">

				<h3 class="top-title wow fadeInUp mb-3 changes_dynamic_title">

					Find Your Dream Job

				</h3>
				@include('frontend.pages.partials.search', ['route' => route('searches') ])
				<div class="navbar-breadcrumb">

					<ol class="breadcrumb">

						<li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>

						<li class="breadcrumb-item active" aria-current="page">Jobs</li>

					</ol>

				</div>

			</div>

		</div>

	</div>

</div>
@elseif(Route::is('jobs'))

<div class="home-top">

	<div class="container">

		<div class="row justify-content-center">

			<div class="col-md-10">

				<h3 class="top-title wow fadeInUp mb-3 changes_dynamic_title">

					Find Your Dream Job

				</h3>
				<form action="{{ route('jobs.search') }}" method="get">

					<div class="d-flex">
						<div class="job-searchbox">
							<div class="input__search">
								<input type="text" name="job" class="form-control" placeholder="Find Job: title, keywords">
							</div>

							<div class="input__city">
								<input type="text" name="location" class="form-control" placeholder="Where: city">
							</div>
							<div class="custom__search_bar">
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
							<button class="job--advanced-search" type="button"><i class="fa fa-ellipsis-v" aria-hidden="true"></i>
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

								@foreach (App\Models\Experience::orderBy('name', 'asc')->get() as $exp)

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

					</div>

				</form>

				<div class="navbar-breadcrumb">

					<ol class="breadcrumb">

						<li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>

						<li class="breadcrumb-item active" aria-current="page">Jobs</li>

					</ol>

				</div>

			</div>

		</div>

	</div>

</div>
@elseif(Route::is('description') || Route::is('description.search'))

<div class="home-top">

	<div class="container">

		<div class="row justify-content-center">

			<div class="col-md-10">



				<h3 class="top-title wow fadeInUp mb-3 changes_dynamic_title">

					Find perfect Job description

				</h3>

				<form action="{{ route('description.search') }}" method="get">

					<div class="candidate-searchbox py-5">

						<div class="d-md-flex justify-content-center">
							<div class="input w-md-50 w-100">
								<input type="text" name="search" class="form-control"

								placeholder="Enter Job Description Title">
							</div>

							<div class="search">
								<button type="submit" class="ml-4 btn btn-info search-button">

									Search

								</button>

							</div>
						</div>

					</div> <!-- End Searchbox -->

				</form>


				<div class="navbar-breadcrumb">

					<ol class="breadcrumb">

						<li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>

						<li class="breadcrumb-item active" aria-current="page">Job description</li>

					</ol>

				</div>

			</div>

		</div>

	</div>

</div>

@elseif(Route::is('employers.applicants'))

<div class="home-top">

	<div class="container">

		<div class="row justify-content-center">

			<div class="col-md-10">



				<h3 class="top-title wow fadeInUp mb-3">

					List of Applicants

				</h3>

				<div class="navbar-breadcrumb">

					<ol class="breadcrumb">

						<li class="breadcrumb-item"><a href="{{ route('employers.dashboard') }}">Home</a></li>

						<li class="breadcrumb-item active" aria-current="page">Applicants</li>

					</ol>

				</div>

			</div>

		</div>

	</div>

</div>

@elseif(Route::is('employers.listed'))

<div class="home-top">

	<div class="container">

		<div class="row justify-content-center">

			<div class="col-md-10">



				<h3 class="top-title wow fadeInUp mb-3">

					List of Applicants

				</h3>

				<!-- <div class="navbar-breadcrumb">

					<ol class="breadcrumb">

						<li class="breadcrumb-item"><a href="{{ route('employers.dashboard') }}">Home</a></li>

						<li class="breadcrumb-item"><a href="{{ route('employers.dashboard') }}">All Applicants</a></li>

						<li class="breadcrumb-item active" aria-current="page">Applicants</li>

					</ol>

				</div> -->

			</div>

		</div>

	</div>

</div>

@elseif(Route::is('employers.candidate'))

<div class="home-top">

	<div class="container">

		<div class="row justify-content-center">

			<div class="col-md-10">



				<h3 class="top-title wow fadeInUp mb-3">

					List of Candidates

				</h3>

				<!-- <div class="navbar-breadcrumb">

					<ol class="breadcrumb">

						<li class="breadcrumb-item"><a href="{{ route('employers.dashboard') }}">Home</a></li>

						<li class="breadcrumb-item active" aria-current="page">Candidates</li>

					</ol>

				</div> -->

			</div>

		</div>

	</div>

</div>
@elseif(Route::is('team.candidate'))

<div class="home-top">

	<div class="container">

		<div class="row justify-content-center">

			<div class="col-md-12">



				<h3 class="top-title wow fadeInUp mb-3">

					List of Candidates

				</h3>

				 <div class="navbar-breadcrumb">

					<ol class="breadcrumb">

						<li class="breadcrumb-item"><a href="{{ route('team.dashboard') }}">Dashboard</a></li>

						<li class="breadcrumb-item active" aria-current="page">Candidates</li>

					</ol>

				</div>

			</div>

		</div>

	</div>

</div>
@elseif(Route::is('testimonial'))

<div class="home-top">

	<div class="container">

		<div class="row justify-content-center">

			<div class="col-md-12">



				<h3 class="top-title wow fadeInUp mb-3">

					Testimonials

				</h3>

				 <div class="navbar-breadcrumb">

					<ol class="breadcrumb">

						<li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>

						<li class="breadcrumb-item active" aria-current="page">testimonials</li>

					</ol>

				</div>

			</div>

		</div>

	</div>

</div>

@elseif(Route::is('employers.jobs.listed'))

<div class="home-top">

	<div class="container">

		<div class="row justify-content-center">

			<div class="col-md-10">



				<h3 class="top-title wow fadeInUp mb-3">

					List of Jobs

				</h3>
<!--
				<div class="navbar-breadcrumb">

					<ol class="breadcrumb">

						<li class="breadcrumb-item"><a href="{{ route('employers.dashboard') }}">Home</a></li>

						<li class="breadcrumb-item active" aria-current="page">Listed Jobs</li>

					</ol>

				</div> -->

			</div>

		</div>

	</div>

</div>

@elseif(Route::is('employers.total'))

<div class="home-top">

	<div class="container">

		<div class="row justify-content-center">

			<div class="col-md-10">



				<h3 class="top-title wow fadeInUp mb-3">

					List of All Applicants

				</h3>

				<div class="navbar-breadcrumb">

					<ol class="breadcrumb">

						<li class="breadcrumb-item"><a href="{{ route('employers.dashboard') }}">Home</a></li>

						<li class="breadcrumb-item active" aria-current="page">Total Applications</li>

					</ol>

				</div>

			</div>

		</div>

	</div>

</div>
@elseif(Route::is('team.total'))

<div class="home-top">

	<div class="container">

		<div class="row justify-content-center">

			<div class="col-md-10">



				<h3 class="top-title wow fadeInUp mb-3">

					List of All Applicants

				</h3>

				<div class="navbar-breadcrumb">

					<ol class="breadcrumb">

						<li class="breadcrumb-item"><a href="{{ route('team.dashboard') }}">Home</a></li>

						<li class="breadcrumb-item active" aria-current="page">Total Applications</li>

					</ol>

				</div>

			</div>

		</div>

	</div>

</div>

@elseif(Route::is('employers.applicants.edit'))

<div class="home-top">

	<div class="container">

		<div class="row justify-content-center">

			<div class="col-md-10">



				<h3 class="top-title wow fadeInUp mb-3">

					Edit Applicant

				</h3>

				<div class="navbar-breadcrumb">

					<ol class="breadcrumb">

						<li class="breadcrumb-item"><a href="{{ route('employers.dashboard') }}">Home</a></li>

						<li class="breadcrumb-item"><a href="{{ route('employers.applicants') }}">Applicants</a></li>

						<li class="breadcrumb-item active" aria-current="page">Applicants</li>

					</ol>

				</div>

			</div>

		</div>

	</div>

</div>
@elseif(Route::is('jobDescription'))

<div class="home-top">

	<div class="container">

		<div class="row justify-content-center">

			<div class="col-md-10">

				<h3 class="top-title wow fadeInUp mb-3">

					Job Description

				</h3>

				<div class="navbar-breadcrumb">

					<ol class="breadcrumb">

						<li class="breadcrumb-item"><a href="{{ route('employers.dashboard') }}">Home</a></li>

						<li class="breadcrumb-item active" aria-current="page">job Description</l>

					</ol>

				</div>

			</div>

		</div>

	</div>

</div>


@elseif(Route::is('jobs.show'))

<div class="home-top">

</div>



@elseif(Route::is('candidates'))

<div class="home-top">

	<div class="container">

		<div class="row justify-content-center">

			<div class="col-md-10">



				<h3 class="top-title wow fadeInUp mb-3">

					Find Perfect Candidate

				</h3>


				<form action="{{ route('candidates.search') }}" method="get">

					<div class="candidate-searchbox py-5">

						<div class="d-md-flex justify-content-center">
							<div class="input">
								<input type="text" name="search" class="form-control candidate_input"

							placeholder="Enter Job Title, Candidate Name">
							</div>
							<div class="position px-md-4">

								<select name="category" id="category" class="selectpicker" data-live-search="true">

									<option data-icon="fa fa-navicon" value="all">All Positions</option>

									@foreach (App\Models\Category::orderBy('name', 'asc')->get() as $category)

									<option value="{{ $category->slug }}">{{ $category->name }}</option>

									@endforeach

								</select>
							</div>
							<div class="search">
								<button type="submit" class="btn btn-info search-button">

									Search

								</button>

							</div>
						</div>

					</div> <!-- End Searchbox -->

				</form>



				<div class="navbar-breadcrumb">

					<ol class="breadcrumb">

						<li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>



						@if(Route::is('candidates'))

						<li class="breadcrumb-item active" aria-current="page">Candidates</li>

						@endif



					</ol>

				</div>



			</div>

		</div>

	</div>

</div>





@elseif(Route::is('employers'))

<div class="home-top">

	<div class="container">

		<div class="row justify-content-center">

			<div class="col-md-12">



				<h3 class="top-title wow fadeInUp mb-3">

					Find Employer

				</h3>



				<form action="{{ route('employers.search') }}" method="get">
					<div class="candidate-searchbox py-5">
						<div class="d-md-flex justify-content-center">
							<div class="input">
								<input type="text" name="search" class="form-control company__input"

								placeholder="Enter Job Title, Employer Name">
							</div>
							<button type="submit" class="btn btn-info ml-4 search-button">

								Search

							</button>
						</div>

					</div> <!-- End Searchbox -->

				</form>



				<div class="navbar-breadcrumb">

					<ol class="breadcrumb">

						<li class="breadcrumb-item"><a href="{{ route('employers.dashboard') }}">Home</a></li>

						<li class="breadcrumb-item active" aria-current="page">Employers</li>

					</ol>

				</div>



			</div>

		</div>

	</div>

</div>

@elseif(Route::is('exam'))

<div class="home-top">

	<div class="container">

		<div class="row justify-content-center">

			<div class="col-md-10">



				<h3 class="top-title wow fadeInUp mb-3">

					Online Skill Test

				</h3>

				<div class="navbar-breadcrumb">

					<ol class="breadcrumb">

						<li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>

						<li class="breadcrumb-item active" aria-current="page">Skill Test</li>

					</ol>

				</div>

			</div>

		</div>

	</div>

</div>

@elseif(Route::is('personality'))

<div class="home-top">

	<div class="container">

		<div class="row justify-content-center">

			<div class="col-md-10">



				<h3 class="top-title wow fadeInUp mb-3">

					Test your personality

				</h3>

				<div class="navbar-breadcrumb">

					<ol class="breadcrumb">

						<li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>

						<li class="breadcrumb-item active" aria-current="page">Personality Test</li>

					</ol>

				</div>

			</div>

		</div>

	</div>

</div>

@elseif(Route::is('aptitude'))

<div class="home-top">

	<div class="container">

		<div class="row justify-content-center">

			<div class="col-md-10">



				<h3 class="top-title wow fadeInUp mb-3">

					Test your aptitude

				</h3>

				<div class="navbar-breadcrumb">

					<ol class="breadcrumb">

						<li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>

						<li class="breadcrumb-item active" aria-current="page">Aptitude test</li>

					</ol>

				</div>

			</div>

		</div>

	</div>

</div>
@elseif(Route::is('companies'))

@elseif(Route::is('team.companies'))

@elseif(Route::is('company.create'))
@elseif(Route::is('company.show'))

@elseif(Route::is('team.company.show'))

@elseif(Route::is('company.edit'))

@elseif(Route::is('show-result'))

<div class="home-top">

	<div class="container">

		<div class="row justify-content-center">

			<div class="col-md-10">

				<h3 class="top-title wow fadeInUp mb-3">

					Online Skill Test Result

				</h3>

				<div class="navbar-breadcrumb">

					<ol class="breadcrumb">

						<li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>

						<li class="breadcrumb-item active" aria-current="page">Result</li>

					</ol>

				</div>

			</div>

		</div>

	</div>

</div>



@elseif(Route::is('employers.dashboard') || Route::is('teams') || Route::is('team.create') || Route::is('team.dashboard') || Route::is('candidates.dashboard') || Route::is('employers.jobs.posted') ||
 Route::is('team.jobs.posted') ||
Route::is('employers.search.candidates') || Route::is('team.search.candidates') || Route::is('candidates.jobs.favorite') || Route::is('employers.messages') || Route::is('messages') || Route::is('message') || Route::is('team.messages') ||

Route::is('candidates.messages') || Route::is('employers.jobs.applications') || Route::is('team.jobs.applications') ||Route::is('candidates.jobs.applied'))

<!-- -->

@elseif(Route::is('password.request') || Route::is('password.reset'))

<!-- -->



@else

<div class="home-top">

	<div class="container">

		<div class="row justify-content-center">

			<div class="col-md-10">



				<h3 class="top-title wow fadeInUp ">

					@if(Route::is('contacts'))

					Contact Us

					@elseif(Route::is('employers.show'))

					Employer - {{ $user->name }}
					@elseif(Route::is('team.show'))

					Team - {{ $user->name }}

					@elseif(Route::is('candidates.show'))

					Candidate Details

					@elseif(Route::is('candidates.personality'))

					Personality Details

					@elseif(Route::is('public.personality'))

					Personality Details

					@elseif(Route::is('jobs.post'))

					Post A New Job

					@elseif(Route::is('register'))

					Sign Up

					@elseif(Route::is('jobs.search'))

					<span class="changes_dynamic_title">Find Your Dream Job</span>

					@elseif(Route::is('candidates.search'))

					Search Candidates

					@elseif(Route::is('employers.search'))

					Search Employers

					@elseif(Route::is('jobs.categories.show'))

					Jobs in - {{ $category->name }} Category

					@elseif(Route::is('jobs.edit'))

					Edit - {{ $job->title }}



					@elseif(Route::is('terms'))

					Terms and Service



					@elseif(Route::is('privacy'))

					Privacy Policy

					@elseif(Route::is('about_us'))

					About us



					@else

					404 | Page Not Found

					@endif

				</h3>

				@if(Route::is('employers.search'))

				<form action="{{ route('employers.search') }}" method="get">
					<div class="candidate-searchbox py-5">
						<div class="d-md-flex justify-content-center">
							<div class="input">
								<input type="text" name="search" class="form-control company__input"

								placeholder="Enter Job Title, Employer Name">
							</div>
							<button type="submit" class="btn btn-info ml-4 search-button">

								Search

							</button>
						</div>

					</div> <!-- End Searchbox -->

				</form>

				@elseif(Route::is('candidates.search'))

				{{--  @include('frontend.pages.partials.search', ['route' => route('candidates.search') ])  --}}



				<form action="{{ route('candidates.search') }}" method="get">

					<div class="candidate-searchbox py-5">

						<div class="d-md-flex justify-content-center">
							<div class="input pb-2 pb-md-0">
								<input type="text" name="search" class="form-control"

							placeholder="Enter Job Title, Candidate Name">
							</div>
							<div class="position px-md-4">

								<select name="category" id="category" class="selectpicker" data-live-search="true">

									<option data-icon="fa fa-navicon" value="all">All Positions</option>

									@foreach (App\Models\Category::orderBy('name', 'asc')->get() as $category)

									<option value="{{ $category->slug }}">{{ $category->name }}</option>

									@endforeach

								</select>
							</div>
							<div class="search pt-2 pt-md-0">
								<button type="submit" class="btn btn-info search-button w-100 w-md-auto">

									Search

								</button>

							</div>
						</div>

					</div> <!-- End Searchbox -->

				</form>

				@elseif(Route::is('jobs.search'))

				<div class="home-top">

	<div class="container">

		<div class="row justify-content-center">

			<div class="col-md-12">

				<form action="{{ route('jobs.search') }}" method="get">

					<div class="d-flex">
						<div class="job-searchbox">
							<div class="input__search">
								<input type="text" name="job" class="form-control" placeholder="Find Job: title, keywords">
							</div>

							<div class="input__city">
								<input type="text" name="location" class="form-control" placeholder="Where: city">
							</div>
							<div class="custom__search_bar">
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
							<button class="job--advanced-search" type="button"><i class="fa fa-ellipsis-v" aria-hidden="true"></i>
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

								@foreach (App\Models\Experience::orderBy('name', 'asc')->get() as $exp)

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

					</div>

				</form>

			</div>

		</div>

	</div>

</div>
				@else

				<!--bye-->

				@endif



				<div class="navbar-breadcrumb">

					<ol class="breadcrumb">

						<li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>



						@if(Route::is('employers'))

						<li class="breadcrumb-item active" aria-current="page">Employers</li>

						@elseif(Route::is('employers.show'))

						<li class="breadcrumb-item"><a href="{{ route('employers') }}">Employers</a></li>

						<li class="breadcrumb-item active" aria-current="page">{{ $user->name }}</li>


						@elseif(Route::is('team.show'))

						<li class="breadcrumb-item"><a href="{{ route('team.dashboard') }}">Team</a></li>

						<li class="breadcrumb-item active" aria-current="page">{{ $user->name }}</li>



						@elseif(Route::is('candidates.show'))

						<li class="breadcrumb-item"><a href="{{ route('candidates') }}">Candidates</a></li>

						<li class="breadcrumb-item active" aria-current="page">Candidate Details</li>

						@elseif(Route::is('public.personality'))

						<li class="breadcrumb-item active" aria-current="page">Personality Details</li>

						@elseif(Route::is('candidates.personality'))

						<li class="breadcrumb-item"><a href="{{ route('candidates') }}">Candidates</a></li>

						<li class="breadcrumb-item active" aria-current="page">Personality Details</li>

						@elseif(Route::is('contacts'))

						<li class="breadcrumb-item active" aria-current="page">Contact</li>

						@elseif(Route::is('jobs.post'))

						<li class="breadcrumb-item active" aria-current="page">Post a job</li>

						@elseif(Route::is('register'))

						<li class="breadcrumb-item active" aria-current="page">Sign Up</li>

						@elseif(Route::is('jobs.search'))

						<li class="breadcrumb-item active" aria-current="page">Search Jobs</li>

						@elseif(Route::is('candidates.search'))

						<li class="breadcrumb-item active" aria-current="page">Search Candidates</li>

						@elseif(Route::is('employers.search'))

						<li class="breadcrumb-item active" aria-current="page">Search Employers</li>

						@elseif(Route::is('jobs.categories.show'))

						<li class="breadcrumb-item"><a href="{{ route('index') }}">Categories</a></li>

						<li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>

						@elseif(Route::is('jobs.edit'))

						<li class="breadcrumb-item"><a href="{{ route('jobs') }}">Jobs</a></li>

						<li class="breadcrumb-item active" aria-current="page">Edit - {{ $job->title }}</li>

						@elseif(Route::is('terms'))


						<li class="breadcrumb-item active" aria-current="page">Terms and Service</li>

						@elseif(Route::is('privacy'))

						<li class="breadcrumb-item active" aria-current="page">Privacy Policy</li>

						@elseif(Route::is('about_us'))


						<li class="breadcrumb-item active" aria-current="page">About-us</li>

						@else

						<li class="breadcrumb-item active" aria-current="page">404 - Page Not Found</li>

						@endif

					</ol>

				</div>



			</div>

		</div>

	</div>

</div>



@endif
