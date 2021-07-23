<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\ImageUploadHelper;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanyProfile;
use App\Models\Experience;
use App\Models\Job;
use App\Models\JobActivity;
use App\Models\Location;
use App\Models\UserQualification;
use App\Models\UserTeam;
use App\User;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->check() && auth()->user()->is_company == 1) {
            $users = User::where('type', 1)
                ->whereHas('team', function ($query) {
                    $query->where('employer_id', auth()->user()->id);
                })
                ->with(['location' => function ($q) {
                    $q->select('id', 'country_id');
                }])
                ->select('id', 'name', 'email', 'phone_no', 'location_id', 'status')
                ->get();
            return view('frontend.pages.teams.teams', compact('users'));
        } else {
            return redirect()->back()->with('errors', 'Permission denied');
        }
    }
    /**
     * Display dashboard element
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard($id)
    {
        if (auth()->check()) {

            if ($id == auth()->user()->id) {
                $user = User::where('type', 1)->where('id', auth()->user()->id)->select('id', 'name', 'username', 'email')->first();
            } else {
                $user = User::where('type', 1)->where('id', $id)->select('id', 'name', 'username', 'email')->first();
            }

            if ($user) {
                return view('frontend.pages.teams.dashboard', compact('user'));
            } else {
                return redirect()->route('teams');
            }
        }
        return redirect()->route('teams');
    }

    public function postedJobs($id)
    {
        if (!Auth::check()) {
            session()->flash('error', 'Sorry   You are not an authenticated Employer  ');
            return redirect()->route('index');
        }

        if ($id == auth()->user()->id) {
            $user = User::where('type', 1)->where('id', auth()->user()->id)->first();
        } else {
            $user = User::where('type', 1)->where('id', $id)->first();
        }

        if (!$user) {
            return redirect()->route('teams');
        }

        $user_id = $user->id;
        $_filter = request()->filter ?? null;
        $jobs = Job::where('user_id', $user_id)
            ->when($_filter == 'active', function ($query) use ($_filter) {
                return $query->where('archived', 0);
            })
            ->when($_filter == 'inactive', function ($query) use ($_filter) {
                return $query->where('archived', 1);
            })
            ->paginate(40);
        $user_jobs = $user->jobs;
        $user_jobs_count = $user_jobs->count();
        $user_active_jobs_count = $user_jobs->where('archived', 0)->count();
        $user_inactive_jobs_count = $user_jobs->where('archived', 1)->count();
        return view('frontend.pages.teams.posted-jobs', compact('id', 'user', 'jobs', 'user_jobs_count', 'user_active_jobs_count', 'user_inactive_jobs_count'));

    }

    public function jobApplications($id, $slug)
    {

        if (!Auth::check()) {

            session()->flash('error', 'Sorry   You are not an authenticated Employer  ');

            return redirect()->route('index');

        }

        if ($id == auth()->user()->id) {
            $user = User::where('type', 1)->where('id', auth()->user()->id)->first();
        } else {
            $user = User::where('type', 1)->where('id', $id)->first();
        }

        if (!$user) {
            return redirect()->route('teams');
        }

        $user_id = $user->id;

        $applicant = DB::table('job_activities')->where('user_id', $user_id)->get();

        $job = Job::where('slug', $slug)->first();

        $expreience_data = Experience::all();
        $filter = [];

        $query = JobActivity::query();

        if (isset(request()->date_from) && isset(request()->date_to)) {
            $query->whereDate('created_at', '>=', request()->date_from);
            $query->whereDate('created_at', '<=', request()->date_to);
            $filter['date_from'] = request()->date_from;
            $filter['date_to'] = request()->date_to;

        }

        if (isset(request()->salary_from) && isset(request()->salary_to)) {
            $query->where('expected_salary', '>=', request()->salary_from);
            $query->where('expected_salary', '<=', request()->salary_to);
            $filter['salary_from'] = request()->salary_from;
            $filter['salary_to'] = request()->salary_to;

        }

        //$applications = $query->where('job_id', $job->id)->get();

        $applications = JobActivity::where('job_id', $job->id)->get();

        $experiences = [];
        $education = [];
        $application_data = [];
        foreach ($applications as $application) {

            if (isset(request()->exp)) {
                $exp_data = CandidateProfile::with('experience')->where('experience_id', request()->exp)->where('user_id', $application->user_id)->first();
                if ($exp_data) {
                    $experiences[] = $exp_data;
                    $education[] = UserQualification::where('user_id', $application->user_id)->first();
                    $application_data[] = $application;
                    $filter['exp'] = request()->exp;
                }
            } else {
                $experiences[] = CandidateProfile::with('experience')->where('user_id', $application->user_id)->first();
                $education[] = UserQualification::where('user_id', $application->user_id)->first();
                $application_data[] = $application;
            }
        }

        $education = $education ? $education[0] : [];
        $experience = $experiences ? $experiences[0] : [];
        $applications = $application_data;
        if (request()->has('export')) {
            $export = new \App\Exports\JobApplicationExport($job, $applications);
            return \Excel::download($export, $job->slug . '_' . time() . '.xlsx');
        }
        if (request()->has('delete')) {
            DB::table('job_activities')->where('id', $applicant->id)->delete();
            session()->flash('success', 'Applicant deleted successfully  ');
        }
        return view('frontend.pages.teams.job-applications', compact('id', 'slug', 'user', 'applicant', 'job', 'applications', 'experience', 'education', 'filter', 'expreience_data'));

    }

    public function totalApplications($id)
    {

        if (!Auth::check()) {

            session()->flash('error', 'Sorry   You are not an authenticated Employer  ');

            return redirect()->route('index');

        }

        if ($id == auth()->user()->id) {
            $user = User::where('type', 1)->where('id', auth()->user()->id)->first();
        } else {
            $user = User::where('type', 1)->where('id', $id)->first();
        }

        if (!$user) {
            return redirect()->route('teams');
        }

        $company_id = $user->id;

        $applicant = JobActivity::where('company_id', $company_id)->get();

        return view('frontend.pages.teams.total', compact('user', 'applicant'));

    }

    public function candidatesDisplay($id, $status)
    {

        if (!Auth::check()) {

            session()->flash('error', 'Sorry   You are not an authenticated Employer  ');

            return redirect()->route('index');

        }
        if ($id == auth()->user()->id) {
            $user = User::where('type', 1)->where('id', auth()->user()->id)->first();
        } else {
            $user = User::where('type', 1)->where('id', $id)->first();
        }

        $user_id = $user->id;

        $job = Job::where('user_id', $user_id)->first();

        $slug = $job->slug;

        $applicant = JobActivity::where('status', $status)->where('company_id', $user_id)->get();

        return view('frontend.pages.teams.candidate', compact('user', 'applicant', 'status', 'slug'));

    }

    public function messages()
    {

        if (!Auth::check()) {

            session()->flash('error', 'Sorry   You are not an authenticated Employer  ');

            return redirect()->route('index');

        }

        $user = Auth::user();

        $user_id = $user->id;

        $received_messages = $user->received_messages()->paginate(20);

        $sent_messages = $user->sent_messages()->paginate(20);

        $user->received_messages()->update(['is_seen' => 1]);

        return view('frontend.pages.teams.messages', compact('user', 'received_messages', 'sent_messages'));

    }

    public function searchCadidates(Request $request)
    {

        if (!Auth::check()) {

            session()->flash('error', 'Sorry   You are not an authenticated Employer  ');

            return redirect()->route('index');

        }

        $user = Auth::user();

        $results = [];

        $find = false;

        if ($request->keyword || $request->experience || $request->country) {

            $keywords = explode(',', $request->keyword);

            $experience = $request->experience;

            $country = $request->country;

            $terms = array_map('trim', $keywords);

            $find = true;

            $users = User::with('categories', 'skills', 'location')->where('status', 1)->where('is_company', 0);

            foreach ($keywords as $keyword) {

                $users->where(function ($query) use ($terms) {

                    foreach ($terms as $term) {

                        $query->where('name', 'LIKE', '%' . $term . '%');

                        $query->orWhere('username', 'LIKE', '%' . $term . '%');

                        $query->orWhere('email', 'LIKE', '%' . $term . '%');

                        $query->orWhere('about', 'LIKE', '%' . $term . '%');

                        $query->orWhere('website', 'LIKE', '%' . $term . '%');

                        $query->orWhere('phone_no', 'LIKE', '%' . $term . '%');

                        $query->orWhereHas('candidate', function ($query) use ($term) {

                            $query->where('gender', 'LIKE', "%$term%");

                            $query->orWhere('date_of_birth', 'LIKE', "%$term%");

                            $query->orWhere('sector', 'LIKE', "%$term%");

                            $query->orWhere('career_level_id', 'LIKE', "%$term%");

                            $query->orWhere('date_of_birth', 'LIKE', "%$term%");

                            $query->orWhere('date_of_birth', 'LIKE', "%$term%");

                        });

                        $query->orWhereHas('candidate.experience', function ($query) use ($term) {

                            $query->where('name', 'LIKE', "%$term%");

                        });

                        $query->orWhereHas('location', function ($query) use ($term) {

                            $query->where('street_address', 'LIKE', "%$term%");

                            $query->orWhere('zip', 'LIKE', "%$term%");

                            $query->orWhere('city', 'LIKE', "%$term%");

                            $query->orWhere('state', 'LIKE', "%$term%");

                        });

                        $query->orWhereHas('location.country', function ($query) use ($term) {

                            $query->where('name', 'LIKE', "%$term%");

                        });

                        $query->orWhereHas('new_categories', function ($query) use ($term) {

                            $query->where('name', 'LIKE', "%$term%");

                        });

                        $query->orWhereHas('new_sectors', function ($query) use ($term) {

                            $query->where('name', 'LIKE', "%$term%");

                        });

                        $query->orWhereHas('new_skills', function ($query) use ($term) {

                            $query->where('name', 'LIKE', "%$term%");

                        });

                        $query->orWhereHas('qualifications', function ($query) use ($term) {

                            $query->where('certificate_degree_name', 'LIKE', "%$term%");

                            $query->orWhere('major_subject', 'LIKE', "%$term%");

                            $query->orWhere('start_date', 'LIKE', "%$term%");

                            $query->orWhere('end_date', 'LIKE', "%$term%");

                            $query->orWhere('institute_university_name', 'LIKE', "%$term%");

                            $query->orWhere('percentage', 'LIKE', "%$term%");

                        });

                        $query->orWhereHas('experiences', function ($query) use ($term) {

                            $query->where('is_current_job', 'LIKE', "%$term%");

                            $query->orWhere('job_title', 'LIKE', "%$term%");

                            $query->orWhere('company_name', 'LIKE', "%$term%");

                            $query->orWhere('job_location_city', 'LIKE', "%$term%");

                            $query->orWhere('job_location_state', 'LIKE', "%$term%");

                            $query->orWhere('job_location_country', 'LIKE', "%$term%");

                            $query->orWhere('description', 'LIKE', "%$term%");

                        });

                        $query->orWhereHas('jobApplications', function ($query) use ($term) {

                            $query->where('expected_salary', 'LIKE', "%$term%");

                            $query->orWhere('salary_currency', 'LIKE', "%$term%");

                            $query->orWhere('cover_letter', 'LIKE', "%$term%");

                        });

                        $query->orWhereHas('jobs', function ($query) use ($term) {

                            $query->where('title', 'LIKE', "%$term%");

                        });

                    }

                });

            }

            if ($country != 'all') {

                $users->whereHas('location.country', function ($query) use ($country) {

                    $query->where('name', 'LIKE', "%$country%");

                });

            }

            if ($experience != 'all') {

                $users = $users->get();

                $min = explode('-', explode(' ', $experience)[0])[0];

                $max = explode('-', explode(' ', $experience)[0])[1];

                $new_user = [];

                foreach ($users as $user) {

                    if (($min <= $user->getExperienceInYears()) && ($user->getExperienceInYears() <= $max)) {

                        $new_user[] = $user;

                    }

                }

                $collection = collect($new_user);

                $total = $collection->count();

                $pageSize = 10;

                $results[] = CollectionHelper::paginate($collection, $total, $pageSize);

            } else {

                $results[] = $users->paginate(10);

            }

        }

        return view('frontend.pages.teams.search-candidates', compact('user', 'results', 'find'));

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('frontend.pages.teams.team-create');
    }

    public function showProfile($username)
    {

        $user = User::where('type', 1)->where('username', $username)->first();

        if (is_null($user)) {

            session()->flash('error', 'No Team has been found  ');

            return redirect()->route('team.dashboard');

        }
        return view('frontend.pages.teams.show', compact('user'));

    }
    public function updateProfile(Request $request, $user_id)
    {

        if (!Auth::check() && Auth::id() != $user_id) {

            session()->flash('error', 'Sorry   You are not permitted to do this action');

            return redirect()->route('index');

        }

        $this->validate($request, [

            'name' => 'required|max:30',

            'profile_picture' => 'nullable|image',

            'website' => 'nullable|url',

            'facebook_link' => 'nullable|url',

            'twitter_link' => 'nullable|url',

            'linkedin_link' => 'nullable|url',

            'google_plus_link' => 'nullable|url',

        ]);

        $user = User::find($user_id);

        $user->name = $request->name;

        $user->website = $request->website;

        $user->facebook_link = $request->facebook_link;

        $user->twitter_link = $request->twitter_link;

        $user->linkedin_link = $request->linkedin_link;

        $user->google_plus_link = $request->google_plus_link;

        $user->phone_no = $request->phone_no;

        if ($request->profile_picture) {

            $user->profile_picture = ImageUploadHelper::update('profile_picture', $request->file('profile_picture'), 'pr-' . time(), 'images/users', 'images/users/' . $user->profile_picture);

        }

        $user->save();

        $user->company->update([

            'establish_date' => $request->establish_date,

            'establish_year' => substr($request->establish_date, 0, 4),

            'team_member' => $request->team_member,

        ]);

        session()->flash('success', 'Your profile information has been updated  ');

        return redirect()->route('index');

    }

    public function Companies($id)
    {
        $companies = Company::where('assign_id', $id)->get();
        return view('frontend.pages.teams.companies', compact('companies', 'id'));
    }
    public function CompanyShow($id)
    {
        $show = Company::where('id', $id)->first();
        if ($show) {
            return view('frontend.pages.teams.company-show', compact('show', 'id'));
        }
        return back();

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required|max:30',
            'email' => 'required|email|unique:users',
            'location' => 'required',
            'password' => 'required|min:8|confirmed',
        ],

            [

                'location.required' => 'Please choose your Location',

                'email.required' => 'Please give an email address',

                'email.email' => 'Please give a valid email address',

                'email.unique' => 'Sorry   An email is already exists',

                'name.required' => 'Please give your name',

                'name.max' => 'Please give your name between 30 characters',

                'password.min' => 'Please give your password more than 8 characters',

                'password.confirmed' => 'Please confirm your password',

            ]

        );

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        // Create location and add location ID

        if (auth()->check() && auth()->user()->is_company == 1) {
            $location = new Location();
            $location->country_id = $request->location;
            $location->save();

            $user = new User();
            $user->name = $request->name;
            $user->username = $request->name . "-" . \Str::random(3);
            $user->email = $request->email;
            $user->phone_no = $request->phone_no;
            $user->location_id = $location->id;
            $user->status = 1;
            $user->is_company = 1;
            $user->api_token = bin2hex(openssl_random_pseudo_bytes(30));
            $user->password = Hash::make($request->password);
            $user->type = 1;
            $user->save();

            $userteam = new UserTeam();
            $userteam->employer_id = auth()->user()->id;
            $userteam->user_id = $user->id;
            $userteam->save();

            $company = new CompanyProfile();

            $company->user_id = $user->id;

            $company->category_id = 85;

            $company->save();

            return redirect()->route('teams')->with('success', 'Profile created successfull');
        } else {
            return redirect()->back()->with('errors', 'Permission denied');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $status)
    {
        $user = User::find($id);
        if ($user) {
            $user->status = $status;
            $user->save();
            return redirect()->back();
        }
    }
}
