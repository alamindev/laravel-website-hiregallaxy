<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\UserAward;
use Auth;
use Illuminate\Http\Request;

class AwardsController extends Controller
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

            'award_name' => 'required',

            'company_name' => 'required',

            'date' => 'required',

            'description' => 'required',

        ]);

        $userAward = new UserAward();

        $userAward->user_id = Auth::id();

        $userAward->award_name = $request->award_name;

        $userAward->company_name = $request->company_name;

        $userAward->date = $request->date;

        $userAward->description = $request->description;

        $userAward->save();

        session()->flash('success', 'New Award has been created for you .');

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

        $userAward = UserAward::find($id);

        if (Auth::id() != $userAward->user_id) {

            session()->flash('error', 'Sorry . You can not edit others award');

            return back();

        }

        $this->validate($request, [

            'award_name' => 'required',

            'company_name' => 'required',

            'date' => 'required',

            'description' => 'required',

        ]);

        $userAward->user_id = Auth::id();

        $userAward->award_name = $request->award_name;

        $userAward->company_name = $request->company_name;

        $userAward->date = $request->date;

        $userAward->description = $request->description;

        $userAward->save();

        session()->flash('success', 'Award has been updated for you .');

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

        $userAward = UserAward::find($id);

        if (Auth::id() != $userAward->user_id) {

            session()->flash('error', 'Sorry . You can not edit others award');

            return back();

        }

        $userAward->delete();

        session()->flash('success', 'Award has been deleted successfully .');

        return back();

    }

}
