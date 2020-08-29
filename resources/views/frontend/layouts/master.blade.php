<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>@yield('title', App\Models\Setting::first()->site_title)</title>  
	<meta name="csrf_token" content="{!! csrf_token() !!}">
	<!-- link to stylesheets -->
	@include('frontend.partials.styles')
	@stack('stylesheets_stack')
	@yield('stylesheets')
</head>
<body>

	<div id="app">
		{{-- <div id="preloader">
			<div id="preloader-status">&nbsp;</div>
		</div> --}}
		<!-- Header -->
		<div class="">
			<!-- Top Header -->
			<!-- @include('frontend.partials.top-header') -->
			<!-- Top Header -->
			<!-- Navbar -->
			@include('frontend.partials.nav')
			<!-- Navbar -->
			<!-- Home Top -->
			@include('frontend.partials.top-section')
			<!-- Home Top -->
		</div>
		<!-- Header -->
		@if (!Route::is('register'))
		@include('frontend.partials.messages')
		@endif
		<!-- Page -->
		<div class="page-area home-page">
			@yield('content')
		</div>
		<!-- Page -->
		@include('frontend.partials.footer')
	</div> <!-- end footer -->
	<button onclick="topFunction()" id="scroll-btn" title="Scroll to top"><i class="fa fa-chevron-up"></i></button>
	<!-- JS Files -->
	@include('frontend.partials.scripts')
	
	@stack('scripts_stack')
	@yield('scripts')
	<!-- JS Files -->
	<script data-ad-client="ca-pub-5382978051188489" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	<!-- <script data-ad-client="ca-pub-5382978051188489" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script> -->

</body>
</html>