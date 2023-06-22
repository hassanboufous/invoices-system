<?php

namespace App\Http\Controllers\students;

use App\Models\Promotion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Repository\StudentPromotionRepositoryInterface;

class PromotionController extends Controller
{
    public $promotion;

    public function __construct(StudentPromotionRepositoryInterface $promotion)
    {
        $this->promotion = $promotion;
    }
    public function index()
    {
        return $this->promotion->index();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $promotions = Promotion::all();
       return view('students.promotion.show',compact('promotions'));
    }


    public function store(Request $request)
    {
        return $this->promotion->store($request);
    }


    public function show()
    {

    }


    public function edit(Promotion $promotion)
    {
        //
    }


    public function update(Request $request, Promotion $promotion)
    {
        //
    }

    // cancel promotion
    public function destroy($id)
    {
        return $this->promotion->destroy($id);
    }
}
