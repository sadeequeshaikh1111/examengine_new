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
<form action="{{ route('submitFeedback') }}" method="POST">
    @csrf
    <!-- Add Hidden Input for Registration Number -->
    <input type="hidden" name="reg_no" id="hidden_reg_no" value="{{ $data['reg_no'] }}">
   {{$i=0}} 
    @foreach($feedback as $feed)
{{$i=$i+1}}
    <fieldset style="margin-bottom: 20px; border: 1px solid #ccc; padding: 10px;">
        <legend>{{ $feed['parameter'] }}</legend>
        <div>
            <input type="radio" name="P{{$i}}" id="option1_{{ $feed['id'] }}" value="{{ $feed['option1'] }}">
            <label for="option1_{{ $feed['Id'] }}">{{ $feed['option1'] }}</label>
        </div>
        <div>
            <input type="radio" name="P{{$i}}" id="option2_{{ $feed['id'] }}" value="{{ $feed['option2'] }}">
            <label for="option2_{{ $feed['Id'] }}">{{ $feed['option2'] }}</label>
        </div>
        <div>
            <input type="radio" name="P{{$i}}" id="option3_{{ $feed['id'] }}" value="{{ $feed['option3'] }}">
            <label for="option3_{{ $feed['Id'] }}">{{ $feed['option3'] }}</label>
        </div>
        <div>
            <input type="radio" name="P{{$i}}" id="option4_{{ $feed['id'] }}" value="{{ $feed['option4'] }}">
            <label for="option4_{{ $feed['Id'] }}">{{ $feed['option4'] }}</label>
        </div>
        <div>
            <input type="radio" name="P{{$i}}" id="option5_{{ $feed['id'] }}" value="{{ $feed['option5'] }}">
            <label for="option5_{{ $feed['Id'] }}">{{ $feed['option5'] }}</label>
        </div>
    </fieldset>
    @endforeach
    <button type="submit" class="btn btn-primary">Submit Feedback & Exit</button>
</form>






</body>

</html>