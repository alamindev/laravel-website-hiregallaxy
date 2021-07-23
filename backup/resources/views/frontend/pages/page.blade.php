@extends('frontend.layouts.master')

@section('title')
Terms and Service | HomePage
@endsection

@section('content')

<section class="how-work sec-pad">
	<div class="container">
		<h3 class="how-work-title wow fadeInDown">Terms and Service</h3>
		<div>
		    {!! $terms_data !!}
		</div>
	</div>
</section>

@endsection

