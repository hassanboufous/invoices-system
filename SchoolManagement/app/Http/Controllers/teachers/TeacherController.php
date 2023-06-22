<?php

namespace App\Http\Controllers\teachers;
use App\Repository\TeacherRepositoryInterface;
use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeacherRequest;
use App\Models\Gender;
use App\Models\Specialization;

class TeacherController extends Controller
{
    protected $teacher;

    public function __construct(TeacherRepositoryInterface $teacher)
    {
        $this->teacher = $teacher;
    }

    public function index()
    {
        $teachers = $this->teacher->getAllTeachers();
        return view('teachers.index',compact('teachers'));
    }

    public function create()
    {
        $genders = $this->teacher->getGenders();
        $specializations = $this->teacher->getSpecializations();
        return view('teachers.create',compact('genders','specializations'));
    }


    public function store(StoreTeacherRequest $request)
    {
        $this->teacher->storeTeacher($request);
        notify()->success(trans('messages.added'));
        return redirect()->route('teachers.create');
    }


    public function edit($id)
    {
        $teacher =  $this->teacher->editTeacher($id);
        $genders = $this->teacher->getGenders();
        $specializations = $this->teacher->getSpecializations();
        return view('teachers.edit',compact('genders','specializations','teacher'));
    }


    public function update(Request $request,$id)
    {
        $this->teacher->updateTeacher($request,$id)
              ->with(['success'=>trans('messages.edited')]);
    }


    public function destroy($id)
    {
      $this->teacher->deleteTeacher($id)
           ->with(['success'=>trans('messages.deleted')]);

    }
}
