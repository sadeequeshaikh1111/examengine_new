<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Question_SET_A_Controller;
use App\Http\Controllers\set_logs;
use App\Http\Controllers\user_controller;
use App\Http\Controllers\candidate_controller;
use App\Http\Controllers\Log_controller;
use App\Http\Controllers\file_controller;
use App\Http\Controllers\instruction_controller;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get("show",[Question_SET_A_Controller::Class,'show']);

Route::get('/', function () {
    return view('candidate_login');
});
Route::get('/lte', function () {
    return view('admin.adminpanel');
});
Route::get('/clte', function () {
    return view('admin.admin_master');
});

Route::get('/dlte', function () {
    return view('dashboard');
});
Route::get('exampage', function () {
    return view('exam_page');
});
Route::get('admin', function () {
    return view('Exam_Admin');
});
//Get Routes set_A_QP
Route::get('getQuestion/{id}',[App\Http\Controllers\Question_SET_A_Controller::Class,'ajaxGetQuestion']);//get question fro qpsetA using id
Route::get('getrecent',[App\Http\Controllers\Question_SET_A_Controller::Class,'ajaxGetQuestion']);//get question fro qpsetA using id
Route::get('getQuestion/{id}/{lang}',[App\Http\Controllers\Question_SET_A_Controller::Class,'ajaxGetQuestionl']);//get question fro qpsetA using id
Route::get('getinstructions/{type}/{lang}',[App\Http\Controllers\instruction_controller::Class,'getinstructions']);//get instruction fro qpsetA using id


//Get Routes
//Get Question by set route ajaxGetQuestionl_byset
Route::get('getQuestionbs/{id}/{lang}/{set}',[App\Http\Controllers\Question_SET_A_Controller::Class,'ajaxGetQuestionl_byset']);
Route::get('getQuestionbs/{id}/{lang}/{reg_no}',[App\Http\Controllers\Question_SET_A_Controller::Class,'ajaxGetQuestionl_byset']);

//Get Question by set route end
//update time route start
Route::post('update_time', [App\Http\Controllers\candidate_controller::Class, 'update_time'])->name('update_time.update');

Route::get('get_time/{reg_no}', [App\Http\Controllers\candidate_controller::Class, 'get_candidate_info']);
Route::post('Log_ans', [App\Http\Controllers\candidate_controller::Class, 'Log_Answer'])->name('Log_ans.create');
Route::post('save_ans', [App\Http\Controllers\Log_controller::Class, 'save_answer'])->name('Log_answer.save');
Route::post('save_current', [App\Http\Controllers\Log_controller::Class, 'save_current'])->name('Log_current_qn.save');
Route::post('end_exam', [App\Http\Controllers\Log_controller::Class, 'end_exam'])->name('end_exam.save');

//update time route end

Route::post('ajaxstore', [App\Http\Controllers\set_logs::Class, 'store'])->name('ajaxRequest.set');
//CandidateLogin routes start
Route::get('CandidateLogin', function () {
             return view('CandidateLogin');
});
//CandidateLogin routes end


//login controller function Candidate_login post method
Route::post('candidate_login',[App\Http\Controllers\candidate_controller::Class,'login']);//get question fro qpsetA using id
Route::post('start_test',[App\Http\Controllers\candidate_controller::Class,'start_test']);//get question fro qpsetA using id
Route::post('end_test',[App\Http\Controllers\candidate_controller::Class,'end_test']);//get question fro qpsetA using id

//login controller function Candidate_login post method

//Admin login and logout routes

//login controller function admin_login post method
Route::post('admin_login',[App\Http\Controllers\user_controller::Class,'login']);//get question fro qpsetA using id
//login controller function admin_login get method
Route::get('admin_login', function () {
    if(session()->has('user'))
   { 
       return view("dashboard");
   }
   return view('login');
});

//logout route
Route::get('/logout', function () {
    if(session()->has('user'))
   { session()->pull('user');}
   return view('admin.admin_login');
});
//Admin login page
Route::get('/adminl', function () {
    return view('admin.admin_login');
});
//below code is for managing login profile
Route::get('login', function () {
    if(session()->has('user'))
   { 
       return view("dashboard");
   }
   return view('login');
});


//Admin routes 

//exam menu route
Route::get('/exam_menu', function () {
    if(session()->has('user'))
    {
    return view('admin.exam_menu');
    }
    else
    {
    return view('admin.admin_login');
    }

});
//admin login page route
Route::get('/adminl', function () {
    if(session()->has('user'))
    {return view('admin.dashboard');
    }
    else
    {
    return view('admin.admin_login');
    }
});

// candidate menu route
Route::get('/candidate_menu', function () {
    if(session()->has('user'))
    {return view('admin.candidate_menu');
    }
    else
    {
    return view('admin.admin_login');
    }
});


//idle and dead status routes
Route::post('set_idle', [App\Http\Controllers\candidate_controller::Class, 'set_idle'])->name('set_idle.Idle');
Route::post('set_dead', [App\Http\Controllers\candidate_controller::Class, 'set_dead'])->name('set_dead.Dead');
Route::get('get_idle', [App\Http\Controllers\candidate_controller::Class, 'get_idle'])->name('get_idle.Idle');
Route::get('get_dead', [App\Http\Controllers\candidate_controller::Class, 'get_dead'])->name('get_dead.get');



//dashboard route
Route::get('/dashboard', function () {
    if(session()->has('user'))
    {return view('admin.dashboard');}
    else
    {
    return view('admin.admin_login');
    }
});
//drive menu route
Route::get('/drive_menu', function () {
    if(session()->has('user'))
    {return view('admin.drive_menu');
    }
    else
    {
    return view('admin.admin_login');
    }
});
//drive menu route
Route::get('/college_menu', function () {
    if(session()->has('user'))
    {return view('admin.college_menu');
    }
    else
    {
    return view('admin.admin_login');
    }
});
//verification_desk route
Route::get('/verification_desk', function () {
    if(session()->has('user'))
    {return view('admin.VDAdmin');
    }
    else
    {
    return view('admin.admin_login');
    }
});
//mock menu
Route::get('/mock_menu', function () {
    if(session()->has('user'))
    {return view('admin.Mock_menu');
    }
    else
    {
    return view('admin.admin_login');
    }
}); 

Route::get('/instructions_page', function () {
    if(session()->has('user'))
    {return view('instruction_page');
    }
    else
    {
    return view('admin.admin_login');
    }
}); 
//drive city load route
Route::get('loadcities',[App\Http\Controllers\user_controller::Class,'loadcities']);//gets and loads cities on pageload
Route::get('loadcenters/{city}',[App\Http\Controllers\user_controller::Class,'loadcenters']);//gets and loads examcenters on select event of cities
//Routes for candidate data
//Route::get('candidate_data',[App\Http\Controllers\candidate_controller::Class,'index']);//get question fro qpsetA using id


Route::post('set_logs', [App\Http\Controllers\candidate_controller::Class, 'set_logs'])->name('set_logs.post');

//get staus
Route::get('get_Candidates_unlock', [App\Http\Controllers\candidate_controller::Class, 'get_Candidates_unlock'])->name('get_Candidates_unlock.get');
Route::get('get_Candidates', [App\Http\Controllers\candidate_controller::Class, 'get_Candidates'])->name('candidates.get');
Route::get('get_qn_status/{reg_no}',[App\Http\Controllers\Log_controller::Class,'get_qn_status']);//gets status of questions
Route::post('set_status_unlock', [App\Http\Controllers\candidate_controller::Class, 'set_status_unlock'])->name('set_status_unlock.post'); //set status unlock for perticular candidate
Route::post('set_logs', [App\Http\Controllers\candidate_controller::Class, 'set_logs'])->name('set_logs.post'); 
Route::post('set_unlock_all', [App\Http\Controllers\candidate_controller::Class, 'set_unlock_all'])->name('set_unlock_all.post'); //set status unlock or all loged in

//create mock data
Route::post('create_mock_candidates',[App\Http\Controllers\candidate_controller::Class,'create_mock_candidates'])->name('create_mock_candidates.post'); ;//create mock candidates data
Route::post('create_mock_qp',[App\Http\Controllers\candidate_controller::Class,'create_mock_qp'])->name('create_mock_qp.post'); ;//create mock qp data

//get selected ans get_qn_qn_ans
Route::get('get_qn_ans/{reg_no}/{qn}',[App\Http\Controllers\Log_controller::Class,'get_qn_ans']);//gets sselected answer

//file controller routes
Route::get('set_backup_bat/{exam_id}', [App\Http\Controllers\file_controller::Class, 'set_backup'])->name('set_backup.get');
Route::get('set_drive_bat', [App\Http\Controllers\file_controller::Class, 'set_drive'])->name('set_drive.get');
//encryption roots
Route::get('encrypt/{str}', [App\Http\Controllers\file_controller::Class, 'encrypt'])->name('encrypt.get');
Route::get('decrypt/{pass}/{shift}', [App\Http\Controllers\file_controller::Class, 'decrypt']);

//get drive table routes
Route::get('get_todays_drive', [App\Http\Controllers\file_controller::Class, 'get_todays_drive'])->name('get_todays_drive.get');
Route::get('get_selected_drive/{drive_id}', [App\Http\Controllers\file_controller::Class, 'get_selected_drive']);
Route::get('select_drive/{drive_id}', [App\Http\Controllers\file_controller::Class, 'select_drive']);
Route::post('start_selected_drive', [App\Http\Controllers\file_controller::Class, 'start_selected_drive'])->name('start_selected_drive.post'); //start drive 
Route::post('shuffle_qp_sets',[App\Http\Controllers\file_controller::Class,'shuffle_qp_sets'])->name('shuffle_qp_sets.post'); ;//create mock qp data
Route::post('start_drive', [App\Http\Controllers\file_controller::Class, 'start_drive'])->name('start_drive.post'); //start drive 
Route::post('end_drive', [App\Http\Controllers\file_controller::Class, 'end_drive'])->name('end_drive.post'); //start drive 
Route::post('backup_selected_drive', [App\Http\Controllers\file_controller::Class, 'backup_selected_drive'])->name('create_backup.post'); //start drive
Route::post('upload_drive', [App\Http\Controllers\file_controller::Class, 'upload_drive'])->name('upload_drive.post'); //start drive

//drivefiles upload
Route::post('upload',[App\Http\Controllers\file_controller::Class,'store_drive']);//post file names
Route::post('uploadlink',[App\Http\Controllers\file_controller::Class,'store_drive_link']);//post file names
Route::post('create_qp_sets',[App\Http\Controllers\candidate_controller::Class,'create_qp_sets'])->name('create_qp_sets.post'); ;//create mock qp data
