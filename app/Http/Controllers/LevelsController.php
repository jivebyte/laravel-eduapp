<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Level;
use App\user;
use App\Category;
use DB;

class LevelsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)    {
        $allLevels = DB:: select('select * from levels where cat_id =? order by lev_num asc',[$id]);
        return view('level.details')->with('levels',$allLevels)->with('cat_id',$id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)    {
        $last = Level::where('cat_id',$id)->orderBy('lev_num','desc')->first();
        if(!blank($last)){
            $newLevel = $last->lev_num +1;
        }else{
                $newLevel = 1;
        }
        return view('level.add')->with('cat_id',$id)->with('newLevel',$newLevel);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$cid)    {
        $this->validate($request, [
            'location' =>'required'
        ]);

        $level = new Level();
        $level->lev_location = $request->input('location');
        $level->cat_id = $cid;
        $level->lev_num = $request->input('position');

        $allLevel = Level::where('cat_id',$cid)->where('lev_num','>=',$request->input('position'))->get();
        if(!blank($allLevel)){
            foreach ($allLevel as $upperLevel){
                ++$upperLevel->lev_num;
                $upperLevel->save();
            }
        }

        $level->save();

        return redirect('/levels/'.$cid)->with('success', 'Level added');
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
    public function destroy($lid,$lnum,$cid)
    {
       $allLevel = Level::where('cat_id',$cid)->where('lev_num','>',$lnum)->get();
        foreach ($allLevel as $level){
            --$level->lev_num;
            $level->save();
        }

        $currentLevel = Level::find($lid);
        $currentLevel->delete();
        return redirect('/levels/'.$cid)->with('success', 'Level Deleted');
    }
}
