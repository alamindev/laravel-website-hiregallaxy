@extends('backend.layouts.master')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 float-left"> Personality Type</h1>
  <div class="breadcrumb-holder float-right">
    <ol class="breadcrumb float-right">
      <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
      <li class="breadcrumb-item active">Personality Type</li>
    </ol>
    <div class="clearfix"></div>
  </div>
</div>


<div class="main-body">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
    <div class="card mb-3">
      <div class="card-header py-3">
        <div class="float-left">
          <h6 class="m-0 font-weight-bold text-primary">All Personality Questions</h6>
        </div>
        <div class="float-right">

          <a href="{{ route('admin.personality.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus-circle fa-sm text-white-50"></i> Add Personality</a>
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
                <th width="20%">Title</th>
                <th width="20%">Sub title</th>
                @if(auth()->user()->hasRole('super-admin') or auth()->user()->hasRole('admin'))
                <th width="20%">Editor</th>
                @endif
                <th width="15%" class="sortoff">Manage</th>
              </tr>
            </thead>
            <tbody>
              @foreach($personalities as $key=>$personality)
                  <tr>
                    <td>{{$key+1}}</td>
                    <td> {{ $personality->title }}</td>
                    <td> {{ $personality->sub_title }}</td>
                    @if(auth()->user()->hasRole('super-admin') or auth()->user()->hasRole('admin'))
                    <td>
                      @php
                          $user = \App\Models\Admin::where('id', $personality->user_id)->first();
                      @endphp
                      {{ $user ? $user->username : ''}}
                    </td>
                    @endif
                    <td>
                        <a href="{{route('admin.personality.view',$personality->id)}}" title="show Personality" class="btn btn-outline-success">
                          <i class="fa fa-eye"></i>
                        </a>
                        <a href="{{route('admin.personality.edit',$personality->id)}}" title="Edit Personality" class="btn btn-outline-success">
                          <i class="fa fa-edit"></i>
                        </a>
                        <a href="{{route('admin.personality.delete',$personality->id)}}" title="Edit Personality" class="btn btn-outline-danger" onclick="return confirm('Are you sure?')">
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
