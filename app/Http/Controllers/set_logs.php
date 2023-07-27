<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exam_set_A_log;
use App\Models\set_a_question_paper;
use App\Models\Candidate;


class set_logs extends Controller
{
    public function store(Request $request)
    {
        $qdata = set_a_question_paper::where('lang','english');
        $candidates=Candidate::all();
        foreach($candidates as $cand)
        {
        for($i=1;$i<=$qdata->count();$i++) //i is for number of questions
        {
        $qpset_A=set_a_question_paper::find($i);
        $res=new Exam_set_A_log;
        $res->reg_no=$cand->reg_no;
        $res->Question_number="".$i;
        $res->SQN=$qpset_A->SQn;
        $res->selected_ans="0";
        $res->points="0";
        $res->save();     
        }
    
    }
        return response()->json($res, 200);       
    
    }


    public function create_logs_set_A($request)
    {


    }
    

}
