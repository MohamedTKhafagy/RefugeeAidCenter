<?php
require_once __DIR__ . '/../Models/DoctorModel.php';


class DoctorController
{

    public function index()
    {
        $doctors = Doctor::all();
        require 'Views/DoctorsView.php';
    }

    public function add($data = null)
    {
        
        if ($data) {
            //validation
            $this->saveDoctor($data);
            $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
            header('Location: ' . $base_url . '/doctors');
        } else {
            require 'Views/AddDoctorView.php';
        }
    }

    public function saveDoctor($data)
    {
        $doctor = new Doctor(
            null,
            $data['Name'],
            $data['Age'],
            $data['Gender'],
            $data['Address'],
            $data['Phone'],
            $data['Nationality'],
            4,
            $data['Email'],
            $data['Preference'],
            $data["Specialization"],
            $data["Availability"],
            $data["Hospital"]
        );
        $doctor->save();
    }

    public function editDoctor($data){
        $doctor = new Doctor(
            $data['Id'],
            $data['Name'],
            $data['Age'],
            $data['Gender'],
            $data['Address'],
            $data['Phone'],
            $data['Nationality'],
            4,
            $data['Email'],
            $data['Preference'],
            $data["Specialization"],
            $data["Availability"],
            $data["Hospital"]
        );
        Doctor::editById($data['Id'], $doctor);
        $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        header('Location: ' . $base_url . '/doctors');
    }

    public function edit($id){
            $doctor = Doctor::findById($id);
            require 'Views/EditDoctorView.php';
    }
    public function delete($id){
        Doctor::deleteById($id);
        $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        header('Location: ' . $base_url . '/doctors');
    }

    public function findDoctorById($id)
    {
        $doctor = Doctor::findById($id);
        require 'Views/DoctorView.php';
    }
}
