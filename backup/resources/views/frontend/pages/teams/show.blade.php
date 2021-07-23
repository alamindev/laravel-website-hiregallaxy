@extends('frontend.layouts.master-two')



@section('title')

Team - {{ $user->name }} | {{ App\Models\Setting::first()->site_title }}

@endsection



@section('stylesheets')



@endsection



@section('content')

<section class="employer-page sec-pad">

	<div class="container">

		<div class="header-company-profile">

			<div class="row justify-content-center">

				<div class="col-md-10">

					<div class="row">

						<div class="col-sm-3 text-center mb-4">

							<img src="{{ App\Helpers\ReturnPathHelper::getUserImage($user->id) }}"

								class="img img-fluid rounded-circle" alt="image">

						</div>

						<div class="col-sm-9">

							<div class="text-center text-sm-left ">

								<div class="single-job-description">

									<h3>{{ $user->name }}</h3>

									<div class="float-right">

										@if (Auth::check() && Auth::id() == $user->id)

										<div class="float-right">

											<a href="#editProfileModal" class="btn btn-outline-secondary"

												data-toggle="modal"><i class="fa fa-edit"></i></a>

										</div>

										<div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog"

											aria-labelledby="exampleModalLabel" aria-hidden="true">

											<div class="modal-dialog modal-lg" role="document">

												<div class="modal-content">

													<div class="modal-header">

														<h5 class="modal-title" id="exampleModalLabel">About Yourself

														</h5>

														<button type="button" class="close" data-dismiss="modal"

															aria-label="Close">

															<span aria-hidden="true">&times;</span>

														</button>

													</div>

													<div class="modal-body" style="text-align: left!important">

														<form

															action="{{ route('team.profile.update', $user->id) }}"

															method="post" data-parsley-validate

															enctype="multipart/form-data">

															@csrf

															<div class="row form-group">

																<div class="col-md-6">

																	<label for="name">Company Name <span

																			class="required">*</span></label>

																	<input type="text" name="name" id="name"

																		class="form-control" required

																		value="{{ $user->name }}" />

																</div>

																<div class="col-md-6">

																	<label for="profile_picture">Company Profile Picture

																		<span class="text-info font12">

																			optional</span></label>

																	<input type="file" name="profile_picture"

																		id="profile_picture" class="form-control" />

																</div>

															</div>





															<div class="row form-group">
																<div class="col-md-6">

																	<label for="phone_no">Phone No <span

																			class="text-info font12">

																			optional</span></label>

																	<input type="text" name="phone_no" id="phone_no"

																		class="form-control"

																		value="{{ $user->phone_no }}" />

																</div>

																<div class="col-md-6">

																	<label for="website">Website <span

																			class="text-info font12">

																			optional</span></label>

																	<input type="url" name="website" id="website"

																		class="form-control"

																		value="{{ $user->website }}" />

																</div>


 


															</div>



															<div class="row form-group">

																



																<div class="col-md-6">

																	<label for="establish_date">Established Date <span

																			class="text-info font12">

																			optional</span></label>

																	<input type="date" name="establish_date"

																		id="establish_date" class="form-control"

																		value="{{ $user->company->establish_date }}" />

																</div>



																<div class="col-md-6">

																	<label for="team_member">Team Size <span

																			class="text-info font12">

																			optional</span></label>

																	<select name="team_member" id="team_member"

																		class="form-control">

																		@foreach (App\Models\TeamSize::get() as $team)

																		<option value="{{ $team->id }}"

																			{{ $user->company->team_member == $team->id ? 'selected' : '' }}>

																			{{ $team->name }}</option>

																		@endforeach

																	</select>

																</div>

															</div>



															<div class="row form-group border-top pt-3 mt-3">

																<div class="col-md-12">

																	<h5 class="text-center">Social Links</h5>

																</div>

																<div class="col-md-6">

																	<label for="sector">Facebook <span

																			class="text-info font12">

																			optional</span></label>

																	<input type="url" name="facebook_link"

																		id="facebook_link" class="form-control"

																		value="{{ $user->facebook_link }}" />

																</div>

																<div class="col-md-6">

																	<label for="linkedin_link">LinkedIn <span

																			class="text-info font12">

																			optional</span></label>

																	<input type="url" name="linkedin_link"

																		id="linkedin_link" class="form-control"

																		value="{{ $user->linkedin_link }}" />

																</div>



																<div class="col-md-6">

																	<label for="twitter_link">Twitter <span

																			class="text-info font12">

																			optional</span></label>

																	<input type="url" name="twitter_link"

																		id="twitter_link" class="form-control"

																		value="{{ $user->twitter_link }}" />

																</div>



																<div class="col-md-6">

																	<label for="google_plus_link">Google Plus <span

																			class="text-info font12">

																			optional</span></label>

																	<input type="url" name="google_plus_link"

																		id="google_plus_link" class="form-control"

																		value="{{ $user->google_plus_link }}" />

																</div>

															</div>



															<p class="text-left">

																<button type="submit" class="btn btn-outline-success"><i

																		class="fa fa-check"></i> Save</button>

															</p>

														</form>

													</div>

												</div>

											</div>

										</div>

										@endif

									</div>

								 

									<p>

										<span class="ml-2">

											<i class="fa fa-map-marker location-icon"></i> 
											{{ $user->location->country->name }}

										</span>

										<span class="ml-2">

											<a href="{{ $user->website }}" target="_blank" class="text-link"><i

													class="fa fa-globe"></i> {{ $user->website }}</a>

										</span>

									</p>

									<p>

										<span class="mr-2">

											<i class="fa fa-envelope"></i> {{ $user->email }}

										</span>

										@if (!is_null($user->phone_no))

										<span class="ml-2">

											<i class="fa fa-phone"></i> {{ $user->phone_no }}

										</span>

										@endif



									</p>

									<div class="mt-3">

										<div class="footer-social">

											<a href="{{ $user->facebook_link }}"><i

													class="fa fa-facebook facebook-icon"></i></a>

											<a href="{{ $user->twitter_link }}"><i

													class="fa fa-twitter twitter-icon"></i></a>

											<a href="{{ $user->googple_plus_link }}"><i

													class="fa fa-google-plus google-plus-icon"></i></a>

											<a href="{{ $user->linkedin_link }}"><i

													class="fa fa-linkedin linkedin-icon"></i></a>

										</div>

									</div>



								</div>

							</div>

						</div>

					</div>

				</div>

			</div>



		</div>


 
	</div>

</section>

@endsection





@section('scripts')

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<style>

	.select2-container .select2-selection--single {

		height: 35px;

	}



	#s2id_title .select2-default {

		color: green !important;

	}



	.select2-container {

		text-align: center;

		min-width:320px;

	}



	.select2-container--default .select2-selection--single {

		border: none;

		border-bottom: 1px solid #5553b7;

		border-radius: 0px;

	}



	.select2-container--default .select2-selection--single .select2-selection__rendered {

		color: #5553b7;

		font-weight: bold;

	}



	.select2-container--default .select2-selection--multiple {

		background-color: white;

		border: 1px solid #aaa;

		border-radius: 4px;

		cursor: text;

		/*min-width: 767px;*/

	}



	.badge-category {

		color: #FFF;

		background-color: #ff7c39;

		font-weight: normal;

		font-size: 15px;

	}



	.badge-category:hover {

		color: #FFF;

	}

</style>

<script>

	$(".select2").select2();

</script>

@endsection