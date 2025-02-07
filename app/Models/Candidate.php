<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;
    protected $primaryKey = "reg_no";
    protected $fillable = ['status','time','marks','candidate_feedback'];

}
