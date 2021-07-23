@extends('frontend.layouts.master-two')



@section('title')

Employer Dashboard | {{ App\Models\Setting::first()->site_title }}

@endsection



@section('stylesheets')



@endsection



@section('content')

<section class="employer-page sec-pad pt-0" id="wrapper">

	<div class="container">

		<div class="row">
			<div class="col-md-6">
            <br><br>
				<div class="employer-detail-main">

					<div class="mt-2 mr-0 mr-sm-2">

						<h5 class="text-theme">Change Password</h5>

						<div class="row">

                            <form class="col-md-8" action="{{ 'employer-password-change' }}" method="POST" data-parsley-validate>
                                
                                @csrf
                                
                                <div class="row form-group">
                                
                                    <div class="col-md-12">
                            
                                        <label for="old_password">Old Password <span class="required">*</span></label>
                            
                                        <input type="password" data-parsley-trigger="input" class="form-control"
                                            name="old_password" id="old_password" minlength="8"
                                            placeholder="********" required
                                            data-parsley-required-message="Please write old password">
                                        @if($errors->has('old_password'))
                                        <div class="text-danger">{{ $errors->first('old_password') }}</div>
                                        @endif
                                        
                                    </div>
                                    
                                </div>
                            
                                
                                <div class="row form-group">
                                
                                    <div class="col-md-12">
                            
                                        <label for="new_password">New Password <span class="required">*</span></label>
                            
                                        <input type="password" data-parsley-trigger="input" class="form-control"
                                            name="new_password" id="new_password" minlength="8"
                                            placeholder="********" required
                                            data-parsley-required-message="Please write new password">
                                        @if($errors->has('new_password'))
                                        <div class="text-danger">{{ $errors->first('new_password') }}</div>
                                        @endif
                                        
                                    </div>
                                    
                                </div>
                            
                                
                                <div class="row form-group">
                                
                                    <div class="col-md-12">
                            
                                        <label for="confirm_password">Confirm Password <span class="required">*</span></label>
                            
                                        <input type="password" data-parsley-trigger="input" class="form-control"
                                            name="confirm_password" id="confirm_password" minlength="8"
                                            placeholder="********" required
                                            data-parsley-equalto="#new_password" data-parsley-required-message="Please write your confirmation password">
                                        @if($errors->has('confirm_password'))
                                        <div class="text-danger">{{ $errors->first('confirm_password') }}</div>
                                        @endif
                                        
                                    </div>
                                    
                                </div>
                            
                                
                                <div class="row form-group">
                                
                                    <div class="col-md-12">
                            
                                        <input type="submit" value="Submit" class="btn btn-block btn-success  pt-2 pb-2 font20">
                                        
                                    </div>
                                    
                                </div>
                            
                            	</form> 
                            	
						</div>

					</div>

				</div>
			</div>


			<div class="col-md-6">
            <br><br>

				<div class="mt-2 ml-0 ml-sm-3">

					<h5 class="text-theme p-2">Your Profile</h5>

					<div class="row">

						<div class="col-sm-6 col-md-6 col-lg-4 mb-2 px-1">

							<div class="single-dashboard-link card card-default p-3 text-center"

								onclick="location.href='{{ route('employers.show', $user->username) }}'">

								<i class="fa fa-edit font30"></i>

								<h6>

									Profile

								</h6>

								<p>

									Edit

								</p>

							</div>

						</div>

						<div class="col-sm-6 col-md-6 col-lg-4 mb-2 px-1">

							<div class="single-dashboard-link card card-default p-3 text-center"

								onclick="location.href='{{ route('jobs.post') }}'">

								<i class="fa fa-plus-circle font30"></i>

								<h6>

									Post

								</h6>

								<p>

									New Job

								</p>

							</div>

						</div>

						<div class="col-sm-6 col-md-6 col-lg-4 mb-2 px-1">

								<div class="single-dashboard-link card card-default p-3 text-center"

									onclick="location.href='{{ route('employers.search.candidates') }}'">

									<i class="fa fa-search font30"></i>

									<h6>

									 Search Candidates

									</h6>

								</div>

						</div>
						<div class="col-sm-6 col-md-6 col-lg-4 mb-2 px-1">

							<div class="single-dashboard-link card card-default p-3 text-center seen--message"

							  >

								<i class="fa fa-envelope font30"></i>

								<h6>

									@php

										$messages = count($user->unread());

									@endphp

									{{ $messages }} Message{{ $messages > 1 ? 's' : '' }}

								</h6>

							</div>

						</div>
						<div class="col-sm-6 col-md-6 col-lg-4 mb-2 px-1">

							<div class="single-dashboard-link card card-default p-3 text-center"

								onclick="location.href='{{ route('teams') }}'">
								<i class="fa fa-users font30"></i>
								<h6>{{ count($user->teams) }}  Team</h6>
							</div>

						</div>
						<div class="col-sm-6 col-md-6 col-lg-4 mb-2 px-1">

							<div class="single-dashboard-link card card-default p-3 text-center"

								onclick="location.href='{{ route('employers.change-password') }}'">
								<i class="fa fa-edit font30"></i>
								<h6>Change password</h6>
							</div>

						</div>
					</div>

				</div>


			</div>

		</div>

	</div>


</section>

@endsection





@section('scripts')



@endsection
