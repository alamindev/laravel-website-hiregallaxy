@extends('frontend.layouts.master-two')



@section('title')

Edit Applicant | {{ App\Models\Setting::first()->site_title }}

@endsection



@section('stylesheets')



@endsection



@section('content')
<br>
<section class="employer-page sec-pad pt-0" id="wrapper">

	<div class="container">

		<table class="table table-hover table-striped" id="dataTable" style="font-size: 13px !important">

			<thead>

				<th style="padding:5px 22px 10px 6px !important">Candidate ID</th>

				<th style="padding:5px 22px 10px 6px !important">Status</th>


			</thead>

			<tbody>

				@foreach ($applicant as $app)

				<tr>



					<td>

						{{ $app->user_id }}

						</td>

						<td>

							<form

							action="{{ route('employers.applicants.update', $app->id) }}"

							method="post">

							@csrf

							<div class="row">

							<select name="status"

								class="form-control app-edit-field col-md-8" required>

								<option value="Applied" {{ $app->status == 'Applied' ? 'selected' : '' }}>Applied</option>
								<option value="Shortlisted" {{ $app->status == 'Shortlisted' ? 'selected' : '' }}>Shortlisted</option>
								<option value="Interviewed" {{ $app->status == 'Interviewed' ? 'selected' : '' }}>Interviewed</option>
								<option value="Hired" {{ $app->status == 'Hired' ? 'selected' : '' }}>Hired</option>
								<option value="Rejected" {{ $app->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>

							</select>
							<button type="submit" id="submit" name="submit" class="btn btn-primary btn-app col-md-3">Update</button>
							</div>

							</form>

						</td>

					</tr>

					@endforeach

				</tbody>

			</table>
		
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