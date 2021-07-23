<?php



namespace App\Http\Controllers\Backend;



use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Models\PersonalityQuestion;



class PersonalityQuestionController extends Controller

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

            $questions = PersonalityQuestion::orderBy('created_at', 'desc')->where('user_id', auth()->user()->id)->get();

        }else{

            $questions = PersonalityQuestion::get();

        } 

 

        return view('backend.pages.personalities.question.index')->with(compact('questions'));

    }



    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        return view('backend.pages.personalities.question.create');

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

            'question' => 'required',

            'answer_1' => 'required',

            'answer_2' => 'required',

        ]);



        $question = new PersonalityQuestion();

        $question->question = $request->question;

        $question->answer_1 = $request->answer_1;

        $question->answer_2 = $request->answer_2;

        $question->user_id = auth()->user()->id;

        $question->save();

        return redirect()->route('admin.personality.question.index')->with('message', 'Question created successfully');

    }

 /**

     * upload image

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function upload(Request $request)

    {

        $request->upload->move(public_path('uploads'), $request->file('upload')->getClientOriginalName());

        return json_encode(array('file_name' => $request->file('upload')->getClientOriginalName()));

    }

    /**

     * showing all files

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function fileBrowser()

    {

        $paths = glob(public_path('uploads/*'));

        $fileNames = array();

        foreach ($paths as $path) {

            array_push($fileNames, basename($path));

        }

        return view('backend.pages.personalities.question.file_browser')->with(compact('fileNames'));

    }

 /**

     * Display the specified resource.

     *

     * @param  \App\Question  $question

     * @return \Illuminate\Http\Response

     */

    public function show($id)

    {

        $question = PersonalityQuestion::where('id', $id)->first();

        return view('backend.pages.personalities.question.view',compact('question'));

    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        $question = PersonalityQuestion::where('id', $id)->first();

        return view('backend.pages.personalities.question.edit',compact('question'));

    }



    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function update( Request $request, $id )

    {

        $this->validate( $request, [

            'question' => 'required',

            'answer_1' => 'required',

            'answer_2' => 'required',

        ]);



        $question = PersonalityQuestion::find( $id );

        $question->question = $request->question;

        $question->answer_1 = $request->answer_1;

        $question->answer_2 = $request->answer_2;

        $question->save();

        return redirect()->route('admin.personality.question.index')->with('message', 'Question updated successfully');

    }



    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        PersonalityQuestion::find($id)->delete();

        return redirect()->route('admin.personality.question.index')->with('message', 'Question Deleted successfully');

    }

}

