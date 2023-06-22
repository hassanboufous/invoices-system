<?php

namespace App\Repository\subject;

use App\Models\Grade;

class SubjectRepository implements SubjectRepositoryInterface {

        public function index(){
            return view('subjects.index');
        }

        public function create(){
            $grades = Grade::all();
            return view('subjects.create',compact('grades'));
        }



}
