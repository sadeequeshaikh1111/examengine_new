<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\exam_set_a_log;
use App\Models\exam_set_b_log;
use App\Models\exam_set_c_log;
use App\Models\exam_set_d_log;
use App\Models\set_a_question_paper;
use App\Models\set_b_question_paper;
use App\Models\set_c_question_paper;
use App\Models\set_d_question_paper;
use App\Models\instruction;
use App\Models\Language;

use App\Models\exammasters;
use App\Models\exam_question;
use App\Models\subject;
use Illuminate\Support\Facades\DB;
use App\Models\Candidate;
use Yajra\Datatables\DataTables;
use App\Models\feedback;
use App\Models\feedback_log;

class feedback_controller extends Controller
{
    //
}
