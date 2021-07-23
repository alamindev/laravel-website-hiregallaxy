@extends('frontend.layouts.master')



@section('title')

Sign Up | Joblrs

@endsection


@section('stylesheets')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .registration-form .parsley-errors-list li {
        width: 100% !important;
    }
</style>
@php

$is_employer = false;

if (isset($_GET['type']) && $_GET['type'] == 'employer') {

$is_employer = true;

}

@endphp

@endsection





@section('content')

<div class="container">

    <div class="row justify-content-center">

        <div class="col-md-9">

            <div class="registration-form border p-2 m-3 pb-4" id="registration">

                <div class="strike">

                    <span class="text-yellow">Choose Account Type</span>

                </div>

                <div class="row justify-content-center mt-3">

                    <div class="col-md-10">

                        <div class="row">

                            <div class="col-md-12">

                                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">



                                    <li class="nav-item">

                                        <a class="nav-link {{ !$is_employer? 'active' : '' }}" id="pills-candidate-tab"
                                            data-toggle="pill" href="#pills-candidate" role="tab"
                                            aria-controls="pills-candidate" aria-selected="true">

                                            <i class="fa fa-user-o"></i>

                                            <br>

                                            Candidate

                                        </a>

                                    </li>



                                    <li class="nav-item">

                                        <a class="nav-link {{ $is_employer? 'active' : '' }}" id="pills-employer-tab"
                                            data-toggle="pill" href="#pills-employer" role="tab"
                                            aria-controls="pills-employer" aria-selected="false">

                                            <i class="fa fa-building-o"></i>

                                            <br>

                                            Employer

                                        </a>

                                    </li>

                                </ul>

                            </div>

                        </div>



                    </div>

                </div>

                <div class="tab-content" id="pills-tabContent">

                    <div class="tab-pane fade  {{ !$is_employer? 'show active' : '' }}" id="pills-candidate"
                        role="tabpanel" aria-labelledby="pills-home-tab">

                        <form action="{{ route('register') }}" method="post" data-parsley-validate="">

                            @csrf
                            <input type="hidden" name="is_company" value="0">

                            <div class="row form-group">

                                <div class="col-md-6">

                                    <label for="name">Name <span class="required">*</span></label>

                                    <input type="text" class="form-control" name="name" id="name"
                                        placeholder="Write Your Name" required value="{{ old('name') }}"
                                        data-parsley-required-message="Please  enter your name."
                                        data-parsley-alpha="/[a-z]/gi" data-parsley-minlength="5">
                                    @if($errors->has('name'))
                                    <div class="text-danger">{{ $errors->first('name') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-6">

                                    <label for="can_username">Username <span class="required">*</span></label>

                                    <input type="text" class="form-control candidate-username-check" name="username"
                                        id="can_username" placeholder="Write Your Username" required
                                        value="{{ old('username') }}"
                                        data-parsley-required-message="Please enter your username."
                                        data-parsley-minlength="5" autocomplete="off">
                                    @if($errors->has('username'))
                                    <div class="text-danger">{{ $errors->first('username') }}</div>
                                    @endif
                                    <div class="candidate-username-error"></div>
                                </div>

                            </div>



                            <div class="row form-group">

                                <div class="col-md-6">

                                    <label for="email">Email Address <span class="required">*</span></label>

                                    <input type="email" class="form-control candidate-email-check" name="email"
                                        id="email" placeholder="Write Your Email Address" required
                                        value="{{ old('email') }}"
                                        data-parsley-required-message="Please enter your email." autocomplete="off">
                                    @if($errors->has('email'))
                                    <div class="text-danger">{{ $errors->first('email') }}</div>
                                    @endif
                                    <div class="candidate-email-error"></div>
                                </div>

                                <div class="col-md-6">

                                    <label for="sector">Position <span class="required">*</span></label>

                                    <select name="sector" id="sector" class="form-control" required
                                        value="{{ old('sector') }}"
                                        data-parsley-required-message="Please select a position.">

                                        <option value="">Select One</option>

                                        @foreach ($categories as $cat)

                                        <option value="{{ $cat->id }}" {{ old('sector') == $cat->id ? 'selected':'' }}>
                                            {{ $cat->name }}</option>

                                        @endforeach

                                    </select>
                                    @if($errors->has('sector'))
                                    <div class="text-danger">{{ $errors->first('sector') }}</div>
                                    @endif
                                </div>

                            </div>

                            <div class="form-group">

                                <label for="street_address">Street Address <span class="required">*</span></label>

                                <input data-parsley-required-message="Please write your street address." type="text"
                                    class="form-control" name="street_address" id="street_address"
                                    placeholder="Write Your Address" required value="{{ old('street_address') }}"
                                    data-parsley-minlength="5">
                                @if($errors->has('street_address'))
                                <div class="text-danger">{{ $errors->first('street_address') }}</div>
                                @endif
                            </div>

                            <div class="row form-group">

                                <div class="col-md-6">
                                    <label for="city">Your Country <span class="required">*</span></label>

                                    <select name="city" id="city" class="form-control country__select" required
                                        value="{{ old('city') }}"
                                        data-parsley-required-message="Please select a country.">

                                        <option value="">Select a Country</option>

                                        @foreach (App\Models\City::orderBy('name', 'asc')->get() as $country)

                                        <option value="{{ $country->id }}">

                                            {{ $country->name }}

                                        </option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('city'))
                                    <div class="text-danger">{{ $errors->first('city') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-6">

                                    <label for="country">Your City <span class="required">*</span></label>

                                    <select name="country" id="country" class="form-control city__showing" required
                                        value="{{ old('country') }}"
                                        data-parsley-required-message="Please select a city.">

                                        <option value="">Select a city</option>
                                        @foreach (App\Models\State::orderBy('name', 'asc')->get() as $state)

                                        <option value="" disabled style="font-weight: bolder;font-size: 16px;">

                                            {{ $state->name }}

                                        </option>

                                        @foreach ($state->cities()->orderBy('name', 'asc')->get() as $country)

                                        <option value="{{ $country->id }}"
                                            {{ old('country') == $country->id ? 'selected':'' }}>

                                            &nbsp; &nbsp;

                                            {{ $country->name }}

                                        </option>

                                        @endforeach

                                        @endforeach

                                    </select>
                                    @if($errors->has('country'))
                                    <div class="text-danger">{{ $errors->first('country') }}</div>
                                    @endif
                                </div>

                            </div>



                            <div class="row form-group">

                                <div class="col-md-6">

                                    <label for="password">Password <span class="required">*</span></label>

                                    <input type="password" data-parsley-trigger="input" class="form-control"
                                        name="password" id="passwordCandidate" minlength="8"
                                        placeholder="Write A Strong Password" required
                                        data-parsley-required-message="Please write a strong password">
                                    @if($errors->has('password'))
                                    <div class="text-danger">{{ $errors->first('password') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-6">

                                    <label for="password_confirmation">Confirm Password <span
                                            class="required">*</span></label>

                                    <input type="password" data-parsley-trigger="input" class="form-control"
                                        name="password_confirmation" id="password_confirmation"
                                        placeholder="Write Password Again" data-parsley-equalto="#passwordCandidate"
                                        minlength="8" required
                                        data-parsley-required-message="Please write your confirmation password">

                                </div>

                            </div>

                            <div class="form-group">

                                <div class="form-check">

                                    <input class="form-check-input" name="term" type="checkbox"
                                        id="candidate_term&codition" required
                                        data-parsley-required-message="Please check term & condition">

                                    <label class=" form-check-label ml-1 mt-1" for="candidate_term&codition">

                                        Accept our <a href="{{ route('terms') }}" class="text-yellow">Terms and
                                            Condition</a> and <a href="{{ route('privacy') }}"
                                            class="text-yellow">Privacy
                                            Policy</a>

                                    </label>

                                </div>
                                @if($errors->has('term'))
                                <div class="text-danger">{{ $errors->first('term') }}</div>
                                @endif
                            </div>



                            <div class="row justify-content-center form-group text-center">

                                <div class="col-8">

                                    <input type="submit" value="Sign Up"
                                        class="btn btn-block apply-now-button pt-2 pb-2 font20 sign-up-candidate">

                                    <div class="mt-3 mb-3">

                                        <div class="text-center text-theme font16">

                                            Already have an account ?

                                            <a href="#signInModal" data-toggle="modal" class="text-yellow">Log in</a>

                                        </div>

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

                    <div class="tab-pane fade {{ $is_employer? 'show active' : '' }}" id="pills-employer"
                        role="tabpanel" aria-labelledby="pills-employer-tab">



                        <form action="{{ route('register.employee') }}" method="post" enctype="multipart/form-data"
                            data-parsley-validate>

                            @csrf

                            <input type="hidden" name="is_company" value="1">

                            <div class="row form-group">

                                <div class="col-md-6">

                                    <label for="employe_name">Company/Employer Name <span
                                            class="required">*</span></label>

                                    <input type="text" class="form-control" name="name" id="employe_name"
                                        placeholder="Write Name" required value="{{ old('name') }}"
                                        data-parsley-required-message="Please  enter your name."
                                        data-parsley-alpha="/[a-z]/gi" data-parsley-minlength="5">
                                    @if($errors->has('name'))
                                    <div class="text-danger">{{ $errors->first('name') }}</div>
                                    @endif
                                </div>



                                <div class="col-md-6">

                                    <label for="employe_username">Username <span class="required">*</span></label>

                                    <input type="text" data-parsley-required-message="Please enter your username."
                                        data-parsley-minlength="5" class="form-control employee-username-check"
                                        name="username" id="employe_username" placeholder="Write Your Username" required
                                        value="{{ old('username') }}" autocomplete="off">
                                    @if($errors->has('username'))
                                    <div class="text-danger">{{ $errors->first('username') }}</div>
                                    @endif
                                    <div class="employee-username-error"></div>
                                </div>

                            </div>

                            <div class="row form-group">

                                <div class="col-md-6">

                                    <label for="employe_email">Email Address <span class="required">*</span></label>

                                    <input type="email" class="form-control employee-email-check" name="email"
                                        id="employe_email" placeholder="Write Your Email Address"
                                        data-parsley-required-message="Please enter your email." required
                                        value="{{ old('email') }}" autocomplete="off">
                                    @if($errors->has('email'))
                                    <div class="text-danger">{{ $errors->first('email') }}</div>
                                    @endif
                                    <div class="employee-email-error"></div>
                                </div>

                                <div class="col-md-6">

                                    <label for="employe_category_id">Position <span class="required">*</span></label>

                                    <select name="category_id" data-parsley-required-message="Please select a Category."
                                        id="employe_category_id" class="form-control" required
                                        value="{{ old('category_id') }}">

                                        <option value="">Select One</option>

                                        @foreach ($categories as $cat)

                                        <option value="{{ $cat->id }}"
                                            {{ old('category_id') == $cat->id ? 'selected':'' }}>{{ $cat->name }}
                                        </option>

                                        @endforeach

                                    </select>
                                    @if($errors->has('category_id'))
                                    <div class="text-danger">{{ $errors->first('category_id') }}</div>
                                    @endif
                                </div>
                            </div>


                            <div class="row form-group">

                                <div class="col-md-6">

                                    <label for="employe_sector" class="d-block">Sectors <span
                                            class="required">*</span></label>

                                    <select data-parsley-required-message="Please select a position." name="sector[]"
                                        id="employe_sector" class="form-control select2" multiple required>

                                        <option value="">Select sectors</option>
                                        @php
                                        $sectors = \App\Models\Sector::get();
                                        @endphp
                                        @foreach ($sectors as $sector)
                                        <option value="{{ $sector->id }}">{{ $sector->name }}</option>

                                        @endforeach

                                    </select>
                                    @if($errors->has('sector'))
                                    <div class="text-danger">{{ $errors->first('sector') }}</div>
                                    @endif
                                </div>
                                <div class="col-md-6">

                                    <label for="employe_street_address">Street Address <span
                                            class="required">*</span></label>

                                    <input type="text" data-parsley-required-message="Please write your street address."
                                        class="form-control" name="street_address" id="employe_street_address"
                                        placeholder="Write Your Address" required value="{{ old('street_address') }}"
                                        value="{{ old('street_address') }}">
                                    @if($errors->has('street_address'))
                                    <div class="text-danger">{{ $errors->first('street_address') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="row form-group">

                                <div class="col-md-6">
                                    <label for="employe_city">Your Country <span class="required">*</span></label>

                                    <select data-parsley-required-message="Please select a country." name="city"
                                        id="employe_city" class="form-control country__select" required
                                        value="{{ old('city') }}">

                                        <option value="">Select a Country</option>

                                        @foreach (App\Models\City::orderBy('name', 'asc')->get() as $country)

                                        <option value="{{ $country->id }}">

                                            {{ $country->name }}

                                        </option>
                                        @endforeach

                                    </select>
                                    @if($errors->has('city'))
                                    <div class="text-danger">{{ $errors->first('city') }}</div>
                                    @endif
                                </div>
                                <div class="col-md-6">

                                    <label for="employe_country">Your City <span class="required">*</span></label>

                                    <select data-parsley-required-message="Please select a city." name="country"
                                        id="employe_country" class="form-control city__showing" required>

                                        <option value="">Select a city</option>

                                        @foreach (App\Models\State::orderBy('name', 'asc')->get() as $state)

                                        <option value="" disabled style="font-weight: bolder;font-size: 16px;">

                                            {{ $state->name }}

                                        </option>

                                        @foreach ($state->cities()->orderBy('name', 'asc')->get() as $country)

                                        <option value="{{ $country->id }}"
                                            {{ old('country') == $country->id ? 'selected':'' }}>

                                            &nbsp; &nbsp;

                                            {{ $country->name }}

                                        </option>

                                        @endforeach

                                        @endforeach

                                    </select>
                                    @if($errors->has('country'))
                                    <div class="text-danger">{{ $errors->first('country') }}</div>
                                    @endif
                                </div>

                            </div>



                            <div class="row form-group">

                                <div class="col-md-6">

                                    <label for="employe_password">Password <span class="required">*</span></label>

                                    <input type="password" data-parsley-trigger="input" class="form-control"
                                        name="password" data-parsley-required-message="Please write a strong password"
                                        id="employe_passwordEm" placeholder="Write A Strong Password" minlength="8"
                                        required>
                                    @if($errors->has('password'))
                                    <div class="text-danger">{{ $errors->first('password') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-6">

                                    <label for="employe_password_confirmation">Confirm Password <span
                                            class="required">*</span></label>

                                    <input type="password" data-parsley-trigger="input" class="form-control"
                                        name="password_confirmation" id="employe_password_confirmation"
                                        placeholder="Write Password Again" minlength="8"
                                        data-parsley-equalto="#passwordEm" required
                                        data-parsley-required-message="Please write your confirmation password">

                                </div>

                            </div>
                            <div class="form-group">

                                <div class="form-check">

                                    <input class="form-check-input" name="term" required
                                        data-parsley-required-message="Please check term & condition" type="checkbox"
                                        id="employer_term&codition">

                                    <label class="form-check-label ml-1 mt-1" for="employer_term&codition">

                                        Accept our <a href="{{ route('terms') }}" class="text-yellow">Terms and
                                            Condition</a> and <a href="{{ route('privacy') }}"
                                            class="text-yellow">Privacy Policy</a>

                                    </label>
                                    @if($errors->has('term'))
                                    <div class="text-danger">{{ $errors->first('term') }}</div>
                                    @endif
                                </div>

                            </div>
                            <div class="form-group">
                                <div class="col-8 offset-2">

                                    <input type="submit" value="Sign Up"
                                        class="btn btn-block apply-now-button pt-2 pb-2 font20 sign-up-employee">

                                    <div class="mt-3 mb-3">

                                        <div class="text-center text-theme font16">

                                            Already have an account ?

                                            <a href="#signInModal" data-toggle="modal" class="text-yellow">Log in</a>

                                        </div>

                                    </div>
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

        </div>

    </div>

</div>

@endsection





@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
    $('.select2').select2();
    $(document).ready(function() {
       window.Parsley
        .addValidator('alpha', {
        requirementType: 'regexp',
        validateString: function(value, requirement) {
        return requirement.test(value);
        },
        messages: {
        en: 'Your name must contain only letter.'
        }
        });
    });
</script>

@endsection
