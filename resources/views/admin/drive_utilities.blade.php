<!DOCTYPE html>
<html lang="english">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google" content="notranslate">
    <meta http-equiv="Content-Language" content="en">
    <title>Drive Utilities</title>
</head>
<body>
@extends('admin.admin_master')
    @section('title','Drive Utilities')
    @section('contnet')

    <div class="admin-dashboard">
        <!-- Manual Drive Upload -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Manual Drive Upload</h3>
            </div>
            <div class="card-body">
                <form action="upload" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="drive_file">Drive File</label>
                        <input type="file" id="drive_file" name="file" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="drive_shift">Drive Shift</label>
                        <input type="text" id="drive_shift" name="shift" class="form-control" placeholder="Drive Shift" required>
                    </div>
                    <div class="form-group">
                        <label for="drive_password">Drive Password</label>
                        <input type="text" id="drive_password" name="password" class="form-control" placeholder="Drive Password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Upload Drive</button>
                </form>
            </div>
        </div>

        <!-- Encrypt / Decrypt Tools -->
        <div class="card mt-3">
            <div class="card-header">
                <h3 class="card-title">Encrypt / Decrypt Tools</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="util_password">Drive Password</label>
                    <input type="text" id="util_password" class="form-control" placeholder="Drive Password">
                </div>
                <div class="form-group">
                    <label for="util_shift">Drive Shift</label>
                    <input type="text" id="util_shift" class="form-control" placeholder="Drive Shift">
                </div>
                <div class="admin-actions">
                    <button id="encr_btn" class="btn btn-primary" onclick="encrypt()">Encrypt</button>
                    <button id="decr_btn" class="btn btn-secondary" onclick="decrypt()">Decrypt</button>
                </div>
            </div>
        </div>
    </div>

    @endsection
</body>
<script src="{{ asset('assets\js\jquery.min.js')}}"></script>

<script type="text/javascript">
$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

function encrypt()
{
    var inputVal = document.getElementById("util_password").value;
    document.getElementById("encr_btn").addEventListener("click", function(event){
        event.preventDefault()
    });

    $.ajax({
        type: "GET",
        url: "encrypt/"+inputVal,
        success: function (data) {
            alert(data)
        }
    })
}

function decrypt()
{
    var pass = document.getElementById("util_password").value;
    var shift = document.getElementById("util_shift").value;

    $.ajax({
        type: "GET",
        url: "decrypt/"+pass+"/"+shift,
        success: function (data) {
            alert(data)
        }
    })
}
</script>
</html>