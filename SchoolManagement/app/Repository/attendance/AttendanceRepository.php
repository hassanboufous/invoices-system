<?php

namespace App\Repository\attendance;

use App\Models\Attendance;
use App\Models\Grade;
use App\Models\Section;
use App\Models\Student;
use App\Models\Teacher;
use Exception;

class AttendanceRepository implements AttendanceRepositoryInterface {


    public function index() {
        $grades = Grade::all();
        $teachers = Teacher::all();
        return view('attendance.index',compact('grades','teachers'));
    }

    public function show($id){
        $students = Student::with('attendances')->where('section_id',$id)->get();
        return view('attendance.show',compact('students'));
    }

    public function store($request) {
      try{
            foreach($request->attendances as $student_id=>$attendance){
                if($attendance == 'present'){
                    $attendance_status = 1;
                }
                elseif($attendance == 'absent'){
                    $attendance_status = 0;
                }
                Attendance::create([
                    'student_id'=> $student_id,
                    'grade_id'=> $request->grade_id,
                    'classroom_id'=> $request->classroom_id,
                    'teacher_id'=> 4,
                    'section_id'=> $request->section_id,
                    'attendence_date'=> date('Y-m-d'),
                    'attendence_status'=> $attendance_status,
                ]);

            }
            notify()->success(trans('messages.added'));
            return redirect()->back();

        }
        catch(Exception $e){
         return back()->with('error','error : '.$e->getMessage());
       }
    }

    public function update($request) {

    }

    public function destroy($id){

    }

}
