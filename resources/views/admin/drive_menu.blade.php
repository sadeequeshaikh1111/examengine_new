<!DOCTYPE html>
<html lang="english">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google" content="notranslate">
    <meta http-equiv="Content-Language" content="en">
    <title>Drive Management</title>
</head>
<body>
@extends('admin.admin_master')
    @section('title','Drive Management')
    @section('contnet')

    <div class="admin-dashboard">
        <!-- Drive table -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Downloaded Drives</h3>
            </div>
            <div class="card-body admin-table-wrap">
                <table id="drive_table" class="table table-bordered yajra-datatable" style="width:100%; table-layout:fixed;">
                    <thead>
                        <tr>
                            <th>Exam Name</th>
                            <th>Exam ID</th>
                            <th>Drive Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>

        <!-- Drive details -->
        <div id="drive_detail" class="card mt-3">
            <div class="card-header">
                <h3 class="card-title">Drive Details</h3>
            </div>
            <div class="card-body">
                <p class="text-muted mb-0">Select a drive from the table above to view its details and manage its lifecycle.</p>
            </div>
        </div>
    </div>

    @endsection
</body>
<script src="{{ asset('assets\js\jquery.min.js')}}"></script>
<script src="{{ asset('assets\js\jquery.dataTables.min.js')}}"></script>

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
            { data: 'exam_name', name: 'exam_name' },
            { data: 'exam_id', name: 'exam_id' },
            { data: 'drive_status', name: 'drive_status' },
            { data: 'action', name: 'action', orderable: false }
        ]
    });
    });

function select_drive(drive_id)
{
    console.log("drive id is :"+drive_id)
    $('#drive_detail').empty();
    $('#drive_detail').append('<div class="card-header"><h3 class="card-title">Drive Details</h3></div><div class="card-body">');

    $.ajax({
        type: "GET",
        url: "select_drive/"+drive_id,
        success: function (data) {
            $('#drive_detail .card-body').append(
                '<table class="table table-bordered">' +
                '<thead><tr><th>Exam Name</th><th>Exam ID</th><th>Shift</th><th>Time Slot</th><th>Drive Status</th><th>Total Count</th></tr></thead>' +
                '<tbody><tr>' +
                '<td>'+data.exam_name+'</td>' +
                '<td id="drive_id_cell">'+data.exam_id+'</td>' +
                '<td>'+data.shift+'</td>' +
                '<td>'+data.time_slot+'</td>' +
                '<td>'+data.drive_status+'</td>' +
                '<td>'+data.total+'</td>' +
                '</tr></tbody></table>'
            );

            if(data.drive_status=="Not Started"||data.drive_status=="0")
            {
                $('#drive_detail .card-body').append('<br><button class="btn btn-primary" onclick="set_drive()">Set Question papers</button>');
            }
            else if(data.drive_status=="Question Bank Set")
            {
                $('#drive_detail .card-body').append('<br><span class="badge badge-info">Drive is ready</span>');
                $('#drive_detail .card-body').append('<br><button class="btn btn-success" onclick="start_drive()">Start Drive</button>');
            }
            else if(data.drive_status=="running")
            {
                $('#drive_detail .card-body').append('<br><span class="badge badge-success">Drive is running</span>');
                $('#drive_detail .card-body').append('<br><button class="btn btn-danger" onclick="End_Drive()">End Drive</button>');
            }
            else if(data.drive_status=="Drive Ended")
            {
                $('#drive_detail .card-body').append('<br><span class="badge badge-warning">Drive is ended</span>');
                $('#drive_detail .card-body').append('<br><button class="btn btn-primary" onclick="create_backup()">Backup Drive</button>');
            }
            else if(data.drive_status=="Backup Done")
            {
                $('#drive_detail .card-body').append('<br><span class="badge badge-info">Backup done</span>');
                $('#drive_detail .card-body').append('<br><button class="btn btn-success" onclick="upload_and_finish()">Upload Drive</button>');
            }

            $('#drive_detail').append('</div>');
        }
    });
}

function get_backup()
{
    var drive_id=$("#drive_id_cell").text();
    $.ajax({
        type: "GET",
        url: "set_backup_bat/"+drive_id,
        success: function (data) {
            alert(data)
        }
    })
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