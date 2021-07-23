@extends('frontend.layouts.master-two')



@section('title')

Candidates | {{ App\Models\Setting::first()->site_title }}

@endsection





@section('stylesheets')



@endsection





@section('content')

<section class="employer-page sec-pad">

	<div class="container">

		<h5 class="text-theme bold mb-4 float-left">We have found <span class="text-yellow">{{ count($users) }}</span>

			Matches for you </h5>

		@if (Route::is('candidates.search'))

		<div class="float-right">

			<div class="search-criteria">

				<span class="text-theme">

					Search By -

				</span>

				@if (isset($_GET['search']) && $_GET['search'] != '')

				Search -

				<span class="badge badge-primary font16">

					{{ $_GET['search'] }}

				</span>

				@endif

				@if (isset($_GET['category']) && $_GET['category'] != '')

				Category -

				<span class="badge badge-primary font16">

					{{ $_GET['category'] }}

				</span>

				@endif

				@if (isset($_GET['country']) && $_GET['country'] != '')

				City -

				<span class="badge badge-primary font16">

					{{ $_GET['country'] }}

				</span>

				@endif



				@if (isset($_GET['experience']) && $_GET['experience'] != '')

				Experience -

				<span class="badge badge-primary font16">

					{{ $_GET['experience'] }}

				</span>

				@endif

			</div>

		</div>

		@endif

		<div class="clearfix"></div>

		<div class="row">

			<div class="col-md-4">

				<div class="left-sidebar">

					<div class="toggleNav">

						<button class="btn btn-outline-secondary btn-toggle"><i class="fa fa-bars"></i></button>

					</div>

					<div class="toggleNav2">

						<button class="btn btn-outline-secondary btn-toggle"><i class="fa fa-times"></i></button>

					</div>

					<div id="left-sidebar">

						@include('frontend.pages.partials.candidate-search', ['route' => route('candidates.search') ])

					</div>



				</div>

			</div>

			<div class="col-md-8">

				<div class="page-employer">

					<div class="employee-header-section">

						<div class="float-right">

							<span class="text-theme">

								You're watching <span class="count-text">{{ $pageNoText }}</span>

							</span>

						</div>

						<div class="clearfix"></div>

					</div>



					@foreach ($users as $single_user)

					@include('frontend.pages.partials.candidate-single')

					@endforeach



					@if (count($users) == 0)

					<div class="alert alert-danger mt-2">

						<strong>Sorry !!</strong>

						<br>

						<p>We have not found any employee for this query now !!</p>

					</div>

					@endif



					<div class="page-pagination mt-4">

						{{ $users->links() }}

					</div>

				</div>

			</div>

		</div>

	</div>

</section>

@endsection





@section('scripts')

<script>

	$("input:checkbox").on('click', function() {

		var $box = $(this);

		if ($box.is(":checked")) {

			var group = "input:checkbox[name='" + $box.attr("name") + "']";

			$(group).prop("checked", false);

			$box.prop("checked", true);

		} else {

			$box.prop("checked", false);

		}

	});



	function submitSearch(event){

		// alert('Searching');

		 $("#cadidateSearchForm").submit();

	}
	$.urlParam = function (name) {
		var results = new RegExp('[\?&]' + name + '=([^&#]*)')
						.exec(window.location.search);

		return (results !== null) ? results[1] || 0 : false;
	}
	if($.urlParam('category')){
		$('select[name=category]').val($.urlParam('category'));
	$('.selectpicker').selectpicker('refresh');
	}

</script>

@endsection