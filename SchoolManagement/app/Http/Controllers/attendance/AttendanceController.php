<?php

namespace App\Http\Controllers\attendance;

use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\attendance\AttendanceRepositoryInterface;

class AttendanceController extends Controller {

    public $attendance;

    public function __construct(AttendanceRepositoryInterface $attendance) {
        $this->attendance = $attendance;
    }

    public function index() {
      return $this->attendance->index();
    }

    public function create() {
        //
    }

    public function store(Request $request) {
       return $this->attendance->store($request);
    }

    public function show($id) {
      return $this->attendance->show($id);
    }

    public function edit(Attendance $attendance){
        //
    }

    public function update(Request $request, Attendance $attendance) {
        //
    }


    public function destroy(Attendance $attendance) {
        //
    }
}
