<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    //api that returns a list of all categories.
    public function getAllCat(){
        // $list = Category::select('cat_name')->get();
        // return response()->json($list);
        $list = DB::table('categories')->select('cat_id','cat_name')->get();
        return response()->json($list);
    }

    //check number of levels per category
    //SELECT `categories`.* , count(`levels`.`lev_num`) as NumLevels FROM `categories` LEFT join `levels` on `categories`.cat_id = `levels`.`cat_id` group by `categories`.`cat_id`

    //function that returns level info by getting category id
    public function getLevel($cat_id){
        $list = DB::table('levels')
            ->where('cat_id',$cat_id)
            ->where('lev_num',1)
            ->select('lev_location')
            ->get();
            //echo "this is the list:".$list."end of line";
            // var_dump($list);
        $data = explode(",", $list[0]->lev_location);
        $coords = [
            'lat' => $data[0],
            'lng' => $data[1]
        ];
        return response()->json($coords);
    }

    //check if game continues
    public function checkHowManyLevel($cat_id){
        
        $res;
    
        $numLevels = DB::table('levels')
                     ->select(DB::raw('count(`lev_num`) as numLev'))
                     ->where('cat_id', $cat_id)
                     ->groupBy('cat_id')
                     ->get();

        $res = $numLevels;
    
        return response()->json($res);
    }

    //load the coordinates of next level (if exists)
    public function loadNextLevel($currentLev,$cat_id){
        $list = DB::table('levels')
        ->where('cat_id',$cat_id)
        ->where('lev_num',$currentLev + 1)
        ->select('lev_location')
        ->get();
        //echo "this is the list:".$list."end of line";
        // var_dump($list);
    $data = explode(",", $list[0]->lev_location);
    $coords = [
        'lat' => $data[0],
        'lng' => $data[1]
    ];
    return response()->json($coords);
    }

    //load the questions and answers of a chosen level by ID
    public function loadQuestion($lev_num,$cat_id){
        $lev_id = DB::table('levels')              
                ->where('lev_num',$lev_num)
                ->where('cat_id',$cat_id)
                ->value('lev_id');
        $max = DB::table('questions')
                ->select(DB::raw('max(ques_num) as max'))
                ->where('lev_id',$lev_id)
                ->get();
        $result = DB::table('questions')
        ->select('questions.ques_id','questions.ques_num', 'questions.ques_content')
        ->where('questions.lev_id',$lev_id)
        ->get();
        $data2=null;
        for($i = 0;$i < $max[0]->max ; $i++){
            $list = DB::table('answers')
                    -> select ('ans_id','ans_content')
                    ->where('ques_id', $result[$i]->ques_id)
                    ->get();
 
            // shuffle($list); 

        $data[$i] = [
          
            'ID' => $result[$i]->ques_id,
            'Number' => $result[$i]->ques_num,
            'Content' => $result[$i]->ques_content,
            'answers' => $list
            ];
            $data[$i]= json_decode(json_encode($data[$i]), true);
            shuffle($data[$i]['answers'] );
            
        }
        return response()->json($data);

    }

    //check whether answers submitted are correct
    public function checkAns($ans_id){
        $resultSet;

        $ans_id = explode(',',$ans_id);
        $numQuestions =count($ans_id);
        $numCorrect = 0;
        foreach ($ans_id as $id){
            $result = DB::table('answers')
                    ->where('ans_id',$id)
                    ->value('ans_correct');
            if ($result==1){
                // echo 'correct ' . $result;
                $resultSet[] = ($result);
                $numCorrect ++;
            }
            else 
            {
                // echo 'wrong '.$result;
                $resultSet[] = ($result);
            }
        }
        $score = ($numCorrect/$numQuestions)*100;
        $score = number_format((float)$score, 0, '.', ''); 
        return $score.'%';

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function shuffle_assoc($list) {
      if (!is_array($list)) return $list;
    
      $keys = array_keys($list);
      shuffle($keys);
      $random = array();
      foreach ($keys as $key)
        $random[$key] = $list[$key];
    
      return $random;
    }
    
    
}