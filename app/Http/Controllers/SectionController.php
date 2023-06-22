<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = Section::all();
        return view('sections.sections',compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'section_name'=>['required','string','unique:sections'],
            'description'=>['string']
        ]);

        $section = new Section();
        $section->section_name = $request->section_name  ;
        $section->description = $request->description ;
        $section->created_by = Auth::user()->name;
        $section->save();
        return redirect()->route('sections.index')
                    ->with(['success'=>'تمة اضافة القسم بنجاح']);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Section $section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;
          $request->validate([
            'section_name'=>'required|max:200|unique:sections,section_name,'.$id,
            'description'=>['string']
        ]);

        $section = Section::find($id) ;
        $section->update([
            'section_name'=>$request->section_name,
            'description'=>$request->description
        ]);
        return redirect()->route('sections.index')
                    ->with(['success'=>'تمة تعديل القسم بنجاح']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
       $section = Section::find($request->id);
       $section->delete();
        return redirect()->route('sections.index')
                    ->with(['success'=>'تمة حدف القسم بنجاح']);
    }
}
