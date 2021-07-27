<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PersonalityResult;
use App\Models\PersonalityQuestion;
class PersonalityController extends Controller
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
        $company = auth()->user()->is_company;
        $found = PersonalityResult::where('user_id', auth()->user()->id)->select('id')->first();
        if(!$found && !$company){
            return view('frontend.pages.candidates.exam.exam', compact('id'));
        }
        return redirect()->back();
    }
    /**
     * Display all Question that are available
     *
     * @return \Illuminate\Http\Response
     */
    public function questions($id)
    {
        $personality = PersonalityQuestion::count();
        if($personality >=70){
            return PersonalityQuestion::select('id','question','answer_1', 'answer_2')->inRandomOrder()->limit(70)->get();
        }else{
            return response()->json(['error'=> 'error']);
        }
    }



    /**
     * check Examp Status
     *
     */
    public function examStatus()
    {
       return PersonalityResult::where('user_id', auth()->user()->id)->select('id')->first();
    }

    /**
     * Store Result data in Result Table
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function Results(Request $request)
    {
        if($request->seconds !== 0){
            $time = gmdate("H:i:s", $request->seconds);
         }else{
            $time = gmdate("H:i:s",1800);
         }
        //calculate main answer

      $answer = $request->answer;
      $collection = collect($answer);
      $arr = $collection->split(10);

    $results = [$arr[0], $arr[1], $arr[2], $arr[3], $arr[4], $arr[5], $arr[6], $arr[7], $arr[8], $arr[9]];
         $col_1 = [];
         $col_2 = [];
         $col_3 = [];
         $col_4 =  [];
         $col_5 =  [];
         $col_6 =  [];
         $col_7 =  [];
         for ($i=0; $i <count($results) ; $i++) {
                  $col_1[] = $results[$i][0];
                  $col_2[] = $results[$i][1];
                  $col_3[] = $results[$i][2];
                  $col_4[] = $results[$i][3];
                  $col_5[] = $results[$i][4];
                  $col_6[] = $results[$i][5];
                  $col_7[] = $results[$i][6];
            }
      //   // coding col_1 sum
        $col_1 = collect($col_1);
        $col_1_A =  $col_1->sum('answer_1');
        $col_1_B =  $col_1->sum('answer_2');
        // coding col_2 sum
        $col_2 = collect($col_2);
        $col_2_A =  $col_2->sum('answer_1');
        $col_2_B =  $col_2->sum('answer_2');
        // coding col_3 sum
        $col_3 = collect($col_3);
        $col_3_A =  $col_3->sum('answer_1');
        $col_3_B =  $col_3->sum('answer_2');
        // coding col_4 sum
        $col_4 = collect($col_4);
        $col_4_A =  $col_4->sum('answer_1');
        $col_4_B =  $col_4->sum('answer_2');
        // coding col_5 sum
        $col_5 = collect($col_5);
        $col_5_A =  $col_5->sum('answer_1');
        $col_5_B =  $col_5->sum('answer_2');
        // coding col_6 sum
        $col_6 = collect($col_6);
        $col_6_A =  $col_6->sum('answer_1');
        $col_6_B =  $col_6->sum('answer_2');
        // coding col_6 sum
        $col_7 = collect($col_7);
        $col_7_A =  $col_7->sum('answer_1');
        $col_7_B =  $col_7->sum('answer_2');

         $val_arr = [];

         if($col_1_A == $col_1_B ){
            $val_arr[0] = 'E';
         }elseif($col_1_A > $col_1_B){
            $val_arr[0] = 'E';
         }else{
            $val_arr[0] = 'I';
         }

         $sum_col_2_3_A =  $col_2_A + $col_3_A;
         $sum_col_2_3_B =  $col_2_B + $col_3_B;

         if($sum_col_2_3_A == $sum_col_2_3_B ){
            $val_arr[1] = 'S';
         }elseif($sum_col_2_3_A > $sum_col_2_3_B){
            $val_arr[1] = 'S';
         }else{
            $val_arr[1] = 'N';
         }

         $sum_col_4_5_A =  $col_4_A + $col_5_A;
         $sum_col_4_5_B =  $col_4_B + $col_5_B;

         if($sum_col_4_5_A == $sum_col_4_5_B ){
            $val_arr[2] = 'T';
         }elseif($sum_col_4_5_A > $sum_col_4_5_B){
            $val_arr[2] = 'T';
         }else{
            $val_arr[2] = 'F';
         }

         $sum_col_6_7_A =  $col_6_A + $col_7_A;
         $sum_col_6_7_B =  $col_6_B + $col_7_B;

         if($sum_col_6_7_A == $sum_col_6_7_B ){
            $val_arr[3] = 'J';
         }elseif($sum_col_6_7_A > $sum_col_6_7_B){
            $val_arr[3] = 'J';
         }else{
            $val_arr[3] = 'P';
         }

        $Result = new PersonalityResult();
        $Result->user_id = $request->user_id;
        $Result->personality_result = implode("",$val_arr );
        $Result->que_answer =  $request->total;
        $Result->time = $time;
        $Result->status = 1;
        $Result->save();

        return response()->json(
            [
                'success'=> 'success',
            ]
        );

    }
}
