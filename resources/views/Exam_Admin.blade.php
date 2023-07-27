<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('assets\css\bootstrap.css') }}" rel="stylesheet">
    <script src="{{ asset('assets\js\jquery-3.5.1.slim.min.js')}}"></script>
    <script src="{{ asset('assets\js\bootstrap.min.js')}}"></script>
    <script src="{{ asset('assets\js\jquery.min.js')}}"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <title>Document</title>
</head>
<body>
<div class="panel panel-primary">
      <div class="panel-heading">Panel with panel-primary class</div>
      <div class="panel-body">Panel Content</div>
      <button class="btn btn-primary" id=btn_create>create</button>
      click button to create answersheet <br><br>
     <button class="btn btn-primary" id=btn>delete</button>

    </div>
</body>
<script type="text/javascript">
 $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#btn_create").click(function(e){
    e.preventDefault();
    name="sadik"
  $.ajax({
     type:'POST',
     url:"{{ route('ajaxRequest.set') }}",
     data:{name},
     success:function(res){
        alert(res.SQN+" data updated");
     }
  });


});  
</script>
</html>
