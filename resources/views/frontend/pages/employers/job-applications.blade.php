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

				<div class="content__area" data-slug="{{ $slug }}">
					<div class="main-content"></div>
					<div class="loader"></div>
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

<script src="{{ asset('js/job-application.js') }}"></script>

<script>


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

