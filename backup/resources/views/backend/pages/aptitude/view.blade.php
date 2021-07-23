@extends('backend.layouts.master')



@section('content')



<div class="d-sm-flex align-items-center justify-content-between mb-4">

  <h1 class="h3 mb-0 float-left">Aptitude Question</h1>

  <div class="breadcrumb-holder float-right">

    <ol class="breadcrumb float-right">

      <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>

      <li class="breadcrumb-item active">Aptitude Question</li>

    </ol>

    <div class="clearfix"></div>

  </div>

</div>





<div class="main-body">

  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

    <div class="card mb-3">

      <div class="card-header py-3">

        <div class="float-left">

          <h6 class="m-0 font-weight-bold text-primary">Single Aptitude Question</h6>

        </div>

        <div class="float-right">



          <a href="{{ route('admin.aptitude.index') }}" class="  btn btn-sm btn-primary shadow-sm"><i class="fas fa-angle-left fa-sm text-white-50"></i> Back</a>

        </div>

        <div class="clearfix"></div>

      </div>

      <div class="card-body">

        <div class="table-responsive">

          <table id="dataTable" width="100%" cellspacing="0" class="table table-bordered">

            <tr>

                <td>Aptitude Question</td>

                <td>:</td>

                <td>{!! $aptitude->aptitude !!}</td>

            </tr>

            <tr>

                <td>Skills</td>

                <td>:</td>

                <td> @foreach($aptitude->getAllSkill() as $skll)

                          <span class="badge badge-success">{{$skll}}</span>

                        @endforeach</td>

            </tr> 

            <tr>

                <td>Experience</td>

                <td>:</td>

                <td> @foreach($aptitude->getAllExperience() as $e)

                        <span class="badge badge-success">{{$e}}</span>

                      @endforeach</td>

            </tr> 

            <tr>

                <td>Question One</td>

                <td>:</td>

                <td>{!! $aptitude->aptitudeanswers->answer_1 !!}</td>

            </tr> 

            <tr>

                <td>Question Two </td>

                <td>:</td>

                <td>{!! $aptitude->aptitudeanswers->answer_2 !!}</td>

            </tr> 

            <tr>

                <td>Question Three </td>

                <td>:</td>

                <td>{!! $aptitude->aptitudeanswers->answer_3 !!}</td>

            </tr> 

            <tr>

                <td>Question Four </td>

                <td>:</td>

                <td>{!! $aptitude->aptitudeanswers->answer_4 !!}</td>

            </tr> 

            <tr>

                <td>Right Answer</td>

                <td>:</td>

                <td>{{$aptitude->aptitudeanswers->right_answer}}</td>

            </tr>  

          </table>

        </div>

      </div><!-- end card-->

    </div>

  </div>

</div>





@endsection

