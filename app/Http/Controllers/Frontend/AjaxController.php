<?php

namespace App\Http\Controllers\Frontend;

use App\Conversation;
use App\Http\Controllers\Controller;
use App\Message;
use App\Models\CandidateProfile;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Experience;
use App\Models\Job;
use App\Models\JobActivity;
use App\Models\State;
use App\Models\UserQualification;
use App\User;
use Auth;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class AjaxController extends Controller
{

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function main(Request $request)
    {
        if ($this->request->has('action')) {
            $action = $this->request->get('action');
            if (method_exists($this, $action)) {
                return $this->$action();
            }
        }
        return response()->json(['status' => 'error`']);
    }

    public function posted_job()
    {
        $user = Auth::user();
        $title = 'Total Posted Jobs';
        $id = null;
        if ($this->request->id) {
            if ($this->request->id == auth()->user()->id) {
                $user = User::where('type', 1)->where('id', auth()->user()->id)->first();
                $id = $this->request->id;
            } else {
                $id = $this->request->id;
                $user = User::where('type', 1)->where('id', $this->request->id)->first();
            }
        }

        $user_id = $user->id;

        $_filter = request()->filter ?? null;

        $jobs = Job::where('user_id', $user_id)->orderBy('created_at', 'DESC')->get();

        $user_jobs = $user->jobs;

        $user_jobs_count = $user_jobs->count();

        $user_active_jobs_count = $user_jobs->where('archived', 0)->count();
        $user_inactive_jobs_count = $user_jobs->where('archived', 1)->count();

        $html = view('frontend.pages.ajax-load.employers.posted-job-load', compact('title', 'id', 'user', 'jobs', 'user_jobs_count', 'user_active_jobs_count', 'user_inactive_jobs_count'))->render();
        return response()->json(['status' => 'success', 'html' => $html]);
    }

    public function job_status_show()
    {
        $status = $this->request->status;
        if (!Auth::check()) {

            session()->flash('error', 'Sorry   You are not an authenticated Employer  ');

            return redirect()->route('index');

        }
        $title = "";
        $user = Auth::user();
        if ($this->request->id) {
            if ($this->request->id == auth()->user()->id) {
                $user = User::where('type', 1)->where('id', auth()->user()->id)->first();
            } else {
                $user = User::where('type', 1)->where('id', $this->request->id)->first();
            }
        }
        $user_id = $user->id;

        if ($status == 'Live') {
            $title = "Total Live Jobs";
            $timezone = date_default_timezone_get();

            $date = date('Y/m/d H:i:s');

            $jobs = \App\Models\Job::where('user_id', $user->id)->orderBy('created_at', 'DESC')->where('deadline', '>', $date)->get();

        } elseif ($status == 'In-progress') {
            $title = "Total In-progress Jobs";
            $timezone = date_default_timezone_get();

            $date = date('Y/m/d H:i:s');

            $jobs = \App\Models\Job::where('user_id', $user->id)->orderBy('created_at', 'DESC')->where('deadline', '<', $date)->where('archived', 0)->get();

        } elseif ($status == 'Archived') {
            $title = "Total  Archived Jobs";
            $timezone = date_default_timezone_get();

            $date = date('Y/m/d H:i:s');

            $jobs = \App\Models\Job::where('user_id', $user->id)->orderBy('created_at', 'DESC')->where('archived', 1)->get();

        } else {

            $jobs = \App\Models\Job::where('user_id', $user->id)->orderBy('created_at', 'DESC')->get();

        }

        $html = view('frontend.pages.ajax-load.employers.live-job-load', compact('user', 'title', 'jobs', 'status'))->render();
        return response()->json(['status' => 'success', 'html' => $html]);

    }

    public function all_activity()
    {
        $user = Auth::user();
        if ($this->request->id) {
            if ($this->request->id == auth()->user()->id) {
                $user = User::where('type', 1)->where('id', auth()->user()->id)->first();
            } else {
                $user = User::where('type', 1)->where('id', $this->request->id)->first();
            }
        }
        $user_id = $user->id;

        $applicant = DB::table('job_activities')->where('user_id', $user_id)->get();

        $job = Job::where('slug', $this->request->slug)->first();

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

            return \Excel::download($export, $job->slug . '_' . time() . '.xlsx');

        }

        // Delete applicant

        if (request()->has('delete')) {
            DB::table('job_activities')->where('id', $applicant->id)->delete();
            session()->flash('success', 'Applicant deleted successfully  ');
        }

        $html = view('frontend.pages.ajax-load.employers.job-application-load', compact('user', 'applicant', 'job', 'applications', 'experience', 'education', 'filter', 'expreience_data'))->render();
        return response()->json(['status' => 'success', 'html' => $html]);
    }

    public function job_activity()
    {

        if (!Auth::check()) {

            session()->flash('error', 'Sorry   You are not an authenticated Employer  ');

            return redirect()->route('index');

        }

        $user = Auth::user();
        if ($this->request->id) {
            if ($this->request->id == auth()->user()->id) {
                $user = User::where('type', 1)->where('id', auth()->user()->id)->first();
            } else {
                $user = User::where('type', 1)->where('id', $this->request->id)->first();
            }
        }
        $user_id = $user->id;
        $job = Job::where('slug', $this->request->slug)->first();
        if ($this->request->status) {
            $status = $this->request->status;
            $slug = $this->request->slug;
            $applicant = JobActivity::where('status', $this->request->status)->where('company_id', $user_id)->where('job_id', $job->id)->get();
            $html = view('frontend.pages.ajax-load.employers.listed-job-load', compact('user', 'applicant', 'status', 'slug'))->render();
            return response()->json(['status' => 'success', 'html' => $html]);
        }
        return response()->json(['status' => 'error']);

    }

    public function send_message()
    {
        if ($this->request->id && $this->request->text) {
            if (\auth()->check()) {
                $conversation = Conversation::where('id', $this->request->id)->first();
                if ($conversation) {
                    $receive_id = $conversation->receive_id;
                    $sender_id = $conversation->sender_id;
                    if (\auth()->id() === $conversation->receive_id) {
                        $sender_id = $conversation->receive_id;
                        $receive_id = $conversation->sender_id;
                    }
                    $message = new Message();
                    $message->message = $this->request->text;
                    $message->user_id = \auth()->id();
                    $message->conversation_id = $conversation->id;
                    $message->seen = 0;
                    $message->save();

                    $conversation->last_message = $this->request->text;
                    $conversation->updated_at = date('Y-m-d H:i:s');
                    $conversation->save();
                    $conv = $conversation;
                    $html = view('frontend.pages.messages.message', compact('message'))->render();
                    $html_receive = true;
                    $receive_html = view('frontend.pages.messages.message', compact('message', 'html_receive'))->render();
                    $conversation_html = view('frontend.pages.messages.item', compact('conv', 'html_receive'))->render();
                    return response()->json([
                        'status' => 'success',
                        'html' => $html,
                        'id' => $message->id,
                        'receive_html' => $receive_html,
                        'conversation_html' => $conversation_html,
                        'message' => $message->message,
                    ]);
                }
            } else {
                return response()->json(['status' => 'login']);
            }
        }
        return response()->json(['status' => 'error']);
    }

    public function load_messages()
    {
        if ($this->request->id && $this->request->page && \auth()->check()) {
            $conversation = Conversation::with('messages', 'sender', 'receive')->where('id', $this->request->id)->where(function (Builder $query) {
                $query->where('sender_id', \auth()->id())->orWhere('receive_id', \auth()->id());
            })->first();
            if ($conversation) {
                $messages = $conversation->messages()->paginate(20);
                if ($messages->count()) {
                    $html = '';
                    foreach ($messages->reverse() as $message) {
                        $html .= view('frontend.pages.messages.message', compact('message'))->render();
                    }
                    return response()->json(['status' => 'success', 'html' => $html]);
                } else {
                    return response()->json(['status' => 'empty']);
                }
            }
        }
        return response()->json(['status' => 'error']);
    }
    public function delete_conversation()
    {
        if ($this->request->id && \auth()->check()) {
            $conversation = Conversation::where('id', $this->request->id)->where(function (Builder $builder) {
                $builder->where('sender_id', auth()->id())->orWhere('receive_id', auth()->id());
            })->first();

            if ($conversation) {
                Message::where('conversation_id', $this->request->id)->delete();
                $conversation->delete();
            }
            return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'error']);
    }
    public function load_conversation()
    {
        if ($this->request->id && \auth()->check()) {
            $conversation = Conversation::with('messages', 'sender', 'receive')->where('id', $this->request->id)->where(function (Builder $query) {
                $query->where('sender_id', \auth()->id())->orWhere('receive_id', \auth()->id());
            })->first();
            if ($conversation) {
                Message::where('conversation_id', $conversation->id)->where('user_id', '!=', \auth()->id())->update(['seen' => 1]);
                $html = view('frontend.pages.messages.conversation', compact('conversation'))->render();
                return response()->json(['status' => 'success', 'html' => $html, 'unread' => \auth()->user()->unread()->count(), 'url' => route('message', ['id' => $conversation->id])]);
            }
        }
        return response()->json(['status' => 'error']);
    }

    public function seen()
    {
        if (auth()->check()) {
            Message::where('user_id', auth()->user()->id)->update(['seen' => 1]);
            return response()->json(['status' => 'success', 'route' => route('messages')]);
        }
        return response()->json(['status' => 'error']);
    }

    public function show_city_country_select()
    {
        if ($this->request->id && $this->request->id != '') {
            $id = $this->request->id;
            $states = State::with(['cities' => function ($q) use ($id) {
                $q->where('city_id', $id);
            }])->orderBy('name', 'asc')->get();

            $html = view('frontend.pages.ajax-load.city', compact('states'))->render();
            return response()->json(['status' => 'success', 'html' => $html]);
        } else {
            return response()->json(['status' => 'error']);
        }

    }
    public function show_city_country_select_2()
    {
        if ($this->request->name && $this->request->name != '') {
            $country = City::where('name', $this->request->name)->first();
            if ($country) {
                $states = State::with(['cities' => function ($q) use ($country) {
                    $q->where('city_id', $country->id);
                }])->orderBy('name', 'asc')->get();
                $urlName = $this->request->cityName;
                $html = view('frontend.pages.ajax-load.city_2', compact('states','urlName'))->render();
                return response()->json(['status' => 'success', 'urlName' => $urlName, 'html' => $html]);
            }

        } else {
            return response()->json(['status' => 'error']);
        }

    }
    public function show_city_position_select()
    {
        if ($this->request->name && $this->request->name != '') {
            $country = Country::where('name', $this->request->name)->first();
            if ($country) {
                $cat_id = Job::where('country_id', $country->id)->select('category_id')->get();
                $categories = Category::whereIn('id', $cat_id)->get();
                $html = view('frontend.pages.ajax-load.position-load', compact('categories'))->render();
                return response()->json(['status' => 'success', 'html' => $html]);
            }

        } else {
            return response()->json(['status' => 'error']);
        }

    }

    public function country_by_tag()
    {
         $city_id = City::where('name',$this->request->country)->first()->id;
         $cate_id =  Job::where('city_id', $city_id)->get()->pluck('category_id');
         $top_job_cate = Category::whereIn('id', $cate_id)->withCount('jobs')->orderBy('jobs_count', 'desc')->take(15)->get();
        $html = view('frontend.pages.ajax-load.latest-tag', compact('top_job_cate'))->render();
        return response()->json(['status' => 'success', 'html' => $html]);
    }
  public function check_username()
    {
        if ($this->request->has('username')) {
            $check = User::where('username', $this->request->get('username'))->first();
            if ($check) {
                return response()->json(['status' => 'error']);
            } else {
                return response()->json(['status' => 'success']);
            }

        }
        return response()->json(['status' => 'error']);
    }
  public function check_email()
    {
        if ($this->request->has('email')) {
            $check = User::where('email', $this->request->get('email'))->first();
            if ($check) {
                return response()->json(['status' => 'error']);
            } else {
                return response()->json(['status' => 'success']);
            }

        }
        return response()->json(['status' => 'error']);
    }

}