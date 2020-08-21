<div class="modal animated fadeIn" id="apply-job-modal">

	<div class="modal-dialog modal-lg">

		<div class="modal-content">



			<!-- Modal Header -->

			<div class="modal-header">

				<h4 class="modal-title text-theme font22 bold">Apply for this Job</h4>

				<button type="button" class="close ml-2" data-dismiss="modal">&times;</button>

			</div>



			<!-- Modal body -->

			<div class="modal-body">

				<form action="{{ route('jobs.apply') }}" method="post" enctype="multipart/form-data"

					data-parsley-validate>

					@csrf

					<!-- Hidden Job ID -->

					<input type="hidden" name="job_id" id="job_id_for_apply">
					<input type="hidden" name="company_id" id="company_id_for_apply">
					<div class="row form-group">



						<div class="col-md-12">

							<label for="expected_salary">Expected Salary <span class="required">*</span>

								<input type="checkbox" name="is_salary_negotiable" id="is_salary_negotiable" value="1"

									class="ml-3" />

								<span class="font12"><label for="is_salary_negotiable">(Salary

										Negotiable)</label></span>

							</label></label>

							<div class="row">

								<div class="col-md-6 pr-0">

									<input type="number" class="form-control" id="expected_salary"

										name="expected_salary" placeholder="Your Expected Salary" min="0" required>

								</div>

								<div class="col-md-6 pl-0">

									<input type="text" id="jobApplyCurrency" value="CAD" disabled>

								</div>

							</div>



						</div>



					</div>

					<div class="row form-group">

						<div class="col-md-12">

							<label for="cover_letter">Cover Letter <span class="text-info font12"> optional

								</span></label>

							<textarea name="cover_letter" id="apply_job_description" cols="30" rows="5"

								class="form-control" placeholder="Your Cover Letter to the Employer"></textarea>

						</div>

					</div>

					<div class="row form-group">

						<div class="col-md-8">

							<label for="cover_letter">Curriculam Vitae

								<span class="text-muted font12">Upload your curriculam vitae, Max size: 2MB (only

									pdf)</span>

							</label>

							<input type="file" class="form-control" name="cv_file" id="cover_letter_cv">

						</div>

						@if (Auth::check())

						@if (Auth::user()->is_company == 0)

						@if (Auth::user()->candidate && Auth::user()->candidate->cv != null)

						<div class="col-md-4">

							<label for="cover_letter">Use Profile CV

							</label>

							<br>

							<input type="checkbox" name="use_profile_cv" id="use_profile_cv" value="1" class="ml-3" />

						</div>

						@endif

						@endif

						@endif



					</div>

					<div class="form-group">

						<div class="form-check">

							<input class="form-check-input" type="checkbox" id="acceptTerm" required>

							<label class="form-check-label ml-3" for="acceptTerm">

								Accept our <a href="" class="text-yellow">Terms and Condition</a> and <a href=""

									class="text-yellow">Privacy Policy</a>

							</label>

						</div>

					</div>



					<div class="row justify-content-center form-group text-center">

						<div class="col-6">

							@if (Auth::check())

							<input type="submit" value="Apply Job"

								class="btn btn-block apply-now-button pt-2 pb-2 font16 ">

							@else

							<a href="#signInModal" data-toggle="modal"

								class="btn btn-primary btn-login pt-2 pb-2 font18">

								Please Login to Apply

							</a>

							@endif

						</div>

					</div>



				</form>

			</div>



		</div>

	</div>

</div>