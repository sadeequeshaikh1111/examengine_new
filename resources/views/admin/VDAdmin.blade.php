<!DOCTYPE html>
<html lang="en">
<meta name="csrf-token" content="{{ csrf_token() }}" />

<body>
@extends('admin.admin_master')
    @section('title','Dasahboard')
    @section('contnet') 
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">

<h1>Verification Desk</h1>
 
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
                alert(data)
               
            }
           }
        });
        $('#Candidate_table').DataTable().ajax.reload();
        

}
</script>

@endsection
    </body>
</html>
