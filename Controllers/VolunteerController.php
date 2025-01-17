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
        // if (
        //     !isset($_SESSION['user']) ||
        //     !isset($_SESSION['user']['type']) ||
        //     $_SESSION['user']['type'] !== 'admin'
        // ) {
        //     $_SESSION['error'] = "Access denied. Admin privileges required.";
        //     header('Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/login');
        //     exit;
        // }
        return 0;
    }

    public function index()
    {
        $this->checkAdminAccess();
        $volunteers = Volunteer::all();
        echo renderVolunteerListView($volunteers);
    }

    // public function add($data = null)
    // {
    //     $this->checkAdminAccess();
    //     if ($data) {
    //         $this->saveVolunteer($data);
    //         $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
    //         header('Location: ' . $base_url . '/volunteers');
    //     } else {
    //         echo renderAddVolunteerView();
    //     }
    // }


    public function showVolunteer($id)
    {
        $this->checkAdminAccess();
        $volunteer = Volunteer::findById($id);
        require 'Views/VolunteerDetailView.php';
    }

    public function update($data)
    {
        $this->checkAdminAccess();
        $registerService = new RegisterService();
        $commonErrors = $registerService->validateUserData($data, true);
        $strategy = RegistrationFactory::createStrategy('volunteer', $data);
        $specificErrors = $strategy->validate();
        $errors = array_merge($commonErrors, $specificErrors);
        if (!empty($errors)) {
            $volunteer = Volunteer::findById($data['Id']);
            require 'Views/EditVolunteerView.php';
            return;
        }
        $volunteer = Volunteer::findById($data['Id']);
        $data['Availability'] = $strategy->convertAvailability($data['Availability']);
        $volunteer->update($data);
        $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        header('Location: ' . $base_url . '/volunteers');
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
