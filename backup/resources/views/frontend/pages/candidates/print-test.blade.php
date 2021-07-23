<html>

@php

$user = $data['user'];

@endphp



<head>

    <link rel="stylesheet" href="{{ asset('public/css/bootstrap/pdf-bootstrap.css') }}" />

    <style>

        /** Custom CSS  {{ App\Helpers\ReturnPathHelper::getUserImage($user->id) }}**/



        p,

        td {

            font-size: 14px;

            padding: 0px;

            margin: 0px;

        }
        
        .pageSize{
            width:970px;
            margin: 0 auto;
            margin-top: 30px !important;
        }

        .width100 {

            width: 100%;

        }



        .width50Left {

            width: 50%;

            float: left;

        }



        .profile-img {

            height: 80px;
        
        }

        .mar-b-100 {

            margin-bottom:100px;
        
        }



        .width50Right {

            float: right;

            width: 50%;

        }



        .width30Right {

            float: right;

            width: 30%;

        }



        .width40Right {

            float: right;

            width: 40%;

        }



        .width20Right {

            float: right;

            width: 20%;

        }



        .width22Right {

            float: right;

            width: 22%;

        }



        .width10Right {

            float: right;

            width: 10%;

        }



        .width15Right {

            float: right;

            width: 15%;

        }



        .single-item {

            margin-bottom: 10px;

        }



        .clearfix {

            clear: both;

        }



        .header-subtitle {

            text-transform: uppercase;

            font-weight: bold;

            border-bottom: 2px solid #000;
            padding-bottom: 10px;

        }



        .width-200px {

            width: 200px;

        }



        .width-100px {

            width: 100px;

        }


        .table-skill th,

        .table-skill td,

        .table-skill tr {

            padding: 5px !important;

        }



        .table-skill th {

            background: #ccc;

        }



        .font-12 {

            font-size: 12px !important;

        }



        .font-14 {

            font-size: 14px !important;

        }



        .font-16 {

            font-size: 16px !important;

        }



        .text-bold {

            font-weight: bold !important;

        }

    </style>

    <title>

        Resume of {{ $user->name }}

    </title>

    <link rel="shortcut icon" href="{{ App\Helpers\ReturnPathHelper::getUserImage($user->id) }}" type="image/png">

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>

</head>



<body>

    <div class="resume-page pageSize">


        <div class="width100">

            <div class="width50Left">

                <img src="{{ App\Helpers\ReturnPathHelper::getUserImage($user->id) }}" class="profile-img">

            </div>

            <div class="width50Right">

                <h3 class="text-right">{{ $user->name }}</h3>

                <p class="text-right">

                    <i>

                        Curriculam Vitae

                    </i>

                </p>

            </div>

        </div>

        <div class="personal-details-part mt-3">

            <h5 class="header-subtitle">

                Personal Details

            </h5>

            <div>

                <table>

                    <tr>

                        <td class="width-200px">Gender</td>

                        <td>: {{ $user->candidate->gender }}</td>

                    </tr>

                    <tr>

                        <td class="width-200px">Birthdate</td>

                        <td>: {{ $user->candidate->date_of_birth }}</td>

                    </tr>

                    <tr>

                        <td class="width-200px">Address</td>

                        <td>:

                            {{ $user->location->street_address }},

                            {{ $user->location->country->name }}



                        </td>

                    </tr>

                    <tr>

                        <td class="width-200px">Email</td>

                        <td>: {{ $user->email }}</td>

                    </tr>

                </table>

            </div>

        </div>





        <!-- Objectives -->

        <div class="educations-part mt-3 pageSize">

            <h5 class="header-subtitle">

                Objective

            </h5>

            <div>

                {!! $user->about !!}

            </div>

        </div>

    </div>

    <!-- End Objectives Part -->







    <!-- Start Experience -->

    <div class="experiences-part mt-3 pageSize">

        <h5 class="header-subtitle">

            Experiences

        </h5>

        <div>

            @php

            $user_work_experiences = $user->experiences()->orderBy('is_current_job',

            'desc')->orderBy('end_date',

            'desc')->get();

            @endphp

            @foreach ($user_work_experiences as $exp)

            <div class="single-item">

                <div class="width100">

                    <div class="width50Left font-14 text-bold">

                        {{ $exp->job_title }}

                    </div>

                    <div class="width22Right">

                        <div class="text-right bg-dark text-white pr-2 font-14" style="display:inline;float: right;padding-left: 10px;">

                            {{ $exp->start_date }} -

                            {{ $exp->is_current_job ? 'Present' : $exp->end_date }}

                        </div>

                    </div>

                </div>

                <div>

                    <p>

                        {{ $exp->company_name }}

                    </p>

                    <p class="font-14 pl-4">

                        {{ $exp->description }}

                    </p>



                </div>



            </div>

            @endforeach

        </div>

    </div>

    <!-- End Experience Part -->





    <!-- Education -->

    <div class="educations-part mt-3 pageSize">

        <h5 class="header-subtitle">

            Educations

        </h5>

        <div>

            @php

            $user_qualifications = $user->qualifications()->orderBy('is_current_qualification',

            'desc')->orderBy('end_date','desc')->get();

            @endphp

            @foreach ($user_qualifications as $qualification)

            <div class="single-item">

                <div class="width100">

                    <div class="width50Left font-14 text-bold">

                        {{ $qualification->major_subject }} -

                        {{ $qualification->certificate_degree_name }}

                    </div>

                    <div class="width22Right">

                        <div class="text-right bg-dark text-white pr-2 font-14" style="display:inline;float: right;padding-left: 10px;">

                            {{ $qualification->start_date }} -

                            {{ $qualification->is_current_qualification ? 'Present' : $qualification->end_date }}

                        </div>

                    </div>

                </div>

                {{--  <div class="clearfix"></div>  --}}



                <div>

                    <p>

                        {{ $qualification->institute_university_name }}

                    </p>

                    <p class="font-14 pl-4">

                        {{ $qualification->description }}

                    </p>



                </div>



            </div>

            @endforeach

        </div>

    </div>

    <!-- End Education Part -->





    <!-- Start Awards and Prizes -->

    <div class="awards-part mt-3 pageSize">

        <h5 class="header-subtitle">

            Awards & Prizes

        </h5>

        <div>

            @php

            $user_awards = $user->awards()->orderBy('date', 'desc')->get();

            @endphp

            @foreach ($user_awards as $award)

            <div class="single-item">

                <div class="width100">

                    <div class="width50Left font-14 text-bold">

                        {{ $award->award_name }}

                    </div>

                    <div class="width15Right">

                        <div class="text-right bg-dark text-white pr-2 font-14" style="display:inline;float: right;padding-left: 10px;">

                            {{ $award->date }}

                        </div>

                    </div>

                </div>

                <div>

                    <p>

                        {{ $award->company_name }}

                    </p>

                    <p class="font-14 pl-4">

                        {{ $award->description }}

                    </p>



                </div>



            </div>

            @endforeach

        </div>

    </div>

    <!-- End Awards and Prizes Part -->





    <!-- Start Skills -->

    <div class="awards-part mt-3 pageSize">

        <h5 class="header-subtitle">

            Skills

        </h5>

        <div>

            @php

            $user_awards = $user->awards()->orderBy('date', 'desc')->get();

            @endphp

            <table class="table-skill" style="width:100%;">

                <thead>

                   
                </thead>

                <tbody> 
                    <tr> 
                        <td><strong class="text-bold">Skill Name:</strong></td> 
                        @foreach ($user->skills as $sk)
                        <td>

                            {{ $sk->skill->name }}

                        </td> 
                        @endforeach
                    </tr>
                    <tr> 
                        <td><strong class="text-bold">Skill Proficiency: </strong></td> 
                        @foreach ($user->skills as $sk)
                        <td>

                            {{ $sk->percentage }}%

                        </td> 
                        @endforeach
                    </tr>


                </tbody>



            </table>
            
            <div class="chart_Print" style="width:100%;    margin-top: 20px;">
                <div class="chart_Print_Div" style="width:50%;margin:0 auto;">
                    <canvas id="myChart" style="margin:0 auto;" ></canvas>
                </div>
            </div>

        </div>

    </div>

    <!-- End Skills Part -->
 
    <!-- Start Portfolios -->

    <div class="awards-part mt-3 pageSize mar-b-100">

        <h5 class="header-subtitle">

            Portfolios

        </h5>

        <div>

            @php

            $user_portfolios = $user->portfolios()->orderBy('priority', 'asc')->get();

            @endphp

            @foreach ($user_portfolios as $portfolio)

            <div class="single-item">

                <div class="width100">

                    <div class="width50Left font-14 text-bold">

                        {{ $portfolio->title }}

                    </div>

                    <div class="width22Right">

                        <div class="text-right pr-2 font-14" style="display:inline">

                            {{ $portfolio->link }}

                        </div>

                    </div>

                </div>

                <div>

                    <p class="font-14 pl-4">

                        {{ $portfolio->description }}

                    </p>



                </div>



            </div>

            @endforeach

        </div>

    </div>

    <!-- End Portfolios Part -->


    <p style="text-align:center;font-weight:bold;font-size:14px;margin-bottom: 30px;">All rights goes to <a href="https://joblrs.com" target="blank">joblrs.com</a></a></p>
    
    </div>



<script>

window.onload = function () {
    
    var label = {!! json_encode($label) !!};
    var data ={!! json_encode($arr) !!};

    var ctx = document.getElementById('myChart');
    var myChart = new Chart(ctx, {
        type: 'radar',
    	data: {
    		labels: label,
    		datasets: [{
    			label: 'skill',
    			data: data,
    			borderColor: '#6b68e7'
    		}]
    	},
    	options: {
    		legend: {
    				display: false
    			},
    			scale: {
    			angleLines: {
    				display: false
    			},
    			ticks: {
    				suggestedMin: 50,
    				suggestedMax: 100
    			}
    		},
    		tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
    					return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + '%';
    				}
                }
            }
    	}
    });
};

</script>



</body>



</html>