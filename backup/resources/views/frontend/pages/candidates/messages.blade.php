@extends('frontend.layouts.master-two')



@section('title')

Messages | {{ App\Models\Setting::first()->site_title }}

@endsection



@section('stylesheets')

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">

@endsection



@section('content')

<section class="employer-page sec-pad pt-0">

	<div class="container">

		<div class="row mt-4">

			<div class="col-md-8">

				@include('frontend.pages.partials.message-section')

			</div>

			<div class="col-md-4">

				@include('frontend.pages.partials.candidates-sidebar')

			</div>

		</div>

</section>

@endsection





@section('scripts')

<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>

<script>

	$("#dataTable").dataTable();

		$("#dataTable1").dataTable();

</script>

@endsection