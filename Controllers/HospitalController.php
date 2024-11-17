<?php
require_once __DIR__ . '/../Models/HospitalModel.php';

class HospitalController {

    public function index() {
        $hospitals = Hospital::all(); // Fetch all hospitals
        require  'Views/HospitalView.php'; // Load the view
    }
    public function add($data = null){
        if($data ){ 
            if (is_array($data)) {
                $this->saveHospital($data);
            } else {
                throw new Exception("Invalid data submitted.");
            }            $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
            header('Location: ' . $base_url . '/hospitals');
        } else 
        {
            require 'Views/AddHospitalView.php';
        }
        
    }
    public function saveHospital($data) {
        $requiredFields = ['Name', 'Address', 'Supervisor', 'MaxCapacity', 'insuranceType'];
        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) {
                throw new Exception("Missing required field: $field");
            }
        }
    
        $hospital = new Hospital(
            Null,
            $data['Name'],
            $data['Address'],
            1,
            $data['Supervisor'],
            $data['MaxCapacity'],
            0
            //$data['currentCapacity']
        );
        $hospital->setInsuranceType($data['insuranceType']);
        $hospital->save();
    }
    

    public function editHospital($data) {
        $hospital = new Hospital(
            $data['Id'],
            $data['Name'],
            $data['Address'],
            1,
            $data['Supervisor'],
            $data['MaxCapacity']

        );
        $hospital->setInsuranceType($data['insuranceType']);
        Hospital::updateById($data['Id'], $hospital);
        $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        header('Location: ' . $base_url . '/hospitals');

    }

    public function edit($id){
        $hospital = Hospital::findById($id);
        require 'Views/EditHospitalView.php';
    }
    public function delete($id){
        Hospital::deleteById($id);
        $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        header('Location: ' . $base_url . '/hospitals');
    }

    public function findhospitalById($id)
    {
        $hospital = Hospital::findById($id);
        require 'Views/HospitalView.php';
    }

}