@extends('frontend.layouts.master-two')

@section('stylesheets')
<link href="{{ asset('admin-asset/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<style>

#dataTable img {



width: auto !important;

height: auto !important;



}

</style>

@endsection



@section('content')

<div class="container pt-5">


    <div class="main-body">

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="alert alert-danger">
                Note: To work skill test, please enter 30 questions per position
            </div>
            <div class="card mb-3">

                <div class="card-header py-3">

                    <div class="float-left">

                        <h6 class="m-0 font-weight-bold text-primary">All Questions</h6>

                    </div>

                    <div class="float-right">



                        <a href="{{ route('question.create') }}" class="  btn btn-sm btn-primary shadow-sm"><i
                                class="fa fa-plus-circle fa-sm text-white-50"></i> Add New Question</a>

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

                                    <th width="30%">Question</th>

                                    <th width="10%">Skill</th>
                                    <th width="10%">Position</th>

                                    <th width="15%">Experience</th>
                                    <th width="10%">Editor</th>
                                    <th width="15%" class="sortoff">Manage</th>

                                </tr>

                            </thead>

                            <tbody>

                                @foreach($questions as $key=>$question)

                                <tr>

                                    <td>{{$key+1}}</td>

                                    <td> {!! $question->question !!}</td>

                                    <td>

                                        @foreach($question->getAllSkill() as $skll)

                                        <span class="badge badge-success">{{$skll}}</span>

                                        @endforeach

                                    </td>

                                    <td> @foreach($question->getAllPosition() as $e)

                                        <span class="badge badge-success">{{$e}}</span>

                                        @endforeach</td>



                                    <td>
                                        @foreach($question->getAllExperience() as $e)

                                        <span class="badge badge-success">{{$e}}</span>

                                        @endforeach</td>
                                    <td>{{ $question->user->email }}</td>

                                    <td>

                                        <a href="{{route('question.show', $question->id)}}" title="View Question"
                                            class="btn btn-outline-success btn-sm">

                                            <i class="fa fa-eye"></i>

                                        </a>

                                        <a href="{{route('question.edit',$question->id)}}" title="Edit Question"
                                            class="btn btn-outline-success btn-sm">

                                            <i class="fa fa-edit"></i>

                                        </a>

                                        <a href="{{route('question.delete', $question->id)}}"
                                            onClick="return confirm('Are you sure?')" title="Delete Question"
                                            class="btn btn-outline-danger btn-sm">

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
</div>




@endsection

@section('scripts')
<script src="{{ asset('admin-asset/vendor/datatables/jquery.dataTables.min.js') }}"></script>



<script src="{{ asset('admin-asset/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script>
    $(document).ready(function() {
    $("#dataTable").DataTable({
        aoColumnDefs: [{
            bSortable: false,
            aTargets: ["sortoff"]
        }]
    });
});
</script>
@endsection

