<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\ImageUploadHelper;
use App\Helpers\StringHelper;
use App\Models\Experience;

class ExperiencesController extends Controller
{
  public function __construct(){
    $this->middleware('auth:admin');
  }

  /*
  Experience list
   */
  public function index()
  {
    $experiences = Experience::where('status', 1)->orderBy('id', 'desc')->get();
    return view('backend.pages.experience.index', compact('experiences'));
  }  

  public function trash()
  {
    $experiences = Experience::where('status', 0)->orderBy('id', 'desc')->get();
    return view('backend.pages.experience.index', compact('experiences'));
  }


  /*
  Save experience
   */
  public function store(Request $request)
  {
    $this->validate($request, [
      'name' => 'required',
      'slug' => 'nullable|unique:experiences'
    ]);

    $experience = new Experience();
    $experience->name = $request->name;
    if ($request->slug) {
      $experience->slug = $request->slug;
    }else{
      $experience->slug = StringHelper::createSlug($request->name, 'Experience', 'slug');
    }
    
    $experience->description = $request->description;
    $experience->save();

    session()->flash('success', 'Experience added successfully');
    return back();
  }


  /*
  Update experience
   */
  public function update(Request $request, $id)
  {
    $experience = Experience::find($id);

    if($experience){
      $this->validate($request, [
        'name' => 'required',
        'slug' => 'required|unique:experiences,slug,'.$experience->id,
      ]);

      $experience->name = $request->name;
      $experience->slug = $request->slug;
      $experience->description = $request->description;
      $experience->save();

      session()->flash('success', 'Experience updated successfully');
      return redirect()->route('admin.experience.index');
    }
    else{
      return redirect()->route('admin.experience.index');
    }
  }

  /*
  Delete experience and related information
   */
  public function destroy($id)
  {
    $experience = Experience::find($id);

    if($experience){
      if ($experience->status == 1) {
        // Just inactive it
        $experience->status = 0;
        $experience->save();
        session()->flash('error', 'Experience trashed successfully');
      }else{
        $experience->delete();
        session()->flash('error', 'Experience deleted successfully');
      }
      
      return redirect()->route('admin.experience.index');
    }
    else{
      return redirect()->route('admin.experience.index');
    }
  }  

  public function active($id)
  {
    $experience = Experience::find($id);

    if($experience){
        $experience->status = 1;
        $experience->save();
        session()->flash('error', 'Experience Activated successfully');
      return redirect()->route('admin.experience.index');
    }
    else{
      return redirect()->route('admin.experience.index');
    }
  }
}
