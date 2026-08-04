<!DOCTYPE html>
<html lang="english">
<head>
    <meta charset="UTF-8">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google" content="notranslate">
<meta http-equiv="Content-Language" content="en">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
@extends('admin.admin_master')
    @section('title','Exam Menu')
    @section('contnet') 
    {{session('user')}}

<h1>welcome to Exam menu</h1>
    @endsection    
</body>
</html>