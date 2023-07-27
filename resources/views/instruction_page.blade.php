<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructions and Declarations</title>

    <meta name="csrf-token" content="{{ csrf_token() }}" />
<link href="{{ asset('assets\css\bootstrap.css') }}" rel="stylesheet">
<link href="{{ asset('assets\css\platform.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="{{asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{asset('plugins/jqvmap/jqvmap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{asset('plugins/daterangepicker/daterangepicker.css')}}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.css')}}">
  <script src="{{ asset('assets\js\popper.min.js')}}"></script>
<script src="{{ asset('assets\js\jquery.min.js')}}"></script>
<script src="{{ asset('assets\js\bootstrap.min.js')}}"></script>
<link href="{{ asset('assets\css\platform.css') }}" rel="stylesheet">

</head>
<body>
<div>
<br>
<div class="split left">
  <div class="infodiv">
      <div class="centeredimg">
      <img  src="drive\{{$drive['exam_ID']}}\candidate_photo\{{$data['reg_no']}}.png" id="img" class="centeredimg" >
  </div>
  <br><br>
  &nbsp Registration Number: <span id="reg_no">{{$data['reg_no']}}</span>
  <br>
  &nbsp Name:{{$data['name']}}
               <br>
               &nbsp System <Number:>{{$data['node']}}</Number:>
               <br>
</div>
<div class="split right">

<div> Select language for instructions &nbsp<select name="lang" id="LANG" onchange="instruction_langSelect(this.value)" class=tools>
@foreach($languages as $lang)
@if($lang['Language_name']=='English')
   <option  value="{{$lang['Language_script']}}">{{$lang['Language_script']}}</option>
 @endif 
   @endforeach
@foreach($languages as $lang)
   <option  value="{{$lang['Language_script']}}">{{$lang['Language_script']}}</option>
   @endforeach
  </select></div>

  <div id="instruction_div">Instructions
  @foreach($inst as $ins)
  @if($ins['Instruction_type']=="Instruction")
  <div>{{$ins['Instruction_matter']}}
  @if($ins['component']=="Brief")
  <button class="btn-primary">Previous</button>
  &nbsp; &nbsp;<button class="btn-primary">Save & Next</button>
  &nbsp; &nbsp;<button class="btn-primary">Mark For Review</button>
  &nbsp; &nbsp;<button class="btn-primary">Clear Response</button>
  @endif
  </div>
  @endif
  @endforeach
  </div>

  <div id="nav_instruction_div">
  Navigation instructions
  @foreach($inst as $ins)
  @if($ins['Instruction_type']=="Navigation")
  <div>
  @if($ins['component']=="1")
  <button type="button"  class="button" onclick='GetQuestion(this.id)'>1</button>
  @endif
  @if($ins['component']=="2")
  <button type="button"  class="visited_answered_button" onclick='GetQuestion(this.id)'>1</button>
  @endif
  @if($ins['component']=="3")
  <button type="button"  class="visited_unanswered_button" onclick='GetQuestion(this.id)'>1</button>
  @endif
  @if($ins['component']=="4")
  <button type="button"  class="visited_answered_button_marked" onclick='GetQuestion(this.id)'>1</button>
  @endif
  @if($ins['component']=="5")
  <button type="button"  class="save_next_btn_inst" onclick='GetQuestion(this.id)'>1</button>
  @endif
 
 
  {{$ins['Instruction_matter']}}</div>

  @endif
  @endforeach
  </div>
  



<span id="lang_div"> 
@foreach($inst as $ins)
@if($ins['Instruction_type']=="Language")
{{$ins['Instruction_matter']}}
  @endif
  @endforeach


 </span> <span> <select name="lang" id="qLANG" onchange="qp_langSelect(this.value)" class=tools>
@foreach($languages as $lang)
@if($lang['Language_name']=='English')
   <option  value="{{$lang['Language_script']}}">{{$lang['Language_script']}}</option>
 @endif 
   @endforeach
@foreach($languages as $lang)
   <option  value="{{$lang['Language_script']}}">{{$lang['Language_script']}}</option>
   @endforeach
  </select></span>
<div id="TAC">
@foreach($inst as $ins)
  @if($ins['Instruction_type']=="T&C")
  <div>{{$ins['Instruction_matter']}}</div>
  
  @endif
  @endforeach
</div>
<span id="terms_div">
@foreach($inst as $ins)
  @if($ins['Instruction_type']=="Terms")
  {{$ins['Instruction_matter']}}
  @endif
  @endforeach
</span>
<span><input id="instructions_cb" name="instructions_cb" type="checkbox" value="1" onchange="Enable_btn()"></input></span>
<div> <form action="start_test" method="post" id="quickForm" value=>
      @csrf
      <input type="hidden" name="reg_no" id="reg_no" value={{$data['reg_no']}}></iput>
      <button id="start_exam_btn" disabled="true" type="submit" class="btn btn-primary btn-block">Start exam</button>

      </div>
</div>



</body>
<script type="text/javascript">
$( document ).ready(function() {
  str=document.getElementById("Lang").value();
  {document.getElementById("start_exam_btn").disabled = true;}

  });
function Enable_btn()
{    checkval1 = $("input[id='instructions_cb']:checked").val();
if(checkval1==1)
{document.getElementById("start_exam_btn").disabled = false;}
else{document.getElementById("start_exam_btn").disabled = true;}
  

}
function get_instructions(str)
{
  type="Instruction";
  lang=str;
  $.ajax({  //create an ajax request to display.php
        type: "GET",
        url: "getinstructions/"+type+"/"+lang,        
        success: function (data) { 
          $('#nav_instruction_div').empty();
          $('#instruction_div').empty();
          $('#terms_div').empty();
          $('#TAC').empty();
          $('#lang_div').empty();

          $.each(data, function(i, data) {
    if (data.Instruction_type=='Navigation') {

        console.log(data.Instruction_matter);
        
        if(data.component==1)
        {
          $('#nav_instruction_div').append('<span>').append('<button class=button>1</button>').append('</span>')  
        }
        if(data.component==2)
        {
          $('#nav_instruction_div').append('<span>').append('<button class=visited_answered_button>1</button>').append('</span>')  
        }
        if(data.component==3)
        {
          $('#nav_instruction_div').append('<span>').append('<button class=visited_unanswered_button>1</button>').append('</span>')  
        }
        if(data.component==4)
        {
          $('#nav_instruction_div').append('<span>').append('<button class=visited_answered_button_marked>1</button>').append('</span>')  
        }
        if(data.component==5)
        {
          $('#nav_instruction_div').append('<span>').append('<button class=btn-primary btn-block>Save & Next</button>').append('</span>')  
        }
        $('#nav_instruction_div').append('<span>').append(data.Instruction_matter).append('</span><br>')
        
    }
    if (data.Instruction_type=='Instruction') {
        console.log(data.Instruction_matter);
        $('#instruction_div').append('<div>').append(data.Instruction_matter).append('</div>')
        if(data.component=="Brief")
        {
          $('#instruction_div').append('<span>').append('&nbsp <button class=btn-primary btn-block>Previous</button>').append('</span>')  
          $('#instruction_div').append('<span>').append('&nbsp <button class=btn-primary btn-block>Save & Next</button>').append('</span>')  
          $('#instruction_div').append('<span>').append('&nbsp <button class=btn-primary btn-block>Mark For Review</button>').append('</span>')  
          $('#instruction_div').append('<span>').append('&nbsp <button class=btn-primary btn-block>Clear Response</button>').append('</span>')  

        }

    }
    if (data.Instruction_type=='Language') {
        console.log(data.Instruction_matter);
        $('#lang_div').append('<div>').append(data.Instruction_matter).append('</div>')
    }
    if (data.Instruction_type=='Terms') {
        console.log(data.Instruction_matter);
        $('#terms_div').append('<div>').append(data.Instruction_matter).append('</div>')
    }
    if (data.Instruction_type=='T&C') {
        console.log(data.Instruction_matter);
        $('#TAC').append('<div>').append(data.Instruction_matter).append('</div>')
    }

});

       }
    });


}

function get_time_new()
{   

 
  
}

function instruction_langSelect(str)
{alert('instruction language changed to '+str);
  get_instructions(str);

}

function qp_langSelect(str)
{alert('qp language changed to '+str);}
</script>
</html>