{{-- <div class="header-top">
	<div class="container">
		@if (Auth::check())
		<div class="float-right">
			<div class="top-authentication-links">
				<a href="{{ route('messages') }}">
					<i class="fa fa-envelope"></i> 
					<span class="message-count">
						{{ count(Auth::user()->unread()) }} 
					</span>
					<span class="message__hidden">	New Message</span>
				</a>
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" id="dropdownAccountButton">
					<i class="fa fa-user"></i> {{ 'Account' }}</a>
				<div class="dropdown-menu dropdown-menu-account" aria-labelledby="dropdownAccountButton">
					<a class="dropdown-item dropdown-account-item" href="{{ route('users.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a>
					<a class="dropdown-item dropdown-account-item" target="_blank" href="{{ Auth::user()->is_company ? route('employers.show', Auth::user()->username) : route('candidates.show', Auth::user()->username) }}"><i class="fa fa-user"></i> Profile</a>
					<a class="dropdown-item dropdown-account-item" href="{{ route('logout') }}"
					onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i> Logout</a>
					<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
						@csrf
					</form>
				</div>
			</div>
		</div>
		@else
		<div class="float-right">
			<div class="top-authentication-links">
				<a href="{{ route('register') }}" class="btn-primary">Join Us</a>
				@if (!Route::is('login'))
				<a href="#signInModal" data-toggle="modal" class="btn-secondary">Login</a>
				@endif
			</div>
		</div>
		@endif
		<div class="clearfix"></div>
	</div>
</div> --}}