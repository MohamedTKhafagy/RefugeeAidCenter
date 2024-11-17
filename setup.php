// 1. Database/File Structure Setup
// Create a script called setup.php in your project root

<?php
// setup.php
class HospitalSetup {
    public static function initializeSystem() {
        $dataDir = __DIR__ . '/data';
        $hospitalFile = $dataDir . '/hospitals.txt';

        // Create data directory if it doesn't exist
        if (!file_exists($dataDir)) {
            mkdir($dataDir, 0755, true);
            echo "Created data directory\n";
        }

        // Create hospitals.txt with initial structure
        if (!file_exists($hospitalFile)) {
            $initialData = [
                [
                    'HospitalID' => 'HOSP_' . uniqid(),
                    'Name' => 'Sample Hospital',
                    'Address' => '123 Main St',
                    'Supervisor' => 'John Doe',
                    'MaxCapacity' => 100,
                    'CurrentCapacity' => 0,
                    'InsuranceType' => 'Basic'
                ]
            ];
            
            file_put_contents($hospitalFile, json_encode($initialData, JSON_PRETTY_PRINT));
            echo "Created hospitals.txt with sample data\n";
        }

        // Set proper file permissions
        chmod($dataDir, 0755);
        chmod($hospitalFile, 0644);
        echo "Set file permissions\n";
    }
}

// Run the setup
HospitalSetup::initializeSystem();


