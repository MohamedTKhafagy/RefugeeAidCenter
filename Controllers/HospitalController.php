<?php
require_once __DIR__ . '/../Models/HospitalModel.php';


class HospitalController
{
    public function index()
    {
        $hospitals = Hospital::all();
        require 'Views/HospitalView.php';
    }

    public function add($data = null)
    {
        if ($data) {
            //validation
            $this->saveHospital($data);
            $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
            header('Location: ' . $base_url . '/hospitals');
        } else {
            require 'Views/AddHospitalView.php';
        }
    }

    public function saveHospital($data)
    {
        $hospital = new Hospital(
            $data['Name'],
            $data['Address'],
            $data['Supervisor'],
            $data['MaxCapacity'],
            CurrentCapacity: 0
        );
        $hospital->save();
    }

    
}