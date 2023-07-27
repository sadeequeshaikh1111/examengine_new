<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
     <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
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
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="sidebar-mini layout-fixed sidebar-open">
     <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>    
    </nav>
<!-- Left navbar links end -->
  <!-- Main Sidebar Container -->

<aside class="main-sidebar sidebar-dark-primary elevation-4" name="slidenavpan" id="slidenavpan">
<div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <!-- Sidebar user panel (optional) -->

<div class="image">
<img src="{{asset('dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">

</div>
<div class="info"><a href="#" class="d-block">    {{session('user')}}
</a>
</div>
    </div>
          <!-- Sidebar user panel (optional)  end -->

                <!-- Sidebar Menu -->
<nav class="mt-2" id="navbar">
<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
 <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <li class="nav-item has-treeview menu-open">
            <a href="dashboard" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
Dashboard                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            @if(session('user')=='exam_admin')

            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="dashboard" class="nav-link active">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>Dashboard</p>
                </a>
              </li>
            <li class="nav-item">
                <a href="college_menu" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Exam Center</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="drive_menu" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Drive</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="exam_menu" class="nav-link active">
                <i class="nav-icon fas fa-edit"></i>
                <p>Examination menu</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="candidate_menu" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <span class="glyphicon glyphicon-user"></span>
                  <p>Candidates</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="verification_desk" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Registration and Verification</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="mock_menu" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Mock data</p>
                </a>
              </li>
            @endif
            @if(session('user')=='Verification admin')
            <li class="nav-item">
                <a href="verification_desk" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Registration and Verification</p>
                </a>
              </li>
            @endif
            </ul>
</ul>
<a href="logout" class="nav-link active">Logout</a>

    </nav>
      <!-- Sidebar Menu end -->

</aside>
  <!-- Main Sidebar Container end -->
 
<div class="content-wrapper"> <!-- Content Wrapper. Contains page content -->
<div class="content-header"><!--content header-->
<div class="container-fluid">
        <div class="row mb-2">
        <div class="col-sm-6">
           
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
      <section><!--content-->
<div class="container-fluid">@yield('contnet')   </div>
</div><!--content header end-->


</section><!--end content-->

</div><!-- Content Wrapper. Contains page content  end-->

<!-- css for colapse is sidebar-mini layout-fixed sidebar-closed sidebar-collapse-->
<!--css for normal body sidebar-mini layout-fixed sidebar-open-->
</body>
<!-- jQuery -->
<!-- Bootstrap 4 -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('/dist/js/adminlte.min.js')}}"></script>


</script>
</html>