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
        echo "Elementary school '{$school}' has been assigned.\n";
    }

    public function AssignTeacher(Teacher $teacher) {
        echo "Teacher '{$teacher}' has been assigned to teach elementary level students.\n";
    }
}

class MiddleEducation implements EducationStrategy {

    public function AssignSchool($school) {
        echo "Middle school '{$school}' has been assigned.\n";
    }

    public function AssignTeacher($teacher) {
        echo "Teacher '{$teacher}' has been assigned to teach middle-level students.\n";
    }
}

class HighEducation implements EducationStrategy {
    public function AssignSchool($school) {
        echo "High school '{$school}' has been assigned.\n";
    }

    public function AssignTeacher($teacher) {
        echo "Teacher '{$teacher}' has been assigned to teach high-level students.\n";
    }
}
