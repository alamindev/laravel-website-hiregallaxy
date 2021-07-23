@extends('frontend.layouts.master')

@section('title')
Employer Exam | {{ App\Models\Setting::first()->site_title }}
@endsection

@section('stylesheets') 
@endsection

@section('content')

<section class="employer-page sec-pad pt-0" id="hiregalaxy">
	<div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="card my-5">
                    <div class="card-header"><h5>Your Result</h5></div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <tr>
                                <td>Status: </td>
                            <td  class="font-weight-bold">@if($result) <span class="{{ $result->result < 33 ? 'text-danger': 'text-success' }}">{{ $result->result < 33 ? 'Fail': 'Pass' }}</span>@endif </td>
                            </tr>
                            <tr>
                                <td>Parcent:</td>
                                <td  class="font-weight-bold"> @if($result) {{$result->result}}% @endif</td>
                            </tr>
                            <tr>
                                <td>Out Of Question:</td>
                                <td  class="font-weight-bold">@if($result) {{$result->que_answer}} @endif</td>
                            </tr>
                            <tr>
                                <td>Time:</td>
                                <td  class="font-weight-bold">@if($result){{Carbon\Carbon::parse($result->time)->format('H:i:s')}} @endif</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection


@section('scripts')
 
@endsection