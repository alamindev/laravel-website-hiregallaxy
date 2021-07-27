<?php

namespace App\Http\Controllers\Frontend;


use App\Notifications\StatusEmail;
use App\Helpers\General\CollectionHelper;
use App\Helpers\ImageUploadHelper;
use App\Http\Controllers\Controller;
use App\Models\CandidateProfile;
use App\Models\Category;
use App\Models\City;
use App\Models\CompanyProfile;
use App\Models\Country;
use App\Models\Experience;
use App\Models\UserQualification;
use App\Models\Job;
use App\Models\JobActivity;
use App\Models\Personality;
use App\Models\PersonalityResult;
use App\Models\Result;
use App\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Excel;
class EmployersController extends Controller
{

    public function index(Request $request)
    {

        $paginateNumber = 10;

        // You are watching text

        if ($request->page) {

            $pageNo = $request->page;

        } else {

            $pageNo = 0;

        }

        $users = User::where('status', 1)->where('is_company', 1)->orderBy('created_at','desc')->paginate($paginateNumber);

        $total_user = count($users);

        $pageNoText = $paginateNumber * $pageNo . ' to ' . ($pageNo * $paginateNumber + $total_user);

        return view('frontend.pages.employers.index', compact('users', 'pageNoText'));

    }

    public function show($username)
    {

        $user = User::where('username', $username)->first();

        if (is_null($user) || $user->is_company == 0) {

            session()->flash('error', 'No Employer has been found  ');

            return redirect()->route('employers');

        }

        //       $user->company->update([

        //           'total_view' => $user->company->total_view + 1

        //       ]);

        $company = CompanyProfile::where('user_id', $user->id)->first();

        if ($company) {
            $company->total_view = $company->total_view + 1;

            $company->save();
        }

        $results = Result::where('status', 1)->select('job_id')->get();

        return view('frontend.pages.employers.show', compact('user', 'results'));

    }

    public function search(Request $request)
    {

        $search = $country = $category = $country_id = $category_id = null;

        $categories = Category::orderBy('name', 'asc')->where('status', 1)->get();

        $paginateNumber = 10;

        // You are watching text

        if ($request->page) {

            $pageNo = $request->page;

        } else {

            $pageNo = 0;

        }

        $pdo = DB::connection()->getPdo();

        $sql = 'select users.id

                from users

                left join company_profiles on users.id = company_profiles.user_id

                left join locations on locations.id = users.location_id

                left join jobs on jobs.user_id = users.id

                where users.is_company=1 and users.status=1

        ';

        if ($request->search && $request->search != '') {

            //$sql .= " and users.name like '%$request->search%' or users.about like '%$request->search%' or jobs.title like '%$request->search%'";

            $sql .= " and users.name like '%$request->search%' ";

        }

        if ($request->city && $request->city != 'all') {

            $city_id = $request->city;

            $city = Country::where('name', $city_id)->first();
            if ($city) {
                $sql .= " and locations.country_id = $city->id";
            }

        }

        if ($request->country && $request->country != 'all') {

            $country_id = $request->country;

            $country = City::where('name', $country_id)->first();
            if ($country) {
                $sql .= " and company_profiles.country_id = $country->id ";
            }

        }

        if ($request->sector) {
            $sectors = implode(',', $request->sector);

            $sql .= " and company_profiles.sector_id like '%$sectors%' ";

        }
        // if ($request->category != null && $request->category != 'all') {

        //     $category = $request->category;

        //     $category_id = Category::where('slug', $category)->first()->id;

        //     $sql .= " and company_profiles.category_id = $category_id ";

        // }

        $team = null;

        if ($request->team != null && $request->team != '') {

            $sql .= " and company_profiles.team_member = '$request->team'";

        }

        $stmt = $pdo->prepare($sql);

        $stmt->execute();

        $user_ids = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $users = User::whereIn('id', $user_ids)->paginate($paginateNumber);

        $total_users = count($users);

        $pageNoText = $paginateNumber * $pageNo . ' to ' . ($pageNo * $paginateNumber + $total_users);

        return view('frontend.pages.employers.index', compact('users', 'categories', 'pageNoText', 'search', 'country', 'category'));

    }

    public function updateAbout(Request $request, $user_id)
    {

        if (!Auth::check() && Auth::id() != $user_id) {

            session()->flash('error', 'Sorry   You are not permitted to do this action');

            return redirect()->route('index');

        }

        $this->validate($request, [

            'about' => 'required',

        ]);

        $user = User::find($user_id);

        $user->about = $request->about;

        session()->flash('success', 'Your profile about information has been updated  ');

        $user->save();

        return redirect()->route('employers.show',$user->username);

    }

    public function applicantUpdate(Request $request, $id)
    {
        //session()->flash('success', $user_id);

        // if (!Auth::check() && Auth::id() != $user_id) {

        //     session()->flash('error', 'Sorry   You are not permitted to do this action');

        //     return redirect()->route('index');

        // }

        if (!Auth::check()) {

            session()->flash('error', 'Sorry   You are not an authenticated Employer  ');

            return redirect()->route('index');

        }

        // $user = Auth::user();

        $userData = DB::table('job_activities')->where('id', $id)->first();

        if($userData){

            $user_id = $userData->user_id;
            $user = User::find($user_id);
            $data['name'] = $name = $user->name;
            $data['email'] = $email = $user->email;
            $data['username'] = $username = $user->username;

            $jobId = $userData->job_id;
            $jobs = DB::table('jobs')->where('id', $jobId)->first();

            $user['id'] = $jobs->id;
            $user['title'] = $jobs->title;
            $user['slug'] = $jobs->slug;
            $user['status'] = $request->status;

            $user->notify(new StatusEmail($user));
        }

        if ($request->status == 'Hired') {
            $timezone = date_default_timezone_get();
            date_default_timezone_set($timezone);
            $date = date('Y-m-d H:i:s', time());
            DB::table('job_activities')->where('id', $id)->update(array('status' => $request->status, 'hired_at' => $date));
            session()->flash('success', 'Applicant status has been updated  ');
        } elseif ($request->status == 'Rejected') {
            $timezone = date_default_timezone_get();
            date_default_timezone_set($timezone);
            $date = date('Y-m-d H:i:s', time());
            DB::table('job_activities')->where('id', $id)->update(array('status' => $request->status, 'rejected_at' => $date));
            session()->flash('success', 'Applicant status has been updated  ');
        } elseif ($request->status == 'Shortlisted') {
            $timezone = date_default_timezone_get();
            date_default_timezone_set($timezone);
            $date = date('Y-m-d H:i:s', time());
            DB::table('job_activities')->where('id', $id)->update(array('status' => $request->status, 'shortlisted_at' => $date));
            session()->flash('success', 'Applicant status has been updated  ');
        } elseif ($request->status == 'Interview') {
            $timezone = date_default_timezone_get();
            date_default_timezone_set($timezone);
            $date = date('Y-m-d H:i:s', time());
            DB::table('job_activities')->where('id', $id)->update(array('status' => $request->status, 'interview_at' => $date));
            session()->flash('success', 'Applicant status has been updated  ');
        } elseif ($request->status == 'Offered') {
            $timezone = date_default_timezone_get();
            date_default_timezone_set($timezone);
            $date = date('Y-m-d H:i:s', time());
            DB::table('job_activities')->where('id', $id)->update(array('status' => $request->status, 'offered_at' => $date));
            session()->flash('success', 'Applicant status has been updated  ');
        } else {
            session()->flash('success', 'Applicant status has been updated  ');
        }

        return redirect()->back();
        //return redirect()->route('employers.dashboard', compact('user'));
        // return redirect('frontend.pages.employers.dashboard', compact('user'));
        //return redirect()->back();

        //return view('frontend.pages.employers.dashboard', compact('user'));

    }

    public function updateProfile(Request $request, $user_id)
    {
        if (!Auth::check() && Auth::id() != $user_id) {

            session()->flash('error', 'Sorry   You are not permitted to do this action');

            return redirect()->route('index');

        }

        $this->validate($request, [

            'name' => 'required|max:30',

            'category_id' => 'required|numeric',

            // 'profile_picture' => 'nullable|image',

            'website' => 'nullable',

            'facebook_link' => 'nullable',

            'twitter_link' => 'nullable',

            'linkedin_link' => 'nullable',

            'google_plus_link' => 'nullable',

        ]);

        $user = User::find($user_id);

        $user->name = $request->name;

        $user->website = $request->website;

        $user->facebook_link = $request->facebook_link;

        $user->twitter_link = $request->twitter_link;

        $user->linkedin_link = $request->linkedin_link;

        $user->whatsapp = $request->whatsapp;
        $user->google_plus_link = $request->google_plus_link;

        $user->phone_no = $request->phone_no;

        if ($request->profile_picture) {

            $user->profile_picture = ImageUploadHelper::update('profile_picture', $request->file('profile_picture'), 'pr-' . time(), 'images/users', 'images/users/' . $user->profile_picture);

        }

        $user->save();

        $user->company->update([

            'category_id' => $request->category_id,

            'establish_date' => Carbon::parse($request->establish_date)->format('Y-m-d'),

            'establish_year' => Carbon::parse($request->establish_date)->format('Y'),

            'team_member' => $request->team_member,

        ]);

        // If not empty sectors[] then add this to user_sectors table

        if (count($request->sectors) != 0) {

            // Delete all existings

            $user_id = $user->id;

            DB::table('user_sectors')->where('user_id', $user_id)->delete();

            foreach ($request->sectors as $sector) {

                $sector_id = $sector;

                DB::table('user_sectors')->insert([

                    'sector_id' => $sector_id,

                    'user_id' => $user_id,

                ]);

            }

        }

        session()->flash('success', 'Your profile information has been updated  ');

        return redirect()->route('employers.show', $user->username);

    }

    public function dashboard()
    {

        if (!Auth::check()) {

            session()->flash('error', 'Sorry   You are not an authenticated Employer  ');

            return redirect()->route('index');

        }

        $user = User::where('id', auth()->user()->id)
            ->with('teams')
            ->first();

        $collection = collect($user->teams);
        $filtered_id = $collection->pluck('id');

        $team_job_count = Job::whereIn('user_id', $filtered_id)->count();

        $applicant_count = JobActivity::whereIn('company_id', $filtered_id)->count();
        $new_count = JobActivity::whereIn('company_id', $filtered_id)->where('status', 'New')->count();
        $short_count = JobActivity::whereIn('company_id', $filtered_id)->where('status', 'Shortlisted')->count();
        $interview_count = JobActivity::whereIn('company_id', $filtered_id)->where('status', 'Interview')->count();
        $offered_count = JobActivity::whereIn('company_id', $filtered_id)->where('status', 'Offered')->count();
        $hired_count = JobActivity::whereIn('company_id', $filtered_id)->where('status', 'Hired')->count();
        $reject_count = JobActivity::whereIn('company_id', $filtered_id)->where('status', 'Rejected')->count();

        $candidates = JobActivity::all();

        return view('frontend.pages.employers.dashboard',
            compact('user', 'candidates', 'team_job_count', 'applicant_count', 'new_count', 'short_count', 'interview_count', 'offered_count', 'hired_count', 'reject_count'));

    }

    public function applicants()
    {

        if (!Auth::check()) {

            session()->flash('error', 'Sorry   You are not an authenticated Employer  ');

            return redirect()->route('index');

        }

        $user = Auth::user();

        $user_id = $user->id;

        $applicant = DB::table('applicants')->where('company_id', $user_id)->get();

        return view('frontend.pages.employers.applicants', compact('user', 'applicant'));

    }

    public function applicantEdit($id)
    {

        //session()->flash('error', $id);

        if (!Auth::check()) {

            session()->flash('error', 'Sorry   You are not an authenticated Employer  ');

            return redirect()->route('index');

        }

        $user = Auth::user();

        $user_id = $user->id;

        $applicant = DB::table('job_activities')->where('id', $id)->get();

        //$candi = $applicant->user_id;

        return view('frontend.pages.employers.edit', compact('user', 'applicant'));

    }

    // public function favoriteJobs()

    // {

    //     if (!Auth::check()) {

    //         session()->flash('error', 'Sorry   You are not an authenticated Employer  ');

    //         return redirect()->route('index');

    //     }

    //     $user = Auth::user();

    //     $user_id = $user->id;

    //     $pdo = DB::connection()->getPdo();

    //     $sql = "select job_favorites.job_id

    //             from job_favorites

    //             left join users on job_favorites.user_id = users.id

    //             where users.id = $user_id";

    //     $stmt = $pdo->prepare($sql);

    //     $stmt->execute();

    //     $job_ids = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    //     $jobs = Job::whereIn('id', $job_ids)->paginate(20);

    //     return view('frontend.pages.employers.favorite-jobs', compact('user', 'jobs'));

    // }

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

        return view('frontend.pages.employers.search-candidates', compact('user', 'results', 'find'));

    }

    public function applicantList($status, $slug)
    {

        if (!Auth::check()) {

            session()->flash('error', 'Sorry   You are not an authenticated Employer  ');

            return redirect()->route('index');

        }

        $user = Auth::user();

        $user_id = $user->id;

        $job = Job::where('slug', $slug)->first();

        $applicant = JobActivity::where('status', $status)->where('company_id', $user_id)->where('job_id', $job->id)->get();

        return view('frontend.pages.employers.listed', compact('user', 'applicant', 'status', 'slug'));

    }

    public function postedJobs()
    {

        if (!Auth::check()) {

            session()->flash('error', 'Sorry   You are not an authenticated Employer  ');

            return redirect()->route('index');

        }

        $user = Auth::user();

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

        return view('frontend.pages.employers.posted-jobs', compact('user', 'jobs', 'user_jobs_count', 'user_active_jobs_count', 'user_inactive_jobs_count'));

    }

    public function listedJobs($status)
    {

        if (!Auth::check()) {

            session()->flash('error', 'Sorry   You are not an authenticated Employer  ');

            return redirect()->route('index');

        }

        $user = Auth::user();

        $user_id = $user->id;

        if ($status == 'Live') {

            $timezone = date_default_timezone_get();

            $date = date('Y/m/d H:i:s');

            $jobs = \App\Models\Job::where('user_id', $user->id)->where('deadline', '>', $date)->get();

        } elseif ($status == 'In-progress') {

            $timezone = date_default_timezone_get();

            $date = date('Y/m/d H:i:s');

            $jobs = \App\Models\Job::where('user_id', $user->id)->where('deadline', '<', $date)->where('archived', 0)->get();

        } elseif ($status == 'Archived') {

            $timezone = date_default_timezone_get();

            $date = date('Y/m/d H:i:s');

            $jobs = \App\Models\Job::where('user_id', $user->id)->where('archived', 1)->get();

        } else {

            $jobs = \App\Models\Job::where('user_id', $user->id)->get();

        }

        return view('frontend.pages.employers.listed-jobs', compact('user', 'jobs', 'status'));

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

        return view('frontend.pages.employers.messages', compact('user', 'received_messages', 'sent_messages'));

    }

    public function jobApplications(Request $request, $slug)
    {

        if (!Auth::check()) {

            session()->flash('error', 'Sorry   You are not an authenticated Employer  ');

            return redirect()->route('index');

        }

        $user = Auth::user();

        $user_id = $user->id;

        $applicant = DB::table('job_activities')->where('user_id', $user_id)->get();

        $job = Job::where('slug', $request->slug)->first();

        // Filter application

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

            // Filter

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

        // return $applications;

        $applications = $application_data;

        if (request()->has('export')) {

            $export = new \App\Exports\JobApplicationExport($job, $applications);

            return  Excel::download($export, $job->slug . '_' . time() . '.xlsx');

        }


        return view('frontend.pages.employers.job-applications', compact('user', 'job', 'slug'));
    }

/*
=====================================================================================================================================
Dashboard icons
=====================================================================================================================================
 */

    public function candidatesDisplay($status)
    {

        if (!Auth::check()) {

            session()->flash('error', 'Sorry   You are not an authenticated Employer  ');

            return redirect()->route('index');

        }

        $user = Auth::user();

        $user_id = $user->id;

        $job = Job::where('user_id', $user_id)->first();

        if($job){
            $slug = $job->slug;
            $applicant = JobActivity::where('status', $status)->where('company_id', $user_id)->get();

            return view('frontend.pages.employers.candidate', compact('user', 'applicant', 'status', 'slug'));

        }

        return redirect()->back();


    }

/* =====================================================================================================================*/

    public function totalApplications()
    {

        //session()->flash('success', 'We are here ');

        if (!Auth::check()) {

            session()->flash('error', 'Sorry   You are not an authenticated Employer  ');

            return redirect()->route('index');

        }

        $user = Auth::user();

        $company_id = $user->id;

        $applicant = JobActivity::where('company_id', $company_id)->get();

        return view('frontend.pages.employers.total', compact('user', 'applicant'));

    }

/*
==========================================================================================================================================
end
==========================================================================================================================================
 */

    /**

     * deleteJob

     *

     * @param string $slug

     * @return void

     */

    public function deleteJob($slug)
    {

        $job = Job::where('slug', $slug)->first();

        if (!is_null($job)) {

            if (!Auth::check() && $job->user_id !== Auth::id()) {

                session()->flash('error', 'Sorry   You are not an authenticated Employer to delete this job  ');

                return redirect()->route('index');

            }

            // Delete All job activities

            $jobActivities = JobActivity::where('job_id', $job->id)->get();

            foreach ($jobActivities as $activity) {

                // Get User and check if the CV is not the user default CV,

                // if not then delete the cv from file path

                $appliedUser = CandidateProfile::where('user_id', $activity->user_id)->first();

                if (!is_null($appliedUser)) {

                    $uploaded_cv = $activity->cv;

                    $user_cv = url('/files/cv/') . $appliedUser->cv;

                    if ($user_cv != $uploaded_cv) {

                        // Delete Uploaded New CV for that jobs

                        if (File::exists($uploaded_cv)) {

                            unlink($uploaded_cv);

                        }

                    }

                }

                $activity->delete();

            }

            $job->delete();

            session()->flash('success', 'Job has been deleted  ');

        } else {

            session()->flash('error', 'No job has been found  ');

        }

        return redirect()->route('index');

    }

    public function Personality($id)
    {

        if (!Auth::check()) {

            session()->flash('error', 'Sorry   You are not an authenticated Employer  ');

            return redirect()->route('index');

        }

        $user = User::where('id', $id)->first();

        if ($user) {

            $personality_result = PersonalityResult::where('user_id', $user->id)->select('id', 'personality_result')->first();

            $personality = Personality::where('title', '=', $personality_result['personality_result'])

                ->select('id', 'title', 'sub_title', 'description', 'strengths', 'weaknesses')->first();

            return view('frontend.pages.employers.personality', compact('personality', 'user'));

        } else {

            return redirect()->back();

        }

    }


    public function changePassword()
    {

        if (!Auth::check()) {

            session()->flash('error', 'Sorry  You are not an authenticated Employer  ');

            return back();

        }

        $user = User::where('id', auth()->user()->id)
            ->with('teams')
            ->first();

        $collection = collect($user->teams);
        $filtered_id = $collection->pluck('id');

        $team_job_count = Job::whereIn('user_id', $filtered_id)->count();

        $applicant_count = JobActivity::whereIn('company_id', $filtered_id)->count();
        $new_count = JobActivity::whereIn('company_id', $filtered_id)->where('status', 'New')->count();
        $short_count = JobActivity::whereIn('company_id', $filtered_id)->where('status', 'Shortlisted')->count();
        $interview_count = JobActivity::whereIn('company_id', $filtered_id)->where('status', 'Interview')->count();
        $offered_count = JobActivity::whereIn('company_id', $filtered_id)->where('status', 'Offered')->count();
        $hired_count = JobActivity::whereIn('company_id', $filtered_id)->where('status', 'Hired')->count();
        $reject_count = JobActivity::whereIn('company_id', $filtered_id)->where('status', 'Rejected')->count();

        $candidates = JobActivity::all();

        return view('frontend.pages.employers.change',
            compact('user', 'candidates', 'team_job_count', 'applicant_count', 'new_count', 'short_count', 'interview_count', 'offered_count', 'hired_count', 'reject_count'));

    }

    public function passwordChangeUpdate(Request $request)
    {

        if (!Auth::check()) {

            session()->flash('error', 'Sorry   You are not an authenticated Employer  ');

            return back();

        }


        $this->validate($request, [

            'new_password' => 'required|min:8',
            'confirm_password' => 'required|min:8',
            'old_password' => 'required|min:8',

        ]);


        $user = Auth::user();

        $user_id = $user->id;


        if($request->new_password != $request->confirm_password)
        {
            session()->flash('error', 'Confirm Password Must Be Same !');
        }
        else
        {
            $checkPassword = User::where('id', $user_id)->first();

            if($checkPassword)
            {
                if(password_verify($request->old_password,$checkPassword->password))
                {

                    $profile = User::find($user_id);
                    $profile->password = bcrypt($request->new_password);
                    $profile->save();
                    session()->flash('success', 'Password Changed SuccessFully !');
                }
                else
                {
                    session()->flash('error', 'Old Password Does Not Match !');
                }
            }
            else
            {
                session()->flash('error', 'No data found !');
            }

            return back();
        }

    }



}
