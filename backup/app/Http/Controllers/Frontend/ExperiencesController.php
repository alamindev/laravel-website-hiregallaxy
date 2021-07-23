<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\UserExperience;
use Auth;
use Illuminate\Http\Request;

class ExperiencesController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth:web');

    }

    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)
    {

        $this->validate($request, [

            'job_title' => 'required',

            'company_name' => 'required',

            'start_date' => 'required',

            'job_location_country' => 'required',

            'description' => 'required',

        ]);

        $userExperience = new UserExperience();

        $userExperience->user_id = Auth::id();

        $userExperience->job_title = $request->job_title;

        $userExperience->company_name = $request->company_name;

        $userExperience->description = $request->description;

        $userExperience->start_date = \Carbon\Carbon::parse($request->start_date)->format('Y-m-d');

        if (isset($request->is_current_job)) {

            $userExperience->is_current_job = 1;

            $userExperience->end_date = null;

        } else {

            $userExperience->is_current_job = 0;

            $userExperience->end_date =  \Carbon\Carbon::parse($request->end_date)->format('Y-m-d');

        }

        $userExperience->job_location_city = $request->job_location_city;

        $userExperience->job_location_state = $request->job_location_state;

        $userExperience->job_location_country = $request->job_location_country;

        $userExperience->save();

        session()->flash('success', 'New Experience has been created for you .');

        return back();

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

        $userExperience = UserExperience::find($id);

        if (Auth::id() != $userExperience->user_id) {

            session()->flash('error', 'Sorry . You can not edit others experience');

            return back();

        }

        $this->validate($request, [

            'job_title' => 'required',

            'company_name' => 'required',

            'start_date' => 'required',

            'description' => 'required',

        ]);

        $userExperience->user_id = Auth::id();

        $userExperience->job_title = $request->job_title;

        $userExperience->company_name = $request->company_name;

        $userExperience->description = $request->description;

        $userExperience->start_date = \Carbon\Carbon::parse($request->start_date)->format('Y-m-d');

        if (isset($request->is_current_job)) {

            $userExperience->is_current_job = 1;

            $userExperience->end_date = null;

        } else {

            $userExperience->is_current_job = 0;

            $userExperience->end_date = \Carbon\Carbon::parse($request->end_date)->format('Y-m-d');

        }

        $userExperience->job_location_city = null;

        $userExperience->job_location_state = $request->job_location_state;

        $userExperience->job_location_country = $request->job_location_country;

        $userExperience->save();

        session()->flash('success', 'Experience has been updated for you .');

        return back();

    }

    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)
    {

        $userExperience = UserExperience::find($id);

        if (Auth::id() != $userExperience->user_id) {

            session()->flash('error', 'Sorry . You can not edit others experience');

            return back();

        }

        $userExperience->delete();

        session()->flash('success', 'Experience has been deleted successfully .');

        return back();

    }

}