@extends('frontend.layouts.master-two')



@section('title')

Total Applications | {{ App\Models\Setting::first()->site_title }}

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

                            Total Applications

                        </h5>
                        <a href="{{route('employers.dashboard')}}" class="btn btn-sm btn-success shadow-sm"> <i class="fa fa-arrow-left fa-sm text-white-50"></i> Back</a>
                    </div>

					<hr>
					<div class="table-responsive">
					<table class="table table-hover table-striped col-sm-12" id="candidateTable" style="font-size: 13px !important">

						<thead>

							<th style="padding:5px 22px 10px 6px !important">Candidate Name</th>

							<th style="padding:5px 22px 10px 6px !important">Applied For</th>

							<th style="padding:5px 22px 10px 6px !important">Skill test</th>

							<th style="padding:5px 22px 10px 6px !important">Personality</th>

							<th style="padding:5px 22px 10px 6px !important">Aptitude</th>
{{--
							<th style="padding:5px 22px 10px 6px !important">CV</th> --}}

							<th style="padding:5px 22px 10px 6px !important" class="sortoff">Cover Letter</th>

							<th style="padding:5px 22px 10px 6px !important">Status</th>

						</thead>

						<tbody>

							@foreach ($applicant as $application)

							<tr>

								<td>

								@php

								$cand = \App\Models\CandidateProfile::where('user_id', $application->user_id)->first();

								@endphp
                                    <a href="{{ route('candidates.show', $application->user->name ) }}" target="_blank">

								<img class="d-block text-center" src="{{ App\Helpers\ReturnPathHelper::getUserImage($application->user_id) }}"

								style="width: 30px">



								{{ $application->user->name }}

                                    </a>
								</td>

								<td>

									@php

									$getJob = \App\Models\Job::where('id', $application->job_id)->first();

									@endphp

									{{ $getJob->title }}

								</td>

								@php

								$result = \App\Models\Result::where('job_acitvity_id', $application->id)->where('user_id', $application->user_id)->first();

								@endphp

								@if($result != null)

								<td>{{ $result->result }}</td>

								@else

								<td>
                                    <button class="btn btn-success assin_modal" data-id="{{ $application->id }}">Assign</button>
                                </td>

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

										<a href="{{ route('public.personality', $application->user_id)}}" class="mt-1 text-center btn-sm btn btn-outline-yellow"> <i class="fa fa-eye"></i> view</a>

									</div>

								</td>

								@endif

								@php

								$apt = \App\Models\AptitudeResult::where('user_id', $application->user_id)->first();

								@endphp

								@if($apt == null)

								<td>---</td>

								@else

								<td>Completed</td>
								{{-- <td>{{$apt['result']}}</td> --}}

								@endif

								{{-- <td>

								@if ($application->cv != null)

								<a href="{{ $application->cv }}" target="_blank"><i

									class="fa fa-download"></i> Download</a>

									@else

									--

									@endif

								</td> --}}

								<td>

									<a href="#coverLetterViewModal{{ $application->id }}" data-toggle="modal"

									class="btn btn-outline-yellow btn-sm"><span class="fa fa-eye"></span> View</a>

								</td>

								<td>

									{{ $application->status }}

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
        <div class="modal animated fadeIn" id="assign">
            <div class="vertical-alignment-helper">
                <div class="modal-dialog vertical-align-center">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title text-theme font22 bold"> </h4>
                            <button type="button" class="close ml-2"
                            data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body pb-5">
                            <h4 class="text-center">Send link to a candidate to take skill test</h4>
                            <div class="d-flex justify-content-center align-items-center mt-3">
                                <button class="btn btn-info" id="get_link">Get the link</button>
                                <div class=" show-href">
                                    <div class="custom-link"></div>
                                    <div class="copy-btn ml-2">
                                        <i class="fa fa-clone" aria-hidden="true"></i>
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

<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>

<script>

$("#candidateTable").dataTable({
    aoColumnDefs: [{
    bSortable: false,
    aTargets: ["sortoff"]
    }]
});

$('.assin_modal').click(function(){
    $('#assign').modal('show');
    let id = $(this).attr('data-id');
    $('#get_link').attr('data-id',id);
    $('#get_link').show();
    $('.show-href').removeClass('active-href')
})

$('#get_link').click(function(){
    $(this).hide();
    let id = $(this).data('id');
    let href = `https://joblrs.com/exam/home/${id}`;
    $('.custom-link').text(href);
    $('.show-href').addClass('active-href')
})

const copyText = document.querySelector('.copy-btn');

    copyText.addEventListener('click', () => {
        const link =  document.querySelector('.custom-link')
        const selection = window.getSelection();
        const range = document.createRange();
        range.selectNodeContents(link);
        selection.removeAllRanges();
        selection.addRange(range);

        try {
            document.execCommand('copy');
            selection.removeAllRanges();

            const mailId = link.textContent;
            link.textContent = 'Copied!';
            link.classList.add('text-success');

            setTimeout(() => {
                link.textContent = mailId;
                link.classList.remove('text-success');
            }, 1000);
        } catch (e) {
            link.textContent = 'Couldn\'t copy, hit Ctrl+C!';
            link.classList.add('error');

            setTimeout(() => {
                errorMsg.classList.remove('show');
            }, 1200);
        }
    });



</script>

@endsection

