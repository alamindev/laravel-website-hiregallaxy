@extends('backend.layouts.master')

@section('stylesheets')

@show

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 float-left">Assigned Site List</h1>
    <div class="breadcrumb-holder float-right">
        <ol class="breadcrumb float-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Assigned Site List</li>
        </ol>
        <div class="clearfix"></div>
    </div>
</div>


<div class="main-body">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <div class="card mb-3">
            <div class="card-header py-3">
                <div class="float-left">
                    <h6 class="m-0 font-weight-bold text-primary">Assigned Site List</h6>
                </div>
                <div class="float-right">
                    <a href="{{ route('admin.sites.assign') }}" class="btn btn-primary">
                        <i class="fa fa-plus-circle"></i> Assign Site
                    </a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="card-body">
                @include('backend.partials.message')

                <div class="table-responsive">
                    <table id="dataTable" width="100%" cellspacing="0" class="table table-bordered">
                        <thead>
                            <tr>
                                <td>Sl</td>
                                <td>Url</td>
                                <td>Assigned Site</td>
                                <td class="sortoff"><button class="btn btn-outline-danger"><i class="fa fa-trash"></i></button></td>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($crawler_links) > 0)
                            @foreach($crawler_links as $crawler)
                            <tr>
                                <td>
                                    {{ $loop->index+1 }}
                                </td>
                                <td>
                                    @if(!is_null($crawler->crawlerUrl))
                                        {{ $crawler->crawlerUrl->url }}
                                    @endif

                                </td>
                                <td>
                                    @if(!is_null($crawler->crawlerSite))
                                        {{ $crawler->crawlerSite->name }}
                                    @endif

                                </td>
                                <td>
                                    <form action="{{ route('admin.sites.assign.delete', $crawler->id) }}" method="POST">
                                        @method('delete')

                                        <button type="submit" onclick="return confirm('Do you want to delete ?')"
                                            class="btn text-danger">
                                            <i class="fa fa-trash" title="Delete "></i>
                                        </button>
                                        @csrf
                                    </form>
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

@section('scripts')
@endsection
