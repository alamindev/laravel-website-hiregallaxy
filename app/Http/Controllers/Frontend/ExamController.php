<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobActivity;
use App\Models\Question;
use App\Models\Result;
use Illuminate\Http\Request;

class ExamController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth:web');

    }

    /**

     * fronend view

     *

     * @return \Illuminate\Http\Response

     */

    public function index($id)
    {
        $job_id = '';
        $job_activity  = JobActivity::where('id', $id)->first();
        if(!empty($job_activity)){
            $job_id =  $job_activity->job_id;
            if($job_activity->user_id == auth()->user()->id){
                return view('frontend.pages.employers.exam.exam', compact('id','job_id'));
            }else{
                return abort(404);
            }
        }else{
            return abort(404);
        }
    }

    /**

     * Display all Question that are available

     *

     * @return \Illuminate\Http\Response

     */

    public function questions($id)
    {

        $questions = [];



        $job_activity = JobActivity::where('id', $id)->first();
        if(!empty($job_activity)){
            $job_id = $job_activity->job_id;
            $job = Job::where('id', $job_id)->first();
            if(!empty($job)){
                $job_category_id = $job->category_id;

                $all_questions = Question::with('answers')->whereNotNull('positions')->get();

                $all_question = [];

                for ($d = 0; $d < count($all_questions); $d++) {
                    $positions = $all_questions[$d]['positions'];
                    $positions = explode(',', $positions);

                    for ($k = 0; $k < count($positions); $k++) {
                        $singlePosition = $positions[$k];
                        if ($singlePosition == $job_category_id) {
                            $all_question[] = $all_questions[$d];
                        }

                    }

                }
                $questions = $this->array_unique_custom($all_question);


                if (count($questions) >= 30) {

                    $questions = collect($questions);
                    $questions = $questions->random(30);

                    $data = [];

                    for ($i = 0; $i < count($questions); $i++) {

                        $data[$i]['id'] = $questions[$i]->id;

                        $data[$i]['questions'] = $questions[$i]->question;

                        $data[$i]['responses']['answer_1'] = $questions[$i]->answers['answer_1'];

                        $data[$i]['responses']['answer_2'] = $questions[$i]->answers['answer_2'];

                        $data[$i]['responses']['answer_3'] = $questions[$i]->answers['answer_3'];

                        $data[$i]['responses']['answer_4'] = $questions[$i]->answers['answer_4'];

                    }

                    $withUser = [

                        'id' => auth()->user()->id,

                        'user' => auth()->user()->name,

                        $data,

                    ];

                    return $withUser;

                }

                return response()->json(['error' => 'error']);


            }
        }


        //  $job_skills = Job::with('skills')->where('id', $id)->first();

        // if (!empty($job_skills)) {

        //     $skills = $job_skills->skills;

        //     if (count($skills) > 0) {

        //         $skill_id = $skills->pluck('id');

        //         $all_questions = Question::with('answers')->get();

        //         $all_question = [];

        //         for ($d = 0; $d < count($all_questions); $d++) {

        //             $skills = $all_questions[$d]['skills'];

        //             for ($k = 0; $k < count($skills); $k++) {

        //                 $singles = $skills[$k];

        //                 for ($j = 0; $j < count($skill_id); $j++) {

        //                     $skill_id[$j] . $singles;

        //                     if ($singles == $skill_id[$j]) {

        //                         $all_question[] = $all_questions[$d];

        //                     }

        //                 }

        //             }

        //         }
        //         $questions = $this->array_unique_custom($all_question);

        //         $new_questions = [];

        //         foreach ($questions as $que) {

        //             $exp = array_map('intval', explode(',', $que['exparience']));

        //             if (in_array($job_skills->experience_id, $exp)) {

        //                 $new_questions[] = $que;

        //             }

        //         }

        //         $questions = collect($new_questions);
        //         if (count($questions) > 30) {
        //             $questions = $questions->random(30);
        //             $collection = collect($questions);

        //             $question_pluck_id = $collection->pluck('id');

        //             $newQuestion = Question::with('answers')->inRandomOrder()->get();

        //             $new_collection = collect($newQuestion);

        //             $final = $new_collection->whereNotIn('id', $question_pluck_id);

        //             if (count($questions) < 30) {

        //                 $question_left = (30 - count($questions));

        //                 $result = collect($final)->random($question_left);

        //                 $collect = collect($questions);

        //                 return $questions = $collect->merge($result);

        //             }
        //         } else {
        //             return response()->json(['error' => 'error']);
        //         }
        //     } else {

        //         $questions = Question::with('answers')->inRandomOrder()->limit(30)->get();

        //     }

        // }

        // if (count($questions) >= 30) {

        //     $data = [];

        //     for ($i = 0; $i < count($questions); $i++) {

        //         $data[$i]['id'] = $questions[$i]->id;

        //         $data[$i]['questions'] = $questions[$i]->question;

        //         $data[$i]['responses']['answer_1'] = $questions[$i]->answers['answer_1'];

        //         $data[$i]['responses']['answer_2'] = $questions[$i]->answers['answer_2'];

        //         $data[$i]['responses']['answer_3'] = $questions[$i]->answers['answer_3'];

        //         $data[$i]['responses']['answer_4'] = $questions[$i]->answers['answer_4'];

        //     }

        //     $withUser = [

        //         'id' => auth()->user()->id,

        //         'user' => auth()->user()->name,

        //         $data,

        //     ];

        //     return $withUser;

        // }

        // return response()->json(['error' => 'error']);

    }

    public function array_unique_custom($array, $keep_key_assoc = false)
    {

        $duplicate_keys = array();

        $tmp = array();

        foreach ($array as $key => $val) {

            if (is_object($val)) {
                $val = (array) $val;
            }

            if (!in_array($val, $tmp)) {
                $tmp[] = $val;
            } else {
                $duplicate_keys[] = $key;
            }

        }

        foreach ($duplicate_keys as $key) {
            unset($array[$key]);
        }

        return $keep_key_assoc ? $array : array_values($array);

    }

    /**

     * check authinticate user skill

     *

     */

    public function checkSkill()
    {

        return auth()->user()->skills;

    }

    /**

     * check Examp Status

     *

     */

    public function examStatus()
    {

        return Result::where('user_id', auth()->user()->id)->select('job_activity_id')->get();

    }

    /**

     * Store Result data in Result Table

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function Results(Request $request)
    {

        $collection = collect($request->answer);

        $question_id = $collection->pluck('id')->all();

        $questions = Question::with('answers')->whereIn('id', $question_id)->get();

        $que_collection = collect($questions);

        $answers = $que_collection->pluck('answers')->all();

        $right_answer = [];

        for ($i = 0; $i < count($answers); $i++) {

            $id = $answers[$i]['question_id'];

            $right_que_answer = $answers[$i]['right_answer'];

            for ($j = 0; $j <= $i; $j++) {

                $request_id = $request->answer[$j]['id'];

                $request_question = $request->answer[$j]['question'];

                if ($id == $request_id) {

                    if ($right_que_answer == $request_question) {

                        $right_answer[] = $right_que_answer;

                    }

                }

            }

        }

        // calculation result

        // $total_question = $request->total;

        // $result_percent = '';

        // if(count($right_answer) > 0){

        //     $result_percent = (count($right_answer)  / $total_question) * 100;

        // }else{

        //     $result_percent = 0;

        // }

        // $result_percent;

        // $total_que = count($right_answer). '/'. $total_question;

        // if($request->seconds !== 0){

        //    $time = gmdate("H:i:s", $request->seconds);

        // }else{

        //    $time = gmdate("H:i:s",1800);

        // }

        $total_question = $request->total;

        $x = (count($right_answer) / $total_question);

        $time_taken = 1800 - $request->seconds;

         $y = gmdate("i.s", $time_taken);

        $result = round(($x * (60 - $y)) / 100, 2);

        $flag = '';

        if ($result >= 0.41) {

            $flag = 'Excellent';

        } else if ($result >= 0.31 && $result <= 0.40) {

            $flag = 'Good';

        } else if ($result >= 0.21 && $result <= 0.30) {

            $flag = 'Average';

        } else if ($result <= 0.18) {

            $flag = 'Poor';

        }

        $Result = new Result();

        $Result->user_id = $request->user_id;

        $Result->job_id = $request->job_id;

        $Result->job_activity_id = $request->job_activity_id;

        $Result->result = $flag;

        $Result->que_answer = $x;

        $Result->time = $y;

        $Result->status = 1;

        $Result->save();

        return response()->json(

            [

                'success' => 'success',

            ]

        );

    }

    /**

     * Display a final Result.

     *

     * @return \Illuminate\Http\Response

     */

    public function ShowResult()
    {

        $result = Result::where('user_id', auth()->user()->id)->where('status', 1)->first();

        return view('frontend.pages.employers.exam.exam-result', compact('result'));

    }

}
