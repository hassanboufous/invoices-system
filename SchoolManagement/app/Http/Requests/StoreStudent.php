<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudent extends FormRequest
{
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'name'=>'required',
            'name_en'=>'required',
            'email'=>'required',
            'password'=>'required',
            'gender_id'=>'required',

            'blood_type_id'=>'required',
            'birth_date'=>'required',
            'grade_id'=>'required',
            'classroom_id'=>'required',
            'section_id'=>'required',
            'parent_id'=>'required',
            'academic_year'=>'required',
        ];
    }
}
