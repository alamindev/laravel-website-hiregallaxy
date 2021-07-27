<div class="top--nav d-flex d-lg-none">
@guest
			<ul class="navbar-nav w-100 flex-row" >
				<li class="nav-item">
					@if (!Route::is('login'))
						<a href="#signInModal" data-toggle="modal" class="nav-link">Login</a>
					@endif
				</li>
				<li class="nav-item">
					<a href="{{ route('register') }}" class="nav-link">Join Us</a>
				</li>
				<li class="nav-item">
					<a  href="{{ route('jobs.post') }}" class="nav-link" title="post job"> Post a Job</a>
				</li>
			</ul>
			@endguest
</div>
<nav class="new--navbar navbar navbar-expand-lg navbar-dark   sticky-top">
	<div class="container-fluid nav-container">
		@if (Auth::check() && Auth::user()->is_company)
		<div class="control__nav">
			<label for="check" class="mobile--control">
				<button class="fa fa-bars btn btn-primary" id="sidebar_btn"></button>
				<button class="fa fa-close btn btn-danger btn-close-sidebar" id="sidebar_close"></button>
			  </label>
			<a class="navbar-brand" href="{{ route('index') }}">
				<img alt="image" src="{{ asset('images/'.App\Models\Setting::first()->site_logo) }}"

				style="width: 140px;margin-top: 0px;" class="float-left" />
			</a>

		</div>
        @if(Route::currentRouteName() != 'index' && Route::currentRouteName() != 'jobs' && Route::currentRouteName() != 'jobs.show' && Route::currentRouteName() != 'employers'
        && Route::currentRouteName() != 'employers.show' && Route::currentRouteName() != 'candidates' && Route::currentRouteName() != 'candidates.show' && Route::currentRouteName() != 'terms' && Route::currentRouteName() != 'about_us' && Route::currentRouteName() != 'contacts' && Route::currentRouteName() != 'privacy' && Route::currentRouteName() != 'testimonial' && Route::currentRouteName() != 'description' && Route::currentRouteName() != 'jobDescription' && Route::currentRouteName() != 'jobs.categories.show' && Route::currentRouteName() != 'jobs.search' && Route::currentRouteName() != 'description.search' && Route::currentRouteName() != 'candidates.search' && Route::currentRouteName() != 'employers.search' && Route::currentRouteName() != 'searches'

        )
		  <div class="sidebar" id="sidebar">
		  <a href="{{ route('employers.dashboard') }}" class="@if(Route::currentRouteName() == 'employers.dashboard') sidebar--active @endif"><i class="fa fa-desktop"></i><span>Dashboard</span></a>
		  <a href="{{ route('employers.jobs.posted') }}" class="@if(Route::currentRouteName() == 'employers.jobs.posted') sidebar--active @endif"><i class="fa fa-bell"></i><span>My Posted Job</span></a>
		  <!-- <a href="{{ route('employers.applicants') }}"><i class="fa fa-users"></i><span>Applicants</span></a> -->
		  <a href="{{ route('employers.search.candidates') }}" class="@if(Route::currentRouteName() == 'employers.search.candidates') sidebar--active @endif"><i class="fa fa-search"></i><span>Search Cadidates</span></a>
		  <a href="{{ route('messages') }}" class="@if(Route::currentRouteName() == 'messages') sidebar--active @endif"><i class="fa fa-envelope"></i><span>Messages</span></a>

		  <a href="{{ route('employers.show', Auth::user()->username) }}" class="@if(Route::currentRouteName() == 'employers.show') sidebar--active @endif"><i class="fa fa-edit"></i><span>Edit My Profile</span></a>
          <a href="{{ route('question.index') }}" class="@if(Route::currentRouteName() == 'question.index') sidebar--active @endif"><i class="fa fa-question-circle"></i><span>Questions</span></a>
		</div>
        @endif
		@else
		<a class="navbar-brand" href="{{ route('index') }}">
			<img alt="image" src="{{ asset('images/'.App\Models\Setting::first()->site_logo) }}"

			style="width: 140px;margin-top: 0px;" class="float-left" />
		</a>
		  @endif


		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"	aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarResponsive">
			<ul class="navbar-nav ml-auto py-1">
				<li class="nav-item ">
					<a class="nav-link {{ Route::is('index') ? 'nav-link-active' : '' }}" href="{{ route('index') }}">Home<span class="sr-only">(current)</span>
					</a>
				</li>
				<li class="nav-item ">
					<a class="nav-link {{ Route::is('employers') || Route::is('employers.show') ? 'nav-link-active' : '' }}" href="{{ route('employers') }}">Employer</a>
				</li>
				<li class="nav-item">
					<a class="nav-link {{ Route::is('candidates') ? 'nav-link-active' : '' }}" href="{{ route('candidates') }}">Candidates</a>
				</li>
				<li class="nav-item">
					<a class="nav-link {{ Route::is('jobs') || Route::is('jobs.show') ? 'nav-link-active' : '' }}" href="{{ route('jobs') }}">Job</a>
				</li>
				<li class="nav-item">
					<a class="nav-link {{ Route::is('description') || Route::is('description') ? 'nav-link-active' : '' }}" href="{{ route('description') }}">Job Description</a>
				</li>
			</ul>
			@guest
			<ul class="navbar-nav  ml-auto mr-5 d-md-none d-lg-flex" >
				<li class="nav-item">
					<a href="{{ route('register') }}" class="nav-link">Join Us</a>
				</li>
				<li class="nav-item">
					@if (!Route::is('login'))
						<a href="#signInModal" data-toggle="modal" class="nav-link">Login</a>
					@endif
				</li>
			</ul>
			@endguest

			@if (Auth::check())
			<div class="">
				<div class="top-authentication-links custom-auth-links">
					<a class="seen--message py-2" href="javascript:void(0)">
						<i class="fa fa-envelope"></i>
						<span class="message-count">
							{{ count(Auth::user()->unread()) }}
						</span>
						<span class="message__hidden">	New Message</span>
					</a>
					<a href="#" class="dropdown-toggle  py-2" data-toggle="dropdown" id="dropdownAccountButton">
						<img alt="image" src="{{ App\Helpers\ReturnPathHelper::getUserImage(Auth::user()->id) }}" class="account-img">

						 {{ str_limit(Auth::user()->name , $limit = 3, $end = '..') }}</a>
					<div class="dropdown-menu dropdown-menu-account" aria-labelledby="dropdownAccountButton">
						@if(auth()->check() && auth()->user()->type == 1)
							<a class="dropdown-item dropdown-account-item" href="{{ route('team.dashboard', auth()->user()->id) }}"><i class="fa fa-dashboard"></i> Dashboard</a>
							<a class="dropdown-item dropdown-account-item" target="_blank" href="{{ route('team.show', Auth::user()->username) }}"><i class="fa fa-user"></i> Profile</a>
						@else
							<a class="dropdown-item dropdown-account-item" href="{{ route('users.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a>
							<a class="dropdown-item dropdown-account-item" target="_blank" href="{{ Auth::user()->is_company ? route('employers.show', Auth::user()->username) : route('candidates.show', Auth::user()->username) }}"><i class="fa fa-user"></i> Profile</a>
						@endif
						<a class="dropdown-item dropdown-account-item" href="{{ route('logout') }}"
						onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i> Logout</a>
						<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
							@csrf
						</form>
					</div>
				</div>
			</div>
			@else
			<div class="d-md-none d-lg-block">
				<div class="top-authentication-links">
				 	<a class="post-job-button" href="{{ route('jobs.post') }}" title="post job"> Post a Job</a>
				</div>
			</div>
			@endif

		</div>
	</div>
</nav>

