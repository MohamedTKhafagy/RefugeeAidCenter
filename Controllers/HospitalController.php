<?php
require_once __DIR__ . '/../Models/HospitalModel.php';

class HospitalController {
    public function index() {
        $hospitals = Hospital::all(); // Fetch all hospitals
        include __DIR__ . '/../Views/HospitalView.php'; // Load the view
    }

    public function add($data = null) {
        if ($data && !empty($data)) {
            try {
                // Set a default current capacity if not provided
                $currentCapacity = isset($data['CurrentCapacity']) ? $data['CurrentCapacity'] : 0;
                
                $hospital = new Hospital(
                    $data['Name'],
                    $data['Address'],
                    $data['Supervisor'],
                    $data['MaxCapacity'],
                    $currentCapacity,
                    $data['insuranceType']
                );
                
                $result = $hospital->save();
                
                if ($result) {
                    // Use the base URL for redirection
                    $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
                    header("Location: " . $base_url . "/hospitals");
                    exit();
                } else {
                    throw new Exception("Failed to save hospital data");
                }
            } catch (Exception $e) {
                echo "Error adding hospital: " . $e->getMessage();
            }
        } else {
            include __DIR__ . '/../Views/AddHospitalView.php';
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
        try {
            if (!$id) {
                throw new Exception("No ID provided.");
            }

            $hospital = Hospital::getById($id);
            if (!$hospital) {
                throw new Exception("Hospital not found with ID: " . $id);
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && $data) {
                $hospital->setName($data['Name']);
                $hospital->setAddress($data['Address']);
                $hospital->setSupervisor($data['Supervisor']);
                $hospital->setMaxCapacity($data['MaxCapacity']);
                
                // Handle strategy change if insurance type is changed
                if (isset($data['insuranceType'])) {
                    $strategy = strtolower($data['insuranceType']) === 'basic' ? 
                               new BasicInsurance() : 
                               new ComprehensiveInsurance();
                    $hospital->setHealthcareStrategy($strategy);
                }

                if ($hospital->save()) {
                    header("Location: /hospitals");
                    exit();
                }
            }
            
            include __DIR__ . '/../Views/EditHospitalView.php';
        } catch (Exception $e) {
            error_log("Error in update method: " . $e->getMessage());
            echo "Error: " . $e->getMessage();
        }
    }
    
    private function saveToFile($hospitals) {
        $filePath = __DIR__ . '/../data/hospitals.txt';
        
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
    
    
   /* public function delete($id) {
        if (!$id) {
            header("Location: /hospitals");
            return;
        }

        $data = [];
        if (file_exists(Hospital::$file)) {
            $data = json_decode(file_get_contents(Hospital::$file), true) ?: [];
            $data = array_filter($data, function($hospital) use ($id) {
                return $hospital['HospitalID'] !== $id;
            });
            file_put_contents(Hospital::$file, json_encode(array_values($data), JSON_PRETTY_PRINT));
        }

        header("Location: /hospitals");
        exit();
    }*/
    
}
