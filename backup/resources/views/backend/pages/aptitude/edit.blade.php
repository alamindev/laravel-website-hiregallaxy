@extends('backend.layouts.master')







@section('content')



<div class="d-sm-flex align-items-center justify-content-between mb-4">

  <h1 class="h3 mb-0 float-left">Edit aptitude question</h1>

  <div class="breadcrumb-holder float-right">

    <ol class="breadcrumb float-right">

      <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>

      <li class="breadcrumb-item active">Edit Question</li>

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

            Edit aptitude question

          </h6>

        </div>

        <div class="float-right">

          <a href="{{ url('admin/aptitude') }}"

            class="  btn btn-sm btn-primary shadow-sm"><i

              class="fas fa-arrow-left fa-sm text-white-50"></i> All aptitude questions</a>

        </div>

        <div class="clearfix"></div>

      </div>

      <div class="card-body">

        @include('backend.partials.message')

        <form class="js-validate" method="POST" data-parsley-validate action="{{url('admin/aptitude/'.$aptitude->id)}}" enctype="multipart/form-data">

            @csrf

            <input name="_method" type="hidden" value="PUT">

          <div class="row">

            <!-- Input -->

            <div class="col-sm-12 mb-6">

                <div class="form-group">

                  <label id="aptitudes" class="form-label">Aptitude question <span class="text-danger">*</span></label>

                     <textarea cols="30" rows="1" class="form-control aptitude_editor" data-parsley-errors-container="#aptitude-errors" name="aptitude" id="aptitudes" placeholder="Enter aptitude question" >{{$aptitude->aptitude}}</textarea>
<div class="pt-2" id="aptitude-errors"></div>
                     <span class="text-danger">{{ $errors->has('aptitude') ? $errors->first('aptitude') : '' }}</span>

                </div>

            </div>

            <!-- End Input -->



            <!-- Input -->

            <div class="col-sm-6 mb-6">

                <div class="form-group">

                  <label id="nameLabel" class="form-label">Answer 1 <span class="text-danger">*</span></label>
  <textarea cols="30" rows="1" class="form-control" data-parsley-errors-container="#answer_1-errors" name="answer_1" id="answer_1" placeholder="Enter answer" >{{$aptitude->aptitudeanswers->answer_1}}</textarea>
  <div class="pt-2" id="answer_1-errors"></div>
                </div>

            </div>

            <div class="col-sm-6 mb-6">

                <div class="form-group">

                  <label id="nameLabel" class="form-label">

                    Answer 2 <span class="text-danger">*</span>

                  </label>

  <textarea cols="30" rows="1" class="form-control" data-parsley-errors-container="#answer_2-errors" name="answer_2" id="answer_2" placeholder="Enter answer" >{{$aptitude->aptitudeanswers->answer_2}}</textarea>
  <div class="pt-2" id="answer_2-errors"></div>
                </div>

            </div>

            <div class="col-sm-6 mb-6">

                <div class="form-group">

                  <label id="nameLabel" class="form-label">

                    Answer 3 <span class="text-danger">*</span>



                  </label>

                  <textarea cols="30" rows="1" class="form-control" name="answer_3" data-parsley-errors-container="#answer_3-errors" id="answer_3" placeholder="Enter answer" >{{$aptitude->aptitudeanswers->answer_3}}</textarea>
                  <div class="pt-2" id="answer_3-errors"></div>
                </div>

            </div>

            <div class="col-sm-6 mb-6">

                <div class="form-group">

                  <label id="nameLabel" class="form-label">

                    Answer 4 <span class="text-danger">*</span>



                  </label>
  <textarea cols="30" rows="1" class="form-control" data-parsley-errors-container="#answer_4-errors" name="answer_4" id="answer_4" placeholder="Enter answer" >{{$aptitude->aptitudeanswers->answer_4}}</textarea>
  <div class="pt-2" id="answer_4-errors"></div>
                </div>

            </div>





            <div class="col-sm-6 mb-6">

                <div class="form-group">

                  <label id="skills" class="form-label">

                  Skills <span class="text-danger">*</span>

                </label>

                  <select name="skills[]" id="skills" required class="form-control skillselect" multiple>



                    @foreach($skills as $skill)

                      <option value="{{$skill->id}}" {{in_array($skill->id,$aptitude->skills) ? 'selected' :''}}>{{$skill->name}}</option>

                    @endforeach

                  </select>

                </div>

                <div class="form-group">

                  <label id="exparience" class="form-label">

                    Exparience <span class="text-danger">*</span>

                  </label>

                  <select name="expariences[]" id="exparience" required class="form-control select2exp" multiple>

                    @foreach($experiences as $experience)

                        <option value="{{$experience->id}}" {{in_array($experience->id, explode(',',$aptitude->exparience)) ? 'selected' :''}}>{{$experience->name}}</option>

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

                      <option value="answer_1" {{$aptitude->aptitudeanswers->right_answer=='answer_1' ? 'selected' :''}} >Answer 1</option>

                      <option value="answer_2" {{$aptitude->aptitudeanswers->right_answer=='answer_2' ? 'selected' :''}} >Answer 2</option>

                      <option value="answer_3" {{$aptitude->aptitudeanswers->right_answer=='answer_3' ? 'selected' :''}} >Answer 3</option>

                      <option value="answer_4" {{$aptitude->aptitudeanswers->right_answer=='answer_4' ? 'selected' :''}} >Answer 4</option>



                  </select>

                </div>



            </div>



            <!-- End Input -->

          </div>



          <div class="mt-3">

            <button type="button" class="btn btn-danger float-right mt-1 ml-2 " data-dismiss="modal"><i

                class="fa fa-times"></i> Cancel</button>



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



@endsection



@section('scripts')

<script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>

<script type="text/javascript">

  $(document).ready(function(){

    var select2 = $('select.skillselect').select2();

    $('.select2exp').select2();

    CKEDITOR.replace('aptitude', {

      filebrowserUploadUrl: "{{asset('admin/aptitudes/uploads?_token=' . csrf_token()) }}&type=file",
      imageUploadUrl: "{{asset('admin/aptitudes/uploads?_token='. csrf_token() )  }}&type=image",

            filebrowserBrowseUrl: "{{asset('admin/aptitude/file_browser') }}",

            filebrowserUploadMethod: 'form'

		});




		CKEDITOR.replace('answer_1', {

filebrowserUploadUrl: "{{asset('admin/aptitudes/uploads?_token=' . csrf_token()) }}&type=file",

imageUploadUrl: "{{asset('admin/aptitudes/uploads?_token='. csrf_token() )  }}&type=image",

    filebrowserBrowseUrl: "{{asset('admin/question/file_browser') }}",

    filebrowserUploadMethod: 'form'

});



CKEDITOR.replace('answer_2', {

filebrowserUploadUrl: "{{asset('admin/aptitudes/uploads?_token=' . csrf_token()) }}&type=file",

imageUploadUrl: "{{asset('admin/aptitudes/uploads?_token='. csrf_token() )  }}&type=image",

    filebrowserBrowseUrl: "{{asset('admin/question/file_browser') }}",

    filebrowserUploadMethod: 'form'

});



CKEDITOR.replace('answer_3', {

filebrowserUploadUrl: "{{asset('admin/aptitudes/uploads?_token=' . csrf_token()) }}&type=file",

imageUploadUrl: "{{asset('admin/aptitudes/uploads?_token='. csrf_token() )  }}&type=image",

    filebrowserBrowseUrl: "{{asset('admin/question/file_browser') }}",

    filebrowserUploadMethod: 'form'

});



CKEDITOR.replace('answer_4', {

filebrowserUploadUrl: "{{asset('admin/aptitudes/uploads?_token=' . csrf_token()) }}&type=file",

imageUploadUrl: "{{asset('admin/aptitudes/uploads?_token='. csrf_token() )  }}&type=image",

    filebrowserBrowseUrl: "{{asset('admin/question/file_browser') }}",

    filebrowserUploadMethod: 'form'

});

CKEDITOR.on('instanceReady', function () {
$('#aptitudes').attr('required', '');
$('#answer_1').attr('required', '');
$('#answer_2').attr('required', '');
$('#answer_3').attr('required', '');
$('#answer_4').attr('required', '');
let aptitudeErr =$('#aptitude-errors');
let aptitude1Err =$('#answer_1-errors');
let aptitude2Err =$('#answer_2-errors');
let aptitude3Err =$('#answer_3-errors');
let aptitude4Err =$('#answer_4-errors');
$.each(CKEDITOR.instances, function (instance) {
CKEDITOR.instances[instance].on("change", function (e) {
for (instance in CKEDITOR.instances) {
CKEDITOR.instances[instance].updateElement();
if(instance == 'aptitudes'){
aptitudeErr.empty();
var dataLength = CKEDITOR.instances['aptitudes'].getData();



if ([...dataLength].length > 4 && [...dataLength].length <= 12) { $('<span class="text-danger"></span>')
    .html("Length must be greater than 5 characters")
    .appendTo(aptitudeErr);
    }
    }
    if(instance == 'answer_1'){
    aptitude1Err.empty();
    var answer_1 = CKEDITOR.instances['answer_1'].getData();

    if ([...answer_1].length > 4 && [...answer_1].length <= 12) { $('<span class="text-danger"></span>')
        .html("Length must be greater than 5 characters")
        .appendTo(aptitude1Err);
        }
        }
        if(instance == 'answer_2'){
        aptitude2Err.empty();
        var answer_2 = CKEDITOR.instances['answer_2'].getData();

        if ([...answer_2].length > 4 && [...answer_2].length <= 12) { $('<span class="text-danger"></span>')
            .html("Length must be greater than 5 characters")
            .appendTo(aptitude2Err);
            }
            }
            if(instance == 'answer_3'){
            aptitude3Err.empty();
            var answer_3 = CKEDITOR.instances['answer_3'].getData();
            if ([...answer_3].length > 4 && [...answer_3].length <= 12) { $('<span class="text-danger"></span>')
                .html("Length must be greater than 5 characters")
                .appendTo(aptitude3Err);
                }
                }
                if(instance == 'answer_4'){
                aptitude4Err.empty();
                var answer_4 = CKEDITOR.instances['answer_4'].getData();
                if ([...answer_4].length > 4 && [...answer_4].length <= 12) { $('<span class="text-danger"></span>')
                    .html("Length must be greater than 5 characters")
                    .appendTo(aptitude4Err);
                    }
                    }
                    }
                    });
                    });
                    });

  });

</script>





@endsection

