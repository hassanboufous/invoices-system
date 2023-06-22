<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Fee extends Model
{
    use HasFactory;
    use HasTranslations;

    public $translatable = ['title'];
    protected $gaurded = [];



    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }
    public function class()
    {
        return $this->belongsTo(Classroom::class);
    }
}
