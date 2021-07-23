@extends('backend.layouts.master')



@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 float-left">Edit Personality Type</h1>
  <div class="breadcrumb-holder float-right">
    <ol class="breadcrumb float-right">
      <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
      <li class="breadcrumb-item active">Edit Personality Type</li>
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
            Edit Personality Type
          </h6>
        </div>
        <div class="float-right">
            <a href="{{ route('admin.personality.index') }}"
            class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
              class="fas fa-arrow-left fa-sm text-white-50"></i> All Personality</a>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="card-body">
        @include('backend.partials.message')
        <form class="js-validate" method="POST" data-parsley-validate action="{{route('admin.personality.update',$edit->id )}}" enctype="multipart/form-data">
            @csrf
          <div class="row">
            <!-- Input -->
            <div class="col-sm-12 mb-6">
                <div class="form-group">
                    <label id="title" class="form-label">Question <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="title" required minlength="3" id="title" value="{{ $edit->title }}" placeholder="Enter Personality Title" required>
                    <span class="text-danger">{{ $errors->has('title') ? $errors->first('title') : '' }}</span>
                 </div>
                <div class="form-group">
                    <label id="sub_title" class="form-label">Sub title <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="sub_title" required minlength="3" id="sub_title" value="{{ $edit->sub_title }}" placeholder="Enter Personality Sub Title">
                 </div>
                <div class="form-group">
                    <label id="description" class="form-label">Descrition <span class="text-danger">*</span></label>
                    <textarea name="description"  class="form-control" required minlength="3" id="description" cols="30" rows="5">{{ $edit->description }}</textarea>
                 </div>
                <div class="form-group">
                    <label id="strength" class="form-label">Strengths</label>
                    <textarea name="strengths"  class="form-control"  id="strength" cols="30" rows="5">{{ $edit->strengths }}</textarea>
                    <div class="pt-2" id="strength-errors"></div>
                 </div>
                <div class="form-group">
                    <label id="weaknesse" class="form-label">Weaknesses</label>
                    <textarea name="weaknesses"  class="form-control"  id="weaknesse" cols="30" rows="5">{{ $edit->weaknesses }}</textarea>
                    <div class="pt-2" id="weaknesse-errors"></div>
                 </div>
            </div>
          </div>

          <div class="mt-3">
            <a href="{{ route('admin.personality.index') }}" class="btn btn-danger float-right mt-1 ml-2 "><i
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



@section('scripts')
<script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
     CKEDITOR.replace('strengths');
     CKEDITOR.replace('weaknesses');

     CKEDITOR.on('instanceReady', function () {
        let weaknessesErr =$('#weaknesse-errors');
        let strengthsErr =$('#strength-errors');
        $.each(CKEDITOR.instances, function (instance) {
        CKEDITOR.instances[instance].on("change", function (e) {
        for (instance in CKEDITOR.instances) {
        CKEDITOR.instances[instance].updateElement();
        if(instance == 'strength'){
        strengthsErr.empty();
        var strength = CKEDITOR.instances['strength'].getData();
        if ([...strength].length > 4 && [...strength].length <= 12) { $('<span class="text-danger"></span>')
            .html("Length must be greater than 5 characters")
            .appendTo(strengthsErr);
            }
            }
            if(instance == 'weaknesse'){
            weaknessesErr.empty();
            var weaknesse = CKEDITOR.instances['weaknesse'].getData();

            if ([...weaknesse].length > 4 && [...weaknesse].length <= 12) { $('<span class="text-danger"></span>')
                .html("Length must be greater than 5 characters")
                .appendTo(weaknessesErr);
                }
                }
                }

                });
                });
                });
  });
</script>


@endsection
