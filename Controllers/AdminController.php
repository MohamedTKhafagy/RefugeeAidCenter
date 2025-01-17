<?php 
require_once "Models/UserAdmin.php";
require_once "Proxy/SecureUserDataProxy.php";
require_once "Views/AdminView.php";
class AdminController {
    private $model;
    private $view;
    

    public function __construct($currentUser = null) {
        // If no user is provided, get the current user from the session
        if ($currentUser === null) {
            $currentUser = $this->getCurrentUser();
        }
        
        
        // Create proxy and model
        $proxy = new SecureUserDataProxy($currentUser);
        $this->model = new AdminUser($proxy);
        $this->view = new AdminView();
    }

    public function index() {
        // Get all data needed for dashboard
        $users = $this->model->listAllUsers();
        $events = $this->model->listAllEvents();
        $tasks = $this->model->listAllTasks();
        $donations = $this->model->listAllDonations();

        // Render dashboard
        echo $this->view->renderDashboard($users, $events,  $tasks, $donations);
    }
    public function editUser($userId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Handle form submission
            $result = $this->model->updateUser($userId, $_POST);
            if ($result) {
                header('Location:/RefugeeAidCenter/admin');
                exit;
            }
        }

        // Get user data for edit form
        $user = $this->model->getUserById($userId);
        echo $this->view->renderEditUser($user);
    }
    public function deleteUser($userId) {
        $result = $this->model->deleteUser($userId);
        if ($result) {
            header('Location:/RefugeeAidCenter/admin'); //here change
            exit;
        } else {
            echo "Failed to delete user.";
        }
    }

    public function editEvent($eventId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $this->model->updateEvent($eventId, $_POST);
            if ($result) {
                header('Location:/RefugeeAidCenter/admin');
                exit;
            }
        }

        $event = $this->model->getEventById($eventId);
        echo $this->view->renderEditEvent($event);
    }

    public function editTask($taskId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $this->model->updateTask($taskId, $_POST);
            if ($result) {
                header('Location:/RefugeeAidCenter/admin');
                exit;
            }
        }

        $task = $this->model->getTaskById($taskId);
        $volunteers = $this->model->getVolunteers(); // Get list of volunteers for assignment
        echo $this->view->renderEditTask($task, $volunteers);
    }

    public function editDonation($donationId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $this->model->updateDonation($donationId, $_POST);
            if ($result) {
                header('Location:/RefugeeAidCenter/admin');
                exit;
            }
        }

        $donation = $this->model->getDonationById($donationId);
        $users = $this->model->listAllUsers(); // For DirectedTo field
        echo $this->view->renderEditDonation($donation, $users);
    }

    private function getCurrentUser() {
        // Fetch user with ID = 1 from the database
        $db = DbConnection::getInstance(); // Assuming you have a DbConnection class
        $sql = "SELECT * FROM User "; // Fetch user with ID = 1
        $result = $db->fetchAll($sql);
    
        if (!empty($result)) {
            $userData = $result[0]; // Get the first row
    
    
            // Ensure the keys match the database columns
            return new DummyUser(
                $userData['id'] ?? null,
                $userData['name'] ?? null,
                $userData['age'] ?? null,
                $userData['gender'] ?? null,
                $userData['address'] ?? null,
                $userData['phone'] ?? null,
                $userData['nationality'] ?? null,
                $userData['type'] ?? null,
                $userData['email'] ?? null,
                $userData['preference'] ?? null
            );
        }
    
        // If no user is found, throw an exception or handle the error
        throw new Exception("User with ID = 1 not found in the database.");
    }

    
}