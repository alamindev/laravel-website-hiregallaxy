<html>
@php
$user = $data['user'];
@endphp

<head>
    <link rel="stylesheet" href="{{ asset('public/css/bootstrap/pdf-bootstrap.css') }}" />
    <style>
        /** Custom CSS **/

        p,
        td {
            font-size: 12px;
            padding: 0px;
            margin: 0px;
        }

        .width100 {
            width: 100%;
        }

        .width50Left {
            width: 50%;
            float: left;
        }

        .profile-img {
            width: 100px;
            height: 100px;
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
</head>

<body>
    <div class="resume-page">

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
        <div class="educations-part mt-3">
            <h5 class="header-subtitle">
                Objective
            </h5>
            <div>
                {!! $user->about !!}
            </div>
        </div>
    </div>
    <!-- End Objectives Part -->

    <!-- Education -->
    <div class="educations-part mt-3">
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
                    <div class="width50Left font-12 text-bold">
                        {{ $qualification->major_subject }} -
                        {{ $qualification->certificate_degree_name }}
                    </div>
                    <div class="width22Right">
                        <div class="text-right bg-dark text-white pr-2 font-12" style="display:inline">
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
                    <p class="font-12 pl-4">
                        {{ $qualification->description }}
                    </p>

                </div>

            </div>
            @endforeach
        </div>
    </div>
    <!-- End Education Part -->

    <!-- Start Experience -->
    <div class="experiences-part mt-3">
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
                    <div class="width50Left font-12 text-bold">
                        {{ $exp->job_title }}
                    </div>
                    <div class="width22Right">
                        <div class="text-right bg-dark text-white pr-2 font-12" style="display:inline">
                            {{ $exp->start_date }} -
                            {{ $exp->is_current_job ? 'Present' : $exp->end_date }}
                        </div>
                    </div>
                </div>
                <div>
                    <p>
                        {{ $exp->company_name }}
                    </p>
                    <p class="font-12 pl-4">
                        {{ $exp->description }}
                    </p>

                </div>

            </div>
            @endforeach
        </div>
    </div>
    <!-- End Experience Part -->


    <!-- Start Skills -->
    <div class="awards-part mt-3">
        <h5 class="header-subtitle">
            Skills
        </h5>
        <div>
            @php
            $user_awards = $user->awards()->orderBy('date', 'desc')->get();
            @endphp
            <table class="table-skill">
                <thead>
                    <tr>
                        <td>No.</td>
                        <td>Skill Name</td>
                        <td>Skill Proficiency</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user->skills as $sk)
                    <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td>
                            {{ $sk->skill->name }}
                        </td>
                        <td>
                            {{ $sk->percentage }}%
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
    <!-- End Skills Part -->



    <!-- Start Portfolios -->
    <div class="awards-part mt-3">
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
                    <div class="width50Left font-12 text-bold">
                        {{ $portfolio->title }}
                    </div>
                    <div class="width22Right">
                        <div class="text-right pr-2 font-12" style="display:inline">
                            {{ $portfolio->link }}
                        </div>
                    </div>
                </div>
                <div>
                    <p class="font-12 pl-4">
                        {{ $portfolio->description }}
                    </p>

                </div>

            </div>
            @endforeach
        </div>
    </div>
    <!-- End Portfolios Part -->


    <!-- Start Awards and Prizes -->
    <div class="awards-part mt-3">
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
                    <div class="width50Left font-12 text-bold">
                        {{ $award->award_name }}
                    </div>
                    <div class="width15Right">
                        <div class="text-right bg-dark text-white pr-2 font-12" style="display:inline">
                            {{ $award->date }}
                        </div>
                    </div>
                </div>
                <div>
                    <p>
                        {{ $award->company_name }}
                    </p>
                    <p class="font-12 pl-4">
                        {{ $award->description }}
                    </p>

                </div>

            </div>
            @endforeach
        </div>
    </div>
    <!-- End Awards and Prizes Part -->


    </div>
</body>

</html>