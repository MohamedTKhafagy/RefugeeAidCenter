<?php
require_once __DIR__ . '/../Models/HospitalModel.php';

class HospitalController {
    public function index() {
        $hospitals = Hospital::all(); // Fetch all hospitals
        include __DIR__ . '/../Views/HospitalView.php'; // Load the view
    }

    public function add($data = null) {
        if ($data) {
            try {
                $hospital = new Hospital(
                    $data['Name'],
                    $data['Address'],
                    $data['Supervisor'],
                    $data['MaxCapacity'],
                    $data['CurrentCapacity']
                );
                $hospital->save();
                header("Location: /hospitals");
            } catch (Exception $e) {
                echo "Error adding hospital: " . $e->getMessage();
            }
        } else {
            include __DIR__ . '/../Views/AddHospitalForm.php'; // Load a form view
        }
    }

    public function assignStrategy($hospitalId, $strategyType) {
        $hospitals = Hospital::all();
        foreach ($hospitals as $hospital) {
            if ($hospital->getID() === $hospitalId) {
                $strategy = ($strategyType === 'basic') ? new BasicInsurance() : new ComprehensiveInsurance();
                $hospital->setHealthcareStrategy($strategy);
                $hospital->assignWithStrategy();
                header("Location: /hospitals");
                return;
            }
        }
        echo "Hospital not found.";
    }
}
