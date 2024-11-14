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
                    $data['CurrentCapacity'],
                    $data['insuranceType']
                );
                $hospital->save();
                header("Location: /hospitals");
            } catch (Exception $e) {
                echo "Error adding hospital: " . $e->getMessage();
            }
        } else {
            include __DIR__ . '/../Views/AddHospitalView.php'; // Load a form view
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
    public function update($id, $data = null) {
        $hospitals = Hospital::all();
        foreach ($hospitals as $hospital) {
            if ($hospital->getID() == $id) {
                if ($data) {
                    // Update hospital details
                    $hospital->setName($data['Name']);
                    $hospital->setAddress($data['Address']);
                    $hospital->setSupervisor($data['Supervisor']);
                    $hospital->setMaxCapacity($data['MaxCapacity']);
                    $hospital->setCurrentCapacity($data['CurrentCapacity']);
                    $hospital->setInsuranceType($data['insuranceType']);
                    $this->saveToFile($hospitals);
                    header("Location: /hospitals");
                    return;
                }
                include __DIR__ . '/../Views/UpdateHospitalForm.php'; // Load the form view
                return;
            }
        }
        echo "Hospital not found.";
    }
    
    private function saveToFile($hospitals) {
        $filePath = __DIR__ . '/../Data/hospitals.txt';
        
        $file = fopen($filePath, 'w');
        if (!$file) {
            throw new Exception("Unable to open file for writing: " . $filePath);
        }
    
        foreach ($hospitals as $hospital) {
            $line = implode('|', [
                $hospital->getID(),
                $hospital->getName(),
                $hospital->getAddress(),
                $hospital->getSupervisor(),
                $hospital->getMaxCapacity(),
                $hospital->getCurrentCapacity(),
                $hospital->getInsuranceType()
            ]);
    
            if (fwrite($file, $line . PHP_EOL) === false) {
                throw new Exception("Failed to write to file.");
            }
        }
    
        fclose($file);
    }
    
    
    public function delete($id) {
        $hospitals = Hospital::all();
        $hospitals = array_filter($hospitals, fn($hospital) => $hospital->getID() != $id);
        $this->saveToFile($hospitals);
        header("Location: /hospitals");
    }
    
}
