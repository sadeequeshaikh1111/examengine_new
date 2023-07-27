<?php

namespace App\Http\Controllers;
use App\Services\PayUService\Exception;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\examcenterdetail;
use App\Models\set_a_question_paper;

use Illuminate\Support\Facades\Auth;

class user_controller extends Controller
{
    public function login(Request $request)//function for login
    {try{
  
     $name=$request->input('name');
     $password=$request->input('password');
    $user=User::where('email',$name)->where('password',$password)->get()->first();
if($user)
 {
     $data=array('email'=>$user->email,'name'=>$user->name);

     $request->session()->put('email',$data['email']);
     $request->session()->put('user',$data['name']);

    return view('dashboard',compact('data'));
 }
 else
{
          $request->session()->flash('msg','Invalid Credentials');
print($request->name);
    return back()->with('msg', 'Invalid credentials');
}}
catch(MethodNotAllowedHttpException $e)
{
    return view('admin.admin_login');
}
   
    }

   function loadcities()
    {
        $data = examcenterdetail::select('city')->distinct()->orderBy('city', 'asc')->get();
                return response()->json($data, 200); 
    }
    function loadcenters($city)//load centers after selecting city
    {
        $data = examcenterdetail::select('Exam_Center_name')->where('city',$city)->distinct()->orderBy('Exam_Center_name', 'asc')->get();
                return response()->json($data, 200); 
    }
    
} 
