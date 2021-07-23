<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\StringHelper;
use App\Http\Controllers\Controller;
use App\Models\Sector;
use Illuminate\Http\Request;

class SectorsController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth:admin');

    }

    /*

    Sector list

     */

    public function index()
    {

        $sectors = Sector::where('status', 1)->orderBy('id', 'desc')->get();

        return view('backend.pages.sector.index', compact('sectors'));

    }

    public function trash()
    {

        $sectors = Sector::where('status', 0)->orderBy('id', 'desc')->get();

        return view('backend.pages.sector.index', compact('sectors'));

    }

    /*

    Save sector

     */

    public function store(Request $request)
    {

        $this->validate($request, [

            'name' => 'required',

            'slug' => 'nullable|unique:sectors',

        ]);

        $sector = new Sector();

        $sector->name = $request->name;

        if ($request->slug) {

            $sector->slug = $request->slug;

        } else {

            $sector->slug = StringHelper::createSlug($request->name, 'Sector', 'slug');

        }

        $sector->description = $request->description;

        $sector->save();

        session()->flash('success', 'Sector added successfully');

        return back();

    }

    /*

    Update sector

     */

    public function update(Request $request, $id)
    {

        $sector = Sector::find($id);

        if ($sector) {

            $this->validate($request, [

                'name' => 'required',

                'slug' => 'required|unique:sectors,slug,' . $sector->id,

            ]);

            $sector->name = $request->name;

            $sector->slug = $request->slug;

            $sector->description = $request->description;

            $sector->save();

            session()->flash('success', 'Sector updated successfully');

            return redirect()->route('admin.sector.index');

        } else {

            return redirect()->route('admin.sector.index');

        }

    }

    /*

    Delete sector and related information

     */

    public function destroy($id)
    {

        $sector = Sector::find($id);

        if ($sector) {

            if ($sector->status == 1) {

                // Just inactive it

                $sector->status = 0;

                $sector->save();

                session()->flash('error', 'Sector trashed successfully');

            } else {

                $sector->delete();

                session()->flash('error', 'Sector deleted successfully');

            }

            return redirect()->route('admin.sector.index');

        } else {

            return redirect()->route('admin.sector.index');

        }

    }

    public function active($id)
    {

        $sector = Sector::find($id);

        if ($sector) {

            $sector->status = 1;

            $sector->save();

            session()->flash('error', 'Sector Activated successfully');

            return redirect()->route('admin.sector.index');

        } else {

            return redirect()->route('admin.sector.index');

        }

    }

}
