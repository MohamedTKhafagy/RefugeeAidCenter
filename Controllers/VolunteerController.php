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
        $db = DbConnection::getInstance();

        // Create and save the volunteer
        $volunteer = new Volunteer(
            null,
            $data['Name'],
            $data['Age'],
            $data['Gender'],
            $data['Address'],
            $data['Phone'],
            $data['Nationality'],
            2,
            $data['Email'],
            $data['Preference'],
            $data['Availability']
        );
        $volunteer->save();

        // Handle skills
        if (isset($data['skills']) && isset($data['proficiency_levels'])) {
            foreach ($data['skills'] as $index => $skillName) {
                if (empty($skillName)) continue;

                // Find or create the skill
                $skill = Skill::findByName($skillName);
                if (!$skill) {
                    $skill = new Skill($skillName, $skillName, 'Skill for ' . $skillName);
                    $skill->save();
                }

                // Add the skill to the volunteer with proficiency
                $volunteer->addSkill($skill->getId(), $data['proficiency_levels'][$index]);
            }
        }

        return $volunteer;
    }

    // Show details of a specific volunteer by ID
    public function showVolunteer($id)
    {
        $volunteer = Volunteer::findById($id);
        require 'Views/VolunteerDetailView.php';
    }

    public function editVolunteer($data)
    {
        $db = DbConnection::getInstance();

        // Create and update the volunteer
        $volunteer = new Volunteer(
            $data['Id'],
            $data['Name'],
            $data['Age'],
            $data['Gender'],
            $data['Address'],
            $data['Phone'],
            $data['Nationality'],
            2,
            $data['Email'],
            $data['Preference'],
            $data['Availability']
        );
        Volunteer::editById($data['Id'], $volunteer);

        // Handle skills
        if (isset($data['skills']) && isset($data['proficiency_levels'])) {
            // First remove all existing skills
            $db->query("DELETE FROM Volunteer_Skills WHERE volunteer_id = " . $data['Id']);

            // Then add the new skills
            foreach ($data['skills'] as $index => $skillName) {
                if (empty($skillName)) continue;

                // Find or create the skill
                $skill = Skill::findByName($skillName);
                if (!$skill) {
                    $skill = new Skill($skillName, $skillName, 'Skill for ' . $skillName);
                    $skill->save();
                }

                // Add the skill to the volunteer with proficiency
                $volunteer->addSkill($skill->getId(), $data['proficiency_levels'][$index]);
            }
        }

        $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        header('Location: ' . $base_url . '/volunteers');
    }

    public function edit($id)
    {
        $volunteer = Volunteer::findById($id);
        require 'Views/EditVolunteerView.php';
    }

    public function delete($id)
    {
        Volunteer::deleteById($id);
        $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        header('Location: ' . $base_url . '/volunteers');
    }
    public function findVolunteerById($id)
    {
        $volunteer = Volunteer::findById($id);
        require 'Views/VolunteerDetailView.php';
    }
}
