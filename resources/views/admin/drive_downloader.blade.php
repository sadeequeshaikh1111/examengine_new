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
THis is drive downloader


  </div>
  <div>
  <div class="row">


   <form action="upload" method="post" enctype="multipart/form-data">
{{ csrf_field() }}

</form>
<!--center code end-->
 <table id="core_drive_table" class="table table-bordered yajra-datatable" style="width:100%">
        <thead>
            <tr>
                <th>exam_id</th>
                <th>drive_status</th>
                <th>total_candidate_count</th>
                <th>exam_date</th>
                <th>time_slot</th>
                 <th>action</th>   
                </tr>
        </thead>
        <tbody></tbody>       
    </table>

    <div>
      this is extended div
    </div>
<div class="row">
<div id="drive_detail">THish is drivedetails div</div>
</div>
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
      $('#core_drive_table').DataTable({
        bInfo : false,
filter:false,
paging:false,
 processing: true,
 serverSide: true,
 ajax: {
  url: "{{ route('get_drive_from_core.get') }}",
 },
 columns: [
  {
   data: 'exam_id',
   name: 'exam_name'
  },
  {
   data: 'exam_status',
   name: 'drive_status'
  },
  
  {
   data: 'total_candidate_count',
   name: 'total_candidate_count'
  },
  {

   data: 'exam_date',
   name: 'exam_date'

  },
   {

   data: 'time_slot',
   name: 'time_slot'

  },
    {
   data: 'action',
   name: 'action',
   orderable: false
  }
  
 ]
});

    });

function select_drive(drive_id) {
  alert(drive_id)
    // Get DataTable instance
    var table = $('#core_drive_table').DataTable();


    // Find the row with this drive_id
    var rowData = table.rows().data().toArray().find(row => row.exam_id == drive_id);
    console.log(rowData)

    if (!rowData) {
        alert("Drive not found in table!");
        return;
    }

    // Empty previous details
    $('#drive_detail').empty();

    // Create drive detail div
    var detailHtml = `
        <div class="card p-3 mb-3">
            <h5>Drive Details</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Exam ID</th>
                        <th>Total Candidates</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td id="drive_id_cell">${rowData.exam_id}</td>
                        <td>${rowData.total_candidate_count}</td>
                    </tr>
                </tbody>
            </table>

            <button class="btn btn-success" onclick="download_drive_dump('${drive_id}')">Download Drive</button>
        </div>
    `;

    $('#drive_detail').append(detailHtml);
}

// Function to handle download
function download_drive_dump(drive_id) {


    $.ajax({
        type: 'POST',
        url: "{{ route('download_drive_dump_step1.post') }}",
        data: {
            driveid: drive_id,
            component: "candidates_" + drive_id + ".sql",
            _token: "{{ csrf_token() }}"
        },
        success: function (data) {
            if (data.success) {
                alert("✅ File saved at 111: " + data.path);
                download_drive_dump_step2(drive_id);


            } else {
                alert("❌ " + data.message);
            }
        },
        error: function (xhr) {
            alert("⚠️ Server error: " + xhr.responseText);
        }
    });
}

function download_drive_dump_step2(drive_id)
{
  alert("downloading candidate dump for sss "+drive_id)
  var detailHtml = `<div>downloading dump for</div>`
  $('#drive_detail').append(detailHtml);
}


function download_drive_dump_data(candidate_id,component_category){
//loop this for photo and sign 1 resource at 1 time show staus bar
  alert("downloading candidate_id photo/image for "+candidate_id+component_category);
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
           data:{exam_id:drive_id,status:"Drive End"},
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
           data:{exam_id:drive_id,status:"Backup Done"},
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
           data:{exam_id:drive_id,status:"Upload"},
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
           data:{exam_id:drive_id,status:"set_qp",set:set},
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
           data:{exam_id:drive_id},
           success:function(data){
            $('#drive_table').DataTable().ajax.reload();
            select_drive(drive_id)

           alert(data);

           }
        });

}


</script>
</html>