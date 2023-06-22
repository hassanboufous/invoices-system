<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Grade extends Model
{
    use HasFactory;
    use HasTranslations;

    public $translatable = ['name'];

    protected $fillable = ['name','notes'];


    public function sections()
    {
        return $this->hasMany(Section::class, 'grade_id');
    }
    public function classes()
    {
        return $this->hasMany(Classroom::class, 'grade_id');
    }
}
