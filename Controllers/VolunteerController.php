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
        try {
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
            if (isset($data['skills'])) {
                foreach ($data['skills'] as $skillName) {
                    if (empty($skillName)) continue;

                    // Find or create the skill
                    $skill = Skill::findByName($skillName);
                    if (!$skill) {
                        // Get the category ID first
                        $categoryId = Skill::getCategoryIdByName($skillName);
                        if (!$categoryId) {
                            // If category doesn't exist, use 'Other' category
                            $categoryId = Skill::getCategoryIdByName('Other');
                        }

                        $skill = new Skill($skillName, $categoryId, 'Skill for ' . $skillName);
                        $skill->save();
                    }

                    // Add the skill to the volunteer
                    $volunteer->addSkill($skill->getId());
                }
            }

            $_SESSION['success'] = "Volunteer added successfully";
            return $volunteer;
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/volunteers/add');
            exit;
        }
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
        if (isset($data['skills'])) {
            // First remove all existing skills
            $db->query("DELETE FROM Volunteer_Skills WHERE volunteer_id = " . $data['Id']);

            // Then add the new skills
            foreach ($data['skills'] as $skillName) {
                if (empty($skillName)) continue;

                // Find or create the skill
                $skill = Skill::findByName($skillName);
                if (!$skill) {
                    // Get the category ID first
                    $categoryId = Skill::getCategoryIdByName($skillName);
                    if (!$categoryId) {
                        // If category doesn't exist, use 'Other' category
                        $categoryId = Skill::getCategoryIdByName('Other');
                    }

                    $skill = new Skill($skillName, $categoryId, 'Skill for ' . $skillName);
                    $skill->save();
                }

                // Add the skill to the volunteer
                $volunteer->addSkill($skill->getId());
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
        $db = DbConnection::getInstance();

        // Check if volunteer has any assigned tasks
        $sql = "SELECT COUNT(*) as count FROM Tasks WHERE volunteer_id = ? AND is_deleted = 0";
        $result = $db->fetchAll($sql, [$id]);

        if ($result[0]['count'] > 0) {
            $_SESSION['error'] = "Cannot delete volunteer: They have assigned tasks";
        } else {
            Volunteer::deleteById($id);
            $_SESSION['success'] = "Volunteer deleted successfully";
        }

        $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        header('Location: ' . $base_url . '/volunteers');
    }
    public function findVolunteerById($id)
    {
        $volunteer = Volunteer::findById($id);
        require 'Views/VolunteerDetailView.php';
    }
}
