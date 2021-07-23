@extends('backend.layouts.master')



@section('content')



<div class="d-sm-flex align-items-center justify-content-between mb-4">

  <h1 class="h3 mb-0 float-left">Job Templates</h1>

  <div class="breadcrumb-holder float-right">

    <ol class="breadcrumb float-right">

      <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>

      <li class="breadcrumb-item active">Job Templates</li>

    </ol>

    <div class="clearfix"></div>

  </div>

</div>


<div class="main-body w-100">

  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

    <div class="card mb-3">

      <div class="card-header py-3">

        <div class="float-left">

          <h6 class="m-0 font-weight-bold text-primary">All Job Templates</h6>

        </div>

        <div class="float-right">

          <a href="{{ route('admin.templates.create') }}"

            class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i

              class="fas fa-plus-circle fa-sm text-white-50"></i> Add New template</a>

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

                <th width="15%">Position</th>

                <th width="15%">Discipline</th>

                <th width="15%" class="sortoff">Manage</th>

              </tr>

            </thead>

            <tbody>

              @if(count($templates) > 0)



              @foreach($templates as $template)



              <tr>

                <td>{{ $loop->index+1 }}</td>

                <td>
{{ isset($template->category->name) ? $template->category->name : '' }}
                </td>

                <td>

                  {{ isset($template->discipline) ? $template->discipline->name : '' }}

                </td>

                <td>

                  <a href="{{ route('admin.templates.show', $template->id) }}" title="View Template"

                    class="btn btn-outline-info">

                    <i class="fa fa-eye"></i>

                  </a>

                  <a href="{{ route('admin.templates.edit', $template->id) }}" title="Edit Template"

                    class="btn btn-outline-success">

                    <i class="fa fa-edit"></i>

                  </a>

                  <button class="btn btn-circle btn-outline-danger" data-toggle="modal"

                    data-target="#deleteModal{{ $template->id }}" title="Delete template"><i

                      class="fa fa-fw fa-trash"></i></button>



                  <!-- Delete Modal-->

                  <div class="modal fade" id="deleteModal{{ $template->id }}" tabindex="-1" role="dialog"

                    aria-labelledby="exampleModalLabel" aria-hidden="true">

                    <div class="modal-dialog" role="document">

                      <div class="modal-content">

                        <div class="modal-header">

                          <h5 class="modal-title" id="exampleModalLabel">Are you sure want to delete this template ?

                          </h5>

                          <button class="close" type="button" data-dismiss="modal" aria-label="Close">

                            <span aria-hidden="true">×</span>

                          </button>

                        </div>

                        <div class="modal-body">Please confirm if you want to delete</div>

                        <div class="modal-footer">

                          <button class="btn btn-outline-secondary btn-sm" type="button"

                            data-dismiss="modal">Cancel</button>

                          <form class="" action="{{ route('admin.templates.destroy', $template->id) }}" method="post">

                            @method('delete')

                            @csrf

                            <button type="submit" class="btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i>

                              Confirm</button>

                          </form>

                        </div>

                      </div>

                    </div>

                  </div>





                </td>

              </tr>



              @endforeach

              @endif

            </tbody>

          </table>

        </div>

      </div><!-- end card-->

    </div>

  </div>

</div>



@endsection

