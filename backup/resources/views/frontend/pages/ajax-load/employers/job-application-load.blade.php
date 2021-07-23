<div class="employer-detail-main">

    <h5 class="text-theme mb-3 mt-4">

        Applications For - <mark><span class="border-left">{{ $job->title }}</span></mark>

    </h5>

    <table class="table table-striped  w-100" style="font-size: 13px !important">
        <thead>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Hired Date</th>
        </thead>
        <tbody>
            <tr>
                <td>{{ $job->created_at }}</td>
                <td>{{ $job->deadline }}</td>
                <td>
                    @foreach($applications as $app)
                        @if($app->hired_at != null)
                            {{ $app->hired_at }}
                            @break
                        @endif
                    @endforeach
                </td>
            </tr>
        </tbody>
    </table>

    <form id="filter_form" class="d-flex justify-content-between align-items-center" action="{{ route('employers.jobs.applications', $job->slug) }}" method="get">
        <input type="hidden" name="export">
        <button type="submit" id="export" class="btn btn-sm btn-info">Export</button>
        @if(!empty($id))
            <a href="{{ route('team.dashboard', $id) }}" class="btn btn-success">Back</a>
        @else
            <a href="{{ route('employers.dashboard') }}" class="btn btn-success">Back</a>
        @endif
    </form>

    <hr>
    @if(count($applications) > 0)
    <div class="table-responsive">
    <table class="table table-hover table-striped" id="dataTable" style="font-size: 13px !important">

        <thead>

            <th style="padding:5px 22px 10px 6px !important">Candidate</th>

            <th style="padding:5px 22px 10px 6px !important">Education</th>

            <th style="padding:5px 22px 10px 6px !important">Experience</th>

            <th style="padding:5px 22px 10px 6px !important">Skill test</th>

            <th style="padding:5px 22px 10px 6px !important">Personality</th>

            <th style="padding:5px 22px 10px 6px !important">Aptitude</th>

            <!-- <th style="padding:5px 22px 10px 6px !important">Expected Salary</th> -->

            <th style="padding:5px 22px 10px 6px !important">CV</th>

            <th style="padding:5px 22px 10px 6px !important" class="sortoff">Cover Letter</th>

            <th style="padding:5px 22px 10px 6px !important">Status</th>

            <th style="padding:5px 22px 10px 6px !important" class="sortoff">Edit</th>
            <th style="padding:5px 22px 10px 6px !important" class="sortoff">contact</th>


        </thead>

        <tbody>

            @foreach ($applications as $application)

            <tr>

                <td>

                <img alt="image" class="d-block text-center" src="{{ App\Helpers\ReturnPathHelper::getUserImage($application->user->id) }}"

                style="width: 30px">



                <a class="text-center" href="#userViewModal{{ $application->id }}" data-toggle="modal" class="text-theme">{{ $application->user->name }}</a>

                    <br>

                    <span class="text-muted font12">

                        Applied {{ $application->created_at->diffForHumans() }}

                    </span>

                </td>

                <td> @if(!empty($education)){{$education->certificate_degree_name}} @else --- @endif</td>

                <td> @if(!empty($experience->experience)){{$experience->experience->name}} @else --- @endif</td>



                @php

                $result = \App\Models\Result::where('job_id', $application->job_id)->where('user_id', $application->user_id)->first();

                @endphp

                @if($result != null)

                <td>{{ $result->result }}</td>

                @else

                <td>---</td>

                @endif



                @php

                $personality_result = \App\Models\PersonalityResult::where('user_id', $application->user_id)->first();

                $personality = \App\Models\Personality::where('title', '=', $personality_result['personality_result'])

                ->select('id','sub_title')->first();

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

                @if ($application->cv != null)

                <a href="{{ $application->cv }}" target="_blank"><i

                    class="fa fa-download"></i> Download</a>

                    @else

                    --

                    @endif

                </td>

                <td>

                    <a href="#coverLetterViewModal{{ $application->id }}" data-toggle="modal"

                    class="btn btn-outline-yellow btn-sm"><span class="fa fa-eye"></span> View</a>

                </td>

                <td>

                    {{ $application->status }}

                </td>

                <td>

                    <div class="float-right">

                            <a href="#editStatusModal{{ $application->id }}" data-toggle="tooltip"  data-placement="top" title="Edit" class="btn btn-outline-secondary"

                                data-toggle="modal"><i class="fa fa-edit"></i></a>

                        </div>

                        <div class="modal fade" id="editStatusModal{{ $application->id }}" tabindex="-1" role="dialog"

                            aria-labelledby="exampleModalLabel" aria-hidden="true">

                            <div class="modal-dialog modal-sm" role="document">

                                <div class="modal-content">

                                    <div class="modal-header">

                                        <h5 class="modal-title" id="exampleModalLabel">Edit Status

                                        </h5>

                                        <button type="button" class="close" data-dismiss="modal"

                                            aria-label="Close">

                                            <span aria-hidden="true">&times;</span>

                                        </button>

                                    </div>

                                    <div class="modal-body" style="text-align: left!important">

                                        <form

                                        action="{{ route('employers.applicants.update', $application->id) }}"

                                        method="post">

                                        @csrf

                                        <div class="row">

                                        <select name="status"

                                            class="form-control app-edit-field col-md-8" required>

                                            <option value="New" {{ $application->status == 'New' ? 'selected' : '' }}>New</option>
                                            <option value="Shortlisted" {{ $application->status == 'Shortlisted' ? 'selected' : '' }}>Shortlisted</option>
                                            <option value="Interview" {{ $application->status == 'Interview' ? 'selected' : '' }}>Interview</option>
                                            <option value="Offered" {{ $application->status == 'Offered' ? 'selected' : '' }}>Offered</option>
                                            <option value="Hired" {{ $application->status == 'Hired' ? 'selected' : '' }}>Hired</option>
                                            <option value="Rejected" {{ $application->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>

                                        </select>
                                        <button type="submit" id="submit" name="submit" class="btn btn-primary btn-app col-md-3">Update</button>
                                        </div>

                                        </form>

                                    </div>

                                </div>

                            </div>

                        </div>


                    <!--

                    =====================================================================================
                    -->

                </td>
                <td>
					<span class="nav-item  " >
						<a href="{!! route('chat',['id'=>$application->user_id]) !!}"
							class="btn-chatter"><i class="fa fa-comment"></i> Chat Now</a>
					</span>
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

            <!--
            ================= profile view modal =========================
            -->

            <div class="modal animated fadeIn" id="userViewModal{{ $application->id }}">

                <div class="modal-dialog modal-md">

                    <div class="modal-content">



                        <!-- Modal Header -->

                        <div class="modal-header">

                            <h4 class="modal-title text-theme font22 bold">User Profile</h4>

                            <button type="button" class="close ml-2"

                            data-dismiss="modal">&times;</button>

                        </div>



                        <!-- Modal body -->

                        <div class="modal-body pb-5">

                            <div class="row">

                                <div class="col-md-3">
                                    <img alt="image" alt="image" class="d-block text-center" src="{{ App\Helpers\ReturnPathHelper::getUserImage($application->user->id) }}" style="max-width: 100% !important;">

                                </div>

                                <div class="col-md-5">
                                    <b>Name:</b><br>
                                    {{ $application->user->name }}
                                    <br>
                                    <b>Email:</b><br>
                                    {{ $application->user->email }}
                                    <br>
                                    <b>Applied For:</b><br>
                                    {{ $job->title }}
                                </div>

                                <div class="col-md-4">
                                    <b>Phone No:</b><br>
                                    @if(!empty($user->phone_no)){{$user->phone_no}} @else --- @endif
                                    <br>
                                    <b>Experience:</b><br>
                                    @if(!empty($experience->experience)){{$experience->experience->name}} @else --- @endif
                                    <br>
                                    <b>Working At:</b><br>
                                    @php

                                    $exps = $application->user->experiences()->orderBy('is_current_job', 'desc')->get();

                                    @endphp

                                    @foreach($exps as $exp)
                                    <span style="font-size: 12px; opacity: 0.7;">{{ $exp->company_name }}</span>
                                    <br>
                                    {{ $exp->job_title }}
                                    <br>
                                    <span style="font-size: 12px; opacity: 0.7;">{{ $exp->start_date }} -
                                    @if ($exp->is_current_job)

                                    Present

                                    @else

                                    {{ $exp->end_date }}

                                    @endif
                                    </span>
                                    @break
                                    @endforeach
                                </div>

                            </div>
                            <hr>
                            <a href="{{ route('candidates.show', $application->user->username) }}" class="btn btn-primary pull-right" target="_blank">View Complete Profile</a>
                        </div>



                    </div>

                </div>

            </div>

            <!--
            ================= profile view end ===========================
            -->

            @endforeach

        </tbody>

    </table>

    </div>
	@else
    <div class="d-flex justify-content-center">
		<p class="mt-4">

			<span class="alert alert-danger">

				Sorry !! No data found !!

			</span>

		</p>
	</div>
	@endif
</div>
