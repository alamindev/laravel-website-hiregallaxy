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

				<form action="{{ route('jobs.apply') }}" method="post"  enctype="multipart/form-data"

					data-parsley-validate>

					@csrf

					<!-- Hidden Job ID -->

					<input type="hidden" name="job_id" id="job_id_for_apply">
					<input type="hidden" name="company_id" id="company_id_for_apply">
					<div class="row form-group">



						<div class="col-md-12">

							<label for="expected_salary" class="d-flex">Expected Salary <span class="required">*</span>

								<input type="checkbox" class="salary_negotiable"  name="is_salary_negotiable" id="is_salary_negotiable_update"

									value="1" class="ml-3" />

								<span class="font12 ml-2"><label for="is_salary_negotiable_update ">(Salary

										Negotiable)</label></span>

							</label></label>

							<div class="row">

								<div class="col-md-6 pr-0">

									<input type="number" class="form-control expected_salary" id="expected_salary_update"

										name="expected_salary" data-parsley-required-message="Please fill your expected salary" placeholder="Your Expected Salary" min="0" required>

								</div>

								<div class="col-md-6 pl-0">

									<input type="text" id="jobApplyCurrencyUpdate" value="CAD" disabled>

								</div>

							</div>



						</div>



					</div>

					<div class="row form-group textarea">

						<div class="col-md-12">

							<label for="cover_letter">Cover Letter <span class="text-danger font12"> *

								</span></label>

							<textarea required minlength="5"    data-parsley-required-message="Please write a Corver letter" name="cover_letter"     @if(auth()->check()) id="apply_job_description" @endif  cols="30" rows="5"

								class="form-control apply-job-modal" placeholder="Your Cover Letter to the Employer"></textarea>
							<div class="error-length"></div>
						</div>

					</div>


					<div class="form-group">

						<div class="form-check">

							<input class="form-check-input" data-parsley-required-message="Please check and accept terms & condistion" type="checkbox" id="acceptTerm" required >

							<label class="form-check-label ml-1 mt-1" for="acceptTerm">

								Accept our <a href="" class="text-yellow">Terms and Condition</a> and <a href=""

									class="text-yellow">Privacy Policy</a>

							</label>

						</div>

					</div>



					<div class="row justify-content-center form-group text-center">

						<div class="col-6">

							@if (Auth::check())

							<input type="submit" value="Apply Job"

								class="btn btn-block apply-now-button pt-2 pb-2 font16 apply-job submited">

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
