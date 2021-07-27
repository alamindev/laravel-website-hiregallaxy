@extends('frontend.layouts.master-two')



@section('title')

{{ $status }} Applicants | {{ App\Models\Setting::first()->site_title }}

@endsection



@section('stylesheets')

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">

@endsection



@section('content')


<section class="employer-page sec-pad pt-0">

	<div class="container">

		<div class="row mt-4">

			<div class="col-md-12">

				<div class="employer-detail-main">


<div class="d-flex justify-content-between align-items-center">
   <h5 class="text-theme mb-5">

        {{ $status }} Applicants

    </h5>
    <a href="{{route('employers.dashboard')}}" class="btn btn-sm btn-success shadow-sm"> <i
            class="fa fa-arrow-left fa-sm text-white-50"></i> Back</a>
</div>
					<hr>
					<div class="table-responsive">
					<table class="table table-hover table-striped col-sm-12" id="dataTable" style="font-size: 13px !important">

						<thead>

							<th style="padding:5px 22px 10px 6px !important">Candidate Name</th>

							<th style="padding:5px 22px 10px 6px !important">Applied For</th>

							<th style="padding:5px 22px 10px 6px !important">Skill test</th>

							<th style="padding:5px 22px 10px 6px !important">Personality</th>

							<th style="padding:5px 22px 10px 6px !important">Aptitude</th>

							<th style="padding:5px 22px 10px 6px !important" class="sortoff">Cover Letter</th>

							<th style="padding:5px 22px 10px 6px !important">Status</th>

							<th style="padding:5px 22px 10px 6px !important">{{ $status=='New' ? 'Applied' : $status }} on</th>

						</thead>

						<tbody>

							@foreach ($applicant as $application)

							<tr>

								<td>

								@php

								$cand = \App\Models\CandidateProfile::where('user_id', $application->user_id)->first();

								@endphp

								<img alt="image" class="d-block text-center" src="{{ App\Helpers\ReturnPathHelper::getUserImage($application->user_id) }}"

								style="width: 30px">


								<a class="text-center" href="{{ route('candidates.show', $application->user->username)}}" target="_blank" class="text-theme">{{ $application->user->name }}</a>


								</td>

								<td>

									@php

									$getJob = \App\Models\Job::where('id', $application->job_id)->first();

									@endphp

									<a href="{{ route('jobs.show', $getJob->slug) }}" target="_blank" style="text-decoration: none; color: #000;">{{ $getJob->title }}</a>

								</td>

								@php

								$result = \App\Models\Result::where('job_id', $application->job_id)->where('user_id', $application->user_id)->first();

								@endphp

								@if($result != null)

								<td>{{ $result->result }}</td>

								@else

								<td>---</td>

								@endif



								@php
$personality = '';
								$personality_res = \App\Models\PersonalityResult::where('user_id', $application->user_id)->first();
if($personality_res != ""){
$personality = \App\Models\Personality::where('title', '=', $personality_res['personality_result'])

->select('id','sub_title')->first();
}

								@endphp

								@if($personality == null)

								<td>---</td>

								@else

								<td>{{$personality['sub_title']}}

									<div class="d-flex justify-content-center">

										<a target="_blank" href="{{ route('public.personality', $application->user_id)}}" class="mt-1 text-center btn-sm btn btn-outline-yellow"> <i class="fa fa-eye"></i> view</a>

									</div>

								</td>

								@endif

								@php

								$apt = \App\Models\AptitudeResult::where('user_id', $application->user_id)->first();

								@endphp

								@if($apt == null)

								<td>---</td>

								@else

								<td>{{$apt['result']}}</td>

								@endif



								<td>

									<a href="#coverLetterViewModal{{ $application->id }}" data-toggle="modal"

									class="btn btn-outline-yellow btn-sm"><span class="fa fa-eye"></span> View</a>

								</td>

								<td>

									{{ $application->status }}

								</td>

								<td>

									@if($status == 'Hired')

										{{ $application->hired_at }}

									@elseif($status == 'Rejected')

										{{ $application->rejected_at }}

									@elseif($status == 'Shortlisted')

										{{ $application->shortlisted_at }}

									@elseif($status == 'Interviewed')

										{{ $application->interviewed_at }}

									@else

										{{ $application->created_at }}

									@endif

								</td>

							</tr>

							<div class="modal animated fadeIn" id="coverLetterViewModal{{ $application->id }}">

								<div class="modal-dialog modal-lg">

									<div class="modal-content">



										<!-- Modal Header -->

										<div class="modal-header">

											<h4 class="modal-title text-theme font22 bold">View Cover Ltter</h4>

											<button type="button" class="close ml-2"

											data-dismiss="modal">&times;</button>

										</div>



										<!-- Modal body -->

										<div class="modal-body pb-5">

											{!! $application->cover_letter !!}

										</div>



									</div>

								</div>

							</div>

							@endforeach

						</tbody>

					</table>
					</div>

				</div>



			</div>

		</div>

	</section>

@endsection





@section('scripts')

<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>

<script>

$("#dataTable").dataTable({
aoColumnDefs: [{
bSortable: false,
aTargets: ["sortoff"]
}]
});

$(function() {

	$( ".datepicker" ).datepicker({

		dateFormat: 'yy-mm-dd'

	});

});


</script>

@endsection

