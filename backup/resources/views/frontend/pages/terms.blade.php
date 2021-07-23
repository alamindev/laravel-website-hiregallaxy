@extends('frontend.layouts.master')

@section('title')
Terms and Service | HomePage
@endsection

@section('content')

<section class="sec-pad">
	<div class="container">
		<div>
		    {!! $terms_data !!}
		</div>
	</div>
</section>

@endsection

