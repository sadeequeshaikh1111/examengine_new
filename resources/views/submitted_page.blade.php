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
      <div>
    <span>  <img  src="drive\{{$drive['exam_ID']}}\candidate_photo\{{$data['reg_no']}}.png" id="img" class="centeredimg" >
    </span></div>
  <br><br>
  &nbsp Registration Number: <span id="reg_no">{{$data['reg_no']}}</span>
  <br>
  &nbsp Name:{{$data['name']}}
               <br>
               &nbsp System <Number:>{{$data['node']}}</Number:>
               <br>
</div>
<div class="split right">
<div>
    <br><br><br>
    Congratulations you have completed your examination you have scored {{$data['marks']}} marks
    <br>
    Please fill following feedback so that we can improve your exam experience 
</div>

<div id="feedback_div">
@foreach($feedback as $feed)
<div>
{{$feed['parameter']}}
<div><input type="radio" name={{$feed['id']}} id="">{{$feed['option1']}}</input></div>
<div><input type="radio" name={{$feed['id']}} id="">{{$feed['option2']}}</input></div>
<div><input type="radio" name={{$feed['id']}} id="">{{$feed['option3']}}</input></div>
<div><input type="radio" name={{$feed['id']}} id="">{{$feed['option4']}}</input></div>
<div><input type="radio" name={{$feed['id']}} id="">{{$feed['option5']}}</input></div>

</div>

@endforeach
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