@extends('frontend.layouts.master-two')



@section('title')

Search Candidates | {{ App\Models\Setting::first()->site_title }}

@endsection



@section('stylesheets')

  <style>

	  .candidate-searchbox .dropdown.bootstrap-select{

		  width: 100% !important;

	  }

	  .candidate-searchbox .keywords{

			border-radius: 50px;

	  }

	   

	  .candidate-searchbox .dropdown-toggle{

			border-radius: 50px;

			border: 1px solid #ced4da

	  }

  </style>



@endsection



@section('content')

<section class="employer-page sec-pad pt-0">

	<div class="container">

		<div class="row mt-4">

			<div class="col-md-12">

				<div class="employer-detail-main favorite-job-section">

					<h5 class="text-theme mb-2">

						Search Candidates

					</h5> 

						<form id="formdata" action="{{Request::fullUrl()}}" method="get">

							<div class="candidate-searchbox">

								<div class="row">

									<div class="col-sm-4 col-xs-4">

										<label>What</label>

										<input type="text" name="keyword" class="form-control keywords" placeholder="Keywords....">

									</div>

									<div class="col-sm-3 col-xs-2">

										<label>Experience</label>

										<select name="experience" id="experience" class="selectpicker" data-live-search="true">

											<option  value="all">All Experience</option>

											@foreach (App\Models\Experience::orderBy('name', 'asc')->get() as $exp)

											<option value="{{ $exp->slug }}">{{ $exp->name }}</option>

											@endforeach

										</select>

									</div> 

									<div class="col-sm-3 col-xs-2">

										<label>Where</label>

									

										<select name="country" id="country" class="selectpicker" data-live-search="true">

											<option  value="all">All Locations</option>

											@foreach (App\Models\State::orderBy('name', 'asc')->get() as $state)

											<option value="" disabled style="font-weight: bolder;font-size: 16px;">

												{{ $state->name }}

											</option>

											@foreach ($state->cities()->orderBy('name', 'asc')->get() as $country)

											<option value="{{ $country->name }}">

												&nbsp; &nbsp;

												{{ $country->name }}

											</option>

											@endforeach

											@endforeach

										</select>

									</div>

									<div class="col-sm-2 col-xs-2 d-flex align-items-end">

										<button type="submit" class="btn btn-info search-button"> 

											Search

										</button>

									</div>

								</div>

							</div> <!-- End Searchbox -->

						</form>

					</form> 

				</div>

				<div class="employer-detail-main favorite-job-section mt-4">

					<h5 class="text-theme mb-2 d-flex justify-content-between">

						<span>Search results</span>

					<span>{{ $results ? count($results[0]) : '0' }} Matches</span>

					</h5>

					<hr>

					@if($find)

						@if (count($results[0]) > 0)

						@foreach ($results[0] as $single_user)

						<div class="single-job-short single-employer">

							<a href="{{ route('candidates.show', $single_user->username) }}" target="_blank"><div class="float-left">

								<img alt="image" class="rounded-circle" src="{{ App\Helpers\ReturnPathHelper::getUserImage($single_user->id) }}">

							</div></a>

							<div class="float-left  ml-2 single-job-description">

								<a href="{{ route('candidates.show', $single_user->username) }}" target="_blank">	<h4>{{ $single_user->name }}

								</h4></a>

								@if($single_user->categories)

								<p class="text-theme mb-2">

									@foreach ($single_user->categories as $catSingleUser)

									@if(!empty($catSingleUser->category->slug))

									<a

										href="{{ route('jobs.categories.show', $catSingleUser->category->slug) }}">{{ $catSingleUser->category->name }}</a>

									 

										@endif

						

									@endforeach

								</p>

								@endif

								<p class="mt-2">

									<span class="">

										<i class="fa fa-map-marker location-icon"></i> {{ $single_user->location->street_address }},

										{{ $single_user->location->country->name }}

									</span>

								</p>

								<p>

									@foreach ($single_user->skills as $sk)

									<span class="mr-2 expertise-tag"

										onclick="location.href='{{ route('jobs.skills.show', $sk->skill->slug) }}'">

										<i class="fa fa-tags mr-2"></i> {{ $sk->skill->name }}

									</span>

									@endforeach

								</p>

							</div>

						 

							<div class="clearfix"></div>

						</div>

						@endforeach

						@if($results[0]->links() != '')

							<div class="bottom">

								<div class="float-right">

									<div class="page-pagination mt-4">

										{{ $results[0]->appends(Illuminate\Support\Facades\Input::except('page'))->links("pagination::bootstrap-4") }}

									</div>

								</div>

								<div class="clearfix"></div>

							</div>

							@endif 

						@else

							<h3 class="text-center">Ops! No result found.</h3>

						@endif

					@endif

					

				</div>

			</div>

		</div>

</section>

@endsection





@section('scripts')

<script>

	$(document).ready(function(){

	 

	})

</script>

@endsection