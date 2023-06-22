<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Jobs\ActivateUsers;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $users = User::latest()->get();
        return view('users.index',compact('users'));
    }
    public function create(){
        $roles = Role::all();
        return view('users.create',compact('roles'));
    }
}
