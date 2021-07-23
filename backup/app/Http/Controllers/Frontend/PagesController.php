<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Country;
use App\Models\Job;
use App\Models\Setting;
use App\Models\SiteReview;

class PagesController extends Controller
{

    /**

     * index()

     *

     * Site Homepage

     *

     * @return view

     */

    public function index()
    { 
        $categories = Category::orderBy('name', 'asc')->where('is_featured', 1)->where('status', 1)->limit(20)->get();

        // $categories = Category::orderBy('name', 'asc')->limit(20)->get();

        $countries = Country::orderBy('name', 'asc')->get();

        $recent_jobs = Job::where('is_confirmed', 1)->orderBy('id', 'desc')->where('status_id', 1)->limit(8)->get();

        $featured_jobs = Job::where('is_confirmed', 1)->where('is_featured', 1)->where('status_id', 1)->orderBy('id', 'desc')->limit(8)->get();

        $reviews = SiteReview::where('is_confirmed', 1)->get();

        return view('frontend.pages.index', compact( 'categories', 'recent_jobs', 'featured_jobs', 'countries', 'reviews'));

    }

    public function termsAndService()
    {

        $terms_data = Setting::first()->terms_and_service;

        return view('frontend.pages.terms', compact('terms_data'));

    }

    public function privacyPolicy()
    {

        $privacy_data = Setting::first()->privacy_policy;

        return view('frontend.pages.privacy', compact('privacy_data'));

    }

    public function about_us()
    {

        $about = Setting::first()->about_us;

        return view('frontend.pages.about', compact('about'));

    }

}
