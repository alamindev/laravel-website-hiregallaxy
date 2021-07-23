@extends('frontend.layouts.master-two')



@section('title')

Job Application For - {{ $job->title }} | {{ App\Models\Setting::first()->site_title }}

@endsection

 

@section('content')

<section class="employer-page sec-pad pt-0">

	<div class="container">

		<div class="row mt-4">

			<div class="col-md-12">

				<!-- code for quick icons -->

				<div class="d-flex  flex-wrap justify-content-center">

					<div class="item">

						<div class="single-dashboard-link card card-default p-3 text-center" id="all_activity"

							{{-- onclick="location.href='{{ route('employers.listed', ['slug'=>$job->slug,'status'=>'New']) }}'" --}}
							>

							<span class="">

								<i class="fa fa-bell font30"></i>							

							</span>

							<h6 class="text-primary">

								@php

									$new =  \App\Models\JobActivity::where('company_id',$user->id)->where('job_id',$job->id)->get();

								@endphp

								{{ $new->count() }} All

							</h6>

						</div>

					</div>
					<div class="item">

						<div class="single-dashboard-link card card-default p-3 text-center" id="new_activity"

							{{-- onclick="location.href='{{ route('employers.listed', ['slug'=>$job->slug,'status'=>'New']) }}'" --}}
							>

							<span class="">

								<i class="fa fa-bell font30"></i>							

							</span>

							<h6 class="text-primary">

								@php

									$new =  \App\Models\JobActivity::where('company_id',$user->id)->where('job_id',$job->id)->where('status','New')->get();

								@endphp

								{{ $new->count() }} New

							</h6>

						</div>

					</div>

					<div class="item">

						<div class="single-dashboard-link card card-default p-3 text-center" id="short_listed_activity"

							{{-- onclick="location.href='{{ route('employers.listed', ['slug'=>$job->slug,'status'=>'Shortlisted']) }}'" --}}
							>

							<span class="">

								<i class="fa fa-bell font30"></i>							

							</span>

							<h6 class="text-success">

								@php

									$short =  \App\Models\JobActivity::where('company_id',$user->id)->where('job_id',$job->id)->where('status','Shortlisted')->get();

								@endphp

								{{ $short->count() }} Shortlisted

							</h6>

						</div>

					</div>

					<div class="item">

						<div class="single-dashboard-link card card-default p-3 text-center" id="interview_activity"

							{{-- onclick="location.href='{{ route('employers.listed', ['slug'=>$job->slug,'status'=>'Interview']) }}'" --}}
							>

							<span class="">

								<i class="fa fa-bell font30"></i>							

							</span>

							<h6 class="text-danger">

								@php

									$interview =  \App\Models\JobActivity::where('company_id',$user->id)->where('job_id',$job->id)->where('status','Interview')->get();

								@endphp

								{{ $interview->count() }} Interview

							</h6>

						</div>

					</div>

					<div class="item">

						<div class="single-dashboard-link card card-default p-3 text-center" id="offered_activity"

							{{-- onclick="location.href='{{ route('employers.listed', ['slug'=>$job->slug,'status'=>'Offered']) }}'" --}}
							>

							<span class="">

								<i class="fa fa-bell font30"></i>							

							</span>

							<h6 class="text-danger">

								@php

									$offered =  \App\Models\JobActivity::where('company_id',$user->id)->where('job_id',$job->id)->where('status','Offered')->get();

								@endphp

								{{ $offered->count() }} Offered

							</h6>

						</div>

					</div>

					<div class="item">

						<div class="single-dashboard-link card card-default p-3 text-center" id="hired_activity"

							{{-- onclick="location.href='{{ route('employers.listed', ['slug'=>$job->slug,'status'=>'Hired']) }}'" --}}
							>

							<span class="">

								<i class="fa fa-bell font30"></i>							

							</span>

							<h6 class="text-danger">

								@php

									$hired =  \App\Models\JobActivity::where('company_id',$user->id)->where('job_id',$job->id)->where('status','Hired')->get();

								@endphp

								{{ $hired->count() }} Hired

							</h6>

						</div>

					</div>

					<div class="item">

						<div class="single-dashboard-link card card-default p-3 text-center" id="rejected_activity"

							{{-- onclick="location.href='{{ route('employers.listed', ['slug'=>$job->slug,'status'=>'Rejected']) }}'" --}}
							>

							<span class="">

								<i class="fa fa-bell font30"></i>							

							</span>

							<h6 class="text-danger">

								@php

									$rejected =  \App\Models\JobActivity::where('company_id',$user->id)->where('job_id',$job->id)->where('status','Rejected')->get();

								@endphp

								{{ $rejected->count() }} Rejected

							</h6>

						</div>

					</div>

				</div>

				<!-- code for quick icons end -->
 
				<div class="content__area" data-slug="{{ $slug }}" data-team="{{ $id }}">
					<div class="main-content"></div>
					<div class="loader"></div>
				</div>
			</div>

		</div>

	</section>

@endsection





@section('scripts')

<script src="{{ asset('js/job-application.js') }}"></script> 

<script> 

// $('#export').click(function(){

// 	$('<input>').attr({

// 	    type: 'hidden',

// 	    id: 'foo',

// 	    name: 'export'

// 	}).appendTo('form');

// 	$('#filter_form').submit();

// });

</script>

@endsection

