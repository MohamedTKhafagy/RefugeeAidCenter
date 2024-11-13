<?php

require_once __DIR__ . '/../Models/Stratigies/VolunteerAuthentication.php';
require_once __DIR__ . '/../Models/Stratigies/DonatorAuthentication.php';
require_once __DIR__ . '/../Models/Stratigies/RefugeeAuthentication.php';

class RegisterController
{

    public function index()
    {
        require 'Views/RegisterView.php';
    }

    public function register($data)
    {
        $commonErrors = $this->validateUserData($data);
        $strategy = $this->getRegisterationStrategy($data['type']);
        $specificErrors = $strategy->validate($data);
        $errors = array_merge($commonErrors, $specificErrors);
        if (!empty($errors)) {
            require 'Views/RegisterView.php';
            return;
        }
        $strategy->register($data);
        $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        header('Location: ' . $base_url . '/refugees');
    }

    function validateUserData($data)
    {
        $errors = [];

        if (empty($data['name']) || !preg_match("/^[a-zA-Z\s]+$/", $data['name']) || strlen($data['name']) < 2) {
            $errors['name'] = "Name is required and should only contain letters and spaces (at least 2 characters).";
        }

        if (!isset($data['age']) || !filter_var($data['age'], FILTER_VALIDATE_INT, ["options" => ["min_range" => 1, "max_range" => 120]])) {
            $errors['age'] = "Age is required and must be a valid number between 1 and 120.";
        }

        $allowedGenders = ["Male", "Female"];
        if (empty($data['gender']) || !in_array($data['gender'], $allowedGenders)) {
            $errors['gender'] = "Gender is required and must be 'Male' or 'Female'.";
        }

        if (empty($data['address']) || strlen($data['address']) < 5) {
            $errors['address'] = "Address is required and should be at least 5 characters long.";
        }

        if (empty($data['phone']) || !preg_match("/^\d{10}$/", $data['phone'])) {
            $errors['phone'] = "Phone is required and should be a valid 10-digit number.";
        }

        if (empty($data['nationality']) || !preg_match("/^[a-zA-Z\s]+$/", $data['nationality'])) {
            $errors['nationality'] = "Nationality is required and should only contain letters and spaces.";
        }

        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Email is required and should be a valid email address.";
        }

        return $errors;
    }

    private function getRegisterationStrategy($type)
    {
        switch ($type) {
            case 'volunteer':
                return new VolunteerAuthentication();
            case 'donator':
                return new DonatorAuthentication();
            case 'refugee':
                return new RefugeeAuthentication();
            default:
                throw new Exception("Invalid user type.");
        }
    }
}
