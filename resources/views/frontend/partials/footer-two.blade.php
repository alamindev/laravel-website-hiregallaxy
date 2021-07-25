 <section class="footer-section sec-pad">

	<div class="container">

		<div class="footer-area">

			<div class="row">

				<div class="col-md-3">

					<h1 class="footer-title text-capitalize">Company</h1>


					<ul class="footer-links">

						<li>

							<a href="{{ route('about_us') }}"> About us</a>

						</li>

						<li>

							<a href="{{ route('contacts') }}"> Contact us</a>

						</li>


						</ul>

					</div>
				<div class="col-md-3">

					<h1 class="footer-title text-capitalize">Terms</h1>

					<ul class="footer-links">

						<li>

							<a href="{{ route('terms') }}"> Terms of use</a>

						</li>

						<li>

							<a href="{{ route('privacy') }}"> Privacy Policy</a>

						</li>


						</ul>

				</div>
				<div class="col-md-3">

					<h1 class="footer-title text-capitalize">Customer</h1>

					<ul class="footer-links">

						<li>

							<a href="{{ route('testimonial') }}">  Testimonials</a>

						</li>

					</ul>

				</div>



				<div class="col-md-3">

					<h1 class="footer-title text-capitalize">Follow Us</h1>

					<div class="footer-social">

						<a href="{{ App\Models\Setting::first()->facebook_link ? App\Models\Setting::first()->facebook_link : '#' }}"><i class="fa fa-facebook-square "></i></a>

						<a href="{{ App\Models\Setting::first()->twitter_link ? App\Models\Setting::first()->twitter_link: '#' }}"><i class="fa fa-twitter "></i></a>

						<a href="{{ App\Models\Setting::first()->google_plus_link ? App\Models\Setting::first()->google_plus_link : '#' }}"><i class="fa fa-google-plus-square  "></i></a>

						<a href="{{ App\Models\Setting::first()->linkedin_link ? App\Models\Setting::first()->linkedin_link : '#' }}"><i class="fa fa-linkedin-square "></i></a>

					</div>

				</div>

		</div>

	</div>

</div>

</section>


<!-- Apply Job Modals -->

@include('frontend.partials.apply-job-modal')

@include('frontend.partials.apply-update-job-modal')

<!-- Apply Job Modals -->

@auth
@if(auth()->user()->is_company == 0)
@if((auth()->user()->is_company == 0 && auth()->user()->candidate->user_id) || count(auth()->user()->experiences) > 0 || count(auth()->user()->qualifications) > 0 || count(auth()->user()->awards) > 0 || count(auth()->user()->skills)  > 0 || count(auth()->user()->portfolios) > 0)

<div class="modal animated fadeIn" id="alertmodal">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center">
		<div class="modal-content">
			<div class="modal-header d-flex justify-content-end" style="width: 100%;">
					<button type="button" class="close ml-2" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
                <h2 class="text-center">Please Update Your Profile</h2>
              <div class="d-flex justify-content-center align-items-center">
                <a class="btn btn-info mt-3" href="{{ route('candidates.show', auth()->user()->username) }}">Go to profile</a>
                <button id="remember-later"  class="btn btn-primary ml-2 mt-3"  >Remember Later</button>
              </div>
			</div>
		</div>
	</div>
	</div>
</div>
@endif
@endif
@endauth




<div class="modal animated fadeIn" id="signInModal">

	@include('frontend.partials.signin-modal')

</div>


<section class="footer-bottom-section">
		<div class="container">
		<div class="footer--new">
			<p>&copy; {{ date('Y') }} Joblrs, All rights reseved </p>
			<p>Design by Joblrs</p>
		</div>
	</div>

</section>


<!-- Footer Section -->
