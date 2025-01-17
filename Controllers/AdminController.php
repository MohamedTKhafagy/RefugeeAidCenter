<?php

use function PHPSTORM_META\type;

require_once "Models/UserAdmin.php";
require_once "Proxy/SecureUserDataProxy.php";
require_once "Views/AdminView.php";
class AdminController {
    private $model;
    private $view;
    

    public function __construct($currentUser = null) {
        $currentUser = $currentUser ?? $this->getCurrentUser();
    
       
        if ($currentUser->getType() !== 'admin') { 
            echo "<div style='text-align: center; margin-top: 50px;'>
                    <h1 style='color: red;'>Access Denied</h1>
                    <p>You're not authorized to access this page.</p>
                  </div>";
            exit; 
        }
    
        $proxy = new SecureUserDataProxy($currentUser);
        $this->model = new AdminUser($proxy);
        $this->view = new AdminView();
    }
    
    
    public function index() {
        
        $users = $this->model->listAllUsers();
        $events = $this->model->listAllEvents();
        $tasks = $this->model->listAllTasks();
        $donations = $this->model->listAllDonations();

        
        echo $this->view->renderDashboard($users, $events,  $tasks, $donations);
    }
    public function editUser($userId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $result = $this->model->updateUser($userId, $_POST);
            if ($result) {
                header('Location:/RefugeeAidCenter/admin');
                exit;
            }
        }

        
        $user = $this->model->getUserById($userId);
        echo $this->view->renderEditUser($user);
    }
    public function deleteUser($userId) {
        $result = $this->model->deleteUser($userId);
        if ($result) {
            header('Location:/RefugeeAidCenter/admin'); 
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
        $volunteers = $this->model->getVolunteers(); 
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
        $users = $this->model->listAllUsers(); 
        echo $this->view->renderEditDonation($donation, $users);
    }

    private function getCurrentUser() {
        session_start(); 
    
    
        $userid = $_SESSION['user']['id'] ?? null; 
        if (!$userid) {
            throw new Exception("No user ID found in session.");
        }
    
        $db = DbConnection::getInstance();
        $sql = "SELECT * FROM User WHERE Id = $userid;";
        
        $result = $db->fetchAll($sql);
        if (empty($result)) {
            throw new Exception("User not found in the database.");
        }

        $userData = $result[0];
    
        $currentType = ($userData['Type'] == '8') ? 'admin' : 'user';
    
        return new User(
            $userData['Id'] ?? null,         
            $userData['Name'] ?? null,       
            $userData['Age'] ?? null,        
            $userData['Gender'] ?? null,     
            $userData['Address'] ?? null,    
            $userData['Phone'] ?? null,      
            $userData['Nationality'] ?? null, 
            $currentType,                    
            $userData['Email'] ?? null,      
            null,                            
            $userData['Preference'] ?? null  
        );
    }
    
}