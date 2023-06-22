<?php

namespace App\Repository;

interface TeacherRepositoryInterface {

    // get teacher names
    public function getAllTeachers();

    // get specializations
    public function getSpecializations();

    // get genders
    public function getGenders();

    // add teacher
    public function storeTeacher($request);

    // edit teacher
    public function editTeacher($id);

    // update teacher info
    public function updateTeacher($request,$id);

    // delete teacher
    public function deleteTeacher($id);
}
