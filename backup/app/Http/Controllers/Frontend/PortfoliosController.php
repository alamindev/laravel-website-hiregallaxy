<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\ImageUploadHelper;
use App\Helpers\UploadHelper;
use App\Http\Controllers\Controller;
use App\Models\UserPortfolio;
use Auth;
use Illuminate\Http\Request;

class PortfoliosController extends Controller
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

            'title' => 'required',

            'image' => 'required|image',

            'description' => 'required',

            'link' => 'nullable',

            'file' => 'nullable|mimes:zip',

        ]);

        $userPortfolio = new UserPortfolio();

        $userPortfolio->user_id = Auth::id();

        $userPortfolio->title = $request->title;

        $userPortfolio->link = $request->link;

        $userPortfolio->description = $request->description;

        // If featured Image Upload It

        $userPortfolio->image = ImageUploadHelper::upload('image', $request->file('image'), time(), 'images/portfolios');

        $userPortfolio->file = UploadHelper::upload('file', $request->file('file'), time(), 'files/portfolios');

        $userPortfolio->save();

        $userPortfolio->priority = $userPortfolio->id;

        $userPortfolio->save();

        session()->flash('success', 'New Portfolio has been created for you .');

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

        $userPortfolio = UserPortfolio::find($id);

        if (Auth::id() != $userPortfolio->user_id) {

            session()->flash('error', 'Sorry . You can not edit others skill');

            return back();

        }

        $this->validate($request, [

            'title' => 'required',

            'image' => 'nullable|image',

            'description' => 'required',

            'link' => 'nullable|url',

            'file' => 'nullable|mimes:zip',

        ]);

        $userPortfolio->user_id = Auth::id();

        $userPortfolio->title = $request->title;

        $userPortfolio->description = $request->description;

        $userPortfolio->link = $request->link;

        // If featured Image Upload It

        if ($request->image) {

            if (!is_null($userPortfolio->image)) {

                if (file_exists('images/portfolios/' . $userPortfolio->image)) {

                    unlink('images/portfolios/' . $userPortfolio->image);

                }

            }

            $userPortfolio->image = ImageUploadHelper::update('image', $request->file('image'), time(), 'images/portfolios', 'images/portfolios/' . $userPortfolio->image);

        }

        if ($request->file) {

            if (!is_null($userPortfolio->file)) {

                if (file_exists('files/portfolios/' . $userPortfolio->file)) {

                    unlink('files/portfolios/' . $userPortfolio->file);

                }

            }

            $userPortfolio->file = UploadHelper::upload('file', $request->file('file'), time(), 'files/portfolios');

        }

        $userPortfolio->save();

        session()->flash('success', 'Portfolio has been updated for you .');

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

        $userPortfolio = UserPortfolio::find($id);

        if (Auth::id() != $userPortfolio->user_id) {

            session()->flash('error', 'Sorry . You can not delete others portfolio');

            return back();

        }

        if (!is_null($userPortfolio->file)) {

            if (file_exists('files/portfolios/' . $userPortfolio->file)) {

                unlink('files/portfolios/' . $userPortfolio->file);

            }

        }

        if (!is_null($userPortfolio->image)) {

            if (file_exists('images/portfolios/' . $userPortfolio->image)) {

                unlink('images/portfolios/' . $userPortfolio->image);

            }

        }

        $userPortfolio->delete();

        session()->flash('success', 'Portfolio has been deleted successfully .');

        return back();

    }

}
