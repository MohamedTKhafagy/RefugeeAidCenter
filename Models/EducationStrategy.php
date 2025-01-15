<?php
include_once 'SchoolModel.php';
include_once 'TeacherModel.php';

//EducationStrategy.php

interface EducationStrategy {
    public function AssignSchool(School $school);
    public function AssignTeacher(Teacher $teacher);
}

class ElementaryEducation implements EducationStrategy {

    public function AssignSchool(School $school) {
        echo "Elementary school: " . $school->getName() . " has been assigned.\n";
    }

    public function AssignTeacher(Teacher $teacher) {
        echo "Teacher: " . $teacher->getName() . " has been assigned to teach elementary level students.\n";
    }
}

class MiddleEducation implements EducationStrategy {

    public function AssignSchool(School $school) {
        echo "Middle school: " . $school->getName() . " has been assigned.\n";
    }

    public function AssignTeacher(Teacher $teacher) {
        echo "Teacher: " . $teacher->getName() . " has been assigned to teach middle-level students.\n";
    }
}

class HighEducation implements EducationStrategy {
    public function AssignSchool(School $school) {
        echo "High school: " . $school->getName() . " has been assigned.\n";
    }

    public function AssignTeacher(Teacher $teacher) {
        echo "Teacher: " . $teacher->getName() . " has been assigned to teach high-level students.\n";
    }
}
