<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\UserQualification;
use Auth;
use Illuminate\Http\Request;

class EducationsController extends Controller
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

            'certificate_degree_name' => 'required',

            'institute_university_name' => 'required',

            'start_date' => 'required',

            'major_subject' => 'required',

            'description' => 'required',

        ]);

        $userQualification = new UserQualification();

        $userQualification->user_id = Auth::id();

        $userQualification->certificate_degree_name = $request->certificate_degree_name;

        $userQualification->institute_university_name = $request->institute_university_name;

        $userQualification->description = $request->description;

        $userQualification->start_date = \Carbon\Carbon::parse($request->start_date)->format('Y-m-d') ;

        if ($request->is_current_qualification) {

            $userQualification->is_current_qualification = 1;

            $userQualification->end_date = null;

        } else {

            $userQualification->is_current_qualification = 0;

            $userQualification->end_date = \Carbon\Carbon::parse($request->end_date)->format('Y-m-d') ;

        }

        $userQualification->percentage = $request->percentage;

        $userQualification->get_cgpa = $request->get_cgpa;

        $userQualification->on_cgpa = $request->on_cgpa;

        $userQualification->major_subject = $request->major_subject;

        $userQualification->save();

        session()->flash('success', 'New Qualification has been created for you .');

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

        $userQualification = UserQualification::find($id);

        if (Auth::id() != $userQualification->user_id) {

            session()->flash('error', 'Sorry . You can not edit others qualification');

            return back();

        }

        $this->validate($request, [

            'certificate_degree_name' => 'required',

            'institute_university_name' => 'required',

            'start_date' => 'required',

            'major_subject' => 'required',

            'description' => 'required',

        ]);

        $userQualification->user_id = Auth::id();

        $userQualification->certificate_degree_name = $request->certificate_degree_name;

        $userQualification->institute_university_name = $request->institute_university_name;

        $userQualification->description = $request->description;

        $userQualification->start_date = $request->start_date;

        if ($request->is_current_qualification) {

            $userQualification->is_current_qualification = 1;

            $userQualification->end_date = null;

        } else {

            $userQualification->is_current_qualification = 0;

            $userQualification->end_date = $request->end_date;

        }

        $userQualification->percentage = $request->percentage;

        $userQualification->get_cgpa = $request->get_cgpa;

        $userQualification->on_cgpa = $request->on_cgpa;

        $userQualification->major_subject = $request->major_subject;

        $userQualification->save();

        session()->flash('success', 'Qualification has been updated for you .');

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

        $userQualification = UserQualification::find($id);

        if (Auth::id() != $userQualification->user_id) {

            session()->flash('error', 'Sorry . You can not edit others experience');

            return back();

        }

        $userQualification->delete();

        session()->flash('success', 'Qualification has been deleted successfully .');

        return back();

    }

}