<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\State;

class StatesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /*
  State list
   */
    public function index()
    {
        $states = State::orderBy('name', 'asc')->get();
        return view('backend.pages.states.index', compact('states'));
    }


    /*
    Save states
   */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $state = new State();
        $state->name = $request->name;
        $state->save();

        session()->flash('success', 'State added successfully');
        return back();
    }


    /*
  Update states
   */
    public function update(Request $request, $id)
    {
        $state = State::find($id);

        if ($state) {
            $this->validate($request, [
                'name' => 'required'
            ]);

            $state->name = $request->name;
            $state->save();

            session()->flash('success', 'State updated successfully');
            return redirect()->route('admin.states.index');
        } else {
            return redirect()->route('admin.states.index');
        }
    }

    /*
  Delete states and related information
   */
    public function destroy($id)
    {
        $state = State::find($id);

        if ($state) {
            $state->delete();
            session()->flash('error', 'State deleted successfully');
            return redirect()->route('admin.states.index');
        } else {
            return redirect()->route('admin.states.index');
        }
    }
}
