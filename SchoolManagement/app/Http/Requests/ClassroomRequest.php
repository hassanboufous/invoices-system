<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClassroomRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
           'classLists.*.name'=>'required',
           'classLists.*.name_en'=>'required'
        ];
    }
    public function messages()
    {
        return [
           'name.required' => trans('classrooms.required_name_ar'),
           'name_en.required' => trans('classrooms.required_name_en'),
        ];
    }
}
