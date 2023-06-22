<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
     protected $fillable  = [
        'classroom_id','grade_id',
        'student_id','attendence_status',
        'attendence_date','teacher_id',
        'section_id'
    ];
}
