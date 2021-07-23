@extends('backend.layouts.master')

@section('stylesheets')

@show

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 float-left">Extract Links</h1>
    <div class="breadcrumb-holder float-right">
        <ol class="breadcrumb float-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Extract Links</li>
        </ol>
        <div class="clearfix"></div>
    </div>
</div>


<div class="main-body">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <div class="card mb-3">
            <div class="card-header py-3">
                <div class="float-left">
                    <h6 class="m-0 font-weight-bold text-primary">Extract Links</h6>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="card-body">
                @include('backend.partials.message')

                <form action="{{ route('admin.crawl.extractLinks.store') }}" method="post" data-parsley-validate
                    id="form2">
                    @csrf

                    <div class="row form-group">
                        <label for="url"  >URL <span class="text-danger">*</span></label>
                        <input type="url" name="url" class="form-control  " placeholder="Enter URL" id="url"
                            value="@if(isset($request->url)) {{ $request->url }}@endif" required>
                    </div>

                    <div class="row form-group">
                        <label for="links"  >Extracted Links  <span class="text-danger">*</span></label>
                        <textarea name="links" class="form-control  " id="links" required
                            rows="8">@if(isset($links))@foreach ($links as $link){{ $link."\n" }}@endforeach @endif</textarea>
                    </div>

                    <div id="results"></div>

                    <div class="float-right">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fa fa-check"></i> Extract Links
                        </button>
                    </div>
                </form>


            </div><!-- end card-->
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    {{--  $("#form").submit(function(e){
        e.preventDefault();
        var url = $("#url").val();

        $.get(url, function(data) {
            var data = $(data);
            var links = data.find('a');
            //do stuff with links
              $("#results").html(links);
          });
      });  --}}
</script>
@endsection
