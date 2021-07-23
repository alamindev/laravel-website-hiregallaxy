<div class="employer-detail-main">

	<div class="d-flex justify-content-between align-items-center pb-4">
		<h5 class="text-theme">{{ $title ? $title : 'Posted Jobs'}} </h5>
		<a href="{{ route('employers.dashboard') }}" class="btn btn-success">Back</a>
	</div>
	@if(count($jobs) > 0)
	<div class="table-responsive">
		<table class="table table-hover table-striped col-sm-12" id="dataTable" style="font-size: 13px !important">

			<thead>

				<th style="padding:5px 22px 10px 6px !important">#</th>

				<th style="padding:5px 22px 10px 6px !important">Title</th>

				<th style="padding:5px 22px 10px 6px !important">Company/Project</th>

				<th style="padding:5px 22px 10px 6px !important">Locations</th>

				<th style="padding:5px 22px 10px 6px !important">Posted Date</th>

				<th style="padding:5px 22px 10px 6px !important">Deadline Date</th>

				<th style="padding:5px 22px 10px 6px !important">Archieved Date</th>

				<th style="padding:5px 22px 10px 6px !important">Status</th>

				<th style="padding:5px 22px 10px 6px !important" class="sortoff">Actions</th>

			</thead>

			<tbody>

				@php
					$i = 1;
				@endphp

				@foreach ($jobs as  $key => $single_job)

				<tr>

					<td> {{ $i }} </td>

					<td>

						<p class="pointer" onclick="location.href='{{ route('jobs.show', $single_job->slug) }}'">
							{{ $single_job->title }}
						</p>

					</td>

					<td>
						@php
						$company = App\Models\Company::where('id', $single_job->company_id)->first()
					@endphp
					{{ $company ? $company->name : '---'  }}
					</td>

					<td>
						{{ $single_job->country ?$single_job->country->name: ''  }}
					</td>

					<td>
						{{ $single_job->created_at }}
					</td>

					<td>
						{{ $single_job->deadline }}
					</td>

					<td>
						{{ $single_job->archived_at != null ?  $single_job->archived_at : 'Not Archived' }}
					</td>

					<td>

						@php

						$flag = 0;

						$timezone = date_default_timezone_get();

						$date = date('Y/m/d H:i:s');

						$getActiveJobs = \App\Models\Job::where('user_id',$user->id)->where( 'deadline', '>', $date)->get();

						foreach($getActiveJobs as $value => $activeJob){
							if($activeJob->id == $single_job->id){
								$flag = 1;
							}
						}

						@endphp

						@if($flag == 1)
							<p style="background-color: #4BB543; padding: 5px 10px; color: #fff;">Active</p>

						@elseif($single_job->archived == 1)
							<p style="background-color: #0000CD; padding: 5px 10px; color: #fff;">Archived</p>
						@else
							<p style="background-color: #8B0000; padding: 5px 10px; color: #fff;">In-Progress</p>
						@endif

						@php

						$flag = 0;

						@endphp

					</td>

					<td>



						@if(!empty($id))
						<a href="{{ route('team.jobs.applications', [ $user->id, $single_job->slug]) }}" class="btn btn-outline-yellow"

							title="View All Applications ({{ count($single_job->activities) }})">

							<i class="fa fa-eye"></i>

							<span class="badge badge-danger">{{ count($single_job->activities) }}</span>

						</a>
						@else
						<a href="{{ route('employers.jobs.applications', $single_job->slug) }}" class="btn btn-outline-yellow"

                            title="View All Applications ({{ count($single_job->activities) }})">

                            <i class="fa fa-eye"></i>

                            <span class="badge badge-danger">{{ count($single_job->activities) }}</span>

                        </a>
						@endif
                        @if (auth()->user()->id == $user->id)
                        <a href="{{ route('jobs.edit', $single_job->slug) }}" class="btn btn-outline-success" title="Edit Job">

                            <i class="fa fa-edit"></i>

                        </a>
                        @endif
						@if (auth()->user()->id == $user->id)
							<form method="post" action="{{ route('employers.jobs.delete', $single_job->slug) }}" class="ml-1"

								style="display:inline" onsubmit="return confirm('Are you sure to delete the job permanently ?')">

								@csrf

								<button class="btn btn-outline-danger" type="submit" title="Delete Job" style="border-radius: 20px!important;

								padding: 4px 20px!important">

									<i class="fa fa-trash"></i>

								</button>

							</form>
						@endif
					</td>

				</tr>

				@php
					$i = $i + 1;
				@endphp

				@endforeach

			</tbody>

		</table>
	</div>
	@else
	<div class="d-flex justify-content-center">
		<p class="mt-4">

			<span class="alert alert-danger">

				Sorry !! No jobs found !!

			</span>

		</p>
	</div>
	@endif

</div>
