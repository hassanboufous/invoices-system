<?php

namespace App\Http\Controllers\classrooms;

use Exception;
use App\Models\Grade;
use App\Models\Classroom;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClassroomRequest;
use Barryvdh\Debugbar\Facades\Debugbar;

class ClassroomController extends Controller
{

    public function index()
    {
        $grades = Grade::all();
        $classLists = Classroom::all();
        $classes = [];
        Debugbar::info($grades);
       return view('classrooms.index',compact('grades','classLists','classes'));
    }

    public function store(classroomRequest $request)
    {
        $validated = $request->validated();

        try{
            foreach($request->classLists as $class){
                Classroom::create([
                    'class_name' => ['ar'=>$class['name'] ,'en'=>$class['name_en']],
                    'grade_id' => $class['grade_id']
                ]);
            }
            notify()->success(trans('messages.added'));
           return redirect()->route('classrooms.index');
        }
        catch (Exception $e){
          return redirect()->back()->with(['error' => $e->getMessage()]);
       }
    }

    public function update(ClassroomRequest $request)
    {
        try {
            $classroom = Classroom::findOrFail($request->id);
            $classroom->update([
            'class_name'=>['ar' => $request->name, 'en' => $request->name_en],
            'grade_id' =>$request->grade_id
            ]);
            notify()->success(trans('messages.edited'));
            return redirect()->route('classrooms.index');
        }
        catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function destroy(Classroom $classroom)
    {
       $classroom->delete();
       notify()->error(trans('messages.deleted'));
       return redirect()->route('classrooms.index');
    }

    public function deleteCheckedItems(Request $request)
    {
        $chekcIds = explode(",",$request->delete_all_id);
        Classroom::whereIn('id',$chekcIds)->delete();
        notify()->error(trans('messages.deleted'));
        return redirect()->route('classrooms.index');
    }

    public function filterClasses(Request $request){
        $grades = Grade::all();
        $classLists = Classroom::where('grade_id', $request->grade_id)->get();
       return view('classrooms.index',compact('grades','classLists'));
    }

}
