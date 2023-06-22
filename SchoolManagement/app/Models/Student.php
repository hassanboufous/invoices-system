<?php

namespace App\Models;

use App\Models\Image;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory;
    use HasTranslations;
    use SoftDeletes;

    public $translatable = ['name'];
    protected $guarded = [];

    public function class() {
        return $this->belongsTo(Classroom::class,'class_id');
    }
    public function grade() {
        return $this->belongsTo(Grade::class,'grade_id');
    }
    public function gender() {
        return $this->belongsTo(Gender::class,'gender_id');
    }
    public function parent() {
        return $this->belongsTo(MyParent::class,'parent_id');
    }
    public function section() {
        return $this->belongsTo(Section::class,'section_id');
    }
    public function bloodType() {
        return $this->belongsTo(BloodType::class,'blood_type_id');
    }
    //---------------------------------------------------------
    public function images() {
        return $this->morphMany(Image::class,'imageable');
    }


    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'student_id');
    }

}
