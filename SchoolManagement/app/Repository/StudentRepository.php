<?php
namespace App\Repository;

use App\Http\Requests\StoreStudent;
use App\Models\BloodType;
use App\Models\Classroom;
use App\Models\Gender;
use App\Models\Grade;
use App\Models\Image;
use App\Models\MyParent;
use App\Models\Nationality;
use App\Models\Section;
use App\Models\Student;
use App\traits\UploadImg;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class StudentRepository implements StudentRepositoryInterface {
    use UploadImg;

    public function getStudent()
    {
        $students = Student::all();
        return view('students.index',compact('students'));
    }

    public function addStudent()
    {
        $data['grades']        = Grade::all();
        $data['classes']       = Classroom::all();
        $data['genders']       = Gender::all();
        $data['parents']       = MyParent::all();
        $data['nationalities'] = Nationality::all();
        $data['bloodTypes']    = BloodType::all();

        return view('students.create',$data);
    }

    public function showStudent($id)
    {
        $student = Student::findOrFail($id);
        $attachmets = Image::where('imageable_id',$student->id)->get();
        return view('students.show',compact('student','attachmets'));
    }

    public function getClasses($id){
        $classes = Classroom::where('grade_id', $id)->pluck('class_name','id');
        return $classes;
    }

    public function getSection($id){
        $sections = Section::where('class_id', $id)->pluck('section_name','id');
        return $sections;
    }

    public function storeStudent($request){

        DB::beginTransaction();
        try {
                $student = new Student();
                $student->name          = ['ar'=>$request->name ,'en'=>$request->name_en];
                $student->email         = $request->email ;
                $student->password      = $request->password ;
                $student->gender_id     = $request->gender_id ;
                $student->birth_date    = $request->birth_date ;
                $student->section_id    = $request->section_id ;
                $student->grade_id      = $request->grade_id ;
                $student->parent_id     = $request->parent_id ;
                $student->academic_year = $request->academic_year ;
                $student->class_id      = $request->classroom_id ;
                $student->blood_type_id = $request->blood_type_id ;
                $student->save();

                if($request->hasfile('photos')) {
                    $student_path = 'Attachment/students/';
                    $student = Student::latest()->first();
                    foreach($request->file('photos') as $file){
                        $file_name = $this->uplodIgmage($file,$student_path.$request->name_en);
                        $image = new Image();
                        $image->filename       = $file_name;
                        $image->imageable_id   = $student->id;
                        $image->imageable_type = 'App\Model\Student';
                        $image->save();
                    }
                }
                DB::commit();
                notify()->success(trans('messages.added'));
                return redirect()->route('students.index');
            }
        catch(Exception $e){
                DB::rollBack();
                return back()->with('error','error : '.$e->getMessage());
            }
    }

    public function editStudent($id)
    {
        $data['grades']        = Grade::all();
        $data['classes']       = Classroom::all();
        $data['genders']       = Gender::all();
        $data['parents']       = MyParent::all();
        $data['nationalities'] = Nationality::all();
        $data['bloodTypes']    = BloodType::all();
        $data['student']       = Student::findOrFail($id);

        return view('students.edit',$data);
    }

    public function updateStudent($request ,$id)
    {
       try {
            $student = Student::findOrFail($id) ;
            $student->name          = ['ar'=>$request->name ,'en'=>$request->name_en];
            $student->email         = $request->email ;
            $student->password      = $request->password ;
            $student->gender_id     = $request->gender_id ;
            $student->birth_date    = $request->birth_date ;
            $student->section_id    = $request->section_id ;
            $student->grade_id      = $request->grade_id ;
            $student->parent_id     = $request->parent_id ;
            $student->academic_year = $request->academic_year ;
            $student->class_id      = $request->classroom_id ;
            $student->blood_type_id = $request->blood_type_id ;
            $student->save();

            notify()->success(trans('messages.edited'));
            return redirect()->route('students.index');

       }
       catch(Exception $e){
         return back()->with('error','error : '.$e->getMessage());
       }

    }

    public function deleteStudent($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        notify()->success(trans('messages.deleted'));
        return redirect()->route('students.index');
    }

    // Student Attachments ----------------------------------------------
    public function uploadStudentAttachment($request) {
        $student_path = 'Attachment/students/';
        foreach($request->file('photos') as $file){
            $file_name = $this->uplodIgmage($file,$student_path.$request->name);
            $image = new Image();
            $image->filename       = $file_name;
            $image->imageable_id   = $request->id;
            $image->imageable_type = 'App\Model\Student';
            $image->save();
        }
        notify()->success(trans('messages.added'));
        return back();
    }

    public function downloadAttachment($id) {
        $file = Image::findOrFail($id);
        $file_path = public_path('storage/'.$file->filename);
        return response()->download($file_path);
    }

    public function deleteAttachment($id) {
         $file = Image::findOrFail($id);
        Storage::delete($file->filename);
        $file->delete();
        notify()->success(trans('messages.deleted'));
        return back();

    }

}
