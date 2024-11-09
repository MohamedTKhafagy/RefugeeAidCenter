<?php
require_once __DIR__ . '/../Models/SchoolModel.php';

class SchoolController
{
    public function showAllSchools()
    {
        $schools = School::getAll();
        include __DIR__ . '/../views/SchoolListView.php';
    }

    public function showSchool($SchoolID)
    {
        $school = School::findById($SchoolID);
        if ($school) {
            include __DIR__ . '/../views/SchoolDetailView.php';
        } else {
            echo "School not found.";
        }
    }
}
