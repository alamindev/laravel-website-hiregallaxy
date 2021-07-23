<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\ImageUploadHelper;
use App\Helpers\StringHelper;
use App\Models\Job;

class JobsController extends Controller
{
  public function __construct(){
    $this->middleware('auth:admin');
  }

  /*
  Job list
   */
  public function index()
  {
    $jobs = Job::orderBy('id', 'desc')->where('is_confirmed',1)->get();
    return view('backend.pages.job.index', compact('jobs'));
  }  

  public function trash()
  {
    $jobs = Job::orderBy('id', 'desc')->where('is_confirmed',0)->get();
    return view('backend.pages.job.index', compact('jobs'));
  }


  /*
  Save Job
   */
  public function store(Request $request)
  {
    $this->validate($request, [
      'name' => 'required',
      'slug' => 'nullable|unique:Jobs'
    ]);

    $Job = new Job();
    $Job->name = $request->name;
    if ($request->slug) {
      $Job->slug = $request->slug;
    }else{
      $Job->slug = StringHelper::createSlug($request->name, 'Job', 'slug');
    }
    
    $Job->description = $request->description;
    $Job->save();

    session()->flash('success', 'Job added successfully');
    return back();
  }


  /*
  Update Job
   */
  public function update(Request $request, $id)
  {
    $Job = Job::find($id);

    if($Job){
      $this->validate($request, [
        'name' => 'required',
        'slug' => 'required|unique:Jobs,slug,'.$Job->id,
      ]);

      $Job->name = $request->name;
      $Job->slug = $request->slug;
      $Job->description = $request->description;
      $Job->save();

      session()->flash('success', 'Job updated successfully');
      return redirect()->route('admin.job.index');
    }
    else{
      return redirect()->route('admin.job.index');
    }
  }

  /*
  Delete Job and related information
   */
  public function destroy($id)
  {
    $Job = Job::find($id);

    if($Job){
      if ($Job->is_confirmed == 1) {
        // Just inactive it
        $Job->is_confirmed = 0;
        $Job->save();
        session()->flash('error', 'Job trashed successfully');
      }else{
        // $Job->delete();
        $Job->is_confirmed = 0;
        $Job->save();
        session()->flash('error', 'Job deleted successfully');
      }
      
      return redirect()->route('admin.job.index');
    }
    else{
      return redirect()->route('admin.job.index');
    }
  }  

  public function active($id)
  {
    $Job = Job::find($id);

    if($Job){
        $Job->is_confirmed = 1;
        $Job->save();
        session()->flash('error', 'Job Activated successfully');
      return back();
    }
    else{
      return redirect()->route('admin.job.index');
    }
  }
}
