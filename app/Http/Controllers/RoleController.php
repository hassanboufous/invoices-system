<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index() {
        $roles= [] ;
        return view('roles.index',compact('roles'));
    }
}
