<?php

namespace App\Http\Controllers\graduation;

use App\Models\Graduation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Repository\graduation\GraduationRepositoryInterface;

class GraduationController extends Controller
{
    public $graduation;

    public function __construct(GraduationRepositoryInterface $graduation)
    {
        $this->graduation = $graduation;
    }

    public function index()
    {
        return $this->graduation->index();
    }


    public function create()
    {
        return $this->graduation->create();
    }


    public function store(Request $request)
    {
       return $this->graduation->store($request);
    }


    public function show(Graduation $graduation)
    {
        //
    }

    public function edit(Graduation $graduation)
    {
        //
    }

    public function update(Request $request, Graduation $graduation)
    {
        //
    }
    // Force Delete student after gradaution
    public function destroy($id)
    {
       return $this->graduation->Delete($id);
    }

    public function restore($id)
    {
       return $this->graduation->restore($id);
    }
}
