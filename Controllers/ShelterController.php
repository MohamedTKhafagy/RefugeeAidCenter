<?php
require_once __DIR__ . '/../Models/ShelterModel.php';

class ShelterController
{
    // Display all shelters
    public function showAllShelters()
    {
        $shelters = Shelter::getAll();
        include __DIR__ . '/../Views/ShelterListView.php';
    }

    // Display a specific shelter's details
    public function showShelter($data)
    {

        $shelter = Shelter::findById($data["ShelterID"]);
        if ($shelter) {
            include __DIR__ . '/../Views/ShelterDetailView.php';
        } else {
            echo "Shelter not found.";
        }
    }

    // Add or update a shelter's capacity
    public function updateCapacity($ShelterID, $newCapacity)
    {
        $shelter = Shelter::findById($ShelterID);
        if ($shelter) {
            if ($shelter->setCurrentCapacity($newCapacity)) {
                echo "Shelter capacity updated.";
            } else {
                echo "Error: Capacity exceeds max limit.";
            }
        } else {
            echo "Shelter not found.";
        }
    }
}
