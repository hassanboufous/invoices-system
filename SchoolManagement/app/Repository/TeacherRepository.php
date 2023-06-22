<?php

namespace App\Repository;

use Error;
use Exception;
use App\Models\Gender;
use App\Models\Teacher;
use App\Models\Specialization;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\Hash;

class TeacherRepository implements TeacherRepositoryInterface {

    public function getAllTeachers(){
        return Teacher::all();
    }

    public function getSpecializations(){
        return Specialization::all();
    }

    public function getGenders(){
        return Gender::all();
    }

    public function storeTeacher($request){
        try{
            $teacher = new Teacher();
            $teacher->name           = ['ar'=>$request->teacher_name,'en'=>$request->teacher_name_en];
            $teacher->email          = $request->email;
            $teacher->password       = Hash::make($request->password);
            $teacher->specialization = $request->teacher_specialization;
            $teacher->gender         = $request->teacher_gender;
            $teacher->phone          = $request->teacher_phone;
            $teacher->join_date      = $request->teacher_date;
            $teacher->address        = $request->teacher_address;
            $teacher->save();

        }
        catch(Exception $e){
            return back()->with('error',$e->getMessage());
        }

    }
    public function editTeacher($id) {
        $teacher = Teacher::findOrFail($id);
        return $teacher;
    }

    public function updateTeacher($request,$id) {

        try{
            $teacher = Teacher::findOrFail($id);
            $teacher->name           = ['ar'=>$request->teacher_name,'en'=>$request->teacher_name_en];
            $teacher->email          = $request->email;
            $teacher->password       = Hash::make($request->password);
            $teacher->specialization = $request->teacher_specialization;
            $teacher->gender         = $request->teacher_gender;
            $teacher->phone          = $request->teacher_phone;
            $teacher->join_date      = $request->teacher_date;
            $teacher->address        = $request->teacher_address;
            $teacher->save();
            notify()->success(trans('messages.edited'));
            return redirect()->route('teachers.index');
        }
        catch(Exception $e){
            return back()->with('error',$e->getMessage());
        }
    }

    public function deleteTeacher($id)
    {
        $teacher = Teacher::findOrFail($id);
        $teacher->delete();
        notify()->success(trans('messages.deleted'));
       return redirect()->route('teachers.index');
    }
}
