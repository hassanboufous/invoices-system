<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MyParent extends Model
{
    use HasFactory, Notifiable;
    use HasTranslations;

       public $translatable = [
              'father_name',
              'father_job',
              'mother_name',
              'mother_job'
            ];

    protected $table = 'my_parents';
    protected $guarded = [];

    /**
     * Get the user associated with the MyParent
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function nationality()
    {
        return $this->hasOne(Nationality::class, 'id','father_nationality_id');
    }


}
