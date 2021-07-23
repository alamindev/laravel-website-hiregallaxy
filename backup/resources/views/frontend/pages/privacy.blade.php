@extends('frontend.layouts.master')

@section('title')
Privacy Policy | HomePage
@endsection

@section('content')

<section class="sec-pad">
	<div class="container">
		<div>
		    {!! $privacy_data !!}
		</div>
	</div>
</section>

@endsection

