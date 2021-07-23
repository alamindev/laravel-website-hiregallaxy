@extends('backend.layouts.master')

@section('stylesheets')

<style>

#dataTable img {



width: auto !important;

height: auto !important;



}

</style>

@endsection



@section('content')



<div class="d-sm-flex align-items-center justify-content-between mb-4">

  <h1 class="h3 mb-0 float-left">Questions</h1>

  <div class="breadcrumb-holder float-right">

    <ol class="breadcrumb float-right">

      <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>

      <li class="breadcrumb-item active">Questions</li>

    </ol>

    <div class="clearfix"></div>

  </div>

</div>





<div class="main-body">

  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

    <div class="card mb-3">

      <div class="card-header py-3">

        <div class="float-left">

          <h6 class="m-0 font-weight-bold text-primary">All Questions</h6>

        </div>

        <div class="float-right">



          <a href="{{ route('admin.question.create') }}" class="  btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus-circle fa-sm text-white-50"></i> Add New Question</a>

        </div>

        <div class="clearfix"></div>

      </div>

      <div class="card-body">

        @include('backend.partials.message')



        <div class="table-responsive">

          <table id="dataTable" width="100%" cellspacing="0" class="table table-bordered">

            <thead>

              <tr>

                <th width="5%">Sl</th>

                <th width="30%">Question</th>

                <th width="10%">Skill</th>

                <th width="15%">Experience</th>

                @if(auth()->user()->hasRole('super-admin') or auth()->user()->hasRole('admin'))

                <th width="15%">Editors</th>

                @endif

                <th width="15%" class="sortoff">Manage</th>

              </tr>

            </thead>

            <tbody>

              @foreach($questions as $key=>$question)

                  <tr>

                    <td>{{$key+1}}</td>

                    <td> {!! $question->question !!}</td>

                    <td >

                        @foreach($question->getAllSkill() as $skll)

                          <span class="badge badge-success">{{$skll}}</span>

                        @endforeach

                    </td>

                      <td> @foreach($question->getAllExperience() as $e)

                        <span class="badge badge-success">{{$e}}</span>

                      @endforeach</td>

                      @if(auth()->user()->hasRole('super-admin') or auth()->user()->hasRole('admin'))

                      <td>

                        @php

                            $user = \App\Models\Admin::where('id', $question->user_id)->first();

                        @endphp

                        {{ $user['username'] }}

                      </td>

                      @endif

                    <td>

                        <a href="{{url('admin/question/view/'.$question->id)}}" title="View Question" class="btn btn-outline-success">

                          <i class="fa fa-eye"></i>

                        </a>

                        <a href="{{url('admin/question/'.$question->id.'/edit')}}" title="Edit Question" class="btn btn-outline-success">

                          <i class="fa fa-edit"></i>

                        </a>

                        <a href="{{url('admin/delete_question/'.$question->id)}}" onClick="return confirm('Are you sure?')" title="Delete Question" class="btn btn-outline-danger">

                          <i class="fa fa fa-fw fa-trash"></i>

                        </a>

                    </td>

                  </tr>

                @endforeach

            </tbody>

          </table>

        </div>

      </div><!-- end card-->

    </div>

  </div>

</div>





@endsection

