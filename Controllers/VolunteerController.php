<?php
require_once __DIR__ . '/../Models/VolunteerModel.php';
require_once __DIR__ . '/../Views/VolunteerListView.php';
require_once __DIR__ . '/../Views/AddVolunteerView.php';

class VolunteerController
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    private function checkAdminAccess()
    {
        if (
            !isset($_SESSION['user']) ||
            !isset($_SESSION['user']['type']) ||
            $_SESSION['user']['type'] !== 'admin'
        ) {
            $_SESSION['error'] = "Access denied. Admin privileges required.";
            header('Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/login');
            exit;
        }
    }

    // Display a list of all volunteers
    public function index()
    {
        $this->checkAdminAccess();
        $volunteers = Volunteer::all();
        echo renderVolunteerListView($volunteers);
    }

    // Display form to add a new volunteer or handle form submission
    public function add($data = null)
    {
        $this->checkAdminAccess();
        if ($data) {
            $this->saveVolunteer($data);
            $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
            header('Location: ' . $base_url . '/volunteers');
        } else {
            echo renderAddVolunteerView();
        }
    }

    // Save volunteer data
    public function saveVolunteer($data)
    {
        $this->checkAdminAccess();
        try {
            // Convert availability array to bit field
            $availabilityBits = 0;
            if (isset($data['Availability']) && is_array($data['Availability'])) {
                $dayMap = [
                    'Sunday' => 0,
                    'Monday' => 1,
                    'Tuesday' => 2,
                    'Wednesday' => 3,
                    'Thursday' => 4,
                    'Friday' => 5,
                    'Saturday' => 6
                ];
                foreach ($data['Availability'] as $day) {
                    if (isset($dayMap[$day])) {
                        $availabilityBits |= (1 << $dayMap[$day]);
                    }
                }
            }

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
                $availabilityBits
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
            $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
            header('Location: ' . $base_url . '/volunteers/add');
            exit;
        }
    }

    // Show details of a specific volunteer by ID
    public function showVolunteer($id)
    {
        $this->checkAdminAccess();
        $volunteer = Volunteer::findById($id);
        require 'Views/VolunteerDetailView.php';
    }

    public function editVolunteer($data)
    {
        $this->checkAdminAccess();
        try {
            $db = DbConnection::getInstance();

            // Convert availability array to bit field
            $availabilityBits = 0;
            if (isset($data['Availability']) && is_array($data['Availability'])) {
                $dayMap = [
                    'Sunday' => 0,
                    'Monday' => 1,
                    'Tuesday' => 2,
                    'Wednesday' => 3,
                    'Thursday' => 4,
                    'Friday' => 5,
                    'Saturday' => 6
                ];
                foreach ($data['Availability'] as $day) {
                    if (isset($dayMap[$day])) {
                        $availabilityBits |= (1 << $dayMap[$day]);
                    }
                }
            }

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
                $availabilityBits
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

            $_SESSION['success'] = "Volunteer updated successfully";
            $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
            header('Location: ' . $base_url . '/volunteers');
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
            header('Location: ' . $base_url . '/volunteers/edit/' . $data['Id']);
            exit;
        }
    }

    public function edit($id)
    {
        $this->checkAdminAccess();
        $volunteer = Volunteer::findById($id);
        require 'Views/EditVolunteerView.php';
    }

    public function delete($id)
    {
        $this->checkAdminAccess();
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
        $this->checkAdminAccess();
        $volunteer = Volunteer::findById($id);
        require 'Views/VolunteerDetailView.php';
    }
}
