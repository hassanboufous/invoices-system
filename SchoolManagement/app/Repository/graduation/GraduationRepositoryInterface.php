<?php

namespace App\Repository\graduation;

interface GraduationRepositoryInterface {

    public function index();

    public function create();

    public function store($request);

    // Restore student from graduation
    public function restore($id);

    // Hard delete student - after graduation
    public function Delete($id) ;
}
