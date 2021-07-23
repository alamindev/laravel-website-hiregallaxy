@extends('frontend.layouts.master-two')



@section('title')

Change Password | {{ App\Models\Setting::first()->site_title }}

@endsection



@section('stylesheets')



@endsection



@section('content')

<section class="employer-page sec-pad pt-0">

	<div class="container">

		<div class="row mt-4">

			<div class="col-md-8">

<form class="col-md-8" action="{{ 'password-change' }}" method="POST" data-parsley-validate>
    
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

			<div class="col-md-4">

				@include('frontend.pages.partials.candidates-sidebar')

			</div>

		</div>

</section>

@endsection





@section('scripts')



@endsection