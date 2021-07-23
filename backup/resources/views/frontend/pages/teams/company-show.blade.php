@extends('frontend.layouts.master-two')

@section('title')

show company details | {{ App\Models\Setting::first()->site_title }}

@endsection

@section('stylesheets')



@endsection

@section('content')
<div class="home-top">

	<div class="container">

		<div class="row justify-content-center">

			<div class="col-md-12">



				<h3 class="top-title wow fadeInUp mb-3">
Show company  Details

				</h3>

				<div class="navbar-breadcrumb d-flex justify-content-between align-items-center">

					<ol class="breadcrumb">

						<li class="breadcrumb-item"><a href="{{ route('employers.dashboard') }}">Home</a></li>

						<li class="breadcrumb-item active" aria-current="page">company details</li>

					</ol>
                <a href="{{ route('team.company.show', $id) }}" class="btn btn-dark">Back</a>
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
                          <div class="float-right">
                            <a href="{{ route('companies') }}" class="btn btn-sm btn-success shadow-sm"><i class="fa fa-arrow-left fa-sm text-white-50"></i> Back</a>
                          </div>
                          <div class="clearfix"></div>
                        </div>
                            <div class="card-body">
                            @include('backend.partials.message')

                            <table id="dataTable" width="100%" cellspacing="0" class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td>Company Name</td>
                                        <td>: </td>
                                        <td>{{ $show->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Contact Person</td>
                                        <td>: </td>
                                        <td>{{ $show->contact_person }}</td>
                                    </tr>
                                    <tr>
                                        <td>Contact Number</td>
                                        <td>: </td>
                                        <td>{{ $show->phone }}</td>
                                    </tr>
                                    <tr>
                                        <td>Email id</td>
                                        <td>: </td>
                                        <td>{{ $show->email }}</td>
                                    </tr>
                                    <tr>
                                        <td>Location</td>
                                        <td>: </td>
                                        <td>{{ $show->location }}</td>
                                    </tr>
                                    <tr>
                                        <td>Website Url</td>
                                        <td>: </td>
                                        <td>{{ $show->website_url }}</td>
                                    </tr>
                                    <tr>
                                        <td>Assigned </td>
                                        <td>: </td>
                                        <td>{{ App\User::where('id', $show->assign_id)->first()->name }}</td>
                                    </tr>
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
