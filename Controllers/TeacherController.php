<?php
require_once __DIR__ . '/../Models/TeacherModel.php';


class TeacherController
{

    public function index()
    {
        $teachers = Teacher::all();
        require 'Views/TeachersView.php';
    }

    public function add($data = null)
    {
        
        if ($data) {
            //validation
            $this->saveTeacher($data);
            $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
            header('Location: ' . $base_url . '/teachers');
        } else {
            require 'Views/AddTeacherView.php';
        }
    }

    public function saveTeacher($data)
    {
        $Teacher = new Teacher(
            null,
            $data['Name'],
            $data['Age'],
            $data['Gender'],
            $data['Address'],
            $data['Phone'],
            $data['Nationality'],
            6,
            $data['Email'],
            $data['Preference'],
            $data["Subject"],
            $data["Availability"],
            $data["School"]
        );
        $Teacher->save();
    }

    public function editTeacher($data){
        $Teacher = new Teacher(
            $data['Id'],
            $data['Name'],
            $data['Age'],
            $data['Gender'],
            $data['Address'],
            $data['Phone'],
            $data['Nationality'],
            6,
            $data['Email'],
            $data['Preference'],
            $data["Subject"],
            $data["Availability"],
            $data["School"]
        );
        Teacher::editById($data['Id'], $Teacher);
        $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        header('Location: ' . $base_url . '/teachers');
    }

    public function edit($id){
            $teacher = Teacher::findById($id);
            require 'Views/EditTeacherView.php';
    }
    public function delete($id){
        Teacher::deleteById($id);
        $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        header('Location: ' . $base_url . '/teachers');
    }

    public function findTeacherById($id)
    {
        $teacher = Teacher::findById($id);
        require 'Views/TeacherView.php';
    }
}
