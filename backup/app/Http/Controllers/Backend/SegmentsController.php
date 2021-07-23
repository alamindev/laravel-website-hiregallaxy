<?php



namespace App\Http\Controllers\Backend;



use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Helpers\ImageUploadHelper;

use App\Helpers\StringHelper;

use App\Models\Segment;



class SegmentsController extends Controller

{

  public function __construct()

  {

    $this->middleware('auth:admin');

  }



  /*

  Segment list

   */

  public function index()

  {

    $segments = Segment::where('status', 1)->orderBy('id', 'desc')->get();

    return view('backend.pages.segment.index', compact('segments'));

  }



  public function trash()

  {

    $segments = Segment::where('status', 0)->orderBy('id', 'desc')->get();

    return view('backend.pages.segment.index', compact('segments'));

  }





  /*

  Save segment

   */

  public function store(Request $request)

  {

    $this->validate($request, [

      'name' => 'required',

      'slug' => 'nullable|unique:segments'

    ]);



    $segment = new Segment();

    $segment->name = $request->name;

    if ($request->slug) {

      $segment->slug = $request->slug;

    } else {

      $segment->slug = StringHelper::createSlug($request->name, 'Segment', 'slug');

    }



    $segment->description = $request->description;

    $segment->save();



    session()->flash('success', ' Employer Added Sucessfully');

    return back();

  }





  /*

  Update segment

   */

  public function update(Request $request, $id)

  {

    $segment = Segment::find($id);



    if ($segment) {

      $this->validate($request, [

        'name' => 'required',

        'slug' => 'required|unique:segments,slug,' . $segment->id,

      ]);



      $segment->name = $request->name;

      $segment->slug = $request->slug;

      $segment->description = $request->description;

      $segment->save();



      session()->flash('success', ' Employer Updated Sucessfully');

      return redirect()->route('admin.segment.index');

    } else {

      return redirect()->route('admin.segment.index');

    }

  }



  /*

  Delete segment and related information

   */

  public function destroy($id)

  {

    $segment = Segment::find($id);



    if ($segment) {

      if ($segment->status == 1) {

        // Just inactive it

        $segment->status = 0;

        $segment->save();

        session()->flash('error', ' Employer Trashed Sucessfully');

      } else {

        $segment->delete();

        session()->flash('error', 'Employer Deleted Sucessfully');

      }



      return redirect()->route('admin.segment.index');

    } else {

      return redirect()->route('admin.segment.index');

    }

  }



  public function active($id)

  {

    $segment = Segment::find($id);



    if ($segment) {

      $segment->status = 1;

      $segment->save();

      session()->flash('error', 'Employer Activated successfully');

      return redirect()->route('admin.segment.index');

    } else {

      return redirect()->route('admin.segment.index');

    }

  }

}