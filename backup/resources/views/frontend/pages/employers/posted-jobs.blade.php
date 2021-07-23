@extends('frontend.layouts.master-two')



@section('title')

Posted Jobs | {{ App\Models\Setting::first()->site_title }}

@endsection



@section('stylesheets') 
<style type="text/css">

	.mb-4{

		margin-bottom: 4px;

	}

</style>

@endsection



@php

$_filter = request()->filter ?? '';

@endphp



@section('content')

<section class="employer-page sec-pad pt-0">

	<div class="container">

		<div class="row mt-4">

			<div class="col-md-12">

				<div class="row mb-4">

					<div class="col-md-3">

						<div id="posted__jobs"  class="single-dashboard-link card card-default p-3 text-center" >

							<span class="">

								<i class="fa fa-bell font30"></i>							

							</span>

							<h6 class="text-primary">

								{{ $user_jobs_count }} Total Jobs

							</h6>

						</div>

					</div>

					<div class="col-md-3">

						<div id="live__jobs"   class="single-dashboard-link card card-default p-3 text-center">

							<span class="">

								<i class="fa fa-bell font30"></i>							

							</span>

							<h6 class="text-success">

								@php

									$timezone = date_default_timezone_get();

									$date = date('Y/m/d H:i:s');

									$getActiveJobs = \App\Models\Job::where('user_id',$user->id)->where( 'deadline', '>', $date)->get();

								@endphp

								{{ $getActiveJobs->count() }} Live Jobs

							</h6>

						</div>

					</div>

					<div class="col-md-3">

						<div id="progress__jobs"   class="single-dashboard-link card card-default p-3 text-center" 
							>

							<span class="">

								<i class="fa fa-bell font30"></i>							

							</span>

							<h6 class="text-danger">

								@php

									$timezone = date_default_timezone_get();

									$date = date('Y/m/d H:i:s');

									$getInProgressJobs = \App\Models\Job::where('user_id',$user->id)->where( 'deadline', '<', $date)->where('archived',0)->get();

								@endphp

								{{ $getInProgressJobs->count() }} In-progress Jobs

							</h6>

						</div>

					</div>

					<div class="col-md-3">

						<div id="archived__jobs"  class="single-dashboard-link card card-default p-3 text-center">

							<span class="">

								<i class="fa fa-bell font30"></i>							

							</span>

							<h6 class="text-danger">

								@php

									$timezone = date_default_timezone_get();

									$date = date('Y/m/d H:i:s');

									$getArchivedJobs = \App\Models\Job::where('user_id',$user->id)->where('archived',1)->get();

								@endphp

								{{ $getArchivedJobs->count() }} Archived Jobs

							</h6>

						</div>

					</div>

				</div> 

				<div class="content__area">
					<div class="main-content"></div>
					<div class="loader"></div>
				</div>
			</div>

		</div>

</section>

@endsection





@section('scripts')

<script src="{{ asset('js/postjob.js') }}"></script> 

@endsection