<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\StringHelper;
use App\Helpers\UploadHelper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Discipline;
use App\Models\Experience;
use App\Models\Job;
use App\Models\JobActivity;
use App\Models\JobApplyType;
use App\Models\JobType;
use App\Models\Location;
use App\Models\Qualification;
use App\Models\Result;
use App\Models\Sector;
use App\Models\Segment;
use App\Models\Skill;
use App\Models\Template;
use App\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobsController extends Controller
{

    /**

     * index

     * @param  Request $request

     * @return view

     */

    public function index(Request $request)
    {

        // $ip = $_SERVER['REMOTE_ADDR'];

        // if ($ip == "::1") {

        //     $ip = "128.100.33.149";

        // }

        // $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}"));

        // $user_city = $details->city;

        // if (!is_null(Country::where('name', $user_city)->first())) {

        //     $city_id = Country::where('name', $user_city)->first()->id;

        // }

        $categories = Category::orderBy('name', 'asc')->where('status', 1)->get();

        $paginateNumber = 20;

        // You are watching text

        if ($request->page) {

            $pageNo = $request->page;

        } else {

            $pageNo = 0;

        }

        $jobs = Job::with('results')->where('is_confirmed', 1)->orderBy('id', 'desc')->where('status_id', 1)->paginate($paginateNumber);

        // if (isset($city_id) && !is_null($city_id) && $city_id != '' && $city_id != 0) {

        //     $jobs = Job::where('is_confirmed', 1)->where('status_id', 1)->orderByRaw(DB::raw("FIELD(country_id , '$city_id') DESC"))->orderBy('id', 'DESC')->paginate($paginateNumber);

        // }

        //orderByRaw('FIELD(language, "USD", "EUR", "JPN")')

        $total_jobs = count($jobs);

        $pageNo = $pageNo != 0 ? $pageNo - 1 : $pageNo;

        $pageNoText = $paginateNumber * $pageNo . ' to ' . ($pageNo * $paginateNumber + $total_jobs);

        // for exam result validation

        return view('frontend.pages.jobs.index', compact('jobs', 'categories', 'pageNoText'));

    }

    public function category(Request $request, $slug)
    {

        // $ip = $_SERVER['REMOTE_ADDR'];

        // if ($ip == "::1") {

        //     $ip = "128.100.33.149";

        // }

        // $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}"));

        // $user_city = $details->city;

        // if (!is_null(Country::where('name', $user_city)->first())) {

        //     $city_id = Country::where('name', $user_city)->first()->id;

        // }

        $categories = Category::orderBy('name', 'asc')->where('status', 1)->get();

        $category = Category::where('slug', $slug)->where('status', 1)->first();

        if (is_null($category)) {

            return redirect()->route('index');

        }

        $paginateNumber = 20;

        // You are watching text

        if ($request->page) {

            $pageNo = $request->page;

        } else {

            $pageNo = 0;

        }

        $jobs = Job::with('results')->where('is_confirmed', 1)->where('category_id', $category->id)->where('status_id', 1)->orderBy('id', 'desc')->paginate($paginateNumber);

        // if (isset($city_id) && !is_null($city_id) && $city_id != '' && $city_id != 0) {

        //     $jobs = Job::where('is_confirmed', 1)->where('category_id', $category->id)->where('status_id', 1)->orderByRaw(DB::raw("FIELD(country_id , '$city_id') DESC"))->orderBy('id', 'DESC')->paginate($paginateNumber);

        // }

        $total_jobs = count($jobs);

        $pageNo = $pageNo != 0 ? $pageNo - 1 : $pageNo;

        $pageNoText = $paginateNumber * $pageNo . ' to ' . ($pageNo * $paginateNumber + $total_jobs);

        return view('frontend.pages.jobs.index', compact('jobs', 'categories', 'category', 'pageNoText'));

    }

    private function jobsearchs($request)
    {
        $search = $category = $country = $city = $country_id = $category_id = null;

        $salary_min = 0;

        $salary_max = null;

        if ($request->title) {

            $search = $request->title;

        }

        if ($request->city && $request->city != 'all') {

            $city = $request->city;

            $city_id = Country::where('name', $city)->first();

            if ($city_id) {
                $city_id = $city_id->id;
            }
        }

        if ($request->category != null && $request->category != 'all') {

            $category = $request->category;
            $cate = Category::where('slug', $category)->first();
            if ($cate) {
                $category_id = $cate->id;
            }

        }

        $min_salary = 0;

        $max_salary = 100000;

        if ($request->salary != null && $request->salary != '') {

            $salaryPart = explode("-", $request->salary);

            $min_salary = $salaryPart[0];

            if (isset($salaryPart[1])) {

                $max_salary = $salaryPart[1];

            }

        }

        $categories = Category::orderBy('name', 'asc')->where('status', 1)->get();

        $paginateNumber = 20;

        // You are watching text

        if ($request->page) {

            $pageNo = $request->page;

        } else {

            $pageNo = 0;

        }

        $pdo = DB::connection()->getPdo();

        $sql = 'select jobs.id

        from jobs

        left join users on users.id = jobs.id

        left join categories on jobs.category_id = categories.id

        left join job_types on job_types.id = jobs.type_id

        left join countries on countries.id = jobs.country_id

        where 1 = 1

        ';

        if ($request->job && $request->job != '') {

            $sql .= " and jobs.title like '%$request->job%'";

        }

        if ($request->cities && $request->cities != 'all') {

            $cities = $request->cities;

            $cities = Country::where('name', $cities)->first();

            if (!is_null($cities)) {

                $cities_id = $cities->id;

                $sql .= " and jobs.country_id = $cities_id ";

            }

        }

        if ($request->country && $request->country != 'all') {

            $country = $request->country;

            $country = City::where('name', $country)->first();

            if (!is_null($country)) {

                $country = $country->id;

                $sql .= " and jobs.city_id = $country ";

            }

        }

        if ($request->location && $request->location != '') {

            $location = $request->location;

            $sql .= "and countries.name like '%$location%'";

        }

        if ($request->category != null && $request->category != 'all') {

            $category = $request->category;

            $category = Category::where('slug', $category)->first();

            if (!is_null($category)) {

                $category_id = $category->id;

                $sql .= " and jobs.category_id = $category_id ";

            }

        }

        $min_salary = 0;

        $max_salary = 100000;

        if ($request->salary != null && $request->salary != '') {

            $salaryPart = explode("-", $request->salary);

            $min_salary = $salaryPart[0];

            if (isset($salaryPart[1])) {

                $max_salary = $salaryPart[1];

            }

            $sql .= " and jobs.monthly_salary  between  $min_salary and $max_salary ";

        }

        $type_id = null;
        if ($request->type != null && $request->type != 'all') {
            $type = \DB::table('job_types')->where('name', $request->type)->first();
            $sql .= " and jobs.type_id = $type->id";
        }
        if ($request->date != null && $request->date != '') {
            $date = $request->date;
            $sql .= " and jobs.created_at = $date";
        }

        $experience_id = null;

        if ($request->experience != null && $request->experience != '') {

            $experience = Experience::where('slug', $request->experience)->first();

            if (!is_null($experience)) {

                $experience_id = $experience->id;

                $sql .= " and jobs.experience_id = $experience_id";

            }

        }

        $stmt = $pdo->prepare($sql);

        $stmt->execute();

        $job_ids = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $jobs = Job::with('results')->whereIn('id', $job_ids)->paginate($paginateNumber);

        $total_jobs = count($jobs);

        $pageNo = $pageNo != 0 ? $pageNo - 1 : $pageNo;

        $pageNoText = $paginateNumber * $pageNo . ' to ' . ($pageNo * $paginateNumber + $total_jobs);

        return view('frontend.pages.jobs.index', compact('jobs', 'categories', 'pageNoText', 'search', 'country', 'category', 'city'));

    }
    public function JobDescriptionSearch($request)
    {

        $search = $category = $category_id = null;

        $categories = Category::orderBy('name', 'asc')->where('status', 1)->get();

        $paginateNumber = 15;

        if ($request->page) {

            $pageNo = $request->page;

        } else {

            $pageNo = 0;

        }
        $templates = Template::with('category');

        if ($request->search && $request->search != '') {
            $templates->where('name', 'LIKE', "%$request->search%");
        }

        if ($request->category != null && $request->category != 'all') {

            $category = $request->category;

            $category = $request->category;
            $cate = Category::where('slug', $category)->first();
            if ($cate) {
                $category_id = $cate->id;
            }
            $templates->where('category_id', $category_id);
        }
        if ($request->alpha != null && $request->alpha != '') {

            $alpha = $request->alpha;

            $templates->where('name', 'like', $alpha . '%');
        }

        $templates = $templates->paginate($paginateNumber);

        $total_template = count($templates);

        $pageNoText = $paginateNumber * $pageNo . ' to ' . ($pageNo * $paginateNumber + $total_template);

        return view('frontend.pages.description.index', compact('templates', 'categories', 'pageNoText'));

    }
    public function Description(Request $request)
    {
        $search = $category = $category_id = null;

        $categories = Category::orderBy('name', 'asc')->where('status', 1)->get();

        $paginateNumber = 15;

        if ($request->page) {

            $pageNo = $request->page;

        } else {

            $pageNo = 0;

        }
        $templates = Template::with('category');

        if ($request->search && $request->search != '') {
            $templates->where('name', 'LIKE', "%$request->search%");
        }

        if ($request->category != null && $request->category != 'all') {

            $category = $request->category;

            $category_id = Category::where('slug', $category)->first()->id;

            $templates->where('category_id', $category_id);
        }

        $templates = $templates->paginate($paginateNumber);

        $total_template = count($templates);

        $pageNoText = $paginateNumber * $pageNo . ' to ' . ($pageNo * $paginateNumber + $total_template);

        return view('frontend.pages.description.index', compact('templates', 'categories', 'pageNoText'));
    }

    public function JobDescription($id)
    {
        $template = Template::with('category')->where('id', $id)->first();
        return view('frontend.pages.description.show', compact('template'));
    }
    public function searchJobDescription(Request $request)
    {
        return $this->JobDescriptionSearch($request);
    }
    /**

     * searchJob

     *

     * @param  Request $request

     * @return [type]

     */

    public function searchJob(Request $request)
    {
        // return $request->job;

        if ($request->has('job')) {
            return $this->jobsearchs($request);
        }
    }

    /**

     * show

     *

     * @param  string

     * @return view

     */

    public function show($slug)
    {

        $job = Job::with('skills')->where('slug', $slug)->first();

        // for exam result validation

        $result = '';

        if (auth()->user()) {

            $result = Result::where('status', 1)->where('job_id', $job->id)->where('user_id', auth()->user()->id)->select('job_id')->first();

        }

        if (!is_null($job)) {

            $similar_jobs = Job::where('category_id', $job->category->id)->where('status_id', 1)->where('id', '!=', $job->id)->limit(3)->get();

            return view('frontend.pages.jobs.show', compact('job', 'similar_jobs', 'result'));

        }

        session()->flash('error', 'Sorry   No job has found  ');

        return redirect()->route('index');

    }

    /**

     * post

     *

     * Job Post Page

     *

     * @return  view

     */

    public function post()
    {

        $job_types = JobType::where('status', 1)->get();

        $job_experiences = Experience::where('status', 1)->get();

        $job_apply_types = JobApplyType::where('status', 1)->get();

        $categories = Category::where('status', 1)->orderBy('name', 'asc')->get();

        $qualifications = Qualification::where('status', 1)->orderBy('name', 'asc')->get();

        $skills = Skill::where('status', 1)->where('type', 0)->orderBy('name', 'asc')->get();

        $currencies = Currency::orderBy('priority', 'asc')->get();

        $countries = Country::orderBy('name', 'asc')->get();

        $templates = Template::orderBy('name', 'asc')->get();

        $sectors = Sector::orderBy('name', 'asc')->select('name', 'id')->get();

        $segments = Segment::orderBy('name', 'asc')->select('name', 'id')->get();

        $disciplines = Discipline::orderBy('name', 'asc')->select('name', 'id')->get();

        $skills = Skill::where('status', 1)->orderBy('name', 'asc')->where('type', 0)->select('name', 'id')->get();

        $last_id = Job::orderBy('id', 'DESC')->first();

        if (!$last_id) {

            $number = 0;

        } else {

            $number = substr($last_id->job_id, 3);

        }

        $job_id = '1' . sprintf('%04d', intval($number) + 1);

        return view('frontend.pages.jobs.post-job', compact('job_id', 'skills', 'job_types', 'job_experiences', 'job_apply_types', 'categories', 'skills', 'qualifications', 'currencies', 'countries', 'sectors', 'segments', 'disciplines', 'templates'));

    }

    /**

     * store

     *

     * Add New Job Post

     *

     * @param  Request $request [description]

     * @return [type]           [description]

     */

    public function store(Request $request)
    {
        if (!Auth::check() || !User::userCanPost(Auth::id())) {

            session()->flash('error', 'Sorry   You are not permitted to post a job  ');

            return redirect()->route('jobs');

        }

        $this->validate($request, [

            'title' => 'required|max:150',
            'email' => 'required|email',
            'type_id' => 'required',
            'apply_type_id' => 'required',
            'location' => 'nullable',
            'deadline' => 'required',

        ]);

        $job = new Job();
        $job->title = $request->title;
        $job->slug = StringHelper::createSlug($request->title, 'Job', 'slug');
        $job->email = $request->email;
        $job->description = $request->description;
        $job->category_id = $request->category_id;
        $job->type_id = $request->type_id;
        $job->company_id = $request->company_id;
        $job->experience_id = $request->experience_id;
        $job->apply_type_id = $request->apply_type_id;
        $job->sector_id = $request->sector_id;
        $job->segment_id = $request->segment_id;
        $job->discipline_id = $request->discipline_id;
        $job->location = trim($request->location);
        $job->country_id = $request->country;
        $job->job_id = $request->job_id;
        if (isset($request->is_salary_negotiable)) {
            $job->is_salary_negotiable = 1;
        } else {
            $job->is_salary_negotiable = 0;
            $this->validate($request, [
                'monthly_salary' => 'required',
                'salary_currency' => 'required',
            ]);
            $job->monthly_salary = $request->monthly_salary;
            $job->salary_currency = $request->salary_currency;
        }
        $job->gender = $request->gender;
        $job->deadline = Carbon::parse($request->deadline)->format('Y-m-d H:i:s');
        $job->is_featured = 1;
        $job->is_confirmed = 1;
        $job->user_id = Auth::id();
        $job->status_id = 1;
        $job->job_summery = $request->job_summery;

        $job->responsibilities = $request->responsibilities;

        $job->qualification = $request->qualification;

        $job->certification = $request->certification;

        $job->experience = $request->experience;

        $job->about_company = $request->about_company;

        $job->city_id = $request->city;
        $job->skills =  $request->skills;
        $job->save();



        session()->flash('success', 'Job has been posted successfully  ');
        return redirect()->route('jobs');

    }

    /**

     * Job Post Edit page

     *

     * @param  view $slug

     * @return view

     */

    public function edit($slug)
    {

        if (!Auth::check() || !User::userCanPost(Auth::id())) {

            session()->flash('error', 'Sorry   You are not permitted to edit the job  ');

            return redirect()->route('jobs');

        }

        $job = Job::with('skills')->where('slug', $slug)->first();

        if (is_null($job)) {

            session()->flash('error', 'Sorry   No job has found  ');

            return redirect()->route('index');

        }

        if (!Auth::check() && Auth::user()->id != $job->id) {

            session()->flash('error', 'Sorry   You are not authenticated to edit this job  ');

            return redirect()->route('index');

        }

        $job_types = JobType::where('status', 1)->get();

        $job_experiences = Experience::where('status', 1)->get();

        $job_apply_types = JobApplyType::where('status', 1)->get();

        $categories = Category::where('status', 1)->orderBy('name', 'asc')->get();

        $qualifications = Qualification::where('status', 1)->orderBy('name', 'asc')->get();

        $skills = Skill::where('status', 1)->orderBy('name', 'asc')->where('type', 0)->select('name', 'id')->get();

        $currencies = Currency::orderBy('priority', 'asc')->get();

        $countries = Country::orderBy('name', 'asc')->get();

        $job_deadline = substr($job->deadline, 5, 2) . '/' . substr($job->deadline, 8, 2) . '/' . substr($job->deadline, 0, 4); //2019-04-18 to 04/10/2019

        $templates = Template::orderBy('name', 'asc')->get();

        $sectors = Sector::orderBy('name', 'asc')->select('name', 'id')->get();

        $segments = Segment::orderBy('name', 'asc')->select('name', 'id')->get();

        $disciplines = Discipline::orderBy('name', 'asc')->select('name', 'id')->get();

        return view('frontend.pages.jobs.edit', compact('job_types', 'job_experiences', 'job_apply_types', 'categories', 'skills', 'qualifications', 'currencies', 'countries', 'job', 'job_deadline', 'sectors', 'segments', 'disciplines', 'templates'));

    }

    /**

     * update Job

     *

     * @param  Request $request

     * @return Route

     */

    public function update(Request $request, $slug)
    {

        if (!Auth::check() || !User::userCanPost(Auth::id())) {

            session()->flash('error', 'Sorry   You are not permitted to post a job  ');

            return redirect()->route('jobs');

        }

        $this->validate($request, [

            'title' => 'required|max:150',
            'email' => 'required|email',
            'type_id' => 'required',
            'apply_type_id' => 'required',
            'location' => 'nullable',
            'deadline' => 'required',

        ]);

        $job = Job::where('slug', $request->slug)->first();
        $job->title = $request->title;
        $job->email = $request->email;
        $job->description = $request->description;
        $job->category_id = $request->category_id;
        $job->type_id = $request->type_id;
        $job->company_id = $request->company_id;
        $job->experience_id = $request->experience_id;
        $job->apply_type_id = $request->apply_type_id;
        $job->sector_id = $request->sector_id;
        $job->segment_id = $request->segment_id;
        $job->discipline_id = $request->discipline_id;
        $job->location = trim($request->location);
        $job->country_id = $request->country;
        $job->job_id = $request->job_id;
        if (isset($request->is_salary_negotiable)) {
            $job->is_salary_negotiable = 1;
        } else {
            $job->is_salary_negotiable = 0;
            $this->validate($request, [
                'monthly_salary' => 'required',
                'salary_currency' => 'required',
            ]);
            $job->monthly_salary = $request->monthly_salary;
            $job->salary_currency = $request->salary_currency;
        }
        $job->gender = $request->gender;
        $getDeadline = $request->deadline;
        $getDeadline = substr($getDeadline, 6, 4) . '-' . substr($getDeadline, 0, 2) . '-' . substr($getDeadline, 3, 2);
        $job->deadline = $getDeadline;
        $job->is_featured = 1;
        $job->is_confirmed = 1;
        $job->user_id = Auth::id();
        $job->status_id = 1;
        $job->job_summery = $request->job_summery;

        $job->responsibilities = $request->responsibilities;

        $job->qualification = $request->qualification;

        $job->certification = $request->certification;

        $job->experience = $request->experience;

        $job->about_company = $request->about_company;

        $job->save();
        if ($request->has('job_skill_check') && $request->job_skill_check != '') {
            $job->skills()->sync($request->skills);
        } else {
            $job->skills()->delete();
        }

        session()->flash('success', 'Job has been posted successfully  ');
        return redirect()->route('employers.jobs.posted');

    }

    /**

     * Apply For Jobs

     * @param  Request $request [description]

     * @return [type]           [description]

     */

    public function apply(Request $request)
    {

        if (!Auth::check()) {

            session()->flash('error', 'Sorry   You are not permitted to apply job  ');

            return back();

        }

        $this->validate($request, [

            'job_id' => 'required|numeric',

            'cover_letter' => 'required',

            'expected_salary' => 'nullable|numeric',

            // 'cv_file' => 'nullable|mimes:pdf|max:2000',

        ]);

        if (JobActivity::where('user_id', Auth::id())->where('job_id', $request->job_id)->first() != null) {

            session()->flash('error', 'Sorry   You have already applied for this job  ');

            return back();

        }

        $jobActivity = new JobActivity();

        $jobActivity->job_id = $request->job_id;

        $jobActivity->user_id = Auth::id();
        $jobActivity->company_id = $request->company_id;

        $jobActivity->cover_letter = $request->cover_letter;

        if (isset($request->is_salary_negotiable)) {

            $jobActivity->is_salary_negotiable = 1;

            $jobActivity->expected_salary = 0;

        } else {

            $jobActivity->is_salary_negotiable = 0;

            $jobActivity->expected_salary = $request->expected_salary;

        }

        // if (isset($request->use_profile_cv)) {

        //     if (Auth::user()->candidate->cv != null) {

        //         $cv = Auth::user()->candidate->cv;

        //     } else {

        //         $cv = null;

        //     }

        // } else {

        //     // If there is any uploaded CV

        //     $cv_file = UploadHelper::upload('cv_file', $request->file('cv_file'), time(), 'files/cv');

        //     if (!is_null($cv_file)) {

        //         $cv = url('/') . '/files/cv/' . $cv_file;

        //     } else {

        //         $cv = null;

        //     }

        // }

        // $jobActivity->cv = $cv;

        $jobActivity->save();

        session()->flash('success', 'You have applied successfully for the job  ');

        return redirect()->route('jobs');

    }

    /**

     * applyUpdate

     * @param  Request $request

     * @return

     */

    public function applyUpdate(Request $request)
    {

        if (!Auth::check()) {

            session()->flash('error', 'Sorry   You are not permitted to apply job  ');

            return back();

        }

        $this->validate($request, [

            'job_id' => 'required|numeric',

            'cover_letter' => 'required',

            'expected_salary' => 'nullable|numeric',

            // 'cv_file' => 'nullable|mimes:pdf|max:2000',

        ]);

        $jobActivity = JobActivity::where('user_id', Auth::id())->where('job_id', $request->job_id)->first();

        if ($jobActivity->user_id != Auth::id()) {

            session()->flash('error', 'Sorry   You are not authenticated to update the application  ');

            return back();

        }

        $jobActivity->cover_letter = $request->cover_letter;

        if (isset($request->is_salary_negotiable)) {

            $jobActivity->is_salary_negotiable = 1;

            $jobActivity->expected_salary = 0;

        } else {

            $jobActivity->is_salary_negotiable = 0;

            $jobActivity->expected_salary = $request->expected_salary;

        }

        // if (isset($request->use_profile_cv)) {

        //     if (Auth::user()->candidate->cv != null) {

        //         $cv = Auth::user()->candidate->cv;

        //     } else {

        //         $cv = null;

        //     }

        // } else {

        //     // If there is any uploaded CV

        //     // Delete the existing File

        //     if (file_exists($jobActivity->cv)) {

        //         unlink($jobActivity->cv);

        //     }

        //     $cv_file = UploadHelper::upload('cv_file', $request->file('cv_file'), time(), 'files/cv');

        //     if (!is_null($cv_file)) {

        //         $cv = url('/') . '/files/cv/' . $cv_file;

        //     } else {

        //         $cv = null;

        //     }

        // }

        // $jobActivity->cv = $cv;

        $jobActivity->save();

        session()->flash('success', 'You have successfully updated the application  ');

        return redirect()->route('jobs');

    }

}
