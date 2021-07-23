<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Job;
use App\Models\JobActivity;
use App\Models\SiteReview;
use App\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class APIController extends Controller
{

    public function getJobActivity(Request $request, $job_id, $user_id)
    {

        $job_activity = JobActivity::where('user_id', $user_id)->where('job_id', $job_id)->first();

        return json_encode(['status' => 'success', 'data' => $job_activity]);

    }

    public function addReview(Request $request)
    {

        $api_token = $request->get('api_token');

        $user = User::where('api_token', $api_token)->first();

        if (!is_null($user->api_token)) {

            $review = new SiteReview();

            if ($user->is_company) {

                $review->name = $request->get('name');

                $review->position = $request->get('position');

                $review->company = $user->name;

            } else {

                $review->name = $user->name;

                $review->position = $user->currentJob()->job_title;

                $review->company = $user->currentJob()->company_name;

            }

            if ($user->profile_picture == null) {

                $review->profile_picture = 'user.png';

            } else {

                $review->profile_picture = $user->profile_picture;

            }

            $review->facebook_link = $user->facebook_link;

            $review->twitter_link = $user->twitter_link;

            $review->linkedin_link = $user->linkedin_link;

            $review->is_confirmed = 1;

            $review->review = $request->get('review');

            $review->save();

            return json_encode(['status' => 'success', 'message' => 'Your review has been taken successfully  ']);

        } else {

            return json_encode(['status' => 'error', 'message' => 'Not Authenticated']);

        }

    }

    public function EmployerData(Request $request)
    {
        if (!Auth::check()) {
            return response('Sorry   You are not an authenticated Employer  ');

        }
        if ($request->has('team_id') && $request->team_id != '') {
            $user = User::where('id', $request->team_id)
                ->with('teams')
                ->first();
        } else {
            $user = User::where('id', auth()->user()->id)
                ->with('teams')
                ->first();
        }

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

        $total_companies;
        if ($request->assign == 'true' && $request->team_id) {

            $total_companies = Company::where('assign_id', $request->team_id)->count();
        } else {
            $total_companies = Company::where('user_id', auth()->user()->id)->count();
        }

        if ($request->has('team_id') && $request->team_id != '') {
            $total_job = Job::where('user_id', $request->team_id)->count() + $team_job_count;
            $total_applicant = JobActivity::where('company_id', $request->team_id)->get()->count() + $applicant_count;
        } else {
            $total_job = Job::where('user_id', auth()->user()->id)->count() + $team_job_count;
            $total_applicant = JobActivity::where('company_id', auth()->user()->id)->get()->count() + $applicant_count;
        }

        $total_new_count = JobActivity::where('company_id', $user->id)->where('status', 'New')->get()->count() + $new_count;
        $total_short_count = JobActivity::where('company_id', $user->id)->where('status', 'Shortlisted')->get()->count() + $short_count;
        $total_interview_count = JobActivity::where('company_id', $user->id)->where('status', 'Interview')->get()->count() + $interview_count;
        $total_offered_count = JobActivity::where('company_id', $user->id)->where('status', 'Offered')->get()->count() + $offered_count;
        $total_hired_count = JobActivity::where('company_id', $user->id)->where('status', 'Hired')->get()->count() + $hired_count;
        $total_reject_count = JobActivity::where('company_id', $user->id)->where('status', 'Rejected')->get()->count() + $reject_count;
        return [$total_job, $total_companies, $total_applicant, $total_new_count, $total_short_count, $total_interview_count, $total_offered_count, $total_hired_count, $total_reject_count];
    }

    public function weeklyData(Request $request)
    {
        if (!Auth::check()) {
            return response('Sorry   You are not an authenticated Employer  ');

        }

        if ($request->has('team_id') && $request->team_id != '') {
            $user = User::where('id', $request->team_id)
                ->with('teams')
                ->first();
        } else {
            $user = User::where('id', auth()->user()->id)
                ->with('teams')
                ->first();
        }

        $collection = collect($user->teams);
        $filtered_id = $collection->pluck('id');

        $team_job_count = Job::whereIn('user_id', $filtered_id)->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $applicant_count = JobActivity::whereIn('company_id', $filtered_id)->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $new_count = JobActivity::whereIn('company_id', $filtered_id)->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('status', 'New')->count();
        $short_count = JobActivity::whereIn('company_id', $filtered_id)->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('status', 'Shortlisted')->count();
        $interview_count = JobActivity::whereIn('company_id', $filtered_id)->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('status', 'Interview')->count();
        $offered_count = JobActivity::whereIn('company_id', $filtered_id)->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('status', 'Offered')->count();
        $hired_count = JobActivity::whereIn('company_id', $filtered_id)->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('status', 'Hired')->count();
        $reject_count = JobActivity::whereIn('company_id', $filtered_id)->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('status', 'Rejected')->count();

        $total_companies;
        if ($request->assign == 'true' && $request->team_id) {
            $total_companies = Company::where('assign_id', $request->team_id)->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        } else {
            $total_companies = Company::where('user_id', auth()->user()->id)->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        }

        if ($request->has('team_id') && $request->team_id != '') {
            $total_job = Job::where('user_id', $request->team_id)->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count() + $team_job_count;
            $total_applicant = JobActivity::where('company_id', $request->team_id)->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get()->count() + $applicant_count;
        } else {
            $total_job = Job::where('user_id', auth()->user()->id)->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count() + $team_job_count;
            $total_applicant = JobActivity::where('company_id', auth()->user()->id)->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get()->count() + $applicant_count;
        }

        $total_new_count = JobActivity::where('company_id', $user->id)->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('status', 'New')->get()->count() + $new_count;
        $total_short_count = JobActivity::where('company_id', $user->id)->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('status', 'Shortlisted')->get()->count() + $short_count;
        $total_interview_count = JobActivity::where('company_id', $user->id)->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('status', 'Interview')->get()->count() + $interview_count;
        $total_offered_count = JobActivity::where('company_id', $user->id)->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('status', 'Offered')->get()->count() + $offered_count;
        $total_hired_count = JobActivity::where('company_id', $user->id)->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('status', 'Hired')->get()->count() + $hired_count;
        $total_reject_count = JobActivity::where('company_id', $user->id)->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('status', 'Rejected')->get()->count() + $reject_count;
        return [$total_job, $total_companies, $total_applicant, $total_new_count, $total_short_count, $total_interview_count, $total_offered_count, $total_hired_count, $total_reject_count];
    }
    public function YearlyData(Request $request)
    {
        if (!Auth::check()) {
            return response('Sorry   You are not an authenticated Employer  ');

        }
        if ($request->has('year') && $request->year != '') {

            if ($request->has('team_id') && $request->team_id != '') {
                $user = User::where('id', $request->team_id)
                    ->with('teams')
                    ->first();
            } else {
                $user = User::where('id', auth()->user()->id)
                    ->with('teams')
                    ->first();
            }

            $collection = collect($user->teams);
            $filtered_id = $collection->pluck('id');

            $team_job_count = Job::whereIn('user_id', $filtered_id)->whereYear('created_at', $request->year)->count();
            $applicant_count = JobActivity::whereIn('company_id', $filtered_id)->whereYear('created_at', $request->year)->count();
            $new_count = JobActivity::whereIn('company_id', $filtered_id)->whereYear('created_at', $request->year)->where('status', 'New')->count();
            $short_count = JobActivity::whereIn('company_id', $filtered_id)->whereYear('created_at', $request->year)->where('status', 'Shortlisted')->count();
            $interview_count = JobActivity::whereIn('company_id', $filtered_id)->whereYear('created_at', $request->year)->where('status', 'Interview')->count();
            $offered_count = JobActivity::whereIn('company_id', $filtered_id)->whereYear('created_at', $request->year)->where('status', 'Offered')->count();
            $hired_count = JobActivity::whereIn('company_id', $filtered_id)->whereYear('created_at', $request->year)->where('status', 'Hired')->count();
            $reject_count = JobActivity::whereIn('company_id', $filtered_id)->whereYear('created_at', $request->year)->where('status', 'Rejected')->count();

            $total_companies;
            if ($request->assign == 'true' && $request->team_id) {
                $total_companies = Company::where('assign_id', $request->team_id)->whereYear('created_at', $request->year)->count();
            } else {
                $total_companies = Company::where('user_id', auth()->user()->id)->whereYear('created_at', $request->year)->count();
            }

            if ($request->has('team_id') && $request->team_id != '') {
                $total_job = Job::where('user_id', $request->team_id)->whereYear('created_at', $request->year)->count() + $team_job_count;
                $total_applicant = JobActivity::where('company_id', $request->team_id)->whereYear('created_at', $request->year)->get()->count() + $applicant_count;
            } else {
                $total_job = Job::where('user_id', auth()->user()->id)->whereYear('created_at', $request->year)->count() + $team_job_count;
                $total_applicant = JobActivity::where('company_id', auth()->user()->id)->whereYear('created_at', $request->year)->get()->count() + $applicant_count;
            }

            $total_new_count = JobActivity::where('company_id', $user->id)->whereYear('created_at', $request->year)->where('status', 'New')->get()->count() + $new_count;
            $total_short_count = JobActivity::where('company_id', $user->id)->whereYear('created_at', $request->year)->where('status', 'Shortlisted')->get()->count() + $short_count;
            $total_interview_count = JobActivity::where('company_id', $user->id)->whereYear('created_at', $request->year)->where('status', 'Interview')->get()->count() + $interview_count;
            $total_offered_count = JobActivity::where('company_id', $user->id)->whereYear('created_at', $request->year)->where('status', 'Offered')->get()->count() + $offered_count;
            $total_hired_count = JobActivity::where('company_id', $user->id)->whereYear('created_at', $request->year)->where('status', 'Hired')->get()->count() + $hired_count;
            $total_reject_count = JobActivity::where('company_id', $user->id)->whereYear('created_at', $request->year)->where('status', 'Rejected')->get()->count() + $reject_count;
            return [$total_job, $total_companies, $total_applicant, $total_new_count, $total_short_count, $total_interview_count, $total_offered_count, $total_hired_count, $total_reject_count];
        }
        return response('Sorry   Something went wrong  ');
    }

    public function MonthlyData(Request $request)
    {
        if (!Auth::check()) {
            return response('Sorry   You are not an authenticated Employer  ');

        }

        if ($request->has('month') && $request->month != '') {
            $month = Carbon::parse($request->month)->month;
            if ($request->has('team_id') && $request->team_id != '') {
                $user = User::where('id', $request->team_id)
                    ->with('teams')
                    ->first();
            } else {
                $user = User::where('id', auth()->user()->id)
                    ->with('teams')
                    ->first();
            }
            $collection = collect($user->teams);
            $filtered_id = $collection->pluck('id');

            $team_job_count = Job::whereIn('user_id', $filtered_id)
                ->whereYear('created_at', $request->year != '' ? $request->year : Carbon::now()->year)->whereMonth('created_at', $month)->count();
            $applicant_count = JobActivity::whereIn('company_id', $filtered_id)
                ->whereYear('created_at', $request->year != '' ? $request->year : Carbon::now()->year)->whereMonth('created_at', $month)->count();
            $new_count = JobActivity::whereIn('company_id', $filtered_id)
                ->whereYear('created_at', $request->year != '' ? $request->year : Carbon::now()->year)->whereMonth('created_at', $month)->where('status', 'New')->count();
            $short_count = JobActivity::whereIn('company_id', $filtered_id)
                ->whereYear('created_at', $request->year != '' ? $request->year : Carbon::now()->year)->whereMonth('created_at', $month)->where('status', 'Shortlisted')->count();
            $interview_count = JobActivity::whereIn('company_id', $filtered_id)
                ->whereYear('created_at', $request->year != '' ? $request->year : Carbon::now()->year)->whereMonth('created_at', $month)->where('status', 'Interview')->count();
            $offered_count = JobActivity::whereIn('company_id', $filtered_id)
                ->whereYear('created_at', $request->year != '' ? $request->year : Carbon::now()->year)->whereMonth('created_at', $month)->where('status', 'Offered')->count();
            $hired_count = JobActivity::whereIn('company_id', $filtered_id)
                ->whereYear('created_at', $request->year != '' ? $request->year : Carbon::now()->year)->whereMonth('created_at', $month)->where('status', 'Hired')->count();
            $reject_count = JobActivity::whereIn('company_id', $filtered_id)
                ->whereYear('created_at', $request->year != '' ? $request->year : Carbon::now()->year)->whereMonth('created_at', $month)->where('status', 'Rejected')->count();

            $total_companies;
            if ($request->assign == 'true' && $request->team_id) {
                $total_companies = Company::where('assign_id', $request->team_id)->whereYear('created_at', $request->year != '' ? $request->year : Carbon::now()->year)->whereMonth('created_at', $month)->count();
            } else {
                $total_companies = Company::where('user_id', auth()->user()->id)->whereYear('created_at', $request->year != '' ? $request->year : Carbon::now()->year)->whereMonth('created_at', $month)->count();
            }

            if ($request->has('team_id') && $request->team_id != '') {
                $total_job = Job::where('user_id', $request->team_id)->whereYear('created_at', $request->year != '' ? $request->year : Carbon::now()->year)->whereMonth('created_at', $month)->count() + $team_job_count;
                $total_applicant = JobActivity::where('company_id', $request->team_id)->whereYear('created_at', $request->year != '' ? $request->year : Carbon::now()->year)->whereMonth('created_at', $month)->get()->count() + $applicant_count;
            } else {
                $total_job = Job::where('user_id', auth()->user()->id)->whereYear('created_at', $request->year != '' ? $request->year : Carbon::now()->year)->whereMonth('created_at', $month)->count() + $team_job_count;
                $total_applicant = JobActivity::where('company_id', auth()->user()->id)->whereYear('created_at', $request->year != '' ? $request->year : Carbon::now()->year)->whereMonth('created_at', $month)->get()->count() + $applicant_count;
            }

            $total_new_count = JobActivity::where('company_id', $user->id)
                ->whereYear('created_at', $request->year != '' ? $request->year : Carbon::now()->year)->whereMonth('created_at', $month)->where('status', 'New')->get()->count() + $new_count;
            $total_short_count = JobActivity::where('company_id', $user->id)
                ->whereYear('created_at', $request->year != '' ? $request->year : Carbon::now()->year)->whereMonth('created_at', $month)->where('status', 'Shortlisted')->get()->count() + $short_count;
            $total_interview_count = JobActivity::where('company_id', $user->id)
                ->whereYear('created_at', $request->year != '' ? $request->year : Carbon::now()->year)->whereMonth('created_at', $month)->where('status', 'Interview')->get()->count() + $interview_count;
            $total_offered_count = JobActivity::where('company_id', $user->id)
                ->whereYear('created_at', $request->year != '' ? $request->year : Carbon::now()->year)->whereMonth('created_at', $month)->where('status', 'Offered')->get()->count() + $offered_count;
            $total_hired_count = JobActivity::where('company_id', $user->id)
                ->whereYear('created_at', $request->year != '' ? $request->year : Carbon::now()->year)->whereMonth('created_at', $month)->where('status', 'Hired')->get()->count() + $hired_count;
            $total_reject_count = JobActivity::where('company_id', $user->id)
                ->whereYear('created_at', $request->year != '' ? $request->year : Carbon::now()->year)->whereMonth('created_at', $month)->where('status', 'Rejected')->get()->count() + $reject_count;
            return [$total_job, $total_companies, $total_applicant, $total_new_count, $total_short_count, $total_interview_count, $total_offered_count, $total_hired_count, $total_reject_count];
        }
        return response('Sorry   Something went wrong  ');
    }

}
