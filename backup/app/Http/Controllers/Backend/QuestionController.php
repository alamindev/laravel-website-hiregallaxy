<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Answers;
use App\Models\Experience;
use App\Models\Question;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class QuestionController extends Controller
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

        if (auth()->user()->hasRole('editor')) {

            $questions = Question::orderBy('created_at', 'desc')->where('user_id', auth()->user()->id)->get();

        } else {

            $questions = Question::orderBy('created_at', 'desc')->get();

        }

        return view('backend.pages.question.index')->with(compact('questions'));

    }

    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()
    {

        $skills = Skill::orderBy('created_at', 'desc')->where('type',0)->where('status', 1)->get();

        $experiences = Experience::get();

        return view('backend.pages.question.create')->with(compact('skills', 'experiences'));

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

        ]);

        $explode = implode(',', $request->expariences);

        $question = new Question();

        $question->question = $request->question;

        $question->skills = $request->skills;

        $question->exparience = $explode;

        $question->user_id = auth()->user()->id;

        $question->save();

        $this->syncAnswer($request, $question->id);

        return redirect('admin/question')->with('message', 'Question created successfully');

    }

    public function upload(Request $request)
    {

        //   dd($request->all());

        $CKEditor = $request->input('CKEditor') ? $request->input('CKEditor') : null;

        $funcNum = $request->input('CKEditorFuncNum') ? $request->input('CKEditorFuncNum') : null;

        $message = $url = '';

        if (Input::hasFile('upload')) {

            $file = Input::file('upload');

            if ($file->isValid()) {

                $filename = rand(1000, 9999) . $file->getClientOriginalName();

                $file->move(public_path() . '/uploads/', $filename);

                $url = url('uploads/' . $filename);

            } else {

                $message = 'An error occurred while uploading the file.';

            }

        } else {

            $message = 'No file uploaded.';

        }

        if ($_GET['type'] == 'file') {

            return '<script>window.parent.CKEDITOR.tools.callFunction(' . $funcNum . ', "' . $url . '", "' . $message . '")</script>';

        }

        $data = ['uploaded' => 1, 'fileName' => $filename, 'url' => $url];

        return json_encode($data);

        // $request->upload->move(public_path('uploads'), $request->file('upload')->getClientOriginalName());

        // return json_encode(array('file_name' => $request->file('upload')->getClientOriginalName()));

    }

    public function fileBrowser()
    {

        $paths = glob(public_path('uploads/*'));

        $fileNames = array();

        foreach ($paths as $path) {

            array_push($fileNames, basename($path));

        }

        return view('backend.pages.question.file_browser')->with(compact('fileNames'));

    }

    /**

     * Display the specified resource.

     *

     * @param  \App\Question  $question

     * @return \Illuminate\Http\Response

     */

    public function show($id)
    {

        $question = Question::with('answers')->where('id', $id)->first();

        return view('backend.pages.question.view', compact('question'));

    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  \App\Question  $question

     * @return \Illuminate\Http\Response

     */

    public function edit(Question $question)
    {

        $skills = Skill::orderBy('created_at', 'desc')->where('type',0)->where('status', 1)->get();

        $experiences = Experience::get();

        return view('backend.pages.question.edit')->with(compact('skills', 'question', 'experiences'));

    }

    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  \App\Question  $question

     * @return \Illuminate\Http\Response

     */

    public function update(Request $request, $id)
    {

        $this->validate($request, [

            'question' => 'required',

        ]);

        $explode = implode(',', $request->expariences);

        $question = Question::find($id);

        $question->question = $request->question;

        $question->skills = $request->skills;

        $question->exparience = $explode;

        $question->save();

        $this->syncAnswer($request, $question->id);

        return redirect('admin/question')->with('message', 'Question updated successfully');

    }

    /**

     * Remove the specified resource from storage.

     *

     * @param  \App\Question  $question

     * @return \Illuminate\Http\Response

     */

    public function destroy(Question $question)
    {

    }

    public function delete_question($question_id)
    {

        Question::find($question_id)->delete();

        Answers::where('question_id', $question_id)->delete();

        return redirect('admin/question')->with('message', 'Question deleted successfully');

    }

    public function syncAnswer(Request $request, $question_id)
    {

        $answers = Answers::where('question_id', $question_id)->first();

        if ($answers && !empty($answers)) {

            $answers->answer_1 = $request->answer_1;

            $answers->answer_2 = $request->answer_2;

            $answers->answer_3 = $request->answer_3;

            $answers->answer_4 = $request->answer_4;

            $answers->right_answer = $request->right_answer;

            $answers->save();

        } else {

            $answers = new Answers();

            $answers->question_id = $question_id;

            $answers->answer_1 = $request->answer_1;

            $answers->answer_2 = $request->answer_2;

            $answers->answer_3 = $request->answer_3;

            $answers->answer_4 = $request->answer_4;

            $answers->right_answer = $request->right_answer;

            $answers->save();

        }

    }

}
