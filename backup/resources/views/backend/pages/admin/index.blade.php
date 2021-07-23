@extends('backend.layouts.master')
@section('stylesheets')
<style>
#dataTable img {

width: 50px !important;
height: 50px !important;

}
</style>
@endsection

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 float-left">Admins</h1>
  <div class="breadcrumb-holder float-right">
    <ol class="breadcrumb float-right">
      <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
      <li class="breadcrumb-item active">Admins</li>
    </ol>
    <div class="clearfix"></div>
  </div>
</div>


<div class="main-body">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
    <div class="card mb-3">
      <div class="card-header py-3">
        <div class="float-left">
          <h6 class="m-0 font-weight-bold text-primary">All Admins</h6>
        </div>
        <div class="float-right">
          @if(auth()->user()->hasRole('super-admin'))
          <a href="{{ route('admin.account.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus-circle fa-sm text-white-50"></i> Add New Admin</a>
          @endif
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
                <th width="30%">Username</th>
                <th width="20%">Email</th>
                <th width="20%">Role</th>
                @if(auth()->user()->hasRole('super-admin'))
                  <th>Access</th>
                @endif
                <th width="15%" class="sortoff">Manage</th>
              </tr>
            </thead>
            <tbody>
              @foreach($admins as $key=>$admin)
                  <tr>
                    <td>{{$key+1}}</td>
                    <td> {!! $admin->username !!}</td>
                    <td> {!! $admin->email !!}</td>
                    <td>
                     @foreach($admin->role as $role)
                            {{$role->name}}
                     @endforeach
                    </td>
                    @if(auth()->user()->hasRole('super-admin'))
                    <td>
                      @foreach($admin->role as $role)
                          @if($role->slug == 'editor')
                    <button type="button" id="access__btn" class="btn btn-primary" data-id="{{ $admin->id }}" data-toggle="modal" data-target="#exampleModal">
                            Access
                          </button>
                          @endif
                      @endforeach
                    </td>
                    @endif
                    <td>
                        <a href="{{ route('admin.account.view', $admin->id)}}" title="View User" class="btn btn-outline-success">
                          <i class="fa fa-eye"></i>
                        </a>
                        @if(auth()->user()->hasRole('super-admin'))
                          <a href="{{ route('admin.account.edit', $admin->id)}}" title="Edit User" class="btn btn-outline-success">
                            <i class="fa fa-edit"></i>
                          </a>
                          <a href="{{ route('admin.account.delete', $admin->id)}}" onclick="return confirm('Are you sure!')" title="Edit User" class="btn btn-outline-danger">
                            <i class="fa fa fa-fw fa-trash"></i>
                          </a>
                        @endif
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
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="form_id"  method="POST" action="{{route('admin.account.access')}}" >
      @csrf
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Access control</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="form-check">
              <input type="hidden" name="user_id" value="" id="user_id">
              <input class="form-check-input" type="checkbox" name="access[]" id="skill" value="skill" >
              <label class="form-check-label" for="skill">
                  Skill
              </label>
          </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="access[]" id="personality" value="personality" >
              <label class="form-check-label" for="personality">
                  Personality
              </label>
          </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="access[]" id="aptitude" value="aptitude" >
              <label class="form-check-label" for="aptitude">
                Aptitude
              </label>
          </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="access[]" id="template" value="template" >
              <label class="form-check-label" for="template">
                  Template
              </label>
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
    </form>
    </div>
  </div>
</div>

@endsection
@section('scripts')
<script>
  $(function(){
    $('#exampleModal').on('shown.bs.modal', function (event) {
      let id = $(event.relatedTarget).data('id')
      $("#form_id").trigger("reset");
      $(this).find('.modal-body #user_id').val(id)
    })
  })
</script>
@endsection
