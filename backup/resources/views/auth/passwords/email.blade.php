@extends('frontend.layouts.master')



@section('title')

Forget Password | Joblrs

@endsection





@section('stylesheets')



<style>

.forgot-password-section .card-header {

    background: #5b50b7;

    color: #fff;

}

</style>

@endsection





@section('content')

<div class="container">

    <div class="row justify-content-center m-5">

        <div class="col-md-9">

            <div class="card forgot-password-section">

                <div class="card-header">Reset Password</div>



                <div class="card-body">

                    @if (session('status'))

                    <div class="alert alert-success" role="alert">

                        {{ session('status') }}

                    </div>

                    @endif



                    <form method="POST" action="{{ route('password.email') }}" data-parsley-validate>

                        @csrf



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



                        <div class="form-group row mb-0">

                            <div class="col-md-6 offset-md-4">

                                <button type="submit" class="btn btn-yellow btn-block">

                                    <i class="fa fa-check"></i> Send Password Reset Link

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

