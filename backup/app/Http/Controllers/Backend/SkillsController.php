<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\StringHelper;
use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;

class SkillsController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth:admin');

    }

    /*

    Skill list

     */

    public function index()
    {

        $skills = Skill::where('status', 1)->orderBy('id', 'desc')->get();

        return view('backend.pages.skill.index', compact('skills'));

    }

    public function trash()
    {

        $skills = Skill::where('status', 0)->orderBy('id', 'desc')->get();

        return view('backend.pages.skill.index', compact('skills'));

    }

    /*

    Save skill

     */

    public function store(Request $request)
    {

        $this->validate($request, [

            'name' => 'required',

            'slug' => 'nullable|unique:skills',

        ]);

        $skill = new Skill();

        $skill->name = $request->name;
        $skill->type = $request->type;

        if ($request->slug) {

            $skill->slug = $request->slug;

        } else {

            $skill->slug = StringHelper::createSlug($request->name, 'Skill', 'slug');

        }

        $skill->description = $request->description;

        $skill->save();

        session()->flash('success', 'Skill added successfully');

        return back();

    }

    /*

    Update skill

     */

    public function update(Request $request, $id)
    {

        $skill = Skill::find($id);

        if ($skill) {

            $this->validate($request, [

                'name' => 'required',

                'slug' => 'required|unique:skills,slug,' . $skill->id,

            ]);

            $skill->name = $request->name;

            $skill->slug = $request->slug;
    $skill->type = $request->type;
            $skill->description = $request->description;

            $skill->save();

            session()->flash('success', 'Skill updated successfully');

            return redirect()->route('admin.skill.index');

        } else {

            return redirect()->route('admin.skill.index');

        }

    }

    /*

    Delete skill and related information

     */

    public function destroy($id)
    {

        $skill = Skill::find($id);

        if ($skill) {

            if ($skill->status == 1) {

                // Just inactive it

                $skill->status = 0;

                $skill->save();

                session()->flash('error', 'Skill trashed successfully');

            } else {

                $skill->delete();

                session()->flash('error', 'Skill deleted successfully');

            }

            return redirect()->route('admin.skill.index');

        } else {

            return redirect()->route('admin.skill.index');

        }

    }

    public function active($id)
    {

        $skill = Skill::find($id);

        if ($skill) {

            $skill->status = 1;

            $skill->save();

            session()->flash('error', 'Skill Activated successfully');

            return redirect()->route('admin.skill.index');

        } else {

            return redirect()->route('admin.skill.index');

        }

    }

}
