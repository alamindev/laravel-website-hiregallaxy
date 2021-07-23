@extends('frontend.layouts.master-two')



@section('title')

Applicants | {{ App\Models\Setting::first()->site_title }}

@endsection



@section('stylesheets')



@endsection



@section('content')
<br>
<section class="employer-page sec-pad pt-0" id="wrapper">

	<div class="container">

		<table class="table table-striped table-bordered table-hover" id="app_list">
			
			<thead>
				
				<tr>
					
					<th>Applicant Name</th>

					<th>Job Title</th>

					<th>Status</th>

					<th>Edit</th>

				</tr>

				<tbody>
					
				@foreach($applicant as $key => $app)
				<tr>
					
					<td>{{ $app->user_name }}</td>

					<td>{{ $app->job_title }}</td>

					<td>{{ $app->status }}</td>

					<td><a class="btn btn-small btn-info" href="{{ route('employers.applicants.edit', $app->id) }}">Edit</a></td>

				</tr>
				@endforeach

				</tbody>

			</thead>

		</table>
		
	</div>
	

</section>

<!-- script for datatables -->
<script type="text/javascript">
	
	$(function()	{
		$('#app_list').DataTable();
	});

</script>

@endsection





@section('scripts')



@endsection