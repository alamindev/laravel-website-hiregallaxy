@extends('frontend.layouts.master-two')



@section('title')

{{ $status }} Jobs | {{ App\Models\Setting::first()->site_title }}

@endsection



@section('stylesheets')

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">

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

		<div class="navbar-breadcrumb">

			<ol class="breadcrumb">

				<li class="breadcrumb-item"><a href="{{ route('employers.dashboard') }}">Home</a></li>

				<li class="breadcrumb-item"><a href="{{ route('employers.jobs.posted') }}">All Jobs</a></li>

				<li class="breadcrumb-item active" aria-current="page">Applicants</li>

			</ol>

		</div>

		<br>

		<div class="row mt-4">

			<div class="col-md-12">

				<div class="employer-detail-main">

					<h5 class="text-theme">

						{{ $status }} Jobs

					</h5>

<!-- ==========================================================================================================================================
		Data table code for posted jobs
	===========================================================================================================================================
 -->					

 					<hr>
					<div class="table-responsive">
					<table class="table table-hover table-striped col-sm-12" id="dataTable" style="font-size: 13px !important">

						<thead>

							<th style="padding:5px 22px 10px 6px !important">#</th>

							<th style="padding:5px 22px 10px 6px !important">Job Title</th>

							<th style="padding:5px 22px 10px 6px !important">Company/Project</th>

							<th style="padding:5px 22px 10px 6px !important">Job Locations</th>

							<th style="padding:5px 22px 10px 6px !important">Job Posted Date</th>

							<th style="padding:5px 22px 10px 6px !important">Job Deadline Date</th>

							<th style="padding:5px 22px 10px 6px !important">Job Archieved Date</th>

							<th style="padding:5px 22px 10px 6px !important">Status</th>

							<th style="padding:5px 22px 10px 6px !important">Actions</th>

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
									{{ $single_job->location != null ?  $single_job->location : '--' }}
								</td>

								<td>
									{{ $single_job->country->name }}
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

									$timezone = date_default_timezone_get();

									$date = date('Y/m/d H:i:s');

									@endphp

									@if($status == 'Live')
										<p style="background-color: #4BB543; padding: 5px 10px; color: #fff;">Active</p>

									@elseif($single_job->archived == 1)
										<p style="background-color: #0000CD; padding: 5px 10px; color: #fff;">Archived</p>										
									@else
										<p style="background-color: #8B0000; padding: 5px 10px; color: #fff;">In-Progress</p>
									@endif

								</td>

								<td>

									<a href="{{ route('jobs.edit', $single_job->slug) }}" class="btn btn-outline-success" title="Edit Job">

										<i class="fa fa-edit"></i>

									</a>

									<a href="{{ route('employers.jobs.applications', $single_job->slug) }}" class="btn btn-outline-yellow"

										title="View All Applications ({{ count($single_job->activities) }})">

										<i class="fa fa-eye"></i>

										<span class="badge badge-danger">{{ count($single_job->activities) }}</span>

									</a>

									<form method="post" action="{{ route('employers.jobs.delete', $single_job->slug) }}" class="ml-1"

										style="display:inline" onsubmit="return confirm('Are you sure to delete the job permanently ?')">

										@csrf

										<button class="btn btn-outline-danger" type="submit" title="Delete Job" style="border-radius: 20px!important;

										padding: 4px 20px!important">

											<i class="fa fa-trash"></i>

										</button>

									</form>

								</td>

							</tr>

							@php
								$i = $i + 1;
							@endphp

							@endforeach

						</tbody>

					</table>
					</div>

<!-- ==========================================================================================================================================
		Code ends
	===========================================================================================================================================
 -->					

					@if (count($jobs) == 0)

					<p class="mt-4">

						<span class="alert alert-danger">

							Sorry !! No {{ucwords(request()->filter)}} jobs found !!

						</span>

					</p>

					@endif

				</div>



			</div>

		</div>

</section>

@endsection





@section('scripts')

<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>

<script>

$("#dataTable").dataTable();

$(function() {

	$( ".datepicker" ).datepicker({

		dateFormat: 'yy-mm-dd'

	});

});

</script>


@endsection