<?php



namespace App\Http\Controllers\Frontend;



use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Models\Aptitude;

use Illuminate\Support\Collection;

use App\Models\AptitudeResult; 

use App\Models\Experience;

use App\User;

use Illuminate\Support\Arr;



class AptitudeResultController extends Controller

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

        $found = AptitudeResult::where('user_id', auth()->user()->id)->select('id')->first(); 

        if(!$found && !$company){

             $user = User::where('id', $id)->first();

           if(auth()->user()->id == $user->id){

                return view('frontend.pages.candidates.aptitude.exam', compact('id'));

           }else{

              return redirect()->route('candidates.dashboard');

           }

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

        $user = User::where('id',$id)->first();

        $candadite_experience = $user->getExperienceInYears() ; 

        if($candadite_experience){

            $aptitude_experiences =Aptitude::pluck('exparience'); 

              if(count($aptitude_experiences) > 0){

                    $aptitude_experience = [];

                    foreach($aptitude_experiences as $experience){

                        $aptitude_experience[] = array_map('intval', explode(',', $experience));

                    } 

                    $collection = collect($aptitude_experience); 

                    $collapsed = $collection->collapse();

                    $collection = collect($collapsed); 

                    $unique_exp_id = $collection->unique(); 

                    $experiences = Experience::whereIn('id', $unique_exp_id)

                ->select('id','name')->get(); 

                $new_exp_id = [];

                foreach($experiences as $exp){

                    if($exp->name != 'N/A'){

                            $min =  explode('-',explode(' ', $exp->name)[0])[0]; 

                            $max =  explode('-',explode(' ', $exp->name)[0])[1];  

                            if(($min <= $candadite_experience) && ($candadite_experience <= $max)){

                                $new_exp_id[] = $exp->id; 

                            } 

                        } 

                }   

                $aptitudes = Aptitude::with('aptitudeanswers')->get(); 

                $new_aptitudes = [];

                foreach($aptitudes as $aptitude){

                    $exp_id = array_map('intval', explode(',', $aptitude->exparience));

                    foreach($exp_id as $id){

                        if(in_array($id, $new_exp_id)){

                            $new_aptitudes[] =  $aptitude;

                        } 

                    }

                } 

                $questions = $this->array_unique_custom($new_aptitudes); 

                    if(count($questions) >= 30){

                        

                        $questions = collect($questions)->random(30);



                        $data = [];

                            for($i = 0; $i < count($questions); $i++){

                                $data[$i]['id'] = $questions[$i]->id;

                                $data[$i]['questions'] = $questions[$i]->aptitude;

                                $data[$i]['responses']['answer_1'] = $questions[$i]->aptitudeanswers['answer_1'];

                                $data[$i]['responses']['answer_2'] = $questions[$i]->aptitudeanswers['answer_2'];

                                $data[$i]['responses']['answer_3'] = $questions[$i]->aptitudeanswers['answer_3'];

                                $data[$i]['responses']['answer_4'] = $questions[$i]->aptitudeanswers['answer_4'];

                            }

                            $withUser = [

                                'id' => auth()->user()->id,

                                'user' => auth()->user()->name,

                                $data

                            ];

                        return $withUser;

                    }else{

                        return response()->json(['error'=> 'error']);

                    }

              } else{

                return response()->json(['error'=> 'error']);

              }

        }else{

            return response()->json(['error'=> 'error']);

        }

     

    }



    function array_unique_custom($array, $keep_key_assoc = false){

        $duplicate_keys = array();

        $tmp = array();

        foreach ($array as $key => $val){

            if (is_object($val))

                $val = (array)$val;

            if (!in_array($val, $tmp))

                $tmp[] = $val;

            else

                $duplicate_keys[] = $key;

        }

        foreach ($duplicate_keys as $key)

            unset($array[$key]);

        return $keep_key_assoc ? $array : array_values($array);

    }



    /**

     * check authinticate user skill

     *

     */

    public function checkSkill( )

    {

        return auth()->user()->skills;

    }

    /**

     * check Examp Status

     *

     */

    public function examStatus( )

    { 

       return AptitudeResult::where('user_id', auth()->user()->id)->select('id')->get(); 

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

        $question_id =  $collection->pluck('id')->all();

        $questions = Aptitude::with('aptitudeanswers')->whereIn('id', $question_id)->get();

        $que_collection = collect($questions);

        $answers =  $que_collection->pluck('aptitudeanswers')->all();

        $right_answer = [];

        for($i = 0; $i < count($answers); $i++){

           $id = $answers[$i]['aptitude_id'];

           $right_que_answer = $answers[$i]['right_answer'];

            for($j = 0; $j <= $i; $j++){

                $request_id = $request->answer[$j]['id'];

                $request_question = $request->answer[$j]['question']; 

                if( $id == $request_id ){

                    if( $right_que_answer ==  $request_question){

                        $right_answer[] = $right_que_answer;

                    }

                }

            }

        }

        // calculation result  

        $total_question = $request->total; 

        $x =(count($right_answer) / $total_question);



        $time_taken =    1800 - $request->seconds   ; 

        $y = gmdate("i.s", $time_taken ); 



        $result = round(( $x * ( 60 - $y ) ) / 100, 2);



        $flag = '';

        if($result >= 0.41){

            $flag = 'Excellent';

        }else if($result >= 0.31 && $result <= 0.40){

            $flag = 'Good';

        }else if($result >= 0.21 && $result <= 0.30){

            $flag = 'Average';

        }else if($result <= 0.18){

            $flag = 'Poor';

        } 



        $Result = new AptitudeResult();

        $Result->user_id = $request->user_id; 

        $Result->result = $flag;

        $Result->que_answer = $x;

        $Result->time = $y;

        $Result->status = 1;

        $Result->save(); 

        return response()->json(

            [

                'success'=> 'success' 

            ]

        );



    }



}

