@extends('frontend.layouts.master')



@section('title')

404 | Page Not Found | Joblrs 

@endsection





@section('stylesheets')



@endsection





@section('content')

<section class="page-not-found-page">

	<div class="container sec-pad">

		<div class="row justify-content-center text-center">

			<div class="col-12">

				<p>

					<img src="{{ asset('public/images/default/404.png') }}" alt="" class="page-not-found-image">

				</p>

				<br>

				<p>

					<span class="text-muted">

						Sorry !! The page you are requested, could not found. You may enter a wrong URL

					</span>

					<br>

					<a href="{{ route('index') }}" class="btn apply-now-button font20"><i class="fa fa-arrow-left"></i> Go Home  </a> 

				</p>

			</div>

		</div>

	</div>

</section>

@endsection





@section('scripts')



@endsection