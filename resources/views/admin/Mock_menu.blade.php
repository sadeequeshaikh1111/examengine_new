<!DOCTYPE html>
<html lang="en">
<meta name="csrf-token" content="{{ csrf_token() }}" />

<body>
@extends('admin.admin_master')
    @section('title','Dasahboard')
    @section('contnet') 
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">

<h1>Mock Menu</h1>

<div class="card" style="width: 60rem;">
<input type="text" id="n" name="shift" placeholder="Number Candidates" require></text><br>
<button onclick="create_candidates()">create mock data</button>
<button onclick="create_mock_qp()">create mock questions</button>
<button onclick="shuffle()">shuffle</button>


</div>
  <table id="Candidate_table" class="table table-bordered yajra-datatable" style="width:100%">
        <thead>
            <tr>
                <th>Reg_no</th>
                <th>Name</th>
                <th>dob</th>
                <th>status</th>
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
$(document).ready(function(){
$('#Candidate_table').DataTable({
 processing: true,
 serverSide: true,
 ajax: {
  url: "{{ route('candidates.get') }}",
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
   data: 'action',
   name: 'action',
   orderable: false
  }
  
 ]
});
});

function Register(reg_no)
{
       
   
        $.ajax({
           type:'POST',
           url:"{{ route('set_logs.post') }}",
           data:{reg_no:reg_no},
           success:function(data){
             if(reg_no==data.reg_no)
              {alert("registration number "+data.reg_no+" Registered");
                $('#Candidate_table').DataTable().ajax.reload();

}
            else{
                alert("already registered")
               
            }
           }
        });
        $('#Candidate_table').DataTable().ajax.reload();
        

}
function create_candidates()
{
    var inputVal = document.getElementById("n").value;
    $.ajax({
           type:'POST',
           url:"{{ route('create_mock_candidates.post') }}",
           data:{number:10},
           success:function(data){
              alert("registration number "+data.reg_no+" Registered");
                $('#Candidate_table').DataTable().ajax.reload();
           }
        });
        $('#Candidate_table').DataTable().ajax.reload();
        
    alert("candidates created"+' '+inputVal)
}

function create_mock_qp()
{
    var inputVal = document.getElementById("n").value;
    $.ajax({
           type:'POST',
           url:"{{ route('create_mock_qp.post') }}",
           data:{number:10},
           success:function(data){
              alert("registration number "+data.reg_no+" Registered");
                $('#Candidate_table').DataTable().ajax.reload();
           }
        });
        $('#Candidate_table').DataTable().ajax.reload();
        
    alert("candidates created"+' '+inputVal)
}
function shuffle()
{
    var inputVal = document.getElementById("n").value;
    $.ajax({
           type:'POST',
           url:"{{ route('create_qp_sets.post') }}",
           data:{number:10},
           success:function(data){
              alert("question paper shuflled");
                $('#Candidate_table').DataTable().ajax.reload();
           }
        });
        $('#Candidate_table').DataTable().ajax.reload();
        
}
</script>

@endsection
    </body>
</html>
