{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
 --}}

 <form action="" method="post">
                    @csrf
                    <div class="row form-group">
                        <div class="col-md-12">
                            <label for="username">Username <span class="required">*</span></label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="username" id="username" placeholder="Write Your Username">

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
                                <input type="password" class="form-control" name="password" id="password" placeholder="Write Your Password">
                                
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    

                    <div class="row justify-content-center form-group text-center">
                        <div class="col-8">
                            <input type="submit" value="Login" class="btn btn-block apply-now-button pt-2 pb-2 font20 ">
                            <div class="mt-2">
                                <div class="float-left">
                                    <a href="" class="text-yellow">Forget Password ?</a> 
                                    <span class="text-yellow">|</span>
                                    <a href="#signUpModal" data-toggle="modal" class="text-yellow">Sign Up</a>
                                </div>
                                <div class="float-right">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="remember_me">
                                            <label class="form-check-label ml-3" for="remember_me">
                                                Remember Me
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>

                            <div class="mt-1">
                                <div class="strike">
                                    <span class="text-yellow">Or</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
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
                    </div>

                </form>