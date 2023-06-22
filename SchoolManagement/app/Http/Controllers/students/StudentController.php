<?php

namespace App\Http\Controllers\students;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudent;
use App\Models\Image;
use App\Repository\StudentRepositoryInterface;

class StudentController extends Controller
{
    public $student;

    public function __construct(StudentRepositoryInterface $student)
    {
        $this->student =  $student;
    }

    public function index()
    {
       return $this->student->getStudent();
    }

    public function create()
    {
        return $this->student->addStudent();
    }

    public function show($id)
    {
        return $this->student->showStudent($id);
    }

    public function store(StoreStudent $request)
    {
       return $this->student->storeStudent($request);
    }

    // Upload student attachmets
    public function StdAttachment(Request $request) {
        return $this->student->uploadStudentAttachment($request);
    }
    // Upload student attachmets
    public function downloadAttachment($id) {
      return $this->student->downloadAttachment($id);
    }

    // need to repair ---- not working ???????????????
    public function showAttachment($id) {
        $file = Image::findOrFail($id);
        $file_path = public_path('storage/'.$file->filename);
        return response()->file($file_path);
    }

    public function deleteAttachment($id){
        return $this->student->deleteAttachment($id);
    }


    public function getClasses($id)
    {
        return $this->student->getClasses($id);
    }

    public function getSection($id)
    {
       return $this->student->getSection($id);
    }

    public function edit($id)
    {
        return $this->student->editStudent($id);
    }

    public function update(Request $request,$id)
    {
        return $this->student->updateStudent($request,$id);
    }

    public function destroy($id)
    {
       return $this->student->deleteStudent($id);
    }
}
