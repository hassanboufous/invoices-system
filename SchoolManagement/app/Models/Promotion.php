<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function student()
    {
        return $this->belongsTo(Student::class,'student_id');
    }
    //---------------------------------------------------------------
    public function fromClassroom()
    {
        return $this->belongsTo(Classroom::class,'from_class');
    }
    public function fromGrade()
    {
        return $this->belongsTo(Grade::class,'from_grade');
    }
    public function fromSection()
    {
        return $this->belongsTo(Section::class,'from_section');
    }
    //---------------------------------------------------------------
    public function toClassroom()
    {
        return $this->belongsTo(Classroom::class,'to_class');
    }
    public function toGrade()
    {
        return $this->belongsTo(Grade::class,'to_grade');
    }
    public function toSection()
    {
        return $this->belongsTo(Section::class,'to_section');
    }
}
