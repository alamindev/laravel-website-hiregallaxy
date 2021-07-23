@extends('frontend.layouts.master')



@section('title')

Employers | {{ App\Models\Setting::first()->site_title }}

@endsection





@section('stylesheets')



@endsection





@section('content')

<section class="employer-page sec-pad">

	<div class="container"> 
	 
		<form action="{{ route('description.search') }}" method="get" id="JobDesSearchForms">
			<input type="hidden" name="job_description">
			<div class="row">
				<div class="col-lg-4">	<h5 class="text-theme bold mb-4 float-left">We have found <span class="text-yellow">{{ count($templates) }}</span>

					Matches for you </h5> </div>
				<div class="col-lg-8">
					<div class="abcd">
						<button type="submit" class="alpha" value="a" name="alpha"  onchange="submitSearch()">A</button>
						<button type="submit" class="alpha" value="b" name="alpha"  onchange="submitSearch()">B</button>
						<button type="submit" class="alpha" value="c" name="alpha"  onchange="submitSearch()">C</button>
						<button type="submit" class="alpha" value="d" name="alpha"  onchange="submitSearch()">D</button>
						<button type="submit" class="alpha" value="e" name="alpha"  onchange="submitSearch()">E</button>
						<button type="submit" class="alpha" value="f" name="alpha"  onchange="submitSearch()">F</button>
						<button type="submit" class="alpha" value="g" name="alpha"  onchange="submitSearch()">G</button>
						<button type="submit" class="alpha" value="h" name="alpha"  onchange="submitSearch()">H</button>
						<button type="submit" class="alpha" value="i" name="alpha"  onchange="submitSearch()">I</button>
						<button type="submit" class="alpha" value="j" name="alpha"  onchange="submitSearch()">J</button>
						<button type="submit" class="alpha" value="k" name="alpha"  onchange="submitSearch()">K</button>
						<button type="submit" class="alpha" value="l" name="alpha"  onchange="submitSearch()">L</button>
						<button type="submit" class="alpha" value="m" name="alpha"  onchange="submitSearch()">M</button>
						<button type="submit" class="alpha" value="n" name="alpha"  onchange="submitSearch()">N</button>
						<button type="submit" class="alpha" value="o" name="alpha"  onchange="submitSearch()">O</button>
						<button type="submit" class="alpha" value="p" name="alpha"  onchange="submitSearch()">P</button>
						<button type="submit" class="alpha" value="q" name="alpha"  onchange="submitSearch()">Q</button>
						<button type="submit" class="alpha" value="r" name="alpha"  onchange="submitSearch()">R</button>
						<button type="submit" class="alpha" value="s" name="alpha"  onchange="submitSearch()">S</button>
						<button type="submit" class="alpha" value="t" name="alpha"  onchange="submitSearch()">T</button>
						<button type="submit" class="alpha" value="u" name="alpha"  onchange="submitSearch()">U</button>
						<button type="submit" class="alpha" value="v" name="alpha"  onchange="submitSearch()">V</button>
						<button type="submit" class="alpha" value="w" name="alpha"  onchange="submitSearch()">W</button>
						<button type="submit" class="alpha" value="x" name="alpha"  onchange="submitSearch()">X</button>
						<button type="submit" class="alpha" value="y" name="alpha"  onchange="submitSearch()">Y</button>
						<button type="submit" class="alpha" value="z" name="alpha"  onchange="submitSearch()">Z</button>
					</div>
				</div>
			</div>
		
		<div class="row">

			<div class="col-md-4">

				<div class="left-sidebar">

					<div class="toggleNav">

						<button class="btn btn-outline-secondary btn-toggle"><i class="fa fa-bars"></i></button>

					</div>

					<div class="toggleNav2">

						<button class="btn btn-outline-secondary btn-toggle"><i class="fa fa-times"></i></button>

					</div>

					<div id="left-sidebar">

						@include('frontend.pages.partials.description-search')

					</div>

				</div>

			</div>

			<div class="col-md-8">
				
				<div class="page-employer">

					<div class="employee-header-section">

						<div class="float-left">

							<select name="" id="">

								<option value="">Most Recent</option>

							</select>

						</div>

						<div class="float-right">

							<span class="text-theme">

								You are watching <span class="count-text">{{ $pageNoText }}</span>

							</span>

						</div>

						<div class="clearfix"></div>

					</div>

					@foreach ($templates as $key => $template)

                    <div class="single-job-short single-template d-flex align-items-center justify-content-between px-4"> 
                    
                        <div class="ml-2 single-job-description">
                    
                            <h4><a href="{{ route('jobDescription', $template->id) }}">{{ $template->name }}</a></h4>  
                            <p class="text-theme mb-2">   {{ $template->category ? $template->category->name : '' }}</p> 
                               <p class="mt-2">
                            {!! $template->job_summery !!}
                                
                            </p>
                    
                        </div> 
                        <a class="btn btn-secondary ml-4" href="{{ route('jobDescription', $template->id) }}">view</a>
                    </div> 

					@endforeach



					@if (count($templates) == 0)

					<div class="alert alert-danger mt-2">

						<strong>Sorry !!</strong>

						<br>

						<p>We have not found any employee for this query now !!</p>

					</div>

					@endif



					<div class="page-pagination mt-4">

						{{ $templates->links() }}

					</div>

				</div>

			</div>

		</div>
	</form>
 
	</div>

</section>

@endsection





@section('scripts')

<script>

	$("input:checkbox").on('click', function() {

		var $box = $(this);

		if ($box.is(":checked")) {

			var group = "input:checkbox[name='" + $box.attr("name") + "']";

			$(group).prop("checked", false);

			$box.prop("checked", true);

		} else {

			$box.prop("checked", false);

		}

	});



	function submitSearch(event){

		 $("#JobDesSearchForms").submit();

	}
	$.urlParam = function (name) {
		var results = new RegExp('[\?&]' + name + '=([^&#]*)')
						.exec(window.location.search);

		return (results !== null) ? results[1] || 0 : false;
	}
	if($.urlParam('category')){
		$('select[name=category]').val($.urlParam('category'));
	$('.selectpicker').selectpicker('refresh');
	}

</script>

@endsection