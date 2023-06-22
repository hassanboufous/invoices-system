<?php

namespace App\Http\Controllers\fees;

use Exception;
use App\Models\Fee;
use App\Models\Grade;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Repository\fees\FeeRepositoryInterface;

class FeeController extends Controller {

    public $fee;

    public function __construct(FeeRepositoryInterface $fee) {
        return $this->fee =$fee;
    }

    public function index() {
     return $this->fee->index();
    }

    public function create() {
        return $this->fee->create();
    }


    public function store(Request $request) {
        return $this->fee->store($request);
    }

    public function edit($id) {
       return $this->fee->edit($id);
    }

    public function update(Request $request,$id) {
        return $this->fee->update($request,$id);
    }

    public function destroy($id) {
        return $this->fee->destroy($id);
    }

    public function studentFees($id) {
        $student = Student::findOrFail($id);
        $fees = Fee::all();
        return view('Fees.students.addfees',compact('student','fees'));
    }
}
