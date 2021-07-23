<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Country;
use App\Models\Experience;
use App\Models\Job;
use App\Models\JobType;
use App\Models\Sector;
use App\Models\SiteReview;
use App\Models\Template;
use App\User;
use DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**

     * Create a new controller instance.

     *

     * @return void

     */

    /**

     * Show the application dashboard.

     *

     * @return \Illuminate\Contracts\Support\Renderable

     */

    public function index()
    {

        return view('home');

    }

    public function Testimonial()
    {
        $reviews = SiteReview::where('is_confirmed', 1)->get();
        return view('frontend.pages.testimonial.index', compact('reviews'));

    }
    private function jobsearchs($request)
    {
        $search = $category = $country = $country_id = $category_id = null;

        $salary_min = 0;

        $salary_max = null;

        if ($request->title) {

            $search = $request->title;

        }

        if ($request->country && $request->country != 'all') {

            $country = $request->country;

            $country_id = Country::where('name', $country)->first()->id;

        }

        if ($request->category != null && $request->category != 'all') {

            $category = $request->category;

            $category_id = Category::where('slug', $category)->first()->id;

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
        where

        ';
    
        $flag = 0;

        if ($request->job && $request->job != '') {

            $sql .= " jobs.title like '%$request->job%'";
            $flag = 1;
            

        }

        if ($request->country && $request->country != 'all') {

            $country = $request->country;

            $country = Country::where('name', $country)->first();

            if (!is_null($country)) {

                $country_id = $country->id;

                $sql .= " and jobs.country_id = $country_id ";

            }

        }
        if ($request->location && $request->location != '') {

            $location = $request->location;
            if($location != 'all'){
                if ($request->job && $request->job != '') {
                    $sql .= " and ";
                }
                $sql .= " countries.name like '%$location%'";
                $flag = 1;
            }
            

        }
        
        if($flag==0){
            $sql .= " jobs.title like '% %'";
            // $sql .= "countries.name IS NOT NULL";
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
            
            $type_id = $request->type;
            $type = JobType::where('name', $type_id)->first();
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
        
        // echo $sql;
        // exit;
        
        $stmt = $pdo->prepare($sql);


        $stmt->execute();

        $job_ids = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $jobs = Job::with('results')->whereIn('id', $job_ids)->paginate($paginateNumber);

        $total_jobs = count($jobs);

        $pageNo = $pageNo != 0 ? $pageNo - 1 : $pageNo;

        $pageNoText = $paginateNumber * $pageNo . ' to ' . ($pageNo * $paginateNumber + $total_jobs);

        return view('frontend.pages.jobs.index', compact('jobs', 'categories', 'pageNoText', 'search', 'country', 'category'));

    }
    public function candaditeSearch($request)
    {

        $search = $categories = $category = $country = $country_id = $category_id = null;

        $categories = Category::orderBy('name', 'asc')->where('status', 1)->get();

        $paginateNumber = 20;

        // You are watching text

        if ($request->page) {

            $pageNo = $request->page;

        } else {

            $pageNo = 0;

        }

        $pdo = DB::connection()->getPdo();

        $sql = 'select users.id

                from users

                left join candidate_profiles on users.id = candidate_profiles.user_id

                left join locations on locations.id = users.location_id

                where is_company = 0 and status=1

        ';

        if ($request->company && $request->company != '') {

            $sql .= " and users.name like '%$request->company%' or users.about like '%$request->company%'";

        }

        if ($request->location && $request->location != '') {

            $location = $request->location;

            $country = Country::where('name', 'like', '%' . $location . '%')->first();
            if ($country) {
                $country_id = $country->id;
                $sql .= " and locations.country_id = $country_id ";
            }

        }

        if ($request->category != null && $request->category != 'all') {

            $category = $request->category;

            $category_id = Category::where('slug', $category)->first()->id;

            $sql .= " and candidate_profiles.sector = $category_id ";

        }

        $experience_id = null;

        if ($request->experience != null && $request->experience != 'all') {

            $experience_id = Experience::where('slug', $request->experience)->first()->id;

            $sql .= " and candidate_profiles.experience_id = $experience_id";

        }

        $gender = null;

        if ($request->gender != null && $request->gender != '') {

            $sql .= " and candidate_profiles.gender = '$request->gender'";

        }

        $stmt = $pdo->prepare($sql);

        $stmt->execute();

        $user_ids = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $users = User::whereIn('id', $user_ids)->paginate($paginateNumber);

        $total_users = count($users);

        $pageNoText = $paginateNumber * $pageNo . ' to ' . ($pageNo * $paginateNumber + $total_users);

        return view('frontend.pages.candidates.index', compact('users', 'categories', 'pageNoText', 'search', 'country', 'category'));

    }
    public function CompanySearch($request)
    {
        $search = $country = $category = $country_id = $category_id = null;

        $categories = Category::orderBy('name', 'asc')->where('status', 1)->get();

        $paginateNumber = 20;

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

        if ($request->candidate && $request->candidate != '') {

            $sql .= " and users.name like '%$request->candidate%' ";

        }

        if ($request->location && $request->location != '') {

            $location = $request->location;

            $country = Country::where('name', 'like', '%' . $location . '%')->first();
            if ($country) {
                $country_id = $country->id;
                $sql .= " and locations.country_id = $country_id ";
            }

        }

        if ($request->sector) {
            $sectors = implode(',', $request->sector);

            $sql .= " and company_profiles.sector_id like '%$sectors%' ";

        }

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

        if ($request->job_description && $request->job_description != '') {
            $templates->where('name', 'LIKE', "%$request->job_description%");
        }

        if ($request->category != null && $request->category != 'all') {

            $category = $request->category;

            $category_id = Category::where('slug', $category)->first()->id;

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

    /**

     * searchJob

     *

     * @param  Request $request

     * @return [type]

     */

    public function searches(Request $request)
    {

        if ($request->has('job')) {
            return $this->jobsearchs($request);
        }
        if ($request->has('candidate')) {
            return $this->candaditeSearch($request);
        }
        if ($request->has('company')) {
            return $this->CompanySearch($request);
        }
        if ($request->has('job_description')) {
            return $this->JobDescriptionSearch($request);
        }

    }

}