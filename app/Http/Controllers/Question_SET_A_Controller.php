<?php

namespace App\Http\Controllers;

use App\Models\set_a_question_paper;
use App\Models\set_b_question_paper;
use App\Models\set_c_question_paper;
use App\Models\set_d_question_paper;
use Illuminate\Http\Request;
use App\Models\Candidate;
use App\Models\subject;


class Question_SET_A_Controller extends Controller
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
    public function shw()
    {
print("hello");
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
     * @param  \App\Models\set_a_question_paper  $set_a_question_paper
     * @return \Illuminate\Http\Response
     */
    public function show(set_a_question_paper $set_a_question_paper)
    {
        $subs=subject::all();    
        $data=Candidate::where('reg_no','2')->first();
        
    return view('exam_platform',compact('data','subs'));


    }
public function ajaxGetQuestion($id)
{
  $data = set_a_question_paper::find($id);
    return response()->json($data, 200); 
}
public function ajaxGetQuestionl($id,$lang)
{
  $data = set_a_question_paper::where('SQn',$id)->where('lang',$lang)->first();
    return response()->json($data, 200); 
}
public function ajaxGetQuestionl_byset($id,$lang,$reg_no)
{
    $candidate=Candidate::where('reg_no',$reg_no)->first();

  if($candidate->qpset=='A') //for set a
  {
    $data = set_a_question_paper::where('SQn',$id)->where('lang',$lang)->first();
  }
else if($candidate->qpset=='B')//for set b
{
    $data = set_b_question_paper::where('SQn',$id)->where('lang',$lang)->first();
    
}
else if($candidate->qpset=='C')//for set c
{
    $data = set_c_question_paper::where('SQn',$id)->where('lang',$lang)->first();
}
else//for set c
{
    $data = set_d_question_paper::where('SQn',$id)->where('lang',$lang)->first();
}


  return response()->json($data, 200); 
}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\set_a_question_paper  $set_a_question_paper
     * @return \Illuminate\Http\Response
     */
    public function edit(set_a_question_paper $set_a_question_paper)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\set_a_question_paper  $set_a_question_paper
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, set_a_question_paper $set_a_question_paper)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\set_a_question_paper  $set_a_question_paper
     * @return \Illuminate\Http\Response
     */
    public function destroy(set_a_question_paper $set_a_question_paper)
    {
        //
    }
}
