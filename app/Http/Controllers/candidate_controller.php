<?php

namespace App\Http\Controllers;
use App\Models\feedbacks;

use App\Models\exam_set_a_log;
use App\Models\exam_set_b_log;
use App\Models\exam_set_c_log;
use App\Models\exam_set_d_log;
use App\Models\set_a_question_paper;
use App\Models\set_b_question_paper;
use App\Models\set_c_question_paper;
use App\Models\set_d_question_paper;
use App\Models\instruction;
use App\Models\Language;
use App\Models\exammasters;
use App\Models\exam_question;
use App\Models\subject;
use Illuminate\Support\Facades\DB;
use App\Models\candidate;
use Illuminate\Http\Request;
use Yajra\Datatables\DataTables;

class candidate_controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
   
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
     * @param  \App\Models\candidate  $candidate
     * @return \Illuminate\Http\Response
     */
    public function show(candidate $candidate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\candidate  $candidate
     * @return \Illuminate\Http\Response
     */
    public function edit(candidate $candidate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\candidate  $candidate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, candidate $candidate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\candidate  $candidate
     * @return \Illuminate\Http\Response
     */
    public function destroy(candidate $candidate)
    {
        //
    }
public function get_set()
{

    
}
public function get_candidate_info($reg_no)
{
    $data=candidate::where('reg_no',$reg_no)->first();
    return response()->json($data, 200); 

}
public function update_time(Request $request)
{          $data =candidate::where('reg_no',$request->reg_no)->update($request->all());

      
   // $res=candidate::where('reg_no',$request->reg_no);
   // $res->time=$request->input('time');
   // $res->save();
    return response()->json($data, 200); 
 
}    
public function get_candidates()
        {          
            $data = candidate::latest()->get();
            return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id='.$data->reg_no.' class="edit btn btn-primary btn-sm"  onclick=Register(this.id)>Register</button> &nbsp;<button type="button" name="time" id='.$data->reg_no.' class="edit btn btn-primary btn-sm"  onclick=Add_time(this.id)>Un Register </button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        } 


        public function get_candidates_unlock()
        {          
            $data = candidate::latest()->get();
            return DataTables::of($data)
                    ->addColumn('action', function($data){
                      
                        $button = '<button type="button" name="time" id='.$data->reg_no.' class="edit btn btn-primary btn-sm"  onclick=Unlock(this.id)>Unlock </button> &nbsp;<button type="button" name="time" id='.$data->reg_no.' class="edit btn btn-primary btn-sm"  onclick=Add_time(this.id)>Add Time </button>';

                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }        
        public function get_candidates_list(Request $request)
        {      $data=candidate::select('reg_no','name','dob');
                       return DataTables::of($data)->make(true);
        } 

 public function set_logs(Request $request)
   {     
       $drcnt=exammasters::where('drive_status','Question Bank Set')->count();
 if($drcnt!=0)
 {   return response()->json("drive is not started", 200);    

}
  $reg_no=$request->input('reg_no');
  $data=candidate::where('reg_no',$request->input('reg_no'))->first();
  $qpset=$data->qpset;
 if($data->status =='not started')
 {

     
    if($qpset=='A')
    
  {
    
    $qpcnt=set_a_question_paper::all()->max('sqn');
    for($i=1;$i<=$qpcnt;$i++)
    {
    $qp=set_a_question_paper::find($i);    
    $res=new exam_set_a_log;
    $res->reg_no=$reg_no;
    $res->question_number=$qp->qn;
    $res->sqn=$qp->sqn;  
    $res->selected_ans="0";  
    $res->points="0";  
    $res->status="untouched";        
    $res->save();}
  }    

  if($qpset=='B')
 {  
    $qpcnt=set_b_question_paper::all()->max('sqn');
    for($i=1;$i<=$qpcnt;$i++)
    {
    $qp=set_b_question_paper::find($i);    
    $res=new exam_set_b_log;
    $res->reg_no=$reg_no;
    $res->question_number=$qp->qn;
    $res->sqn=$qp->sqn;  
    $res->selected_ans="0";  
    $res->points="0";      
    $res->status="untouched";  
    $res->save();}
 }    
    
 if($qpset=='C')
 { 
    $qpcnt=set_c_question_paper::all()->max('sqn');
     for($i=1;$i<=$qpcnt;$i++)
    {
    $qp=set_c_question_paper::find($i);    
    $res=new exam_set_c_log;
    $res->reg_no=$reg_no;
    $res->question_number=$qp->qn;
    $res->sqn=$qp->sqn;  
    $res->selected_ans="0";  
    $res->points="0";    
    $res->status="untouched";  
      $res->save();}
 }    
 if($qpset=='D')
 {    $qpcnt=set_d_question_paper::all()->max('sqn');

    for($i=1;$i<=$qpcnt;$i++)
    {
    $qp=set_d_question_paper::find($i);    
    $res=new exam_set_d_log;
    $res->reg_no=$reg_no;
    $res->question_number=$qp->qn;
    $res->sqn=$qp->sqn;  
    $res->selected_ans="0";  
    $res->points="0";      
    $res->status="untouched";  

    $res->save();}
 }    
$data->status="Present";
$data->save();
 #return response()->json($res, 200);    
 return ['success' => true, 'message' => 'New user created !!'];
}
else{ 
    $data->reg_no=0;   // return response()->json($data, 200);    
   return response()->json($data, 200);    

}



   }

   public function login(Request $request)//function for login
   {try{
 
    $name=$request->input('name');
    $password=$request->input('password');
   $user=candidate::where('reg_no',$name)->where('dob',$password)->get()->first();
   if($user)
   {
    if($user->status=="Loged In")
    {
     $request->session()->flash('msg','candidate Registration is not done');
        return back()->with('msg', 'candidate is Loged in on other computer');
    }
    if($user->status=="not started")
    {
     $request->session()->flash('msg','candidate Registration is not done');
        return back()->with('msg', 'Please Complete Registration process');
    }
    if($user->status=="unlocked")
    {
        $subs=subject::all();    
        $data=candidate::where('reg_no',$name)->first();
      $status_update=candidate::where('reg_no',$name)->first()->update(array_merge($request->all(), ['status' => 'Loged In']));
    }
       $subs=subject::all();    
    $drive=exammasters::where('drive_status',"running")->first();
    if($drive==null)
    {
        $request->session()->flash('msg','Drive is not running');
        return back()->with('msg', 'Drive is not started');
    }
       $data=candidate::where('reg_no',$name)->first();
     $status_update=candidate::where('reg_no',$name)->first()->update(array_merge($request->all(), ['status' => 'Loged In']));
     $languages = Language::all();

     $inst=instruction::where('language','English')->get();

     return view('instruction_page',compact('data','subs','drive','inst','languages'));//exam_platform this view is for examplatform
   }
 

else
{
         $request->session()->flash('msg','Invalid Credentials');
print($request->name);
   return back()->with('msg', 'Invalid credentials');
}
}
catch(MethodNotAllowedHttpException $e)
{
   return view('admin.admin_login');
}
  
   }
function start_test(Request $request)
{
      $reg_no=$request->input('reg_no');
    $data=candidate::where('reg_no',$reg_no)->first();
     $status_update=candidate::where('reg_no',$reg_no)->first()->update(array_merge($request->all(), ['status' => 'Loged In']));
     $languages = Language::all();
       $subs=subject::all();    
    $drive=exammasters::where('drive_status',"running")->first();

     $inst=instruction::where('language','English')->get();

         return view('exam_platform',compact('data','subs','drive','inst','languages'));//exam_platform 
}
  function set_status_unlock(Request $request)   
  {

    
    if($request->time==null)
    {
        $cad=candidate::where('reg_no',$request->Reg_no)->first();
        if($cad->status=="Loged In" || $cad->status=="unlocked")    
        {
            $data=candidate::where('reg_no',$request->Reg_no)->first()->update($request->all());
        }
        return response()->json($cad, 200);
    
    }
    else{
        $cad=candidate::where('reg_no',$request->Reg_no)->first();

        $extra_time=$request->time;
        $time=$cad->time + $extra_time;
        $data=candidate::where('reg_no',$request->Reg_no)->first()->update(array_merge($request->all(), ['time' => $time]));
        return response()->json($cad, 200);

    }

  }
function set_unlock_all(Request $request)
{
  //exammaster::where('exam_id', $r->exam_id)->update(["drive_status" => "running"]);
DB::table('candidates')
    ->where('status', 'Loged In')  // match exact case
    ->update(['status' => 'unlocked']);
//      $cad=candidate::where('reg_no',$request->Reg_no)->where('status',"loged in")->update(array_merge($request->all(), ['status' => 'Loged In']));;
return response("unlocked all");
}

/*
code to import drive db sql

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

$sql_dump = File::get('/path/to/file.sql');
DB::connection()->getPdo()->exec($sql_dump);


 */

function create_mock_candidates(Request $request)
{

candidate::query()->truncate(); 

$i=1;
do{    $res=new candidate;
    $res->reg_no=$i;
        $res->name='candidate '.$i;
        $res->node='C'.$i;
        $res->status="not started";  
        $res->dob="1234";      
        $res->time="4300";  
        if($i%2==0)
        {
        $res->qpset="B"; 
        if($i%4==0)
        {$res->qpset="D";}
    }
        else{$res->qpset="A";
            if($i%3==0)
            {$res->qpset="C";}
        }     
        $res->marks=$request->number;  
        $res->current_qn="1";      
        $res->save();
    $i++;
    }while($i<220);


    
return response(" created");
}


function create_mock_qp(Request $request)
{
    $Language = array("English"=>"Question", "मराठी"=>"प्रश्न क्रमांक", "हिंदी"=>"सवाल क्रमांक");
    
    set_a_question_paper::query()->truncate(); 
foreach($Language as $lang)
    {
$i=1;
do{    $res=new set_a_question_paper;
    $res->qn=$i;
        $res->sqn=$i;
        $res->Question='drive1'.$lang.$i;
        $res->option1="drive1 Question".$i.'option1';  
        $res->option2="drive1 Question".$i.'option2';  
        $res->option3="drive1 Question".$i.'option3';
        $res->option4="drive1 Question".$i.'option4';    
        $res->weitage='1';    
        $res->Negative='1';    
           if($i%2==0)
        {
        $res->Key="B"; 
        if($i%4==0)
        {$res->Key="D";}
        }
        else{$res->Key="A";
            if($i%3==0)
            {$res->Key="C";}
        } 
        if($i>25)    
       { $res->sub='sub2'; 
         if($i>50)
        { $res->sub='sub3';  }
        else if($i>75)
        { $res->sub='sub4';  }
    }          
       else{$res->sub='sub1';}
        $res->Qtype	="1";
        if($lang=="Question")
      {  $res->Lang	="English";}
      else if($lang=="प्रश्न क्रमांक")
      {$res->Lang	="मराठी";}
      else{$res->Lang	="हिंदी";}
        $res->save();
    $i++;
    }while($i<=100);

}
    
return response(" created");
}
function create_qp_sets()
{    set_b_question_paper::query()->truncate(); 
  
$count = subject::all()->count();

$lang="English";
for($i=1;$i<=$count;$i++)
{


$subq=subject::find($i);
$qusetions=$subq->Questions;
$qn_range_start=$subq->qn_range_start;
$qns=array();
for($x=0;$x<$qusetions;$x++)
{
    $qns[$x]=$qn_range_start+$x;
}
$shuffled =shuffle($qns);

foreach( $qns as $value ) {
    $qp=set_a_question_paper::where('sqn',$value)->get()->first();    
    $res=new set_b_question_paper;
    $res->sqn=$qn_range_start;
    $res->qn=$value;
    $res->Question=$qp->Question.' set b';
    $res->option1= $qp->option1;  
    $res->option2= $qp->option2;  
    $res->option3= $qp->option3;
    $res->option4= $qp->option4;    
    $res->weitage= $qp->weitage;    
    $res->Negative=$qp->Negative;
    $res->Key=$qp->Key;
    $res->Key=$qp->Negative;
    $res->sub=$qp->sub;
    $res->Qtype	=$qp->Qtype;
    $res->Lang	=$qp->Lang;
    $res->save();
    $qn_range_start++;
    
}


}
$shuffled_sqn=set_b_question_paper::all();    
$languages = set_a_question_paper::select('Lang')->distinct()->get();
foreach($languages as $lang)
{foreach($shuffled_sqn as $sqn)
{
    //return DB::table('users')->where('username', $username)->pluck('groupName');
if($lang->Lang!="English")
{   
   $qpb=set_b_question_paper::where('sqn',$sqn->sqn)->get()->first();
    $qpa=set_a_question_paper::where('qn',$qpb->qn)->where('Lang',$lang->Lang)->get()->first();

    $resb=new set_b_question_paper;
    $resb->sqn=$qpb->sqn;
    $resb->qn=$qpb->qn;
    $resb->Question=$qpa->Question.' set b';
    $resb->option1= $qpa->option1;  
    $resb->option2= $qpa->option2;  
    $resb->option3= $qpa->option3;
    $resb->option4= $qpa->option4;    
    $resb->weitage= $qpa->weitage;    
    $resb->Negative=$qpa->Negative;
    $resb->Key=$qpa->Key;
    $resb->Key=$qpa->Negative;
    $resb->sub=$qpa->sub;
    $resb->Qtype	=$qpa->Qtype;
    $resb->Lang	=$qpa->Lang;
    $resb->save();
}

}}

}
public function set_idle(Request $request)
{

 if($request->flag==0)
    {
         DB::table('candidates')->update(['Idle' => "True"]);
return response("Idle status set true Flag is: ".$request->flag);

    }
  else{
        DB::table('candidates')->where('status','Loged In')->update(['Dead' =>  DB::raw('Dead+1')]);
        DB::table('candidates')->where('Dead','>','2')->update(['status' =>  DB::raw('Locked')]);

return response("Dead status set true Flag is: ".$request->flag);
    }
 
}
public function set_dead(Request $request)
{


    

 

}


public function get_dead()
{
$list="";
$data=candidate::where('Dead','>=','2')->get();

foreach($data as $u)
{
    //$list=$list." Registration number ";
    $list=$list." ".$u->reg_no.",";
//    $list=$list." Node ";
  //  $list=$list." ".$u->node;

}
    return response()->json("These candidates are offline Registration number <br>".$list, 200);


}
public function get_idle()
{

$data=candidate::where('Dead','True')->get();
return $data;
}

public function end_test(Request $request)
{
    $reg_no=$request->input('reg_no');
    $data=candidate::where('reg_no',$reg_no)->first();
    $drive=exammasters::where('drive_status',"running")->first();
    $feedback=feedbacks::all();

  //  return view('exam_platform',compact('data','subs','drive','inst','languages'));//exam_platform 
return view("submitted_page",compact('data','drive','feedback'));
}

public function submitFeedback(Request $request)
    {
        // Retrieve the registration number from the request
    $reg_no = $request->input('reg_no');

    // Retrieve the candidate based on the registration number
    $candidate = candidate::where('reg_no', $reg_no)->first();

    if (!$candidate) {
        return "candidate not found!";
    }

    // Get all input data from the request and exclude the token
    $data = $request->except('_token'); // This will remove the _token field

    // Define the values to be replaced and their corresponding numeric values
    $replacePairs = [
        'Very Good' => 5,
        'Good' => 4,
        'Ok' => 3,
        'Bad' => 2,
        'Very Bad' => 1,
    ];

    // Convert the data to a string (for example, using json_encode to stringify the whole array)
    $dataString = json_encode($data);

    // Replace string values with corresponding numeric values
    $dataString = str_replace(array_keys($replacePairs), array_values($replacePairs), $dataString);

    // Store the updated data string in the candidate_feedback column
    $candidate->candidate_feedback = $dataString;
    $candidate->save();

    // Return a success message
    return "Thank you for your Feedback. Your examination has been submitted.";

        
    }



}
