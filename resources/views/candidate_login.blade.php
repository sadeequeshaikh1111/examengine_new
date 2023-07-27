<!DOCTYPE html>
<!-- Created By CodingNepal -->
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <!-- Somehow I got an error, so I comment the title, just uncomment to show -->
    <!-- <title>Animated Login Form</title> -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link href="{{ asset('assets\css\bootstrap.css') }}" rel="stylesheet">
<script src="{{ asset('assets\js\jquery-3.5.1.slim.min.js')}}"></script>
<link href="{{ asset('assets\css\candidate_logincss.css') }}" rel="stylesheet">

<script src="{{ asset('assets\js\popper.min.js')}}"></script>
<script src="{{ asset('assets\js\bootstrap.min.js')}}"></script>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <div class="container">
      <header>Login Form</header>
      <form action="" method="post">
        <div class="input-field">
          <input type="text" required>
          <label>Email or Username</label>
        </div>
<div class="input-field">
          <input class="pswrd" type="password" required>
          <span class="show">SHOW</span>
          <label>Password</label>
        </div>
<div class="button">
          <div class="inner">
</div>
<button>LOGIN</button>
        </div>
</form>

<script>
$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
      var input = document.querySelector('.pswrd');
      var show = document.querySelector('.show');
      show.addEventListener('click', active);
      function active(){
        if(input.type === "password"){
          input.type = "text";
          show.style.color = "#1DA1F2";
          show.textContent = "HIDE";
        }else{
          input.type = "password";
          show.textContent = "SHOW";
          show.style.color = "#111";
        }
      }
    </script>


  </body>
</html>
