<?php
require_once __DIR__ . '/../Models/VolunteerModel.php';

class VolunteerController
{

    // Display a list of all volunteers
    public function index()
    {
        $volunteers = Volunteer::all(); // Retrieve all volunteers
        require 'Views/VolunteerListView.php'; // Load view to display volunteers
    }

    // Display form to add a new volunteer or handle form submission
    public function add($data = null)
    {
        if ($data) {
            $this->saveVolunteer($data);
            $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
            header('Location: ' . $base_url . '/volunteers'); // Redirect to list after adding
        } else {
            require 'Views/AddVolunteerView.php';
        }
    }

    // Save volunteer data
    public function saveVolunteer($data)
    {
        $volunteer = new Volunteer(
            $data['Id'],
            $data['Name'],
            $data['Age'],
            $data['Gender'],
            $data['Address'],
            $data['Phone'],
            $data['Nationality'],
            $data['Type'],
            $data['Email'],
            $data['Preference'],
            $data['VolunteerID'],
            $data['Skills'],
            $data['Availability']
        );
        $volunteer->save();
    }

    // Show details of a specific volunteer by ID
    public function showVolunteer($id)
    {
        $volunteer = Volunteer::findById($id);
        require 'Views/VolunteerDetailView.php'; // Load view to display volunteer details
    }
}
