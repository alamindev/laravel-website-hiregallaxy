@extends('frontend.layouts.master-two')

@section('title')

Teams | {{ App\Models\Setting::first()->site_title }}

@endsection

@section('stylesheets')

<link rel="stylesheet" href="{{ asset('css/intlTelInput.min.css') }}">

@endsection

@section('content')

<section class="employer-page sec-pad pt-4" id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="main-body">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <form action="{{ route('team.store') }}" method="post" data-parsley-validate>

                            @csrf

                            <div class="card mb-3">
                                <div class="card-header py-3">
                                <div class="float-left">
                                    <h6 class="m-0 font-weight-bold text-primary">New Teams</h6>
                                </div>
                                <div class="float-right">
                                    <a href="{{ route('teams') }}" class="btn btn-sm btn-success shadow-sm">Back</a>
                                </div>
                                <div class="clearfix"></div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="name">Name <span class="required">*</span></label>
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Write Your Name" minlength="3" required  value="{{ old('name') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email Address <span class="required">*</span></label>
                                        <input type="email" class="form-control" name="email" id="email" placeholder="Write Your Email Address" required  value="{{ old('email') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="location">Location<span class="required">*</span></label>
                                        <select name="location" id="location" class="form-control" required value="{{ old('location') }}">

                                            <option value="">Select a Location</option>

                                            @foreach (App\Models\State::orderBy('name', 'asc')->get() as $state)

                                            <option value="" disabled style="font-weight: bolder;font-size: 16px;">
                                                {{ $state->name }}

                                            </option>
                                            @foreach ($state->cities()->orderBy('name', 'asc')->get() as $country)

                                            <option value="{{ $country->id }}" {{ old('country') == $country->id ? 'selected':'' }}>

                                                &nbsp; &nbsp;

                                                {{ $country->name }}

                                            </option>

                                            @endforeach

                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone_no">Phone Number </label>
                                        <br>
                                        <input type="tel" class="form-control" name="phone_no" id="phone_no"  required  value="{{ old('phone_no') }}">
                                        <br>
                                        <div id="error-msg" class="text-danger"></div>
                                        <div id="valid-msg" class="text-success"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password <span class="required">*</span></label>
                                        <input type="password" class="form-control" minlength="8" name="password" id="passwordEm" placeholder="Write A Strong Password" maxlength="8" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="password_confirmation">Confirm Password <span class="required">*</span></label>
                                          <input type="password" class="form-control" minlength="8" data-parsley-equalto="#passwordEm" name="password_confirmation" id="password_confirmation" placeholder="Write Password Again" maxlength="8"   required>
                                    </div>
                                    <div class="form-group">
                                          <input type="submit" class="btn btn-success .submit-btn" value="Submit">
                                    </div>
                                </div>
                            </div><!-- end card-->
                        </form>
                    </div>

                  </div>
            </div>
        </div>
    </div>

</section>

@endsection

@section('scripts')
<script src="{{ asset('js/intlTelInput.min.js') }}"></script>
<script src="{{ asset('js/utils.js') }}"></script>

<script>var input = document.querySelector("#phone_no"),
errorMsg = document.querySelector("#error-msg"),
validMsg = document.querySelector("#valid-msg");
submit = $(".submit-btn");

// here, the index maps to the error code returned from getValidationError - see readme
var errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

// initialise plugin
var iti = window.intlTelInput(input, {
utilsScript: "{{asset('js/utils.js')}}"
});

var reset = function() {
input.classList.remove("error");
errorMsg.innerHTML = "";
errorMsg.classList.add("hide");
validMsg.classList.add("hide");
submit.attr('disabled', false)
};

// on blur: validate
input.addEventListener('blur', function(e) {
reset();
if (input.value.trim()) {
if (iti.isValidNumber()) {
validMsg.classList.remove("hide");
} else {
submit.attr('disabled', true)
input.classList.add("error");
var errorCode = iti.getValidationError();
errorMsg.innerHTML = errorMap[errorCode];
errorMsg.classList.remove("hide");
}
}
});

// on keyup / change flag: reset
input.addEventListener('change', reset);
input.addEventListener('keyup', reset);</script>
@endsection
