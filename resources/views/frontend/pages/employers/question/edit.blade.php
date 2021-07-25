@extends('frontend.layouts.master-two')






@section('stylesheets')
<link href="{{ asset('admin-asset/vendor/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('content')


 <div class="container pt-5">

<div class="main-body">

  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

    <div class="card mb-3">

      <div class="card-header py-3">

        <div class="float-left">

          <h6 class="m-0 font-weight-bold text-primary">

            Edit Question

          </h6>

        </div>

        <div class="float-right">

          <a href="{{ route('question.index') }}"

            class=" btn btn-sm btn-primary shadow-sm"><i

              class="fa fa-arrow-left fa-sm text-white-50"></i> All Questions</a>

        </div>

        <div class="clearfix"></div>

      </div>

      <div class="card-body">

        @include('backend.partials.message')

        <form class="js-validate" method="POST" data-parsley-validate action="{{route('question.update',$question->id)}}" enctype="multipart/form-data">

            @csrf

            <input name="_method" type="hidden" value="PUT">

          <div class="row">

            <!-- Input -->

            <div class="col-sm-12 mb-6">

                <div class="form-group">

                  <label id="questions" class="form-label">Question <span class="text-danger">*</span></label>

                     <textarea cols="30" data-parsley-errors-container="#question-errors" rows="1" class="form-control question_editor" name="question" id="question" placeholder="Enter question" >{{$question->question}}</textarea>
<div class="pt-2" id="question-errors"></div>
                     <span class="text-danger">{{ $errors->has('question') ? $errors->first('question') : '' }}</span>

                </div>

            </div>

            <!-- End Input -->



            <!-- Input -->

            <div class="col-sm-6 mb-6">

                <div class="form-group">

                  <label id="nameLabel" class="form-label">Answer 1 <span class="text-danger">*</span></label>

                  <!--<input type="text" class="form-control" name="answer_1" value="{{$question->answers->answer_1}}" id="answer_1" placeholder="Enter answer" required>-->

                  <textarea cols="30" data-parsley-errors-container="#answer_1-errors" rows="1" class="form-control answer_1_editor" name="answer_1" id="answer_1" placeholder="Enter answer" >{{$question->answers->answer_1}}</textarea>
<div class="pt-2" id="answer_1-errors"></div>
               </div>

            </div>

            <div class="col-sm-6 mb-6">

                <div class="form-group">

                  <label id="nameLabel" class="form-label">

                    Answer 2 <span class="text-danger">*</span>

                  </label>

                  <!--<input type="text" class="form-control" name="answer_2" value="{{$question->answers->answer_2}}" id="answer_2" placeholder="Enter answer" required>-->

                  <textarea cols="30" rows="1" data-parsley-errors-container="#answer_2-errors" class="form-control answer_2_editor" name="answer_2" id="answer_2" placeholder="Enter answer" >{{$question->answers->answer_2}}</textarea>
<div class="pt-2" id="answer_2-errors"></div>
                 </div>

            </div>

            <div class="col-sm-6 mb-6">

                <div class="form-group">

                  <label id="nameLabel" class="form-label">

                    Answer 3 <span class="text-danger">*</span>



                  </label>

                  <!--<input type="text" class="form-control" name="answer_3" value="{{$question->answers->answer_3}}" id="answer_3" placeholder="Enter answer" required>-->

                  <textarea cols="30" data-parsley-errors-container="#answer_3-errors" rows="1" class="form-control answer_3_editor" name="answer_3" id="answer_3" placeholder="Enter answer" >{{$question->answers->answer_3}}</textarea>
<div class="pt-2" id="answer_3-errors"></div>
                 </div>

            </div>

            <div class="col-sm-6 mb-6">

                <div class="form-group">

                  <label id="nameLabel" class="form-label">

                    Answer 4 <span class="text-danger">*</span>



                  </label>

                  <!--<input type="text" class="form-control" name="answer_4" value="{{$question->answers->answer_4}}" id="answer_4" placeholder="Enter answer" required>-->

                  <textarea cols="30" rows="1" data-parsley-errors-container="#answer_4-errors" class="form-control answer_4_editor" name="answer_4" id="answer_4" placeholder="Enter answer" >{{$question->answers->answer_4}}</textarea>
<div class="pt-2" id="answer_4-errors"></div>
                </div>

            </div>





            <div class="col-sm-6 mb-6">

                <div class="form-group">

                  <label id="skills" class="form-label">

                  Skills  <span class="text-danger">*</span>

                </label>

                  <select name="skills[]" id="skills" required class="form-control skillselect" multiple>



                    @foreach($skills as $skill)

                      <option value="{{$skill->id}}" {{in_array($skill->id,$question->skills) ? 'selected' :''}}>{{$skill->name}}</option>

                    @endforeach

                  </select>

                </div>

                <div class="form-group">

                  <label id="exparience" class="form-label">

                    Experience <span class="text-danger">*</span>

                  </label>

                  <select name="expariences[]" id="exparience" required class="form-control select2exp" multiple>

                    @foreach($experiences as $experience)

                        <option value="{{$experience->id}}" {{in_array($experience->id, explode(',',$question->exparience)) ? 'selected' :''}}>{{$experience->name}}</option>

                    @endforeach

                  </select>

                </div>

            </div>



            <div class="col-sm-6 mb-6">

                <div class="form-group">

                  <label id="skills" class="form-label">

                  Right Answer <span class="text-danger">*</span>

                </label>

                  <select name="right_answer" id="right_answer" required class="form-control">

                      <option value="">Select right answer</option>

                      <option value="answer_1" {{$question->answers->right_answer=='answer_1' ? 'selected' :''}} >Answer 1</option>

                      <option value="answer_2" {{$question->answers->right_answer=='answer_2' ? 'selected' :''}} >Answer 2</option>

                      <option value="answer_3" {{$question->answers->right_answer=='answer_3' ? 'selected' :''}} >Answer 3</option>

                      <option value="answer_4" {{$question->answers->right_answer=='answer_4' ? 'selected' :''}} >Answer 4</option>



                  </select>

                </div>

                <div class="form-group">

                    <label id="exparience" class="form-label">

                      Position <span class="text-danger">*</span>
                      </label>

                    <select name="positions[]" id="position" required class="form-control position" multiple>

                      @foreach($positions as $position)

                        <option value="{{$position->id}}" {{in_array($position->id, explode(',',$question->positions)) ? 'selected' :''}}>{{$position->name}}</option>

                      @endforeach

                    </select>

                  </div>

            </div>



            <!-- End Input -->

          </div>



          <div class="mt-3">



            <button type="submit" class="btn btn-success float-right mt-1 ">

              <i class="fa fa-check"></i> Save

            </button>



          </div>





          <!-- End Buttons -->

        </form>

      </div><!-- end card-->

    </div>

  </div>

</div>
</div>



@endsection



@section('scripts')
<script src="{{ asset('admin-asset/vendor/select2/js/select2.min.js') }}"></script>
<script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>

<script type="text/javascript">

  $(document).ready(function(){

    var select2 = $('select.skillselect').select2();

    $('.select2exp').select2();
    $('#position').select2();

        CKEDITOR.replace('question', {

		    filebrowserUploadUrl: "{{asset('admin/questions/uploads?_token=' . csrf_token()) }}&type=file",

		    imageUploadUrl: "{{asset('admin/questions/uploads?_token='. csrf_token() )  }}&type=image",

            filebrowserBrowseUrl: "{{asset('admin/question/file_browser') }}",

            filebrowserUploadMethod: 'form'

		});



		CKEDITOR.replace('answer_1', {

		    filebrowserUploadUrl: "{{asset('admin/questions/uploads?_token=' . csrf_token()) }}&type=file",

		    imageUploadUrl: "{{asset('admin/questions/uploads?_token='. csrf_token() )  }}&type=image",

            filebrowserBrowseUrl: "{{asset('admin/question/file_browser') }}",

            filebrowserUploadMethod: 'form'

		});



		CKEDITOR.replace('answer_2', {

		    filebrowserUploadUrl: "{{asset('admin/questions/uploads?_token=' . csrf_token()) }}&type=file",

		    imageUploadUrl: "{{asset('admin/questions/uploads?_token='. csrf_token() )  }}&type=image",

            filebrowserBrowseUrl: "{{asset('admin/question/file_browser') }}",

            filebrowserUploadMethod: 'form'

		});



		CKEDITOR.replace('answer_3', {

		    filebrowserUploadUrl: "{{asset('admin/questions/uploads?_token=' . csrf_token()) }}&type=file",

		    imageUploadUrl: "{{asset('admin/questions/uploads?_token='. csrf_token() )  }}&type=image",

            filebrowserBrowseUrl: "{{asset('admin/question/file_browser') }}",

            filebrowserUploadMethod: 'form'

		});



		CKEDITOR.replace('answer_4', {

		    filebrowserUploadUrl: "{{asset('admin/questions/uploads?_token=' . csrf_token()) }}&type=file",

		    imageUploadUrl: "{{asset('admin/questions/uploads?_token='. csrf_token() )  }}&type=image",

            filebrowserBrowseUrl: "{{asset('admin/question/file_browser') }}",

            filebrowserUploadMethod: 'form'

		});
CKEDITOR.on('instanceReady', function () {
$('#question').attr('required', '');
$('#answer_1').attr('required', '');
$('#answer_2').attr('required', '');
$('#answer_3').attr('required', '');
$('#answer_4').attr('required', '');
let questionErr =$('#question-errors');
let question1Err =$('#answer_1-errors');
let question2Err =$('#answer_2-errors');
let question3Err =$('#answer_3-errors');
let question4Err =$('#answer_4-errors');
$.each(CKEDITOR.instances, function (instance) {
CKEDITOR.instances[instance].on("change", function (e) {
for (instance in CKEDITOR.instances) {
CKEDITOR.instances[instance].updateElement();
if(instance == 'question'){
questionErr.empty();
var dataLength = CKEDITOR.instances['question'].getData();
if ([...dataLength].length > 4 && [...dataLength].length <= 12) { $('<span class="text-danger"></span>')
    .html("Length must be greater than 5 characters")
    .appendTo(questionErr);
    }
    }
    if(instance == 'answer_1'){
    question1Err.empty();
    var answer_1 = CKEDITOR.instances['answer_1'].getData();

    if ([...answer_1].length > 4 && [...answer_1].length <= 12) { $('<span class="text-danger"></span>')
        .html("Length must be greater than 5 characters")
        .appendTo(question1Err);
        }
        }
        if(instance == 'answer_2'){
        question2Err.empty();
        var answer_2 = CKEDITOR.instances['answer_2'].getData();
        console.log(answer_2);
        if ([...answer_2].length > 4 && [...answer_2].length <= 12) { $('<span class="text-danger"></span>')
            .html("Length must be greater than 5 characters")
            .appendTo(question2Err);
            }
            }
            if(instance == 'answer_3'){
            question3Err.empty();
            var answer_3 = CKEDITOR.instances['answer_3'].getData();
            if ([...answer_3].length > 4 && [...answer_3].length <= 12) { $('<span class="text-danger"></span>')
                .html("Length must be greater than 5 characters")
                .appendTo(question3Err);
                }
                }
                if(instance == 'answer_4'){
                question4Err.empty();
                var answer_4 = CKEDITOR.instances['answer_4'].getData();
                if ([...answer_4].length > 4 && [...answer_4].length <= 12) { $('<span class="text-danger"></span>')
                    .html("Length must be greater than 5 characters")
                    .appendTo(question4Err);
                    }
                    }
                    }
                    });
                    });
                    });

  });

</script>





@endsection
