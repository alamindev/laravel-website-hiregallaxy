@extends('frontend.layouts.master-two') 

@section('title')

Teams | {{ App\Models\Setting::first()->site_title }}

@endsection
 
@section('stylesheets')



@endsection 

@section('content')

<section class="employer-page sec-pad pt-4" id="wrapper"> 
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="main-body">

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                  
                      <div class="card mb-3"> 
                        <div class="card-header py-3"> 
                          <div class="float-left"> 
                            <h6 class="m-0 font-weight-bold text-primary">Teams</h6> 
                          </div> 
                          <div class="float-right"> 
                            <a href="{{ route('team.create') }}" class="btn btn-sm btn-success shadow-sm"><i class="fa fa-plus-circle fa-sm text-white-50"></i> Add Team</a> 
                          </div> 
                          <div class="clearfix"></div> 
                        </div> 
                        <div class="card-body"> 
                          @include('backend.partials.message') 
                          
                          <div class="row">
                            @foreach($users as $user)
                              <div class="col-sm-6 col-md-6 col-lg-4 mb-2">
                                <div class="card teams__all">
                                  <div class="card-body">
                                      <div class="d-flex">
                                          <div class="left__side" style="flex:2">
                                              <div class="username"> {{ $user->name }}</div>
                                              <div class="email"> {{ $user->email }}</div>
                                              <div class="action"> 
                                                <a href="{{ route('team.dashboard', $user->id) }}" class="btn btn-secondary">Dashboard</a>
                                                @if($user->status == 1)
                                                <a href="{{ route('team.delete', [$user->id, 2]) }}" class="btn btn-success" onclick="return confirm('Are you sure?')">Active</a>
                                                @elseif($user->status == 2)
                                                <a href="{{ route('team.delete', [$user->id, 1]) }}" class="btn btn-danger" onclick="return confirm('Are you sure?')">Deactive</a>
                                                @endif
                                              </div>
                                          </div>
                                          <img alt="image" class="rounded-circle" src="{{ App\Helpers\ReturnPathHelper::getUserImage($user->id) }}" style="width: 70px; height: 70px">
                                      </div>
                                  </div>
                                </div>
                              </div>
                            @endforeach
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