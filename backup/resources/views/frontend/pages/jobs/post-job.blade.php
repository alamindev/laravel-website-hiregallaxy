@extends('frontend.layouts.master')



@section('title')

Post New Job | {{ App\Models\Setting::first()->site_title }}

@endsection





@section('stylesheets')

<style>

	textarea {

		border: none;

	}



	.cke_editable {

		padding: 5px;

		border: 0px !important;

		border-bottom: 1px solid #dfdfdf !important;

		//margin-top: -18px;

	}

	#parsley-id-multiple-skill\[\] {

    position: absolute;

    top: 70px;

}



	div#searchTemplateArea {

		border: 1px solid #dfdfdf;

		padding: 10px;

		margin-top: -17px;

		overflow-y: scroll;

		max-height: 240px;

		position: absolute;

		z-index: 10000;

		background: #eee;

		width: 405px;

	}



	div#searchTemplateArea a {

		border-bottom: 1px solid #9e9e9e57 !important;

		display: block;

		padding: 5px;

		transition: .3s;

	}



	div#searchTemplateArea a:hover {

		background: #6b68e7;

		color: #FFF;

	}



	#title:focus,

	#title:active {

		box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0) !important;

	}



	.post-job-page .form-row strong {

		padding-left: 7px;

	}

</style>

@endsection





@section('content')

<section class="post-job-page sec-pad">

	@php

	$enable_editing = App\Models\Setting::first()->enable_job_editing;

	@endphp



	<div class="container">

		<div class="">

			<div class="row justify-content-center">

				<div class="col-11">

					<form action="{{ route('jobs.store') }}" method="post" enctype="multipart/form-data"

						data-parsley-validate autocomplete="off">

						@csrf



						<div class="card card-body p-0 pt-2 pb-2">

							<div class="row form-group">

								<div class="col-md-4">

									<div id="job__id" class="job__id">

										<div class="job__label">

											Job ID:

										</div>

										<div class="job__number" style="font-weight: bold; margin-left: 5px">{{$job_id}}</div>

									</div>

									<input type="hidden" name="job_id" id="job_id" value="{{$job_id}}">

								</div>

								<div class="@if(auth()->check() && auth()->user()->is_company == 1)col-md-4 @else col-md-8 @endif">
								 	<div class="pr-2"><input type="search" autocomplete="off"
										class="text-center text-theme form-control border-0  mb-3 job__title"

										id="title" name="title" value="{{ old('title') }}" placeholder="Job Title"

										> </div>
								</div>
								@if(auth()->check() && auth()->user()->is_company == 1)
								@php

									if(auth()->user()->is_company == 1 && auth()->user()->type == 1){
										$companies = App\Models\Company::orderBy('created_at','desc')->where('assign_id', auth()->user()->id)->get();
									}else{
										$companies = App\Models\Company::orderBy('created_at','desc')->get();
									}
								@endphp
								<div class="col-md-4">
									<div class="form-group">
										<label for="conpany_id">Company <span class="text-success">(optional)</span></label>
										<select name="company_id" id="conpany_id" class="form-control" value="{{ old('company_id') }}">
											<option value="">Select Company</option>
											@foreach($companies as $company)
												<option value="{{ $company->id }}" >{{ $company->name }}</option>
											@endforeach
										</select>
									</div>
								</div>
								@endif

							</div>





							<div class="form-row">

								<div class="col-md-12 form-group px-2">

									<div class="row">

										<div class="col-md-12">

											<strong>Job Summary</strong>

											@if ($enable_editing)

											<textarea name="job_summery" id="job_summery" rows="3"

												class="template form-control">{{ old('job_summery') }}</textarea>
<div class="job-summery-error"></div>
											@else

											<div id="job_summery" class="ml-2"></div>

											@endif

										</div>

									</div>

								</div>

								<div class="col-md-12 form-group px-2">

									<div class="row">

										<div class="col-md-12">

											<strong>Responsibilities & Duties</strong>



											@if ($enable_editing)

											<textarea name="responsibilities" id="responsibilities"

												name="responsibilities" rows="3"

												class="template form-control">{{ old('responsibilities') }}</textarea>
<div class="responsibilities-error"></div>
											@else

											<div id="responsibilities" class="ml-2"></div>

											@endif

										</div>

									</div>

								</div>

							</div>

							<div class="form-row">

								<div class="col-md-12 form-group px-2">

									<div class="row">

										<div class="col-md-12">

											<strong>Qualification</strong>

											@if ($enable_editing)

											<textarea name="qualification" id="qualification" name="qualification"

												rows="3" class="template form-control">{{ old('qualification') }}</textarea>
<div class="qualification-error"></div>
											@else

											<div id="qualification" class="ml-2"></div>

											@endif

										</div>

									</div>

								</div>

								<div class="col-md-12 form-group px-2">

									<div class="row">

										<div class="col-md-12">

											<strong>Certification</strong>

											@if ($enable_editing)

											<textarea name="certification" id="certification" name="certification"

												rows="3" class="template form-control">{{ old('certification') }}</textarea>
<div class="certification-error"></div>
											@else

											<div id="certification" class="ml-2"></div>

											@endif





										</div>

									</div>

								</div>

							</div>

							<div class="form-row w-100 px-1">
								<div class="col-md-10 form-group">

									<label for="skill">	<strong>Skill</strong></span>

									</label>

									<select multiple name="skills[]" id="skill" class="form-control skill_job_post" disabled>

										  @foreach ($skills as $skill)

										<option value="{{ $skill->id }}">{{ $skill->name }}</option>

										@endforeach

									</select>

								</div>
								<div class="col-md-2 d-flex align-items-center">
									<div class="button-switch mt-4 ml-4">
										<input type="checkbox" id="switch-blue" name="job_skill_check" class="switch job__skill_onoff" />
										<label for="switch-blue" class="lbl-off">Off</label>
										<label for="switch-blue" class="lbl-on">On</label>
									  </div>

								</div>
							</div>

							<div class="form-row">

								<div class="col-md-12 form-group px-2">

									<div class="row">

										<div class="col-md-12">

											<strong>Experience</strong>

											@if ($enable_editing)

											<textarea name="experience" id="experience" name="experience" rows="3"

												class="template form-control">{{ old('experience') }}</textarea>
<div class="experience-error"></div>
											@else

											<div id="experience" class="ml-2"></div>

											@endif

										</div>

									</div>

								</div>
								<div class="col-md-12 form-group px-2" style="margin-bottom: -9px;">

									<div class="row">

										<div class="col-md-12">

											<strong>About Company</strong>

											@if ($enable_editing)

											<textarea name="about_company" id="about_company" name="about_company"

												rows="3" class="template form-control">{{ old('about_company') }}</textarea>
<div class="about-company-error"></div>
											@else

											<div id="about_company" class="ml-2"></div>

											@endif

										</div>

									</div>

								</div>

							</div>

						</div>



						<div class="card card-body p-2" style="margin-top: 50px">

							<div class="row form-group">

								<div class="col-sm-6">

									<div class="d-flex align-items-center pb-3">

										<label  class="m-0"  for="monthly_salary">Salary <span class="required">*</span> <span

											class="text-muted font12">(Monthly Salary)</span>

									</label>
									<div class="d-flex align-items-center">

										<input type="checkbox" name="is_salary_negotiable" id="is_salary_negotiable"

										value="1" class="ml-3 mr-2"> <label class="m-0" for="is_salary_negotiable">(Salary

										Negotiable)</label>
									</div>

									</div>

									<div class="row">

										<div class="col-8">

											<input type="number" id="monthly_salary" name="monthly_salary"
											data-parsley-required-message="Please enter interger value"
												class="form-control" placeholder="Write your expected salary" required
												value="{{ old('monthly_salary') }}"
												min="1">

										</div>

										<div class="col-4 pl-0">

											<select name="salary_currency" class="form-control" id="salary_currency"

												required>

												@foreach ($currencies as $cur)

												<option value="{{ $cur->id }}">{{ $cur->name }}</option>

												@endforeach

											</select>

										</div>

									</div>

								</div>

								<div class="col-sm-6">

									<label for="email " class=" pt-2">Email <span class="required">*</span>

									</label>

									<input type="email" name="email" class="form-control" id="email"

										placeholder="Write job response email"

										value="{{ Auth::check() ? Auth::user()->email : '' }}" required>

								</div>

							</div>



							<div class="row form-group">

								<div class="col-sm-4">
                                    <label for="city">Your Country <span class="required">*</span></label>

                                    <select name="city" id="city" class="form-control country__select" required value="{{ old('city') }}">

                                        <option value="">Select a Country</option>

                                        @foreach (App\Models\City::orderBy('name', 'asc')->get() as $country)

                    					<option value="{{ $country->id }}" >

                    						{{ $country->name }}

                    					</option>
                    					@endforeach

                                    </select>
								</div>

								<div class="col-sm-4">

									<div class="row form-group">

										<input type="hidden" class="form-control" name="location" id="location"

											placeholder="Company/Job Location" value="@if (Auth::check())@if (Auth::user()->is_company){{ Auth::user()->location->street_address }}@endif

														@endif">

										<div class="col-12">

											<label for="location">City <span class="required">*</span></label>

											<select name="country" id="country" class="form-control city__showing" required>

												<option value="">Select a city</option>

												@foreach ($countries as $country)

												<option value="{{ $country->id }}" @php if (Auth::check()){

													if(Auth::user()->is_company && Auth::user()->location->country_id ==

													$country->id){

													echo 'selected';

													}

													}



													@endphp

													>{{ $country->name }}</option>

												@endforeach

											</select>

										</div>

									</div>



								</div>
								<div class="col-sm-4">

									<label for="type_id">Job Type <span class="required">*</span>

									</label>

									<select name="type_id" id="type_id" class="form-control" required>

										<option value="">Select One</option>

										@foreach ($job_types as $j_type)

										<option value="{{ $j_type->id }}">{{ $j_type->name }}</option>

										@endforeach

									</select>

								</div>



							</div>



							<!-- Sector, Segment, Discipline -->

							<div class="row form-group">

								<div class="col-sm-4">

									<label for="category_id">Positions <span class="required">*</span>

									</label>

									<select name="category_id" id="category_id" class="form-control" required>

										<option value="">Select a Position</option>

										@foreach ($categories as $category)

										<option value="{{ $category->id }}">{{ $category->name }}</option>

										@endforeach

									</select>

								</div>



								<div class="col-sm-4">

									<label for="sector_id">Job Sector <span class="required">*</span>

									</label>

									<select name="sector_id" id="sector_id" class="form-control" required>

										<option value="">Select One</option>

										@foreach ($sectors as $sector)

										<option value="{{ $sector->id }}">{{ $sector->name }}</option>

										@endforeach

									</select>

								</div>

								<div class="col-sm-4">

									<label for="segment_id">Employer Type<span class="required">*</span>

									</label>

									<select name="segment_id" id="segment_id" class="form-control" required>

										<option value="">Select One</option>

										@foreach ($segments as $segment)

										<option value="{{ $segment->id }}">{{ $segment->name }}</option>

										@endforeach

									</select>

								</div>



							</div>

							<!-- Sector, Segment, Discipline -->



							<div class="row form-group">

								<div class="col-sm-4">

									<label for="discipline_id">Job Discipline <span class="required">*</span>

									</label>

									<select name="discipline_id" id="discipline_id" class="form-control" required>

										<option value="">Select One</option>

										@foreach ($disciplines as $discipline)

										<option value="{{ $discipline->id }}">{{ $discipline->name }}</option>

										@endforeach

									</select>

								</div>

								<div class="col-sm-4">

									<label for="apply_type_id">Job Nature <span class="required">*</span>

									</label>

									<select name="apply_type_id" id="apply_type_id" class="form-control" required>

										<option value="">Select One</option>

										@foreach ($job_apply_types as $apply_type)

										<option value="{{ $apply_type->id }}">{{ $apply_type->name }}</option>

										@endforeach

									</select>

								</div>



								<div class="col-sm-4">

									<label for="experience_id">Experience <span class="required">*</span>

									</label>

									<select name="experience_id" id="experience_id" class="form-control" required>

										<option value="">Select One</option>

										@foreach ($job_experiences as $exp)

										<option value="{{ $exp->id }}">{{ $exp->name }}</option>

										@endforeach

									</select>

								</div>

							</div>
							<div class="row form-group">
								<div class="col-sm-4">

									<label for="deadline">Application Deadline <span class="required">*</span>

									</label>

									<input type="text" autocomplete="off" name="deadline" class="form-control"

										id="deadline" placeholder="Write application deadline" required>

								</div>

							</div>

						</div>



						<div class="form-group mt-2">

							<div class="form-check">

								<input class="form-check-input" type="checkbox" id="termsCheck" required>

								<label class="form-check-label ml-3" for="termsCheck">

									Accept our <a target="_blank" href="{{ route('terms') }}" class="text-yellow">Terms

										and

										Condition</a> and <a target="_blank" href="{{ route('privacy') }}"

										class="text-yellow">Privacy

										Policy</a>

								</label>

							</div>

						</div>

						@if (Auth::check())

						@if (App\User::userCanPost(Auth::id()))

						<div class="row form-group">

							<div class="col-12">

								<button type="submit" class="btn apply-now-button pt-2 pb-2 font18 updatedjob">

									<i class="fa fa-check"></i> Post Job

								</button>

							</div>

						</div>

						@else

						<div class="row form-group">

							<div class="col-12">

								<a href="#signInModal" data-toggle="modal"

									class="btn btn-primary btn-login pt-2 pb-2 font18">

									Only Employer Can Post ! Login as Employer

								</a>

							</div>

						</div>

						@endif

						@else

						<div class="row form-group">

							<div class="col-12">

								<a href="#signInModal" data-toggle="modal"

									class="btn btn-primary btn-login pt-2 pb-2 font18">

									Please Login to Post

								</a>

							</div>

						</div>

						@endif





					</form>

				</div>

			</div>

		</div>

	</div>

</section>

@endsection





@section('scripts')



<!-- Select2 -->

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

	.select2-container--default.select2-container--focus .select2-selection--multiple {

		border: solid #b9b9b9 1px;

		margin-right: 12px;

	}

</style>

<script>

	$(".select2-title").select2({

		placeholder: "Job Title",

		allowClear: true

	});

	$(this).siblings('.select2-container').find('.select2-selection__placeholder').css('color', '#5553b7');

	$("#skill").select2()



</script>



@include('frontend.pages.jobs.partials.post-job-script-old');

<script>

	$(function() {
		var year = (new Date).getFullYear();
	var month = (new Date).getMonth();
	var date = (new Date).getDate();
		$( "#deadline" ).datepicker({
		format: 'YYYY-MM-DD',
		minDate: new Date(year, month,date),
		changeMonth: true,
      changeYear: true

	});

	});



	$("#is_salary_negotiable").change(function(){



		var monthly_salary = $("#monthly_salary");

		var salary_currency = $("#salary_currency");



		if($(this).is(':checked')){

			monthly_salary.removeAttr('required');

			monthly_salary.attr('disabled', 'true');



			salary_currency.removeAttr('required');

			salary_currency.attr('disabled', 'true');

		}else{

			monthly_salary.removeAttr('disabled');

			monthly_salary.attr('required', 'true');



			salary_currency.removeAttr('disabled');

			salary_currency.attr('required', 'true');

		}

	});



	// Select on the job title and fill the fields from the templates



	var area = $("#searchTemplateArea");


	area.addClass('hidden');



	// $("#title").on('input', function(){

	// 	var search = $("#title").val();

	// 	if(search.length > 0){

	// 		var url = "{{ Url('/') }}"+"/api/templates/"+search;

	// 		var htmlValue = "";



	// 		$.get(url).done(function( data ) {

	// 			// console.log(data.templates);

	// 			if(data.templates.length > 0){

	// 				area.removeClass('hidden');

	// 				for(var i=0; i < data.templates.length; i++){

	// 					htmlValue += `

	// 						<div class='item'>
	// 							<a onClick='selectTemplate(${data.templates[i].id},  "${data.templates[i].name}")' class='pointer border-bottom'>
	// 						 ${data.templates[i].name}</a>
	// 						 </div>
	// 					`;

	// 				}

	// 				area.html(htmlValue);

	// 			}else{

	// 				data = [];

	// 				area.html(htmlValue);

	// 				area.addClass('hidden');

	// 			}





	// 		});

	// 	}else{

	// 		area.addClass('hidden');

	// 	}



	// });
	// function selectTemplate(id, name){

	// 	var area = $("#searchTemplateArea");

	// 	var search = $("#title");



	// 	area.addClass('hidden');

	// 	$("#template_id").val(id);
	// 	$("#title").val(name);


	// }


	// function selectTemplate(id){

	// 	var area = $("#searchTemplateArea");

	// 	var search = $("#title");



	// 	area.addClass('hidden');

	// 	$("#template_id").val(id);



		@if($enable_editing)



		tinymce.init({

			selector:'#job_summery',

			plugins: "{{ config('constants.tiny_plugins') }}",

			toolbar: "{{ config('constants.tiny_toolbar') }}",

			contextmenu: "{{ config('constants.tiny_contextmenu') }}",

			autoresize_bottom_margin: 0,

			image_advtab: true,

			menubar:false,

		  });



		tinymce.init({

			selector:'#responsibilities',

			plugins: "{{ config('constants.tiny_plugins') }}",

			toolbar: "{{ config('constants.tiny_toolbar') }}",

			contextmenu: "{{ config('constants.tiny_contextmenu') }}",

			autoresize_bottom_margin: 0,

			image_advtab: true,

			menubar:false,

		  });



		tinymce.init({

			selector:'#qualification',

			plugins: "{{ config('constants.tiny_plugins') }}",

			toolbar: "{{ config('constants.tiny_toolbar') }}",

			contextmenu: "{{ config('constants.tiny_contextmenu') }}",

			autoresize_bottom_margin: 0,

			image_advtab: true,

			menubar:false,

		  });



		tinymce.init({

			selector:'#certification',

			plugins: "{{ config('constants.tiny_plugins') }}",

			toolbar: "{{ config('constants.tiny_toolbar') }}",

			contextmenu: "{{ config('constants.tiny_contextmenu') }}",

			autoresize_bottom_margin: 0,

			image_advtab: true,

			menubar:false,

		  });



		tinymce.init({

			selector:'#experience',

			plugins: "{{ config('constants.tiny_plugins') }}",

			toolbar: "{{ config('constants.tiny_toolbar') }}",

			contextmenu: "{{ config('constants.tiny_contextmenu') }}",

			autoresize_bottom_margin: 0,

			image_advtab: true,

			menubar:false,

		  });



		tinymce.init({

			selector:'#about_company',

			plugins: "{{ config('constants.tiny_plugins') }}",

			toolbar: "{{ config('constants.tiny_toolbar') }}",

			contextmenu: "{{ config('constants.tiny_contextmenu') }}",

			autoresize_bottom_margin: 0,

			image_advtab: true,

			menubar:false,

		  });

		@endif





	// 	$.post( "{{ route('api.getTemplate') }}", { template_id: id } )

	// 	.done(function( data ) {

	// 		data = JSON.parse(data);

	// 		search.val(data.template.name);

	// 		$('#responsibilities').html('');

	// 		$('#job_summery').html('');

	// 		$('#qualification').html('');

	// 		$('#certification').html('');

	// 		$('#experience').html('');

	// 		$('#about_company').html('');



	// 		@if($enable_editing)

	// 			tinymce.get('job_summery').setContent(data.template.job_summery);

	// 			tinymce.get('responsibilities').setContent(data.template.responsibilities);

	// 			tinymce.get('qualification').setContent(data.template.qualification);

	// 			tinymce.get('certification').setContent(data.template.certification);

	// 			tinymce.get('experience').setContent(data.template.experience);

	// 			tinymce.get('about_company').setContent(data.template.about_company);

	// 		@endif



	// 		  $('#responsibilities').html(data.template.responsibilities);

	// 		  $('#job_summery').html(data.template.job_summery);

	// 		  $('#qualification').html(data.template.qualification);

	// 		  $('#certification').html(data.template.certification);

	// 		  $('#experience').html(data.template.experience);

	// 		  $('#about_company').html(data.template.about_company);



	// 		  /** Segment, Sector, Discipline **/

	// 		  $('#segment_id').val(data.template.segment_id);

	// 		  $('#sector_id').val(data.template.sector_id);

	// 		  $('#discipline_id').val(data.template.discipline_id);

	// 	});

	// }



</script>

@endsection

