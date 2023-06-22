<?php

namespace App\Repository;

use Exception;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Promotion;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\DB;

class StudentPromotionRepository implements StudentPromotionRepositoryInterface {

    public function index() {
        $grades = Grade::all();
        return view('students.promotion.index',compact('grades'));
    }

    public function store($request) {
        DB::beginTransaction();
        try {
            $students = Student::where('grade_id',$request->grade_id)
                                ->where('class_id',$request->classroom_id)
                                ->where('section_id',$request->section_id)
                                ->where('academic_year',$request->academic_year)
                                ->get();
            if($students->count()<1){
                notify()->error(trans('messages.empty'));
                return back();
            }
            foreach($students as $student) {
                $student->update([
                    'grade_id'      =>$request->new_grade_id,
                    'class_id'      =>$request->new_classroom_id,
                    'section_id'    =>$request->new_section_id,
                    'academic_year' =>$request->new_academic_year
                ]);

                Promotion::updateOrCreate([
                    'student_id'   => $student->id,
                    'from_section' => $request->section_id,
                    'from_grade'   => $request->grade_id,
                    'from_class'   => $request->classroom_id,
                    'to_section'   => $request->new_section_id,
                    'to_grade'     => $request->new_grade_id,
                    'to_class'     => $request->new_classroom_id,
                    'old_academic_year'  => $request->academic_year,
                    'new_academic_year'  => $request->new_academic_year
                ]);

            }
            DB::commit();
            notify()->success(trans('messages.edited'));
            return redirect()->route('students.index');
        }
        catch(Exception $e){
            DB::rollBack();
            return back()->with('error','error : '.$e->getMessage());
        }
    }

    public function destroy($id){
        try {
             if($id){
                    $promotion = Promotion::findOrFail($id);
                    Student::where('id',$promotion->student_id)->update([
                                'academic_year'=>$promotion->old_academic_year ,
                                'grade_id'     => $promotion->from_grade,
                                'section_id'   =>$promotion->from_section,
                                'class_id'     =>$promotion->from_class,
                            ]);
                    Promotion::destroy($promotion->id);
                    notify()->success(trans('messages.edited'));
                    return back();
                }
                else{
                    $promotions = Promotion::all();
                    foreach($promotions as $promotion){
                        Student::where('id',$promotion->student_id)->update([
                            'academic_year'=>$promotion->old_academic_year ,
                            'grade_id'     => $promotion->from_grade,
                            'section_id'   =>$promotion->from_section,
                            'class_id'     =>$promotion->from_class,
                        ]);
                    }
                    Promotion::truncate();
                    notify()->success(trans('messages.edited'));
                    return back();
             }
        }
        catch(Exception $e){
            return back()->with('error','error : '.$e->getMessage());
        }

    }

}
