@extends('backend.layouts.master')



@section('content')



<!-- Page Heading -->

<div class="d-sm-flex align-items-center justify-content-between mb-4">

	<h1 class="h3 mb-0 text-gray-800">Dashboard</h1>

	{{-- 	<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> --}}

</div>





@if(auth()->user()->hasRole('editor'))

<div class="row">

	@foreach($editor_access as $access) 

	@if($access == 'skill')

		<div class="col-xl-3 col-md-6 mb-4">

			<div class="card border-left-primary shadow pointer h-100 py-2"

				onclick="location.href='{{ route('admin.question.index') }}'">

				<div class="card-body d-flex justify-content-center">

					<img src="{{ asset('images/skill.png') }}" alt="skill Image">

				</div>

			</div>

		</div> 

	@endif

	

  @if($access == 'aptitude')

	<div class="col-xl-3 col-md-6 mb-4">

		<div class="card border-left-primary shadow pointer h-100 py-2"

			onclick="location.href='{{ route('admin.aptitude.index') }}'">

			<div class="card-body d-flex justify-content-center">

				<img src="{{ asset('images/aptitude.png') }}" alt="aptitude Image">

			</div>

		</div>

	</div> 

  @endif

  @if($access == 'personality') 

	<div class="col-xl-3 col-md-6 mb-4">

		<div class="card border-left-primary shadow pointer h-100 py-2"

			onclick="location.href='{{ route('admin.personality.question.index') }}'">

			<div class="card-body d-flex justify-content-center">

				<img src="{{ asset('images/personality.png') }}" alt="personality Image">

			</div>

		</div>

	</div> 

	<div class="col-xl-3 col-md-6 mb-4">

		<div class="card border-left-primary shadow pointer h-100 py-2"

			onclick="location.href='{{ route('admin.personality.index') }}'">

			<div class="card-body d-flex justify-content-center">

				<img src="{{ asset('images/type.png') }}" alt="personality type Image">

			</div>

		</div>

	</div> 

  @endif

	@endforeach



</div>

@endif



@if(auth()->user()->hasRole('super-admin') or auth()->user()->hasRole('admin'))

<!-- Content Row -->

<div class="row">



	<div class="col-xl-3 col-md-6 mb-4">

		<div class="card border-left-primary shadow pointer h-100 py-2"

			onclick="location.href='{{ route('admin.job.index') }}'">

			<div class="card-body">

				<div class="row no-gutters align-items-center">

					<div class="col mr-2">

						<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Jobs</div>

						<div class="h5 mb-0 font-weight-bold text-gray-800">

							{{ ($jobs) }}

						</div>

					</div>

					<div class="col-auto">

						<i class="fas fa-calendar fa-2x text-gray-300"></i>

					</div>

				</div>

			</div>

		</div>

	</div>



	<div class="col-xl-3 col-md-6 mb-4">

		<div class="card border-left-success shadow h-100 py-2 pointer"

			onclick="location.href='{{ route('admin.users.employers') }}'">

			<div class="card-body">

				<div class="row no-gutters align-items-center">

					<div class="col mr-2">

						<div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Employers</div>

						<div class="h5 mb-0 font-weight-bold text-gray-800">

							{{ ($employers) }}

						</div>

					</div>

					<div class="col-auto">

						<i class="fas fa-dollar-sign fa-2x text-gray-300"></i>

					</div>

				</div>

			</div>

		</div>

	</div>



	<div class="col-xl-3 col-md-6 mb-4">

		<div class="card border-left-info shadow h-100 py-2 pointer"

			onclick="location.href='{{ route('admin.users.candidates') }}'">

			<div class="card-body">

				<div class="row no-gutters align-items-center">

					<div class="col mr-2">

						<div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Candidates</div>

						<div class="row no-gutters align-items-center">

							<div class="col-auto">

								<div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">

									{{ ($candidates) }}

								</div>

							</div>

						</div>

					</div>

					<div class="col-auto">

						<i class="fas fa-user fa-2x text-gray-300"></i>

					</div>

				</div>

			</div>

		</div>

	</div>



	<div class="col-xl-3 col-md-6 mb-4">

		<div class="card border-left-warning shadow pointer h-100 py-2"

			onclick="location.href='{{ route('admin.category.index') }}'">

			<div class="card-body">

				<div class="row no-gutters align-items-center">

					<div class="col mr-2">

						<div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Positions</div>

						<div class="h5 mb-0 font-weight-bold text-gray-800">

							{{ ($categories) }}

						</div>

					</div>

					<div class="col-auto">

						<i class="fas fa-th fa-2x text-gray-300"></i>

					</div>

				</div>

			</div>

		</div>

	</div>



</div>



<!-- Content Row -->



<div class="row">
 

<div class="col-xl-3 col-md-6 mb-4">

	<div class="card border-left-success shadow pointer h-100 py-2"

		onclick="location.href='{{ route('admin.templates.index') }}'">

		<div class="card-body">

			<div class="row no-gutters align-items-center">

				<div class="col mr-2">

					<div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Job Templates</div>

					<div class="h5 mb-0 font-weight-bold text-gray-800">

						{{ ($templates) }}

					</div>

				</div>

				<div class="col-auto">

					<i class="fas fa-th fa-2x text-gray-300"></i>

				</div>

			</div>

		</div>

	</div>

</div>
 

<div class="col-xl-3 col-md-6 mb-4">

	<div class="card border-left-warning shadow pointer h-100 py-2"

		onclick="location.href='{{ route('admin.cities.index') }}'">

		<div class="card-body">

			<div class="row no-gutters align-items-center">

				<div class="col mr-2">

					<div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Cities</div>

					<div class="h5 mb-0 font-weight-bold text-gray-800">

						{{ ($cities) }}

					</div>

				</div>

				<div class="col-auto">

					<i class="fas fa-building fa-2x text-gray-300"></i>

				</div>

			</div>

		</div>

	</div>

</div> <!-- Single -->



<div class="col-xl-3 col-md-6 mb-4" style="Display:none;">

	<div class="card border-left-primary shadow pointer h-100 py-2"

		onclick="location.href='{{ route('admin.crawlers.index') }}'">

		<div class="card-body">

			<div class="row no-gutters align-items-center">

				<div class="col mr-2">

					<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Job Crawlers</div>

					<div class="h5 mb-0 font-weight-bold text-gray-800">

						{{ ($crawlers) }}

					</div>

				</div>

				<div class="col-auto">

					<i class="fas fa-users fa-2x text-gray-300"></i>

				</div>

			</div>

		</div>

	</div>

</div> <!-- Single -->





<div class="col-xl-3 col-md-6 mb-4">

	<div class="card border-left-warning shadow pointer h-100 py-2"

		onclick="location.href='{{ route('admin.discipline.index') }}'">

		<div class="card-body">

			<div class="row no-gutters align-items-center">

				<div class="col mr-2">

					<div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Disciplines</div>

					<div class="h5 mb-0 font-weight-bold text-gray-800">

						{{ ($disciplines) }}

					</div>

				</div>

				<div class="col-auto">

					<i class="fas fa-building fa-2x text-gray-300"></i>

				</div>

			</div>

		</div>

	</div>

</div> <!-- Single -->





<div class="col-xl-3 col-md-6 mb-4">

	<div class="card border-left-primary shadow pointer h-100 py-2"

		onclick="location.href='{{ route('admin.sector.index') }}'">

		<div class="card-body">

			<div class="row no-gutters align-items-center">

				<div class="col mr-2">

					<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Sectors</div>

					<div class="h5 mb-0 font-weight-bold text-gray-800">

						{{ ($sectors) }}

					</div>

				</div>

				<div class="col-auto">

					<i class="fas fa-users fa-2x text-gray-300"></i>

				</div>

			</div>

		</div>

	</div>

</div> <!-- Single -->





<div class="col-xl-3 col-md-6 mb-4">

	<div class="card border-left-primary shadow pointer h-100 py-2"

		onclick="location.href='{{ route('admin.segment.index') }}'">

		<div class="card-body">

			<div class="row no-gutters align-items-center">

				<div class="col mr-2">

					<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Employer</div>

					<div class="h5 mb-0 font-weight-bold text-gray-800">

						{{ ($segments) }}

					</div>

				</div>

				<div class="col-auto">

					<i class="fas fa-users fa-2x text-gray-300"></i>

				</div>

			</div>

		</div>

	</div>

</div> <!-- Single -->



<div class="col-xl-3 col-md-6 mb-4">

	<div class="card border-left-warning shadow pointer h-100 py-2"

		onclick="location.href='{{ route('admin.settings.index') }}'">

		<div class="card-body">

			<div class="row no-gutters align-items-center">

				<div class="col mr-2">

					<div class="text-xs font-weight-bold text-black text-uppercase mb-1">

						Settings

					</div>



				</div>

				<div class="col-auto">

					<i class="fas fa-cog fa-2x text-gray-300"></i>

				</div>

			</div>

		</div>

	</div>

</div> <!-- Single -->



<div class="col-xl-3 col-md-6 mb-4">

	<div class="card border-left-success shadow pointer h-100 py-2"

		onclick="location.href='{{ route('admin.account.index') }}'">

		<div class="card-body">

			<div class="row no-gutters align-items-center">

				<div class="col mr-2">

					<div class="text-xs font-weight-bold text-black text-uppercase mb-1">

						Admins

					</div>

					<div class="h5 mb-0 font-weight-bold text-gray-800">

						{{ ($admins) }}

					</div>

				</div>

				<div class="col-auto">

					<i class="fas fa-users fa-2x text-gray-300"></i>

				</div>

			</div>

		</div>

	</div>

</div> <!-- Single -->
<div class="col-xl-3 col-md-6 mb-4">

	<a href="{{ route('admin.contact.index') }}" class="card border-left-success shadow pointer h-100 py-2" >

		<div class="card-body">

			<div class="row no-gutters align-items-center">

				<div class="col mr-2">

					<div class="text-xs font-weight-bold text-black text-uppercase mb-1">

					Contact messages

					</div>

					<div class="h5 mb-0 font-weight-bold text-gray-800">

						{{ \App\Models\Contact::get()->count() }}

					</div>

				</div>

				<div class="col-auto">

					<i class="fas fa-users fa-2x text-gray-300"></i>

				</div>

			</div>

		</div>

	</a>

</div> <!-- Single -->
 

</div>

@endif



@endsection

