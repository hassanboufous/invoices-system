<?php

namespace App\Http\Controllers\sections;

use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Grade;
use App\Models\Teacher;

class SectionController extends Controller
{
    public function index()
    {
        $grades = Grade::with(['sections'])->get();
        $grades_lists =  Grade::all();
        $sections = Section::all();
        $teachers = Teacher::all();

        return view('sections.index',compact('grades','grades_lists','sections','teachers'));
    }

    public function store(Request $request)
    {
       $section = new Section();
       $section->section_name = ['ar'=>$request->name ,'en'=>$request->name_en];
       $section->grade_id = $request->grade_id;
       $section->class_id = $request->class_id;
       $section->status = 1;
       $section->save();
       $section->teachers()->attach($request->teacher_id);
       notify()->success(trans('messages.added'));
       return redirect()->route('sections.index');
    }


    public function show($id)
    {
       $grade = Grade::findOrFail($id);
       $classes = $grade->classes;
       return $classes;
       //return response()->json($sections);
    }


    public function edit(Request $request)
    {

    }

    public function update(Request $request)
    {
       $section = Section::findOrFail($request->id);
       $section->section_name = ['ar'=>$request->name ,'en'=>$request->name_en];
       $section->grade_id = $request->grade_id;
       $section->class_id = $request->class_id;
       $request->status ? $section->status = 1: $section->status = 0;
       if(isset($request->teacher_id)){
         $section->teachers()->sync($request->teacher_id);
        }
        else {
         $section->teachers()->sync(array());
       }
       $section->save();
       notify()->success(trans('messages.edited'));
       return redirect()->route('sections.index');
    }

    public function destroy(Request $request)
    {
        Section::findOrFail($request->id)->delete();
        notify()->error(trans('messages.deleted'));
        return redirect()->route('sections.index');
    }
}
