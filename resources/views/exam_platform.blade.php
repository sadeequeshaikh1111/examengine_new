`<!DOCTYPE html>
<html>
<head>
<meta name="csrf-token" content="{{ csrf_token() }}" />
<link href="{{ asset('assets\css\bootstrap.css') }}" rel="stylesheet">
<link href="{{ asset('assets\css\platform.css') }}" rel="stylesheet">

<script src="{{ asset('assets\js\jquery-3.5.1.slim.min.js')}}"></script>
<script src="{{ asset('assets\js\create_options.js')}}"></script>
<script src="{{ asset('assets\js\Set_platform.js')}}"> pageload setup</script>
<script src="{{ asset('assets\js\endexam.js')}}"> pageload setup</script>

<script src="{{ asset('assets\js\popper.min.js')}}"></script>
<script src="{{ asset('assets\js\bootstrap.min.js')}}"></script>
<script src="{{ asset('assets\js\jquery.min.js')}}"></script>


</head>
<body id="body">
<div>toolbar


</div>
<div class="split left">
  <div class="infodiv">
      <div class="centeredimg">
  <img  src="drive\{{$drive['exam_ID']}}\candidate_photo\{{$data['reg_no']}}.png" id="img" class="centeredimg" >
  </div>
  
  Registration Number: <span id="reg_no">{{$data['reg_no']}}</span>
  <br>
               Name:{{$data['name']}}
               <br>
               System <Number:>{{$data['node']}}</Number:>
               <br>
               
  <DIV id="timer" class="timercss_normal"></DIV>

<div id="main">
@foreach($subs as $sub)
<div id=div_{{$sub['Subject_name']}}>
{{$sub['Questions']}}
{{$sub['Subject_name']}} Questions
<br>
@for($i=$sub['Qn_range_start'];$i<$sub['Questions']+$sub['Qn_range_start'];$i++)
 <button type="button" id={{$i}} class="button" onclick='GetQuestion(this.id)'>{{$i}}</button>
@endfor
</div>
@endforeach

  </div><!--subject div end -->
  
  </div><!--main div end-->

<div class="split right">
  <div class="top_div">
<a href="">instructions</a>
<a href="">Question Paper</a>
  </div>
  <div class="tab">
  @foreach($subs as $sub)
<button  onclick='get_Subject(this.id)' id={{$sub['Subject_name']}}>{{$sub['Subject_name']}}</button>
@endforeach
   <select name="lang" id="LANG" onchange="langSelect()" class=tools>
   <option  value={{$data['Language']}}>{{$data['Language']}}</option>
   <option  value="English">English</option>
  </select>
  </div>
<div> Question Number: <label id="qn_lbl" for="Qn"></label>
</div>
<div id="Question_container" class="questiondiv">
<div id="qtools">

</div>  
GetQuestion </div>
<div class="gapdiv"></div>
<div id="options_panel" class="option_panel_1">
<div id="optiondiv_1" class="optiondiv"> 
  <input type="radio" id="option1" name="options" value="1">
  <label for="option1">option1</label>
  </div>
<div id="optiondiv_2" class="optiondiv">
<input type="radio" id="option2" name="options" value="2">
  <label for="option2">option2</label>
</div>
<div id="optiondiv_3" class="optiondiv">
<input type="radio" id="option3" name="options" value="3">
  <label for="option3">option3</label>
</div>
<div id="optiondiv_4" class="optiondiv">
<input type="radio" id="option4" name="options" value="4">
  <label for="option4">option4</label>

</div>
<div id="response" class><button onclick="save_next()">Mark For Review &Next</button>
<button id="clear_btn" onclick="clear_resp()">Clear Response</button>
<button id="save_next_btn" onclick="save_next()">Save & Next</button>
</div><br>
<div id="endexam"><button onclick="submit_exam()">End Exam</button></div>
</div>
<div id="cendexam"><button onclick="getConfirmation()">End Exam</button></div>
<div>
      <form action="end_test" method="post">

      @csrf
      <input type="hidden" name="reg_no" id="reg_no" value={{$data['reg_no']}}></iput>
      <button id="start_exam_btn"  type="submit" class="btn btn-primary btn-block">Submit exam</button>

      </form>
    </div> 
</div>

</div>
</div>
    
</body>
<script type="text/javascript">
 $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
   
    $(document).ready(function() {
      timer_setup()
      var reg_no=JSON.parse("{{json_encode($data['reg_no'])}}");
      console.log("status test")
      getstatus(reg_no)
    }
      
      );   
function GetQuestion(str)
{
  deadtime=get_deadtime();

  if(deadtime>1)
{alert("please contact Invigilator deatime ="+deadtime)}
  var lang =$('#LANG').val();
  var reg_no=JSON.parse("{{json_encode($data['reg_no'])}}");
  $.ajax({  //create an ajax request to display.php
        type: "GET",
        url: "getQuestionbs/"+str+"/"+lang+"/"+reg_no,       
        success: function (data) {
        console.log("option is: "+data.option1);
        console.log(data.option2);



if(data.Qtype==1)//text question 4 radio options
{
  $('#qn_lbl').html(data.SQn);
          $('#Question_container').html(data.Question);
          clear_option_divs();
          generate_options(data.option1,data.option2,data.option3,data.option4);

    
} 
else if(data.Qtype==2)//text question 2 radio options  
        { 
          clear_option_divs();
          $('#qn_lbl').html(data.SQn);
          $('#Question_container').html(data.Question);
        //  generate_checkboxes(data.option1,data.option2,data.option3,data.option4);
        Generate_TrueFalse_options(data.option1,data.option2);
}
else if(data.Qtype==3)//image question 4 radio options
{  
var drive = {!! json_encode($drive ) !!}
var src="drive"+"\\"+drive.exam_ID+"\\images\\"+data.Qn+".png";
var url = '{{ URL::asset('drive') }}'+"\\"+drive.exam_ID+"\\images\\"+str+data.Lang+".png";
  clear_option_divs();
  $('#Question_container').html("");

  $('#qn_lbl').html(data.SQn);
  var img = document.createElement("img"); 
  img.src = url; 
  var src = document.getElementById("Question_container"); 
src.appendChild(img); 
          generate_options(data.option1,data.option2,data.option3,data.option4);
}
else if(data.Qtype==4)//image question 2 radio options
{ 
          clear_option_divs();
          $('#qn_lbl').html(data.SQn);

          var drive = {!! json_encode($drive ) !!}
var src="drive"+"\\"+drive.exam_ID+"\\images\\"+data.Qn+".png";
var url = '{{ URL::asset('drive') }}'+"\\"+drive.exam_ID+"\\images\\"+data.Qn+".png";
  clear_option_divs();
  $('#Question_container').html("");

  $('#qn_lbl').html(data.SQn);
  var img = document.createElement("img"); 
  img.src = url; 
  var src = document.getElementById("Question_container"); 
src.appendChild(img); 
        //  generate_checkboxes(data.option1,data.option2,data.option3,data.option4);
        Generate_TrueFalse_options(data.option1,data.option2);
}
else if(data.Qtype==5)//text question 4 checkboxes 
        { 
          clear_option_divs();
          $('#qn_lbl').html(data.SQn);

          $('#Question_container').html(data.Question);
          generate_checkboxes(data.option1,data.option2,data.option3,data.option4);
       // Generate_TrueFalse_options(data.option1,data.option2);
}
else if(data.Qtype==6)//Image question 4 checkboxes 
        { 
          var drive = {!! json_encode($drive ) !!}
var src="drive"+"\\"+drive.exam_ID+"\\images\\"+data.Qn+".png";
var url = '{{ URL::asset('drive') }}'+"\\"+drive.exam_ID+"\\images\\"+data.Qn+data.Lang+".png";
  clear_option_divs();
  $('#Question_container').html("");

  $('#qn_lbl').html(data.SQn);
  var img = document.createElement("img"); 
  img.src = url; 
  var src = document.getElementById("Question_container"); 
src.appendChild(img); 
          generate_checkboxes(data.option1,data.option2,data.option3,data.option4);
       // Generate_TrueFalse_options(data.option1,data.option2);
}
console.log("SQN "+data.SQn);
get_Subject(data.sub);
console.log(data.sub);
get_selected(str,reg_no);
current_status("current")

}
      });
    
}
$('#LANG').on('change', function() {
  Question_number=$('#qn_lbl').text();
 GetQuestion(Question_number);

});
function load_subject_qpanel()
{
}
function save_next()
{var x=0;
  var optype=$("#option1").attr('type');
if(optype=="radio")
  {saverad("saved");}
  else{
    
    checkval1 = $("input[id='option1']:checked").val();
    checkval2 = $("input[id='option2']:checked").val();
    checkval3 = $("input[id='option3']:checked").val();
    checkval4 = $("input[id='option4']:checked").val();

    if(checkval1)
    {}else(checkval1='0')
    if(checkval2)
    {}else(checkval2='0')
    if(checkval3)
    {}else(checkval3='0')
    if(checkval4)
    {}else(checkval4='0')

    savecheck(checkval1+checkval2+checkval3+checkval4)
    }
  var  radioValue=0
 radioValue = $("input[name='options']:checked").val();
  Question_number=$('#qn_lbl').text();
  var x = (typeof radioValue == 'undefined') ? 0 : radioValue;
  change_css(x)
  GetQuestion(parseInt(Question_number)+1);
}
function change_css(flag)
{  $("#"+Question_number).removeClass();
  var greencss="visited_answered_button";
  var redcss="visited_unanswered_button";
if(flag==0)//unanswered
{
  $("#"+Question_number).addClass(redcss);
}
else
{  $("#"+Question_number).addClass(greencss);
}

}
function reload_colors()
{
  
}
function get_Subject(sub)
{
  
  var x = "div_"+sub.split(' ')[0];
   var ids = {};
$("#main>div").each(function(i){
    ids[i] = $(this).prop('id');
    if(ids[i]!=x)
    $("#"+ids[i]).hide();

else{$("#"+ids[i]).show();}
    });

}
const start_minutes=get_time_new();
let time=start_minutes
const countdownl=$('#timer')
var refreshIntervalId=setInterval(timerupdate,1000)
function timerupdate()
{
  if(time%10==0)
  {
    update_time();
  }
  if(time<900)
 {  $("#timer").addClass("timercss_at_end");   
 }
time--;
var sec=time%60;

var hr=Math.floor(time/3600);
var min=Math.floor(time/60);
var minmod=min%60
var strsec=sec.toString();   
var strminmod=minmod.toString();   
if(sec<10)
{
  strsec="0"+sec.toString();   
}
if(minmod<10)
{
  strminmod="0"+minmod.toString();   
}
/*if(min<10)
{
  min="0"+min.toString()

}*/
var tl=("0"+hr%3600).toString().concat(":"+strminmod).concat(":"+strsec)
var t=$('#timer').text();
$('#timer').html(tl);
if(time<0)
{
end_exam();  }

}

function timer_setup()
{

$('#timer').html(start_minutes);
}
function end_exam()
{  $('#timer').html("00:00:00");

  clearInterval(refreshIntervalId);
  alert("Exam ended");
}
function get_time_new()
{   var reg_no =$('#reg_no').text();

  console.log("test_reg is"+reg_no);
    $.ajax({  //create an ajax request to display.php
        type: "GET",
        url: "get_time/"+reg_no,       
        success: function (data) {
        x=data.time;
        $('#countdown_timer').html(x);
        time=data.time;
console.log("Time is"+data.time);

return time;

       }
    });

}
function update_time()
{
var time = $("#timer").text();
var hms = time;   // your input string
var a = hms.split(':'); // split it at the colons
// minutes are worth 60 seconds. Hours are worth 60 minutes.
var seconds = (+a[0]) * 60 * 60 + (+a[1]) * 60 + (+a[2]); 
var reg_no = $("#reg_no").text();
if (isNaN(seconds)) 
  {
    return false;
  }
   $.ajax({
     type:'POST',
     url:"{{ route('update_time.update') }}",
     data:{reg_no:reg_no,time:seconds,Dead:"0"},
     success:function(data){
     },  error: function(xhr, status, error){
         var errorMessage = xhr.status + ': ' + xhr.statusText;
         console.log(errorMessage);
         if(errorMessage=='500: Internal Server Error')
        {
          alert('Connection lost')
        }
        else {
          alert("Please Contact your Invigilator"+errorMessage);
         clearInterval(refreshIntervalId);

        }

     }
    

  });

}
function saverad(status)
{  var time = $("#timer").text();
var hms = time;   // your input string
var a = hms.split(':'); // split it at the colons
// minutes are worth 60 seconds. Hours are worth 60 minutes.
var seconds = (+a[0]) * 60 * 60 + (+a[1]) * 60 + (+a[2]); 
var reg_no = $("#reg_no").text();
var x=$('input[name="options"]:checked').val();
if(x==undefined)
{x=0;
status="unanswered";
}
Sqn=qn_lbl.textContent;
selected_ans=x;
  $.ajax({
     type:'POST',
     url:"{{ route('Log_answer.save') }}",
     data:{reg_no:reg_no,selected_ans:selected_ans,Sqn:Sqn,status:status},
     success:function(data){console.log(data);
     },  error: function(xhr, status, error){
         var errorMessage = xhr.status + ': ' + xhr.statusText
         alert('Error - ' + errorMessage);
         console.log(errorMessage)
         clearInterval(refreshIntervalId);
     }     
  });  
}
function savecheck(checklist)
{
  var time = $("#timer").text();
var hms = time;   // your input string
var a = hms.split(':'); // split it at the colons
// minutes are worth 60 seconds. Hours are worth 60 minutes.
var seconds = (+a[0]) * 60 * 60 + (+a[1]) * 60 + (+a[2]); 
var reg_no = $("#reg_no").text();
var x=$('input[name="options"]:checked').val();
if(checklist=="0000")
{x=0;
status="unanswered";
}
else{status="saved";}
Sqn=qn_lbl.textContent;
selected_ans=checklist;
  $.ajax({
     type:'POST',
     url:"{{ route('Log_answer.save') }}",
     data:{reg_no:reg_no,selected_ans:selected_ans,Sqn:Sqn,status:status},
     success:function(data){console.log(data);
     },  error: function(xhr, status, error){
         var errorMessage = xhr.status + ': ' + xhr.statusText
         alert('Error - ' + errorMessage);
         console.log(errorMessage)
         clearInterval(refreshIntervalId);
     }     
  });  
}

function current_status(str)
{
 var Sqn=qn_lbl.textContent;
  var reg_no = $("#reg_no").text();
  $.ajax({
     type:'POST',
     url:"{{ route('Log_current_qn.save') }}",
     data:{reg_no:reg_no,current_qn:Sqn},
     success:function(data){
     },  error: function(xhr, status, error){
         var errorMessage = xhr.status + ': ' + xhr.statusText
         alert('Error - ' + errorMessage);
         console.log(errorMessage)
         clearInterval(refreshIntervalId);
     }     
  });  

}
function langSelect()
{  Question_number=$('#qn_lbl').text();

  var lang =$('#LANG').val();
  GetQuestion(Question_number)
}
  function submit_exam()
  {

    var Sqn=qn_lbl.textContent;
  var reg_no = $("#reg_no").text();
  $.ajax({
     type:'POST',
     url:"{{ route('end_exam.save') }}",
     data:{reg_no:reg_no},
     success:function(data){
       alert(data);
       document.write ("<br>"+data);

     },  error: function(xhr, status, error){
         var errorMessage = xhr.status + ': ' + xhr.statusText
         alert('Error - ' + errorMessage);
         console.log(errorMessage)
         clearInterval(refreshIntervalId);

     }     
  });  
  }

  function get_deadtime()
  {
  var reg_no =$('#reg_no').text();
  console.log("test_reg is"+reg_no);
    $.ajax({  //create an ajax request to display.php
        type: "GET",
        url: "get_time/"+reg_no,       
        success: function (data) {
        deadtime=data.Dead;
console.log("Time is"+data.Deads);
return deadtime;

       }
    });


  }
  function getConfirmation() {
               var retVal = confirm("Do you want to Submit ?");
               if( retVal == true ) {
                submit_exam();

                  document.write ("User has Submitted the exam\n");

                  return true;
               } else {
                 
               }}

 
</script>
</html> 
