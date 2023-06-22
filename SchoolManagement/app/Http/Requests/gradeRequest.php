<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class gradeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'=>'required|unique:grades,name->ar,'.$this->id,
            'name_en'=>'required|unique:grades,name->en,'.$this->id
        ];
    }
    public function messages()
    {
        return [
            'name.required' => trans('validation.required'),
            'name_en.required' => trans('validation.required'),
            'name.unique' => trans('validation.unique'),
            'name_en.unique' => trans('validation.unique')
        ];
    }
}
