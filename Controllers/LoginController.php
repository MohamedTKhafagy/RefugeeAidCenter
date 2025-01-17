<?php

require_once __DIR__ . '/../Models/UserModel.php';

class LoginController
{

    public function index()
    {
        // session_start();
        // if (isset($_SESSION['user'])) {
        //     $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        //     header('Location: ' . $base_url . '/dashboard/' . $_SESSION['user']['type']);
        //     return;
        // }
        require 'Views/LoginView.php';
    }

    public function login($data)
    {
        $commonErrors = $this->validateUserData($data);
        if (!empty($commonErrors)) {
            require 'Views/LoginView.php';
            return;
        }
        $user = User::login($data);
        if (!$user['exist']) {
            $commonErrors['email'] = "Email or password is incorrect";
            require 'Views/LoginView.php';
            return;
        }

        session_start();
        $_SESSION['user'] = [
            'id' => $user['Id'],
            'type' => $data['type']
        ];

        $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        header('Location: ' . $base_url . '/dashboard/' . $data['type']);
    }

    function validateUserData($data)
    {
        $errors = [];

        if (empty($data['password'])) {
            $errors['password'] = "Password is required";
        }

        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Email is required and should be a valid email address.";
        }

        return $errors;
    }
}
