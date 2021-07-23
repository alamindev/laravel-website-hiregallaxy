<div class="employer-detail-sidebar">

	<div style="width:100%;text-align:center;"><img alt="image" src="{{ App\Helpers\ReturnPathHelper::getUserImage($user->id) }}" class="img" style="height:150px;"></div>

	<div class="single-job-description mt-2">

		<h3>{{ $user->name }}</h3>

		<p class="text-yellow mb-3"> {{ $user->candidate ?$user->candidate->sector_data ? $user->candidate->sector_data->name : '' :"" }}</p>

	</div>

	<div class="user-sidebar">

		<div class="list-group">

			<a href="{{ route('candidates.dashboard') }}" class="list-group-item list-group-item-action {{ Route::is('candidates.dashboard') ? 'active' : '' }}">

				<i class="fa fa-dashboard"></i> Dashboard

			</a>



			<a href="{{ route('candidates.jobs.applied') }}" class="list-group-item list-group-item-action {{ Route::is('candidates.jobs.applied') ? 'active' : '' }}">

				<i class="fa fa-bell"></i> My Applied Jobs

			</a>



			<a href="{{ route('candidates.jobs.favorite') }}" class="list-group-item list-group-item-action {{ Route::is('candidates.jobs.favorite') ? 'active' : '' }}">

				<i class="fa fa-heart"></i> My Favorite Jobs

			</a>



			<a href="{{ route('messages') }}" class="list-group-item list-group-item-action {{ Route::is('candidates.messages') ? 'active' : '' }}">

				<i class="fa fa-envelope"></i> Messages

			</a>



			<a href="{{ route('candidates.change-password') }}" class="list-group-item list-group-item-action">

				<i class="fa fa-edit"></i> Change Password

			</a>

			<a href="{{ route('candidates.show', $user->username) }}" class="list-group-item list-group-item-action">

				<i class="fa fa-edit"></i> Edit My Profile

			</a>

		</div>

	</div>

</div>
