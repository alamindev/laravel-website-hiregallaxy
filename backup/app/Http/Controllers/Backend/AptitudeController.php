<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Aptitude;
use App\Models\AptitudeAnswer;
use App\Models\Experience;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class AptitudeController extends Controller
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

            $aptitudes = Aptitude::orderBy('created_at', 'desc')->where('user_id', auth()->user()->id)->get();

        } else {

            $aptitudes = Aptitude::orderBy('created_at', 'desc')->get();

        }

        return view('backend.pages.aptitude.index')->with(compact('aptitudes'));

    }

    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()
    {

        $skills = Skill::orderBy('created_at', 'desc')->where('type',2)->where('status', 1)->get();

        $experiences = Experience::get();

        return view('backend.pages.aptitude.create')->with(compact('skills', 'experiences'));

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

            'aptitude' => 'required',

        ]);

        $explode = implode(',', $request->expariences);

        $aptitude = new Aptitude();

        $aptitude->aptitude = $request->aptitude;

        $aptitude->skills = $request->skills;

        $aptitude->exparience = $explode;

        $aptitude->user_id = auth()->user()->id;

        $aptitude->save();

        $this->syncAnswer($request, $aptitude->id);

        return redirect('admin/aptitude')->with('message', 'Aptitude created successfully');

    }

    public function upload(Request $request)
    {

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

    }

    public function fileBrowser()
    {

        $paths = glob(public_path('uploads/*'));

        $fileNames = array();

        foreach ($paths as $path) {

            array_push($fileNames, basename($path));

        }

        return view('backend.pages.aptitude.file_browser')->with(compact('fileNames'));

    }

    /**

     * Display the specified resource.

     *

     * @param  \App\Aptitude  $aptitude

     * @return \Illuminate\Http\Response

     */

    public function show($id)
    {

        $aptitude = Aptitude::with('aptitudeanswers')->where('id', $id)->first();

        return view('backend.pages.aptitude.view', compact('aptitude'));

    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  \App\Aptitude  $aptitude

     * @return \Illuminate\Http\Response

     */

    public function edit(Aptitude $aptitude)
    {
        
        $skills = Skill::orderBy('created_at', 'desc')->where('type',2)->where('status', 1)->get();

        $experiences = Experience::get();

        return view('backend.pages.aptitude.edit')->with(compact('skills', 'aptitude', 'experiences'));

    }

    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  \App\aptitude  $aptitude

     * @return \Illuminate\Http\Response

     */

    public function update(Request $request, $id)
    {

        $this->validate($request, [

            'aptitude' => 'required',

        ]);

        $explode = implode(',', $request->expariences);

        $aptitude = Aptitude::find($id);

        $aptitude->aptitude = $request->aptitude;

        $aptitude->skills = $request->skills;

        $aptitude->exparience = $explode;

        $aptitude->save();

        $this->syncAnswer($request, $aptitude->id);

        return redirect('admin/aptitude')->with('message', 'Aptitude updated successfully');

    }

    public function delete_aptitude($aptitude_id)
    {

        Aptitude::find($aptitude_id)->delete();

        AptitudeAnswer::where('aptitude_id', $aptitude_id)->delete();

        return redirect('admin/aptitude')->with('message', 'Aptitude deleted successfully');

    }

    public function syncAnswer(Request $request, $aptitude_id)
    {

        $answers = AptitudeAnswer::where('aptitude_id', $aptitude_id)->first();

        if ($answers && !empty($answers)) {

            $answers->answer_1 = $request->answer_1;

            $answers->answer_2 = $request->answer_2;

            $answers->answer_3 = $request->answer_3;

            $answers->answer_4 = $request->answer_4;

            $answers->right_answer = $request->right_answer;

            $answers->save();

        } else {

            $answers = new AptitudeAnswer();

            $answers->aptitude_id = $aptitude_id;

            $answers->answer_1 = $request->answer_1;

            $answers->answer_2 = $request->answer_2;

            $answers->answer_3 = $request->answer_3;

            $answers->answer_4 = $request->answer_4;

            $answers->right_answer = $request->right_answer;

            $answers->save();

        }

    }

}
