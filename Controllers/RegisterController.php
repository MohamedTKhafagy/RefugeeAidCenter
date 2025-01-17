<?php

require_once __DIR__ . '/../Models/Stratigies/VolunteerAuthentication.php';
require_once __DIR__ . '/../Models/Stratigies/DonatorAuthentication.php';
require_once __DIR__ . '/../Models/Stratigies/RefugeeAuthentication.php';
require_once __DIR__ . '/../Models/Stratigies/ChildAuthentication.php';
require_once __DIR__ . "/../Models/UserModel.php";
require_once __DIR__ . "/RegisterService.php";
require_once __DIR__ . "/../Models/Stratigies/RegisterationFactory.php";

class RegisterController
{

    public function index()
    {
        session_start();
        if (isset($_SESSION['user'])) {
            $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
            header('Location: ' . $base_url . '/dashboard/' . $_SESSION['user']['type']);
            return;
        }
        require 'Views/RegisterView.php';
    }

    public function register($data, $admin = false)
    {
        $registerService = new RegisterService();
        $commonErrors = $registerService->validateUserData($data);
        $strategy = RegisterationFactory::createStrategy($data['type']);
        $specificErrors = $strategy->validate($data);
        $errors = array_merge($commonErrors, $specificErrors);
        if (!empty($errors)) {
            require (!$admin ? 'Views/RegisterView.php' : 'Views/AddRefugeeView.php');
            return;
        }
        $id = $strategy->register($data);
        session_start();
        $_SESSION['user'] = [
            'id' => $id,
            'type' => $data['type']
        ];
        $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        header('Location: ' . $base_url . '/dashboard/' . $data['type']);
    }

}

?>