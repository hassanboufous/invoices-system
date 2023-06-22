<?php

namespace App\Repository;
interface StudentRepositoryInterface {
     // Get student
    public function getStudent();

    // Add student
    public function addStudent();

    // Add student
    public function showStudent($id);

    // Edit student
    public function editStudent($id);

    // Update student
    public function updateStudent($request,$id);

    // Delete student
    public function deleteStudent($id);

    // upload student attachments
    public function uploadStudentAttachment($request);

    // Download student attachments
    public function downloadAttachment($id);

    // Delete student attachments
    public function deleteAttachment($id);

    // Get classrooms
    public function getClasses($id);

    // Get section
    public function getSection($id);

    // Store student
    public function storeStudent($request);
}
