<?php



namespace App\Http\Controllers\Backend;



use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Models\Personality;

class PersonalityController extends Controller

{

    public function __construct()

    {

        $this->middleware('auth:admin');

    }

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        if(auth()->user()->hasRole('editor')){

            $personalities = Personality::orderBy('created_at', 'desc')->where('user_id', auth()->user()->id)->get();

        }else{

            $personalities = Personality::get();

        } 



        return view('backend.pages.personalities.personality.index')->with(compact('personalities'));

    }



   /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        return view('backend.pages.personalities.personality.create');

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

        ]);



        $personality = new Personality();

        $personality->title = $request->title;

        $personality->sub_title = $request->sub_title;

        $personality->description = $request->description;

        $personality->strengths = $request->strengths;

        $personality->user_id = auth()->user()->id;

        $personality->weaknesses = $request->weaknesses;

        $personality->save();

        return redirect()->route('admin.personality.index')->with('message', 'Personality created successfully');

    }



    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show($id)

    {

        $personality = Personality::where('id', $id)->first();

        return view('backend.pages.personalities.personality.view',compact('personality'));

    }



    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        $edit = Personality::where('id', $id)->first();

        return view('backend.pages.personalities.personality.edit',compact('edit'));

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

        $this->validate($request, [

            'title' => 'required',

        ]);



        $personality = Personality::find($id);

        $personality->title = $request->title;

        $personality->sub_title = $request->sub_title;

        $personality->description = $request->description;

        $personality->strengths = $request->strengths;

        $personality->weaknesses = $request->weaknesses;

        $personality->save();

        return redirect()->route('admin.personality.index')->with('message', 'Personality Update successfully');

    }



    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        Personality::find($id)->delete();

        return redirect()->route('admin.personality.index')->with('message', 'Personality Deleted successfully');

    }

}