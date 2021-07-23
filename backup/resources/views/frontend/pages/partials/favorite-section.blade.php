<div class="employer-detail-main favorite-job-section">
	<h5 class="text-theme">
		Favorite Jobs
	</h5>
	@foreach ($jobs as $single_job)
	@include('frontend.pages.partials.single-job-search')
	@endforeach

	<div>
		{{ $jobs->links() }}
	</div>

	@if (count($jobs) == 0)
	<p class="mt-4">
		<span class="alert alert-danger">
			Sorry !! No jobs in the favorite job list !!
		</span>
	</p>
	<p class="mt-4">
		<a href="{{ route('jobs') }}" class="btn btn-outline-yellow"><i class="fa fa-search"></i> Browse New Jobs</a>
	</p>
	@endif
</div>