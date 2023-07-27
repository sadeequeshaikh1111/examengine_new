<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\exammaster;
use Carbon\Carbon;
use Yajra\Datatables\DataTables;
use Mail;
use App\Models\subject;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Models\set_a_question_paper;
use App\Models\set_b_question_paper;
use App\Models\set_c_question_paper;
use App\Models\set_d_question_paper;
use App\Models\exam_question;
use App\Models\candidate;
use Illuminate\Support\Facades\DB;
use App\Models\exam_set_a_log;
use App\Models\exam_set_b_log;
use App\Models\exam_set_c_log;
use App\Models\exam_set_d_log;

use Exception;

class file_controller extends Controller
{
    function set_drive()
{

   // "C:\Program Files\7-Zip\7z.exe" e *.zip


  

}
function set_backup($exam_id)
{

   // $ct=date('Y-m-d H:i:s'); // 2016-10-12 21:09:23
   // $ct = str_replace(' ', '_', $ct);
   // $ct = str_replace(':', '_', $ct);

   // $dump_file_name=$ct."_backup.sql";
  // $dump_file_name=$ct."_backup.sql";
  $dump_file_name=$exam_id."_exam_backup.sql";
   $content="cd c:/xampp/htdocs/examengine/public/drive/$exam_id/Backup/& ^mysqldump -u root  exam_engine --no-create-info candidates exam_set_a_logs exam_set_b_logs	exam_set_c_logs	exam_set_d_logs		> ".$dump_file_name;
   $file_name="drive.bat";
       Storage::disk('local')->put($file_name, $content);
      $file=Storage::get($file_name);
     // \system($file);
     \shell_exec($file);

     Storage::disk('local')->put($file_name, "");
     $candidate_file_name=$exam_id."_candidate_backup.sql";
     $candidate_content="cd c:/xampp/htdocs/examengine/public/drive/$exam_id/Backup/& ^mysqldump -u root  exam_engine --no-create-info candidates > ".$candidate_file_name;
     $candidate_file_name_bat="drive_result_backup.bat";
     Storage::disk('local')->put($candidate_file_name_bat, $candidate_content);
     $file2=Storage::get($candidate_file_name_bat);

     \shell_exec($file2);

     return($dump_file_name);

}
function start_backup(Request $req)
{

}
function final_backup(Request $req)
{

}
function encrypt($pass)
{
    
    $last=$rest = substr($pass, -1);
    $lasr=$last+1;
$input=$pass*$last;
$bs36=  base_convert($input,10,36);

return($bs36);

}
function decrypt($pass,$shift)
{
$bs10=  base_convert($pass,36,10);
$result=$bs10/$shift;
return($result);
}
public function store_drive(Request $request)
{       
       

        $upass=$request->password;
        $shift=$request->shift;
        $file = $request->file;
        $filename = $file->getClientOriginalName();
        $pass = substr($filename, strpos($filename, "_") + 1);    
        $arr = explode(".", $pass, 2);
        $first = $arr[0];
          $bs10=  base_convert($upass,36,10);
        $result=$bs10/$shift;
          if($result==$first)
        {//echo("<br>"."Entry allowed");
            //copy drive file in public code started
            $file = $request->file;
            $filename = $file->getClientOriginalName();
            $request->file->move(public_path('drive'), $filename);
            $fn = substr($filename, 0, strpos($filename, '.'));
            //copy drive file in public code ended
//batch ro move and extract file started
$content="cd c:/xampp/htdocs/examengine/public/drive& ^7z x ".$filename." -p1234";
$file_name="drive_extract.bat";
   Storage::disk('local')->put($file_name, $content);
  $file=Storage::get($file_name);
 // \system($file);
 \shell_exec($file);
// Storage::disk('local')->put($file_name, "");
//batch file move and extract ended
//delete bat code 
$content_delete="del \"C:\Users\sadik\Downloads"."\\".$filename."\""." /s /f /q";
$file_name_delete="drive_delete.bat";
  Storage::disk('local')->put($file_name_delete, $content_delete);
 $file_delete=Storage::get($file_name_delete);
 // \system($file);
 \shell_exec($file_delete);
//delete bat code ended

//save drive record code started
try{
   
$arr = explode(".", $filename, 2);
$folder = $arr[0];
//$bat_import_code="cd c:/xampp/htdocs/examengine/public/drive/$folder& ^mysql -u root -f exam_engine <".$folder."_info.sql& ^mysql -u root -f exam_engine <".$folder."_candidates.sql";
$bat_import_code="cd c:/xampp/htdocs/examengine/public/drive/$folder& ^mysql -u root -f exam_engine <".$folder."_info.sql";
$import_bat_file_name="drive_import.bat";
   Storage::disk('local')->put($import_bat_file_name, $bat_import_code);
  $ifile=Storage::get($import_bat_file_name);
 // \system($file);
 \shell_exec($ifile);
}
catch (\Illuminate\Database\QueryException $e) {
    var_dump($e->errorInfo);
}
 
//save drive record code ended

            return view('admin.drive_menu');   
        }
       
        else{              

                $bs36=  base_convert($first*$shift,10,36);
              //  $decrypt=$bs36/$shift;
            echo("<br>"."wrong passoword ".$first." real password  ".$bs36."   bs 36 ".$bs36);}
       

    }
    function get_todays_drive()
    {
        $data = exammaster::where('Drive_status', 'not like', "complete")->get();

        return DataTables::of($data)
                ->addColumn('action', function($data){
                  
                    $button = '<button type="button" name="time" id='.$data->exam_ID.' class="edit btn btn-primary btn-sm"  onclick=select_drive(this.id)>Select </button> ';

                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);

    }
    function get_selected_drive($drive_id)
    {
        $data = exammaster::where('exam_ID', $drive_id)->first();

        return response()->json($data, 200); 

    }
    
    function select_drive($drive_id)
    {
        $data = exammaster::where('exam_ID', $drive_id)->first();
        return response()->json($data, 200); 


    }
function start_selected_drive(Request $r)
{
   if($r->status=="Not Started")
    {
    $count = exammaster::where('Drive_status','=','running')->orwhere('Drive_status','=','Drive Ended')->count();
if($count!=0)
{
$rd=exammaster::where('Drive_status','=','running')->orwhere('Drive_status','=','Drive Ended')->first();
    return response()->json($r->exam_ID." is already still Running Please End Running Drive and Complete Back up process first then start next drive");

}
   else{
    $rd=exammaster::where('exam_ID',$r->exam_ID)->first();
    $drive_status="running";
    $data=exammaster::where('exam_ID',$r->exam_ID)->first()->update(["Drive_status"=>"running"]);

    return response()->json($r->exam_ID." drive started", 200);
}
}
else if($r->status=="Drive End"){   
     $rd=exammaster::where('exam_ID',$r->exam_ID)->first();
     $data=exammaster::where('exam_ID',$r->exam_ID)->first()->update(["Drive_status"=>"Drive Ended"]);
     return response()->json($r->exam_ID." drive Ended", 200);

}
else if($r->status=="Backup Done"){

    $data=exammaster::where('exam_ID',$r->exam_ID)->first()->update(["Drive_status"=>"Backup Done"]);
    set_a_question_paper::query()->truncate();
    set_b_question_paper::query()->truncate();
    set_c_question_paper::query()->truncate();
    set_d_question_paper::query()->truncate();
    exam_set_a_log::query()->truncate();
    exam_set_b_log::query()->truncate();
    exam_set_c_log::query()->truncate();
    exam_set_d_log::query()->truncate();
    subject::query()->truncate();

     exam_question::query()->truncate();
     candidate::query()->truncate(); 
     return response()->json($r->exam_ID." Backup Done", 200);

}
else if($r->status=="set_qp"){
   

    DB::unprepared(file_get_contents(\public_path('drive/'.$r->exam_ID.'/'.$r->exam_ID.'_candidates.sql')));

  $data=exammaster::where('exam_ID',$r->exam_ID)->first()->update(["Drive_status"=>"set_qp"]);
    return response()->json($r->exam_ID."Question paper sets created", 200);
}
else
{ini_set('max_execution_time', '300');
//https://www.itsolutionstuff.com/post/how-to-send-email-with-attachment-in-laravelexample.html
// above code to send mail
//below code to send mail
     
        $data["email"] = "sadiktamboli57@gmail.com";
        $data["title"] = "From arrocorp.com";
        $data["body"] = "This is Demo";
        $files = [
       public_path('drive/'.$r->exam_ID.'/backup'.'/'.$r->exam_ID.'_candidate_backup.sql'),
           // public_path('RRB_10100404212_backup.sql'),

        ];
  
        Mail::send('admin.drive_menu', $data, function($message)use($data, $files) {
            $message->to($data["email"], $data["email"])
                    ->subject($data["title"]);
                 //   $message->attach('\public\drive'.$r->exam_ID);

            foreach ($files as $file){
                $message->attach($file);
            }
            
        });
//mail sending code ended
    $data=exammaster::where('exam_ID',$r->exam_ID)->first()->update(["Drive_status"=>"Upload Done"]);
    return response()->json($r->exam_ID." Upload Done", 200);

}

}
function shuffle_qp_sets(Request $r)
{
  /* $a =exammaster::where('exam_ID',$r->exam_ID)->first();
    if($a->Drive_type=="1")
   { 
    try {   if($r->set=="1")
    {
        set_a_question_paper::query()->truncate(); 
        DB::unprepared(file_get_contents(\public_path('drive/'.$r->exam_ID.'/'.$r->exam_ID.'_candidates.sql')));

    DB::unprepared(file_get_contents(\public_path('drive/'.$r->exam_ID.'/qp'.'/'.$r->exam_ID.'_Qp.sql')));
    set_b_question_paper::query()->truncate(); 
        return "set a created";
    }

    if($r->set==4)
{$count = subject::all()->count();
    $lang="English";
    for($i=1;$i<=$count;$i++)
    {
    
    
    $subq=subject::find($i);
    $qusetions=$subq->Questions;
    $Qn_range_start=$subq->Qn_range_start;
    $qns=array();
    for($x=0;$x<$qusetions;$x++)
    {
        $qns[$x]=$Qn_range_start+$x;
    }
    $shuffled =shuffle($qns);
    
    foreach( $qns as $value ) {
        $qp=set_a_question_paper::where('sqn',$value)->get()->first();    
        $res=new set_d_question_paper;
        $res->SQn=$Qn_range_start;
        $res->Qn=$value;
        $res->Question=$qp->Question.' set c';
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
        $Qn_range_start++;
        
    }
    
    
    }
    $shuffled_sqn=set_d_question_paper::all();    
    $languages = set_a_question_paper::select('Lang')->distinct()->get();
    foreach($languages as $lang)
    {foreach($shuffled_sqn as $sqn)
    {
        //return DB::table('users')->where('username', $username)->pluck('groupName');
    if($lang->Lang!="English")
    {   
       $qpb=set_d_question_paper::where('sqn',$sqn->SQn)->get()->first();
        $qpa=set_a_question_paper::where('qn',$qpb->Qn)->where('Lang',$lang->Lang)->get()->first();
    
        $resb=new set_d_question_paper;
        $resb->SQn=$qpb->SQn;
        $resb->Qn=$qpb->Qn;
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
    
    
    
    return 4;}
    if($r->set=="3")
    {$count = subject::all()->count();
        $lang="English";
        for($i=1;$i<=$count;$i++)
        {
        
        
        $subq=subject::find($i);
        $qusetions=$subq->Questions;
        $Qn_range_start=$subq->Qn_range_start;
        $qns=array();
        for($x=0;$x<$qusetions;$x++)
        {
            $qns[$x]=$Qn_range_start+$x;
        }
        $shuffled =shuffle($qns);
        
        foreach( $qns as $value ) {
            $qp=set_a_question_paper::where('sqn',$value)->get()->first();    
            $res=new set_c_question_paper;
            $res->SQn=$Qn_range_start;
            $res->Qn=$value;
            $res->Question=$qp->Question.' set c';
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
            $Qn_range_start++;
            
        }
        
        
        }
        $shuffled_sqn=set_c_question_paper::all();    
        $languages = set_a_question_paper::select('Lang')->distinct()->get();
        foreach($languages as $lang)
        {foreach($shuffled_sqn as $sqn)
        {
            //return DB::table('users')->where('username', $username)->pluck('groupName');
        if($lang->Lang!="English")
        {   
           $qpb=set_c_question_paper::where('sqn',$sqn->SQn)->get()->first();
            $qpa=set_a_question_paper::where('qn',$qpb->Qn)->where('Lang',$lang->Lang)->get()->first();
        
            $resb=new set_c_question_paper;
            $resb->SQn=$qpb->SQn;
            $resb->Qn=$qpb->Qn;
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
        
        
        
        return "set c created";}
    
  if($r->set=="2")
    {
        $count = subject::all()->count();
        $lang="English";
        for($i=1;$i<=$count;$i++)
        {
        
        
        $subq=subject::find($i);
        $qusetions=$subq->Questions;
        $Qn_range_start=$subq->Qn_range_start;
        $qns=array();
        for($x=0;$x<$qusetions;$x++)
        {
            $qns[$x]=$Qn_range_start+$x;
        }
        $shuffled =shuffle($qns);
        
        foreach( $qns as $value ) {
            $qp=set_a_question_paper::where('sqn',$value)->get()->first();    
            $res=new set_b_question_paper;
            $res->SQn=$Qn_range_start;
            $res->Qn=$value;
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
            $Qn_range_start++;
            
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
   $qpb=set_b_question_paper::where('sqn',$sqn->SQn)->get()->first();
    $qpa=set_a_question_paper::where('qn',$qpb->Qn)->where('Lang',$lang->Lang)->get()->first();

    $resb=new set_b_question_paper;
    $resb->SQn=$qpb->SQn;
    $resb->Qn=$qpb->Qn;
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
return "set b created";

    }//set b if end
}
catch(NotFoundHttpException $ex)
  {

  }}
  else{
   
    

}*/

$count = exammaster::where('Drive_status','=','running')->orwhere('Drive_status','=','Drive Ended')->orwhere('Drive_status','=','set_qp')->count();
if($count!=0)
{
$rd=exammaster::where('Drive_status','=','running')->orwhere('Drive_status','=','Drive Ended')->orwhere('Drive_status','=','set_qp')->first();
    return response()->json($r->exam_ID." is already started Please End Running Drive and Complete Back up process first then start next drive");

}
DB::unprepared(file_get_contents(\public_path('drive/'.$r->exam_ID.'/'.$r->exam_ID.'_candidates.sql')));
DB::unprepared(file_get_contents(\public_path('drive/'.$r->exam_ID.'/qp'.'/'.$r->exam_ID.'_Qp.sql')));
$data=exammaster::where('exam_ID',$r->exam_ID)->first()->update(["Drive_status"=>"Question Bank Set"]);
return response()->json($r->exam_ID."Question paper sets created", 200);
}
function start_drive(Request $r)
{
    $rd=exammaster::where('exam_ID',$r->exam_ID)->first();
    $drive_status="running";
    $data=exammaster::where('exam_ID',$r->exam_ID)->first()->update(["Drive_status"=>"running"]);
    return response()->json($r->exam_ID." drive started", 200);

}
function end_drive(Request $r)
{   $list="Incomplete";
    $count = candidate::where('status','=','Loged In')->orwhere('status','=','locked')->count();
if($count!=0)
{
       $uncomplete=candidate::where('status','=','Loged In')->orwhere('status','=','locked')->get();
foreach($uncomplete as $u)
{
    $list=$list." ".$u->reg_no;
}
    return response()->json($r->exam_ID." drive cant be Ended all candidates havent completed or some candidates  are locked".$list, 200);

}

    $rd=exammaster::where('exam_ID',$r->exam_ID)->first();
     $data=exammaster::where('exam_ID',$r->exam_ID)->first()->update(["Drive_status"=>"Drive Ended"]);
     return response()->json($r->exam_ID." drive Ended", 200);

}
function backup_selected_drive(Request $r)
{
    $data=exammaster::where('exam_ID',$r->exam_ID)->first()->update(["Drive_status"=>"Backup Done"]);
    set_a_question_paper::query()->truncate();
    set_b_question_paper::query()->truncate();
    set_c_question_paper::query()->truncate();
    set_d_question_paper::query()->truncate();
    exam_set_a_log::query()->truncate();
    exam_set_b_log::query()->truncate();
    exam_set_c_log::query()->truncate();
    exam_set_d_log::query()->truncate();
     candidate::query()->truncate(); 
     subject::query()->truncate();

     return response()->json($r->exam_ID."Drive Backup Done ", 200);

}
function upload_drive(Request $r)
{
    ini_set('max_execution_time', '300');
    //https://www.itsolutionstuff.com/post/how-to-send-email-with-attachment-in-laravelexample.html
    // above code to send mail
    //below code to send mail
         
            $data["email"] = "sadiktamboli57@gmail.com";
            $data["title"] = "From arrocorp.com";
            $data["body"] = "This is Demo";
            $files = [
           public_path('drive/'.$r->exam_ID.'/backup'.'/'.$r->exam_ID.'_candidate_backup.sql'),
               // public_path('RRB_10100404212_backup.sql'),
    
            ];
      
            Mail::send('admin.drive_menu', $data, function($message)use($data, $files) {
                $message->to($data["email"], $data["email"])
                        ->subject($data["title"]);
                     //   $message->attach('\public\drive'.$r->exam_ID);
    
                foreach ($files as $file){
                    $message->attach($file);
                }
                
            });
    //mail sending code ended
        $data=exammaster::where('exam_ID',$r->exam_ID)->first()->update(["Drive_status"=>"Upload Done"]);
        return response()->json($r->exam_ID." Upload Done", 200);

}

}
