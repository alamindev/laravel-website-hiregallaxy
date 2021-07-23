<!-- Sign In Modal -->

{{-- <div class="modal animated fadeIn" id="signInModal"> --}}

	<div class="modal-dialog modal-custom">

		<div class="modal-content">



			<!-- Modal Header -->

			<div class="modal-header mt-2">

				<h4 class="modal-title text-theme font22 bold">Welcome back !</h4>

				@if (!Route::is('login'))

					<button type="button" class="close ml-2" data-dismiss="modal">&times;</button>

				@endif

			</div>



			<!-- Modal body -->

			<div class="modal-body">

				<form action="{{ route('login') }}" method="post" class="pb-4" data-parsley-validate id="loginForm">

					@csrf

					<div class="row form-group">

						<div class="col-md-12">

							<label for="username">Username <span class="required">*</span></label>

							<div class="input-group mb-3">

								<input type="text" class="form-control" name="username" id="username" placeholder="Write Your Username or Email" required>



								<div class="input-group-append">

									<span class="input-group-text"><i class="fa fa-user"></i></span>

								</div>

							</div>

						</div>

					</div>



					<div class="row form-group">

						<div class="col-md-12">

							<label for="password">Password <span class="required">*</span></label>

							<div class="input-group mb-1">

								<input type="password" class="form-control" name="password" id="password" placeholder="Write Your Password" required>

								

								<div class="input-group-append">

									<span class="input-group-text"><i class="fa fa-lock"></i></span>

								</div>

							</div>

						</div>

					</div>

					

					<input type="hidden" name="remember" {{ old('remember') ? 'checked' : '' }}> 



					<div class="row justify-content-center form-group text-center">

						<div class="col-8">

							<input type="submit" value="Login" class="btn btn-block apply-now-button pt-2 pb-2 font20 ">

							<div class="mt-2">

								<div class="d-flex items-center flex-wrap justify-content-center">

									<a href="{{ route('password.request') }}" class="text-yellow">Forget Password ?</a> 

									<span class="text-yellow px-1">|</span>

									<a href="{{ route('register') }}" class="text-yellow">Sign Up</a>
									<div class="form-group pl-3">

										<div class="form-check login-model-remember">

											<input class="form-check-input" type="checkbox" id="remember_me">

											<label class="form-check-label ml-2" for="remember_me">

												Remember Me

											</label>

										</div>

									</div>

								</div> 

								<div class="clearfix"></div>

							</div>



							{{-- <div class="mt-1">

								<div class="strike">

									<span class="text-yellow">Or</span>

								</div>

							</div> --}}

						</div>

					</div>



					{{-- <div>

						<div class="row">

							<div class="col-6">

								<a href="" class="social-login facebook">

									<i class="fa fa-facebook"></i>

									<span class="text">

										Login With Facebook

									</span>

								</a>

							</div>

							<div class="col-6">

								<a href="" class="social-login twitter">

									<i class="fa fa-twitter"></i>

									<span class="text">

										Login With Twitter

									</span>

								</a>

							</div>

							<div class="col-6 mt-2">

								<a href="" class="social-login google-plus">

									<i class="fa fa-google-plus"></i>

									<span class="text">

										Login With Google

									</span>

								</a>

							</div>

							<div class="col-6 mt-2">

								<a href="" class="social-login linkedin">

									<i class="fa fa-linkedin"></i>

									<span class="text">

										Login With Linkedin

									</span>

								</a>

							</div>

						</div>

					</div> --}}



				</form>

			</div>



		</div>

	</div>

{{-- </div> --}}

<!-- Apply Job Modal -->

