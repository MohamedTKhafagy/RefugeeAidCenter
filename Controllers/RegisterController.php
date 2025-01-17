<?php

require_once __DIR__ . "/../Models/UserModel.php";
require_once __DIR__ . "/RegisterService.php";
require_once __DIR__ . "/../Models/Stratigies/RegistrationFactory.php";

class RegisterController
{

    public function index()
    {
        session_start();
        // if (isset($_SESSION['user'])) {
        //     $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        //     header('Location: ' . $base_url . '/dashboard/' . $_SESSION['user']['type']);
        //     return;
        // }
        require 'Views/RegisterView.php';
    }

    public function register($data, $admin = false) {
        try {
            $strategy = RegistrationFactory::createStrategy($data['type'], $data);
            $register = $strategy->registerUser();
            if (!empty($register['errors'])) {
                $errors = $register['errors'];
                require(!$admin ? 'Views/RegisterView.php' : 'Views/AddRefugeeView.php');
                return;
            }
            $id = $register['id'];
            // session_start();
            // $_SESSION['user'] = [
            //     'id' => $id,
            //     'type' => $data['type']
            // ];

            $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
            header('Location: ' . $base_url . '/dashboard/' . $data['type']);
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }
}
