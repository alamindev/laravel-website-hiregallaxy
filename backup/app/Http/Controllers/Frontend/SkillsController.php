<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\UserSkill;
use Auth;
use Illuminate\Http\Request;

class SkillsController extends Controller
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

            'skill_id' => 'required',

            'percentage' => 'required',

        ]);
        if ($request->edit_skill_id != '') {
            $userSkill = UserSkill::find($request->edit_skill_id);
        } else {
            $userSkill = new UserSkill();
        }

        $userSkill->user_id = Auth::id();

        $userSkill->skill_id = $request->skill_id;

        $userSkill->percentage = $request->percentage;

        $userSkill->save();

        if ($request->edit_skill_id != '') {

            session()->flash('success', 'New Skill has been Updated for you .');
        } else {

            session()->flash('success', 'New Skill has been created for you .');
        }
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

        $userSkill = UserSkill::find($id);

        if (Auth::id() != $userSkill->user_id) {

            session()->flash('error', 'Sorry . You can not edit others skill');

            return back();

        }

        $this->validate($request, [

            'skill_id' => 'required',

            'percentage' => 'required',

        ]);

        $userSkill->user_id = Auth::id();

        $userSkill->skill_id = $request->skill_id;

        $userSkill->percentage = $request->percentage;

        $userSkill->save();

        session()->flash('success', 'Skill has been updated for you .');

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

        $userSkill = UserSkill::find($id);

        if (Auth::id() != $userSkill->user_id) {

            session()->flash('error', 'Sorry . You can not delete others skill');

            return back();

        }

        $userSkill->delete();

        session()->flash('success', 'Skill has been deleted successfully .');

        return back();

    }

}
