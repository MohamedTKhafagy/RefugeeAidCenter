<?php
require_once __DIR__ . '/../Models/ShelterModel.php';

class ShelterController
{
    // Display a list of all shelters
    public function index()
    {

        $shelters = Shelter::all(); // Retrieve all shelters
        $volunteers = Volunteer::all();
        require 'Views/ShelterListView.php'; // Load view to display shelters
    }

    // Display form to add a new shelter or handle form submission
    public function add($data = null)
    {
        if ($data) {
            $this->saveShelter($data);
            $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
            header('Location: ' . $base_url . '/shelters'); // Redirect to list after adding
        } else {
            //test 
            $volunteers = Volunteer::all();
            require 'Views/AddShelterView.php';
        }
    }

    // Save shelter data
    public function saveShelter($data)
    {
        $shelter = new Shelter(
            null,
            $data["Name"],
            $data["Address"],
            $data["Supervisor"],
            $data["MaxCapacity"],
            $data["CurrentCapacity"]
        );
        $shelter->save();
    }

    // Show details of a specific shelter by ID
    public function showShelter($id)
    {
        $shelter = Shelter::findById($id);
        require 'Views/ShelterDetailView.php'; // Load view to display shelter details
    }

    // Display form to edit a shelter or handle form submission
    public function edit($id)
    {
        $shelter = Shelter::findById($id);
        $volunteers = Volunteer::all();
        require 'Views/EditShelterView.php';
    }

    // Update shelter data
    public function editShelter($data)
    {
        $shelter = new Shelter(
            $data["Id"],
            $data["Name"],
            $data["Address"],
            $data["Supervisor"],
            $data["MaxCapacity"],
            $data["CurrentCapacity"]
        );
        var_dump($data);
        Shelter::editById($data["Id"], $shelter);
        $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        header('Location: ' . $base_url . '/shelters');
    }

    // Delete a shelter
    public function delete($id)
    {
        Shelter::deleteById($id);
        $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        header('Location: ' . $base_url . '/shelters');
    }

    // Find a shelter by ID
    public function findShelterById($id)
    {
        $shelter = Shelter::findById($id);
        require 'Views/ShelterDetailView.php';
    }
}
