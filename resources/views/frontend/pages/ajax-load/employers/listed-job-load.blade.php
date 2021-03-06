<div class="row mt-4">

    <div class="col-md-12">

        <div class="employer-detail-main">

            <h5 class="text-theme mb-5">

                {{ $status }} Applicants

            </h5>
 
            @if(count($applicant) > 0)
            <div class="table-responsive">
                <table class="table table-hover table-striped col-sm-12" id="dataTable" style="font-size: 13px !important">

                    <thead>

                        <th style="padding:5px 22px 10px 6px !important">Candidate Name</th>

                        <th style="padding:5px 22px 10px 6px !important">Applied For</th>

                        <th style="padding:5px 22px 10px 6px !important">Skill test</th>

                        <th style="padding:5px 22px 10px 6px !important">Personality</th>

                        <th style="padding:5px 22px 10px 6px !important">Aptitude</th>

                        <th style="padding:5px 22px 10px 6px !important">CV</th>

                        <th style="padding:5px 22px 10px 6px !important">Cover Letter</th>

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

                            <img class="d-block text-center" src="{{ App\Helpers\ReturnPathHelper::getUserImage($application->user_id) }}"

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

                            $personality_result = \App\Models\PersonalityResult::where('user_id', $application->user_id)->first();

                            $personality = \App\Models\Personality::where('title', '=', $personality_result['personality_result'])

                            ->select('id','sub_title')->first(); 

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



    </div>

</div>