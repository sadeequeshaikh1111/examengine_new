<!DOCTYPE html>
<html lang="en">
<meta name="csrf-token" content="{{ csrf_token() }}" />

<body>
@extends('admin.admin_master')
    @section('title','Dasahboard')
    @section('contnet')
    {{session('user')}}
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="{{ asset('assets\css\bootstrap.css') }}" rel="stylesheet">
<link href="{{ asset('assets\css\platform.css') }}" rel="stylesheet">
   

<div id="locked_candidates">
    locked candidates
</div>
<br>
 <button  onclick='Unlock_all()'> Unlock All</button>
        <button  onclick='Set_idle(0)'> Set Idle All</button>
        <button  onclick='Set_idle(1)'> Set Dead All</button>
<h1>Candidate Menu</h1>
 
  <table id="Candidate_table" class="table table-bordered yajra-datatable" style="width:100%">
        <thead>
            <tr>
                <th>Reg_no</th>
                <th>Name</th>
                <th>dob</th>
                <th>status</th>
                <th>Time</th>
                <th>action</th>   
                </tr>
        </thead>
        <tbody></tbody>
        
    </table>


<script src="{{ asset('assets\js\jquery.min.js')}}"></script>
<script src="{{ asset('assets\js\jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('assets\js\bootstrap.min.js')}}"></script>
<link href="{{ asset('assets\css\bootstrap.css') }}" rel="stylesheet">


<script type="text/javascript">
 $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

var refreshIntervalId=setInterval(timerupdate,15000)
var refreshIntervalId=setInterval(itimerupdate,50000)
function itimerupdate()
{


}
function timerupdate()
{Set_idle(1)
}


$(document).ready(function(){
$('#Candidate_table').DataTable({
 processing: true,
 serverSide: true,
 ajax: {
  url: "{{ route('get_Candidates_unlock.get') }}",
 },
 columns: [
  {
   data: 'reg_no',
   name: 'reg_no'
  },
  {
   data: 'name',
   name: 'name'
  },
  {
   data: 'dob',
   name: 'dob'
  },
  {
   data: 'status',
   name: 'status'
  },
  {
   data: 'time',
   name: 'time'
  },
    {
   data: 'action',
   name: 'action',
   orderable: false
  }
  
 ]
});
});

function Unlock(Reg_no)
{
       
   status="unlocked"
        $.ajax({
           type:'POST',
           url:"{{ route('set_status_unlock.post') }}",
           data:{Reg_no:Reg_no,status:status},
           success:function(data){
              alert("registration number "+Reg_no+" unlocked");
              $('#Candidate_table').DataTable().ajax.reload();

           }
        });
}
function Unlock_all()
{
       
        $.ajax({
           type:'POST',
           url:"{{ route('set_unlock_all.post') }}",
           data:{},
           success:function(data){
              alert("unlocked all");
           }
        });

        $('#Candidate_table').DataTable().ajax.reload();
        $('#Candidate_table').DataTable().ajax.reload();

}
function Add_time(Reg_no)
{
    var min=0;

var min=prompt("Enter how many minutes and seeconds to add");
sec=min*60;
if (isNaN(sec)) 
  {
    alert("Please Enter Valid number")
  }
  else
{ 

    time=sec;
        $.ajax({
           type:'POST',
           url:"{{ route('set_status_unlock.post') }}",
           data:{Reg_no:Reg_no,time:time},
           success:function(data){
            alert(sec+" Seconds time added for reg_no "+Reg_no)
            $('#Candidate_table').DataTable().ajax.reload();

           }
        });




}




}

function Set_idle(str)
{if(str==0)
     {  }
     else{}
        $.ajax({
           type:'POST',
           url:"{{ route('set_idle.Idle') }}",
           data:{flag:str},
           success:function(data){
              console.log("set Dead all");
           }
        });
        get_dead(); 
        $('#Candidate_table').DataTable().ajax.reload();
        $('#Candidate_table').DataTable().ajax.reload();

}

function Set_dead()
{

        $.ajax({
           type:'POST',
           url:"{{ route('set_idle.Idle') }}",
           data:{},
           success:function(data){
              Console.log("set dead all");
           }
        });

        $('#Candidate_table').DataTable().ajax.reload();
        $('#Candidate_table').DataTable().ajax.reload();

}
function get_dead()
  {
    $.ajax({  //create an ajax request to display.php
        type: "GET",
        url: "get_dead/",       
        success: function (data) {
        
console.log(data);
          $('#locked_candidates').html(data);
          $("#locked_candidates").addClass("timercss_at_end");
       }
    });


  }

</script>

@endsection
    </body>
</html>
