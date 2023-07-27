<!DOCTYPE html>
<html lang="english">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google" content="notranslate">

<meta http-equiv="Content-Language" content="en">
    <title>Document</title>
</head>
<body>
@extends('admin.admin_master')
    @section('title','Exam Menu')
    @section('contnet') 
<div>
<div class="card" style="width: 30rem;">
<label for="admin"> {{session('email')}}</label>



  </div>
  <div>
  <div class="row">
  <div class="column" >
    <h2>Column 1</h2>
   <form action="upload" method="post" enctype="multipart/form-data">
{{ csrf_field() }}
<input type="file"  name="file" required><br><br>

<input type="text" id="drive_shift" name="shift" placeholder="Drive Shift" require></text><br>
<input type="text" id="drive_password" name="password" placeholder="Drive Passowrd" require></text><br>
<button type="submit">Submit</button>
</form>
  </div>
  <div class="columntbl" style="background-color:#bbb;">
    <table id="drive_table" class="table table-bordered yajra-datatable" style="width:100% height=100% table-layout:fixed; font-size:18px">
        <thead>
            <tr>
                <th>exam_name</th>
                <th>exam_ID</th>
                <th>Drive_status</th>
                <th>action</th>   
                </tr>
        </thead>
        <tbody></tbody>
        
    </table>  </div>
</div>
  </div>
<!--center code end-->


<form action="upload" method="post" enctype="multipart/form-data">
{{ csrf_field() }}

</div>
<br>
<div id="drive_detail" class="card" style="width: 50rem;">
<div>
 <input type="file"  name="file" required>

<input type="text" id="drive_shift" name="shift" placeholder="Drive Shift" require></text>
<input type="text" id="drive_password" name="password" placeholder="Drive Passowrd" require></text>
<button id="start_drive_btn" onclick='start_drive()'>back_up</button>
<button id="encr_btn" onclick='encrypt()'>encrypt</button>
<button id="decr_btn" onclick='decrypt()'>decrypt Start drive</button>
<br>
<br>
<br>
<button type="submit">Submit</button>
</div>
</form>

    @endsection    
</body>
<script src="{{ asset('assets\js\jquery.min.js')}}"></script>
<script src="{{ asset('assets\js\jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('assets\js\bootstrap.min.js')}}"></script>
<link href="{{ asset('assets\css\bootstrap.css') }}" rel="stylesheet">
<link href="{{ asset('assets\css\drive_menucss.css') }}" rel="stylesheet">


<script type="text/javascript">
$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function() {
      $('#drive_table').DataTable({
        bInfo : false,
filter:false,
paging:false,
 processing: true,
 serverSide: true,
 ajax: {
  url: "{{ route('get_todays_drive.get') }}",
 },
 columns: [
  {
   data: 'exam_name',
   name: 'exam_name'
  },
  {
   data: 'exam_ID',
   name: 'exam_ID'
  },
  
  {
   data: 'Drive_status',
   name: 'Drive_status'
  },
  
    {
   data: 'action',
   name: 'action',
   orderable: false
  }
  
 ]
});

    });

function select_drive(drive_id)
{

  $('#drive_detail').empty();

  $.ajax({  //create an ajax request to display.php
        type: "GET",
        url: "select_drive/"+drive_id,       
        success: function (data) {
        x=data.date;
        $('#drive_detail').append("<table><th>exam_name</th><th>exam_ID</th><th>shift</th><th>time_slot</th><th>Drive_status</th><th>Total Count</th><tr><td>"+data.exam_name+"</td><td id=\'drive_id_cell\'>"+data.exam_ID+"</td><td>"+data.shift+"</td><td>"+data.time_slot+"</td><td>"+data.Drive_status+"</td><td>"+data.Total+"</td></tr></table>");
if(data.Drive_status=="Not Started"||data.Drive_status=="0")
{
  $('#drive_detail').append("<br> <button onclick=\"set_drive()\">Set Question papers</button> ");
}

else if(data.Drive_status=="Question Bank Set")
{
  $('#drive_detail').append("<br> drive is running ");
  $('#drive_detail').append("<br> <button onclick=\"start_drive()\">Start Drive</button> ");
}
else if(data.Drive_status=="running")
{
  $('#drive_detail').append("<br> drive is running ");
  $('#drive_detail').append("<br> <button onclick=\"End_Drive()\">End Drive</button> ");
}
else if(data.Drive_status=="Drive Ended")
{
  $('#drive_detail').append("<br> drive is ended ");
  $('#drive_detail').append("<br> <button onclick=\"create_backup()\">Backup Drive</button> ");


}
else if(data.Drive_status=="Backup Done")
{
  $('#drive_detail').append("<br> drive is ended ");
  $('#drive_detail').append("<br> <button onclick=\"upload_and_finish()\">Upload Drive</button> ");

}


       }
    });

}


//testcmd

function download()
{
  window.open("https://ams.justbeamit.com:8443/download?token=hukrd","_self")


}
function myFunction() 
{
  var inputVal = document.getElementById("drive_otp").value;
  alert(inputVal);
  var link="http://localhost/drive_engine/public/drive/"+inputVal;
  location.replace(link);
  }

  function get_backup()
{  var drive_id=$("#drive_id_cell").text();

$.ajax({  //create an ajax request to display.php

        type: "GET",
        url: "set_backup_bat/"+drive_id,       
        success: function (data) {

            alert(data)
    

        } })
}

function encrypt()
{
  var inputVal = document.getElementById("drive_password").value;
  document.getElementById("encr_btn").addEventListener("click", function(event){
  event.preventDefault()
});

  $.ajax({  //create an ajax request to display.php
        type: "GET",
        url: "encrypt/"+inputVal,       
        success: function (data) {

            alert(data)
    

        } })

}
function decrypt()
{
  var pass = document.getElementById("drive_password").value;
  var shift = document.getElementById("drive_shift").value;

  $.ajax({  //create an ajax request to display.php
        type: "GET",
        url: "decrypt/"+pass+"/"+shift,       
        success: function (data) {

            alert(data)
    

        } })


}

function End_Drive()
{
  var drive_id=$("#drive_id_cell").text();
  console.log(drive_id);
         $.ajax({
           type:'POST',
           url:"{{ route('end_drive.post') }}",
           data:{exam_ID:drive_id,status:"Drive End"},
           success:function(data){
            select_drive(drive_id)
            $('#drive_table').DataTable().ajax.reload();

              alert(data);
           }
        });
       
}
function create_backup()
{
  get_backup();
  var drive_id=$("#drive_id_cell").text();
  console.log(drive_id);
         $.ajax({
           type:'POST',
           url:"{{ route('create_backup.post') }}",
           data:{exam_ID:drive_id,status:"Backup Done"},
           success:function(data){
            select_drive(drive_id)
            $('#drive_table').DataTable().ajax.reload();
              alert(data);
           }
        });
       

}
function upload_and_finish()
{
  var drive_id=$("#drive_id_cell").text();
  console.log(drive_id);
         $.ajax({
           type:'POST',
           url:"{{ route('start_selected_drive.post') }}",
           data:{exam_ID:drive_id,status:"Upload"},
           success:function(data){
            select_drive(drive_id)
            $('#drive_table').DataTable().ajax.reload();
              alert(data);
           }
        });
      

}
var i=1;

 function set_qp(set)
{
  alert("process started")
  console.log(set)
  var drive_id=$("#drive_id_cell").text();
  console.log(drive_id);
         $.ajax({
           type:'POST',
           url:"{{ route('shuffle_qp_sets.post') }}",
           data:{exam_ID:drive_id,status:"set_qp",set:set},
           success:function(data){
           alert(data);
            select_drive(drive_id)

           }
        });

     

}
async function set_drive()
{
await set_qp(1);
}
function start_drive()
{

  var drive_id=$("#drive_id_cell").text();
  alert(drive_id)

  console.log(drive_id);
         $.ajax({
           type:'POST',
           url:"{{ route('start_drive.post') }}",
           data:{exam_ID:drive_id},
           success:function(data){
            $('#drive_table').DataTable().ajax.reload();
            select_drive(drive_id)

           alert(data);

           }
        });

}

</script>
</html>