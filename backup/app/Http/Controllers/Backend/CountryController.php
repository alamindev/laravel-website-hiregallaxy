<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\City as Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth:admin');

    }

    /*

    Country list

     */

    public function index()
    {

        $countries = Country::orderBy('name', 'asc')->get();
        return view('backend.pages.country.index', compact('countries'));

    }

    /*

    Save country

     */

    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
        ]);

        $country = new Country();

        $country->name = $request->name;

        $country->save();

        session()->flash('success', 'Country added successfully');

        return back();

    }

    /*

    Update country

     */

    public function update(Request $request, $id)
    {

        $country = Country::find($id);

        if ($country) {

            $this->validate($request, [

                'name' => 'required',

            ]);

            $country->name = $request->name;

            $country->save();

            session()->flash('success', 'Country updated successfully');

            return redirect()->route('admin.country.index');

        } else {

            return redirect()->route('admin.country.index');

        }

    }

    /*

    Delete country and related information

     */

    public function destroy($id)
    {

        $country = Country::find($id);

        if ($country) {

            $country->delete();

            session()->flash('error', 'Country deleted successfully');

            return redirect()->route('admin.country.index');

        } else {

            return redirect()->route('admin.country.index');

        }

    }
}
