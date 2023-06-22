<?php

namespace App\Http\Controllers\grades;

use notify;
use Exception;
use App\Models\Grade;
use App\Models\Classroom;
use Illuminate\Http\Request;
use App\Http\Requests\gradeRequest;
use App\Http\Controllers\Controller;

class GradeController extends Controller
{

    public function index()
    {
       $grades = Grade::all();
       return view('grades.list',compact('grades'));
    }

    public function store(request $request)
    {

        if(Grade::where('name->ar',$request->name)->orWhere('name->en',$request->name_en)->exists()){
            notify()->error(trans('messages.exists'));
            return redirect()->route('grades.index');
        }
       try {
           $request->validate([
             'name'=>'required',
            'name_en'=>'required'
           ]);
           /*
          $translations = [
              'en' => $request->Name_en,
              'ar' => $request->Name
            ];
            $Grade->setTranslations('Name', $translations);
            */
          $Grade = new Grade();
          $Grade->name = ['en' => $request->name_en, 'ar' => $request->name];
          $Grade->notes = $request->notes;
          $Grade->save();
          notify()->success(trans('messages.added'));
          return redirect()->route('grades.index');
       }
       catch (Exception $e){
          return redirect()->back()->with(['error' => $e->getMessage()]);
       }

    }

    public function update(gradeRequest $request)
    {
        try{
            $request->validated();
            $grade = Grade::findOrFail($request->id);
            $grade->update([
                $grade->name = ['ar' => $request->name, 'en' => $request->name_en],
                $grade->notes = $request->notes,
            ]);
            // toastr()->success(trans('messages.edited'));
            notify()->success(trans('messages.edited'));
            return redirect()->route('grades.index');
        }
        catch (Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function destroy(Request $request)
    {

       $grade = Grade::findOrFail($request->id);
       $classes = Classroom::where('grade_id',$request->id)->first();

       if(!empty($classes)){
            notify()->error(trans('grades.claessOfGrade'));
            return redirect()->back();
       };
       $grade->delete();
       notify()->error(trans('messages.deleted'));
       return redirect()->route('grades.index');
    }
}
