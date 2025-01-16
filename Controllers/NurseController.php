<?php
require_once __DIR__ . '/../Models/NurseModel.php';


class NurseController
{

    public function index()
    {
        $nurses = Nurse::all();
        require 'Views/NursesView.php';
    }

    public function add($data = null)
    {
        
        if ($data) {
            //validation
            $this->saveNurse($data);
            $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
            header('Location: ' . $base_url . '/nurses');
        } else {
            require 'Views/AddNurseView.php';
        }
    }

    public function saveNurse($data)
    {
        $Nurse = new Nurse(
            null,
            $data['Name'],
            $data['Age'],
            $data['Gender'],
            $data['Address'],
            $data['Phone'],
            $data['Nationality'],
            5,
            $data['Email'],
            $data['Preference'],
            $data["Specialization"],
            $data["Availability"],
            $data["Hospital"]
        );
        $Nurse->save();
    }

    public function editNurse($data){
        $Nurse = new Nurse(
            $data['Id'],
            $data['Name'],
            $data['Age'],
            $data['Gender'],
            $data['Address'],
            $data['Phone'],
            $data['Nationality'],
            5,
            $data['Email'],
            $data['Preference'],
            $data["Specialization"],
            $data["Availability"],
            $data["Hospital"]
        );
        Nurse::editById($data['Id'], $Nurse);
        $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        header('Location: ' . $base_url . '/nurses');
    }

    public function edit($id){
            $nurse = Nurse::findById($id);
            require 'Views/EditNurseView.php';
    }
    public function delete($id){
        Nurse::deleteById($id);
        $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        header('Location: ' . $base_url . '/nurses');
    }

    public function findNurseById($id)
    {
        $nurse = Nurse::findById($id);
        require 'Views/NurseView.php';
    }
}
