<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\ImageUploadHelper;
use App\Helpers\StringHelper;
use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use Illuminate\Http\Request;

class SponsorController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth:admin');

    }

    /*

    Sponsor list

     */

    public function index()
    {

        $sponsors = Sponsor::orderBy('id', 'desc')->get();

        return view('backend.pages.sponsor.index', compact('sponsors'));

    }

    public function trash()
    {

        $sponsors = Sponsor::orderBy('id', 'desc')->get();

        return view('backend.pages.sponsor.index', compact('sponsors'));

    }

    /*

    Save sponsor

     */

    public function store(Request $request)
    {

        $this->validate($request, [

            'link' => 'required',

        ]);

        $sponsor = new Sponsor();

        $sponsor->name = $request->name;
        $sponsor->link = $request->link;

        $sponsor->image = ImageUploadHelper::upload('image', $request->file('image'), time(), 'images/sponsors');

        $sponsor->save();

        session()->flash('success', ' Sponsor  Added Sucessfully');

        return back();

    }

    /*

    Update sponsor

     */

    public function update(Request $request, $id)
    {

        $sponsor = Sponsor::find($id);

        if ($sponsor) {

            $this->validate($request, [

                'link' => 'required',

            ]);

            $sponsor->name = $request->name;
            $sponsor->link = $request->link;

            if ($request->image) {

                if ($sponsor->image) {

                    $sponsor->image = ImageUploadHelper::update('image', $request->file('image'), time(), 'images/sponsors', $sponsor->image);

                } else {

                    $sponsor->image = ImageUploadHelper::upload('image', $request->file('image'), time(), 'images/sponsors');

                }

            }

            $sponsor->save();

            session()->flash('success', 'Sponsor  Updated Sucessfully');

            return redirect()->route('admin.sponsor.index');

        } else {

            return redirect()->route('admin.sponsor.index');

        }

    }

    /*

    Delete sponsor and related information

     */

    public function destroy($id)
    {

        $sponsor = Sponsor::find($id);

        if ($sponsor) {

            if ($sponsor->image) {

                ImageUploadHelper::delete('images/sponsors/' . $sponsor->image);

            }

            $sponsor->delete();

            session()->flash('error', 'Sponsor Deleted Sucessfully');
            return redirect()->route('admin.sponsor.index');

        }

    }


}