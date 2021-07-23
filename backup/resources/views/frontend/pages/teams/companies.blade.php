@extends('frontend.layouts.master-two') 

@section('title')

Companies | {{ App\Models\Setting::first()->site_title }}

@endsection
 
@section('stylesheets')



@endsection 

@section('content')

<div class="home-top">

	<div class="container">

		<div class="row justify-content-center">

			<div class="col-md-12"> 
				<h3 class="top-title wow fadeInUp mb-3">

				  Companies

				</h3>  

				<div class="navbar-breadcrumb d-flex justify-content-between align-items-center">

					<ol class="breadcrumb">

						<li class="breadcrumb-item"><a href="{{ route('employers.dashboard') }}">Home</a></li>

						<li class="breadcrumb-item active" aria-current="page">companies</li>

					</ol>
            <a href="{{ route('team.dashboard', $id) }}" class="btn btn-dark">Back</a>
				</div>

			</div>

		</div>

	</div>

</div>
<section class="employer-page sec-pad pt-4" id="wrapper"> 
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="main-body">

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                  
                      <div class="card mb-3"> 
                        <div class="card-header py-3"> 
                          <div class="float-left"> 
                            <h6 class="m-0 font-weight-bold text-primary">Companies</h6> 
                          </div> 
                          <div class="clearfix"></div> 
                        </div> 
                            <div class="card-body" style="overflow-x: scroll"> 
                            @include('backend.partials.message') 
                            <table id="dataTable" width="100%" cellspacing="0" class="table table-bordered">
                                <thead>
                                  <tr>
                                    <th>Sl</th>
                                    <th>Company Name</th>
                                    <th>Email Id</th> 
                                    <th>Assigned</th>  
                                    <th>Manage</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  @foreach($companies as $key=>$company)
                                      <tr>
                                        <td>{{$key+1}}</td>
                                        <td> {!! $company->name !!}</td>
                                        <td> {!! $company->email !!}</td>  
                                        <td>{{ App\User::where('id', $company->assign_id)->first()->name }} </td>  
                                        <td>
                                            <a href="{{ route('team.company.show', $company->id)}}" title="View Company" class="btn btn-info btn-sm ">
                                              <i class="fa fa-eye"></i>
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
            </div>
        </div>
    </div>

</section>

@endsection 

@section('scripts')



@endsection