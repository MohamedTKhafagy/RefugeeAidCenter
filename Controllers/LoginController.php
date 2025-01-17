<?php

require_once __DIR__ . '/../Models/UserModel.php';

class LoginController
{

    public function index()
    {
        require 'Views/LoginView.php';
    }

    public function login($data)
    {
        $commonErrors = $this->validateUserData($data);
        if (!empty($commonErrors)) {
            require 'Views/LoginView.php';
            return;
        }
        $exist = User::login($data);
        if (!$exist) {
            $commonErrors['email'] = "Email or password is incorrect";
            require 'Views/LoginView.php';
            return;
        }
        $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        header('Location: ' . $base_url . '/refugees');
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
