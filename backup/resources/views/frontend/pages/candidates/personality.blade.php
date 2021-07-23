@extends('frontend.layouts.master-two')



@section('title')

Candidate Personality | {{ App\Models\Setting::first()->site_title }}

@endsection



 



@section('content')

<section class="employer-page sec-pad pt-0">

@if(!empty($personality))

	<div class="container">

		<div class="row mt-5">

			<div class="col-md-3"> 

				<img src="{{ App\Helpers\ReturnPathHelper::getUserImage($user->id) }}" class="img img-fluid" alt="image">

				<div class="single-job-description mt-2">

					<h3 class="text-center">{{ $user->name }}</h3>

					<p class="text-center text-yellow mb-3"> {{ $user->candidate->sector_data->name }}</p>

				</div>

			</div>  

			<div class="col-md-6"> 

				<div class="working-preference-item">

						 <h3 class="font-weight-bold text-uppercase text-yellow" style="font-size: 22px;">{{$personality->title}}</h3>

						 <h4 class="mt-3 font-weight-normal text-capitalize text-secondary" style="font-size: 18px;">{{$personality->sub_title}}</h4>

						 <p class="pt-2 text-muted">{{$personality->description}}</p>

				</div> 

			</div>  

		</div>

		<div class="row mt-5">

		<div class="col-md-6"> 

				<div class="p-3">

					<h3 class="mb-4">Strengths</h3>

					{!! $personality->strengths !!}

				</div>

			</div>  

			<div class="col-md-6"> 

				<div class="p-3">

					<h3 class="mb-4">Weaknesses</h3>

					{!! $personality->weaknesses !!}

				</div>

			</div>  

		</div>

	</div>

	@else

		<h1 class="pt-5 text-center text-warning">You haven't Taken the personality test yet</h1>

	@endif

</section>

@endsection





@section('scripts')



@endsection