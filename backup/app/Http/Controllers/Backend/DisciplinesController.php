<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\ImageUploadHelper;
use App\Helpers\StringHelper;
use App\Models\Discipline;

class DisciplinesController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:admin');
  }

  /*
  Discipline list
   */
  public function index()
  {
    $disciplines = Discipline::where('status', 1)->orderBy('id', 'desc')->get();
    return view('backend.pages.discipline.index', compact('disciplines'));
  }

  public function trash()
  {
    $disciplines = Discipline::where('status', 0)->orderBy('id', 'desc')->get();
    return view('backend.pages.discipline.index', compact('disciplines'));
  }


  /*
  Save discipline
   */
  public function store(Request $request)
  {
    $this->validate($request, [
      'name' => 'required',
      'slug' => 'nullable|unique:disciplines'
    ]);

    $discipline = new Discipline();
    $discipline->name = $request->name;
    if ($request->slug) {
      $discipline->slug = $request->slug;
    } else {
      $discipline->slug = StringHelper::createSlug($request->name, 'Discipline', 'slug');
    }

    $discipline->description = $request->description;
    $discipline->save();

    session()->flash('success', 'Discipline added successfully');
    return back();
  }


  /*
  Update discipline
   */
  public function update(Request $request, $id)
  {
    $discipline = Discipline::find($id);

    if ($discipline) {
      $this->validate($request, [
        'name' => 'required',
        'slug' => 'required|unique:disciplines,slug,' . $discipline->id,
      ]);

      $discipline->name = $request->name;
      $discipline->slug = $request->slug;
      $discipline->description = $request->description;
      $discipline->save();

      session()->flash('success', 'Discipline updated successfully');
      return redirect()->route('admin.discipline.index');
    } else {
      return redirect()->route('admin.discipline.index');
    }
  }

  /*
  Delete discipline and related information
   */
  public function destroy($id)
  {
    $discipline = Discipline::find($id);

    if ($discipline) {
      if ($discipline->status == 1) {
        // Just inactive it
        $discipline->status = 0;
        $discipline->save();
        session()->flash('error', 'Discipline trashed successfully');
      } else {
        $discipline->delete();
        session()->flash('error', 'Discipline deleted successfully');
      }

      return redirect()->route('admin.discipline.index');
    } else {
      return redirect()->route('admin.discipline.index');
    }
  }

  public function active($id)
  {
    $discipline = Discipline::find($id);

    if ($discipline) {
      $discipline->status = 1;
      $discipline->save();
      session()->flash('error', 'Discipline Activated successfully');
      return redirect()->route('admin.discipline.index');
    } else {
      return redirect()->route('admin.discipline.index');
    }
  }
}
