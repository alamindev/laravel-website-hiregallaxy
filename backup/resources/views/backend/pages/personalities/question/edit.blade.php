@extends('backend.layouts.master')



@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 float-left">Edit Personality Question</h1>
  <div class="breadcrumb-holder float-right">
    <ol class="breadcrumb float-right">
      <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
      <li class="breadcrumb-item active">Edit Personality Question</li>
    </ol>
    <div class="clearfix"></div>
  </div>
</div>


<div class="main-body">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
    <div class="card mb-3">
      <div class="card-header py-3">
        <div class="float-left">
          <h6 class="m-0 font-weight-bold text-primary">
            Edit Personality Question
          </h6>
        </div>
        <div class="float-right">
            <a href="{{ route('admin.personality.question.index') }}"
            class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
              class="fas fa-arrow-left fa-sm text-white-50"></i> All Questions</a>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="card-body">
        @include('backend.partials.message')
        <form class="js-validate" method="POST" data-parsley-validate action="{{route('admin.personality.question.update',$question->id )}}" enctype="multipart/form-data">
            @csrf
          <div class="row">
            <!-- Input -->
            <div class="col-sm-12 mb-6">
                <div class="form-group">
                  <label id="questions" class="form-label">Question <span class="text-danger">*</span></label>
                     <textarea cols="30" rows="1" class="form-control" required minlength="5" name="question" id="questions" placeholder="Enter question" >{{$question->question}}</textarea>
                     <span class="text-danger">{{ $errors->has('question') ? $errors->first('question') : '' }}</span>
                </div>
            </div>
            <!-- End Input -->

            <!-- Input -->
            <div class="col-sm-6 mb-6">
                <div class="form-group">
                  <label id="answer_1" class="form-label">Answer 1 <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" name="answer_1" required minlength="5" value="{{$question->answer_1}}" id="answer_1" placeholder="Enter answer" required>
                  <span class="text-danger">{{ $errors->has('answer_1') ? $errors->first('answer_1') : '' }}</span>
                </div>
            </div>
            <div class="col-sm-6 mb-6">
                <div class="form-group">
                  <label id="answer_2" class="form-label">
                    Answer 2 <span class="text-danger">*</span>
                  </label>
                  <input type="text" class="form-control" name="answer_2" required minlength="5" value="{{$question->answer_2}}" id="answer_2" placeholder="Enter answer" required>
                  <span class="text-danger">{{ $errors->has('answer_2') ? $errors->first('answer_2') : '' }}</span>
                </div>
            </div>


            <!-- End Input -->
          </div>

          <div class="mt-3">
            <a href="{{ route('admin.personality.question.index') }}" class="btn btn-danger float-right mt-1 ml-2 "><i
                class="fa fa-times"></i> Cancel</a>

            <button type="submit" class="btn btn-success float-right mt-1 ">
              <i class="fa fa-check"></i> Update
            </button>

          </div>


          <!-- End Buttons -->
        </form>
      </div><!-- end card-->
    </div>
  </div>
</div>

@endsection

