<?php

namespace App\Repository\graduation;

use App\Models\Grade;
use App\Models\Student;

class GraduationRepository implements GraduationRepositoryInterface {

    public function index(){
       $students = Student::onlyTrashed()->get();
       return view('students.graduation.index',compact('students'));
    }

    public function create(){
        $grades = Grade::all();
        return view('students.graduation.create',compact('grades'));
    }

    public function store($request) {

        $students = Student::where('grade_id',$request->grade_id)
                            ->where('section_id',$request->section_id)
                            ->where('class_id',$request->classroom_id)
                            ->get();

      if($students->count() > 0){
            foreach($students as $student) {
                Student::where('id',$student->id)->delete();
            }
            notify()->error(trans('messages.edited'));
            return back();
        }
        else {
          notify()->error(trans('messages.empty'));
          return back();
        }
    }

    public function restore($id){
        Student::onlyTrashed()->where('id',$id)->first()->restore();
        notify()->success(trans('messages.edited'));
        return back();
    }

    public function Delete($id){
        Student::onlyTrashed()->where('id',$id)->first()->forceDelete();
        notify()->success(trans('messages.deleted'));
        return back();
    }
}
