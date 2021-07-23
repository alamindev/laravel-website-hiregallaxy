<style>
    .em_style{margin-bottom: 0px !important;}
</style>


<form action="{{ route('messages.store') }}" class="mt-3 sendMessageUser" method="post" data-parsley-validate>

@csrf

    <input type="hidden" name="is_admin" value="0" >

	<input type="hidden" name="to_user_id" value="{{ $user->id }}">

	<div class="form-group">

		<label for="name">Your Name</label>

		<div class="input-group mb-3 parsley--message">

			<input type="text" class="form-control em_style" minlength="3" placeholder="Write your name" id="name" name="name" value="{{ Auth::check() ? Auth::user()->name : '' }}" required>

			<div class="input-group-append">

				<span class="input-group-text"><i class="fa fa-user"></i></span>

			</div>

		</div>

	</div>



	<div class="form-group">

		<label for="email">Email Address</label>

		<div class="input-group mb-3 parsley--message">

			<input type="email" class="form-control em_style"  placeholder="Write your email address" id="email" name="email" value="{{ Auth::check() ? Auth::user()->email : '' }}" required>

			<div class="input-group-append">

				<span class="input-group-text"><i class="fa fa-envelope"></i></span>

			</div>

		</div>

	</div>



	<div class="form-group">

		<label for="message">Your Message</label>

		<textarea name="message" id="message" rows="4" minlength="3" class="form-control" placeholder="Write your message here" required></textarea>

	</div>

	<div class="form-group">

		<div class="form-check pt-2">

			<input class="form-check-input" type="checkbox" id="employerSendMessage" checked required>

			<label class="form-check-label ml-3" for="employerSendMessage">

				Accept our <a href="{{ route('terms') }}" class="text-yellow">Terms and Condition</a> and <a href="{{ route('privacy') }}"  class="text-yellow">Privacy Policy</a>

			</label>

		</div>

	</div>



	<div class="form-group text-center">

		<input type="submit" value="Send Message" class="btn apply-now-button">

	</div>



</form>
