@extends('frontend.layouts.master-two')

@section('stylesheets')

<style>

#dataTable img {



width: auto !important;

height: auto !important;



}

</style>

@endsection

@section('content')


 <div class="container pt-5"></div>

@if($question)
<div class="main-body">

  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
    <div class="alert alert-danger">
        Note: To work skill test, please enter 30 questions per position
    </div>
    <div class="card mb-3">

      <div class="card-header py-3">

        <div class="float-left">

          <h6 class="m-0 font-weight-bold text-primary">Single Question</h6>

        </div>

        <div class="float-right">



          <a href="{{ route('question.index') }}" class=" btn btn-sm btn-primary shadow-sm"><i class="fa fa-angle-left fa-sm text-white-50"></i> Back</a>

        </div>

        <div class="clearfix"></div>

      </div>

      <div class="card-body">

        <div class="table-responsive">

          <table id="dataTable" width="100%" cellspacing="0" class="table table-bordered">

            <tr>

                <td>Question</td>

                <td>:</td>

                <td>{!! $question->question !!}</td>

            </tr>

            <tr>

                <td>Skills</td>

                <td>:</td>

                <td> @foreach($question->getAllSkill() as $skll)

                          <span class="badge badge-success">{{$skll}}</span>

                        @endforeach</td>

            </tr>

            <tr>

                <td>Experience</td>

                <td>:</td>

                <td> @foreach($question->getAllExperience() as $e)

                        <span class="badge badge-success">{{$e}}</span>

                      @endforeach</td>

            </tr>
            <tr>

                <td>Positions</td>

                <td>:</td>

                <td> @foreach($question->getAllPosition() as $e)

                        <span class="badge badge-success">{{$e}}</span>

                      @endforeach</td>

            </tr>

            <tr>

                <td>Question One</td>

                <td>:</td>

                <td>{!! $question->answers->answer_1 !!}</td>

            </tr>

            <tr>

                <td>Question Two </td>

                <td>:</td>

                <td>{!! $question->answers->answer_2 !!}</td>

            </tr>

            <tr>

                <td>Question Three </td>

                <td>:</td>

                <td>{!! $question->answers->answer_3 !!}</td>

            </tr>

            <tr>

                <td>Question Four </td>

                <td>:</td>

                <td>{!! $question->answers->answer_4 !!}</td>

            </tr>

            <tr>

                <td>Right Answer</td>

                <td>:</td>

                <td>{{$question->answers->right_answer}}</td>

            </tr>

          </table>

        </div>

      </div><!-- end card-->

    </div>
    </div>

  </div>

</div>
@endif




@endsection

