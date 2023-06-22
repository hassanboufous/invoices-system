<?php

namespace App\Repository\fees;

use App\Models\Classroom;
use Exception;
use App\Models\Fee;
use App\Models\Grade;

class FeeRepository implements FeeRepositoryInterface  {

    public function index(){
        $fees = Fee::all();
        return view('Fees.index',compact('fees'));
    }

    public function create(){
        $grades = Grade::all();
        return view('Fees.create',compact('grades'));
    }

    public function store($request){
        try {
            //return $request;
            $fee = new Fee();
            $fee->title       = ['ar'=>$request->name,'en'=>$request->name_en];
            $fee->amount      = $request->amount;
            $fee->grade_id    = $request->grade_id;
            $fee->class_id    = $request->classroom_id;
            $fee->year        = $request->academic_year;
            $fee->description = $request->description;
            $fee->save();
            notify()->success(trans('messages.added'));
            return redirect()->route('fees.index');
        }
        catch(Exception $ex){
            return back()->with('error','Error : '.$ex->getMessage());
        }
    }

    public function edit($id){
        $fee = Fee::findOrFail($id);
        $classes = Classroom::all();
        $grades = Grade::all();
        return view('Fees.edit',compact('fee','grades','classes'));
    }
    public function update($request,$id){
         try {
            //return $request;
            $fee = Fee::findOrFail($id);
            $fee->title       = ['ar'=>$request->name,'en'=>$request->name_en];
            $fee->amount      = $request->amount;
            $fee->grade_id    = $request->grade_id;
            $fee->class_id    = $request->classroom_id;
            $fee->year        = $request->academic_year;
            $fee->description = $request->description;
            $fee->save();
            notify()->success(trans('messages.edited'));
            return redirect()->route('fees.index');
        }
        catch(Exception $ex){
            return back()->with('error','Error : '.$ex->getMessage());
        }

    }

    public function destroy($id){
        $fee = Fee::findOrFail($id);
        $fee->delete();
        notify()->success(trans('messages.deleted'));
        return redirect()->route('fees.index');
    }


}
