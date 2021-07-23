@extends('backend.layouts.master')

@section('stylesheets')
{{--  <link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.0/css/select.dataTables.min.css">  --}}
<style>
    table.dataTable tr th.select-checkbox.selected::after {
        content: "✔";
        margin-top: -11px;
        margin-left: -4px;
        text-align: center;
        border: 1px solid #ddd;
        text-shadow: rgb(176, 190, 217) 1px 1px, rgb(176, 190, 217) -1px -1px, rgb(176, 190, 217) 1px -1px, rgb(176, 190, 217) -1px 1px;
    }

    th.select-checkbox.sorting_disabled:after {
        content: ' ';
        border-radius: 3px;
        padding: 1px 16px 6px 16px;
        margin-left: 6px;
        border: 1px dotted gray;
    }

    th.select-checkbox.sorting_disabled {
        background: #eee;
        border: 1px solid #ddd;
    }
</style>
@show

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 float-left">Assign Site</h1>
    <div class="breadcrumb-holder float-right">
        <ol class="breadcrumb float-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Assign Site</li>
        </ol>
        <div class="clearfix"></div>
    </div>
</div>


<div class="main-body">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <div class="card mb-3">
            <div class="card-header py-3">
                <div class="float-left">
                    <h6 class="m-0 font-weight-bold text-primary">Assign Site</h6>
                </div>
                <div class="float-right">
                    <a href="{{ route('admin.sites.asignSiteList') }}" class="btn btn-primary">
                        <i class="fa fa-arrow-left"></i> All Assigned Site List
                    </a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="card-body">
                @include('backend.partials.message')

                <form action="{{ route('admin.sites.assign.store') }}" method="post" data-parsley-validate>
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <div class="table-responsive">
                                <table id="crawlerTable" width="100%" cellspacing="0" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="30px">
                                                <input type="checkbox" name="checkAll" id="checkAll" >
                                            </th>
                                            <th>Url</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($crawlers) > 0)
                                        @foreach($crawlers as $crawler)
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="crawler_ids[]" value="{{ $crawler->id }}"
                                                    class="check_single">

                                            </td>
                                            <td>
                                                <a href="{{ $crawler->url }}" target="_blank"><i class="fa fa-link"></i>
                                                    {{ $crawler->url }}</a>
                                            </td>
                                        </tr>


                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div> <!-- end .col-md-8 -->

                        <div class="col-md-4">
                            <div class="card card-body">
                                <label for="site_id">Select Site to assign <span class="text-danger">*</span></label>
                                <select name="site_id" id="site_id" class="form-control" required>
                                    <option value="">Select a site</option>
                                    @foreach ($sites as $site)
                                    <option value="{{ $site->id }}">{{ $site->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="float-right">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fa fa-check"></i> Assign Site
                        </button>
                    </div>
                </form>


            </div><!-- end card-->
        </div>
    </div>
</div>

@endsection

@section('scripts')
{{--  <script src="https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>  --}}
<script>
    $('#crawlerTable').DataTable({
        "sort": false,
        "ordering": false
    });

    $("#checkAll").change(function(){

        if($(this).is(':checked')){
            $(':checkbox').each(function() {
                this.checked = true;
            });
        }else{
            $(':checkbox').each(function() {
                this.checked = false;
            });
        }
    });

    var total_not_checked = 0;
    $(".check_single").change(function(){
        //if(!$(this).is(':checked')){
        //    $("#checkAll"). prop("checked", false);
        //}

        $('.check_single').each(function() {
            if($(this).is(':checked')){
                if(total_not_checked != 0){
                    total_not_checked--;
                }
            }else{
                total_not_checked++;
            }
        });

        if(total_not_checked > 0)  {
            $("#checkAll"). prop("checked", false);
        }else{
            $("#checkAll"). prop("checked", true);
        }
    });


    {{--  let crawlerTable = $('#crawlerTable').DataTable({
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets: 0
        }],
        select: {
            style: 'os',
            selector: 'td:first-child'
        },
        order: [
            [1, 'asc']
        ]
    });
    crawlerTable.on("click", "th.select-checkbox", function() {
        if ($("th.select-checkbox").hasClass("selected")) {
            crawlerTable.rows().deselect();
            $("th.select-checkbox").removeClass("selected");
        } else {
            crawlerTable.rows().select();
            $("th.select-checkbox").addClass("selected");
        }
    }).on("select deselect", function() {
        ("Some selection or deselection going on")
        if (crawlerTable.rows({
                selected: true
            }).count() !== crawlerTable.rows().count()) {
            $("th.select-checkbox").removeClass("selected");
        } else {
            $("th.select-checkbox").addClass("selected");
        }
    });  --}}
</script>
@endsection
