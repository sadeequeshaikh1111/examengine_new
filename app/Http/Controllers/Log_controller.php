<?php

namespace App\Http\Controllers;
use App\Models\candidate;
use Illuminate\Http\Request;
use App\Models\exam_set_a_log;
use App\Models\exam_set_b_log;
use App\Models\exam_set_c_log;
use App\Models\exam_set_d_log;
use App\Models\set_a_question_paper;
use App\Models\set_b_question_paper;
use App\Models\set_c_question_paper;
use App\Models\set_d_question_paper;
use Illuminate\Support\Facades\DB;
class Log_controller extends Controller
{
    public function create_logs(Request $request)
        {          
               
          
               $data =candidate::where('reg_no',$request->reg_no)->update($request->all()); 
               return response()->json($data, 200); 
        }    
        public function save_answer(Request $request)
        {          $reg_no=$request->input('reg_no');
              $data=candidate::where('reg_no',$request->input('reg_no'))->first();
              $qpset=$data->qpset;
              $qid=$request->Sqn;
              
              $point=0;

              // Build update data with lowercase 'sqn' column (PostgreSQL) instead of 'Sqn'
              // Using DB::table to bypass Eloquent $fillable (models only allow 'points')
              $updateData = $request->except(['_token', 'Sqn']);
              $updateData['sqn'] = $qid;
              $updateData['points'] = $point;

           //$data =candidate::where('reg_no',$request->reg_no)->update($request->all()); 
           if($qpset=="A")
          {
            //array_merge($request->all(), ['points' => 'point'])
            //get weitage negative and key of question
      $question=set_a_question_paper::where('sqn',$qid)->first();

            if($question->key==$request->selected_ans)
            {
              $point=$question->weitage;
            }
            
            else{
              $point=-1*$question->negative;
            }
            if($request->selected_ans==0)
            {
              $point=0;
            
            }
            $updateData['points'] = $point;
            $data =DB::table('exam_set_a_logs')->where('reg_no',$request->reg_no)->where('sqn',$qid)->update($updateData);


          }
          elseif ($qpset=="B")
          { 
          //  $log_B=exam_set_b_log::where('reg_no',$request->reg_no)->first();
          //$log_B->update(array_merge($request->all(), ['selected_ans'=>$request->selected_ans]));
         //array_merge($request->all(), ['points' => 'point'])
            //get weitage negative and key of question
            $question=set_b_question_paper::where('sqn',$qid)->first();
            $point=0;
            if($question->key==$request->selected_ans)
            {
              $point=$question->weitage;
            }
            else{
              $point=-1*$question->negative;
            }
            if($request->selected_ans==0)
            {
              $point=0;
            
            }
            $updateData['points'] = $point;
            $data =DB::table('exam_set_b_logs')->where('reg_no',$request->reg_no)->where('sqn',$qid)->update($updateData);


            }     
          elseif ($qpset=="C")
          { 
//array_merge($request->all(), ['points' => 'point'])
            //get weitage negative and key of question
            $question=set_c_question_paper::where('sqn',$qid)->get()->first();
            $point=0;
            if($question->key==$request->selected_ans)
            {
              $point=$question->weitage;
            }
            else{
              $point=-1*$question->negative;
            }
            if($request->selected_ans==0)
            {
              $point=0;
            
            }
            $updateData['points'] = $point;
            $data =DB::table('exam_set_c_logs')->where('reg_no',$request->reg_no)->where('sqn',$qid)->update($updateData);
            return "Qid ".$qid." key ".$question->key." selected answer ".$request->selected_ans;

          }
          else
          { 
//array_merge($request->all(), ['points' => 'point'])
            //get weitage negative and key of question
            $question=set_d_question_paper::where('sqn',$qid)->first();
            $point=0;
            if($question->key==$request->selected_ans)
            {
              $point=$question->weitage;

            }
            else{
              $point=-1*$question->negative;

            }
            if($request->selected_ans==0)
            {
              $point=0;
            
            }
            $updateData['points'] = $point;
            $data =DB::table('exam_set_d_logs')->where('reg_no',$request->reg_no)->where('sqn',$qid)->update($updateData);

          $keys=array_merge(['points' => $point],["selected_ans"=>$request->selected_ans],["key"=>$question->key]);

            
            return response()->json($keys, 200); 


          }         
               
          
          return response()->json($request->Sqn, 200); 
        } 
        public function get_qn_status($reg_no)
        {       
          
          $candidate =candidate::where('reg_no',$reg_no)->get()->first(); 
          if($candidate->qpset=="D")
{        $logs=exam_set_d_log::where('reg_no',$reg_no)->get();}
else if($candidate->qpset=="C")
{        $logs=exam_set_c_log::where('reg_no',$reg_no)->get();}
else if($candidate->qpset=="B")
{        $logs=exam_set_b_log::where('reg_no',$reg_no)->get();}
else{        $logs=exam_set_a_log::where('reg_no',$reg_no)->get();}

          return response()->json($logs, 200); 
        }
        public function get_qn_ans($reg_no,$qn)
        {
          $candidate =candidate::where('reg_no',$reg_no)->get()->first(); 
        if($candidate->qpset=="D")
          {$data=exam_set_d_log::where('reg_no',$reg_no)->where('sqn',$qn)->get()->first();}
         else if($candidate->qpset=="C")
          {$data=exam_set_c_log::where('reg_no',$reg_no)->where('sqn',$qn)->get()->first();}
         else if($candidate->qpset=="B")
          {$data=exam_set_b_log::where('reg_no',$reg_no)->where('sqn',$qn)->get()->first();}
          else{ $data=exam_set_a_log::where('reg_no',$reg_no)->where('sqn',$qn)->get()->first();}

          return response()->json($data, 200); 
        }
      public function save_current(Request $request)
      { 
            // Use DB::table to bypass Eloquent $fillable (candidate model doesn't allow 'current_qn')
            $data =DB::table('candidates')->where('reg_no',$request->reg_no)->update($request->all()); 
            return response()->json($data, 200); 

            
      }

      public function end_exam(Request $request)
      { $reg_no=$request->reg_no;
        $data =candidate::where('reg_no',$request->reg_no)->first();

        if($data->qpset=='A')
        {$marks = DB::table('exam_set_a_logs')->where('reg_no', '=',$reg_no)->sum('points'); 
          $data =candidate::where('reg_no',$request->reg_no)->update(array_merge($request->all(), ['marks' => $marks],['status'=>"submited"]));

        }
        else if($data->qpset=='B')
        {$marks = DB::table('exam_set_b_logs')->where('reg_no', '=',$reg_no)->sum('points'); 
          $data =candidate::where('reg_no',$request->reg_no)->update(array_merge($request->all(), ['marks' => $marks]));

        }
        else if($data->qpset=='C')
        {   
          $marks = DB::table('exam_set_c_logs')->where('reg_no', '=',$reg_no)->sum('points'); 
          $data =candidate::where('reg_no',$request->reg_no)->update(array_merge($request->all(), ['marks' => $marks]));

        }
       else{$marks = DB::table('exam_set_d_logs')->where('reg_no', '=',$reg_no)->sum('points');
        $data =candidate::where('reg_no',$request->reg_no)->update(array_merge($request->all(), ['marks' => $marks]));

      }
        
        //     return response()->json($candidate, 200); 

        $showResult = env('SHOW_RESULT', 0);
        if($showResult==1)
        {
          return "reg number ".$reg_no."exam ended marks ".$marks;
        }
       else
       {
        return "Exam Submitted Thank you";
       }
            
      }
      
      



    }

