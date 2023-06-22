<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Classroom extends Model
{
    use HasFactory;
    use HasTranslations;

    public $translatable = ['class_name'];

    protected $fillable  = ['class_name','grade_id'];


    // protected $casts = [
    //     'class_name' => 'array',
    // ];

    public function grade()
    {
        return $this->belongsTo(Grade::class,'grade_id');
    }
}
