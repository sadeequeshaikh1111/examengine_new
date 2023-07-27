<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\instruction;
use App\Models\Language;

class instruction_controller extends Controller
{
    //
    function getinstructions($type,$lang)
    {
$data=instruction::where('language',$lang)->get();
return response()->json($data, 200); 
}
}
