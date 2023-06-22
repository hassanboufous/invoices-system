<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeacherRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'teacher_name'=>'required',
            'teacher_name_en'=>'required',
            'email'=>'required|unique:teachers,email,'.$this->id,
            'password'=>'required',
            'teacher_gender'=>'required',
            'teacher_date'=>'required',
            'teacher_phone'=>'required',
            'teacher_specialization'=>'required'

        ];
    }
      public function messages()
    {
        return [
            'teacher_name.required' => trans('validation.required'),
            'teacher_name_en.required' => trans('validation.required'),
            'email.required' => trans('validation.required'),
            'email.unique' => trans('validation.unique'),
            'teacher_date.required'=> trans('validation.required'),
            'teacher_specialization.required'=> trans('validation.required'),
            'teacher_gender.required'=> trans('validation.required'),
            'teacher_phone.required'=> trans('validation.required'),
            'teacher_specialization.required' => trans('validation.required'),
        ];
    }
}
